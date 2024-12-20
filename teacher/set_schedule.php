<?php 
include "components/header.php";
?>

<!-- Main Content -->
<div class="container my-4">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Set Schedule</h1>
            <p>This is the main content area where you can set your schedule.</p>

            <!-- Button to set schedule -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setScheduleModal">
                Set Schedule
            </button>
        </div>
    </div>

    <div class="row mt-4">
    <?php 
    $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    $fetch_schedule = $db->fetch_schedule($teacher['teacher_id']);

    foreach ($daysOfWeek as $day):
        $scheduleForDay = null;

        foreach ($fetch_schedule as $schedule):
            if (strtolower($schedule['sched_day']) == $day) {
                $scheduleForDay = $schedule;
                break;
            }
        endforeach;

        if ($scheduleForDay):
    ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <?php echo ucfirst($day); ?>
                </div>
                <div class="card-body">
                    <p id="schedule-<?php echo $day; ?>">
                        <?php 
                        $startTime = date('h:i A', strtotime($scheduleForDay['sched_start_Hrs']));
                        $endTime = date('h:i A', strtotime($scheduleForDay['sched_end_Hrs']));

                        $start = strtotime($scheduleForDay['sched_start_Hrs']);
                        $end = strtotime($scheduleForDay['sched_end_Hrs']);
                        $diff = $end - $start;

                        $hours = floor($diff / 3600);
                        $minutes = floor(($diff % 3600) / 60);

                        echo "Start Time: " . $startTime . "<br>End Time: " . $endTime . "<br>";
                        
                        if ($minutes > 0) {
                            echo "Total Hours: " . $hours . " hours " . $minutes . " minutes";
                        } else {
                            echo "Total Hours: " . $hours . " hours";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    <?php 
        endif;
    endforeach; 
    ?>
</div>


























<div class="modal fade" id="setScheduleModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="setScheduleModalLabel">Set Your Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for setting schedule -->
                            <form id="frmSetSchedule">

                            <input hidden type="text" id="teacher_id" name="teacher_id" value="<?=$teacher['teacher_id']?>" required>
                                <div class="form-group">
                                    <label for="scheduleDay">Day of the Week</label>
                                    <select class="form-control" id="scheduleDay" name="scheduleDay">
                                        <?php 
                                        // Get the list of taken days for the teacher
                                        $takenDays = $db->CheckDayIfAlreadyTaken($teacher['teacher_id']);
                                        
                                        // Define all the days of the week
                                        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                        
                                        // Loop through the days and generate the options
                                        foreach ($daysOfWeek as $day):
                                            // Check if the day is already taken and disable the option
                                            $disabled = in_array($day, $takenDays) ? 'disabled' : '';
                                        ?>
                                            <option value="<?php echo $day; ?>" <?php echo $disabled; ?>>
                                                <?php echo ucfirst($day); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>


                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="scheduleStartTime">Start Time</label>
                                        <input type="time" class="form-control" id="scheduleStartTime" name="scheduleStartTime" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="scheduleEndTime">End Time</label>
                                        <input type="time" class="form-control" id="scheduleEndTime" name="scheduleEndTime" required>
                                    </div>
                                </div>


                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnSaveSchedule" class="btn btn-primary">Save Schedule</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>

<!-- jQuery Script for Search, Pagination, and Add Section -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="js/displayTable.js"></script> -->

<?php 
include "components/footer.php";
?>
