<?php
// Start session and check if the user is logged in
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: AdminLogin.php");
    exit;
}

// Check Role//
$role = $_SESSION['active_role']; 

if ($role == 'Staff') {
    echo "<h2>Only Admins are allowed.</h2>";
    exit;
} 

include 'Database.php';

// Fetch users from the database
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM UsersTable WHERE Username LIKE '%$searchTerm%' OR Role LIKE '%$searchTerm%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="Goto Grocery Admin Edit Users">
    <meta name="keywords" content="Goto Grocery, Admin">
    <meta name="author" content="G1">
    <title>Goto Grocery Admin Edit Users</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="styles/AdminEditUser_style.css" rel="stylesheet">
</head>

<!-- Navigation Sidebar -->
<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="images/admin.png" alt="logo">
            </span>
            <div class="text header-text">
                <span class="name"><?php echo $_SESSION['active_username']; ?></span>
                <span class="profession"><?php echo $_SESSION['active_role']; ?></span>
            </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>
    <div class="menu-bar">
        <div class="menu">
            <li class="search-box">
                <i class="bx bx-search icon"></i>
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchUser()">
            </li>
            <ul class="menu-links">
                <li class="nav-link"><a href="AdminHome.php"><i class="bx bx-home-alt icon"></i><span class="text nav-text">Dashboard</span></a></li>
                <li class="nav-link"><a href="AdminProduct.php"><i class="bx bx-box icon"></i><span class="text nav-text">Products</span></a></li>
                <li class="nav-link"><a href="AdminReport.php"><i class="bx bxs-report icon"></i><span class="text nav-text">Reports</span></a></li>
                <li class="nav-link"><a href="AdminStockOrder.php"><i class="bx bx-cart-add icon"></i><span class="text nav-text">Stock Ordering</span></a></li>
                <li class="nav-link"><a href="#"><i class="bx bx-bell icon"></i><span class="text nav-text">Notification</span></a></li>
                <li class="nav-link"><a href="AdminProfile.php"><i class="bx bxs-user-detail icon"></i><span class="text nav-text">Profile</span></a></li>
                <li class="nav-link"><a href="AdminEditUser.php"><i class="bx bxs-user-detail icon"></i><span class="text nav-text">Edit User</span></a></li>
            </ul>
        </div>
        <div class="bottom-content">
            <li><a href="AdminLogin.php?logout=true"><i class="bx bx-log-out icon"></i><span class="text nav-text">Logout</span></a></li>
            <li class="mode"><div class="moon-sun"><i class="bx bx-moon icon moon"></i><i class="bx bx-sun icon sun"></i></div><span class="mode-text text">Dark Mode</span><div class="toggle-switch"><span class="switch"></span></div></li>
        </div>
    </div>
</nav>

<!-- User List Section -->
<section class="home">
    <div class="text">Edit Users</div>
    <div class="container">
        <form method="GET" action="AdminEditUser.php">
        <input type="text" name="search" class="SearchInputUsers" placeholder="Search by username or role" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" class="SearchUsers">Search</button>
        </form>
            

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone Number</th>
                    <th>DateOfBirth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Role']}</td>
                            <td>{$row['Username']}</td>
                            <td>{$row['Email']}</td>
                            <td>{$row['Password']}</td>
                            <td>{$row['PhoneNumber']}</td>
                            <td>{$row['DateOfBirth']}</td>
                            <td>
                                <a href='javascript:void(0);' onclick=\"openEditPopup({$row['ID']}, '{$row['Username']}', '{$row['Role']}', '{$row['Email']}', '{$row['Password']}', '{$row['PhoneNumber']}', '{$row['DateOfBirth']}')\">Edit</a> |
                                <a href='javascript:void(0);' onclick='showDeletePopup({$row['ID']})'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <button class="add-user-button" onclick="openAddPopup()">Add User</button>
    </div>
</section>

<!-- Edit User Popup Form -->
<div id="overlay" class="overlay" onclick="closeEditPopup()"></div>
<div id="editUserPopup" class="popup-form">
    <span class="close-button" onclick="closeEditPopup()">&times;</span>
    <h2>Edit User</h2>
    <form action="UpdateUser.php" method="POST">
        <input type="hidden" id="editUserId" name="id">
        <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" id="editUsername" name="username" required>
        </div>
        <div class="form-group">
            <label for="editRole">Role</label>
            <input type="text" id="editRole" name="role" required>
        </div>
        <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" id="editEmail" name="email" required>
        </div>
        <div class="form-group">
            <label for="editPassword">Password</label>
            <input type="text" id="editPassword" name="password" required>
        </div>
        <div class="form-group">
            <label for="editPhone">Phone Number</label>
            <input type="text" id="editPhone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="editDateOfBirth">DateOfBirth</label>
            <input type="text" id="editDateOfBirth" name="dateofbirth" required>
        </div>
        <div class="button-group">
            <button type="button" onclick="saveUserChanges()">Save Changes</button>
        </div>
    </form>
</div>
<!-- Add User Popup Form -->
<div id="editUserPopup" class="popup-form">
    <span class="close-button" onclick="closeEditPopup()">&times;</span>
    <h2 id="popupTitle">Edit User</h2>
    <form action="UpdateOrAddUser.php" method="POST" id="userForm">
        <input type="hidden" id="editUserId" name="id">
        <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" id="editUsername" name="username" required>
        </div>
        <div class="form-group">
            <label for="editRole">Role</label>
            <input type="text" id="editRole" name="role" required>
        </div>
        <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" id="editEmail" name="email" required>
        </div>
        <div class="form-group">
            <label for="editPassword">Password</label>
            <input type="text" id="editPassword" name="password" required>
        </div>
        <div class="form-group">
            <label for="editPhone">Phone Number</label>
            <input type="text" id="editPhone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="editDateOfBirth">DateOfBirth</label>
            <input type="text" id="editDateOfBirth" name="dateofbirth" required>
        </div>
    </form>
</div>

<!-- Confirmation Popup for Deleting a User -->
<div id="deletePopup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
        <h3>Are you sure you want to delete this user?</h3>
        <div class="button-group">
            <button id="confirmDeleteBtn" class="confirm-btn">Yes</button>
            <button id="cancelDeleteBtn" class="cancel-btn" onclick="closeDeletePopup()">No</button>
        </div>
    </div>
</div>

<!-- Script for admin side bar -->
<script src="scripts/adminsidebar.js"></script>
<!-- Script for changing user data -->
<script src="scripts/EditUserData.js"></script>
<!-- Script for popup form -->
<script src="scripts/AdminEditUserPopup.js"></script>
</body>
</html>