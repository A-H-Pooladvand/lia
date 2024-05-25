<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InsufficientInventory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected ProductRepository $productRepository
    ) {
    }

    public function getAllOrders(): LengthAwarePaginator
    {
        return $this->orderRepository->all();
    }

    public function createOrder(array $params): Model
    {
        $attributes = $this->handleOrderRequest($params);

        return $this->orderRepository->create([
            'total_price' => $attributes['total'],
            'user_id'     => user()->id,
            'products'    => $attributes['products']
        ]);
    }

    public function getOrderById($id): Order
    {
        return $this->orderRepository->find($id);
    }

    public function updateOrder(Order $order, array $params): Order
    {
        $attributes = $this->handleOrderRequest($params);

        return $this->orderRepository->updateOrder($order, [
            'total_price' => $attributes['total'],
            'products'    => $attributes['products']
        ]);
    }

    public function deleteOrder($id): int
    {
        return $this->orderRepository->delete($id);
    }

    private function handleOrderRequest(array $params): array
    {
        $params = collect($params);

        $products = $this->productRepository->find(
            $params->pluck('product_id')
        );

        $total = $params->map(function (array $param) use ($products) {
            return $products->reduce(function (int $total, Product $product) use ($param) {
                if ($product->_id !== $param['product_id']) {
                    return $total;
                }

                if (!$product->hasInventoryOf($param['count'])) {
                    throw new InsufficientInventory("The product $product->name has $product->inventory inventory but you requested for {$param['count']}");
                }
                $product->inventory -= $param['count'];

                $product->setAttribute('count', $param['count']);

                return $total + $product->price * $product->count;
            }, 0);
        })->sum();

        $products->each(
            fn(Product $product) => $this->productRepository->update([
                'inventory' => $product->inventory
            ], $product->id)
        );

        return [
            'products' => $products->toArray(),
            'total'    => $total
        ];
    }
}
