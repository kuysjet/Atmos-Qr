<?php
// Include database connection code
include 'database/db.php';
include 'phpqrcode/qrlib.php';

// Fetch data from SeniorHighStudents table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT ID, IdentificationNumber, FirstName, LastName, Email, Strand, Grade, Section FROM SeniorHighStudents";
    $result = mysqli_query($conn, $query);

    
    if ($result) {
        $students = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        echo json_encode(array("data" => $students));
        http_response_code(200); // OK`
    } else {
        echo json_encode(array("error" => "Failed to fetch senior high students"));
        http_response_code(500); // Internal Server Error
    }
}

// Add a new student to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {
    $identificationNumber = $_POST['identificationNumber'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $strand = $_POST['strand'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO SeniorHighStudents (IdentificationNumber, FirstName, LastName, Email, Strand, Grade, Section) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("sssssss", $identificationNumber, $firstName, $lastName, $email, $strand, $grade, $section);
    
    // Inside the section that handles adding a new student
if ($stmt->execute()) {
    // After successfully adding the student
    $data = $identificationNumber; // Or any unique data
    $qrCodePath = 'qr_codes/' . $identificationNumber . '.png';
    QRcode::png($data, $qrCodePath);

    echo json_encode(array("status" => "success"));
    http_response_code(200); // OK
}
}

// Update student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editSeniorHighId'])) {
    $studentId = $_POST['editSeniorHighId'];
    $newIdentificationNumber = $_POST['editIdentificationNumber'];
    
    // Fetch the current identification number
    $currentQuery = "SELECT IdentificationNumber FROM SeniorHighStudents WHERE ID = ?";
    $currentStmt = $conn->prepare($currentQuery);
    $currentStmt->bind_param("i", $studentId);
    $currentStmt->execute();
    $result = $currentStmt->get_result();
    $currentData = $result->fetch_assoc();
    $currentIdentificationNumber = $currentData['IdentificationNumber'];
    
    // Proceed with the update as before
    $stmt = $conn->prepare("UPDATE SeniorHighStudents SET IdentificationNumber=?, FirstName=?, LastName=?, Email=?, Strand=?, Grade=?, Section=? WHERE ID=?");
    $stmt->bind_param("sssssssi", $newIdentificationNumber, $_POST['editFirstName'], $_POST['editLastName'], $_POST['editEmail'], $_POST['editStrand'], $_POST['editGrade'], $_POST['editSection'], $studentId);
    
    if ($stmt->execute()) {
        // Delete the old QR code if the identification number has changed
        if ($currentIdentificationNumber !== $newIdentificationNumber) {
            $oldQrCodePath = 'qr_codes/' . $currentIdentificationNumber . '.png';
            if (file_exists($oldQrCodePath)) {
                unlink($oldQrCodePath); // Delete the old QR code file
            }
            
            // Generate a new QR code with the new identification number
            $newQrCodePath = 'qr_codes/' . $newIdentificationNumber . '.png';
            QRcode::png($newIdentificationNumber, $newQrCodePath);
        }

        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to update senior high student"));
        http_response_code(500); // Internal Server Error
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
            // After successful deletion, delete the QR code
            $qrCodePath = 'qr_codes/' . $identificationNumber . '.png';
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath); // Delete the QR code file
            }

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
            // Delete QR codes for each student
            foreach ($identificationNumbers as $idNum) {
                $qrCodePath = 'qr_codes/' . $idNum . '.png';
                if (file_exists($qrCodePath)) {
                    unlink($qrCodePath); // Delete the QR code file
                }
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
