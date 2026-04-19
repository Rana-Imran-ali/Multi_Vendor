<?php

namespace App\Http\Controllers\API;

use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected \App\Services\Payment\PaymentService $paymentService
    ) {
    }

    /**
     * Customer: list their own orders.
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->getByUser($request->user()->id);

        return $this->successResponse($orders, 'Orders retrieved successfully.');
    }

    /**
     * Customer: place an order from their cart.
     * Splits order items by vendor, reduces stock in a single transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'cart_item_ids'    => 'nullable|array',
            'cart_item_ids.*'  => 'integer|exists:cart_items,id',
            'payment_method'   => 'required|string|in:card,paypal,cod',
        ]);

        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return $this->errorResponse('Your cart is empty.', 400);
        }

        // Filter items if cart_item_ids is provided
        $itemsToCheckout = $cart->items;
        if (!empty($validated['cart_item_ids'])) {
            $itemsToCheckout = $cart->items->filter(function ($item) use ($validated) {
                return in_array($item->id, $validated['cart_item_ids']);
            });

            if ($itemsToCheckout->isEmpty()) {
                return $this->errorResponse('None of the selected items were found in your cart.', 400);
            }
        }

        try {
            DB::beginTransaction();

            $total = 0;

            // Validate stock and compute total
            foreach ($itemsToCheckout as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product \"{$item->product->name}\" has insufficient stock.");
                }
                $total += $item->product->price * $item->quantity;
            }

            // Create the parent order
            $parentOrder = Order::create([
                'user_id'          => $user->id,
                'total_amount'     => $total,
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_address' => $validated['shipping_address'],
            ]);

            // Group items by vendor
            $vendorGroups = $itemsToCheckout->groupBy('product.vendor_id');

            $itemIds = [];

            foreach ($vendorGroups as $vendorId => $vendorItems) {
                $vendorTotal = $vendorItems->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });

                $subOrder = Order::create([
                    'user_id'          => $user->id,
                    'parent_id'        => $parentOrder->id,
                    'vendor_id'        => $vendorId,
                    'total_amount'     => $vendorTotal,
                    'status'           => 'pending',
                    'payment_status'   => 'unpaid',
                    'shipping_address' => $validated['shipping_address'],
                ]);

                foreach ($vendorItems as $item) {
                    OrderItem::create([
                        'order_id'   => $subOrder->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price,
                    ]);

                    $item->product->decrement('stock', $item->quantity);
                    $itemIds[] = $item->id;
                }
            }

            // Clear checked out items only
            $cart->items()->whereIn('id', $itemIds)->delete();

            DB::commit();

            // Fire event instead of direct notification
            Event::dispatch(new OrderPlaced($parentOrder));

            // Handle payment initiation if card is selected
            $paymentUrl = null;
            if ($validated['payment_method'] === 'card') {
                $paymentResult = $this->paymentService->payForOrder($parentOrder);
                if ($paymentResult['success'] && !empty($paymentResult['payment_url'])) {
                    $paymentUrl = $paymentResult['payment_url'];
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully.',
                'data' => $parentOrder->load('subOrders.items.product'),
                'payment_url' => $paymentUrl
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Customer: view a single order (must own it).
     */
    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized.', 403);
        }

        return $this->successResponse(
            $order->load('items.product'),
            'Order retrieved successfully.'
        );
    }

    /**
     * Vendor: list orders containing their products.
     */
    public function vendorOrders(Request $request)
    {
        $user = $request->user();

        if (! $user->vendor) {
            return $this->errorResponse('Unauthorized.', 403);
        }

        $orders = $this->orderRepository->getByVendor($user->vendor->id);

        return $this->successResponse($orders, 'Vendor orders retrieved successfully.');
    }

    /**
     * Admin: list all orders across the platform.
     */
    public function indexAll()
    {
        $orders = $this->orderRepository->getAllPaginated(20);

        return $this->successResponse($orders, 'All orders retrieved successfully.');
    }

    /**
     * Admin: update an order's status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $previousStatus = $order->status;

        $this->orderRepository->updateStatus($order->id, $validated['status']);

        $order->refresh();

        // Fire event instead of direct notification
        Event::dispatch(new OrderStatusUpdated($order, $previousStatus));

        return $this->successResponse($order->fresh(), 'Order status updated successfully.');
    }
}
