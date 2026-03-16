<?php

namespace App\Repositories\Eloquent;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Obtener todas las categorías paginadas, con opción de filtrar por estado activo.
     */
    public function all(int $perPage = 15, bool $isActive = true): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Category> $query */
        $query = Category::where('is_active', $isActive);

        return $query->paginate($perPage);
    }

    /**
     * Crear una nueva categoría con los datos proporcionados.
     */
    public function store(CategoryDTO $dto): Category
    {
        return Category::create($dto->toArray());
    }
}
