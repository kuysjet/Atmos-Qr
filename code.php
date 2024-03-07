<?php
session_start();

include 'database/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to find the user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {
            // Check if user is active
            if ($user['status'] == 'active') {
                // Check user type
                switch ($user['user_type_id']) {
                    case 1: // Administrator
                        $_SESSION['username'] = $username;
                        $_SESSION['user_type_id'] = $user['user_type_id'];
                        header('Location: admin_dashboard.php');
                        exit(); // Stop further execution
                    case 2: // Registrar
                        $_SESSION['username'] = $username;
                        $_SESSION['user_type_id'] = $user['user_type_id'];
                        header('Location: registrar_dashboard.php');
                        exit(); // Stop further execution
                    default:
                        // Unsupported user type, redirect to login page with error parameter
                        header('Location: index.php?error=unsupported_user_type');
                        exit(); // Stop further execution
                }
            } else {
                // User is inactive, redirect to login page with error parameter
                header('Location: index.php?error=user_inactive');
                exit(); // Stop further execution
            }
        } else {
            // Password is incorrect, redirect to login page with error parameter
            header('Location: index.php?error=invalid_password');
            exit(); // Stop further execution
        }
    } else {
        // Username not found, redirect to login page with error parameter
        header('Location: index.php?error=user_not_found');
        exit(); // Stop further execution
    }
}
?>
