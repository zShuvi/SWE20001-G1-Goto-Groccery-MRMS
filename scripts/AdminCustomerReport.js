// CUSTOMER REPORT //
// CUSTOMER REPORT //
// CUSTOMER REPORT //
var customerPopup = document.getElementById("customerReportPopup");
var customerGenerateButton = document.getElementById("generateCustomerReportBtn");

customerGenerateButton.onclick = function() {
    customerPopup.style.display = "flex";
};

function closeCustomerPopup() {
    customerPopup.style.display = "none";
}


/* // Handle form submission for Customer Report
document.getElementById("customerReportForm").addEventListener("submit", function(event) {
    //event.preventDefault();

    var selectedOption = document.getElementById("customerReportOption").value;

    if (selectedOption === "favItem") {
        alert("Generating report for Customer Favourite Item");
    } else if (selectedOption === "allMembers") {
        alert("Generating report to Show All Members");
    } else if (selectedOption === "topSpending") {
        alert("Generating report for Top 5 Spending Customers");
    }

    closeCustomerPopup(); 
});
 */