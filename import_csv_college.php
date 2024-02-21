<?php
// Include database connection code
include 'database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
    $file = $_FILES["csvFile"];

    // Check if file is a valid CSV
    if ($file["type"] == "text/csv" || $file["type"] == "application/vnd.ms-excel") {
        $handle = fopen($file["tmp_name"], "r");
        $successCount = 0;
        $errorCount = 0;
        $duplicationCount = 0;
        $headerSkipped = false; // Variable to track if the header row has been skipped

        // Prepare statement outside the loop for better performance
        $stmt = $conn->prepare("INSERT INTO CollegeStudents (IdentificationNumber, FirstName, LastName, Email, Course, Level) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $identificationNumber, $firstName, $lastName, $email, $course, $level);

        // Define valid courses and levels
        $validCourses = array('ACT', 'BSCS', 'ENTREP', 'BSAIS');
        $validLevels = array('1', '2', '3', '4');

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip the header row
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            // Check if the data array has all required fields
            if (count($data) != 6) {
                $errorCount++;
                continue; // Skip this row if it doesn't have the correct number of fields
            }

            // Process CSV data and add student to database
            $identificationNumber = isset($data[0]) ? trim($data[0]) : '';
            $firstName = isset($data[1]) ? trim($data[1]) : '';
            $lastName = isset($data[2]) ? trim($data[2]) : '';
            $email = isset($data[3]) ? trim($data[3]) : '';
            $course = isset($data[4]) ? trim($data[4]) : '';
            $level = isset($data[5]) ? trim($data[5]) : '';

            // Check if any required field is empty
            if (empty($identificationNumber) || empty($firstName) || empty($lastName) || empty($email) || empty($course) || empty($level)) {
                $errorCount++;
                continue; // Skip this row if any required field is empty
            }

            // Check if the course and level are valid
            if (!in_array($course, $validCourses) || !in_array($level, $validLevels)) {
                $errorCount++;
                continue; // Skip this row if the course or level is invalid
            }

            // Check if the student already exists in the database
            $existingStmt = $conn->prepare("SELECT COUNT(*) FROM CollegeStudents WHERE IdentificationNumber = ? OR Email = ?");
            $existingStmt->bind_param("ss", $identificationNumber, $email);
            $existingStmt->execute();
            $existingStmt->bind_result($count);
            $existingStmt->fetch();
            $existingStmt->close();

            if ($count > 0) {
                // Skip inserting this record if the student already exists
                $duplicationCount++;
                continue;
            }

            // Execute the prepared statement
            if ($stmt->execute()) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }

        fclose($handle);
        $stmt->close(); // Close prepared statement
        $conn->close(); // Close database connection

        if ($successCount > 0) {
            $response = array("status" => "success", "message" => "$successCount students imported successfully");
        } elseif ($duplicationCount > 0) {
            $response = array("status" => "warning", "message" => "$duplicationCount records were not imported due to duplication");
        } else {
            $response = array("status" => "error", "message" => "Failed to import students. Please check your CSV file and try again.");
        }
    } else {
        $response = array("status" => "error", "message" => "Invalid file format. Please upload a CSV file.");
    }
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
