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
