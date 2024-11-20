<?php
ob_start();
session_start();
include "Database.php";

// Start session and check if the user is logged in
if ($_SESSION['logged_in'] == false) {
    header("Location: AdminLogin.php");
    exit;
}

require_once 'functions/Download.php';

// Handle report downloads based on POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process Sales Report Form
    if (isset($_POST['salesReportOption'])) {
        $timeframe = $_POST['salesReportOption'];

        // Check if 'reportType' is set, otherwise default to 'TotalSales'
        $formtype = isset($_POST['reportType']) ? $_POST['reportType'] : 'TotalSales';

        // Daily Report Generation - Total Earnings, Sales Quantity, Popular Items
        if ($timeframe === 'daily') {
            $reportDate = $_POST['dailyDate'];

            // Prepare the data for all the reports: Total Earnings, Sales Quantity, and Popular Items
            $dailyData = [];

            // Total Earnings
            $sql = "SELECT SUM(TotalPrice) AS Total_Earnings FROM ReceiptTable WHERE Date = '$reportDate'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dailyData['Total_Earnings'] = $row['Total_Earnings'];
                }
            } else {
                $dailyData['Total_Earnings'] = 0;
            }

            // Sales Quantity (Number of Receipts)
            $sql = "SELECT COUNT(ReceiptID) AS Sales_Quantity FROM ReceiptTable WHERE Date = '$reportDate'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dailyData['Sales_Quantity'] = $row['Sales_Quantity'];
                }
            } else {
                $dailyData['Sales_Quantity'] = 0;
            }

            // Popular Items (Top 5 Products Sold)
            $sql = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold
                    FROM ReceiptItemTable AS ri
                    JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                    JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                    WHERE r.Date = '$reportDate'
                    GROUP BY p.Name
                    ORDER BY Total_Sold DESC
                    LIMIT 5";
            $result = $conn->query($sql);
            $popularItems = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $popularItems[] = $row['Name'];
                }
            }

            // Prepare formatted data for CSV (columns)
            $formattedData = [];
            // Total Earnings
            $formattedData[] = ['Total Earnings', $dailyData['Total_Earnings']];
            // Sales Quantity
            $formattedData[] = ['Sales Quantity', $dailyData['Sales_Quantity']];
            // Popular Items - name only in the Popular Item column
            $formattedData[] = ['Popular Item', implode(', ', $popularItems)];

            // File name and CSV download
            $fileName = "Daily Report - $reportDate";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }

        // Monthly Report Generation
        else if ($timeframe === 'monthly') {
            $reportMonth = $_POST['monthlyMonth'];
            list($year, $month) = explode('-', $reportMonth);

            // Prepare the data for the Monthly Report: Total Earnings, Popular Item, and Daily Sales Revenue
            if ($formtype === 'TotalSales') {
                // Total Earnings for the Month
                $sql = "SELECT SUM(TotalPrice) AS Total_Earnings 
                        FROM ReceiptTable 
                        WHERE YEAR(Date) = '$year' AND MONTH(Date) = '$month'";
                $result = $conn->query($sql);

                $totalEarnings = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalEarnings = $row['Total_Earnings'];
                }

                // Get the most popular item for the month
                $sqlPopular = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold 
                               FROM ReceiptItemTable AS ri
                               JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                               JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                               WHERE YEAR(r.Date) = '$year' AND MONTH(r.Date) = '$month'
                               GROUP BY p.Name
                               ORDER BY Total_Sold DESC
                               LIMIT 1";
                $resultPopular = $conn->query($sqlPopular);
                $popularItem = "";
                if ($resultPopular->num_rows > 0) {
                    $row = $resultPopular->fetch_assoc();
                    $popularItem = $row['Name'];
                }

                // Get daily sales revenue for the month
                $dailySales = [];
                $sqlDailySales = "SELECT DATE(Date) AS Sales_Date, SUM(TotalPrice) AS Daily_Revenue
                                  FROM ReceiptTable 
                                  WHERE YEAR(Date) = '$year' AND MONTH(Date) = '$month'
                                  GROUP BY DATE(Date)";
                $resultDaily = $conn->query($sqlDailySales);
                if ($resultDaily->num_rows > 0) {
                    while ($row = $resultDaily->fetch_assoc()) {
                        $dailySales[] = [$row['Sales_Date'], $row['Daily_Revenue']];
                    }
                }

                // Prepare the formatted data for CSV
                $formattedData = [
                    ['Total Earnings', $totalEarnings],
                    ['Popular Item', $popularItem]
                ];

                // Add daily sales revenue breakdown to the formatted data
                foreach ($dailySales as $sale) {
                    $formattedData[] = ['Date', $sale[0], 'Daily Revenue', $sale[1]];
                }

                // Add the file name and initiate CSV download
                $fileName = "$reportMonth Monthly Report";
                ob_end_clean();
                downloadCSV($fileName, $formattedData);
                exit;
            }
        }

        // Yearly Sales Report
        if ($timeframe === 'yearly') {
            if (isset($_POST['yearlyYear'])) {
                $year = $_POST['yearlyYear'];

                // Query to get total sales for the year
                $sql = "SELECT SUM(TotalPrice) AS Total_Earnings FROM ReceiptTable WHERE YEAR(Date) = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $year);
                $stmt->execute();
                $result = $stmt->get_result();
                $totalEarnings = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalEarnings = $row['Total_Earnings'] ?? 0;
                }

                // Query to find the most popular item of the year
                $sqlPopular = "
                    SELECT p.Name, SUM(ri.Quantity) AS Total_Sold
                    FROM ReceiptItemTable AS ri
                    JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                    JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                    WHERE YEAR(r.Date) = ?
                    GROUP BY p.Name
                    ORDER BY Total_Sold DESC
                    LIMIT 1";
                $stmtPopular = $conn->prepare($sqlPopular);
                $stmtPopular->bind_param("s", $year);
                $stmtPopular->execute();
                $resultPopular = $stmtPopular->get_result();
                $popularItem = "None";
                if ($resultPopular->num_rows > 0) {
                    $row = $resultPopular->fetch_assoc();
                    $popularItem = $row['Name'] ?? "None";
                }

                // Get monthly sales revenue breakdown for the year
                $monthlySales = [];
                $sqlMonthlySales = "SELECT MONTH(Date) AS Month, SUM(TotalPrice) AS Monthly_Revenue
                                    FROM ReceiptTable 
                                    WHERE YEAR(Date) = '$year'
                                    GROUP BY MONTH(Date)
                                    ORDER BY MONTH(Date)";
                $resultMonthly = $conn->query($sqlMonthlySales);
                if ($resultMonthly->num_rows > 0) {
                    while ($row = $resultMonthly->fetch_assoc()) {
                        $monthlySales[] = [$row['Month'], $row['Monthly_Revenue']];
                    }
                }

                // Prepare CSV data
                $formattedData = [
                    ['Year', $year],
                    ['Total Earnings', $totalEarnings],
                    ['Most Popular Item', $popularItem]
                ];

                // Add monthly sales revenue breakdown to the formatted data
                foreach ($monthlySales as $sale) {
                    // Add the month name (numeric month converted to text)
                    $monthName = DateTime::createFromFormat('!m', $sale[0])->format('F'); // Convert month number to name
                    $formattedData[] = ['Month', $monthName, 'Monthly Revenue', $sale[1]];
                }

                // File name and download
                $fileName = "{$year} Yearly Report.csv";
                ob_end_clean();
                downloadCSV($fileName, $formattedData);
                exit;
            } else {
                // Handle missing year
                echo "Year not selected.";
                exit;
            }
        }
    }
}






