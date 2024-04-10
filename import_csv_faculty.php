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
        $stmt = $conn->prepare("INSERT INTO Faculties (IdentificationNumber, FirstName, LastName, Email, DepartmentID, PositionID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $identificationNumber, $firstName, $lastName, $email, $departmentID, $positionID);

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

            // Process CSV data and add faculty to database
            $identificationNumber = isset($data[0]) ? trim($data[0]) : '';
            $firstName = isset($data[1]) ? trim($data[1]) : '';
            $lastName = isset($data[2]) ? trim($data[2]) : '';
            $email = isset($data[3]) ? trim($data[3]) : '';
            $departmentName = isset($data[4]) ? trim($data[4]) : '';
            $positionName = isset($data[5]) ? trim($data[5]) : '';

            // Check if any required field is empty
            if (empty($identificationNumber) || empty($firstName) || empty($lastName) || empty($email) || empty($departmentName) || empty($positionName)) {
                $errorCount++;
                continue; // Skip this row if any required field is empty
            }

            // Get DepartmentID
            $departmentStmt = $conn->prepare("SELECT ID FROM Departments WHERE DepartmentName = ?");
            $departmentStmt->bind_param("s", $departmentName);
            $departmentStmt->execute();
            $departmentStmt->bind_result($departmentID);
            $departmentStmt->fetch();
            $departmentStmt->close();

            // Get PositionID
            $positionStmt = $conn->prepare("SELECT ID FROM Positions WHERE PositionName = ?");
            $positionStmt->bind_param("s", $positionName);
            $positionStmt->execute();
            $positionStmt->bind_result($positionID);
            $positionStmt->fetch();
            $positionStmt->close();

            // Check if the faculty already exists in the database
            $existingStmt = $conn->prepare("SELECT COUNT(*) FROM Faculties WHERE IdentificationNumber = ? OR Email = ?");
            $existingStmt->bind_param("ss", $identificationNumber, $email);
            $existingStmt->execute();
            $existingStmt->bind_result($count);
            $existingStmt->fetch();
            $existingStmt->close();

            if ($count > 0) {
                // Skip inserting this record if the faculty already exists
                $duplicationCount++;
                continue;
            }

            // Execute the prepared statement
            if ($stmt->execute()) {
                $successCount++;
                // Generate and save the QR code
                $errorCorrectionLevel = 'L'; // QR code error correction level
                $matrixPointSize = 26; // Increase the point size for higher resolution

                // Generate the QR code with the identification number
                $qrCodePath = 'qr_codes/' . $identificationNumber . '.png'; // Make sure the qr_codes directory exists and is writable
                QRcode::png($identificationNumber, $qrCodePath, $errorCorrectionLevel, $matrixPointSize, 4);
            } else {
                $errorCount++;
            }
        }

        fclose($handle);
        $stmt->close(); // Close prepared statement
        $conn->close(); // Close database connection

        if ($successCount > 0) {
            $response = array("status" => "success", "message" => "$successCount faculties imported successfully");
        } elseif ($duplicationCount > 0) {
            $response = array("status" => "warning", "message" => "$duplicationCount records were not imported due to duplication");
        } else {
            $response = array("status" => "error", "message" => "Failed to import faculties. Please check your CSV file and try again.");
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
