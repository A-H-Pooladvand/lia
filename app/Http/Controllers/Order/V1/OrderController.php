<?php

namespace App\Http\Controllers\Order\V1;

use Cache;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {
    }

    public function index(): JsonResponse
    {
        $orders = Cache::remember('products_index', now()->addMinute(), function () {
            return $this->orderService->getAllOrders();
        });

        return apiResponse()->paginate($orders);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder(
            $request->validated()
        );

        return apiResponse()->created([
            'order' => $order
        ]);
    }

    public function show($id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);

        return apiResponse()->ok([
            'order' => $order
        ]);
    }

    public function update(OrderRequest $request, $id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);

        if (user()->cannot('update', $order)) {
            abort(404, 'not found');
        }

        $order = $this->orderService->updateOrder($order, $request->validated());

        return apiResponse()
            ->withMessage('Order updated successfully')
            ->ok([
                'order' => $order
            ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->orderService->deleteOrder($id);

        return apiResponse()
            ->withMessage('Order deleted successfully')
            ->ok([]);
    }
}
