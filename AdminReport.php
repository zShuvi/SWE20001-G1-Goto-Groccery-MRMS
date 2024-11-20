<?php
session_start();
include "Database.php";

// Start session and check if the user is logged in
if ($_SESSION['logged_in'] == false) {
    header("Location: AdminLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="Goto Grocery Admin Reports Page">
    <meta name="keywords" content="Goto Grocery, Admin">
    <meta name="author" content="G1">
    <title>Goto Grocery Admin Home Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="styles/adminreport_style.css" rel="stylesheet">
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
                        if (!($_SESSION['active_role'] == "Staff")) {
                            echo'
                                <li class="nav-link">
                                    <a href="AdminEditUser.php">
                                        <i class="bx bx-edit icon"></i>
                                        <span class="text nav-text">Edit User</span>
                                    </a>
                                </li>
                            ';
                        }
                    ?>
                </ul>
            </div>

            <div class="bottom-content <?php echo $_SESSION['active_role']; ?>">

                <li class="log">
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

    <!-- Home, outside of Navigation Sidebar -->
    <section class="home">
        <div class="text">Reports</div>

        <div class="container">
            <div class="box">
                <p class="text">Sales Report</p>
                <img src="images/Sales.png" alt="Image 1">
                <p></p>
                <button id="generateSalesReportBtn">Generate</button>
            </div>
            <div class="box">
                <p class="text">Stock Report</p>
                <img src="images/Stock.png" alt="Image 2">
                <p></p>
                <button id="generateStockReportBtn">Generate</button>
            </div>
            <div class="box">
                <p class="text">Customer Report</p>
                <img src="images/Customer.png" alt="Image 3">
                <p></p>
                <button id="generateCustomerReportBtn">Generate</button>
            </div>
        </div>
    </section>

    <!-- Sales Report Popup -->
    <div id="salesReportPopup" style="display: none;" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeSalesPopup()">&times;</span>
            <h2>Sales Report</h2>
            <form id="salesReportForm" action="DownloadReport.php" method="POST">
                <label for="salesReportOption">Select Timeframe:</label>
                <select id="salesReportOption" name="salesReportOption" required>
                    <option value="daily">Daily</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>

                <div id="dateInput" style="display:none;">
                    <label for="dailyDate">Date:</label>
                    <input type="date" id="dailyDate" name="dailyDate" value="<?php echo date('Y-m-d') ?>">
                </div>

                <div id="monthInputSales" style="display:none;">
                    <label for="monthlyMonth">Month:</label>
                    <input type="month" id="monthlyMonth" name="monthlyMonth" value="<?php echo date('Y-m') ?>">
                </div>

                <div id="yearInput" style="display:none;">
                    <label for="yearlyYear">Year:</label>
                    <input type="number" id="yearlyYear" name="yearlyYear" min="2000" max="2100" value="<?php echo date('Y'); ?>">
                </div>
                
                <button type="submit">Download Report</button>
            </form>
        </div>
    </div>

    <!-- Stock Report Popup -->
    <div id="stockReportPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeStockPopup()">&times;</span>
            <h2>Stock Report</h2>
            <form id="stockReportForm" action="DownloadReport.php" method="POST">
                <label for="stockReportOption">Choose Report Type:</label>
                <select id="stockReportOption" name="reportType" required>
                    <option value="top5MostRestock">Top 5 Most Restocked</option>
                    <option value="top5LeastRestock">Top 5 Least Restocked</option>
                    <option value="productSoldInMonth">Products Sold in Month</option>
                </select>

                <div id="monthInputStock" style="display:none;">
                    <label for="calendarInput">Select Month:</label>
                    <input type="month" id="calendarInput" name="monthInputStock" value="<?php echo date('Y-m') ?>">
                </div>

                <button type="submit">Download Report</button>
                <button type="button" onclick="closeStockPopup()">Close</button>
            </form>
        </div>
    </div>

    <!-- Customer Report Popup -->
    <div id="customerReportPopup" class="popup" style="display:none;">
        <div class="popup-content">
            <span class="close" onclick="closeCustomerPopup()">&times;</span>
            <h2>Generate Customer Report</h2>
            <form id="customerReportForm" action="DownloadReport.php" method="POST">
                <label for="customerReportOption">Choose Report Type:</label><br>
                <select id="customerReportOption" name="reportType" required>
                    <option value="favItem">Top 5 Customer's Favourite Item</option>
                    <option value="allMembers">All Members</option>
                    <option value="topSpending">Top 5 Spending Customers</option>
                </select><br><br>
                <button type="submit">Download Report</button>
                <button type="button" onclick="closeCustomerPopup()">Close</button>
            </form>
        </div>
    </div>

    <!-- Scripts for Popups -->
    <script src="scripts/adminsidebar.js"></script>
    <script src="scripts/AdminSalesReport.js"></script>
    <script src="scripts/AdminStockReport.js"></script>
    <script src="scripts/AdminCustomerReport.js"></script>
</body>
</html>
