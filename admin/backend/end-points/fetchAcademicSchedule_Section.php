<h2 class="text-center mb-4">Schedule for : <span id="teacherName"><?= $sectionDetails; ?></span></h2>

<!-- Print Buttons -->
<div class="text-center mb-4">
    <button onclick="printAcademicSchedule()" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Academic Schedule
    </button>
</div>

<?php
// Check if there is no schedule
$academic_schedule = $view_AcademicSchedule['schedule'];
$time_slots = $view_AcademicSchedule['time_slots'];

$noScheduleFound = true; // Flag to check if any schedule is found

// Loop through time slots to check if any data exists
foreach ($time_slots as $slot_index => $slot) {
    foreach (array_keys($academic_schedule) as $day) {
        if (!empty($academic_schedule[$day])) {
            $noScheduleFound = false;
            break 2; // Exit both loops if a schedule is found
        }
    }
}

// If no schedule found, display a message
if ($noScheduleFound) {
    echo '<div class="alert alert-warning text-center">No schedule found</div>';
} else {
    // Display the academic schedule table
    ?>
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

                foreach ($time_slots as $slot_index => $slot): ?>
                    <?php
                    $row_covered = false; // Flag to track if the row is covered by a schedule
                    ?>
                    <tr style="<?= $row_covered ? 'background-color: #f2f2f2;' : ''; ?>">
                        <td class="fw-bold"><?= $slot['label']; ?></td>
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

                                $status = str_replace('_', ' ', ucfirst($entry['ws_status'])); 
                                $color = ($entry['ws_status'] === "regular_work") ? "green" : "red";

                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 1800) {
                                    $rowspan = ceil(($entry_end - $entry_start) / 1800); // Adjusted for 30-minute intervals

                                    // Apply background color to the entire row if a schedule is present
                                    $row_covered = true;

                                    echo "<td rowspan='$rowspan' class='schedule-entry' data-section='" . 
                                         (isset($entry['section']) ? htmlspecialchars($entry['section']) : 'Vacant Hours') . "' style='background-color: #f2f2f2;'>";

                                   echo "<div>{$entry['room']}</div>";
                                   echo "<div>{$entry['semester']} Semester</div>";
                                   echo "<div>Teacher: {$entry['teacherName']}</div>";
                                   echo "<div>Subject: {$entry['subject_name']}</div>";
                                   echo "<div>Status: <div style='color: $color;'>$status</div></div>";

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
<?php } ?>
