<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(int $perPage = 15, bool $isActive = true): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Category> $query */
        $query = Category::where('is_active', $isActive);

        return $query->paginate($perPage);
    }
}
