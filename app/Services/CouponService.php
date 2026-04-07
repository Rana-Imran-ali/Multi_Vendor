<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;

class CouponService
{
    /**
     * Validate and apply a coupon to a given subtotal.
     *
     * @throws \Exception When the coupon is invalid or conditions are not met.
     */
    public function apply(string $code, float $subtotal, User $user): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (! $coupon) {
            throw new \Exception('Coupon code not found.');
        }

        if (! $coupon->is_active) {
            throw new \Exception('This coupon is no longer active.');
        }

        if ($coupon->expires_at && now()->isAfter($coupon->expires_at)) {
            throw new \Exception('This coupon has expired.');
        }

        if ($coupon->min_spend && $subtotal < $coupon->min_spend) {
            throw new \Exception("Minimum spend of {$coupon->min_spend} required to use this coupon.");
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            throw new \Exception('This coupon has reached its usage limit.');
        }

        // Per-user usage check
        $userUsage = $coupon->usages()->where('user_id', $user->id)->count();
        if ($coupon->max_uses_per_user && $userUsage >= $coupon->max_uses_per_user) {
            throw new \Exception('You have already used this coupon the maximum number of times.');
        }

        $discount = match ($coupon->discount_type) {
            'percentage' => round($subtotal * ($coupon->discount_amount / 100), 2),
            'fixed'      => min($coupon->discount_amount, $subtotal),
            default      => throw new \Exception('Unsupported discount type.'),
        };

        $newTotal = max(0, $subtotal - $discount);

        return [
            'coupon'    => $coupon,
            'discount'  => $discount,
            'new_total' => $newTotal,
        ];
    }

    /**
     * Record that a coupon was used by a user.
     */
    public function recordUsage(Coupon $coupon, int $userId): void
    {
        $coupon->usages()->create(['user_id' => $userId]);
        $coupon->increment('used_count');
    }
}
