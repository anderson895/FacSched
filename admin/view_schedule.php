<?php 
include "components/header.php";

$teacher_id = $_GET['teacher_id'];

$view_AcademicSchedule = $db->view_AcademicSchedule($teacher_id);  // Query from tblworkschedule
$view_OtherSchedule = $db->view_OtherSchedule($teacher_id);  // Query from tblotherworkschedule

$teacher = $db->getTeacherInfo($teacher_id);  
$teacherName = ucfirst($teacher[0]['fname']) . ' ' . $teacher[0]['mname'] . ' ' . $teacher[0]['lname'];

?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Faculty Schedule for Teacher : <?= $teacherName; ?></h2>

    <!-- Print Buttons -->
    <div class="text-center mb-4">
        <button onclick="printAcademicSchedule()" class="btn btn-primary">Print Academic Schedule</button>
        <button onclick="printOtherSchedule()" class="btn btn-secondary">Print Other Work Schedule</button>
    </div>

    <!-- Academic Schedule Table -->
    <div class="table-responsive">
        <table class="table table-bordered" id="academicScheduleTable">
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
                $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);
                $academic_schedule = $view_AcademicSchedule['schedule'];  // Get academic schedule data
                $time_slots = $view_AcademicSchedule['time_slots'];  // Get time slots data

                foreach ($time_slots as $slot_index => $slot): ?>
                    <tr>
                        <td class="fw-bold"><?= $slot['label'] ?></td>
                        <?php foreach (array_keys($day_trackers) as $day): ?>
                            <?php
                            if ($day_trackers[$day] > 0) {
                                $day_trackers[$day]--;
                                continue;
                            }

                            $merged = false;
                            foreach ($academic_schedule[$day] ?? [] as $key => $entry) {
                                $entry_start = $entry['start_time'];
                                $entry_end = $entry['end_time'];

                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                    $rowspan = ceil(($entry_end - $entry_start) / 3600);
                                    echo "<td rowspan='$rowspan'>";
                                    echo "<div>Semester {$entry['semester']}</div>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div>{$entry['subject_name']}</div>";
                                    echo "<div>{$entry['section']}</div>";
                                    echo "</td>";

                                    $day_trackers[$day] = $rowspan - 1;
                                    unset($academic_schedule[$day][$key]);
                                    $merged = true;
                                    break;
                                }
                            }

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

    <h3 class="text-center mt-5">Other Work Schedule</h3>
    <div class="table-responsive">
    <table class="table table-bordered" id="otherWorkScheduleTable">
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
            // Initialize day trackers
            $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);

            $other_schedule = $view_OtherSchedule['schedule'];  // Get other work schedule
            $time_slots = $view_OtherSchedule['time_slots'];   // Get time slots

            // Loop over time slots
            foreach ($time_slots as $slot_index => $slot): ?>
                <tr>
                    <td class="fw-bold"><?= $slot['label']; ?></td> <!-- Display the time slot -->
                    <?php foreach (array_keys($day_trackers) as $day): ?>
                        <?php
                        if ($day_trackers[$day] > 0) {
                            $day_trackers[$day]--;
                            continue; // Skip this cell if a rowspan is already applied
                        }

                        $merged = false; // Flag to check if an entry is merged in the cell
                        $content = ''; // Initialize content variable for the cell
                        $rowspan = 1; // Default rowspan

                        // Loop through the schedule for this day
                        foreach ($other_schedule[$day] ?? [] as $key => $entry) {
                            $entry_start = isset($entry['start_time']) ? $entry['start_time'] : null;
                            $entry_end = isset($entry['end_time']) ? $entry['end_time'] : null;

                            // Ensure that start and end times exist and they fall within this time slot
                            if ($entry_start !== null && $entry_end !== null && $entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                // Convert the start and end times to a readable format
                                $start_time = date('g:i A', $entry_start); // Format: hh:mm AM/PM
                                $end_time = date('g:i A', $entry_end);  // Format: hh:mm AM/PM

                                // Calculate rowspan based on time duration
                                $rowspan = ceil(($entry_end - $entry_start) / 3600);

                                // Store content to be added in the cell
                                $content = "<div><strong>Time:</strong> $start_time - $end_time</div>
                                            <div><strong>Work Type:</strong> {$entry['work']}</div>
                                            <div><strong>Location:</strong> {$entry['room']}</div>
                                            <div><strong>Work Description:</strong> {$entry['work_description']}</div>";

                                // Remove the entry after processing
                                unset($other_schedule[$day][$key]);
                                $merged = true;
                                break; // Exit the loop once a matching entry is found
                            }
                        }

                        // Only render the cell with content, else leave it empty
                        if ($merged) {
                            echo "<td rowspan='$rowspan'>$content</td>";
                            $day_trackers[$day] = $rowspan - 1; // Set the tracker to avoid rendering extra cells
                        } else {
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

<?php 
include "components/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function printAcademicSchedule() {
        var printContents = "<h2>Academic Schedule</h2>" + document.getElementById("academicScheduleTable").outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function printOtherSchedule() {
        var printContents = "<h2>Other Work Schedule</h2>" + document.getElementById("otherWorkScheduleTable").outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
