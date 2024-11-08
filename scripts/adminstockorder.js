function searchStock() {
    var searchQuery = document.getElementById('search').value;

    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Define the callback function to update search results
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('search-results').innerHTML = xhr.responseText;
        }
    };

    // Send the AJAX request with the search query to the same page (AdminProduct.php)
    xhr.open("GET", "AdminStockOrder.php?search=" + searchQuery, true);
    xhr.send();
}

// Function to get query parameters from the URL
function getQueryParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Get the product ID from the URL
const productId = getQueryParameter("productID");
console.log(productId);

if (productId) {
    // Select the search bar and set its value to the product ID
    const searchBar = document.getElementById("search");
    if (searchBar) {
        searchBar.value = productId;
        searchBar.dispatchEvent(new Event("input"));
    }
}



// Use jsArray as you would any JavaScript array
console.log(jsArray);  // Output: ["apple", "banana", "orange"]

order = jsArray;

function updateQuantity(productID, newQuantity) {
    
    jsArray[productID].quantity = parseInt(newQuantity);
    
    
    sendUpdateToServer();
}

function sendUpdateToServer() {
    fetch("AdminStockOrder.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(jsArray),
    })
    .then(response => response.json())
    .then(data => console.log("Server response:", data))
    .catch(error => console.error("Error:", error));
}


function proceedToSummary() {
    const orderSummary = document.getElementById('order-summary');
    
    document.getElementById('order-summary-modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('order-summary-modal').style.display = 'none';
    location.reload();
}

function closeFinalModal() {
    document.getElementById('final-confirmation-modal').style.display = 'none';
}

function confirmOrder() {

   // Loop through each entry in jsArray
    Object.entries(jsArray).forEach(([productId, productData]) => {
        // `productId` is the key (e.g., "39"), and `productData` is the value (e.g., { quantity: 1 })
        let quantity = productData.quantity;
        
        // Find the <p> element by class name that matches the productId
        let quantityElement = document.querySelector(`.product${productId} .quantity`);
        
        // If the element exists, update only the quantity text
        if (quantityElement) {
            if(quantity > 0){
                quantityElement.textContent = quantity;
            } else {
                let whole = document.querySelector(`.product${productId}`)
                whole.textContent = "";
            }
            
        } else {
            console.warn(`Quantity element for product ${productId} not found.`);
        }
    });

    document.getElementById('final-confirmation-modal').style.display = 'block';
    
}


function goBackToSummary() {
    document.getElementById('final-confirmation-modal').style.display = 'none';
    document.getElementById('order-summary-modal').style.display = 'block'; // Go back to order summary
}






