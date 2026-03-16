<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ){}

    public function all(int $perPage = 15)
    {
        return $this->categoryRepository->all($perPage);
    }
}