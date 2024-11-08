<?php

    include "functions/Cart.php";

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }


    include 'Database.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["voucher_code"]) && !empty($_POST["voucher_code"])) {

        $voucher = $_POST["voucher_code"];
        $_SESSION["voucher"] = $voucher;
        $userID = $_SESSION["active_user"];
        

        $sql = "SELECT v.DiscountPercentage, v.VoucherID FROM VoucherOwn vo JOIN VouchersTable v ON vo.Voucher_ID = v.VoucherID WHERE vo.User_ID = '$userID' AND vo.VoucherCode = '$voucher' AND vo.Used = 0";

        $result = mysqli_query($conn, $sql);

        // Check if we have a result
        if (mysqli_num_rows($result) > 0) {
            // Fetch the discount percentage
            $row = mysqli_fetch_assoc($result);
            $discountPercentage = $row['DiscountPercentage'];
            $_SESSION["discount_percentage"] = $discountPercentage;
            $_SESSION["voucher_id"] = $row["VoucherID"];

            // Use the discount percentage as needed
            $error = "Voucher Applied: " . $discountPercentage . "% Discount";
        } else {
            // No match found (invalid voucher or voucher does not belong to this user)
            $error = "Voucher not found or have been used";
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset"])) {

        unset($voucher);
        unset($_SESSION["voucher"]);
        unset($discountPercentage);
        unset($_SESSION["discount_percentage"]);
        unset($_SESSION["voucher_id"]);

    }

?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Home Page">
	<meta name="keywords" content="Goto Grocery, Home" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="styles\checkoutpage_style.css" rel="stylesheet">
</head>



<body>
<input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <nav class="navbar">
            <a href="Home.php">Home</a>
            <a href="Home.php#features">Features</a>
            <a href="Product.php">Products</a>
            <a href="Home.php#reviews">Reviews</a>
        </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn"></div>
        <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
    </div>
    </header>


    <!-- Home, outside of Navigation Side Bar -->

    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <div class="Title">
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                       

                            <?php

                            include 'Database.php';

                            $total_product_amount = 0;
                            $total_receipt_amount = 0;


                            // Check if the cart is set and is not empty
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                                $stylenum = 0;

                                foreach ($_SESSION['cart'] as $productID => $item) {

                                    $stylenum += 1;


                                    $sql = "SELECT * FROM ProductTable WHERE ProductID = $productID";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) { 

                                            if($item['quantity'] > $row["Quantity"]){
                                                $item['quantity'] = $row["Quantity"];
                                            }

                                            $total_product_amount = $row["Price"] * $item['quantity'];
                                            $total_receipt_amount += $total_product_amount;

                                            echo '
                                                <tr>
                                                    <td>
                                                        <div class="media">
                                                            <div class="product'. $stylenum .'">
                                                                <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                                                            </div>
                                                            <div class="media-body">
                                                                <p>' . $row["Name"] . '</p>
                                                                <p>Available Quantity: ' . $row["Quantity"] . '</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5>RM: ' . $row["Price"] . '</h5>
                                                    </td>
                                                    <td>
                                                        <div class="quantity-selector">
                                                            <button type="button" onclick="decreaseQuantity(this)">-</button>
                                                            <input type="text" class="quantity" id="' . $productID . '" min="1" max="'. $row["Quantity"] .'" value="'. $item['quantity'] .'" readonly>
                                                            <button type="button" onclick="increaseQuantity(this)">+</button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 style="white-space: nowrap;">RM: ' . number_format($total_product_amount, 2) . '</h5>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    }
                                }
                            } 

                            // Apply the discount
                            if (isset($discountPercentage)){
                                $total_receipt_amount = $total_receipt_amount * ((100 - $discountPercentage)/100);
                            }

                            ?>
                            

                            <tr class="bottom_button">
                                <td>
                                </td>

                                <td>
                                </td>

                                <td>
                                </td>

                                <td>
                                
                                
                                    <form method="POST" action="">
                                        <div class="cupon_text d-flex align-items-center">
                                            <input type="text" name="voucher_code" placeholder=<?php if(isset($voucher)){echo $voucher;}else{echo "Voucher Code";} ?>>
                                            <button class="primary-btn" type="submit" >Apply</button>
                                            <button class="gray_btn" type="submit" name="reset">Close Coupon</button>
                                        </div>
                                    </form>
                                    <div class="cupon_text d-flex align-items-center">
                                        <a class="voucher_msg" ><?php if(isset($error)){echo $error;} ?></a>
                                    </div>
                                </td>
                            </tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5 style="white-space: nowrap;">RM: <?php echo number_format($total_receipt_amount, 2) ?></h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="ProductPage.php">Continue Shopping</a>
                                        <a class="primary-btn" href="PaymentPage.php">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    
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

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script src="scripts/dropdown.js"></script>
    <script src="scripts/quantity_changer2.js"></script>
</body>



</html>