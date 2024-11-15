// STOCK REPORT //
var stockPopup = document.getElementById("stockReportPopup");
var stockGenerateButton = document.getElementById("generateStockReportBtn");

var stockReportOption = document.getElementById("stockReportOption");
var stockMonthInput = document.getElementById("monthInputStock");
var calendarInput = document.getElementById("calendarInput");

stockReportOption.addEventListener("change", function() {
    var selectedOption = stockReportOption.value;
    stockMonthInput.style.display = "none";
    
    if (selectedOption === "productSoldInMonth") {
        stockMonthInput.style.display = "block"; 
    }
});

stockGenerateButton.onclick = function() {
    stockPopup.style.display = "flex"; 
};

function closeStockPopup() {
    stockPopup.style.display = "none"; 
}

document.getElementById("stockReportForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    var selectedOption = stockReportOption.value;
    var reportValue;
    
    if (selectedOption === "top5MostRestock") {
        alert("Generating report for top 5 most restocked products");
    } 
    else if (selectedOption === "top5LeastRestock") {
        alert("Generating report for top 5 least restocked products");
    } 
    else if (selectedOption === "productSoldInMonth") {
        reportValue = calendarInput.value;
        alert("Generating report for products sold in " + reportValue);
    }
    
    closeStockPopup(); 
});