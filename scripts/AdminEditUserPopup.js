// Edit User popup form
function openEditPopup(id, username, role, email, phone, dateofbirth) {
    document.getElementById("editUserPopup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("editUserId").value = id;
    document.getElementById("editUsername").value = username;
    document.getElementById("editRole").value = role;
    document.getElementById("editEmail").value = email;
    document.getElementById("editPhone").value = phone;
    document.getElementById("editDateOfBirth").value = dateofbirth;
}

function closeEditPopup() {
    document.getElementById("editUserPopup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

// Add user popup form
function openAddPopup() {
    document.getElementById("editUserPopup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("editUserId").value = ""; // Ensure ID is empty for adding
    document.getElementById("editUsername").value = "";
    document.getElementById("editRole").value = "";
    document.getElementById("editEmail").value = "";
    document.getElementById("editPassword").value = "";
    document.getElementById("editPhone").value = "";
    document.getElementById("editDateOfBirth").value = "";
}

// Delete User confirmation popup

let userIdToDelete = null;

function showDeletePopup(userId) {
    userIdToDelete = userId;  // Store the user ID to delete
    document.getElementById('deletePopup').style.display = 'block';  // Show the popup
}

function closeDeletePopup() {
    document.getElementById('deletePopup').style.display = 'none';  // Hide the popup
    userIdToDelete = null;  // Clear the stored user ID
}

document.getElementById('confirmDeleteBtn').onclick = function() {
    if (userIdToDelete) {
        window.location.href = `DeleteUser.php?id=${userIdToDelete}`;  // Redirect to delete script
    }
}

