<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function show(int $id)
    {
        try {
            $product = $this->productService->findById($id);
            return new ProductResource($product);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        try {
            $dto     = ProductDTO::fromRequest($request->validated());
            $product = $this->productService->update($id, $dto);
            return new ProductResource($product);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }
}