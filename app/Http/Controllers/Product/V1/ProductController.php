<?php

namespace App\Http\Controllers\Product\V1;

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

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return apiResponse()->ok([
            'products' => $products
        ]);
    }

    public function show($product): JsonResponse
    {
        $product = $this->productService->getProductById($product);

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
