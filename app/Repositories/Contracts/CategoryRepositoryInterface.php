<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
}
