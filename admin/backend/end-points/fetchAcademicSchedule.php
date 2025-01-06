<?php
                $day_trackers = array_fill_keys(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 0);
                $academic_schedule = $view_AcademicSchedule['schedule'];
                $time_slots = $view_AcademicSchedule['time_slots'];

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

                                if ($entry_start >= $slot['start'] && $entry_start < $slot['start'] + 3600) {
                                    $rowspan = ceil(($entry_end - $entry_start) / 3600);
                                    echo "<td rowspan='$rowspan' class='schedule-entry' data-section='" . 
                                         (isset($entry['section']) ? htmlspecialchars($entry['section']) : 'No Section') . "'>";
                                    echo "<div>Semester {$entry['semester']}</div>";
                                    echo "<div>{$entry['room']}</div>";
                                    echo "<div>{$entry['section']}</div>";
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