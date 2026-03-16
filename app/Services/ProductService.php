<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function all(int $perPage = 15, bool $isActive = true)
    {
        return $this->productRepository->all($perPage, $isActive);
    }
}
