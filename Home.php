<?php
    session_start();
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
	<link href="styles/home_style.css" rel="stylesheet">
</head>



<body>
    <input type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">
    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#features">features</a>
        <a href="#products">products</a>
        <a href="#categories">categories</a>
        <a href="#reviews">reviews</a>
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


    <!-- Advertisement Slider -->
    <section class="slider" id="features">
        <div class="slides">
            <div class="slide current" style="background-image: url('images/Advertisement\ 1.jpg');">

            </div>
            <div class="slide" style="background-image: url('images/Advertisement\ 2.jpg');">

            </div>
            <div class="slide" style="background-image: url('images/Advertisement\ 3.jpg');">

            </div>
        </div>
        <div class="slider-controls">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
    </section>


    <!-- Featured Products -->
    <section class="featured-products" id="products">
        <h2 class="ribbon-header">Products</h2>
        <div class="products">
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Milk">
                <h3>Milk</h3>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Eggs">
                <h3>Eggs</h3>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Cheese">
                <h3>Cheese</h3>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Lunchly">
                <h3>Lunchly</h3>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Yogurt">
                <h3>Yogurt</h3>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="featured-categories" id="categories">
        <h2 class="ribbon-header">Shop by Categories</h2>
        <div class="categories">
            <div class="category">
                <img src="https://via.placeholder.com/150" alt="Fruits & Vegetables">
                <h3>Fruits & Vegetables</h3>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/150" alt="Dairy & Eggs">
                <h3>Dairy & Eggs</h3>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/150" alt="Snacks & Beverages">
                <h3>Snacks & Beverages</h3>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/150" alt="Frozen Foods">
                <h3>Frozen Foods</h3>
            </div>
            <div class="category">
                <img src="https://via.placeholder.com/150" alt="Pantry Staples">
                <h3>Pantry Staples</h3>
            </div>
        </div>
    </section>


    

    <!-- Reviews Section -->
    <section class="reviews" id="reviews">
        <h2 class="ribbon-header">Customer Reviews</h2>
        <div class="review-grid">
            <div class="review">
                <p>"This Website is so clean, it deserves a HD"</p>
                <span>★★★★★</span>
            </div>
            <div class="review">
                <p>"Quality Website, User-Friend UI. Everything is good"</p>
                <span>★★★★</span>
            </div>
            <div class="review">
                <p>"I like the delivery man. </p> <p>10/10 services"</p>
                <span>★★★★★</span>
            </div>
            <div class="review">
                <p>"This website is too good to be true"</p>
                <span>★★★★★★★★</span>
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

    <script src="scripts/home.js"></script>
</body>



</html>
