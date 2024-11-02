<?php
session_start();
function addToCart($productID, $quantity = 1) 
{
    // Check if the item already exists in the cart
    if (isset($_SESSION['cart'][$productID])) 
    {
        // If it exists, just update the quantity
        $_SESSION['cart'][$productID]['quantity'] += $quantity;
    } 
    else 
    {
        // If it doesn't exist, add it to the cart
        $_SESSION['cart'][$productID] = [
            'quantity' => $quantity,
        ];
    }
}
