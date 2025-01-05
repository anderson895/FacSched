<?php 
include "components/header.php";

$teacher_id = $_GET['teacher_id'];

$view_schedule = $db->view_schedule($teacher_id);  
$teacher = $db->getTeacherInfo($teacher_id);  
$teacherName = ucfirst($teacher[0]['fname']) . ' ' . $teacher[0]['mname'] . ' ' . $teacher[0]['lname'];

?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Faculty Schedule for Teacher : <?= $teacherName; ?></h2>
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
                $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);
                $schedule = $view_schedule['schedule'];  // Get schedule data
                $time_slots = $view_schedule['time_slots'];  // Get time slots data

                foreach ($time_slots as $slot_index => $slot): ?>
                    <tr>
                        <td class="fw-bold"><?= $slot['label'] ?></td>
                        <?php foreach (array_keys($day_trackers) as $day): ?>
                            <?php
                            // Skip rendering if current time slot is covered
                            if ($day_trackers[$day] > 0) {
                                $day_trackers[$day]--; // Decrease tracker for remaining slots
                                continue;
                            }

                            // Check if there is a schedule matching this time slot
                            $merged = false;
                            foreach ($schedule[$day] ?? [] as $key => $entry) {
                                $entry_start = $entry['start_time'];
                                $entry_end = $entry['end_time'];

                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                    // Calculate rowspan for the merged cell
                                    $rowspan = ceil(($entry_end - $entry_start) / 3600);

                                    echo "<td rowspan='$rowspan'>";
                                    echo "<div>Semester {$entry['semester']}</div>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div>{$entry['subject_name']}</div>";
                                    echo "<div>{$entry['section']}</div>";
                                    echo "</td>";

                                    // Mark subsequent time slots as covered
                                    $day_trackers[$day] = $rowspan - 1;

                                    // Remove the processed schedule entry
                                    unset($schedule[$day][$key]);
                                    $merged = true;
                                    break;
                                }
                            }

                            // If no schedule matches, skip rendering this time slot
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



<?php 
include "components/footer.php";
?>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>