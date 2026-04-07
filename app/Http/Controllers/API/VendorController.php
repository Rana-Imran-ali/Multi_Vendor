<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    use ApiResponse;

    /**
     * Customer: apply to become a vendor.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'vendor') {
            return $this->errorResponse('You are already an approved vendor.', 409);
        }

        if ($user->vendor) {
            return $this->errorResponse('You already have a pending vendor application.', 409);
        }

        $validated = $request->validate([
            'store_name'  => 'required|string|max:255|unique:vendors',
            'description' => 'required|string',
            'logo'        => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('vendor-logos', 'public');
        }

        $vendor = Vendor::create([
            'user_id'     => $user->id,
            'store_name'  => $validated['store_name'],
            'slug'        => Str::slug($validated['store_name']),
            'description' => $validated['description'],
            'logo'        => $logoPath,
            'status'      => 'pending',
        ]);

        return $this->successResponse($vendor, 'Vendor application submitted. Awaiting admin approval.', 201);
    }

    /**
     * Vendor: update own store profile.
     */
    public function update(Request $request, Vendor $vendor)
    {
        if ($request->user()->id !== $vendor->user_id) {
            return $this->errorResponse('Unauthorized.', 403);
        }

        $validated = $request->validate([
            'store_name'  => 'required|string|max:255|unique:vendors,store_name,' . $vendor->id,
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('vendor-logos', 'public');
        }

        $vendor->update([
            'store_name'  => $validated['store_name'],
            'slug'        => Str::slug($validated['store_name']),
            'description' => $validated['description'] ?? $vendor->description,
            'logo'        => $validated['logo'] ?? $vendor->logo,
        ]);

        return $this->successResponse($vendor->fresh()->load('user:id,name,email'), 'Vendor profile updated successfully.');
    }
}
