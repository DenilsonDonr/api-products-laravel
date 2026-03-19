<?php

namespace App\Repositories\Eloquent;

use App\DTOs\ProductDTO;
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

    public function store(ProductDTO $dto): Product
    {
        return Product::create($dto->toArray());
    }

    /**
     * Obtener un producto por su ID, lanzando una excepción si no se encuentra.
     */
    public function findById(int $id): Product
    {
        return Product::with('category')->where('is_active', true)->findOrFail($id);
    }

    /**
     * Actualizar un producto existente por su ID, lanzando una excepción si no se encuentra.
     */
    public function update(int $id, ProductDTO $dto): Product
    {
        $product = Product::findOrFail($id);
        $product->update($dto->toArray());
        return $product;
    }
}
