<?php

namespace App\Repositories;

use DB;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;

class OrderRepository extends Repository
{
    public function model(): string
    {
        return Order::class;
    }

    public function updateOrder(Order $order, array $data)
    {
        $this->update($data, $order->_id);

        return $order->refresh();
    }
}
