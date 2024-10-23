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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Grid</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/ProductStyle.css">
</head>

<body>
<input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">
    <header class="header">
            <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <nav class="navbar">
            <a href="Home.php">Home</a>
            <a href="Home.php#features">Features</a>
            <a href="ProductPage.php">Products</a>
            <a href="Home.php#categories">Categories</a>
            <a href="Home.php#reviews">Reviews</a>
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
        <!-- <label><?php echo $_SESSION["active_username"]?></label> --> <!-- display name in navbar -->
    </header>

    <div class="container">
    <h2 class="ribbon-header">Products</h2>
        <div class="product-grid">

            <?php 
            include 'Database.php'; // include the database connection
            $sql = "SELECT * FROM ProductTable"; // get all products
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) { 
                    echo '
                    <div class="product">  
                        <a href="ProductDetails.php?id=' . $row["ProductID"] . '">
                            <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                            <h2>' . $row["Name"] . '</h2>
                            <p class="price">RM' . $row["Price"] . '</p>
                        </a>
                    </div>';
                }
            } else {
                echo "No products found!";
            }
            $conn->close(); // close the database connection
            ?>
        </div>
    </div>

    <footer> <!-- not showing -->
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

    <script src="scripts/home.js"></script>

</body>
</html>