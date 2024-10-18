<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="ProductDetailsStyle.css">
</head>

<body>
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="#products">Products</a>
            <a href="#categories">Categories</a>
            <a href="#reviews">Reviews</a>
        </nav>

        <div class="icons">
            <div class="fa fa-bars" id="menu-btn"></div>
            <div class="fa fa-shopping-cart" id="cart-btn"></div>
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
                    </div>';
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
                echo "<h3 class='related-products-title'>People Also Search For</h3>"; // Using a class for styling
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
</body>
</html>
