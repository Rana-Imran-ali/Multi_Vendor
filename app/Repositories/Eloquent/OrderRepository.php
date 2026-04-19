<?php

namespace App\Repositories\Eloquent;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getByUser(int $userId): LengthAwarePaginator
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereNull('parent_id') // Only parent orders
            ->with(['subOrders.vendor', 'subOrders.items.product.images'])
            ->latest()
            ->paginate(15);
    }

    public function getByVendor(int $vendorId): LengthAwarePaginator
    {
        return $this->model
            ->where('vendor_id', $vendorId)
            ->with([
                'items.product.images',
                'user:id,name,email',
            ])
            ->latest()
            ->paginate(15);
    }

    public function getAllPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model
            ->whereNull('parent_id') // Admin sees parent orders by default
            ->with(['user:id,name,email', 'subOrders.items.product', 'subOrders.vendor'])
            ->latest()
            ->paginate($perPage);
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->model->findOrFail($orderId)->update(['status' => $status]);
    }
}
