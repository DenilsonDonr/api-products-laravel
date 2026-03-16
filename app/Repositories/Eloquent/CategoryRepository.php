<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Category> $query */
        $query = Category::where('is_active', true);

        return $query->paginate($perPage);
    }
}
