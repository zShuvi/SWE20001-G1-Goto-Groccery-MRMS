<?php
session_start();

/* Cart is an array of Product IDs, which in turn are objects that store details like quantity. 
If we need the cart to directly store more details, I can easily add it.
Note: If we can pull data directly from the product database, try to use that instead of Cart.
We want as little data to be stored under the Session as possible.

Structure:
    Session
    {
        Cart
        {
            Product 1
            {
                Quantity;
                Other;
                Other2;
            }
            Product 2
            {
                Quantity;
                Other;
                Other2;
            }
        }
    } */


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


// If this script is called via AJAX
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['productID'])) {
    $productID = $_GET['productID'];
    $success = addToCart($productID);

    // Respond with JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $success ? 'Item add' : $productID]);
    exit;
}


function removeFromCart($productID, $quantity = 1)
{
    if (isset($_SESSION['cart'][$productID])) 
    {
        $_SESSION['cart'][$productID]['quantity'] -= $quantity;

        if ($_SESSION['cart'][$productID]['quantity'] < 1)
        {
            unset($_SESSION['cart'][$productID]); //fully remove item from cart
        }
    }
    else
    {
        $_SESSION['error'] = "Item not found";
    }
}


// If this script is called via AJAX
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['productID'])) {
    $productID = $_GET['productID'];
    $success = removeFromCart($productID);

    // Respond with JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $success ? 'Item removed' : $productID]);
    exit;
}

function updateQuantity($productID, $quantity) 
//Just in case we need it, for example implementing a - [ ] + element where customers can directly type it 
{
    if (isset($_SESSION['cart'][$productID])) {
        if ($quantity < 1) 
        {
            unset($_SESSION['cart'][$productID]); 
        } 
        else 
        {
            $_SESSION['cart'][$productID]['quantity'] = $quantity;
        }
    } 
    else 
    {
        $_SESSION['error'] = "Item not found";
    }
}

function productsInCart() //good for having a visual element showing a tally of "items in cart" 
{
    // Check if the cart is set and not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) 
    {
        return count($_SESSION['cart']);
    } 
    else 
    {
        return 0;
    }
}



?>

