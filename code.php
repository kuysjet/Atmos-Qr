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
            // Store user information in session variables
            $_SESSION['username'] = $username;
            $_SESSION['user_type_id'] = $user['user_type_id']; // Assuming 'user_type_id' is a column in the users table

            // Redirect based on user type
            switch ($user['user_type_id']) {
                case 1: // Assuming user_type_id 1 represents 'Administrator'
                    header('Location: admin_dashboard.php');
                    exit(); // Stop further execution
                case 2: // Assuming user_type_id 2 represents 'Registrar'
                    header('Location: registrar_dashboard.php');
                    exit(); // Stop further execution
                // Add more cases for other user types as needed
            }
        } else {
            // Password is incorrect, redirect to login page with error parameter
            header('Location: index.php?error=invalid_password');
            exit(); // Stop further execution
        }
    } else {
        // Username is incorrect, redirect to login page with error parameter
        header('Location: index.php?error=user_not_found');
        exit(); // Stop further execution
    }
}
?>
