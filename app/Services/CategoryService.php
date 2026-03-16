<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ){}

    public function all(int $perPage = 15, bool $isActive = true)
    {
        return $this->categoryRepository->all($perPage, $isActive);
    }

    public function store(CategoryDTO $dto)
    {
        return $this->categoryRepository->store($dto);
    }
}