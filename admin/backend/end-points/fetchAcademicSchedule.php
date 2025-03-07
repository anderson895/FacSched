
<?php
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


                foreach ($time_slots as $slot_index => $slot): ?>
                    <tr >
                        <td  class="fw-bold"><?= $slot['label']; ?></td>
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
                                         (isset($entry['section']) ? htmlspecialchars($entry['section']) : 'Vacant Hours') . "' >";

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
            
 
