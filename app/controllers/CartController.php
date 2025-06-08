<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController
{
    // Cart model instance
    protected $cartModel;

    // Initialize Cart model with database connection
    public function __construct($db)
    {
        $this->cartModel = new Cart($db);
    }

    // Add item to cart
    public function addToCart($userId, $productId, $quantity)
    {
        return $this->cartModel->addToCart($userId, $productId, $quantity);
    }

    // Get all cart items for a user
    public function getCart($userId)
    {
        return $this->cartModel->getUserCartWithDetails($userId);
    }

    // Update quantity of an item in the cart
    public function updateCart($userId, $productId, $quantity)
    {
        return $this->cartModel->updateCart($userId, $productId, $quantity);
    }

    // Remove item from cart
    public function removeFromCart($userId, $productId)
    {
        return $this->cartModel->removeItem($userId, $productId);
    }
}
