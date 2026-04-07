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
            ->with(['items.product.images'])
            ->latest()
            ->paginate(15);
    }

    public function getByVendor(int $vendorId): LengthAwarePaginator
    {
        return $this->model
            ->whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))
            ->with([
                'items' => fn($q) => $q
                    ->whereHas('product', fn($q2) => $q2->where('vendor_id', $vendorId))
                    ->with('product.images'),
                'user:id,name,email',
            ])
            ->latest()
            ->paginate(15);
    }

    public function getAllPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model
            ->with(['user:id,name,email', 'items.product'])
            ->latest()
            ->paginate($perPage);
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->model->findOrFail($orderId)->update(['status' => $status]);
    }
}
