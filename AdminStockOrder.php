<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }

    
?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Stock Ordering Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminstockorder_style.css" rel="stylesheet">
    <script defer src="scripts/adminstockorder.js"></script> <!-- Link to JavaScript file -->
</head>



<body>

    <!-- Navigation Sidebar -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">

                <span class="image">
                    <img src="images/admin.png" alt="logo">
                </span>


                <div class="text header-text">
                    <span class="name"><?php echo $_SESSION['active_username']; ?></span>
                    <span class="profession"><?php echo $_SESSION['active_role']; ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>

        </header>


        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                        <i class="bx bx-search icon"></i>
                        <input type="text" placeholder="Search.....">
                </li>

                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="AdminHome.php">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="AdminProduct.php">
                            <i class="bx bx-box icon"></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>

                    

                    <li class="nav-link">
                        <a href="AdminReport.php">
                            <i class="bx bxs-report icon"></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="AdminStockOrder.php">
                            <i class="bx bx-cart-add icon"></i>
                            <span class="text nav-text">Stock Ordering</span>
                        </a>
                    </li>


                    <li class="nav-link">
                        <a href="AdminNotification.php">
                            <i class="bx bx-bell icon"></i>
                            <span class="text nav-text">Notification</span>
                        </a>
                    </li>

                   
                    <li class="nav-link">
                        <a href="AdminProfile.php">
                            <i class="bx bxs-user-detail icon"></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>

                    <?php
                        if (!($_SESSION['active_role'] == "Staff")){
                            echo'
                                <li class="nav-link">
                                    <a href="AdminEditUser.php">
                                        <i class="bx bx-edit icon"></i>
                                        <span class="text nav-text">EditUser</span>
                                    </a>
                                </li>                            
                            ';
                        }
                    ?>
                </ul>
            </div>

            <div class="bottom-content">

                <li class="">
                    <a href="AdminLogin.php?logout=true">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>

                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>


        </div>
    </nav>

    <!-- Home, outside of Navigation Side Bar -->

    <section class="home">
        <div class="text">Stock Ordering</div>

        <div class="container_order">
            <div class="form-header">
                <h1>Order Stock</h1>
            </div>
    
            <!-- Search Bar -->
            <div class="form-group">
                <label for="search">Search for available stock</label>
                <input type="text" id="search" placeholder="Type to search..." oninput="searchStock()">
            </div>
    
            <!-- Search Results as product cards -->
            <div id="search-results" class="product-container"></div>
    
            <!-- Proceed Button to view order summary -->
            <button id="proceed-btn" class="submit-btn"  onclick="proceedToSummary()">Proceed to Confirmation</button>
        </div>
    
        <!-- Order Summary Modal -->
        <div id="order-summary-modal" class="modal">
            <div class="modal-content">
                <span class="go-back" onclick="closeModal()">&#8592;</span> <!-- Back arrow -->
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Order Summary</h2>
                <div id="order-summary"></div>
                <button class="submit-btn" onclick="confirmOrder()">Confirm Order</button>
            </div>
        </div>
    
       <!-- Final Confirmation Modal -->
       <div id="final-confirmation-modal" class="modal">
            <div class="modal-content">
                <!-- Go Back arrow icon (left aligned) -->
                <span class="go-back" onclick="goBackToSummary()">&#8592;</span> 
        
                <!-- Close button (right aligned) -->
                <span class="close" onclick="closeFinalModal(); closeModal()">&times;</span> 
        
                <!-- Title and content -->
                <h2>Order Confirmation</h2>
                <p id="final-confirmation-details"></p>
                <button class="submit-btn" onclick="submitOrder()">Place Order</button>
            </div>
        </div>
    </section>


    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>
  
</body>



</html>
