<?php
// Start session and check if the user is logged in
session_start();

    if (($_SESSION['logged_in']) == false || $_SESSION["active_role"] == "Member") {
        header("Location: AdminLogin.php");
        exit;
    }

    include "Database.php";

    // Query to get total sales for each day
    $salesQuery = "SELECT Date, SUM(TotalPrice) AS TotalSales FROM ReceiptTable WHERE Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY Date ORDER BY Date";
    $salesResult = $conn->query($salesQuery);
    
    $dates = [];
    $totalSales = [];

    // Store data in arrays for Chart.js
    while ($row = $salesResult->fetch_assoc()) {
        $dates[] = $row['Date'];
        $totalSales[] = $row['TotalSales'];
    }
    

    // Query to calculate total gross sales for the entire store
    $totalGrossSalesQuery = "SELECT SUM(TotalPrice) AS TotalGrossSales FROM ReceiptTable";
    $totalGrossSalesResult = $conn->query($totalGrossSalesQuery);

    $GrossSale = 0;

    if ($totalGrossSalesRow = $totalGrossSalesResult->fetch_assoc()) {
        $GrossSale = $totalGrossSalesRow['TotalGrossSales'];
    }


    // Query to count total members
    $totalMembersQuery = "SELECT COUNT(*) AS TotalMembers FROM UsersTable"; // Adjust table name accordingly
    $totalMembersResult = $conn->query($totalMembersQuery);

    if ($totalMembersRow = $totalMembersResult->fetch_assoc()) {
        $totalMembers = $totalMembersRow['TotalMembers'];
    }
    

    // Query to count total products
    $totalProductsQuery = "SELECT SUM(Quantity) AS TotalProduct FROM ProductTable"; // Adjust table name accordingly
    $totalProductsResult = $conn->query($totalProductsQuery);

    if ($totalProductsRow = $totalProductsResult->fetch_assoc()) {
        $totalProducts = $totalProductsRow['TotalProduct'];
    }
    

    // Fetch sales data by product category
    $query = "SELECT 
        ProductTable.Category, 
        SUM(ReceiptItemTable.Quantity * ProductTable.Price) AS TotalSales FROM ReceiptTable
        JOIN ReceiptItemTable ON ReceiptTable.ReceiptID = ReceiptItemTable.ReceiptID
        JOIN ProductTable ON ReceiptItemTable.ProductID = ProductTable.ProductID
        GROUP BY ProductTable.Category";
    $result = $conn->query($query);

    // Prepare data for the chart
    $categories = [];
    $sales = [];

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $categories[] = $row['Category'];
    $sales[] = $row['TotalSales'];
    }
    } else {
    echo "No sales data found.";
    }





    $conn->close();
?>

<!DOCTYPE html>
<html>
<!-- Head, Charset etc....-->
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Goto Grocery Admin Home Page">
	<meta name="keywords" content="Goto Grocery, Admin" >
	<meta name="author" content="G1" >
	<title> Goto Grocery Admin Home Page </title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="styles/adminhome_style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="text">Dashboard</div>

        <div class="box" id="infor">

            <div class="info-item">
                <i class="bx bx-dollar icon"></i>
                <div class="info-text">
                    <h3>Total Sales</h3>
                    <p>RM<?php echo $GrossSale; ?></p> <!-- Example total sales amount -->
                </div>
            </div>
            <div class="info-item">
                <i class="bx bx-user icon"></i>
                <div class="info-text">
                    <h3>Total Members</h3>
                    <p><?php echo $totalMembers ?></p> <!-- Example total number of members -->
                </div>
            </div>
            <div class="info-item">
                <i class="bx bx-box icon"></i>
                <div class="info-text">
                    <h3>Total Products</h3>
                    <p><?php echo $totalProducts ?></p> <!-- Example total number of products -->
                </div>
            </div>
            
        </div>

        <div class="container">
    
            <div class="box">
                <h2>Sales Distribution by Product Category</h2>
                <div class="chart">
                <canvas id="salesPieChart" width="400" height="200"></canvas>
                </div>
            </div>

            <div class="box">
                <h2>Daily Sales Chart</h2>
                <div class="chart">
                <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <script>
            const categories = <?php echo json_encode($categories); ?>;
            const sales = <?php echo json_encode($sales); ?>;
            const dates = <?php echo json_encode($dates); ?>;
            const totalSales = <?php echo json_encode($totalSales); ?>;

            // Pie chart for sales distribution
            const pieCtx = document.getElementById('salesPieChart').getContext('2d');
            const salesPieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Total Sales (RM)',
                        data: sales,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 71, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 71, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });

            // Bar chart for daily sales
            const barCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Total Sales (RM)',
                        data: totalSales,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'RM' + value.toFixed(2); // Format y-axis labels as currency
                                }
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </section>

    

    <!-- Script for admin side bar -->
    <script src="scripts/adminsidebar.js"></script>
  
</body>



</html>
