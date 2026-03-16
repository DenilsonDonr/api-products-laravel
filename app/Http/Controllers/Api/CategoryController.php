<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CategoryDTO;
use App\Http\Controllers\Controller;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ){}

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $isActive = $request->query('is_active', true);
        $categories = $this->categoryService->all($perPage, $isActive);
        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $dto = CategoryDTO::fromRequest($request->validated());
        $category = $this->categoryService->store($dto);
        return new CategoryResource($category)
            ->response()
            ->setStatusCode(201);
    }
}
