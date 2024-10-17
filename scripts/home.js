let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const nextButton = document.querySelector('.next');
const prevButton = document.querySelector('.prev');

function showSlide(index) {
    if (index >= slides.length) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = slides.length - 1;
    } else {
        currentIndex = index;
    }
    const offset = -currentIndex * 100;
    document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
}

nextButton.addEventListener('click', () => {
    showSlide(currentIndex + 1);
});

prevButton.addEventListener('click', () => {
    showSlide(currentIndex - 1);
});

// Auto-slide every 5 seconds
setInterval(() => {
    showSlide(currentIndex + 1);
}, 5000);





function isUserLoggedIn() {
    var loggedin = document.getElementById('sessionLoggedIn').value;
    if (loggedin == 1)
    {
        return true;
    }
    return false;
    //return Math.random() > 0; // For demo, random login state
}

document.addEventListener('DOMContentLoaded', function() {
    const dropdownList = document.getElementById('dropdownList');
    
    if (isUserLoggedIn()) {
        dropdownList.innerHTML = `
            <li><a href="UserProfile.php">View Profile</a></li>
            <li><a href="Login.php" onclick="logoutUser()">Logout</a></li>
        `;
    } else {
        dropdownList.innerHTML = `<li><a href="Login.php">Login</a></li>`;
    }
});

function logoutUser() {
    document.getElementById('sessionLoggedIn').value = "0";
    //alert('Logging out...');
    // Handle logout logic  
}
