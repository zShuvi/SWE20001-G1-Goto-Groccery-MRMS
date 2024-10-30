<?php
    session_start();

    // Needed this, cause if the variable is unset, it sometimes pop up long error message
    // Which causes the entire html display to shift sometimes.
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = 0;
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="Goto Grocery Home Page">
    <meta name="keywords" content="Goto Grocery, Home">
    <meta name="author" content="G1">
    <title>Goto Grocery Admin Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="styles/home_style.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="Home.php#features">features</a>
            <a href="Product.php">products</a>
            <a href="Home.php#reviews">reviews</a>
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

    <!-- Split-screen options -->
    <div class="split-screen">
        <div class="option search" id="search-option">
            <a href="ProductPage.php"><h2>Search All Products</h2></a>
        </div>
        <div class="option sort" id="sort-option" onclick="openCategoryPopup()">
            <h2>Sort By Category</h2>
        </div>
    </div>

<!-- Popup Modal for Categories -->
<div id="categoryPopup" class="popup-modal">
    <div class="popup-content">
        <span class="close-btn" onclick="closeCategoryPopup()">&times;</span>
        <h3>Select Category</h3>
        <ul class="category-list">
            <a href="ShopByCategoryPage.php?category=Fruit,Vegetable">
                <li>Fruits & Vegetables</li>
            </a>
            <a href="ShopByCategoryPage.php?category=Dairy">
                <li>Dairy & Eggs</li>
            </a>
            <a href="ShopByCategoryPage.php?category=Snacks,Beverage">
                <li>Snacks & Beverages</li>
            </a>
            <a href="ShopByCategoryPage.php?category=FrozenFood">
                <li>Frozen Foods</li>
            </a>
            <a href="ShopByCategoryPage.php?category=PantryStaple">
                <li>Pantry Staples</li>
            </a>
        </ul>
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
                <h4>Subscribe to Our Newsletter</h4>
                <input type="email" placeholder="Your email...">
                <button>Subscribe</button>
            </div>
        </div>
    </footer>

    <script src="scripts/slider.js"></script>
    <script src="scripts/dropdown.js"></script>
    <script src="scripts/CategoryPopup.js"></script>
</body>
</html>

