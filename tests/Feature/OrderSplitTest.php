<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;

class OrderSplitTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_splits_orders_by_vendor()
    {
        // Setup user
        $user = User::factory()->create(['role' => 'customer']);
        
        // Setup Vendors
        $vendorUser1 = User::factory()->create(['role' => 'vendor']);
        $vendor1 = Vendor::create(['user_id' => $vendorUser1->id, 'store_name' => 'Store 1', 'slug' => 's1', 'status' => 'approved']);
        
        $vendorUser2 = User::factory()->create(['role' => 'vendor']);
        $vendor2 = Vendor::create(['user_id' => $vendorUser2->id, 'store_name' => 'Store 2', 'slug' => 's2', 'status' => 'approved']);

        $category = Category::create(['name' => 'Cats', 'slug' => 'cats']);

        // Vendors have products
        $product1 = Product::create(['vendor_id' => $vendor1->id, 'category_id' => $category->id, 'name' => 'P1', 'slug' => 'p1', 'price' => 10, 'stock' => 10]);
        $product2 = Product::create(['vendor_id' => $vendor2->id, 'category_id' => $category->id, 'name' => 'P2', 'slug' => 'p2', 'price' => 20, 'stock' => 10]);

        // Build cart
        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create(['cart_id' => $cart->id, 'product_id' => $product1->id, 'quantity' => 1, 'unit_price' => 10]);
        CartItem::create(['cart_id' => $cart->id, 'product_id' => $product2->id, 'quantity' => 1, 'unit_price' => 20]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/orders', [
            'shipping_address' => '123 Fake St',
            'payment_method' => 'cod' // Bypass dummy payment gateway for simple split test
        ]);

        $response->assertStatus(201);
        
        $responseData = $response->json('data');
        $this->assertEquals(30, $responseData['total_amount']);
        $this->assertCount(2, $responseData['sub_orders']);

        $this->assertDatabaseCount('orders', 3); // 1 Parent, 2 Children
        
        $parentOrder = Order::whereNull('parent_id')->first();
        $this->assertNotNull($parentOrder);
        
        $child1 = Order::where('parent_id', $parentOrder->id)->where('vendor_id', $vendor1->id)->first();
        $this->assertEquals(10, $child1->total_amount);

        $child2 = Order::where('parent_id', $parentOrder->id)->where('vendor_id', $vendor2->id)->first();
        $this->assertEquals(20, $child2->total_amount);
    }
}
