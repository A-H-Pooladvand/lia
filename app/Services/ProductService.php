<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;

class ProductService
{
    public function __construct(
      protected  ProductRepository $productRepository
    )
    {
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->all();
    }

    public function getProductById($id): Model
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data): Model
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(array $data, $id): bool
    {
        return $this->productRepository->update($data, $id);
    }

    public function deleteProduct($id): int
    {
        return $this->productRepository->delete($id);
    }
}
