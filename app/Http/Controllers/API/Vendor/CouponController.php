<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/vendor/coupons
     * List all coupons owned by the authenticated vendor.
     */
    public function index(Request $request)
    {
        $vendor = $request->user()->vendor;

        $coupons = Coupon::where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(15);

        return $this->successResponse($coupons, 'Coupons retrieved successfully.');
    }

    /**
     * POST /api/vendor/coupons
     */
    public function store(Request $request)
    {
        $vendor = $request->user()->vendor;

        $validated = $request->validate([
            'code'               => 'nullable|string|max:32|unique:coupons,code',
            'discount_type'      => 'required|in:percentage,fixed',
            'discount_amount'    => 'required|numeric|min:0.01',
            'min_spend'          => 'nullable|numeric|min:0',
            'max_uses'           => 'nullable|integer|min:1',
            'max_uses_per_user'  => 'nullable|integer|min:1',
            'expires_at'         => 'nullable|date|after:today',
        ]);

        // Auto-generate code if not provided
        $code = strtoupper($validated['code'] ?? Str::random(8));

        $coupon = Coupon::create([
            'vendor_id'          => $vendor->id,
            'code'               => $code,
            'discount_type'      => $validated['discount_type'],
            'discount_amount'    => $validated['discount_amount'],
            'min_spend'          => $validated['min_spend'] ?? null,
            'max_uses'           => $validated['max_uses'] ?? null,
            'max_uses_per_user'  => $validated['max_uses_per_user'] ?? null,
            'expires_at'         => $validated['expires_at'] ?? null,
            'is_active'          => true,
        ]);

        return $this->successResponse($coupon, 'Coupon created successfully.', 201);
    }

    /**
     * PUT /api/vendor/coupons/{coupon}
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorizeVendor($request, $coupon);

        $validated = $request->validate([
            'discount_type'      => 'sometimes|required|in:percentage,fixed',
            'discount_amount'    => 'sometimes|required|numeric|min:0.01',
            'min_spend'          => 'nullable|numeric|min:0',
            'max_uses'           => 'nullable|integer|min:1',
            'max_uses_per_user'  => 'nullable|integer|min:1',
            'expires_at'         => 'nullable|date|after:today',
            'is_active'          => 'boolean',
        ]);

        $coupon->update($validated);

        return $this->successResponse($coupon->fresh(), 'Coupon updated successfully.');
    }

    /**
     * DELETE /api/vendor/coupons/{coupon}
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        $this->authorizeVendor($request, $coupon);
        $coupon->delete();

        return $this->successResponse(null, 'Coupon deleted successfully.');
    }

    /**
     * POST /api/coupons/validate
     * Public endpoint to validate a coupon code against a subtotal.
     */
    public function validate(Request $request)
    {
        $validated = $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($validated['code']))->first();

        if (! $coupon || ! $coupon->is_active) {
            return $this->errorResponse('Invalid or inactive coupon code.', 404);
        }

        if ($coupon->expires_at && now()->isAfter($coupon->expires_at)) {
            return $this->errorResponse('This coupon has expired.', 410);
        }

        $subtotal = (float) $validated['subtotal'];

        if ($coupon->min_spend && $subtotal < $coupon->min_spend) {
            return $this->errorResponse(
                "Minimum spend of {$coupon->min_spend} required for this coupon.",
                422
            );
        }

        $discount = match ($coupon->discount_type) {
            'percentage' => round($subtotal * ($coupon->discount_amount / 100), 2),
            'fixed'      => min($coupon->discount_amount, $subtotal),
        };

        return $this->successResponse([
            'code'          => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount'      => $discount,
            'new_total'     => max(0, $subtotal - $discount),
        ], 'Coupon is valid.');
    }

    private function authorizeVendor(Request $request, Coupon $coupon): void
    {
        $vendor = $request->user()->vendor;
        if (! $vendor || $coupon->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized.');
        }
    }
}
