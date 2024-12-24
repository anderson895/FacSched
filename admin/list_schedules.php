<?php 
include "components/header.php";
?>
<div class="container mt-5">
    <!-- Title -->
    <h2 class="text-center mb-4 text-primary">List of Schedules</h2>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control rounded-pill shadow-sm" placeholder="Search by Teacher's Name">
    </div>

    <!-- Cards Container -->
    <div class="row">
    <?php 
    $fetch_schedule = $db->fetch_schedule();
    
    foreach ($fetch_schedule as $schedule):  // Loop through all schedules
    ?>
    <div class="col-md-4 mb-4 card-item" data-teacher-name="<?= strtolower($schedule['teacher_name']) ?>">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <!-- Display Teacher's Name -->
                <h5 class="card-title text-primary fw-bold"><?= ucfirst($schedule['teacher_name']) ?></h5>

                <!-- Process Days, Times, and Sched IDs -->
                <?php 
                $days = explode(',', $schedule['days']); // Days as an array
                $times = explode(',', $schedule['schedule_times']); // Times as an array
                $sched_ids_per_day = explode(',', $schedule['sched_ids_per_day']); // Schedule IDs as an array

                foreach ($days as $index => $day):
                    // Extract sched_id and day from sched_ids_per_day
                    list($sched_id, $sched_day) = explode(':', $sched_ids_per_day[$index]);

                    // Split the schedule times (start and end)
                    $time_range = explode('-', $times[$index]);
                    $start_time = $time_range[0];
                    $end_time = $time_range[1];

                    // Calculate total hours
                    $start_timestamp = strtotime($start_time);
                    $end_timestamp = strtotime($end_time);
                    $total_hours = round(abs($end_timestamp - $start_timestamp) / 3600, 2); // Total hours
                ?>
                <div class="d-flex justify-content-between mb-3 p-3 bg-light rounded">
                    <span class="text-muted fw-semibold"><?= ucfirst($day) ?> (Sched ID: <?= $sched_id ?>):</span>
                    <span class="text-muted"><?= date('h:i A', strtotime($start_time)) ?> - <?= date('h:i A', strtotime($end_time)) ?></span>
                </div>

            <!-- Assigned Subjects and Hours -->
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Remaining Hrs:</strong> <?= $total_hours ?>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                <?php 
                $fetch_workschedule = $db->fetch_workschedule($sched_id);

                // Check if there are workschedules
                if (!empty($fetch_workschedule)) {
                    $has_assigned_work = false;
                    foreach ($fetch_workschedule as $workschedule):

                        // Check if ws_id exists for each workschedule
                        if ($workschedule['ws_id']) { 
                            $has_assigned_work = true; 
                            
                            // Format start and end times with AM/PM
                            $start_time = date('h:i A', strtotime($workschedule['ws_subtStartTimeAssign']));
                            $end_time = date('h:i A', strtotime($workschedule['ws_subtEndTimeAssign']));
                            ?>
                            
                            <p class="mb-1"><strong><?= $workschedule['course'] ?>, <?= $workschedule['section'] ?>, <?= $workschedule['year_level'] ?></strong></p>
                            <p class="mb-0"><?= ucfirst($workschedule['subject_name']) ?> - <?= $start_time ?> - <?= $end_time ?></p>
                            <small><?= $workschedule['ws_roomCode'] ?></small>
                        <?php }
                    endforeach;
                    
                    if (!$has_assigned_work) {
                        echo '<p>No assigned work schedule.</p>';
                    }
                } else {
                    echo '<p>No work schedule assigned.</p>';
                }
                ?>
            </div>


                    <?php if (!empty($fetch_workschedule) && $has_assigned_work): ?>
                        <button class="btn btn-sm btn-outline-danger" type="button">×</button>
                    <?php endif; ?>

                </li>
            </ul>


                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-success btn-sm TogglerAssignSubject" data-bs-toggle="modal" data-bs-target="#assignSubjectModal"
                        data-totalHrs='<?= $total_hours ?>'
                        data-sched_id='<?= $sched_id ?>'>Teaching Work</a>
                    <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#">Other Work</a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#olModal">Overload</a>
                </div>
                <hr class="my-3">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


    <div id="noResultsMessage" class="alert alert-warning text-center" style="display: none;">
        No search results found.
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination">
            <li class="page-item" id="prevPage">
                <a class="page-link" href="#" aria-label="Previous">
                    Previous
                </a>
            </li>
            <ul class="pagination" id="pageNumbers"></ul>
            <li class="page-item" id="nextPage">
                <a class="page-link" href="#" aria-label="Next">
                    Next
                </a>
            </li>
        </ul>
    </nav>
