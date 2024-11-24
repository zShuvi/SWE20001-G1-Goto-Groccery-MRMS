<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }


// Include the database connection
include 'Database.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){

    $requestID = $_POST['requestID'];
    if(isset($_POST['approve']) || isset($_POST['reject'])){

        $productID = $_POST['productID'];
        $newQuantity = $_POST['newQuantity'];

    }
   

    if(isset($_POST['approve'])){

        // Approve: Update the product quantity and set request status to 'Approved'
        $sql = "UPDATE ProductTable SET Quantity = ? WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $newQuantity, $productID);
        $stmt->execute();
        $stmt->close();

        // Update request status
        $sql = "UPDATE ChangeRequestTable SET RequestStatus = 'Approved' WHERE RequestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $requestID);
        $stmt->execute();
        $stmt->close();

        $message = "Request approved.";

    }else if(isset($_POST['reject'])){

        // Reject: Just update the request status to 'Rejected'
        $sql = "UPDATE ChangeRequestTable SET RequestStatus = 'Rejected' WHERE RequestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $requestID);
        $stmt->execute();
        $stmt->close();

        $message = "Request rejected.";


    }else if(isset($_POST['delete'])){

        // Get the requestID from the form
        $requestID = $_POST['requestID'];

        // Prepare and execute the SQL query to delete the record
        $sql = "DELETE FROM ChangeRequestTable WHERE RequestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $requestID);

        if ($stmt->execute()) {
            $message = "Request deleted successfully!";
        } else {
            $message = "Error deleting request.";
        }

        $stmt->close();
    
    }
}






?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Notification Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Notification Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminnotification_style.css" rel="stylesheet">
</head>



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
        <div class="text">Notification</div>

        <div id="search-results" class="product-container">


                <?php 
                include 'Database.php'; // include the database connection

                $hasNotifcation = false;

                if($_SESSION['active_role'] == "JuniorAdmin" || $_SESSION['active_role'] == "SeniorAdmin"){
                    $status = "('Pending')";
                } else if($_SESSION['active_role'] == "Staff"){
                    $status = "('Approved', 'Rejected')";
                }
                
                    // Admin panel to view pending requests
                    $sql = "
                            SELECT RequestID, Username, OriginalQuantity, ProductID, NewQuantity, RequestStatus, RequestDate, Name, Image
                            FROM ChangeRequestTable
                            NATURAL JOIN ProductTable
                            WHERE RequestStatus IN $status
                    ";  

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        $hasNotifcation = true;

                        while($row = $result->fetch_assoc()) {

                            echo '
                                <div class="product-card">
                                    <img src="' . $row["Image"] . '" alt="' . $row["Name"] . '" onerror="this.onerror=null; this.src=\'images/Placeholder.png\';">

                                    <div class="product-info">
                                        <h3> '. $row["Name"] .' </h3>
                                        <p><strong>Original Quantity: </strong> '. $row['OriginalQuantity'] . '</p>
                                        <p><strong>Proposed Quantity: </strong> '. $row['NewQuantity'] . '</p>
                                        <p><strong>Status: </strong> 
                                            <span style="color: ' . (($row['RequestStatus'] == 'Approved') ? 'limegreen' : 'red') . ';">
                                                ' . $row['RequestStatus'] . '
                                            </span>
                                        </p>                                      
                                        <p><strong>Request Date: </strong> ' . $row['RequestDate'] . '</p>
                                    </div>';

                                if ($_SESSION['active_role'] == "JuniorAdmin" || $_SESSION['active_role'] == "SeniorAdmin"){             
                                    
                                    echo '
                                    <form method="POST" action="">
                                        <input type="hidden" name="requestID" value="' . $row["RequestID"] . '">
                                        <input type="hidden" name="productID" value="' . $row["ProductID"] . '">
                                        <input type="hidden" name="newQuantity" value="' . $row["NewQuantity"] . '">

                                        <input type="submit" class="submit-btn" name="approve" value="Approve"></input>
                                        <input type="submit" class="submit-btn" name="reject" value="Reject"></input>

                                    </form>';

                                }
                                
                                if (($_SESSION['active_role']) == "Staff"){

                                    echo '
                                    <form method="POST" action="">
                                        <input type="hidden" name="requestID" value="' . $row["RequestID"] . '">
                                        <button type="submit" class="ok-btn" name="delete" class="delete-btn">
                                            <span>&#10004;</span>
                                        </button>
                                    </form>';

                                }

                                echo '</div>';

                        }
                    } 


                // Section for Low Stock Notifications
                    $lowStockSql = "
                    SELECT ProductID, Name, Image, Quantity, Category
                    FROM ProductTable
                    WHERE Quantity < 10
                ";

                $lowStockResult = $conn->query($lowStockSql);

                if ($lowStockResult->num_rows > 0) {

                    $hasNotifcation = true;

                    echo '<h1 style="color: var(--text-color);">Low Stock Alerts</h1>';

                    while($lowStockRow = $lowStockResult->fetch_assoc()) {
                        echo '
                            <div class="product-card">
                                <img src="' . $lowStockRow["Image"] . '" alt="' . $lowStockRow["Name"] . '" onerror="this.onerror=null; this.src=\'images/Placeholder.png\';">
                                
                                <div class="product-info">
                                    <h3 style="color: var(--text-color); transition: var(--trans-05);" > '. $lowStockRow["Name"] .' </h3>
                                    <p><strong> Category: </strong>' . $lowStockRow["Category"] . ' </p>
                                    <p><strong> Quantity: </strong>' . $lowStockRow["Quantity"] . ' </p>
                                    <p style="color: orange;"><strong>Alert:</strong> Stock is below threshold!</p>
                                </div>
                                
                                    <a href="AdminStockOrder.php?showLowStock=true">
                                        <button class="ok-btn"> 
                                            <span>Order Stock</span>
                                        </button>
                                    </a>
                                
                            </div>';
                    }
                }



                if(!$hasNotifcation){

                    echo '
                    <div class="empty-notifications">
                        <p class="sad-smiley">☹</p>
                        <p>No Notifications.</p>
                    </div>
                    ';

                } 







                    
                $conn->close(); // close the database connection

                ?>

            </div>
    

    </section>


    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>


  
</body>



</html>
