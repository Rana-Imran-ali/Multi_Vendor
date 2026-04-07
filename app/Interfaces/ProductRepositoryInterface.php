<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\CursorPaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getApprovedCatalog(array $filters, int $perPage): CursorPaginator;

    public function getByVendor(int $vendorId): \Illuminate\Database\Eloquent\Collection;

    public function getPending(): \Illuminate\Database\Eloquent\Collection;
}
