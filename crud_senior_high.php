<?php
// Include database connection code
include 'database/db.php';
include 'phpqrcode/qrlib.php';

// Fetch data from SeniorHighStudents table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT shs.ID, shs.IdentificationNumber, shs.FirstName, shs.LastName, shs.Email, s.strand_name, g.grade_name, se.section_name
              FROM seniorhighstudents shs
              INNER JOIN strands s ON shs.StrandID = s.id
              INNER JOIN grades g ON shs.GradeID = g.id
              INNER JOIN sections se ON shs.SectionID = se.id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $students = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        echo json_encode(array("data" => $students));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch senior high students"));
        http_response_code(500); // Internal Server Error
    }
}


// Add a new student to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {

    // Retrieve form data
    $identificationNumber = $_POST['identificationNumber'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $strandName = $_POST['strand'];
    $gradeName = $_POST['grade'];
    $sectionName = $_POST['section'];

    // Check for duplicate identification number
    $checkDuplicateIdQuery = "SELECT * FROM SeniorHighStudents WHERE IdentificationNumber = ?";
    $stmt = $conn->prepare($checkDuplicateIdQuery);
    $stmt->bind_param("s", $identificationNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Duplicate identification number found
        echo json_encode(array("status" => "error", "error" => "Duplicate identification number"));
        exit; // Stop further execution
    }

    // Check for duplicate email
    $checkDuplicateEmailQuery = "SELECT * FROM SeniorHighStudents WHERE Email = ?";
    $stmt = $conn->prepare($checkDuplicateEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Duplicate email found
        echo json_encode(array("status" => "error", "error" => "Duplicate email"));
        exit; // Stop further execution

    } else {
        // Continue with insertion
        // Get StrandID from strands table
        $strandQuery = "SELECT id FROM strands WHERE strand_name = ?";
        $strandStmt = $conn->prepare($strandQuery);
        $strandStmt->bind_param("s", $strandName);
        $strandStmt->execute();
        $strandResult = $strandStmt->get_result();

        if ($strandResult->num_rows > 0) {
            $strandRow = $strandResult->fetch_assoc();
            $strandID = $strandRow['id'];

            // Get GradeID from grades table
            $gradeQuery = "SELECT id FROM grades WHERE grade_name = ?";
            $gradeStmt = $conn->prepare($gradeQuery);
            $gradeStmt->bind_param("s", $gradeName);
            $gradeStmt->execute();
            $gradeResult = $gradeStmt->get_result();

            if ($gradeResult->num_rows > 0) {
                $gradeRow = $gradeResult->fetch_assoc();
                $gradeID = $gradeRow['id'];

                // Get SectionID from sections table
                $sectionQuery = "SELECT id FROM sections WHERE section_name = ?";
                $sectionStmt = $conn->prepare($sectionQuery);
                $sectionStmt->bind_param("s", $sectionName);
                $sectionStmt->execute();
                $sectionResult = $sectionStmt->get_result();

                if ($sectionResult->num_rows > 0) {
                    $sectionRow = $sectionResult->fetch_assoc();
                    $sectionID = $sectionRow['id'];

                    // Prepare INSERT statement
                    $stmt = $conn->prepare("INSERT INTO SeniorHighStudents (IdentificationNumber, FirstName, LastName, Email, StrandID, GradeID, SectionID, QRCodeImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    // Generate QR code
                    $data = $identificationNumber; // Or any unique data
                    $errorCorrectionLevel = 'L'; // QR code error correction level
                    $matrixPointSize = 26; // QR code point size
                    ob_start(); // Start output buffering
                    QRcode::png($data, null, $errorCorrectionLevel, $matrixPointSize, 4); // Generate QR code without saving it to a file
                    $qrCodeImageBinary = ob_get_contents(); // Get the binary image data
                    ob_end_clean(); // End output buffering and discard output

                    // Bind parameters
                    $stmt->bind_param("ssssiiis", $identificationNumber, $firstName, $lastName, $email, $strandID, $gradeID, $sectionID, $qrCodeImageBinary);
                    
                    // Execute statement
                    if ($stmt->execute()) {
                        echo json_encode(array("status" => "success"));
                        http_response_code(200); // OK
                    } else {
                        echo json_encode(array("error" => "Failed to add student"));
                        http_response_code(500); // Internal Server Error
                    }
                } else {
                    echo json_encode(array("error" => "Invalid Section"));
                    http_response_code(400); // Bad Request
                }
            } else {
                echo json_encode(array("error" => "Invalid Grade"));
                http_response_code(400); // Bad Request
            }
        } else {
            echo json_encode(array("error" => "Invalid Strand"));
            http_response_code(400); // Bad Request
        }
    }
}




elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editSeniorHighId'])) {
    $studentId = $_POST['editSeniorHighId'];
    $newIdentificationNumber = $_POST['editIdentificationNumber'];
    
    // Fetch the current identification number
    $currentQuery = "SELECT IdentificationNumber FROM seniorhighstudents WHERE ID = ?";
    $currentStmt = $conn->prepare($currentQuery);
    $currentStmt->bind_param("i", $studentId);
    $currentStmt->execute();
    $result = $currentStmt->get_result();
    $currentData = $result->fetch_assoc();
    $currentIdentificationNumber = $currentData['IdentificationNumber'];

    // Get StrandID from the Strands table based on StrandName
    $queryStrand = "SELECT ID FROM strands WHERE strand_name = ?";
    $stmtStrand = $conn->prepare($queryStrand);
    $stmtStrand->bind_param("s", $_POST['editStrand']); // Use $_POST['editStrand']
    $stmtStrand->execute();
    $resultStrand = $stmtStrand->get_result();
    
    if ($resultStrand->num_rows > 0) {
        // Strand exists, get StrandID
        $rowStrand = $resultStrand->fetch_assoc();
        $strandId = $rowStrand['ID'];

        // Get GradeID from the Grades table based on GradeName
        $queryGrade = "SELECT ID FROM grades WHERE grade_name = ?";
        $stmtGrade = $conn->prepare($queryGrade);
        $stmtGrade->bind_param("s", $_POST['editGrade']); // Use $_POST['editGrade']
        $stmtGrade->execute();
        $resultGrade = $stmtGrade->get_result();
        
        if ($resultGrade->num_rows > 0) {
            // Grade exists, get GradeID
            $rowGrade = $resultGrade->fetch_assoc();
            $gradeId = $rowGrade['ID'];

            // Get SectionID from the Sections table based on SectionName
            $querySection = "SELECT ID FROM sections WHERE section_name = ?";
            $stmtSection = $conn->prepare($querySection);
            $stmtSection->bind_param("s", $_POST['editSection']); // Use $_POST['editSection']
            $stmtSection->execute();
            $resultSection = $stmtSection->get_result();
            
            if ($resultSection->num_rows > 0) {
                // Section exists, get SectionID
                $rowSection = $resultSection->fetch_assoc();
                $sectionId = $rowSection['ID'];

                // Prepare UPDATE statement
                $stmtUpdate = $conn->prepare("UPDATE seniorhighstudents SET IdentificationNumber=?, FirstName=?, LastName=?, Email=?, StrandID=?, GradeID=?, SectionID=? WHERE ID=?");
                $stmtUpdate->bind_param("ssssiiii", $newIdentificationNumber, $_POST['editFirstName'], $_POST['editLastName'], $_POST['editEmail'], $strandId, $gradeId, $sectionId, $studentId);

                // Execute statement
                if ($stmtUpdate->execute()) {
                    // If the identification number has changed, update the QR code in the database
                    if ($currentIdentificationNumber !== $newIdentificationNumber) {
                        // Set the error correction level and matrix point size
                        $errorCorrectionLevel = 'L'; // QR code error correction level
                        $matrixPointSize = 26; // Increase the point size for higher resolution

                        // Generate a new QR code with the new identification number
                        ob_start(); // Start output buffering
                        QRcode::png($newIdentificationNumber, null, $errorCorrectionLevel, $matrixPointSize, 4); // Generate QR code without saving it
                        $qrCodeImageBinary = ob_get_contents(); // Get the binary image data
                        ob_end_clean(); // End output buffering and discard output

                        // Update the QR code image in the database
                        $stmtUpdateQrCode = $conn->prepare("UPDATE SeniorHighStudents SET QRCodeImage=? WHERE ID=?");
                        $stmtUpdateQrCode->bind_param("si", $qrCodeImageBinary, $studentId);
                        $stmtUpdateQrCode->execute();
                    }

                    echo json_encode(array("status" => "success"));
                    http_response_code(200); // OK
                } else {
                    echo json_encode(array("error" => "Failed to update senior high student"));
                    http_response_code(500); // Internal Server Error
                }
            } else {
                echo json_encode(array("error" => "Section does not exist"));
                http_response_code(400); // Bad Request
            }
        } else {
            echo json_encode(array("error" => "Grade does not exist"));
            http_response_code(400); // Bad Request
        }
    } else {
        echo json_encode(array("error" => "Strand does not exist"));
        http_response_code(400); // Bad Request
    }
}








