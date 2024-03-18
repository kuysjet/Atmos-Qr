<?php
include 'database/db.php';

if(isset($_POST['academicYear'])) {
    $academicYear = $_POST['academicYear'];

    // Fetch events based on the selected academic year
    $query = "SELECT e.* FROM events e
              INNER JOIN academic_years a ON e.academic_year_id = a.id
              WHERE a.academic_year = '$academicYear'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $eventsList = '<option value="" disabled selected>Select Event</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $eventsList .= '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
        }
        echo $eventsList;
    } else {
        echo '<option value="">No Events Found</option>';
    }
} else {
    echo '<option value="">Invalid Request</option>';
}
?>
