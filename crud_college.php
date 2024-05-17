<?php
// Include database connection code
include 'database/db.php';
include 'phpqrcode/qrlib.php';

// Fetch data from CollegeStudents table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT cs.ID, cs.IdentificationNumber, cs.FirstName, cs.LastName, cs.Email, c.course_name, l.level_name 
              FROM collegestudents cs
              INNER JOIN courses c ON cs.CourseID = c.id
              INNER JOIN levels l ON cs.LevelID = l.id
              ORDER BY cs.ID DESC"; // Order by ID in descending order
    $result = mysqli_query($conn, $query);

    if ($result) {
        $students = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        echo json_encode(array("data" => $students));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch college students"));
        http_response_code(500); // Internal Server Error
    }
}


// Add a new student to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {
    $identificationNumber = $_POST['identificationNumber'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $level = $_POST['level'];

        // Check for duplicate identification number
        $checkDuplicateIdQuery = "SELECT * FROM CollegeStudents WHERE IdentificationNumber = ?";
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
        $checkDuplicateEmailQuery = "SELECT * FROM CollegeStudents WHERE Email = ?";
        $stmt = $conn->prepare($checkDuplicateEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Duplicate email found
            echo json_encode(array("status" => "error", "error" => "Duplicate email"));
            exit; // Stop further execution
        }
    

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO CollegeStudents (IdentificationNumber, FirstName, LastName, Email, CourseID, LevelID, QRCodeImage) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Generate QR code
    $data = $identificationNumber; // Or any unique data
    $errorCorrectionLevel = 'L'; // QR code error correction level
    $matrixPointSize = 26; // QR code point size
    ob_start(); // Start output buffering
    QRcode::png($data, null, $errorCorrectionLevel, $matrixPointSize, 4); // Generate QR code without saving it to a file
    $qrCodeImageBinary = ob_get_contents(); // Get the binary image data
    ob_end_clean(); // End output buffering and discard output

    // Bind parameters
    $stmt->bind_param("ssssiis", $identificationNumber, $firstName, $lastName, $email, $course, $level, $qrCodeImageBinary);
    
    // Inside the section that handles adding a new student
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to add student"));
        http_response_code(500); // Internal Server Error
    }
}


// Update student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editStudentId'])) {
    $studentId = $_POST['editStudentId'];
    $newIdentificationNumber = $_POST['editIdentificationNumber'];
    
    // Fetch the current identification number
    $currentQuery = "SELECT IdentificationNumber FROM collegestudents WHERE ID = ?";
    $currentStmt = $conn->prepare($currentQuery);
    $currentStmt->bind_param("i", $studentId);
    $currentStmt->execute();
    $result = $currentStmt->get_result();
    $currentData = $result->fetch_assoc();
    $currentIdentificationNumber = $currentData['IdentificationNumber'];

    // Get CourseID from the Courses table based on CourseName
    $queryCourse = "SELECT ID FROM courses WHERE course_name = ?";
    $stmtCourse = $conn->prepare($queryCourse);
    $stmtCourse->bind_param("s", $_POST['editCourse']); // Use $_POST['editCourse']
    $stmtCourse->execute();
    $resultCourse = $stmtCourse->get_result();
    
    if ($resultCourse->num_rows > 0) {
        // Course exists, get CourseID
        $rowCourse = $resultCourse->fetch_assoc();
        $courseId = $rowCourse['ID'];

        // Get LevelID from the Levels table based on LevelName
        $queryLevel = "SELECT ID FROM levels WHERE level_name = ?";
        $stmtLevel = $conn->prepare($queryLevel);
        $stmtLevel->bind_param("s", $_POST['editLevel']); // Use $_POST['editLevel']
        $stmtLevel->execute();
        $resultLevel = $stmtLevel->get_result();
        
        if ($resultLevel->num_rows > 0) {
            // Level exists, get LevelID
            $rowLevel = $resultLevel->fetch_assoc();
            $levelId = $rowLevel['ID'];

            // Prepare UPDATE statement
            $stmtUpdate = $conn->prepare("UPDATE collegestudents SET IdentificationNumber=?, FirstName=?, LastName=?, Email=?, CourseID=?, LevelID=? WHERE ID=?");
            $stmtUpdate->bind_param("ssssiii", $newIdentificationNumber, $_POST['editFirstName'], $_POST['editLastName'], $_POST['editEmail'], $courseId, $levelId, $studentId);

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
                    $stmtUpdateQrCode = $conn->prepare("UPDATE CollegeStudents SET QRCodeImage=? WHERE ID=?");
                    $stmtUpdateQrCode->bind_param("si", $qrCodeImageBinary, $studentId);
                    $stmtUpdateQrCode->execute();
                }

                echo json_encode(array("status" => "success"));
                http_response_code(200); // OK
            } else {
                echo json_encode(array("error" => "Failed to update college student"));
                http_response_code(500); // Internal Server Error
            }
        } else {
            echo json_encode(array("error" => "Level does not exist"));
            http_response_code(400); // Bad Request
        }
    } else {
        echo json_encode(array("error" => "Course does not exist"));
        http_response_code(400); // Bad Request
    }
}



// Delete student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch the student's identification number before deletion
    $fetchQuery = "SELECT IdentificationNumber FROM CollegeStudents WHERE ID = ?";
    $fetchStmt = $conn->prepare($fetchQuery);
    $fetchStmt->bind_param("i", $student_id);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $identificationNumber = $student['IdentificationNumber'];

        // Proceed with the student deletion
        $stmt = $conn->prepare("DELETE FROM CollegeStudents WHERE ID = ?");
        $stmt->bind_param("i", $student_id);

        if ($stmt->execute()) {
            // After successful deletion, delete the associated QR code if it exists from the database
            $deleteQRStmt = $conn->prepare("UPDATE CollegeStudents SET QRCodeImage = NULL WHERE ID = ?");
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
        $idQuery = "SELECT IdentificationNumber FROM CollegeStudents WHERE ID IN ($placeholders)";
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
        $deleteStmt = $conn->prepare("DELETE FROM CollegeStudents WHERE ID IN ($placeholders)");
        
        // Dynamically bind parameters for student IDs again
        $deleteStmt->bind_param(str_repeat('i', count($student_ids)), ...$student_ids);
        
        if ($deleteStmt->execute()) {
            // Delete QR code data for each student
            foreach ($identificationNumbers as $idNum) {
                // Update QR code image to NULL in the database
                $updateQRStmt = $conn->prepare("UPDATE CollegeStudents SET QRCodeImage = NULL WHERE IdentificationNumber = ?");
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
