<?php
session_start();
require_once 'Database.php';

$userID = $_SESSION['active_user'] ?? 0; // Get the active user ID

// Retrieve claimed vouchers for the user
$sql = "SELECT v.VoucherName, v.DiscountPercentage, v.ExpiryDate, vo.VoucherCode, vo.Used
        FROM VoucherOwn vo 
        JOIN VouchersTable v ON vo.Voucher_ID = v.VoucherID 
        WHERE vo.User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$claimedVouchers = [];
while ($row = $result->fetch_assoc()) {
    $claimedVouchers[] = $row;
}

$stmt->close();
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
            <a href="Home.php">Home</a>
            <a href="Home.php#features">Features</a>
            <a href="Product.php">Products</a>
            <a href="Home.php#reviews">Reviews</a>
            <a href="OrderHistory.php">Order History</a>
        </nav>

    <div class="icons">
        <div class="fa fa-bars" id="menu-btn">
            <ul class="dropdown-content">
                <li><a href="Home.php">Home</a></li>
                <li><a href="Product.php">Products</a></li>
                <li><a href="OrderHistory.php">Order History</a></li>
            </ul>
        </div>
        <div class="fa fa-shopping-cart" id="cart-btn" onclick="window.location.href='CheckoutPage.php'"></div>
        <div class="fa fa-user" id="user-btn">
            <ul id="dropdownList" class="dropdown-content">
                <!-- Content will be populated by JavaScript -->
            </ul>
        </div>
    </div>
</header>

    <h1 class="center-text">Filler</h1> <!-- For some reason this doesn't show, too lazy to fix this so just leave it here -->
    <h1 class="center-text">Claimed Vouchers</h1>
    <main style="min-height: 80vh;">
        <table class="voucher-table">
            <thead>
                <tr>
                    <th>Voucher Name</th>
                    <th>Discount (%)</th>
                    <th>Expiry Date</th>
                    <th>Voucher Code</th>
                    <th>Used</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($claimedVouchers)): ?>
                <?php foreach ($claimedVouchers as $voucher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['VoucherName']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['DiscountPercentage']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['ExpiryDate']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['VoucherCode']); ?></td>
                        <td><?php if($voucher['Used'] == 1){echo "Used";}else{echo "Not Used";}; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No claimed vouchers available.</td>
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
<script src="scripts/MembershipScripts.js"></script>
</body>
</html>