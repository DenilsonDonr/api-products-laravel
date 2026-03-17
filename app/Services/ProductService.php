<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
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

    public function store(ProductDTO $dto): Product
    {
        return $this->productRepository->store($dto);
    }
}
