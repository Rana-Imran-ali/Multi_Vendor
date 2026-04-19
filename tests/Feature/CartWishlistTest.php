<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;

class CartWishlistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $this->vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'store_name' => 'Demo Vendor',
            'slug' => 'demo-vendor',
            'status' => 'approved'
        ]);

        $this->category = Category::create(['name' => 'General', 'slug' => 'general']);

        $this->product = clone $this->createProduct();
    }

    private function createProduct()
    {
        return Product::create([
            'vendor_id' => $this->vendor->id,
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product-' . uniqid(),
            'description' => 'Test',
            'price' => 50.00,
            'stock' => 10,
            'status' => 'active'
        ]);
    }

    public function test_customer_can_add_item_to_cart()
    {
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/cart', [
            'product_id' => $this->product->id,
            'quantity' => 2
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.product.id', $this->product->id)
                 ->assertJsonPath('data.quantity', 2);
                 
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $this->product->id,
            'quantity' => 2
        ]);
    }
    
    public function test_customer_can_add_item_to_wishlist()
    {
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/wishlist', [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.product.id', $this->product->id);
                 
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function test_customer_cannot_add_same_item_to_wishlist_twice()
    {
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user, ['*']);

        $this->postJson('/api/wishlist', ['product_id' => $this->product->id]);
        $response = $this->postJson('/api/wishlist', ['product_id' => $this->product->id]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Product is already in your wishlist.']);
                 
        $this->assertDatabaseCount('wishlists', 1);
    }
}