// Handle stock report downloads based on POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reportType'])) {
        $reportType = $_POST['reportType'];

        // Top 5 Most Restocked Items
        if ($reportType === 'top5MostRestock') {
            // Fetch the top 5 most restocked items
            $sqlTop = "SELECT soh.ProductID, pt.Name, SUM(soh.Quantity) AS TotalQuantity
                       FROM StockOrderHistory AS soh
                       JOIN ProductTable AS pt ON soh.ProductID = pt.ProductID
                       GROUP BY soh.ProductID, pt.Name
                       ORDER BY TotalQuantity DESC
                       LIMIT 5";
            $resultTop = $conn->query($sqlTop);
            $topRestocked = [];
            while ($row = $resultTop->fetch_assoc()) {
                $topRestocked[] = [$row['ProductID'], $row['Name'],  $row['TotalQuantity']];
            }

            // Prepare formatted data for CSV
            $formattedData = [['ProductID', 'ProductName', 'TotalAmountRestocked']];
            $formattedData = array_merge($formattedData, $topRestocked);

            // Download the CSV
            $fileName = "Top_5_Most_Restocked_Items";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }

        // Top 5 Least Restocked Items
        elseif ($reportType === 'top5LeastRestock') {
            // Fetch the top 5 least restocked items
            $sqlLeast = "SELECT soh.ProductID, pt.Name, SUM(soh.Quantity) AS TotalQuantity
                         FROM StockOrderHistory AS soh
                         JOIN ProductTable AS pt ON soh.ProductID = pt.ProductID
                         GROUP BY soh.ProductID, pt.Name
                         ORDER BY TotalQuantity ASC
                         LIMIT 5";
            $resultLeast = $conn->query($sqlLeast);
            $leastRestocked = [];
            while ($row = $resultLeast->fetch_assoc()) {
                $leastRestocked[] = [$row['ProductID'], $row['Name'],  $row['TotalQuantity']];
            }

            // Prepare formatted data for CSV
            $formattedData = [['ProductID', 'ProductName', 'TotalAmountRestocked']];
            $formattedData = array_merge($formattedData, $leastRestocked);

            // Download the CSV
            $fileName = "Top_5_Least_Restocked_Items";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }

        // Products Sold in a Month
        elseif ($reportType === 'productSoldInMonth') {
            if (isset($_POST['monthInputStock'])) {
                $reportMonth = $_POST['monthInputStock'];
                list($year, $month) = explode('-', $reportMonth);

                // Sold Products
                $sqlSold = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold 
                            FROM ReceiptItemTable AS ri
                            JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                            JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                            WHERE YEAR(r.Date) = '$year' AND MONTH(r.Date) = '$month'
                            GROUP BY p.Name";
                $resultSold = $conn->query($sqlSold);
                $soldProducts = [];
                while ($row = $resultSold->fetch_assoc()) {
                    $soldProducts[] = [$row['Name'], $row['Total_Sold']];
                }

                // Unsold Products
                $sqlUnsold = "SELECT p.Name 
                              FROM ProductTable AS p
                              WHERE p.ProductID NOT IN (
                                  SELECT ri.ProductID 
                                  FROM ReceiptItemTable AS ri
                                  JOIN ReceiptTable AS r ON ri.ReceiptID = r.ReceiptID
                                  WHERE YEAR(r.Date) = '$year' AND MONTH(r.Date) = '$month'
                              )";
                $resultUnsold = $conn->query($sqlUnsold);
                $unsoldProducts = [];
                while ($row = $resultUnsold->fetch_assoc()) {
                    $unsoldProducts[] = [$row['Name']];
                }

                // Combine results into formatted data
                $formattedData = [['Sold Products', 'Quantity']];
                $formattedData = array_merge($formattedData, $soldProducts);
                $formattedData[] = []; // Empty row for separation
                $formattedData[] = ['Unsold Products'];
                foreach ($unsoldProducts as $unsold) {
                    $formattedData[] = [$unsold[0]];
                }

                // Download the CSV
                $fileName = "${reportMonth}_Stock_Report";
                ob_end_clean();
                downloadCSV($fileName, $formattedData);
                exit;
            } else {
                $_SESSION['error'] = "Please select a valid month.";
            }
        }
    }
}




