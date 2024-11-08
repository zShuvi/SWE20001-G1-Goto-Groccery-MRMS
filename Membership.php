<?php
session_start();
require_once 'Database.php'; 

// Initialize variables with fallback values
$username = "Unknown";
$phonenumber = "Not provided"; 
$dob = "Not provided";    
$points = 0; // Initialize points to 0
$vouchers = []; // Initialize vouchers to an empty array

// Check if the user is logged in and has a valid session ID
if (isset($_SESSION['logged_in'])) {
    $userid = $_SESSION['active_user'];

    // Retrieve user details including points
    $query = "SELECT Username, PhoneNumber, DateOfBirth, Points FROM UsersTable WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row["Username"];
        $phonenumber = $row["PhoneNumber"];
        $dob = $row["DateOfBirth"];
        $points = $row["Points"]; // Fetch user points
    }
    $stmt->close();

    // Retrieve vouchers from the database
    function fetchVouchers($conn, $isClaimed) {
        $query = "SELECT VoucherID, VoucherName, DiscountPercentage, ExpiryDate, ReqPoints FROM VouchersTable WHERE IsClaimed = ?";
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

        return $vouchers;
    }

    // Function to redeem a voucher
    function redeemVoucher($conn) {
        $activeuser = $_SESSION["active_user"];
        $voucherid = $_POST["voucherid"];

        // Fetch user points
        $sql = "SELECT Points FROM UsersTable WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $activeuser);
        $stmt->execute();
        $result = $stmt->get_result();
        $userpoints = $result->fetch_assoc()['Points'];
        $stmt->close();

        // Fetch voucher point cost
        $sql = "SELECT ReqPoints FROM VouchersTable WHERE VoucherID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $voucherid);
        $stmt->execute();
        $result = $stmt->get_result();
        $voucherprice = $result->fetch_assoc()['ReqPoints'];
        $stmt->close();

        // Check if user has enough points
        if ($userpoints >= $voucherprice) {
            $newpoints = $userpoints - $voucherprice;

            // Update user points
            $sql = "UPDATE UsersTable SET Points = ? WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $newpoints, $activeuser);
            if (!$stmt->execute()) {
                $_SESSION['error'] = "Error updating points.";
                return false;
            }
            $stmt->close();

            // Insert into VoucherOwn table to record voucher claim
            $sql = "INSERT INTO VoucherOwn (User_ID, Voucher_ID) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $activeuser, $voucherid);
            if (!$stmt->execute()) {
                $_SESSION['error'] = "Error claiming voucher.";
                return false;
            }
            $stmt->close();

            $_SESSION['success'] = "Voucher claimed successfully!";
            return true;
        } else {
            $_SESSION["error"] = "Insufficient points to claim this voucher.";
            return false;
        }
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
</head>
<body>

<input style="display: none" type="hidden" name="sessionLoggedIn" id="sessionLoggedIn" value="<?php echo $_SESSION['logged_in'] ?>">

<header class="header">
    <a href="#" class="logo"> <i class="fa fa-shopping-basket"></i> Goto Grocery </a>
    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="Home.php#features">features</a>
        <a href="Product.php">products</a>
        <a href="Home.php#reviews">reviews</a>
    </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn"></div>
        <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
    </div>
</header>

<main> 
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Membership Details Section -->
    <h1 class="center-text">Filler</h1> <!-- For some reason this doesn't show, too lazy to fix this so just leave it here -->
    <h1 class="center-text">Membership Details</h1> 
    <table class="membership-table">
        <tr>
            <th>Username:</th>
            <td><?php echo htmlspecialchars($username); ?></td>
        </tr>
        <tr>
            <th>Phone Number:</th>
            <td><?php echo htmlspecialchars($phonenumber); ?></td>
        </tr>
        <tr>
            <th>Date of Birth:</th>
            <td><?php echo htmlspecialchars($dob); ?></td>
        </tr>
        <tr>
            <th>Points:</th>
            <td><?php echo htmlspecialchars($points); ?></td>
        </tr>
    </table>

    <h1 class="center-text">Available Vouchers</h1>
    <table class="voucher-table">
        <thead>
            <tr>
                <th>Voucher Name</th>
                <th>Discount (%)</th>
                <th>Expiry Date</th>
                <th>Point Cost</th>
                <th>Action</th> <!-- Claim button -->
            </tr>
        </thead>
        <tbody id="voucherTableBody">
            <?php if (!empty($vouchers)): ?>
                <?php foreach ($vouchers as $voucher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['VoucherName']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['DiscountPercentage']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['ExpiryDate']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['ReqPoints']); ?></td>
                        <td>
                            <?php if (!isset($isOwned) || !$isOwned): ?>
                                <button type="button" class="claim-button" onclick="showPopup(<?php echo htmlspecialchars($voucher['VoucherID']); ?>, '<?php echo htmlspecialchars($voucher['VoucherName']); ?>')">Claim</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No vouchers available.</td>
                </tr>
            <?php endif; ?>
        </tbody> 
    </table>
</main>

<!-- Dark overlay -->
<div id="overlay" class="overlay"></div>

<!-- Claim Success Popup -->
<div id="claimPopup" class="popup">
    <span id="closePopup" class="close-popup">&times;</span>
    <h2>Claim Your Voucher</h2>
    <p id="voucherClaimMessage">You’re about to claim the voucher: "<span id="voucherName"></span>"!</p> <!-- Placeholder for voucher name -->
    <button id="confirmClaimButton" class="claim-button">Confirm Claim</button>
    <button id="cancelButton" class="cancel-button">Cancel</button> <!-- New Cancel Button -->
</div>

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
<script src="scripts/MembershipScripts.js"></script>
</body>
</html>