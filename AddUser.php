<?php
session_start();
include 'Database.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['username'], $data['role'], $data['email'], $data['password'], $data['phone'], $data['dateofbirth'])) {
    $username = $conn->real_escape_string($data['username']);
    $role = $conn->real_escape_string($data['role']);
    $email = $conn->real_escape_string($data['email']);
    $password = $conn->real_escape_string($data['password']);
    $phone = $conn->real_escape_string($data['phone']);
    $dateofbirth = $conn->real_escape_string($data['dateofbirth']);

    $sql = "INSERT INTO UsersTable (Username, Role, Email, Password, PhoneNumber, DateOfBirth) 
            VALUES ('$username', '$role', '$email', '$password', '$phone', '$dateofbirth')";

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
