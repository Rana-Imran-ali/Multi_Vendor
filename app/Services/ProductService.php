<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create a new product with variants and images.
     */
    public function createProduct(array $data, User $vendorUser)
    {
        return DB::transaction(function () use ($data, $vendorUser) {
            $product = Product::create([
                'vendor_id' => $vendorUser->vendor->id,
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']) . '-' . uniqid(),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'status' => 'pending', // products start as pending
            ]);

            if (!empty($data['variants'])) {
                $product->variants()->createMany($data['variants']);
            }

            if (!empty($data['images'])) {
                $product->images()->createMany($data['images']);
            }

            return $product->load(['category', 'variants', 'images']);
        });
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(Product $product, array $data)
    {
        return DB::transaction(function () use ($product, $data) {
            if (isset($data['name']) && $data['name'] !== $product->name) {
                $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
            }

            $product->update(collect($data)->except(['variants', 'images'])->toArray());

            if (isset($data['variants'])) {
                // For simplicity, we just delete old and recreate or we update existing ones.
                // A better approach is updating existing by ID, but here we just manage them simply.
                // Assuming clients send full list of variants
                $product->variants()->delete();
                $product->variants()->createMany($data['variants']);
            }

            if (isset($data['images'])) {
                $product->images()->delete();
                $product->images()->createMany($data['images']);
            }

            return $product->fresh(['category', 'variants', 'images']);
        });
    }

    /**
     * Change product status (e.g., Admin approval/rejection)
     */
    public function changeStatus(Product $product, string $status)
    {
        $product->update(['status' => $status]);
        return $product;
    }
}
