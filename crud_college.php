<?php
// Include database connection code
include 'database/db.php';

// Fetch data from CollegeStudents table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT ID, IdentificationNumber, FirstName, LastName, Email, Course, Level FROM CollegeStudents";
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

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO CollegeStudents (IdentificationNumber, FirstName, LastName, Email, Course, Level) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("ssssss", $identificationNumber, $firstName, $lastName, $email, $course, $level);
    
    // Execute statement
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to add college student"));
        http_response_code(500); // Internal Server Error
    }
}

// Update student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editStudentId'])) {
    $studentId = $_POST['editStudentId'];
    $identificationNumber = $_POST['editIdentificationNumber'];
    $firstName = $_POST['editFirstName'];
    $lastName = $_POST['editLastName'];
    $email = $_POST['editEmail'];
    $course = $_POST['editCourse'];
    $level = $_POST['editLevel'];

    // Prepare UPDATE statement
    $stmt = $conn->prepare("UPDATE CollegeStudents SET IdentificationNumber=?, FirstName=?, LastName=?, Email=?, Course=?, Level=? WHERE ID=?");
    $stmt->bind_param("ssssssi", $identificationNumber, $firstName, $lastName, $email, $course, $level, $studentId);

    // Execute statement
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to update college student"));
        http_response_code(500); // Internal Server Error
    }
}

// Delete student
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM CollegeStudents WHERE ID = ?");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Student deleted successfully'));
        http_response_code(200); // OK
    } else {
        echo json_encode(array('error' => 'Failed to delete student'));
        http_response_code(500); // Internal Server Error
    }
} 

// Bulk delete students
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bulkDelete'])) {
    $student_ids = $_POST['student_ids']; // Assume this is an array of student IDs
    
    if (is_array($student_ids)) {
        $placeholders = implode(',', array_fill(0, count($student_ids), '?'));
        $stmt = $conn->prepare("DELETE FROM CollegeStudents WHERE ID IN ($placeholders)");
        
        // Dynamically bind parameters
        $stmt->bind_param(str_repeat('i', count($student_ids)), ...$student_ids);
        
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Students deleted successfully'));
            http_response_code(200); // OK
        } else {
            echo json_encode(array('error' => 'Failed to delete students'));
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo json_encode(array('error' => 'Invalid student IDs'));
        http_response_code(400); // Bad Request
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
    http_response_code(400); // Bad Request
}



?>
