<?php

include 'database/db.php';

// Check if eventId and userType are set in the POST request
if(isset($_POST['eventId']) && isset($_POST['userType'])) {
    // Sanitize input
    $eventId = mysqli_real_escape_string($conn, $_POST['eventId']);
    $userType = mysqli_real_escape_string($conn, $_POST['userType']);

    // Query to fetch attendance based on event and user type
    $attendanceQuery = "";
    if($userType === "college") {
        $attendanceQuery = "SELECT attendance.id, 
                                    collegestudents.FirstName, 
                                    collegestudents.LastName, 
                                    courses.course_name AS course, 
                                    levels.level_name AS level, 
                                    NULL AS strand, 
                                    NULL AS grade, 
                                    NULL AS section, 
                                    NULL AS position, 
                                    attendance.time_in, 
                                    attendance.time_out
                            FROM attendance
                            INNER JOIN collegestudents ON attendance.college_student_id = collegestudents.ID
                            INNER JOIN courses ON collegestudents.courseID = courses.ID
                            INNER JOIN levels ON collegestudents.levelID = levels.ID
                            WHERE attendance.event_id = $eventId";
    } elseif($userType === "high_school") {
        $attendanceQuery = "SELECT attendance.id, 
                                  seniorhighstudents.FirstName, 
                                  seniorhighstudents.LastName, 
                                  NULL AS course, 
                                  NULL AS level, 
                                  strands.strand_name AS strand, 
                                  grades.grade_name AS grade, 
                                  sections.section_name AS section, 
                                  NULL AS position, 
                                  attendance.time_in, 
                                  attendance.time_out
                            FROM attendance
                            INNER JOIN seniorhighstudents ON attendance.senior_high_student_id = seniorhighstudents.ID
                            INNER JOIN strands ON seniorhighstudents.strandID = strands.ID
                            INNER JOIN grades ON seniorhighstudents.gradeID = grades.ID
                            INNER JOIN sections ON seniorhighstudents.sectionID = sections.ID
                            WHERE attendance.event_id = $eventId";
    } elseif($userType === "faculty") {
        $attendanceQuery = "SELECT attendance.id, 
                                  faculties.FirstName, 
                                  faculties.LastName, 
                                  NULL AS course, 
                                  NULL AS level, 
                                  NULL AS strand, 
                                  NULL AS grade, 
                                  NULL AS section, 
                                  positions.PositionName AS position, 
                                  attendance.time_in, 
                                  attendance.time_out
                            FROM attendance
                            INNER JOIN faculties ON attendance.faculty_id = faculties.ID
                            INNER JOIN positions ON faculties.positionID = positions.ID
                            WHERE attendance.event_id = $eventId";
    }

    // Execute query
    $attendanceResult = mysqli_query($conn, $attendanceQuery);

    // Check if query was successful
    if ($attendanceResult && mysqli_num_rows($attendanceResult) > 0) {
        // Initialize variable to store table rows
        $tableRows = '';

        // Attendances found, generate table rows
        while ($attendanceRow = mysqli_fetch_assoc($attendanceResult)) {
            // Concatenate table row data to the variable
            $tableRows .= '<tr>';
            $tableRows .= '<td>' . $attendanceRow['id'] . '</td>';
            $tableRows .= '<td>' . $attendanceRow['FirstName'] . '</td>';
            $tableRows .= '<td>' . $attendanceRow['LastName'] . '</td>';

            // Check if user type is college to hide additional columns
            if($userType === "college") {
                $tableRows .= '<td>' . $attendanceRow['course'] . '</td>';
                $tableRows .= '<td>' . $attendanceRow['level'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['strand'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['grade'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['section'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['position'] . '</td>';
            } elseif ($userType === "high_school") {
                $tableRows .= '<td style="display: none;">' . $attendanceRow['course'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['level'] . '</td>';
                $tableRows .= '<td>' . $attendanceRow['strand'] . '</td>';
                $tableRows .= '<td>' . $attendanceRow['grade'] . '</td>';
                $tableRows .= '<td>' . $attendanceRow['section'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['position'] . '</td>';
            } elseif ($userType === "faculty") {
                $tableRows .= '<td style="display: none;">' . $attendanceRow['course'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['level'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['strand'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['grade'] . '</td>';
                $tableRows .= '<td style="display: none;">' . $attendanceRow['section'] . '</td>';
                $tableRows .= '<td>' . $attendanceRow['position'] . '</td>';
            }

            $tableRows .= '<td>' . $attendanceRow['time_in'] . '</td>';
            $tableRows .= '<td>' . $attendanceRow['time_out'] . '</td>';
            $tableRows .= '</tr>';
        }

        // Echo the table rows
        echo $tableRows;
    } else {
        // No attendance found
        echo '<tr><td colspan="10">No Attendance Found</td></tr>';
    }
}
?>
