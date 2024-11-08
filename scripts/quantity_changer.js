// Select elements
const quantityInput = document.querySelector('.quantity');
const incrementBtn = document.querySelector('.increment');
const decrementBtn = document.querySelector('.decrement');

// Set initial max quantity based on the max attribute
const maxQuantity = parseInt(quantityInput.getAttribute('max'), 10);

// Event listener for increment button
function increaseQuantity() {
    let currentQuantity = parseInt(quantityInput.value, 10);
    if (currentQuantity < maxQuantity) {
        quantityInput.value = currentQuantity + 1;
    }
    toggleButtonState();
}

// Event listener for decrement button
function decreaseQuantity() {
    let currentQuantity = parseInt(quantityInput.value, 10);
    if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
    }
    toggleButtonState();
}

// Disable or enable buttons based on quantity
function toggleButtonState() {
    let currentQuantity = parseInt(quantityInput.value, 10);
    incrementBtn.disabled = currentQuantity >= maxQuantity;
    decrementBtn.disabled = currentQuantity <= 1;
}

// Input validation to prevent manual entry over max
quantityInput.addEventListener('input', function () {
    let currentQuantity = parseInt(quantityInput.value, 10);
    
    if (currentQuantity > maxQuantity) {
        quantityInput.value = maxQuantity;
    } else if (currentQuantity < 1 || isNaN(currentQuantity)) {
        quantityInput.value = 1;
    }
    toggleButtonState();
});

// Initialize button states on page load
toggleButtonState();
