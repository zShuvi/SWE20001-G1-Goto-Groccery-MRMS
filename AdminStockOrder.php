<?php
// Start session and check if the user is logged in
session_start();

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    foreach ($data as $productID => $item) {
        // Update the session cart with the new quantity
        $_SESSION['Admin_Cart'][$productID]['quantity'] = (int)$item['quantity'];
        
        // Remove item from cart if quantity is zero
        if ($_SESSION['Admin_Cart'][$productID]['quantity'] <= 0) {
            unset($_SESSION['Admin_Cart'][$productID]);
        }
    }
    echo json_encode(["status" => "success"]);
    exit;
}

include 'Database.php';

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }


    function addToCart($productID, $quantity = 1) 
    {
        // Check if the item already exists in the cart
        if (isset($_SESSION['Admin_Cart'][$productID])) 
        {
            // If it exists, just update the quantity
            $_SESSION['Admin_Cart'][$productID]['quantity'] += $quantity;
        } 
        else 
        {
            // If it doesn't exist, add it to the cart
            $_SESSION['Admin_Cart'][$productID] = [
                'quantity' => $quantity,
            ];
        }
    }

    // Handle form submission for adding to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $productID = (int)$_POST['productID'];
        $quantity = (int)$_POST['quantity'];

        // Call the addToCart function to add the product to the session cart
        addToCart($productID, $quantity);
        

        // Redirect to avoid re-submitting on page refresh
        header("Location: AdminStockOrder.php?id=$productID&cart=added");
    }

    // Handle form submission for ordering stock and adding to database
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order']) && $_POST['place_order'] === 'ordered') {
        
        if(!empty($_SESSION["Admin_Cart"])){

            // Retrieve form data
            $userID = $_SESSION["active_user"]; // Sample user ID, you can modify this
            
            $cart = $_SESSION["Admin_Cart"];

            $date = date('Y-m-d');

            // Calculate total price from ProductTable
            $productData = [];

            foreach ($cart as $productID => $quantity) {
                // Fetch product price from ProductTable
                $productQuery = "SELECT * FROM ProductTable WHERE ProductID = $productID";
                $result = $conn->query($productQuery);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $currentQuantity = $row['Quantity'];
                    $productPrice = (float)$row['Price'];
                    $quantity = $quantity['quantity'];
        
                    // Store product info for later insertion
                    $productData[] = [
                        'id' => $productID,
                        'price' => $productPrice,
                        'quantity' => $quantity
                    ];

                    $newQuantity = $currentQuantity + $quantity;
                    $updateQuantitySQL = "UPDATE ProductTable SET Quantity = $newQuantity WHERE ProductID = $productID";
                    $conn->query($updateQuantitySQL);

                } else {
                    echo "Product with ID $productID not found.";
                    exit;
                }

                // Update OrderStockHistory 
                $HistoryInsertSQL = "INSERT INTO StockOrderHistory (ProductID, Quantity, OrderDate) VALUES ($productID, $quantity, '$date') ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)";
                $conn->query($HistoryInsertSQL);

            }

            $_SESSION["Admin_Cart"] = []; //fully remove item from cart

        } else {
            echo "
            <script>
                alert('Cart is empty, no stock ordered');
                window.location.href = 'AdminStockOrder.php';
            </script>";

        }
    }


    // SEARCH FUNCTION - REQUIRED JAVASCRIPT

