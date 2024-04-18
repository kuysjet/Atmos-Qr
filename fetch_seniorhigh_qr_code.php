<?php
// Include database configuration
include 'database/db.php';

// Check if identification number is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {
    $identificationNumber = $_POST['identificationNumber'];

    // Prepare and execute SELECT statement to fetch QR code image data
    $stmt = $conn->prepare("SELECT QRCodeImage, FirstName, LastName, strand_name, grade_name, section_name FROM SeniorHighStudents JOIN Strands ON SeniorHighStudents.StrandID = Strands.ID JOIN Grades ON SeniorHighStudents.GradeID = Grades.ID JOIN Sections ON SeniorHighStudents.SectionID = Sections.ID  WHERE IdentificationNumber = ?");
    $stmt->bind_param("s", $identificationNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student found, fetch QR code image data
        $row = $result->fetch_assoc();
        $qrCodeImage = base64_encode($row['QRCodeImage']); // Encode binary data as base64
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $strand = $row['strand_name'];
        $grade = $row['grade_name'];
        $section = $row['section_name'];

        // Send JSON response with QR code image data and student information
        echo json_encode(array(
            "status" => "success",
            "qrCodeImage" => $qrCodeImage,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "strand" => $strand,
            "grade" => $grade,
            "section" => $section
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

