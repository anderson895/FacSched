<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "facsched"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get teacher_id from $_GET
$teacher_id = isset($_GET['teacher_id']) ? intval($_GET['teacher_id']) : 0;

if ($teacher_id === 0) {
    die("Invalid or missing teacher_id.");
}

// Query to fetch the earliest and latest time for the teacher's schedule
$sql_time = "
    SELECT 
        MIN(tws.ws_subtStartTimeAssign) AS min_start_time, 
        MAX(tws.ws_subtEndTimeAssign) AS max_end_time
    FROM tblworkschedule tws
    JOIN tblschedule ts ON ts.sched_id = tws.ws_schedule_id
    WHERE ts.sched_teacher_id = $teacher_id
";

$result_time = $conn->query($sql_time);
if ($result_time->num_rows > 0) {
    $row_time = $result_time->fetch_assoc();
    $min_start_time = $row_time['min_start_time'];
    $max_end_time = $row_time['max_end_time'];
} else {
    die("No schedule found for the specified teacher.");
}

// Convert to time format
$min_start_time = strtotime($min_start_time);
$max_end_time = strtotime($max_end_time);

// Prepare the time slots (hourly)
$time_slots = [];
$current_time = $min_start_time;

while ($current_time < $max_end_time) {
    $start_time = date("g:i A", $current_time);
    $end_time = date("g:i A", $current_time + 3600); // Add 1 hour
    $time_slots[] = "$start_time - $end_time";
    $current_time += 3600; // Move to next hour
}

// Query to fetch the schedule details for the teacher
$sql_schedule = "
   SELECT 
    ts.*, 
    tws.*,
    tc.*,
    tsc.*
FROM tblschedule ts
JOIN tblworkschedule tws ON ts.sched_id = tws.ws_schedule_id
JOIN tblcurriculum tc ON tc.subject_id = tws.ws_CurriculumID
JOIN tblsection tsc ON tsc.sectionId = tws.ws_sectionId
WHERE ts.sched_teacher_id = $teacher_id
ORDER BY 
    FIELD(ts.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
    tws.ws_subtStartTimeAssign;

";

$result_schedule = $conn->query($sql_schedule);

// Initialize schedule array
$schedule = [];
while ($row_schedule = $result_schedule->fetch_assoc()) {
    $day = ucfirst($row_schedule['sched_day']);
    $start_time = date("g:i A", strtotime($row_schedule['ws_subtStartTimeAssign']));
    $end_time = date("g:i A", strtotime($row_schedule['ws_subtEndTimeAssign']));
    $schedule[$day][] = [
        'time' => "$start_time - $end_time",
        'work' => $row_schedule['ws_typeOfWork'],
        'room' => $row_schedule['ws_roomCode'],
        'subject_name' => $row_schedule['subject_name'],
        'section' => $row_schedule['course'].' '.$row_schedule['section']
    ];
}

// Bootstrap HTML table
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
    <h2 class="text-center mb-4">Faculty Schedule for Teacher ID: <?php echo htmlspecialchars($teacher_id); ?></h2>
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
                <?php
                foreach ($time_slots as $slot) {
                    echo "<tr>";
                    echo "<td class='fw-bold'>$slot</td>";
                    foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                        echo "<td>";
                        if (isset($schedule[$day])) {
                            foreach ($schedule[$day] as $entry) {
                                    echo "<div> {$entry['room']}</div>";
                                    echo "<div> {$entry['subject_name']}</div>";
                                    echo "<div> {$entry['section']}</div>";
                                  
                            }
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
