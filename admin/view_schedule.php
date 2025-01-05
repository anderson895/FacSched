<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facsched";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get teacher_id from $_GET with validation
$teacher_id = isset($_GET['teacher_id']) ? intval($_GET['teacher_id']) : 0;

if ($teacher_id === 0) {
    die("Invalid or missing teacher_id.");
}

// Fetch earliest and latest time for the teacher's schedule
$sql_time = $conn->prepare("
    SELECT 
        MIN(tws.ws_subtStartTimeAssign) AS min_start_time, 
        MAX(tws.ws_subtEndTimeAssign) AS max_end_time
    FROM tblworkschedule tws
    JOIN tblschedule ts ON ts.sched_id = tws.ws_schedule_id
    WHERE ts.sched_teacher_id = ?
");
$sql_time->bind_param("i", $teacher_id);
$sql_time->execute();
$result_time = $sql_time->get_result();

if ($result_time->num_rows > 0) {
    $row_time = $result_time->fetch_assoc();
    $min_start_time = strtotime($row_time['min_start_time']);
    $max_end_time = strtotime($row_time['max_end_time']);
} else {
    die("No schedule found for the specified teacher.");
}

// Generate hourly time slots
$time_slots = [];
$current_time = $min_start_time;

while ($current_time < $max_end_time) {
    $start_time = date("g:i A", $current_time);
    $end_time = date("g:i A", $current_time + 3600);
    $time_slots[] = ['start' => $current_time, 'label' => "$start_time - $end_time"];
    $current_time += 3600;
}

// Fetch the schedule details for the teacher
$sql_schedule = $conn->prepare("
    SELECT 
        ts.sched_day, 
        tws.ws_subtStartTimeAssign, 
        tws.ws_subtEndTimeAssign, 
        tws.ws_typeOfWork, 
        tws.ws_roomCode, 
        tc.subject_name, 
        CONCAT(tsc.course, ' ', tsc.section) AS section
    FROM tblschedule ts
    JOIN tblworkschedule tws ON ts.sched_id = tws.ws_schedule_id
    JOIN tblcurriculum tc ON tc.subject_id = tws.ws_CurriculumID
    JOIN tblsection tsc ON tsc.sectionId = tws.ws_sectionId
    WHERE ts.sched_teacher_id = ?
    ORDER BY 
        FIELD(ts.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
        tws.ws_subtStartTimeAssign
");
$sql_schedule->bind_param("i", $teacher_id);
$sql_schedule->execute();
$result_schedule = $sql_schedule->get_result();

// Organize schedule data by day and time
$schedule = [];
while ($row_schedule = $result_schedule->fetch_assoc()) {
    $day = ucfirst($row_schedule['sched_day']);
    $start_time = strtotime($row_schedule['ws_subtStartTimeAssign']);
    $end_time = strtotime($row_schedule['ws_subtEndTimeAssign']);
    $schedule[$day][] = [
        'start_time' => $start_time,
        'end_time' => $end_time,
        'work' => $row_schedule['ws_typeOfWork'],
        'room' => $row_schedule['ws_roomCode'],
        'subject_name' => $row_schedule['subject_name'],
        'section' => $row_schedule['section']
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Faculty Schedule for Teacher ID: <?= htmlspecialchars($teacher_id) ?></h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($time_slots as $slot): ?>
                    <tr>
                        <td class="fw-bold"><?= $slot['label'] ?></td>
                        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                            <?php
                            $merged = false; // Flag for tracking merged cells
                            foreach ($schedule[$day] ?? [] as $key => $entry) {
                                $entry_start = $entry['start_time'];
                                $entry_end = $entry['end_time'];

                                // Check if the current time slot matches the schedule entry
                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                    // Calculate the rowspan based on overlapping time slots
                                    $rowspan = ceil(($entry_end - $entry_start) / 3600);
                                    echo "<td rowspan='$rowspan'>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div>{$entry['subject_name']}</div>";
                                    echo "<div>{$entry['section']}</div>";
                                    echo "</td>";

                                    // Remove the processed schedule entry to avoid duplication
                                    unset($schedule[$day][$key]);
                                    $merged = true;
                                    break;
                                }
                            }

                            // Render empty cell if no schedule matches this time slot
                            if (!$merged) {
                                echo "<td></td>";
                            }
                            ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>