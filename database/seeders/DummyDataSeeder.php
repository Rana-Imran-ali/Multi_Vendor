<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Vendor User and Vendor Profile
        $vendorUser = clone User::firstOrCreate(
            ['email' => 'vendor@example.com'],
            [
                'name' => 'Demo Vendor',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'is_approved' => true,
            ]
        );

        $vendorProfile = Vendor::firstOrCreate(
            ['user_id' => $vendorUser->id],
            [
                'store_name' => 'Tech World Store',
                'description' => 'The best tech store.',
                'status' => Vendor::STATUS_APPROVED,
            ]
        );

        // 2. Create Categories
        $categories = [
            Category::firstOrCreate(['name' => 'Electronics', 'slug' => 'electronics']),
            Category::firstOrCreate(['name' => 'Fashion', 'slug' => 'fashion']),
            Category::firstOrCreate(['name' => 'Home & Garden', 'slug' => 'home-garden']),
        ];

        // 3. Create normal users to leave reviews
        $reviewers = [];
        for ($i = 1; $i <= 5; $i++) {
            $reviewer = User::firstOrCreate(
                ['email' => "reviewer{$i}@example.com"],
                [
                    'name' => "Customer Mode {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ]
            );
            $reviewers[] = $reviewer;
        }

        // 4. Create 15 Products
        for ($i = 1; $i <= 15; $i++) {
            $category = $categories[array_rand($categories)];
            
            $productName = "Amazing Product " . $i;
            $product = Product::create([
                'vendor_id' => $vendorUser->id,
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productName) . '-' . Str::random(5),
                'description' => "This is a detailed description for $productName. It has great features.",
                'price' => rand(50, 1000) + 0.99,
                'stock' => rand(10, 100),
                'status' => 'active',
            ]);

            // Add 2-3 images per product (using generic placeholder based on requirements)
            $imageCount = rand(2, 3);
            for ($j = 0; $j < $imageCount; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "https://via.placeholder.com/300?text=Product+{$product->id}+Img+{$j}",
                    'is_primary' => $j === 0 ? true : false,
                ]);
            }

            // Create 1-3 Reviews per product
            $reviewCount = rand(1, 3);
            $selectedReviewers = (array) array_rand($reviewers, $reviewCount);
            foreach ($selectedReviewers as $index) {
                // Determine morph class automatically by passing the product
                $product->reviews()->create([
                    'user_id' => $reviewers[$index]->id,
                    'rating' => rand(3, 5),
                    'comment' => "I really loved this product. Great quality!",
                ]);
            }
        }
    }
}
