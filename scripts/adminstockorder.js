// Sample data for available stock with images, description, and stock
const stockItems = [
    { name: 'Monitor', image: 'https://via.placeholder.com/70', description: '27" Full HD Monitor', availableQuantity: 12 },
    { name: 'Meyboard', image: 'https://via.placeholder.com/70', description: 'Mechanical Keyboard', availableQuantity: 50 },
    { name: 'Mouse', image: 'https://via.placeholder.com/70', description: 'Wireless Mouse', availableQuantity: 25 },
    { name: 'Maptop', image: 'https://via.placeholder.com/70', description: '15" Laptop with i7 Processor', availableQuantity: 8 },
    { name: 'Martphone', image: 'https://via.placeholder.com/70', description: 'Android Smartphone', availableQuantity: 20 }
];

// Array to store the selected items and quantities
let order = [];

function searchStock() {
    const searchInput = document.getElementById('search').value.toLowerCase();
    const searchResults = document.getElementById('search-results');
    
    // Clear previous results
    searchResults.innerHTML = '';
    
    // Filter items based on input
    const filteredItems = stockItems.filter(item => item.name.toLowerCase().includes(searchInput));

    // Display filtered results
    if (filteredItems.length > 0 && searchInput) {
        filteredItems.forEach(item => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            
            // Image
            const productImage = document.createElement('img');
            productImage.src = item.image;
            
            // Product Info
            const productInfo = document.createElement('div');
            productInfo.classList.add('product-info');
            productInfo.innerHTML = `<h4>${item.name}</h4><p>${item.description}</p><p>Available: ${item.availableQuantity}</p>`;
            
            // Quantity Input and Button
            const quantityInput = document.createElement('div');
            quantityInput.classList.add('quantity-input');

            const quantityField = document.createElement('input');
            quantityField.type = 'number';
            quantityField.min = '1';
            quantityField.max = item.availableQuantity;
            quantityField.placeholder = 'Qty';
            
            const addButton = document.createElement('button');
            addButton.classList.add('box-submit-btn');
            addButton.textContent = 'Add to Order';
            addButton.onclick = () => addToOrder(item.name, quantityField.value, item.availableQuantity);
            
            quantityInput.appendChild(quantityField);
            quantityInput.appendChild(addButton);

            // Append to product card
            productCard.appendChild(productImage);
            productCard.appendChild(productInfo);
            productCard.appendChild(quantityInput);

            // Append product card to results
            searchResults.appendChild(productCard);
        });
    } else {
        searchResults.innerHTML = '<p>No items found.</p>';
    }
}

function addToOrder(itemName, quantity, maxQuantity) {
    const quantityNum = parseInt(quantity);
    if (!quantityNum || quantityNum <= 0 || quantityNum > maxQuantity) {
        alert('Please enter a valid quantity.');
        return;
    }

    // Check if the item is already in the order
    const existingItem = order.find(item => item.name === itemName);
    if (existingItem) {
        existingItem.quantity += quantityNum;
    } else {
        order.push({ name: itemName, quantity: quantityNum });
    }

}

function proceedToSummary() {
    const orderSummary = document.getElementById('order-summary');
    orderSummary.innerHTML = '';

    if (order.length === 0) {
        orderSummary.innerHTML = '<p>No items in the order.</p>';
    } else {
        order.forEach((item, index) => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            
            // Image
            const productImage = document.createElement('img');
            productImage.src = stockItems.find(stockItem => stockItem.name === item.name).image;
            
            // Product Info
            const productInfo = document.createElement('div');
            productInfo.classList.add('product-info');
            productInfo.innerHTML = `<h4>${item.name}</h4><p>${stockItems.find(stockItem => stockItem.name === item.name).description}</p>`;
            
            // Quantity Input and Button
            const quantityInput = document.createElement('div');
            quantityInput.classList.add('quantity-input');
            const quantityField = document.createElement('input');
            quantityField.type = 'number';
            quantityField.min = '1';
            quantityField.value = item.quantity;
            quantityField.onchange = () => updateOrderQuantity(index, quantityField.value);

            quantityInput.appendChild(quantityField);

            // Append to product card
            productCard.appendChild(productImage);
            productCard.appendChild(productInfo);
            productCard.appendChild(quantityInput);

            orderSummary.appendChild(productCard);
        });
    }

    document.getElementById('order-summary-modal').style.display = 'block';
}

