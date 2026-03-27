<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        // Admin views all vendors
        $vendors = Vendor::with('user')->get();
        return response()->json(['status' => 'success', 'data' => $vendors]);
    }

    public function store(Request $request)
    {
        // User applies to become a vendor
        $user = $request->user();

        if ($user->role === 'vendor') {
            return response()->json(['status' => 'error', 'message' => 'You are already a vendor.'], 400);
        }

        if ($user->vendor) {
            return response()->json(['status' => 'error', 'message' => 'You already have a pending vendor application.'], 400);
        }

        $validated = $request->validate([
            'store_name' => 'required|string|max:255|unique:vendors',
            'description' => 'required|string'
        ]);

        $vendor = Vendor::create([
            'user_id' => $user->id,
            'store_name' => $validated['store_name'],
            'description' => $validated['description'],
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Vendor application submitted successfully', 'data' => $vendor], 201);
    }

    public function show(Vendor $vendor)
    {
        return response()->json(['status' => 'success', 'data' => $vendor->load(['user', 'products'])]);
    }

    public function update(Request $request, Vendor $vendor)
    {
        // Vendor updates own profile
        if ($request->user()->id !== $vendor->user_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'store_name' => 'required|string|max:255|unique:vendors,store_name,' . $vendor->id,
            'description' => 'nullable|string'
        ]);

        $vendor->update($validated);

        return response()->json(['status' => 'success', 'message' => 'Vendor profile updated', 'data' => $vendor]);
    }

    public function approve(Request $request, Vendor $vendor)
    {
        // Admin approves vendor
        $request->validate(['status' => 'required|in:approved,rejected']);
        
        $vendor->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $vendor->user->update(['role' => 'vendor']);
        }

        return response()->json(['status' => 'success', 'message' => 'Vendor status updated', 'data' => $vendor]);
    }
}
