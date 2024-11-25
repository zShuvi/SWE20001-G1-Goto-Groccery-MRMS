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
    <link href="styles/EditUserStyle.css" rel="stylesheet">
</head>

    <!-- Navigation Sidebar -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">

                <span class="image">
                    <img src=<?php echo $_SESSION["profile_picture"]; ?> alt="Profile Picture" onerror="this.src='images/admin.png';">
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
                        <input type="text" placeholder="Search.....">
                </li>

                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="AdminHome.php">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="AdminProduct.php">
                            <i class="bx bx-box icon"></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>

                    

                    <li class="nav-link">
                        <a href="AdminReport.php">
                            <i class="bx bxs-report icon"></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="AdminStockOrder.php">
                            <i class="bx bx-cart-add icon"></i>
                            <span class="text nav-text">Stock Ordering</span>
                        </a>
                    </li>


                    <li class="nav-link">
                        <a href="AdminNotification.php">
                            <i class="bx bx-bell icon"></i>
                            <span class="text nav-text">Notification</span>
                        </a>
                    </li>

                   
                    <li class="nav-link">
                        <a href="AdminProfile.php">
                            <i class="bx bxs-user-detail icon"></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>

                    <?php
                        if (!($_SESSION['active_role'] == "Staff")){
                            echo'
                                <li class="">
                                    <a href="AdminEditUser.php">
                                        <i class="bx bx-edit icon"></i>
                                        <span class="text nav-text">EditUser</span>
                                    </a>
                                </li>                            
                            ';
                        }
                    ?>
                </ul>
            </div>

            <div class="bottom-content">

                <li class="">
                    <a href="AdminLogin.php?logout=true">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>

                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
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
                    <th>Gender</th>
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
                            <td>{$row['Gender']}</td>
                            <td>
                                <a href='javascript:void(0);' onclick=\"openEditPopup({$row['ID']}, '{$row['Username']}', '{$row['Role']}', '{$row['Email']}', '{$row['Password']}', '{$row['PhoneNumber']}', '{$row['DateOfBirth']}', '{$row['Gender']}')\">Edit</a> |
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
<!-- Edit User Popup Form -->
<div id="overlay" class="overlay" onclick="closeEditPopup(); closeAddPopup()"></div>
<div id="editUserPopup" class="popup-form">
    <span class="close-button" onclick="closeEditPopup()">&times;</span>
    <h2>Edit User</h2>
    <form id="userForm">
        <input type="hidden" id="editUserId" name="id">

        <!-- Username Field -->
        <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" id="editUsername" name="username" required>
        </div>

        <!-- Role Dropdown -->
        <div class="form-group">
            <label for="editRole">Role</label>
            <select id="editRole" name="role" required>
                <option value="">Select Role</option>
                <option value="Member">Member</option>
                <option value="Staff">Staff</option>
                <option value="JuniorAdmin">JuniorAdmin</option>
                <option value="SeniorAdmin">SeniorAdmin</option>
            </select>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" id="editEmail" name="email" required>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="editPassword">Password</label>
            <input type="password" id="editPassword" name="password" required>
        </div>

        <!-- Phone Number Field -->
        <div class="form-group">
            <label for="editPhone">Phone Number</label>
            <input type="text" id="editPhone" name="phone" required>
        </div>

        <!-- Date of Birth Field -->
        <div class="form-group">
            <label for="editDateOfBirth">Date of Birth</label>
            <input type="date" id="editDateOfBirth" name="dateofbirth" required>
        </div>

        <!-- Gender Field -->
        <div class="form-group">
            <label for="editGender">Gender:</label>
            <select id="editGender" name="edit_gender" required>
                <option value="">Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="button" onclick="saveUserChanges()">Save Changes</button>
        </div>
    </form>
</div>



<!-- Add User Popup -->
<div id="addUserPopup" class="popup-form">
    <span class="close-button" onclick="closeAddPopup()">&times;</span>
    <!-- Title placed above the form -->
    <h2 id="popupTitle">Add User</h2>

    <form action="AddUser.php" method="POST" id="userForm">
        <!-- Hidden Field for User ID -->
        <input type="hidden" id="addUserId" name="id">

        <!-- Username Field -->
        <div class="form-group">
            <label for="addUsername">Username:</label>
            <input type="text" id="addUsername" name="add_username" required>
        </div>

        <!-- Role Dropdown -->
        <div class="form-group">
            <label for="addRole">Role:</label>
            <select id="addRole" name="add_role" required>
                <option value="">Select Role</option>
                <option value="Member">Member</option>
                <option value="Staff">Staff</option>
                <option value="JuniorAdmin">JuniorAdmin</option>
                <option value="SeniorAdmin">SeniorAdmin</option>
            </select>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="addEmail">Email:</label>
            <input type="email" id="addEmail" name="add_email" required>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="addPassword">Password:</label>
            <input type="password" id="addPassword" name="add_password" pattern="^.{8,}$" 
            title="Must contain at least 8 or more characters" required>
        </div>

        <!-- Phone Number Field -->
        <div class="form-group">
            <label for="addPhone">Phone Number:</label>
            <input type="text" id="addPhone" name="add_phone" required>
        </div>

        <!-- Date of Birth Field -->
        <div class="form-group">
            <label for="addDateOfBirth">Date of Birth:</label>
            <input type="date" id="addDateOfBirth" name="add_dateofbirth" required>
        </div>

        <!-- Gender Field -->
        <div class="form-group">
            <label for="addDGender">Gender:</label>
            <select id="addGender" name="add_gender" required>
                <option value="">Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="submit">Save Changes</button>
            <button type="button" class="cancel-btn" onclick="closeAddPopup()">Cancel</button>
        </div>
    </form>
</div>

<!-- Dark background overlay (covers the rest of the screen) -->
<div id="overlay" class="overlay" onclick="closeEditPopup()"></div>

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
