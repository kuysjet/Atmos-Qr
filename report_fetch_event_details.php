<?php
// Include database connection
include 'database/db.php';

if(isset($_POST['eventId']) && is_numeric($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Prepare and execute query to fetch event details
    $query = "SELECT *, DATE_FORMAT(event_date, '%W, %M %e, %Y') AS event_date, 
              TIME_FORMAT(log_in, '%h:%i %p') AS log_in, 
              TIME_FORMAT(log_out, '%h:%i %p') AS log_out
              FROM events WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Event details found, return them as JSON
        $eventData = mysqli_fetch_assoc($result);
        echo json_encode($eventData);
    } else {
        // No event found with the given ID
        echo json_encode(['error' => 'Event not found']);
    }
} else {
    // If no event ID is provided in the request or it's not numeric
    echo json_encode(['error' => 'Invalid event ID']);
}
?>
