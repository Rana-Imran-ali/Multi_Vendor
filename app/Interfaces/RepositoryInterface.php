<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;
    
    public function create(array $payload): Model;
    
    public function update(int $modelId, array $payload): bool;
    
    public function deleteById(int $modelId): bool;
}
