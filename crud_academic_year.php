<?php
// Include database connection code
include 'database/db.php';

// Fetch data from academic_years table
$query = "SELECT ID, academic_year, status FROM academic_years";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch data and store in an array
$academicYears = array();
while ($row = mysqli_fetch_assoc($result)) {
    $academicYears[] = $row;
}

// Function to add a new academic year to the database
function addAcademicYear($conn, $academicYear) {
    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO academic_years (academic_year, status) VALUES (?, 'active')");
    
    // Bind parameter
    $stmt->bind_param("s", $academicYear);
    
    // Execute statement
    if ($stmt->execute()) {
        // Insertion successful
        return true;
    } else {
        // Insertion failed
        return false;
    }
}

// Check if form data is received for adding new academic year
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['academic_year'])) {
    // Extract form data
    $academicYear = $_POST['academic_year'];

    // Call addAcademicYear function to insert data
    if (addAcademicYear($conn, $academicYear)) {
        // Insertion successful
        $response = array("status" => "success");
    } else {
        // Insertion failed
        $response = array("status" => "error");
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Terminate script execution after sending response
}

// Check if form data is received for updating status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['academic_year_id']) && isset($_POST['status'])) {
    // Extract academic year ID and status from the POST data
    $academic_year_id = $_POST['academic_year_id'];
    $status = $_POST['status'];

    // Prepare UPDATE statement
    $stmt = $conn->prepare("UPDATE academic_years SET status = ? WHERE ID = ?");
    
    // Bind parameters
    $stmt->bind_param("si", $status, $academic_year_id);
    
    // Execute statement
    if ($stmt->execute()) {
        // Update successful
        $response = array("status" => "success");
    } else {
        // Update failed
        $response = array("status" => "error", "message" => "Failed to update academic year status");
    }

    // Close statement
    $stmt->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Terminate script execution after sending response
}

// Check if form data is received for deleting academic year
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['academic_year_id'])) {
    // Extract academic year ID from the POST data
    $academic_year_id = $_POST['academic_year_id'];

    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM academic_years WHERE ID = ?");
    
    // Bind parameter
    $stmt->bind_param("i", $academic_year_id);
    
    // Execute statement
    if ($stmt->execute()) {
        // Deletion successful
        $response = array("status" => "success", "message" => "Academic year deleted successfully");
    } else {
        // Deletion failed
        $response = array("status" => "error", "message" => "Failed to delete academic year");
    }

    // Close statement
    $stmt->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Terminate script execution after sending response
}

// Close database connection
mysqli_close($conn);

// Output JSON data for academic years
echo json_encode(array("data" => $academicYears));
?>
