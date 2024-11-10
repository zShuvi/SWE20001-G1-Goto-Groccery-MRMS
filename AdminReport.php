<?php
ob_start();
session_start();
include "Database.php";
// Start session and check if the user is logged in

    if (($_SESSION['logged_in']) == false) {
        header("Location: AdminLogin.php");
        exit;
    }

    require_once 'functions/Download.php';

    // Process Sales Report Form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salesReportOption'])) 
    {
        $timeframe = $_POST['salesReportOption'];
        $formtype = $_POST['reportType'];

        if ($timeframe === 'daily') 
        {
            $reportDate = $_POST['dailyDate']; 

            if ($formtype === 'TotalSales')
            {
                $sql = "SELECT SUM(TotalPrice) AS Total_Earnings FROM ReceiptTable WHERE Date = '$reportDate'";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Total_Earnings']];
                    }
                    $titleArray = ['Total_Earnings'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportDate Total Earnings",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            elseif ($formtype === 'PopularItems')
            {
                $sql = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold 
                        FROM ReceiptItemTable AS ri
                        JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                        JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                        WHERE r.Date = '$reportDate'
                        GROUP BY p.Name
                        ORDER BY Total_Sold DESC
                        LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Name'], $row['Total_Sold']];
                    }
                    $titleArray = ['Name', 'Total_Sold'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportDate Popular Items",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            else 
            {
                $_SESSION['error'] = "No form type selected";
            }
        } 

        elseif ($timeframe === 'monthly') 
        {
            $reportMonth = $_POST['monthlyMonth'];
            list($year, $month) = explode('-', $reportMonth);

            if ($formtype === 'TotalSales')
            {
                $sql = "SELECT SUM(TotalPrice) AS Total_Earnings FROM ReceiptTable WHERE YEAR(Date) = '$year' AND MONTH(Date) = '$month'";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Total_Earnings']];
                    }
                    $titleArray = ['Total_Earnings'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportMonth Total Earnings",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            elseif ($formtype === 'PopularItems')
            {
                $sql = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold 
                        FROM ReceiptItemTable AS ri
                        JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                        JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                        WHERE WHERE YEAR(r.Date) = '$year' AND MONTH(r.Date) = '$month'
                        GROUP BY p.Name
                        ORDER BY Total_Sold DESC
                        LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Name'], $row['Total_Sold']];
                    }
                    $titleArray = ['Name', 'Total_Sold'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportMonth Popular Items",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            else 
            {
                $_SESSION['error'] = "No form type selected";
            }
        } 

        elseif ($timeframe === 'yearly') 
        {
            $reportYear = $_POST['yearlyYear']; 

            if ($formtype === 'TotalSales')
            {
                $sql = "SELECT SUM(TotalPrice) AS Total_Earnings FROM ReceiptTable WHERE YEAR(Date) = '$reportYear'";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Total_Earnings']];
                    }
                    $titleArray = ['Total_Earnings'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportYear Total Earnings",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            elseif ($formtype === 'PopularItems')
            {
                $sql = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold 
                        FROM ReceiptItemTable AS ri
                        JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                        JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                        WHERE WHERE YEAR(r.Date) = '$reportYear'
                        GROUP BY p.Name
                        ORDER BY Total_Sold DESC
                        LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0)
                {
                    $formattedData = [];

                    foreach ($result as $row) 
                    {
                        $formattedData[] = [$row['Name'], $row['Total_Sold']];
                    }
                    $titleArray = ['Name', 'Total_Sold'];
                    array_unshift($formattedData, $titleArray);
                
                    ob_end_clean();
                    downloadCSV("$reportYear Popular Items",$formattedData);
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "No results";
                }
            }
            else 
            {
                $_SESSION['error'] = "No form type selected";
            }
        }

        else 
        {
            $_SESSION['error'] = "No timeframe chosen";
        }

    }  

    // Process Stock Report Form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stockReportForm'])) 
    {
        $reportMonth = $_POST['monthInputStock'];
        list($year, $month) = explode('-', $reportMonth);

        if ($formtype === 'top5MostRestock')
        {
            $sql = "SELECT ProductID, SUM(Quantity) AS Total_Restocked
            FROM StockOrderCount
            GROUP BY ProductID
            ORDER BY Total_Restocked DESC
            LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['ProductID'], $row['Total_Restocked']];
                }
                $titleArray = ['ProductID', 'Total_Restocked'];
                array_unshift($formattedData, $titleArray);
            
                ob_end_clean();
                downloadCSV("Top 5 Most Restocked Items",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        elseif ($formtype === 'top5LeastRestock')
        {
            $sql = "SELECT ProductID, SUM(Quantity) AS Total_Restocked
            FROM StockOrderCount
            GROUP BY ProductID
            ORDER BY Total_Restocked ASC
            LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['ProductID'], $row['Total_Restocked']];
                }
                $titleArray = ['ProductID', 'Total_Restocked'];
                array_unshift($formattedData, $titleArray);
            
                ob_end_clean();
                downloadCSV("Top 5 Least Restocked Items",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        elseif ($formtype === 'productSoldInMonth')
        {
            $sql = "SELECT p.ProductID, p.Name, SUM(ri.Quantity) AS Total_Sold, SUM(ri.ProductPrice * ri.Quantity) AS Total_Earnings
            FROM ReceiptItemTable AS ri
            JOIN ProductTable AS p ON ri.ProductID = p.ProductID
            WHERE YEAR(ri.Date) = '$year' AND MONTH(ri.Date) = '$month'
            GROUP BY p.ProductID, p.Name
            ORDER BY p.ProductID ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['ProductID'], $row['Name'], $row['Total_Sold'], $row['Total_Earnings']];
                }
                $titleArray = ['ProductID', 'Name', 'Total_Sold', 'Total_Earnings'];
                array_unshift($formattedData, $titleArray);
            
                ob_end_clean();
                downloadCSV("$reportMonth Items Sold",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        else
        {
            $_SESSION['error'] = 'No form type selected';
        }
    }

    // Process Customer Report Form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customerReportForm'])) 
    {
        $formtype = $_POST['customerReportOption'];
        $customerid = (int) $_POST['customerID'];
        
        if ($formtype === 'favItem')
        {
            $sql = "SELECT p.Name, COUNT(r.ProductID) AS Total_Sold
            FROM ReceiptItemTable AS r
            JOIN ProductTable AS p ON r.ProductID = p.ProductID
            JOIN ReceiptTable AS t ON r.ReceiptID = t.ReceiptID
            WHERE t.UserID = '$customerid'
            GROUP BY p.Name
            ORDER BY Total_Sold DESC
            LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['Name'], $row['Total_Sold']];
                }
                $titleArray = ['Name', 'Total_Sold'];
                array_unshift($formattedData, $titleArray);
                
                ob_end_clean();
                downloadCSV("Customer ID $customerid Favorite Items",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        elseif ($formtype === 'allMembers')
        {
            $sql = "SELECT * FROM userstable";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['ID'], $row['Role'], $row['Username'], $row['Gender'], $row['Email'], $row['PhoneNumber'], $row['DateOfBirth'], $row['Points']];
                }
                $titleArray = ['ID','Role','Username','Gender','Email','PhoneNumber','DateOfBirth','Points'];
                array_unshift($formattedData, $titleArray);
            
                ob_end_clean();
                downloadCSV("User Information",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        elseif ($formtype === 'topSpending')
        {
            $sql = "SELECT u.UserID, u.Username, SUM(r.TotalPrice) AS Total_Spent
            FROM ReceiptTable AS r
            JOIN UserTable AS u ON r.UserID = u.ID
            GROUP BY u.ID, u.Username
            ORDER BY Total_Spent DESC
            LIMIT 5";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                $formattedData = [];

                foreach ($result as $row) 
                {
                    $formattedData[] = [$row['ID'], $row['Username'],$row['Total_Spent']];
                }
                $titleArray = ['ID', 'Username', 'Total_Spent'];
                array_unshift($formattedData, $titleArray);
                
                ob_end_clean();
                downloadCSV("Top 5 Spendering Customers",$formattedData);
                exit;
            }
            else
            {
                $_SESSION['error'] = "No results";
            }
        }
        else
        {
            $_SESSION['error'] = 'No form type selected';
        }
    }
?>
<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Reports Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    <!-- Normal Styling -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminreport_style.css" rel="stylesheet">
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
        <div class="text">Reports</div>

        <div class="container">
            <div class="box">
                <p class="text">Sales Report</p>
                <img src="images/Placeholder.png" alt="Image 1">
                <p></p>
                <button id="generateSalesReportBtn">Generate</button>
            </div>
            <div class="box">
                <p class="text">Stock Report</p>
                <img src="images/Placeholder.png" alt="Image 2">
                <p></p>
                <button id="generateStockReportBtn">Generate</button>
            </div>
            <div class="box">
                <p class="text">Customer Report</p>
                <img src="images/Placeholder.png" alt="Image 3">
                <p></p>
                <button id="generateCustomerReportBtn">Generate</button>
            </div>
        </div>
    </section>

    <!-- Sales Report Popup -->
    <div id="salesReportPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeSalesPopup()">&times;</span>
            <h2>Generate Sales Report</h2>
            <p>Select the period and type for the report:</p>

            <form id="salesReportForm" name="salesReportForm" method="POST" action="">
                <label for="salesReportOption">Choose Report Timeframe:</label><br>
                <select id="salesReportOption" name="salesReportOption" required>
                    <option value=""></option>
                    <option value="daily">Daily</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select><br><br>

             
                <label for="reportType">Choose Report Type:</label><br>
                <select id="reportType" name="reportType" required>
                    <option value=""></option>
                    <option value="PopularItems">Popular Items</option>
                    <option value="TotalSales">Total Sales</option>
                </select><br><br>
                
                <!-- Daily Report - Date Picker -->
                <div id="dateInput" style="display:none;">
                    <label for="dailyDate">Select Date:</label><br>
                    <input type="date" id="dailyDate" name="dailyDate"><br><br>
                </div>
                
                <!-- Monthly Report - Month Picker -->
                <div id="monthInputSales" style="display:none;">
                    <label for="monthlyMonth">Select Month:</label><br>
                    <input type="month" id="monthlyMonth" name="monthlyMonth"><br><br>
                </div>
                
                <!-- Yearly Report - Year Picker -->
                <div id="yearInput" style="display:none;">
                    <label for="yearlyYear">Select Year:</label><br>
                    <input type="number" id="yearlyYear" name="yearlyYear" min="2000" max="2099" step="1"><br><br>
                </div>
                
                <button type="submit" id="generateSalesReport">Generate</button>
                <button type="button" onclick="closeSalesPopup()">Close</button>
            </form>
        </div>
    </div>

    <!-- Stock Report Popup -->
    <div id="stockReportPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeStockPopup()">&times;</span>
            <h2>Stock Report</h2>
            <form id="stockReportForm" name="stockReportForm" method="POST" action="">
                <label for="stockReportOption">Choose a report:</label>
                <select id="stockReportOption">
                    <option value="top5MostRestock">View top 5 most restocked</option>
                    <option value="top5LeastRestock">View top 5 least restocked</option>
                    <option value="productSoldInMonth">Product sold in Month</option>
                </select>
                <br>
                <div id="monthInputStock" style="display:none;">
                    <label for="calendarInput">Select Month:</label>
                    <input type="month" id="calendarInput">
                </div>
                <button type="submit">Generate Report</button>
                <button type="button" onclick="closeStockPopup()">Close</button>
            </form>
        </div>
    </div>

    <!-- Customer Report Popup -->
    <div id="customerReportPopup" class="popup" style="display:none;">
        <div class="popup-content">
            <span class="close" onclick="closeCustomerPopup()">&times;</span>
            <h2>Generate Customer Report</h2>
            <form id="customerReportForm" name="customerReportForm" method="POST" action="">
                <label for="customerReportOption">Choose Report Type:</label><br>
                <select id="customerReportOption" name="customerReportOption">
                    <option value="favItem">Customer Favourite Item</option>
                    <option value="allMembers">Show All Members</option>
                    <option value="topSpending">Top 5 Spending Customers</option>
                </select><br>
                <label for="customerID">Customer ID:</label>
                    <input type="text" id="customerID" name="customerID" placeholder="Enter customer ID">
                <br>
                <button type="submit">Generate Report</button>
                <button type="button" onclick="closeCustomerPopup()">Close</button>
            </form>
        </div>
    </div>

    <!-- Script for admin sidebar -->
    <script src="scripts/adminsidebar.js"></script>
    <!-- Script for admin sales report -->
    <script src="scripts/AdminSalesReport.js"></script>
    <!-- Script for admin stock report -->
    <script src="scripts/AdminStockReport.js"></script>
    <!-- Script for admin customer report -->
    <script src="scripts/AdminCustomerReport.js"></script>
</body>
</html>
