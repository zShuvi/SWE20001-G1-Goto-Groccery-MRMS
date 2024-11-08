
<?php
    session_start();

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }


    include "Database.php";

    // Handling form submission to simulate purchase
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!empty($_SESSION["cart"])){

            // Retrieve form data
            $userID = $_SESSION["active_user"]; // Sample user ID, you can modify this
            $date = date('Y-m-d');
            
            $cart = $_SESSION["cart"];

            // Calculate total price from ProductTable
            $totalPrice = 0;
            $productData = [];

            foreach ($cart as $productID => $quantity) {
                // Fetch product price from ProductTable
                $productQuery = "SELECT * FROM ProductTable WHERE ProductID = $productID";
                $result = $conn->query($productQuery);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $currentQuantity = $row['Quantity'];
                    $productPrice = (float)$row['Price'];
                    $quantity = $quantity['quantity'];
                    $totalPrice += ($productPrice * $quantity);
        
                    // Store product info for later insertion
                    $productData[] = [
                        'id' => $productID,
                        'price' => $productPrice,
                        'quantity' => $quantity
                    ];

                    $newQuantity = $currentQuantity - $quantity;
                    $updateQuantitySQL = "UPDATE ProductTable SET Quantity = $newQuantity WHERE ProductID = $productID";
                    $conn->query($updateQuantitySQL);

                } else {
                    echo "Product with ID $productID not found.";
                    exit;
                }
            }

            if(isset($_SESSION["voucher"])){
               
                $totalPrice = $totalPrice * ((100 - $_SESSION["discount_percentage"]) / 100);

                // Update the voucher_own table to set 'used' to 1
                $updateVoucherSQL = "UPDATE VoucherOwn SET Used = 1 WHERE User_ID = '" . $_SESSION["active_user"] . "' AND Voucher_ID = '" . $_SESSION["voucher_id"] . "'";

                if ($conn->query($updateVoucherSQL) === TRUE) {
                    $error = "Voucher marked as used.";
                } else {
                    $error = "Error updating voucher: " . $conn->error;
                }

                // Insert into ReceiptTable
                $insertReceiptSQL = "INSERT INTO ReceiptTable (UserID, Date, TotalPrice, voucherID) VALUES ($userID, '$date', $totalPrice, '" . $_SESSION["voucher_id"] . "')";
                
            } else {

                // Insert into ReceiptTable
                $insertReceiptSQL = "INSERT INTO ReceiptTable (UserID, Date, TotalPrice) VALUES ($userID, '$date', $totalPrice)";

            }

            
            if ($conn->query($insertReceiptSQL) === TRUE) {
                $receiptID = $conn->insert_id; // Get the generated ReceiptID

                // Insert each product into ReceiptItemTable
                foreach ($productData as $product) {
                    $productID = $product['id'];
                    $productPrice = $product['price'];
                    $quantity = $product['quantity'];

                    $insertItemSQL = "INSERT INTO ReceiptItemTable (ReceiptID, ProductID, ProductPrice, Quantity) 
                                    VALUES ($receiptID, $productID, $productPrice, $quantity)";
                    $conn->query($insertItemSQL);
                }

                // Optionally, clear the cart session variable after purchase
                $_SESSION["cart"] = []; //fully remove item from cart

                // Display pop-up with a checkmark animation and a "Done" button
                echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showPopup();
                    });
                </script>";

            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "
            <script>
                alert('Your cart is empty. Redirecting to Checkout Page.');
                window.location.href = 'CheckoutPage.php';
            </script>";

        }
        
    }


    $conn->close();

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
    
    <form method="POST" action="#">
        <div class="row">
            <div class="col">
                <h3 class="title">Billing Address</h3>
                <div class="inputBox">
                    <span>Full Name: </span>
                    <input type="text" placeholder="Enter Full Name" required>
                </div>
                <div class="inputBox">
                    <span>Email: </span>
                    <input type="email" placeholder="Enter Email" required>
                </div>
                <div class="inputBox">
                    <span>Address: </span>
                    <input type="text" placeholder="Enter Address" required>
                </div>
                <div class="inputBox">
                    <span>City: </span>
                    <input type="text" placeholder="Enter City" required>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>State: </span>
                        <input type="text" placeholder="Enter State" required>
                    </div>
                    <div class="inputBox">
                        <span>Postal Code: </span>
                        <input type="text" placeholder="Enter Code" required>
                    </div>
                </div>
            </div>
            <div class="col">
                <h3 class="title">Payment</h3>
                <div class="inputBox">
                    <span>Payment Accepted: </span>
                    <div class="paymentlogo">
                        <img src="images/tng.webp" alt="">
                        <img src="images/mastercardlogo.jpg" alt="">
                    </div>
                </div>
                <div class="inputBox">
                    <span>Name on Card: </span>
                    <input type="text" placeholder="Enter Name" required>
                </div>
                <div class="inputBox">
                    <span>Card Number: </span>
                    <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" required>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Expiry Date: </span>
                        <input type="text" placeholder="MM/YY" required>
                    </div>
                </div>
                <div class="cvv">
                    <div class="inputBox">
                        <span>CVV: </span>
                        <input type="text" placeholder="xxx" required>
                    </div>
                </div>
            </div>
            <input type="submit" value="Proceed to Checkout" class="submit-btn">
        </div>
    </form>

    <!-- Pop-up HTML Structure -->
    <div id="popup" class="popup hidden">
        <div class="checkmark-circle">
            <div class="background"></div>
            <div class="checkmark"></div>
        </div>
        <p>Purchase Completed!</p>
        <button onclick="redirect()">Done</button>
    </div>

    <script src="scripts/popup.js"></script>

</div>
</body>
</html>