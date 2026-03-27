<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(Request $request)
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }

    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        return response()->json([
            'status' => 'success',
            'data' => $cart->load('items.product')
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if ($product->stock < $validated['quantity']) {
            return response()->json(['status' => 'error', 'message' => 'Not enough stock'], 400);
        }

        $cart = $this->getCart($request);

        $cartItem = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id']
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $validated['quantity'];
        $cartItem->save();

        return response()->json(['status' => 'success', 'message' => 'Item added to cart', 'data' => $cartItem]);
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $cart = $this->getCart($request);

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['status' => 'error', 'message' => 'Item not in your cart'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json(['status' => 'success', 'message' => 'Cart updated', 'data' => $cartItem]);
    }

    public function remove(Request $request, CartItem $cartItem)
    {
        $cart = $this->getCart($request);

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['status' => 'error', 'message' => 'Item not in your cart'], 403);
        }

        $cartItem->delete();

        return response()->json(['status' => 'success', 'message' => 'Item removed from cart']);
    }

    public function clear(Request $request)
    {
        $cart = $this->getCart($request);
        $cart->items()->delete();

        return response()->json(['status' => 'success', 'message' => 'Cart cleared']);
    }
}
