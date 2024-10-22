<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: AdminLogin.php");
    exit;
}

include 'Database.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);  // Ensure the ID is an integer

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM UsersTable WHERE ID = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Redirect back to AdminEditUser.php with a success message
        header("Location: AdminEditUser.php?message=User+deleted+successfully");
    } else {
        // Handle error (optional)
        header("Location: AdminEditUser.php?error=Failed+to+delete+user");
    }
    $stmt->close();
} else {
    header("Location: AdminEditUser.php");
}

$conn->close();
?>
