<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_hierarchy_can_be_retrieved()
    {
        $parent = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        $child = Category::create(['name' => 'Laptops', 'slug' => 'laptops', 'parent_id' => $parent->id]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Electronics'])
                 ->assertJsonFragment(['name' => 'Laptops']);
    }

    public function test_vendor_can_add_product_with_image_and_stock()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create([
            'user_id' => $user->id,
            'store_name' => 'Tech Shop',
            'slug' => 'tech-shop',
            'status' => 'approved'
        ]);
        
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        Sanctum::actingAs($user, ['*']);

        $image = UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg');

        $response = $this->postJson('/api/vendor/products', [
            'category_id' => $category->id,
            'name' => 'Gaming Laptop',
            'description' => 'A powerful gaming laptop',
            'price' => 1500.00,
            'stock' => 10,
            'images' => [
                $image
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Gaming Laptop']);

        $this->assertDatabaseHas('products', [
            'vendor_id' => $vendor->id,
            'stock' => 10
        ]);

        $this->assertDatabaseCount('product_images', 1);
        
        $product = \App\Models\Product::first();
        Storage::disk('public')->assertExists($product->images->first()->image_path);
    }
}
