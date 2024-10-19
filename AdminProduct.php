
<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }


// Include the database connection
include 'Database.php';


// UPDATE QUANTITY INTO DATABASE

// Check if a form has been submitted to update the quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID and new quantity from the POST request
    $productID = $_POST['productID'];
    $newQuantity = $_POST['quantity'];
    $role = $_SESSION['active_role'];
    $name = $_SESSION['active_username'];

    if ($role == "JuniorAdmin" || $role == "SeniorAdmin"){

        // Prepare and execute the SQL query to update the quantity
        $sql = "UPDATE ProductTable SET Quantity = ? WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $newQuantity, $productID);

        if ($stmt->execute()) {
            $message = "Quantity updated successfully!";
        } else {
            $message = "Error updating quantity.";
        }


        $stmt->close();

    } elseif ($role === 'Staff') {

        // Fetch the original quantity from ProductTable
        $sql = "SELECT Quantity FROM ProductTable WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $stmt->bind_result($originalQuantity);
        $stmt->fetch();
        $stmt->close();

        // Insert a change request for Staff users
        $sql = "INSERT INTO ChangeRequestTable (ProductID, Username, OriginalQuantity, NewQuantity, RequestStatus) VALUES (?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isii', $productID, $name, $originalQuantity, $newQuantity);

        if ($stmt->execute()) {
            $message = "Request sent to admin for approval!";
        } else {
            $message = "Error sending request.";
        }


        $stmt->close();
    } else {
        $message = "Unauthorized action.";
    }
    
}


// SEARCH FUNCTION - REQUIRED JAVASCRIPT

// Check if this is an AJAX request for searching
if (isset($_GET['search'])) {
    // Handle the search query
    $search = $conn->real_escape_string($_GET['search']);
    
    // SQL query to search products
    $sql = "SELECT * FROM ProductTable WHERE Name LIKE '%$search%' ORDER BY Name ASC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output search results as product cards
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="product-card">
                <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '" onerror="this.onerror=null; this.src=\'images/Placeholder.png\';">

                <div class="product-info">
                    <h3> '. $row["Name"] .' </h3>
                    <p><strong> Description: </strong>' . $row["Description"] . ' </p>
                    <p><strong> Category: </strong>' . $row["Category"] . ' </p>
                    <p><strong> Quantity: </strong>' . $row["Quantity"] . ' </p>
                 </div>

                            
                <form method="POST" action="">

                            
                <div class="quantity-control">
                    <input type="hidden" name="productID" value="' . $row["ProductID"] . '">
                    <input type="number" class="quantity_" id="quantity_' . $row["ProductID"] . '" name="quantity" value="' . $row["Quantity"] . '" min="0">
                </div>

                            

                <button type="submit" class="submit-btn">Update Quantity</button>

                </form>

            </div>';
        }
    } else {
        echo "No products found!";
    }
    $conn->close();
    exit;
}
?>








<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Products Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Product Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminproduct_style.css" rel="stylesheet">

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
        

        <div class="container_order">
            <div class="form-header">
                <h1>Product in Stock</h1>
            </div>
    
            <!-- Search Bar -->
            <div class="form-group">
                <?php
                    if(isset($message)){
                        echo "<p class='update-msg'> $message </p>";
                    }

                ?>

                <input type="text" id="search" placeholder="Type to search..." oninput="searchStock()">
            </div>
    
             <!-- Search Results as product cards -->
            <div id="search-results" class="product-container">
                <?php 
                include 'Database.php'; // include the database connection
                $sql = "SELECT * FROM ProductTable"; // get all products
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) { //Image not working//
                        echo '
                        <div class="product-card">
                            <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '" onerror="this.onerror=null; this.src=\'images/Placeholder.png\';">

                            <div class="product-info">
                                <h3> '. $row["Name"] .' </h3>
                                <p><strong> Description: </strong>' . $row["Description"] . ' </p>
                                <p><strong> Category: </strong>' . $row["Category"] . ' </p>
                                <p><strong> Quantity: </strong>' . $row["Quantity"] . ' </p>
                            </div>

                            
                            <form method="POST" action="">

                            
                            <div class="quantity-control">
                                <input type="hidden" name="productID" value="' . $row["ProductID"] . '">
                                <input type="number" class="quantity_" id="quantity_' . $row["ProductID"] . '" name="quantity" value="' . $row["Quantity"] . '" min="0">
                            </div>

                            

                            <button type="submit" class="submit-btn">Update Quantity</button>

                            </form>

                        </div>';
                    }
                } else {
                    echo "No products found!";
                }
                $conn->close(); // close the database connection
                ?>

            </div>
    
        </div>
    

    </section>


    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>
    <script src="scripts/adminproduct.js"></script>


  
</body>



</html>
