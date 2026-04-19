<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private User    $customer;
    private Vendor  $vendor;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create(['role' => 'customer']);

        $vendorUser   = User::factory()->create(['role' => 'vendor']);
        $this->vendor = Vendor::create([
            'user_id'    => $vendorUser->id,
            'store_name' => 'Test Store',
            'slug'       => 'test-store',
            'status'     => 'approved',
        ]);

        $category       = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        $this->product  = Product::create([
            'vendor_id'   => $this->vendor->id,
            'category_id' => $category->id,
            'name'        => 'Test Product',
            'slug'        => 'test-product',
            'price'       => 99.99,
            'stock'       => 50,
            'status'      => 'active',
        ]);
    }

    // ── Helper: give customer a purchased order ────────────────────────────────

    private function givePurchase(): void
    {
        $parentOrder = Order::create([
            'user_id'          => $this->customer->id,
            'total_amount'     => 99.99,
            'status'           => 'delivered',
            'payment_status'   => 'paid',
            'shipping_address' => '1 Test St',
        ]);

        $subOrder = Order::create([
            'user_id'          => $this->customer->id,
            'parent_id'        => $parentOrder->id,
            'vendor_id'        => $this->vendor->id,
            'total_amount'     => 99.99,
            'status'           => 'delivered',
            'payment_status'   => 'paid',
            'shipping_address' => '1 Test St',
        ]);

        \App\Models\OrderItem::create([
            'order_id'     => $subOrder->id,
            'product_id'   => $this->product->id,
            'product_name' => $this->product->name,
            'quantity'     => 1,
            'price'        => 99.99,
        ]);
    }

    // ── Tests ─────────────────────────────────────────────────────────────────

    public function test_anyone_can_list_reviews()
    {
        Review::create([
            'user_id'       => $this->customer->id,
            'reviewable_id' => $this->product->id,
            'reviewable_type' => \App\Models\Product::class,
            'rating'        => 5,
            'comment'       => 'Great product!',
            'status'        => 'approved',
        ]);

        $response = $this->getJson("/api/products/{$this->product->id}/reviews");
        $response->assertStatus(200)->assertJsonPath('data.total', 1);
    }

    public function test_rating_summary_returns_average_and_breakdown()
    {
        foreach ([5, 5, 4, 3] as $i => $stars) {
            Review::create([
                'user_id'         => User::factory()->create(['role' => 'customer'])->id,
                'reviewable_id'   => $this->product->id,
                'reviewable_type' => \App\Models\Product::class,
                'rating'          => $stars,
                'status'          => 'approved',
            ]);
        }

        $response = $this->getJson("/api/products/{$this->product->id}/reviews/summary");

        $response->assertStatus(200)
                 ->assertJsonPath('data.total', 4)
                 ->assertJsonPath('data.average', 4.25)
                 ->assertJsonPath('data.breakdown.5.count', 2)
                 ->assertJsonPath('data.breakdown.4.count', 1)
                 ->assertJsonPath('data.breakdown.3.count', 1);
    }

    public function test_customer_cannot_review_without_purchase()
    {
        Sanctum::actingAs($this->customer, ['*']);

        $response = $this->postJson("/api/products/{$this->product->id}/reviews", [
            'rating'  => 5,
            'comment' => 'Great!',
        ]);

        $response->assertStatus(403)
                 ->assertJsonFragment(['message' => 'You can only review products you have purchased.']);
    }

    public function test_customer_can_review_after_purchase()
    {
        $this->givePurchase();
        Sanctum::actingAs($this->customer, ['*']);

        $response = $this->postJson("/api/products/{$this->product->id}/reviews", [
            'title'   => 'Excellent!',
            'rating'  => 5,
            'comment' => 'Really great quality.',
        ]);

        $response->assertStatus(201)->assertJsonPath('data.rating', 5);
        $this->assertDatabaseHas('reviews', ['user_id' => $this->customer->id, 'rating' => 5]);
    }

    public function test_cannot_review_same_product_twice()
    {
        $this->givePurchase();
        Sanctum::actingAs($this->customer, ['*']);

        $this->postJson("/api/products/{$this->product->id}/reviews", ['rating' => 5]);
        $second = $this->postJson("/api/products/{$this->product->id}/reviews", ['rating' => 4]);

        $second->assertStatus(409);
    }

    public function test_owner_can_update_review()
    {
        $review = Review::create([
            'user_id'         => $this->customer->id,
            'reviewable_id'   => $this->product->id,
            'reviewable_type' => \App\Models\Product::class,
            'rating'          => 3,
            'status'          => 'approved',
        ]);

        Sanctum::actingAs($this->customer, ['*']);

        $response = $this->putJson("/api/products/{$this->product->id}/reviews/{$review->id}", [
            'rating'  => 4,
            'comment' => 'Updated opinion.',
        ]);

        $response->assertStatus(200)->assertJsonPath('data.rating', 4);
    }

    public function test_owner_can_delete_review()
    {
        $review = Review::create([
            'user_id'         => $this->customer->id,
            'reviewable_id'   => $this->product->id,
            'reviewable_type' => \App\Models\Product::class,
            'rating'          => 3,
            'status'          => 'approved',
        ]);

        Sanctum::actingAs($this->customer, ['*']);

        $response = $this->deleteJson("/api/products/{$this->product->id}/reviews/{$review->id}");
        $response->assertStatus(200);

        $this->assertSoftDeleted('reviews', ['id' => $review->id]);
    }

    public function test_helpful_vote_increments_count()
    {
        $review = Review::create([
            'user_id'         => $this->customer->id,
            'reviewable_id'   => $this->product->id,
            'reviewable_type' => \App\Models\Product::class,
            'rating'          => 4,
            'helpful_count'   => 0,
            'status'          => 'approved',
        ]);

        $other = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($other, ['*']);

        $response = $this->postJson("/api/products/{$this->product->id}/reviews/{$review->id}/helpful");
        $response->assertStatus(200)->assertJsonPath('data.helpful_count', 1);

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'helpful_count' => 1]);
    }

    public function test_product_average_rating_accessor()
    {
        foreach ([4, 5, 3] as $i => $stars) {
            Review::create([
                'user_id'         => User::factory()->create(['role' => 'customer'])->id,
                'reviewable_id'   => $this->product->id,
                'reviewable_type' => \App\Models\Product::class,
                'rating'          => $stars,
                'status'          => 'approved',
            ]);
        }

        $this->product->refresh();
        $this->assertEquals(4.0, $this->product->average_rating);
        $this->assertEquals(3,   $this->product->reviews_count);
    }
}
