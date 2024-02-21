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
            // Get user role
            $userTypeId = $user['user_type_id'];
            $roleQuery = "SELECT * FROM user_types WHERE id = $userTypeId";
            $roleResult = mysqli_query($conn, $roleQuery);
            $roleRow = mysqli_fetch_assoc($roleResult);

            // Redirect based on role
            switch ($roleRow['name']) {
                case 'Administrator':
                    header('Location: admin_dashboard.php');
                    break;
                case 'Registrar':
                    header('Location: registrar_dashboard.php');
                    break;
            }
        } else {
            // Password is incorrect, keep username and clear password
            $_SESSION['error'] = 'invalid_password';
            $_SESSION['username'] = $username;
            // Redirect to login page with error parameter
            header('Location: index.php?error=invalid_password');
        }
    } else {
        // Username is incorrect, clear both fields
        $_SESSION['error'] = 'user_not_found';
        unset($_SESSION['username']);
        // Redirect to login page with error parameter
        header('Location: index.php?error=user_not_found');
    }
}
?>
