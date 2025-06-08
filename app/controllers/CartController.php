<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController
{
    protected $cartModel;

    public function __construct($db)
    {
        $this->cartModel = new Cart($db);
    }

    public function addToCart($userId, $productId, $quantity)
    {
        return $this->cartModel->addToCart($userId, $productId, $quantity);
    }

    public function getCart($userId)
    {
        return $this->cartModel->getUserCartWithDetails($userId);
    }

    public function updateCart($userId, $productId, $quantity)
    {
        return $this->cartModel->updateCart($userId, $productId, $quantity);
    }

    public function removeFromCart($userId, $productId)
    {
        return $this->cartModel->removeItem($userId, $productId);
    }
}
