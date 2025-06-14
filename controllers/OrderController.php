<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController
{
    public function createOrder($request)
    {
        // Create and populate the order
        $order = new Order();
        $order->userID = $request['userID'];
        $order->orderDate = date('Y-m-d H:i:s'); // optional if using default timestamp
        $order->totalAmount = $request['totalAmount'];
        $order->save();

        return [
            'status' => 'success',
            'orderID' => $order->orderID
        ];
    }

    public function getOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found'];
        }

        return $order;
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found'];
        }

        // Assuming there's a status field in your orders table
        $order->status = 'canceled'; // You may need to add this column
        $order->save();

        return ['status' => 'success', 'message' => 'Order canceled'];
    }


    public function showUserOrders($userID)
{
    $db = new \App\Config\Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM orders WHERE userID = ?");
    $stmt->execute([$userID]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include 'views/order.php';
}

}
