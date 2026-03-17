<?php

namespace App\Repositories\Contracts;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function all(int $perPage = 15, bool $isActive = true): LengthAwarePaginator;
    public function store(ProductDTO $dto): Product;
    public function findById(int $id): Product;
}
