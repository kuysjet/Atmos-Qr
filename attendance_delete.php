<?php
// Include the database connection file
include 'database/db.php';

// Check if attendance_id is set in the request
if (!isset($_POST['attendance_id'])) {
    echo json_encode(array('error' => 'Attendance ID is not provided'));
    exit();
}

// Retrieve attendance_id from the request
$attendance_id = $_POST['attendance_id'];

// Perform the deletion query
$query = "DELETE FROM attendance WHERE id = $attendance_id";

if (mysqli_query($conn, $query)) {
    echo json_encode(array('success' => 'Attendance record deleted successfully'));
} else {
    echo json_encode(array('error' => 'Error deleting attendance record: ' . mysqli_error($conn)));
}

mysqli_close($conn);
?>
