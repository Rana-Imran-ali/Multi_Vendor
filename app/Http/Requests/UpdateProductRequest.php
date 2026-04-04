<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $product = $this->route('product'); // assuming route parameter name is 'product'
        
        return $user && $user->vendor && $product && $user->vendor->id === $product->vendor_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',

            // Variants validation
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id', // For updating existing variants
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.price_adjustment' => 'nullable|numeric',

            // Images validation
            'images' => 'nullable|array',
            'images.*.image_path' => 'required_with:images|string',
            'images.*.is_primary' => 'nullable|boolean',
        ];
    }
}
