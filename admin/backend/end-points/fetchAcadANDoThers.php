<h2 class="text-center mb-4">Faculty Schedule for Teacher: <span id="teacherName"><?= $teacherName; ?></span></h2>

<!-- Print Buttons -->
<div class="text-center mb-4">
    <button onclick="printAcademicSchedule()" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Schedule
    </button>
</div>

<!-- Filter Dropdown -->
<div class="mb-4">
    <label for="sectionFilter" class="form-label">Filter by Section:</label>
    <select id="sectionFilter" class="form-select" onchange="filterBySection()">
        <option value="">All Sections</option>
        <?php foreach ($sections as $section): ?>
            <option value="<?= htmlspecialchars($section); ?>"><?= htmlspecialchars($section); ?></option>
        <?php endforeach; ?>
    </select>
</div>

<?php
// Check if there are any records in the academic schedule
$academic_schedule = $view_AcademicSchedule['schedule'];
$time_slots = $view_AcademicSchedule['time_slots'];

// Flag to check if there are any records
$noRecordsFound = true; 

// Loop through time slots to check if there is any data
foreach ($time_slots as $slot_index => $slot) {
    foreach (array_keys($academic_schedule) as $day) {
        if (!empty($academic_schedule[$day])) {
            $noRecordsFound = false;
            break 2; // Exit both loops if records are found
        }
    }
}

// If no records found, display a message
if ($noRecordsFound) {
    // echo '<div class="alert alert-warning text-center">No records found for Academic Schedule</div>';
} else {
    // Display the schedule table if records are found
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
                    <tr>
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
                                    echo "<td rowspan='$rowspan' class='schedule-entry' data-section='" . 
                                         (isset($entry['section']) ? htmlspecialchars($entry['section']) : 'Vacant Hours') . "' style='background-color: #f2f2f2;'>";

                                    echo "<div>Semester {$entry['semester']}</div>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div>{$entry['section']} - {$entry['year_level']}</div>";
                                    echo "<div>{$entry['subject_name']}</div>";
                                    echo "<div style='color: $color;'>$status</div>";

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
            
    </div>
<?php } ?>

<?php
// Check if there are any records in the schedule
$other_schedule = $view_OtherSchedule['schedule'];
$time_slots = $view_OtherSchedule['time_slots'];

// Flag to check if there are any records
$noRecordsFound = true; 

// Loop through time slots to check if there is any data
foreach ($time_slots as $slot_index => $slot) {
    foreach (array_keys($other_schedule) as $day) {
        if (!empty($other_schedule[$day])) {
            $noRecordsFound = false;
            break 2; // Exit both loops if records are found
        }
    }
}

// If no records found, display a message
if ($noRecordsFound) {
    // echo '<div class="alert alert-warning text-center">No records found for Other Work Schedule</div>';
} else {
    // Display the table if there are records
    ?>
    <div class="table-responsive">
       
            <?php
                $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);

                foreach ($time_slots as $slot_index => $slot): ?>
                    <tr>
                        <td class="fw-bold"><?= $slot['label']; ?></td>
                        <?php foreach (array_keys($day_trackers) as $day): ?>
                            <?php
                            if ($day_trackers[$day] > 0) {
                                $day_trackers[$day]--;
                                continue;
                            }

                            $merged = false;
                            foreach ($other_schedule[$day] ?? [] as $key => $entry) {
                                $entry_start = $entry['start_time'];
                                $entry_end = $entry['end_time'];

                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                    $rowspan = ceil(($entry_end - $entry_start) / 3600);

                                    $work = ucfirst($entry['work']);
                                    echo "<td rowspan='$rowspan' class='schedule-entry' data-section='" . 
                                         (isset($entry['section']) ? htmlspecialchars($entry['section']) : 'No Section') . "'>";
                                    echo "<div>{$work}</div>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div><i>({$entry['work_description']})</i></div>";
                                    echo "</td>";

                                    $day_trackers[$day] = $rowspan - 1;
                                    unset($other_schedule[$day][$key]);
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
