

function isUserLoggedIn() {
    var loggedin = document.getElementById('sessionLoggedIn').value;
    if (loggedin == 1)
    {
        return true;
    }
    return false;
   
}

document.addEventListener('DOMContentLoaded', function() {
    const dropdownList = document.getElementById('dropdownList');
    
    if (isUserLoggedIn()) {
        dropdownList.innerHTML = `
            <li><a href="UserProfile.php">View Profile</a></li>
            <li><a href="Member.php">Member</a></li>
            <li><a href="Login.php?logout=true" onclick="logoutUser()">Logout</a></li>
        `;
    } else {
        dropdownList.innerHTML = `
            <li><a href="Login.php">Login</a></li>
            <li><a href="SignUp.php">Sign Up</a></li>
        `;
    }
});

function logoutUser() {
    document.getElementById('sessionLoggedIn').value = "0";
    //alert('Logging out...');
    // Handle logout logic  
}
