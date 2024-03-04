<?php
// Include database connection
include 'database/db.php';

// Query to fetch events from the database
$query = "SELECT * FROM events";

// Perform the query
$result = mysqli_query($conn, $query);

// Prepare data to be sent as JSON
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Send JSON response
echo json_encode(['data' => $data]);

// Close database connection
mysqli_close($conn);
?>
