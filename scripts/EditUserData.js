// Function to handle the Save Changes action with AJAX
function saveUserChanges() {
    // Get form field values
    const id = document.getElementById("editUserId").value; // Empty if adding a new user
    const username = document.getElementById("editUsername").value;
    const role = document.getElementById("editRole").value;
    const email = document.getElementById("editEmail").value;
    const password = document.getElementById("editPassword").value;
    const phone = document.getElementById("editPhone").value;
    const dateofbirth = document.getElementById('editDateOfBirth').value;
    // Create the form data to send in the AJAX request
    const formData = {
        id: id,                  // Used to differentiate between add and update
        username: username,      
        role: role,              
        email: email,            
        password: password,      
        phone: phone, 
        dateofbirth: dateofbirth    
    };

    // Determine if it's an Add or Update based on the presence of the id
    const url = id ? 'UpdateUser.php' : 'AddUser.php';

    // Send the data using Fetch API
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Check if it's an Add or Update based on the presence of ID
            alert(id ? "User updated successfully!" : "User added successfully!");
            closeEditPopup();   // Close the popup
            location.reload();  // Reload the page to see the changes
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again.");
    });
}
