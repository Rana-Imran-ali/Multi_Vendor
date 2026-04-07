<?php

namespace App\Interfaces;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getByUser(int $userId): \Illuminate\Pagination\LengthAwarePaginator;

    public function getByVendor(int $vendorId): \Illuminate\Pagination\LengthAwarePaginator;

    public function getAllPaginated(int $perPage = 20): \Illuminate\Pagination\LengthAwarePaginator;

    public function updateStatus(int $orderId, string $status): bool;
}
