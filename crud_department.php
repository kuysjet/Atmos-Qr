<?php
// Include database connection code
include 'database/db.php';

// Fetch data from Departments table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT ID, DepartmentName FROM Departments";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $departments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $departments[] = $row;
        }
        echo json_encode(array("data" => $departments));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch departments"));
        http_response_code(500); // Internal Server Error
    }
}

// Add a new department to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department'])) {
    $department = $_POST['department'];

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO Departments (DepartmentName) VALUES (?)");
    $stmt->bind_param("s", $department);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to add department"));
        http_response_code(500); // Internal Server Error
    }
}

// Update department
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editDepartmentId'])) {
    $departmentId = $_POST['editDepartmentId'];
    $department = $_POST['editDepartmentName'];

    // Prepare UPDATE statement
    $stmt = $conn->prepare("UPDATE Departments SET DepartmentName=? WHERE ID=?");
    $stmt->bind_param("si", $department, $departmentId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to update department"));
        http_response_code(500); // Internal Server Error
    }
}

// Delete department
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department_id'])) {
    $department_id = $_POST['department_id'];
    
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM Departments WHERE ID = ?");
    $stmt->bind_param("i", $department_id);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Department deleted successfully'));
        http_response_code(200); // OK
    } else {
        echo json_encode(array('error' => 'Failed to delete department'));
        http_response_code(500); // Internal Server Error
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
    http_response_code(400); // Bad Request
}
?>
