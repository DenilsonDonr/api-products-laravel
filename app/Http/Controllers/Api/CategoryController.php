<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $categories = $this->categoryService->all($perPage);
        return CategoryResource::collection($categories);
    }
}
