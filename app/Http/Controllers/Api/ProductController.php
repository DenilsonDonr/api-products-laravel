<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
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

    public function store(StoreProductRequest $request)
    {
        $dto     = ProductDTO::fromRequest($request->validated());
        $product = $this->productService->store($dto);
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }
}
