<?php
// Include database connection code
include 'database/db.php';

// Fetch data from Faculty table along with DepartmentName and PositionName
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT f.ID, f.IdentificationNumber, f.FirstName, f.LastName, f.Email, d.DepartmentName, p.PositionName 
              FROM Faculties f
              INNER JOIN Departments d ON f.DepartmentID = d.ID
              INNER JOIN Positions p ON f.PositionID = p.ID";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $faculties = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $faculties[] = $row;
        }
        echo json_encode(array("data" => $faculties));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch faculties"));
        http_response_code(500); // Internal Server Error
    }
}

// Add a new faculty to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificationNumber'])) {
    $identificationNumber = $_POST['identificationNumber'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $departmentName = $_POST['departmentName'];
    $positionName = $_POST['positionName'];

    // Prepare SELECT statements to fetch IDs for department and position names
    $deptQuery = "SELECT ID FROM Departments WHERE DepartmentName = ?";
    $posQuery = "SELECT ID FROM Positions WHERE PositionName = ?";
    
    // Prepare and execute statements
    $deptStmt = $conn->prepare($deptQuery);
    $deptStmt->bind_param("s", $departmentName);
    $deptStmt->execute();
    $deptResult = $deptStmt->get_result();
    
    $posStmt = $conn->prepare($posQuery);
    $posStmt->bind_param("s", $positionName);
    $posStmt->execute();
    $posResult = $posStmt->get_result();
    
    // Check if department and position names exist
    if ($deptResult->num_rows > 0 && $posResult->num_rows > 0) {
        // Fetch IDs
        $deptRow = $deptResult->fetch_assoc();
        $deptID = $deptRow['ID'];
        
        $posRow = $posResult->fetch_assoc();
        $posID = $posRow['ID'];

        // Prepare INSERT statement
        $stmt = $conn->prepare("INSERT INTO Faculties (IdentificationNumber, FirstName, LastName, Email, DepartmentID, PositionID) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("ssssii", $identificationNumber, $firstName, $lastName, $email, $deptID, $posID);
        
        // Execute statement
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
            http_response_code(200); // OK
        } else {
            echo json_encode(array("error" => "Failed to add faculty"));
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo json_encode(array("error" => "Department or position does not exist"));
        http_response_code(400); // Bad Request
    }
}

// Update faculty
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editFacultyId'])) {
    $facultyId = $_POST['editFacultyId'];
    $identificationNumber = $_POST['editIdentificationNumber'];
    $firstName = $_POST['editFirstName'];
    $lastName = $_POST['editLastName'];
    $email = $_POST['editEmail'];
    $departmentName = $_POST['editDepartmentName'];
    $positionName = $_POST['editPositionName'];

    // Get DepartmentID from the Departments table based on DepartmentName
    $queryDepartment = "SELECT ID FROM Departments WHERE DepartmentName = ?";
    $stmtDepartment = $conn->prepare($queryDepartment);
    $stmtDepartment->bind_param("s", $departmentName);
    $stmtDepartment->execute();
    $resultDepartment = $stmtDepartment->get_result();
    
    if ($resultDepartment->num_rows > 0) {
        // Department exists, get DepartmentID
        $rowDepartment = $resultDepartment->fetch_assoc();
        $departmentId = $rowDepartment['ID'];

        // Get PositionID from the Positions table based on PositionName
        $queryPosition = "SELECT ID FROM Positions WHERE PositionName = ?";
        $stmtPosition = $conn->prepare($queryPosition);
        $stmtPosition->bind_param("s", $positionName);
        $stmtPosition->execute();
        $resultPosition = $stmtPosition->get_result();
        
        if ($resultPosition->num_rows > 0) {
            // Position exists, get PositionID
            $rowPosition = $resultPosition->fetch_assoc();
            $positionId = $rowPosition['ID'];

            // Prepare UPDATE statement
            $stmtUpdate = $conn->prepare("UPDATE Faculties SET IdentificationNumber=?, FirstName=?, LastName=?, Email=?, DepartmentID=?, PositionID=? WHERE ID=?");
            $stmtUpdate->bind_param("ssssiii", $identificationNumber, $firstName, $lastName, $email, $departmentId, $positionId, $facultyId);

            // Execute statement
            if ($stmtUpdate->execute()) {
                echo json_encode(array("status" => "success"));
                http_response_code(200); // OK
            } else {
                echo json_encode(array("error" => "Failed to update faculty"));
                http_response_code(500); // Internal Server Error
            }
        } else {
            echo json_encode(array("error" => "Position does not exist"));
            http_response_code(400); // Bad Request
        }
    } else {
        echo json_encode(array("error" => "Department does not exist"));
        http_response_code(400); // Bad Request
    }
}

// Delete faculty
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['faculty_id'])) {
    $faculty_id = $_POST['faculty_id'];
    
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM Faculties WHERE ID = ?");
    $stmt->bind_param("i", $faculty_id);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Faculty deleted successfully'));
        http_response_code(200); // OK
    } else {
        echo json_encode(array('error' => 'Failed to delete faculty'));
        http_response_code(500); // Internal Server Error
    }
}

// Bulk delete faculties
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bulkDelete'])) {
    $faculty_ids = $_POST['faculty_ids']; // Assume this is an array of faculties IDs
    
    if (is_array($faculty_ids)) {
        $placeholders = implode(',', array_fill(0, count($faculty_ids), '?'));
        $stmt = $conn->prepare("DELETE FROM Faculties WHERE ID IN ($placeholders)");
        
        // Dynamically bind parameters
        $stmt->bind_param(str_repeat('i', count($faculty_ids)), ...$faculty_ids);
        
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'faculties deleted successfully'));
            http_response_code(200); // OK
        } else {
            echo json_encode(array('error' => 'Failed to delete faculties'));
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo json_encode(array('error' => 'Invalid faculty IDs'));
        http_response_code(400); // Bad Request
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
    http_response_code(400); // Bad Request
}
?>