// Handle customer report downloads based on POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Customer Report
    if (isset($_POST['reportType'])) {
        $reportType = $_POST['reportType'];

        // Customer Favourite Items (Top 5)
        if ($reportType === 'favItem') {
            $sql = "SELECT p.Name, COUNT(ri.ProductID) AS Total_Sold
                    FROM ReceiptItemTable AS ri
                    JOIN ProductTable AS p ON ri.ProductID = p.ProductID
                    GROUP BY p.Name
                    ORDER BY Total_Sold DESC
                    LIMIT 5";
            $result = $conn->query($sql);

            $favItems = [];
            while ($row = $result->fetch_assoc()) {
                $favItems[] = [$row['Name'], $row['Total_Sold']];
            }

            $formattedData = [['Item Name', 'Times Purchased']];
            $formattedData = array_merge($formattedData, $favItems);

            $fileName = "Top_5_Favourite_Items_Report";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }

        // All Members
        elseif ($reportType === 'allMembers') {
            $sql = "SELECT ID, Role, UserName, Gender, Email, PhoneNumber, DateOfBirth, Points
                    FROM UsersTable";
            $result = $conn->query($sql);

            $allMembers = [];
            while ($row = $result->fetch_assoc()) {
                $allMembers[] = [$row['ID'], $row['Role'], $row['UserName'], $row['Gender'], $row['Email'], $row['PhoneNumber'], $row['DateOfBirth'], $row['Points']];
            }

            $formattedData = [['Member ID', 'Role', 'UserName', 'Gender', 'Email', 'Phone Number', 'Date Of Birth', 'Points']];
            $formattedData = array_merge($formattedData, $allMembers);

            $fileName = "All_Members_Report";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }

        // Top 5 Spending Customers
        elseif ($reportType === 'topSpending') {
            $sql = "SELECT m.ID, m.UserName, SUM(r.TotalPrice) AS Total_Spending
                    FROM ReceiptTable AS r
                    JOIN UsersTable AS m ON r.UserID = m.ID
                    GROUP BY m.ID, m.UserName
                    ORDER BY Total_Spending DESC
                    LIMIT 5";
            $result = $conn->query($sql);

            $topSpenders = [];
            while ($row = $result->fetch_assoc()) {
                $topSpenders[] = [$row['ID'], $row['UserName'], $row['Total_Spending']];
            }

            $formattedData = [['Member ID', 'UserName', 'Total Spending']];
            $formattedData = array_merge($formattedData, $topSpenders);

            $fileName = "Top_5_Spending_Customers";
            ob_end_clean();
            downloadCSV($fileName, $formattedData);
            exit;
        }
    }
}








?>





