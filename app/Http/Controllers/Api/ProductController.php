<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $perPage  = $request->query('per_page', 15);
        $isActive = $request->query('is_active', true);
        $products = $this->productService->all($perPage, $isActive);
        return ProductResource::collection($products);
    }
}
