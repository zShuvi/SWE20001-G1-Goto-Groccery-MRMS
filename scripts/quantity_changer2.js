// Select elements
const quantityInput = document.querySelector('.quantity');
const incrementBtn = document.querySelector('.increment');
const decrementBtn = document.querySelector('.decrement');

// Set initial max quantity based on the max attribute
const maxQuantity = parseInt(quantityInput.getAttribute('max'), 10);


function increaseQuantity(button) {
    const quantityInput = button.previousElementSibling;
    const maxQuantity = parseInt(quantityInput.getAttribute("max"));
    let currentQuantity = parseInt(quantityInput.value, 10);
    
    if (currentQuantity < maxQuantity) {
        quantityInput.value = currentQuantity + 1;
        addToCart(quantityInput.id);
        location.reload();
    }
    // Optionally, you can add code here to update the total cost for the row or cart.
}


// Function to decrease quantity
function decreaseQuantity(button) {
    const quantityInput = button.nextElementSibling;
    let currentQuantity = parseInt(quantityInput.value, 10);

    if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
        removeFromCart(quantityInput.id);
        location.reload();
    } else {
        // Prompt confirmation
        if (confirm("Do you want to remove this item from the cart?")) {
            removeFromCart(quantityInput.id); // Pass the ID to remove
            location.reload();
        }
    }
    toggleButtonState(quantityInput);
    
}

// Function to remove item from the cart
function removeFromCart(productId) {

    fetch(`functions/cart.php?action=remove&productID=${productId}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

        } else {
            console.error("Failed to remove item from cart:", data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}


function addToCart(productId) {
    fetch(`functions/cart.php?action=add&productID=${productId}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

        } else {
            console.error("Failed to add item into cart:", data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}




// Disable or enable buttons based on quantity
function toggleButtonState() {
    let currentQuantity = parseInt(quantityInput.value, 10);
    incrementBtn.disabled = currentQuantity >= maxQuantity;
    decrementBtn.disabled = currentQuantity <= 1;
}



// Initialize button states on page load
toggleButtonState();
