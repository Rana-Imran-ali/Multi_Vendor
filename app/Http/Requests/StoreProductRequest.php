<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->vendor && $user->vendor->status === 'approved';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            
            // Variants validation (optional but structured if present)
            'variants' => 'nullable|array',
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
