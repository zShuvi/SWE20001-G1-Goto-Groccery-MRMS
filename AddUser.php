<?php
session_start();
include 'Database.php';

$validRoles = ["Member", "Staff", "JuniorAdmin", "SeniorAdmin"];

// Check if required POST data is available
if (isset($_POST['add_username'], $_POST['add_role'], $_POST['add_email'], $_POST['add_password'], $_POST['add_phone'], $_POST['add_dateofbirth'])) {
    $role = $_POST['add_role'];
    $password = trim($_POST['add_password']); // Trim whitespace from password
    $dateofbirth = $_POST['add_dateofbirth'];

    // Check if role is valid
    if (!in_array($role, $validRoles)) {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
        exit;
    }

    // Check if password length is at least 8 characters
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Minimum password must contain 8 characters']);
        exit;
    }

    // Check if minimum age is met
    $dob = new DateTime($dateofbirth);
    $currentDate = new DateTime();
    $age = $currentDate->diff($dob)->y;

    if ($age < 3) {
        echo json_encode(['success' => false, 'message' => '3 years old are not allowed']);
        exit;
    }
    if ($age < 0) {
        echo json_encode(['success' => false, 'message' => 'You\'re a wizard Harry']);
        exit;
    }

    $username = $conn->real_escape_string($_POST['add_username']);
    $email = $conn->real_escape_string($_POST['add_email']);
    $password = $conn->real_escape_string($_POST['add_password']);
    $phone = $conn->real_escape_string($_POST['add_phone']);
    $dateofbirth = $conn->real_escape_string($_POST['add_dateofbirth']);

    $sql = "INSERT INTO UsersTable (Username, Role, Email, Password, PhoneNumber, DateOfBirth) 
            VALUES ('$username', '$role', '$email', '$password', '$phone', '$dateofbirth')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to AdminEditUser.php after successful insert
        header("Location: AdminEditUser.php"); 
        exit; // Ensure no further code is executed
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
}

$conn->close();

