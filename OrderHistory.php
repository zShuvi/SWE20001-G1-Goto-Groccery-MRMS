<?php
    session_start();

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }

    $UserID = $_SESSION["active_user"];

    
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Stock Ordering Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">  
	<link href="styles/orderhistory_style.css" rel="stylesheet">

</head>



<body>
    
    <input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">
    
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

    <nav class="navbar">
        <a href="Home.php">home</a>
        <a href="Home.php#features">features</a>
        <a href="Product.php">products</a>
        <a href="Home.php#reviews">reviews</a>
        <a href="OrderHistory.php">Order History</a>
    </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn">
            <ul class="dropdown-content">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Product.php">Products</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
            </ul>
        </div>
        <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
    </div>

    <!-- <label><?php echo $_SESSION["active_username"]?></label> --> <!-- display name in navbar -->

    </header>



    <!-- Home, outside of Navigation Side Bar -->
    <section class="home">
        <div class="container_order">
            <div class="form-header">
                <h1>Order History</h1>
            </div>
    

                

            <?php

                include 'Database.php';
                
            if(isset($_SESSION["active_user"])){

                
                $sql = "SELECT r.ReceiptID, r.Date, r.TotalPrice, o.Quantity, o.ProductPrice, p.Name, p.Image, v.VoucherID, v.VoucherName
                        FROM ReceiptTable r
                        LEFT JOIN ReceiptItemTable o ON r.ReceiptID = o.ReceiptID
                        LEFT JOIN ProductTable p ON o.ProductID = p.ProductID
                        LEFT JOIN VouchersTable v ON r.VoucherID = v.VoucherID
                        WHERE r.UserID = $UserID
                        ORDER BY r.Date DESC";
                $result = $conn->query($sql);

                if (!$result) {
                    echo "Error in query: " . $conn->error;
                } elseif ($result->num_rows > 0) {
                    $receipts = [];
                    while ($row = $result->fetch_assoc()) {
                        $receipts[$row['ReceiptID']]['details'] = [
                            'Date' => $row['Date'],
                            'TotalPrice' => $row['TotalPrice'],
                            'VoucherCode' => $row['VoucherName'] ?? 'No Voucher Used'
                        ];
                        $receipts[$row['ReceiptID']]['items'][] = [
                            'ProductName' => $row['Name'],
                            'Quantity' => $row['Quantity'],
                            'Price' => $row['ProductPrice'],
                            'Image' => $row['Image']
                        ];
                    }
            
                    // Generate cards and popups
                    echo "<div class='related-products-container'>";
                    foreach ($receipts as $receiptID => $receipt) {
                        echo "
                            <div class='product-card'>
                                <div class='product-info'>
                                    <h3 class='receipt_id'>Receipt ID " . $receiptID . "</h3>
                                    <p class='info'><strong>Purchased Date: </strong>" . $receipt['details']['Date'] . "</p>
                                    <p class='info'><strong>Order Total: </strong><span style='color: red;'>RM" . $receipt['details']['TotalPrice'] . "</span></p>
                                </div>
                                
                                <div class='popup' id='popup-" . $receiptID . "'>
                                    <div class='overlay'></div>
                                    <div class='content'>
                                        <div class='close-btn' onclick='togglePopup(\"popup-" . $receiptID . "\")'>&times;</div>

                                        <!-- Receipt Header -->
                                        <div class='receipt-header'>
                                            <h2>Official Receipt</h2>
                                            <p>Goto Grocery</p>
                                            <p>Date: " . $receipt['details']['Date'] ."</p>
                                            <p>Receipt ID: " . $receiptID . "</p>
                                        </div>

                                        

                                        <!-- Receipt Body -->
                                        <div class='receipt-body'>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Quantity</th>
                                                        <th>Price (RM)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                                    foreach ($receipt['items'] as $item) {
                                                        echo "
                                                        <tr>
                                                            <td><img src=" . $item['Image'] . ">" . $item['ProductName'] . "</td>
                                                            <td>" . $item['Quantity'] . "</td>
                                                            <td>" . $item['Price'] . "</td>
                                                        </tr>
                                                        ";
                                                    } 
                                                    echo"
                                                </tbody>
                                            </table>
                                        </div>


                                        


                                        <!-- Receipt Footer -->
                                        <div class='receipt-footer'>
                                            <p><strong>Voucher Used:</strong> " . $receipt['details']['VoucherCode'] . "</p>
                                            <p><strong>Total Price:</strong> <span class='total-price'>RM " . $receipt['details']['TotalPrice'] . "</span></p>
                                            <p>Thank you for your purchase!</p>
                                        </div>


                                    </div>         
                                </div>

                                
                                <button onclick='togglePopup(\"popup-" . $receiptID . "\")'>View Order History</button>
                            </div>";
                    }
                    echo "</div>";
                } else {
                    echo "No Order History found.";
                }
            } else {
                echo "Please Login to Show Order History.";
            }
                

            ?>

            </div>
    
        </div>
    
    </section>


    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Customer Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Social Media</h4>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-subscribe">
                <h4>Subscribe to Our Newsletter</h4>
                <input type="email" placeholder="Your email...">
                <button>Subscribe</button>
            </div>
        </div>
    </footer>

    
    <script src="scripts/dropdown.js"></script>
    <script src="scripts/orderhistory.js"></script> <!-- Link to JavaScript file -->

</body>
</html>
