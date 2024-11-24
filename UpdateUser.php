<?php
session_start();
include 'Database.php';

$data = json_decode(file_get_contents("php://input"), true);
$validRoles = ["Member", "Staff", "JuniorAdmin", "SeniorAdmin"];

if (isset($data['id'], $data['username'], $data['role'], $data['email'], $data['password'], $data['phone'], $data['dateofbirth'])) {
    $role = $data['role'];
    $password = trim($data['password']); // Trim whitespace from password
    $dateofbirth = $data['dateofbirth'];

    if($data['username'] == '' || $data['email'] == '' || $data['phone'] == '' || $data['dateofbirth'] == ''){
        echo json_encode(['success' => false, 'message' => 'Empty Input']);
        exit;
    }

    // Check if role is valid
    if (!in_array($role, $validRoles)) {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
        exit;
    }

    // Check if password length is at least 8 characters
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Minimum password must contain 8 letters/numbers']);
        exit;
    }

    // Check if minimum age is met
    $dob = new DateTime($dateofbirth);
    $currentDate = new DateTime();
    $age = $currentDate->diff($dob)->y;

    // Check if the date of birth is in the future
    if ($dob > $currentDate) {
        echo json_encode(['success' => false, 'message' => 'Date of birth cannot be in the future']);
        exit;
    }

    if ($age < 3) {
        echo json_encode(['success' => false, 'message' => '3 Years old are not allowed']);
        exit;
    }
    if ($age < 0) {
        echo json_encode(['success' => false, 'message' => 'Youre a wizard harry']);
        exit;
    } 

    $id = $data['id'];
    $username = $conn->real_escape_string($data['username']);
    $email = $conn->real_escape_string($data['email']);
    $password = $conn->real_escape_string($data['password']);
    $phone = $conn->real_escape_string($data['phone']);
    $dateofbirth = $conn->real_escape_string($data['dateofbirth']);

    // Ensure SQL query is correct for updating the user data
    $sql = "UPDATE UsersTable SET Username='$username', Role='$role', Email='$email', Password='$password', PhoneNumber='$phone', DateOfBirth='$dateofbirth' WHERE ID='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
}

$conn->close();