// Delete student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch the student's identification number before deletion
    $fetchQuery = "SELECT IdentificationNumber FROM SeniorHighStudents WHERE ID = ?";
    $fetchStmt = $conn->prepare($fetchQuery);
    $fetchStmt->bind_param("i", $student_id);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $identificationNumber = $student['IdentificationNumber'];

        // Proceed with the student deletion
        $stmt = $conn->prepare("DELETE FROM SeniorHighStudents WHERE ID = ?");
        $stmt->bind_param("i", $student_id);

        if ($stmt->execute()) {
            // After successful deletion, delete the associated QR code if it exists from the database
            $deleteQRStmt = $conn->prepare("UPDATE SeniorHighStudents SET QRCodeImage = NULL WHERE ID = ?");
            $deleteQRStmt->bind_param("i", $student_id);
            $deleteQRStmt->execute();

            echo json_encode(array('status' => 'success', 'message' => 'Student deleted successfully'));
            http_response_code(200); // OK
        } else {
            echo json_encode(array('error' => 'Failed to delete student'));
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo json_encode(array('error' => 'Student not found'));
        http_response_code(404); // Not Found
    }
}



// Bulk delete students
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bulkDelete'])) {
    $student_ids = $_POST['student_ids']; // Assume this is an array of student IDs
    
    if (is_array($student_ids)) {
        // Fetch the identification numbers for all students to be deleted
        $placeholders = implode(',', array_fill(0, count($student_ids), '?'));
        $idQuery = "SELECT IdentificationNumber FROM SeniorHighStudents WHERE ID IN ($placeholders)";
        $idStmt = $conn->prepare($idQuery);
        
        // Dynamically bind parameters for student IDs
        $idStmt->bind_param(str_repeat('i', count($student_ids)), ...$student_ids);
        $idStmt->execute();
        $result = $idStmt->get_result();
        $identificationNumbers = [];
        while ($row = $result->fetch_assoc()) {
            $identificationNumbers[] = $row['IdentificationNumber'];
        }
        $idStmt->close();
        
        // Proceed with deleting the students from the database
        $deleteStmt = $conn->prepare("DELETE FROM SeniorHighStudents WHERE ID IN ($placeholders)");
        
        // Dynamically bind parameters for student IDs again
        $deleteStmt->bind_param(str_repeat('i', count($student_ids)), ...$student_ids);
        
        if ($deleteStmt->execute()) {
            // Delete QR code data for each student
            foreach ($identificationNumbers as $idNum) {
                // Update QR code image to NULL in the database
                $updateQRStmt = $conn->prepare("UPDATE SeniorHighStudents SET QRCodeImage = NULL WHERE IdentificationNumber = ?");
                $updateQRStmt->bind_param("s", $idNum);
                $updateQRStmt->execute();
            }
            
            echo json_encode(array('status' => 'success', 'message' => 'Students and their QR codes deleted successfully'));
            http_response_code(200); // OK
        } else {
            echo json_encode(array('error' => 'Failed to delete students'));
            http_response_code(500); // Internal Server Error
        }
        $deleteStmt->close();
    } else {
        echo json_encode(array('error' => 'Invalid student IDs'));
        http_response_code(400); // Bad Request
    }
}




?>
