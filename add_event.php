<?php
// Include database connection
include 'database/db.php';

// Check if the form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $academicYearID = $_POST['academicYear'];
    $eventName = $_POST['eventName'];
    $eventVenue = $_POST['venue'];
    $description = $_POST['description'];
    $startDateTime = $_POST['startDatetime'];
    $endDateTime = $_POST['endDatetime'];
    $registrarID = $_POST['registrar'];
    $collegeStudentID = $_POST['collegeStudent'];
    $seniorHighStudentID = $_POST['seniorHighStudent'];
    $facultyID = $_POST['faculty'];
    
    // Handle multiple respondents
    if(isset($_POST['respondents']) && is_array($_POST['respondents'])) {
        // Convert the array of respondents into a comma-separated string
        $respondents = implode(",", $_POST['respondents']);
    } else {
        $respondents = ""; // Default to empty string if no respondents are selected
    }

    // Prepare SQL statement for insertion
    $query = "INSERT INTO events (AcademicYearID, EventName, EventVenue, Description, StartDateTime, EndDateTime, RegistrarID, CollegeStudentID, SeniorHighStudentID, FacultyID, Respondents) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "issssssssss", $academicYearID, $eventName, $eventVenue, $description, $startDateTime, $endDateTime, $registrarID, $collegeStudentID, $seniorHighStudentID, $facultyID, $respondents);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // If insertion was successful, send success response
        echo json_encode(['status' => 'success']);
    } else {
        // If insertion failed, send error response
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // If the request method is not POST, send error response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close database connection
mysqli_close($conn);
?>
