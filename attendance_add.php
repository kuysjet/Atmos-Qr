<?php
// Include the database connection file
include 'database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from AJAX request
    $identificationNumber = $_POST['identificationNumber'];
    $eventId = $_POST['eventId'];
    $eventTime = $_POST['eventTime'];
    $scanOption = $_POST['scanOption']; // Get the selected scan option (timeIn or timeOut)

    // Determine the type of ID (college student, senior high student, or faculty)
    $type = determineType($identificationNumber, $eventId);

    // Insert attendance based on ID type or update time_out if duplication
    if ($type !== null) {
        switch ($type) {
            case 'college_student':
                $idColumn = 'college_student_id';
                $idQuery = "SELECT ID FROM collegestudents WHERE IdentificationNumber = '$identificationNumber'";
                break;
            case 'senior_high_student':
                $idColumn = 'senior_high_student_id';
                $idQuery = "SELECT ID FROM seniorhighstudents WHERE IdentificationNumber = '$identificationNumber'";
                break;
            case 'faculty':
                $idColumn = 'faculty_id';
                $idQuery = "SELECT ID FROM faculties WHERE IdentificationNumber = '$identificationNumber'";
                break;
            default:
                echo "Invalid ID type";
                exit();
        }

        // Check if the attendee has already attended the event
        $attendanceQuery = "SELECT * FROM attendance WHERE $idColumn IN ($idQuery) AND event_id = $eventId";
        $attendanceResult = mysqli_query($conn, $attendanceQuery);

        if (mysqli_num_rows($attendanceResult) > 0) {
            // If attendance already exists and the selected option is timeIn, make an alert
            if ($scanOption === 'timeIn') {
                echo "Time in is already recorded for this attendee!";
            } else {
                // If the selected option is timeOut and there is no existing time_out record, update the time_out column
                $row = mysqli_fetch_assoc($attendanceResult);
                if (empty($row['time_out'])) {
                    $attendanceId = $row['id'];
                    $updateQuery = "UPDATE attendance SET time_out = '$eventTime' WHERE id = $attendanceId";
                    if (mysqli_query($conn, $updateQuery)) {
                        echo "Attendance added successfully!";
                    } else {
                        echo "Error updating attendance: " . mysqli_error($conn);
                    }
                } else {
                    // If time_out is already recorded, make an alert
                    echo "Time out is already recorded for this attendee!";
                }
            }
        } else {
            // If attendance doesn't exist, insert a new record with the selected option (timeIn)
            if ($scanOption === 'timeIn') {
                $insertQuery = "INSERT INTO attendance (event_id, $idColumn, time_in) VALUES ($eventId, ($idQuery), '$eventTime')";
                if (mysqli_query($conn, $insertQuery)) {
                    echo "Attendance added successfully!";
                } else {
                    echo "Error inserting attendance: " . mysqli_error($conn);
                }
            } else {
                // If the selected option is timeOut without a corresponding time in, make an alert
                echo "Time in is required before recording time out!";
            }
        }
    } else {
        // If the identification number is not in the database or not registered, make an alert
        echo "Invalid identification number!";
    }
} else {
    echo "Invalid request!";
}

// Function to determine the type of ID based on the identification number
function determineType($identificationNumber, $eventId) {
    global $conn; // Assuming $conn is your database connection variable

    // Check if the identification number exists in the collegestudents table
    $query = "SELECT COUNT(*) AS count FROM collegestudents WHERE IdentificationNumber = '$identificationNumber'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $collegeStudentCount = $row['count'];

    // Check if the identification number exists in the seniorhighstudents table
    $query = "SELECT COUNT(*) AS count FROM seniorhighstudents WHERE IdentificationNumber = '$identificationNumber'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $seniorHighStudentCount = $row['count'];

    // Check if the identification number exists in the faculties table
    $query = "SELECT COUNT(*) AS count FROM faculties WHERE IdentificationNumber = '$identificationNumber'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $facultyCount = $row['count'];

    // Determine the type based on the counts
    if ($collegeStudentCount > 0) {
        return 'college_student';
    } elseif ($seniorHighStudentCount > 0) {
        return 'senior_high_student';
    } elseif ($facultyCount > 0) {
        return 'faculty';
    } else {
        return null;
    }
}
?>
