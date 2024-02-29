<?php
// Include database connection code
include 'database/db.php';

// Check if form data is received for adding a new user, updating user status, updating user data, or deleting a user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form data is received for adding a new user
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
        // Extract form data for adding a new user
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch the user type ID for "registrar"
        $userTypeQuery = "SELECT id FROM user_types WHERE name = 'registrar'";
        $userTypeResult = $conn->query($userTypeQuery);

        if ($userTypeResult && $userTypeResult->num_rows > 0) {
            $userTypeRow = $userTypeResult->fetch_assoc();
            $user_type_id = $userTypeRow['id'];

            // Prepare and execute INSERT statement
            $insertQuery = "INSERT INTO users (firstname, lastname, email, username, password, user_type_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssssi", $firstname, $lastname, $email, $username, $password, $user_type_id);

            if ($stmt->execute()) {
                // User added successfully
                echo json_encode(array("status" => "success"));
            } else {
                // Failed to add user
                echo json_encode(array("status" => "error", "message" => "Failed to add user"));
            }

            // Close statement
            $stmt->close();
        } else {
            // User type "registrar" not found
            echo json_encode(array("status" => "error", "message" => "User type 'registrar' not found"));
        }
    } elseif (isset($_POST['userId']) && isset($_POST['status'])) {
        // Check if form data is received for updating status
        // Extract user ID and status from the POST data
        $userId = $_POST['userId'];
        $status = $_POST['status'];

        // Validate status
        if (!in_array($status, ['active', 'inactive'])) {
            echo json_encode(array("status" => "error", "message" => "Invalid status"));
            exit;
        }

        // Prepare and execute UPDATE statement
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $userId);

        if ($stmt->execute()) {
            // Update successful
            echo json_encode(array("status" => "success"));
        } else {
            // Update failed
            echo json_encode(array("status" => "error", "message" => "Failed to update user status"));
        }

        // Close statement
        $stmt->close();
    } elseif (isset($_POST['userId']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['username'])) {
        // Check if form data is received for updating user data
        // Extract user ID and updated user information from the POST data
        $userId = $_POST['userId'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        // Prepare and execute UPDATE statement
        $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, username = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstname, $lastname, $email, $username, $userId);

        if ($stmt->execute()) {
            // Update successful
            echo json_encode(array("status" => "success"));
        } else {
            // Update failed
            echo json_encode(array("status" => "error", "message" => "Failed to update user data"));
        }

        // Close statement
        $stmt->close();
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
        // Check if form data is received for deleting a user
        // Extract user ID from the POST data
        $userId = $_POST['userId'];

        // Prepare and execute DELETE statement
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            // Deletion successful
            echo json_encode(array("status" => "success", "message" => "User deleted successfully"));
        } else {
            // Deletion failed
            echo json_encode(array("status" => "error", "message" => "Failed to delete user: " . $stmt->error));
        }

        // Close statement
        $stmt->close();
    } else {
        // Invalid request
        echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch data from users table, excluding users with user type "administrator"
    $query = "SELECT id, firstname, lastname, email, username, status 
              FROM users 
              WHERE user_type_id != (SELECT id FROM user_types WHERE name = 'administrator')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $users = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        echo json_encode(array("data" => $users));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch users"));
        http_response_code(500); // Internal Server Error
    }
}

// Close database connection
mysqli_close($conn);
?>
