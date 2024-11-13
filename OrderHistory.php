<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Stock Ordering Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">  
	<link href="styles/orderhistory_style.css" rel="stylesheet">
    <script src="scripts\orderhistory.js"></script> <!-- Link to JavaScript file -->
</head>

<script type="text/javascript">
    var jsArray = {}; // Empty, will be filled by session cart data in JavaScript
</script>

<body>

    <header class="header">
        <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>

    <nav class="navbar">
        <a href="Home.html">home</a>
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
    </header>


    <!-- Home, outside of Navigation Side Bar -->

    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Home, outside of Navigation Side Bar -->
    <section class="home">
        <div class="container_order">
            <div class="form-header">
                <h1>Order History</h1>
            </div>
    

                <!-- Example Product Card -->
                <div class="product-card">
                    <img src="" alt="Receipt">

                    <div class="product-info">
                        <h3>Product Name</h3>
                        <p><strong>Purchased Date: </strong>Date will be written here</p>
                        <p><strong>Order Total: </strong>Total will be written here</p>
                    </div>

                    <form method="POST" action="">

                    <button type="submit" name="action" value="add" class="submit-btn" id="openModal">View Order History</button>

                    </form>

                </div>


                <div class="product-card">
                    <img src="" alt="Receipt">

                    <div class="product-info">
                        <h3>Product Name</h3>
                        <p><strong>Purchased Date: </strong>Date will be written here</p>
                        <p><strong>Order Total: </strong>Total will be written here</p>
                    </div>

                    <form method="POST" action="">

                    <button type="submit" name="action" value="add" class="submit-btn">View Order History</button>

                    </form>

                </div>


                <div class="product-card">
                    <img src="" alt="Receipt">

                    <div class="product-info">
                        <h3>Product Name</h3>
                        <p><strong>Purchased Date: </strong>Date will be written here</p>
                        <p><strong>Order Total: </strong>Total will be written here</p>
                    </div>

                    <form method="POST" action="">

                    <div class="popup" id="popup-1">
                        <div class="overlay"></div>
                        <div class="content">
                            <div class="close-btn" onclick="togglePopup()">&times;
                        </div>
                            <h1>Title</h1>
                            <p>Product goes here</p>
                        </div>
                    </div>

                    <button onclick="togglePopup()">View Order History</button>

                    </form>

                </div>


                <div class="product-card">
                    <img src="" alt="Receipt">

                    <div class="product-info">
                        <h3>Product Name</h3>
                        <p><strong>Purchased Date: </strong>Date will be written here</p>
                        <p><strong>Order Total: </strong>Total will be written here</p>
                    </div>

                    <form method="POST" action="">

                    <button type="submit" name="action" value="add" class="submit-btn">View Order History</button>

                    </form>

                </div>

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

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script src="scripts/home.js"></script>

</body>
</html>
