<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function store(StoreOrderRequest $request)
{
    try {
        $order = $this->orderService->createOrder(
            $request->validated()
        );

        return new OrderResource($order->load('items'));

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 422);
    }
}
        
       
    
}
