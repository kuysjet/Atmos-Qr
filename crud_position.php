<?php
// Include database connection code
include 'database/db.php';

// Fetch data from Positions table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT ID, PositionName FROM Positions";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $positions = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $positions[] = $row;
        }
        echo json_encode(array("data" => $positions));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to fetch positions"));
        http_response_code(500); // Internal Server Error
    }
}

// Add a new position to the database
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['position'])) {
    $position = $_POST['position'];

    // Prepare INSERT statement
    $stmt = $conn->prepare("INSERT INTO Positions (PositionName) VALUES (?)");
    $stmt->bind_param("s", $position);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to add position"));
        http_response_code(500); // Internal Server Error
    }
}

// Update position
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editPositionId'])) {
    $positionId = $_POST['editPositionId'];
    $position = $_POST['editPositionName'];

    // Prepare UPDATE statement
    $stmt = $conn->prepare("UPDATE Positions SET PositionName=? WHERE ID=?");
    $stmt->bind_param("si", $position, $positionId);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success"));
        http_response_code(200); // OK
    } else {
        echo json_encode(array("error" => "Failed to update position"));
        http_response_code(500); // Internal Server Error
    }
}

// Delete position
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['position_id'])) {
    $position_id = $_POST['position_id'];
    
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM Positions WHERE ID = ?");
    $stmt->bind_param("i", $position_id);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Position deleted successfully'));
        http_response_code(200); // OK
    } else {
        echo json_encode(array('error' => 'Failed to delete position'));
        http_response_code(500); // Internal Server Error
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
    http_response_code(400); // Bad Request
}
?>
