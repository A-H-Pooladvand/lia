<?php

namespace App\Http\Controllers\Product\V1;

use Cache;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $products = Cache::remember($request->fullUrl(), now()->addMinute(), function () {
            return $this->productService->getAllProducts();
        });

        return apiResponse()->paginate($products);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $product = Cache::remember($request->fullUrl(), now()->addMinute(), function () use ($id) {
            return $this->productService->getProductById($id);
        });

        return apiResponse()->ok([
            'product' => $product
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct(
            $request->validated()
        );

        return apiResponse()->created([
            'product' => $product
        ]);
    }

    public function update(ProductRequest $request, $product): JsonResponse
    {
        $this->productService->updateProduct(
            $request->validated(),
            $product
        );

        return apiResponse()
            ->withMessage('Product updated successfully')
            ->ok([]);
    }

    public function destroy($product): JsonResponse
    {
        $this->productService->deleteProduct($product);

        return apiResponse()->withMessage('Product deleted successfully')->ok([]);
    }
}
