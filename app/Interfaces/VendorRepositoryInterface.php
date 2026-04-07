<?php

namespace App\Interfaces;

interface VendorRepositoryInterface extends RepositoryInterface
{
    public function getPending(): \Illuminate\Database\Eloquent\Collection;

    public function approve(int $vendorId): bool;

    public function reject(int $vendorId): bool;

    public function getEarnings(int $vendorId): float;
}