// Check if this is an AJAX request for searching
if (isset($_GET['search'])) {
    // Handle the search query
    $search = $conn->real_escape_string($_GET['search']);
    
    // SQL query to search products
    if ($search === "lowstock") {
        // Fetch all low stock products
        $sql = "SELECT * FROM ProductTable WHERE Quantity <= 10 ORDER BY Name ASC";
    } else {
        // Perform a regular search
        $sql = "SELECT * FROM ProductTable WHERE Name LIKE '%$search%' OR Category LIKE '%$search%' OR ProductID LIKE '%$search%' ORDER BY Name ASC";
    }
    
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
                                <input type="number" class="quantity_" id="quantity_' . $row["ProductID"] . '" name="quantity" value="1" min="1">
                            </div>

                            

                            <button type="submit" name="action" value="add" class="submit-btn">Add to Cart</button>

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
	<meta name="description" content="Goto Grocery Admin Stock Ordering Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminstockorder_style.css" rel="stylesheet">
    <script defer src="scripts/adminstockorder.js"></script> <!-- Link to JavaScript file -->
</head>

<script type="text/javascript">
    var jsArray = <?php echo json_encode($_SESSION["Admin_Cart"]) ?>
</script>


<body>

    <!-- Navigation Sidebar -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">

                <span class="image">
                    <img src=<?php echo $_SESSION["profile_picture"]; ?> alt="Profile Picture" onerror="this.src='images/admin.png';">
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
            <div id="search-results" class="product-container">

            <?php 
                include 'Database.php'; // include the database connection
                $sql = "SELECT * FROM ProductTable"; // get all products
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
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
                                <input type="number" class="quantity_" id="quantity_' . $row["ProductID"] . '" name="quantity" value="1" min="1">
                            </div>

                            

                            <button type="submit" name="action" value="add" class="submit-btn">Add to Cart</button>

                            </form>

                        </div>';
                    }
                } else {
                    echo "No products found!";
                }
                $conn->close(); // close the database connection
            ?>

            </div>
    
            <!-- Proceed Button to view order summary -->
            <button id="proceed-btn" class="submit-btn"  onclick="proceedToSummary()">Proceed to Confirmation</button>
        </div>
    
        <!-- Order Summary Modal -->
        <div id="order-summary-modal" class="modal">
            <div class="modal-content">
                <span class="go-back" onclick="closeModal()">&#8592;</span> <!-- Back arrow -->
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Order Summary</h2>
                <div id="order-summary">
                    <?php

                        include 'Database.php';



                        // Check if the cart is set and is not empty
                        if (isset($_SESSION['Admin_Cart']) && !empty($_SESSION['Admin_Cart'])) {


                            foreach ($_SESSION['Admin_Cart'] as $productID => $item) {


                                $sql = "SELECT * FROM ProductTable WHERE ProductID = $productID";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) { 

                                        echo '
                                            <div class="product-card">
                                                <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '">
                                                
                                                <div class="product-info">
                                                    <h4>' . $row["Name"] . '</h4>
                                                    <p>Current Quantity: ' . $row["Quantity"] . '</p>
                                                </div>

                                                <div class="quantity-input">
                                                    <input type="number" min="0" value="' . htmlspecialchars($item['quantity']) . '" onchange="updateQuantity(' . $productID . ', this.value)"></input>
                                                </div>

                                            </div>
                                            
                                        ';
                                    }
                                }
                            }
                        } else {
                            echo "<p>No Items in the cart.</p>";
                        }

                    ?>

                </div>
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
                <p id="final-confirmation-details">
                <?php

                    include 'Database.php';

                    // Check if the cart is set and is not empty
                    if (isset($_SESSION['Admin_Cart']) && !empty($_SESSION['Admin_Cart'])) {


                        foreach ($_SESSION['Admin_Cart'] as $productID => $item) {


                            $sql = "SELECT * FROM ProductTable WHERE ProductID = $productID";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) { 


                                    echo '
                                        <p class="product' . $row["ProductID"] . '">
                                            <span class="name"> ' . $row["Name"] . ' </span> x<span class="quantity">0</span> unit
                                        </p>
                                        
                                    ';
                                }
                            }
                        }
                    } else {
                        echo "<p>No Items in the cart.</p>";
                    }

                    ?>
                </p>
                <form method="POST" action="">
                    <button class="submit-btn" type="submit" name="place_order" value="ordered">Place Order</button>
                </form>
            </div>
        </div>
    </section>


    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>
  
</body>



</html>
