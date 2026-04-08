<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(protected OrderRepositoryInterface $orderRepository)
    {
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
        ]);

        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return $this->errorResponse('Your cart is empty.', 400);
        }

        try {
            DB::beginTransaction();

            $total = 0;

            // Validate stock and compute total
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product \"{$item->product->name}\" has insufficient stock.");
                }
                $total += $item->product->price * $item->quantity;
            }

            // Create the parent order
            $order = Order::create([
                'user_id'          => $user->id,
                'total_amount'     => $total,
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_address' => $validated['shipping_address'],
            ]);

            // Create order items and reduce stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return $this->successResponse(
                $order->load('items.product'),
                'Order placed successfully.',
                201
            );
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

        $this->orderRepository->updateStatus($order->id, $validated['status']);

        return $this->successResponse($order->fresh(), 'Order status updated successfully.');
    }
}
