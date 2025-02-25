
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
