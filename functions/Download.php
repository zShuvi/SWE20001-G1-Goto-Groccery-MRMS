<!-- If any future formats like .txt or other filetypes need a download function, put it in this php file. -->

<?php

/* This is a generalized download function that automatically formats arrays into CSV before creating a download.
Formatting should be done in EACH report generating page separately.
You MUST format the data like this before calling the function:

    $example = [
    ["Product ID", "Product Name", "Price"], 
    [101, "Thing A", 19.99],
    [102, "Thing B", 29.99]
    ]; */
function downloadCSV($filename = "report.csv", $data = []) //Bind this to a download button
{
    // Set headers to force download
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // Open output stream for writing CSV data
    $output = fopen("php://output", "w");

    // Write each row to the CSV output
    foreach ($data as $row) 
    {
        fputcsv($output, $row);
    }

    // Close the output stream
    fclose($output);
    exit;
}

/* Use the below code template to convert queries into CSV ready data, then call downloadCSV() 

    $formattedData = [];

    foreach ($results as $row) {
        $formattedData[] = [$row['Name'], $row['Total_Sold'], ... ];
    } 
*/


// Below are the queries to be moved later.

// Sales reports

        /* <Total Sales for Year, Month and Day>     >> These need to be logically written using POST from calendar popups
        SELECT SUM(TotalPrice) FROM ReceiptTable WHERE YEAR(Date) = *;
        SELECT SUM(TotalPrice) FROM ReceiptTable WHERE YEAR(Date) = * AND MONTH(Date) = *;
        SELECT SUM(TotalPrice) FROM ReceiptTable WHERE Date= 'xxxx-xx-xx'; */

        /* <Most Popular Products>
        SELECT p.Name, COUNT(r.ProductID) AS Total_Sold
        FROM ReceiptItemTable AS r
        JOIN ProductTable AS p ON r.ProductID = p.ProductID
        WHERE <use the same WHERE formats for day month year>
        GROUP BY p.Name
        ORDER BY Total_Sold DESC LIMIT 5; */

// Stock reports

        /* <Products sold last <duration>
        SELECT p.Name, COUNT(r.ProductID) AS Total_Sold
        FROM ReceiptItemTable AS r
        JOIN ProductTable AS p ON r.ProductID = p.ProductID
        WHERE <use the same WHERE formats for day month year>
        GROUP BY p.Name
        ORDER BY Total_Sold DESC; */



// Customer reports

        /* <User favorites>
        SELECT p.Name, COUNT(r.ProductID) AS Total_Sold
        FROM ReceiptItemTable AS r
        JOIN ProductTable AS p ON r.ProductID = p.ProductID
        JOIN ReceiptTable AS t ON r.ReceiptID = t.ReceiptID
        WHERE t.UserID = * AND <use the same WHERE formats for day month year>
        GROUP BY p.Name
        ORDER BY Total_Sold DESC
        LIMIT 5; */

        /* <Top 5 Customers>
        SELECT t.UserID, SUM(t.TotalPrice) AS Total_Spent
        FROM ReceiptTable AS t
        WHERE <use the same WHERE formats for day month year>
        GROUP BY t.UserID
        ORDER BY Total_Spent DESC
        LIMIT 5; */
