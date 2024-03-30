<?php
// Include the database connection file
include 'database/db.php';

// Check if eventId is set in the POST parameters
if (isset($_POST['eventId'])) {
    // Retrieve eventId from POST parameters
    $eventId = $_POST['eventId'];

    // Initialize an empty array to store attendance data
    $attendanceData = array();

    // Fetch attendance data for the current event
    $query = "SELECT 
                attendance.id AS attendance_id, 
                COALESCE(collegestudents.FirstName, seniorhighstudents.FirstName, faculties.FirstName) AS first_name,
                COALESCE(collegestudents.LastName, seniorhighstudents.LastName, faculties.LastName) AS last_name,
                TIME_FORMAT(attendance.time_in, '%h:%i %p') AS time_in,
                TIME_FORMAT(attendance.time_out, '%h:%i %p') AS time_out
              FROM 
                attendance
              LEFT JOIN 
                collegestudents ON attendance.college_student_id = collegestudents.ID
              LEFT JOIN 
                seniorhighstudents ON attendance.senior_high_student_id = seniorhighstudents.ID
              LEFT JOIN 
                faculties ON attendance.faculty_id = faculties.ID
              WHERE 
                attendance.event_id = $eventId
              ORDER BY
                attendance.id DESC"; // Order by attendance ID in descending order

    $result = mysqli_query($conn, $query);

    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row and add it to the attendanceData array
        while ($row = mysqli_fetch_assoc($result)) {
            $attendanceData[] = $row;
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the attendance data as JSON
    echo json_encode($attendanceData);
} else {
    // If eventId is not set in the POST parameters, return an error message
    echo json_encode(array('error' => 'Event ID is not set!'));
}
?>
