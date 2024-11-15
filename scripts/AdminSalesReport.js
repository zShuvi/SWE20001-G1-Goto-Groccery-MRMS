// SALES REPORT //
var salesPopup = document.getElementById("salesReportPopup");
var salesGenerateButton = document.getElementById("generateSalesReportBtn");

var salesReportOption = document.getElementById("reportOption");
var dateInput = document.getElementById("dateInput");
var monthInputSales = document.getElementById("monthInputSales");
var yearInput = document.getElementById("yearInput");

salesReportOption.addEventListener("change", function() {
    var selectedOption = salesReportOption.value;
    dateInput.style.display = "none";
    monthInputSales.style.display = "none";
    yearInput.style.display = "none";
    
    if (selectedOption === "daily") {
        dateInput.style.display = "block"; 
    }
     else if (selectedOption === "monthly") {
        monthInputSales.style.display = "block"; 
    }
     else if (selectedOption === "yearly") {
        yearInput.style.display = "block"; 
    }
});

salesGenerateButton.onclick = function() {
    salesPopup.style.display = "flex"; 
};

function closeSalesPopup() {
    salesPopup.style.display = "none"; 
}

document.getElementById("salesReportForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
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
    
    closeSalesPopup(); 
});

