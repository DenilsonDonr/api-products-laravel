<?php

namespace App\Repositories\Contracts;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function all(int $perPage = 15, bool $isActive = true): LengthAwarePaginator;
    public function store(CategoryDTO $dto): Category;
}
