<?php
// Include database connection
include 'database/db.php';

// Function to calculate the status of an event
function calculateEventStatus($eventDate, $logoutTime) {
    $currentDateTime = date('Y-m-d H:i:s');

    if ($eventDate > date('Y-m-d')) {
        return 'Pending';
    } elseif ($eventDate == date('Y-m-d') && $logoutTime > $currentDateTime) {
        return 'Ongoing';
    } else {
        return 'Done';
    }
}

// Check request method and perform corresponding CRUD operation
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Query to fetch events from the database
    $query = "SELECT *, 
                CASE
                    WHEN (event_date > CURDATE()) THEN 'Pending'
                    WHEN (event_date = CURDATE() AND log_out > NOW()) THEN 'Ongoing'
                    ELSE 'Done'
                END AS status
              FROM events";
    
    // Perform the query
    $result = mysqli_query($conn, $query);
    
    // Prepare data to be sent as JSON
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate status based on event date and log_out time
        $row['status'] = calculateEventStatus($row['event_date'], $row['log_out']);
        $data[] = $row;
    }
    
    // Send JSON response
    echo json_encode(['data' => $data]);
    
    // Close database connection
    mysqli_close($conn);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the operation is INSERT or UPDATE
    if (isset($_POST['academicYear'], $_POST['eventName'], $_POST['venue'], $_POST['description'], $_POST['eventDate'], $_POST['loginTime'], $_POST['logoutTime'], $_POST['registrar'])) {
        // Retrieve data from POST request
        $academicYearID = $_POST['academicYear'];
        $eventName = $_POST['eventName'];
        $eventVenue = $_POST['venue'];
        $description = $_POST['description'];
        $eventDate = $_POST['eventDate'];
        $loginTime = $_POST['loginTime'];
        $logoutTime = $_POST['logoutTime'];
        $registrarID = $_POST['registrar'];

        // Prepare SQL statement for insertion
        $query = "INSERT INTO events (academic_year_id, event_name, event_venue, description, event_date, log_in, log_out, registrar_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, $query);
        
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "issssssi", $academicYearID, $eventName, $eventVenue, $description, $eventDate, $loginTime, $logoutTime, $registrarID);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If insertion was successful, send success response
            echo json_encode(['status' => 'success']);
        } else {
            // If insertion failed, send error response
            $error_message = mysqli_error($conn);
            echo json_encode(['status' => 'error', 'message' => $error_message]);
            // Log error message for debugging
            error_log("Error: $error_message", 0);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['editEventId'], $_POST['editAcademicYear'], $_POST['editEventName'], $_POST['editEventVenue'], $_POST['editDescription'], $_POST['editEventDate'], $_POST['editLoginTime'], $_POST['editLogoutTime'], $_POST['editRegistrar'])) {
        // Retrieve form data for event update
        $eventId = $_POST['editEventId'];
        $academicYearId = $_POST['editAcademicYear'];
        $eventName = $_POST['editEventName'];
        $eventVenue = $_POST['editEventVenue'];
        $description = $_POST['editDescription'];
        $eventDate = $_POST['editEventDate'];
        $loginTime = $_POST['editLoginTime'];
        $logoutTime = $_POST['editLogoutTime'];
        $registrarId = $_POST['editRegistrar'];

        // Prepare update query
        $query = "UPDATE events SET academic_year_id = ?, event_name = ?, event_venue = ?, description = ?, event_date = ?, log_in = ?, log_out = ?, registrar_id = ? WHERE id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssssii", $academicYearId, $eventName, $eventVenue, $description, $eventDate, $loginTime, $logoutTime, $registrarId, $eventId);

        // Execute query
        if ($stmt->execute()) {
            // If update is successful, send success response
            $response = array("status" => "success");
            echo json_encode($response);
        } else {
            // If update fails, send error response
            $response = array("status" => "error");
            echo json_encode($response);
        }

        // Close statement
        $stmt->close();
    } elseif (isset($_POST['event_id'])) {
        // Delete event
        $event_id = $_POST['event_id'];
        
        // Prepare DELETE statement
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
      
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Event deleted successfully'));
            http_response_code(200); // OK
        } else {
            echo json_encode(array('error' => 'Failed to delete event'));
            http_response_code(500); // Internal Server Error
        }
    } else {
        // Invalid request
        echo json_encode(array('error' => 'Invalid request'));
        http_response_code(400); // Bad Request
    }
  
    // Close connection
    $conn->close();
}
?>
