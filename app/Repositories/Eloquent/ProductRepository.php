<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Obtener todos los productos paginados, con opción de filtrar por estado activo.
     */
    public function all(int $perPage = 15, bool $isActive = true): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Product> $query */
        $query = Product::where('is_active', $isActive);

        return $query->paginate($perPage);
    }
}
