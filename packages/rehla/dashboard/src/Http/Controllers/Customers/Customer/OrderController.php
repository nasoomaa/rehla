<?php

namespace Rehla\Dashboard\Http\Controllers\Customers\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Rehla\Dashboard\Http\Controllers\Controller;
use Rehla\Dashboard\Http\Resources\OrderItemResource;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected OrderItemRepository $orderItemRepository) {}

    /**
     * Returns the compare items of the customer.
     */
    public function recentItems(int $id): JsonResource
    {
        $orderItems = $this->orderItemRepository
            ->distinct('order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', 'orders.id')
            ->whereNull('order_items.parent_id')
            ->where('orders.customer_id', $id)
            ->orderBy('orders.created_at', 'desc')
            ->limit(5)
            ->get();

        return OrderItemResource::collection($orderItems);
    }
}
