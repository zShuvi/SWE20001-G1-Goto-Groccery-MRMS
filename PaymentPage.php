<?php
    session_start();

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/paymentpage_style.css">
</head>
<body>
<div class="container">
    
    <form action="">
        <div class="row">
            <div class="col">
                <h3 class="title">Billing Address</h3>
                <div class="inputBox">
                    <span>Full Name: </span>
                    <input type="text" placeholder="Enter Full Name">
                </div>
                <div class="inputBox">
                    <span>Email: </span>
                    <input type="email" placeholder="Enter Email">
                </div>
                <div class="inputBox">
                    <span>Address: </span>
                    <input type="text" placeholder="Enter Address">
                </div>
                <div class="inputBox">
                    <span>City: </span>
                    <input type="text" placeholder="Enter City">
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>State: </span>
                        <input type="text" placeholder="Enter State">
                    </div>
                    <div class="inputBox">
                        <span>Postal Code: </span>
                        <input type="text" placeholder="Enter Code">
                    </div>
                </div>
            </div>
            <div class="col">
                <h3 class="title">Payment</h3>
                <div class="inputBox">
                    <span>Payment Accepted: </span>
                <div class="paymentlogo">
                    <img src="images\tng.webp" alt="">
                    <img src="images\mastercardlogo.jpg" alt="">
                </div>
                </div>
                <div class="inputBox">
                    <span>Name on Card: </span>
                    <input type="text" placeholder="Enter Name">
                </div>
                <div class="inputBox">
                    <span>Card Number: </span>
                    <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx">
                </div>
            <div class="flex">
                <div class="inputBox">
                    <span>Expiry Date: </span>
                    <input type="text" placeholder=" (MM/YY)">
                </div>
            </div>
            <div class="cvv">
                <div class="inputBox">
                    <span>CVV: </span>
                    <input type="text" placeholder="xxx">
                </div>
            </div>
                    
                </div>
            </div>
            <input type="submit" value="Proceed to Checkout" class="submit-btn">
        </div>
    </form>
</div>
    
</body>
</html>