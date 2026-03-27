<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->with('items.product')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $orders]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string'
        ]);

        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            $total = 0;
            // Verify stock and calculate total
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception('Product ' . $item->product->name . ' is out of stock.');
                }
                $total += $item->product->price * $item->quantity;
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address']
            ]);

            // Create Order Items and Reduce Stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Clear Cart
            $cart->items()->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Order placed successfully', 'data' => $order->load('items')], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['status' => 'success', 'data' => $order->load('items.product')]);
    }

    public function vendorOrders(Request $request)
    {
        $user = $request->user();
        if (!$user->vendor) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $vendorId = $user->vendor->id;

        // Get orders that contain products belonging to the vendor
        $orders = Order::whereHas('items.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->with(['items' => function ($query) use ($vendorId) {
            $query->whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product');
        }, 'user'])->latest()->get();

        return response()->json(['status' => 'success', 'data' => $orders]);
    }
    
    public function indexAll()
    {
        // Admin views all orders
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $orders]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Admin updates order status
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return response()->json(['status' => 'success', 'message' => 'Order status updated', 'data' => $order]);
    }
}
