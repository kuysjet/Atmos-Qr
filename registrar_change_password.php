<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: index.php');
    exit(); // Stop further execution
}

// Include database connection
include 'database/db.php';

// Get current user's username
$username = $_SESSION['username'];

// Get form data
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

// Validate form data (you might want to add more validation)
if (empty($currentPassword) || empty($newPassword)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit();
}

// Check if the current password is correct
$query = "SELECT password FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'An error occurred while fetching user data.']);
    exit();
}

$row = mysqli_fetch_assoc($result);
$storedPassword = $row['password'];

// Verify the current password
if ($currentPassword !== $storedPassword) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    exit();
}

// Update the password in the database
$updateQuery = "UPDATE users SET password = ? WHERE username = ?";
$updateStmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($updateStmt, 'ss', $newPassword, $username);
$updateResult = mysqli_stmt_execute($updateStmt);

if ($updateResult) {
    echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'An error occurred while updating the password.']);
}

?>
