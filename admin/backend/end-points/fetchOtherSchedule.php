<h3 class="text-center mt-5">Other Work Schedule</h3>

    <div class="text-center mb-4">
        <button onclick="printOtherSchedule()" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Print Other Work Schedule
        </button>

    </div>
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
                $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);
                $other_schedule = $view_OtherSchedule['schedule'];
                $time_slots = $view_OtherSchedule['time_slots'];

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

                                    $work=ucfirst($entry['work']);
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