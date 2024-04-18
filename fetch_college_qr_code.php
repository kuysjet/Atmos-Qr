<?php
// Include database configuration
include 'database/db.php';

// Check if identification number is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {
    $identificationNumber = $_POST['identificationNumber'];

    // Prepare and execute SELECT statement to fetch QR code image data
    $stmt = $conn->prepare("SELECT QRCodeImage, FirstName, LastName, course_name, level_name FROM CollegeStudents JOIN Courses ON CollegeStudents.CourseID = Courses.ID JOIN Levels ON CollegeStudents.LevelID = Levels.ID WHERE IdentificationNumber = ?");
    $stmt->bind_param("s", $identificationNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student found, fetch QR code image data
        $row = $result->fetch_assoc();
        $qrCodeImage = base64_encode($row['QRCodeImage']); // Encode binary data as base64
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $course = $row['course_name'];
        $level = $row['level_name'];

        // Send JSON response with QR code image data and student information
        echo json_encode(array(
            "status" => "success",
            "qrCodeImage" => $qrCodeImage,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "course" => $course,
            "level" => $level
        ));
    } else {
        // Student not found
        echo json_encode(array("status" => "error", "message" => "Student not found"));
    }
} else {
    // Identification number not provided or invalid request method
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
