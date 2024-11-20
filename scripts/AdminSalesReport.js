document.addEventListener("DOMContentLoaded", function() {
    var salesPopup = document.getElementById("salesReportPopup");
    var salesGenerateButton = document.getElementById("generateSalesReportBtn");

    var salesReportOption = document.getElementById("salesReportOption");
    var dateInput = document.getElementById("dateInput");
    var monthInputSales = document.getElementById("monthInputSales");
    var yearInput = document.getElementById("yearInput");

    // Function to adjust visibility based on selected option
    function updateVisibility() {
        var selectedOption = salesReportOption.value;
        dateInput.style.display = selectedOption === "daily" ? "block" : "none";
        monthInputSales.style.display = selectedOption === "monthly" ? "block" : "none";
        yearInput.style.display = selectedOption === "yearly" ? "block" : "none";
    }

    // Handle dropdown change and update visibility
    salesReportOption.addEventListener("change", updateVisibility);

    // Initialize visibility on page load
    updateVisibility();

    // Show popup
    salesGenerateButton.onclick = function() {
        salesPopup.style.display = "flex"; 
    };

    // Close popup function
    window.closeSalesPopup = function() {
        salesPopup.style.display = "none"; 
    };

    // Handle form submission or button click to generate report
    /*
    document.getElementById("generateSalesReportBtn").addEventListener("click", function() {
        var selectedOption = salesReportOption.value;
        var year = yearInput.value;

        if (selectedOption === "yearly" && year !== "") {
            // Send the selected year as part of the request (example using fetch or AJAX)
            console.log("Yearly report for year:", year);
            // Example of sending the year to the backend
            fetch("DownloadReport.php", {
                method: "POST",
                body: JSON.stringify({
                    reportType: selectedOption,
                    year: year
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to generate the report.");
                }
                return response.blob(); // Process the response as a binary file (blob)
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob); // Create a URL for the blob
                const a = document.createElement("a");
                a.href = url;
                a.download = "YearlySalesReport.csv"; // Set a dynamic or fixed filename
                document.body.appendChild(a);
                a.click();
                a.remove(); // Clean up the temporary anchor element
                window.URL.revokeObjectURL(url); // Revoke the blob URL after download
            })
            .catch(error => {
                console.error("Error generating report:", error);
                alert("Failed to generate the report. Please try again.");
            });
        }
    });
    */
});




/* document.getElementById("salesReportForm").addEventListener("submit", function(event) {
    //event.preventDefault();
    
    var selectedOption = salesReportOption.value;
    var reportValue;
    
    if (selectedOption === "daily") {
        reportValue = dateInput.value;
        alert("Generating daily sales report for " + reportValue);
    } 
    else if (selectedOption === "monthly") {
        reportValue = monthInputSales.value;
        alert("Generating monthly sales report for " + reportValue);
    } 
    else if (selectedOption === "yearly") {
        reportValue = yearInput.value;
        alert("Generating yearly sales report for " + reportValue);
    }
    this.submit();
    closeSalesPopup(); s
}); */