</div>
















<!-- Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      <div id="spinner" class="spinner" style="display:none;">
                <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>


        <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subject & Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmAssign">
            <div class="mb-3">
                <h6>Total Remaining Hrs : <span id='totalHrs'></span></h6>
                <input hidden type="text" id="sched_id" name="sched_id">

                <label for="subject_id" class="form-label">Subject Name</label>
                <select class="form-control" id="subject_id" name="subject_id">
                    <option value="" disabled selected>Select subject name</option>
                    <?php 
                     // Fetch the list of days already taken by the teacher
                     $fetch_all_Subject = $db->fetch_all_Subject();
                     foreach ($fetch_all_Subject as $subject):?>
                    <option value="<?=$subject['subject_id']?>"><?=$subject['subject_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="subjectCode" class="form-label">Section</label>
                <select class="form-control" id="sectionId" name="sectionId">
                    <option value="" disabled selected>Select Section</option>
                    <?php
                    $fetch_all_Section = $db->fetch_all_Section();
                     foreach ($fetch_all_Section as $section):?>
                    <option value="<?=$section['sectionId']?>"><?=$section['course']?>,<?=$section['section']?>,<?=$section['year_level']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="roomCode" class="form-label">Room Code</label>
                <input type="text" class="form-control" name="roomCode" placeholder="Enter Room code">
            </div>

            <div class="mb-3">
                <input hidden type="text" id="typeOfWorks" name="typeOfWorks" value="Teaching Work">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="subtStartTimeAssign" class="form-label">Subject Start Time</label>
                    <input type="time" class="form-control" id="subtStartTimeAssign" name="subtStartTimeAssign" placeholder="Enter Start Time">
                </div>
                <div class="col-md-6">
                    <label for="subtEndTimeAssign" class="form-label">Subject End Time</label>
                    <input type="time" class="form-control" id="subtEndTimeAssign" name="subtEndTimeAssign" placeholder="Enter End Time">
                </div>
            </div>

            <button type="submit" id="btnAssignSched" class="btn btn-primary">Assign</button>
        </form>
      </div>
    </div>
  </div>
</div>













<!-- Modal -->
<div class="modal fade" id="olModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignSubjectModalLabel">Overload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>

                <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <select class="form-control" id="subjectName">
                            <option value="" disabled selected>Select subject name</option>
                            <?php 
                            // Fetch the list of days already taken by the teacher
                            $fetch_all_Subject = $db->fetch_all_Subject();
                            foreach ($fetch_all_Subject as $subject):?>
                            <option value="<?=$subject['subject_id']?>"><?=$subject['subject_name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subjectCode" class="form-label">Section</label>
                        <select class="form-control" id="subjectCode">
                            <option value="" disabled selected>Select Section</option>
                            <?php
                            $fetch_all_Section = $db->fetch_all_Section();
                            foreach ($fetch_all_Section as $section):?>
                            <option value="<?=$section['sectionId']?>"><?=$section['course']?>,<?=$section['section']?>,<?=$section['year_level']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roomCode" class="form-label">Room Code</label>
                        <input type="text" class="form-control" name="roomCode" placeholder="Enter Room code">
                    </div>

                    <button type="submit" class="btn btn-primary">Assign</button>
            
        </form>
      </div>
    </div>
  </div>
</div>






<?php 
include "components/footer.php";
?>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/list_of_schedules.js"></script>
