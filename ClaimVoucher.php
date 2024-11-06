<?php
session_start();
require_once 'Database.php';

header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if (isset($_SESSION['active_user']) && isset($_POST['voucherid'])) {
    $userID = $_SESSION['active_user'];
    $voucherID = $_POST['voucherid'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Retrieve user points
        $sql = "SELECT Points FROM UsersTable WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("SQL prepare error: " . $conn->error);
        }
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $userResult = $stmt->get_result()->fetch_assoc();
        $userPoints = $userResult['Points'] ?? 0;
        $stmt->close();

        // Retrieve voucher requirements and code
        $sql = "SELECT ReqPoints, Code FROM VouchersTable WHERE VoucherID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("SQL prepare error: " . $conn->error);
        }
        $stmt->bind_param("i", $voucherID);
        $stmt->execute();
        $voucherResult = $stmt->get_result()->fetch_assoc();
        $voucherPoints = $voucherResult['ReqPoints'] ?? 0;
        $voucherCode = $voucherResult['Code'] ?? '';
        $stmt->close();

        // Check if user has enough points
        if ($userPoints >= $voucherPoints) {
            // Deduct points from the user
            $newPoints = $userPoints - $voucherPoints;
            $updateSql = "UPDATE UsersTable SET Points = ? WHERE ID = ?";
            $updateStmt = $conn->prepare($updateSql);
            if ($updateStmt === false) {
                throw new Exception("SQL prepare error: " . $conn->error);
            }
            $updateStmt->bind_param("ii", $newPoints, $userID);
            $updateStmt->execute();
            $updateStmt->close();

            // Insert into VoucherOwn table to mark voucher as claimed with the voucher code
            $insertSql = "INSERT INTO VoucherOwn (User_ID, Voucher_ID, VoucherCode) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            if ($insertStmt === false) {
                throw new Exception("SQL prepare error: " . $conn->error);
            }
            $insertStmt->bind_param("iis", $userID, $voucherID, $voucherCode);
            $insertStmt->execute();
            $insertStmt->close();

            // Update the voucher's IsClaimed status to 1
            $updateClaimedSql = "UPDATE VouchersTable SET IsClaimed = 1 WHERE VoucherID = ?";
            $updateClaimedStmt = $conn->prepare($updateClaimedSql);
            if ($updateClaimedStmt === false) {
                throw new Exception("SQL prepare error: " . $conn->error);
            }
            $updateClaimedStmt->bind_param("i", $voucherID);
            $updateClaimedStmt->execute();
            $updateClaimedStmt->close();

            // Commit transaction
            $conn->commit();

            // Prepare success response
            $response["success"] = true;
            $response["message"] = "Voucher claimed successfully!";
        } else {
            // Insufficient points error
            $response["message"] = "Insufficient points to claim this voucher.";
        }
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        $response["message"] = "An error occurred while claiming the voucher. Please try again.";
        error_log($e->getMessage());
    }
} else {
    $response["message"] = "Invalid access.";
}

// Send JSON response
echo json_encode($response);
$conn->close();
?>


