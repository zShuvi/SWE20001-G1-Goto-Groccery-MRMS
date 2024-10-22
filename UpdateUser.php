<?php
session_start();
include 'Database.php'; // Include your database connection

// Get the raw POST data and decode the JSON
$data = json_decode(file_get_contents("php://input"), true);

// Check if all required fields are available
if (isset($data['id'], $data['username'], $data['role'], $data['email'], $data['password'], $data['phone'], $data['dateofbirth'])) {
    $id = $data['id'];
    $username = $conn->real_escape_string($data['username']);
    $role = $conn->real_escape_string($data['role']);
    $email = $conn->real_escape_string($data['email']);
    $password = $conn->real_escape_string($data['password']); // Be sure to hash the password before saving
    $phone = $conn->real_escape_string($data['phone']);
    $dateofbirth = $conn->real_escape_string($data['dateofbirth']);

    // Update the user in the database
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
?>