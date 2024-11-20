<?php

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }

    include 'functions/Cart.php';

    // Handle form submission for adding to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $productID = (int)$_POST['productID'];
        $quantity = (int)$_POST['quantity'];

        // Call the addToCart function to add the product to the session cart
        addToCart($productID, $quantity);

        // Redirect to avoid re-submitting on page refresh
        header("Location: ProductDetails.php?id=$productID&cart=added");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/ProductDetailsStyle.css">
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
    </header>

    <div class="container">
    <div class="product">
        <?php
        include 'Database.php'; // include the database connection
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Ensure $productId is valid
        if ($productId > 0) {
            $sql = "SELECT * FROM ProductTable WHERE ProductID = $productId";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // output each data for every product
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                    <div class="product-details">
                        <h2>' . $row["Name"] . '</h2>
                        <p class="price">RM' . $row["Price"] . '</p>
                        <p class="description">' . $row["Description"] . '</p>
                        <p class="description"> Available Quantity: ' . $row["Quantity"] . '<p>
                    </div>
                       <div class="quantity-container">
                            <form action="#" method="POST">
                            <div class="quantity-controls">
                                <button type="button" class="decrement" onclick="decreaseQuantity()">-</button>
                                <input type="number" name="quantity" class="quantity" value="1" min="1" max="'. $row["Quantity"] .'">
                                <button type="button" class="increment" onclick="increaseQuantity()">+</button>
                            </div>
                            
                                <input type="hidden" name="productID" value="'. $row["ProductID"] .'"> <!-- Product ID from PHP -->
                                <button type="submit" name="action" value="add" class="add-to-cart">Add to Cart</button>
                            </form>
                        </div>
                        
                        

                    ';
                }
            } else {
                echo "Product not found!";
            }
        } else {
            echo "No product selected!";
        }
        ?>

    </div>

    <!-- New container for related products -->
    <div class="related-products-section">
        <?php
        // Fetch related products
        if ($productId > 0) {
            $sql = "SELECT ProductID, Name, Image, Price FROM ProductTable WHERE ProductID != $productId ORDER BY RAND() LIMIT 4";
            $result = $conn->query($sql);

            if (!$result) {
                echo "Error in query: " . $conn->error; // Debugging the SQL error
            } elseif ($result->num_rows > 0) {
                echo "<h3 class='related-products-title'> Other Products </h3>"; // Using a class for styling
                echo "<div class='related-products-container'>";
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <div class='related-product'>
                            <a href='ProductDetails.php?id=" . $row['ProductID'] . "'>
                                <img src='" . $row['Image'] . "' alt='" . $row['Name'] . "'>
                                <h4>" . $row['Name'] . "</h4>
                                <p>RM" . number_format($row['Price'], 2) . "</p>
                            </a>
                        </div>
                    ";
                }
                echo "</div>";
            } else {
                echo "No related products found.";
            }
        }
        ?>
    </div>
</div>

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
                <h4>Subscribe To Our Newsletter</h4>
                <input type="email" placeholder="Your Email...">
                <button>Subscribe</button>
            </div>
        </div>
    </footer>
    <script src="scripts/dropdown.js"></script>
    <script src="scripts/quantity_changer.js"></script>
</body>
</html>
