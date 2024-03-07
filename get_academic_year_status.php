<?php
// Include database connection code
include 'database/db.php';

// Check if academic year ID is provided
if (isset($_GET['academic_year_id'])) {
    // Extract academic year ID from the GET parameters
    $academic_year_id = $_GET['academic_year_id'];

    // Prepare SELECT statement to retrieve the status of the academic year
    $stmt = $conn->prepare("SELECT status FROM academic_years WHERE ID = ?");
    
    // Bind parameter
    $stmt->bind_param("i", $academic_year_id);
    
    // Execute statement
    $stmt->execute();
    
    // Bind result variables
    $stmt->bind_result($status);
    
    // Fetch result
    $stmt->fetch();
    
    // Close statement
    $stmt->close();

    // Check if status is retrieved successfully
    if ($status !== null) {
        // Return JSON response with the status
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status));
        exit; // Terminate script execution after sending response
    } else {
        // Return JSON response with an error message if status is not found
        header('Content-Type: application/json');
        echo json_encode(array("status" => "error", "message" => "Academic year status not found"));
        exit; // Terminate script execution after sending response
    }
} else {
    // Return JSON response with an error message if academic year ID is not provided
    header('Content-Type: application/json');
    echo json_encode(array("status" => "error", "message" => "Academic year ID not provided"));
    exit; // Terminate script execution after sending response
}

// Close database connection
mysqli_close($conn);
?>