function updateOrderQuantity(index, newQuantity) {
    if (newQuantity <= 0) {
        order.splice(index, 1);  // Remove item if quantity is set to 0
    } else {
        order[index].quantity = parseInt(newQuantity);
    }

    if (order.length === 0) {
        document.getElementById('proceed-btn').style.display = 'none';
        closeModal();
    }
}

function confirmOrder() {
    const finalConfirmationDetails = document.getElementById('final-confirmation-details');
    finalConfirmationDetails.innerHTML = '';

    if (order.length > 0) {
        order.forEach(item => {
            const confirmationDetail = document.createElement('p');
            confirmationDetail.textContent = `${item.quantity} units of ${item.name}`;
            finalConfirmationDetails.appendChild(confirmationDetail);
        });

        document.getElementById('final-confirmation-modal').style.display = 'block';
    }
}

function submitOrder() {
    alert('Order placed successfully!');
    
    // Close modals but keep the "Proceed to Confirmation" button visible
    closeModal();
    closeFinalModal();

    // Reset everything
    order = [];
    document.getElementById('search-results').innerHTML = ''; // Clear the results
    displayStockItems(stockItems); // Reload all stock items
    document.getElementById('proceed-btn').style.display = 'block'; // Ensure the button stays visible
}


function closeModal() {
    document.getElementById('order-summary-modal').style.display = 'none';
}

function closeFinalModal() {
    document.getElementById('final-confirmation-modal').style.display = 'none';
}

function goBackToSearch() {
    closeModal();
}


// Sort stock items alphabetically by default
stockItems.sort((a, b) => a.name.localeCompare(b.name));

// Display stock items by default
window.onload = function() {
    displayStockItems(stockItems);
};

function searchStock() {
    const searchInput = document.getElementById('search').value.toLowerCase();
    const filteredItems = stockItems.filter(item => item.name.toLowerCase().includes(searchInput));

    // Display filtered items if search input is present; otherwise, show all
    if (searchInput) {
        displayStockItems(filteredItems);
    } else {
        displayStockItems(stockItems); // Show all items when no search term
    }
}

function displayStockItems(items) {
    const searchResults = document.getElementById('search-results');
    searchResults.innerHTML = ''; // Clear previous results

    if (items.length > 0) {
        items.forEach(item => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');

            // Image
            const productImage = document.createElement('img');
            productImage.src = item.image;

            // Product Info
            const productInfo = document.createElement('div');
            productInfo.classList.add('product-info');
            productInfo.innerHTML = `<h4>${item.name}</h4><p>${item.description}</p><p>Available: ${item.availableQuantity}</p>`;

            // Quantity Input and Button
            const quantityInput = document.createElement('div');
            quantityInput.classList.add('quantity-input');
            const quantityField = document.createElement('input');
            quantityField.type = 'number';
            quantityField.min = '1';
            quantityField.max = item.availableQuantity;
            quantityField.placeholder = 'Qty';

            const addButton = document.createElement('button');
            addButton.classList.add('submit-btn');
            addButton.textContent = 'Add to Order';
            addButton.onclick = () => addToOrder(item.name, quantityField.value, item.availableQuantity);

            quantityInput.appendChild(quantityField);
            quantityInput.appendChild(addButton);

            // Append to product card
            productCard.appendChild(productImage);
            productCard.appendChild(productInfo);
            productCard.appendChild(quantityInput);

            // Append product card to results
            searchResults.appendChild(productCard);
        });
    } else {
        searchResults.innerHTML = '<p>No items found.</p>';
    }
}

function goBackToSummary() {
    document.getElementById('final-confirmation-modal').style.display = 'none';
    document.getElementById('order-summary-modal').style.display = 'block'; // Go back to order summary
}


