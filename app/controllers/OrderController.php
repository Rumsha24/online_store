<?php

namespace App\Controllers;

use App\Models\Order;
use Exception;

class OrderController
{
    public function createOrder(array $request): Order
    {
        try {
            $this->validateOrderRequest($request);
            
            $order = new Order();
            $order->fill($request);
            $order->save();
            
            return $order;
        } catch (Exception $e) {
            // Log error
            throw $e;
        }
    }

    public function getOrder(int $orderId): Order
    {
        $order = Order::find($orderId);
        
        if (!$order) {
            throw new Exception("Order not found");
        }
        
        return $order;
    }

    public function cancelOrder(int $orderId): Order
    {
        $order = $this->getOrder($orderId);
        $order->status = 'cancelled';
        $order->save();
        
        return $order;
    }
    
    private function validateOrderRequest(array $request): void
    {
        // Implementation of validation logic
    }
}