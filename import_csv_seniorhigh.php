<?php
// Include database connection code
include 'database/db.php';
include 'phpqrcode/qrlib.php';

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
        $stmt = $conn->prepare("INSERT INTO SeniorHighStudents (IdentificationNumber, FirstName, LastName, Email, StrandID, GradeID, SectionID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiii", $identificationNumber, $firstName, $lastName, $email, $strandId, $gradeId, $sectionId);

        // Fetch valid strands from the Strands table
        $strandQuery = "SELECT ID, strand_name FROM Strands";
        $strandResult = $conn->query($strandQuery);
        $validStrands = array();
        while ($row = $strandResult->fetch_assoc()) {
            $validStrands[$row['ID']] = $row['strand_name'];
        }

        // Fetch valid grades from the Grades table
        $gradeQuery = "SELECT ID, grade_name FROM Grades";
        $gradeResult = $conn->query($gradeQuery);
        $validGrades = array();
        while ($row = $gradeResult->fetch_assoc()) {
            $validGrades[$row['ID']] = $row['grade_name'];
        }

        // Fetch valid sections from the Sections table
        $sectionQuery = "SELECT ID, section_name FROM Sections";
        $sectionResult = $conn->query($sectionQuery);
        $validSections = array();
        while ($row = $sectionResult->fetch_assoc()) {
            $validSections[$row['ID']] = $row['section_name'];
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip the header row
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            // Check if the data array has all required fields
            if (count($data) != 7) {
                $errorCount++;
                continue; // Skip this row if it doesn't have the correct number of fields
            }

            // Process CSV data and add student to database
            $identificationNumber = isset($data[0]) ? trim($data[0]) : '';
            $firstName = isset($data[1]) ? trim($data[1]) : '';
            $lastName = isset($data[2]) ? trim($data[2]) : '';
            $email = isset($data[3]) ? trim($data[3]) : '';
            $strandName = isset($data[4]) ? trim($data[4]) : '';
            $gradeName = isset($data[5]) ? trim($data[5]) : '';
            $sectionName = isset($data[6]) ? trim($data[6]) : '';

            // Check if any required field is empty
            if (empty($identificationNumber) || empty($firstName) || empty($lastName) || empty($email) || empty($strandName) || empty($gradeName) || empty($sectionName)) {
                $errorCount++;
                continue; // Skip this row if any required field is empty
            }

            // Check if the strand, grade, and section are valid
            if (!in_array($strandName, $validStrands) || !in_array($gradeName, $validGrades) || !in_array($sectionName, $validSections)) {
                $errorCount++;
                continue; // Skip this row if the strand, grade, and section is invalid
            }

            // Get StrandID, GradeID, and SectionID
            $strandId = array_search($strandName, $validStrands);
            $gradeId = array_search($gradeName, $validGrades);
            $sectionId = array_search($sectionName, $validSections);

            // Check if the student already exists in the database
            $existingStmt = $conn->prepare("SELECT COUNT(*) FROM SeniorHighStudents WHERE IdentificationNumber = ? OR Email = ?");
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
                // Generate and save the QR code
                $qrCodePath = 'qr_codes/' . $identificationNumber . '.png'; // Make sure the qr_codes directory exists and is writable
                QRcode::png($identificationNumber, $qrCodePath); // Generate QR code
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
