<?php

namespace App\Repositories\Eloquent;

use App\Interfaces\VendorRepositoryInterface;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
{
    public function __construct(Vendor $model)
    {
        parent::__construct($model);
    }

    public function getPending(): Collection
    {
        return $this->model
            ->where('status', 'pending')
            ->with('user:id,name,email')
            ->latest()
            ->get();
    }

    public function approve(int $vendorId): bool
    {
        $vendor = $this->model->findOrFail($vendorId);
        $updated = $vendor->update(['status' => 'approved']);

        if ($updated) {
            // Promote user role to vendor so RBAC middleware allows vendor routes
            $vendor->user()->update(['role' => 'vendor']);
        }

        return $updated;
    }

    public function reject(int $vendorId): bool
    {
        $vendor = $this->model->findOrFail($vendorId);
        return $vendor->update(['status' => 'rejected']);
    }

    /**
     * Calculate total earnings for the vendor (sum of delivered order items).
     */
    public function getEarnings(int $vendorId): float
    {
        return (float) Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))
            ->where('status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.vendor_id', $vendorId)
            ->sum(\DB::raw('order_items.price * order_items.quantity'));
    }
}
