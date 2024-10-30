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
        <label class="user">Aaron</label>
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
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="product1">
                                            <img src="images\AustraliaCarrot.jpg" alt="Australian carrot">
                                        </div>
                                        <div class="media-body">
                                            <p>Australian Carrot</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM4.00</h5>
                                </td>
                                <td>
                                    <div class="quantity-selector">
                                        <button type="button" onclick="decrement()">−</button>
                                        <input type="text" id="quantity" value="1" readonly>
                                        <button type="button" onclick="increment()">+</button>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM8.00</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="product2">
                                            <img src="images\Ayataka.webp" alt="Ayataka Green Tea">
                                        </div>
                                        <div class="media-body">
                                            <p>Ayataka Green Tea</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM5.00</h5>
                                </td>
                                <td>
                                    <div class="quantity-selector">
                                        <button type="button" onclick="decrement()">−</button>
                                        <input type="text" id="quantity" value="1" readonly>
                                        <button type="button" onclick="increment()">+</button>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM15.00</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="product3">
                                            <img src="images\Broccoli.webp" alt="Broccoli">
                                        </div>
                                        <div class="media-body">
                                            <p>Broccoli</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM4.30</h5>
                                </td>
                                <td>
                                    <div class="quantity-selector">
                                        <button type="button" onclick="decrement()">−</button>
                                        <input type="text" id="quantity" value="1" readonly>
                                        <button type="button" onclick="increment()">+</button>
                                    </div>
                                </td>
                                <td>
                                    <h5>RM4.30</h5>
                                </td>
                            </tr>
                            <tr class="bottom_button">
                                <td>
                                </td>

                                <td>
                                </td>

                                <td>
                                </td>

                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <input type="text" placeholder="Coupon Code">
                                        <a class="primary-btn" href="#">Apply</a>
                                        <a class="gray_btn" href="#">Close Coupon</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5>RM27.30</h5>
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
                                        <a class="gray_btn" href="#">Continue Shopping</a>
                                        <a class="primary-btn" href="#">Proceed to checkout</a>
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
    <script src="scripts/home.js"></script>
</body>



</html>
