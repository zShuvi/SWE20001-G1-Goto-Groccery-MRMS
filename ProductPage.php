<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store - Product Grid</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="ProductStyle.css">
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
</body>
</html>