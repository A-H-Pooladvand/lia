<?php

namespace App\Repositories;


use App\Models\Product;

class ProductRepository extends Repository
{
    public function model(): string
    {
        return Product::class;
    }
}
