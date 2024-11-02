<?php
session_start();
require_once 'Database.php'; 

// Initialize variables with fallback values
$username = "Unknown";
$phone = "Not provided"; 
$dob = "Not provided";    
$vouchers = []; // Initialize vouchers to an empty array

// Check if the user is logged in and has a valid session ID
if (isset($_SESSION['logged_in']))
{
    $userid = $_SESSION['active_user'];

    $query = "SELECT Username, PhoneNumber, DateOfBirth FROM UsersTable WHERE ID = ?";

    $sql = "SELECT * FROM userstable WHERE ID = '"."$userid"."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1)
    {
        while($row = $result->fetch_assoc())
        {
            $username = $row["Username"];
            $phonenumber = $row["PhoneNumber"];
            $dob = $row["DateOfBirth"];
        }
    }
        // Retrieve vouchers from database
    function fetchVouchers($conn, $isClaimed) {
        $query = "SELECT VoucherName, DiscountPercentage, ExpiryDate FROM VouchersTable WHERE IsClaimed = ?";
        $stmt = $conn->prepare($query);
            
        if ($stmt === false) {
            die("SQL prepare error: " . $conn->error);
        }
    
        $stmt->bind_param("i", $isClaimed);
            
        if (!$stmt->execute()) {
            die("Query execution failed: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        $vouchers = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        // Check if any vouchers were retrieved
        if (empty($vouchers)) {
            echo "No vouchers available.";
        }
    
        return $vouchers;
    }

    // Set default voucher view (Available vouchers)
    $isClaimed = 0;
    $vouchers = fetchVouchers($conn, $isClaimed);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="Goto Grocery Home Page">
    <meta name="keywords" content="Goto Grocery, Home">
    <meta name="author" content="G1">
    <title> Goto Grocery Admin Home Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="styles/Membership_style.css" rel="stylesheet">
    <style>

       
        .membership-table th, .membership-table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .membership-table th {
            background-color: #4CAF50; /* Green header */
            color: white;
        }

        h1 {
            margin: 20px 0;
        }
    </style>
</head>
<body>

<input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">

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

<main>
    <!--Fucked Area -->
    <h1>Membership Details</h1>
        <table class="membership-table">
            <tr>
                <th>Username:</th>
                <td><?php echo $username; ?></td>
            </tr>
            <tr>
                <th>Phone Number:</th>
                <td><?php echo $phone; ?></td> 
            </tr>
            <tr>
                <th>Date of Birth:</th>
                <td><?php echo $dob; ?></td> 
            </tr>
        </table>

     <!--Vouchers -->
     <h2>Vouchers</h2>
    <table class="voucher-table">
        <thead>
            <tr>
                <th>Voucher Name</th>
                <th>Discount (%)</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody id="voucherTableBody">
            <?php if (count($vouchers) > 0): ?>
                <?php foreach ($vouchers as $voucher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['VoucherName']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['DiscountPercentage']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['ExpiryDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No vouchers available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

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

<script src="scripts/slider.js"></script>
<script src="scripts/dropdown.js"></script>
<scripts src="scripts/MembershipScripts"> </scripts>
</body>
</html>
