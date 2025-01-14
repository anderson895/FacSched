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
<div class="container my-5">
    <div class="row">
        <?php 
        $fetch_schedule = $db->fetch_schedule();
        foreach ($fetch_schedule as $schedule):  // Loop through all schedules
        ?>
        <div class="col-md-4 mb-4 card-item" data-teacher-name="<?= strtolower($schedule['teacher_name']) ?>">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Display Teacher's Name -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title text-primary fw-bold"><?= ucfirst($schedule['teacher_name']) ?></h5>
                        <a href="view_schedule.php?teacher_id=<?= $schedule['sched_teacher_id'] ?>">
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </a>
                        

                    </div>


                    <!-- Process Days, Times, and Sched IDs -->
                    <?php 
                   $days = explode(',', $schedule['days']); // Days as an array
                   $times = explode(',', $schedule['schedule_times']); // Times as an array
                   $sched_ids_per_day = explode(',', $schedule['sched_ids_per_day']); // Schedule IDs as an array
                   $remaining_hours_per_day = explode(',', $schedule['remaining_hours_per_day']); // Schedule IDs as an array
                   $total_hours_workschedule = explode(',', $schedule['total_minutes_workschedule']); // Total work schedule hours
                   $total_offcampus_work_time = explode(',', $schedule['total_offcampus_work_time']); // Off-campus work time
                   $total_admin_work_time = explode(',', $schedule['total_admin_work_time']); // Admin work time
                    
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
                       
                       // Calculate total scheduled hours in minutes
                       $total_minutes = round(abs($end_timestamp - $start_timestamp) / 60, 2); // Total minutes
                       
                       // Get corresponding work schedule hours (default to 0 if not available)
                       $work_schedule_minutes = isset($total_hours_workschedule[$index]) ? $total_hours_workschedule[$index] : 0;
                       
                       // Calculate remaining minutes
                       $remaining_minutes = $total_minutes - $work_schedule_minutes;
                       
                       // Convert remaining minutes to hours (optional: you can also keep it in minutes if preferred)
                       $remaining_hours = round($remaining_minutes / 60, 2); // Convert to hours
                       
                       // Check if remaining time should be displayed in hours or minutes
                       if ($remaining_hours >= 1) {
                           // If remaining hours are 1 or more, display hours
                           $remaining_time = $remaining_hours . ' hour(s)';
                       } else {
                           // If remaining hours are less than 1, display minutes
                           $remaining_time = $remaining_minutes . ' minute(s)';
                       }

                    ?>
                    <div class="d-flex justify-content-between mb-3 p-3 bg-light rounded">
                        <span class="text-muted fw-semibold"><?= ucfirst($day) ?> </span>
                        <span class="text-muted"><?= date('h:i A', strtotime($start_time)) ?> - <?= date('h:i A', strtotime($end_time)) ?></span>
                    </div>

                    <!-- Assigned Subjects and Hours -->
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           Total Scheduled Hours: <i><?= $total_hours ?> hrs</i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Remaining Hrs: <i><?= $remaining_hours >= 1 ? "$remaining_hours hour(s)" : "$remaining_minutes minute(s)"; ?></i>
                        </li>
                        <!-- Display Off-campus work time -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Off-campus Work: <i><?= isset($total_offcampus_work_time[$index]) ? round($total_offcampus_work_time[$index] / 60, 2) . ' hrs' : '0 hrs'; ?></i>
                        </li>
                        <!-- Display Admin work time -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Admin Work: <i><?= isset($total_admin_work_time[$index]) ? round($total_admin_work_time[$index] / 60, 2) . ' hrs' : '0 hrs'; ?></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="container" style="max-height: 300px; overflow-y: auto;">
                                <?php 
                                include "backend/end-points/schedule_list.php";
                                ?>
                            </div>
                        </li>

                    </ul>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-success btn-sm TogglerAssignSubject" data-bs-toggle="modal" data-bs-target="#assignSubjectModal"
                            data-remaining_hours='<?= $remaining_hours ?>'
                            data-sched_id='<?= $sched_id ?>'>Teaching Work</a>
                        <a href="#" class="btn btn-outline-primary TogglerAssignOtherWork btn-sm" data-bs-toggle="modal" data-bs-target="#assignOtherWorkModal"
                            data-remaining_hours='<?= $remaining_hours ?>'
                            data-sched_id='<?= $sched_id ?>'
                        >Other Work</a>
                        <a href="#" class="btn btn-outline-danger btn-sm TogglerAssignOverLoadWork" data-bs-toggle="modal" data-bs-target="#olModal"
                            data-remaining_hours='<?= $remaining_hours ?>'
                            data-sched_id='<?= $sched_id ?>'
                        >Overload</a>
                    </div>
                    <hr class="my-3">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
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


        <h5 class="modal-title" id="assignSubjectModalLabel">Assign Teaching Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmAssign">
            
        
        
        <div class="mb-3">
                <h6>Total Remaining Hrs : <span class='remaining_hours'></span></h6>
                <input hidden type="text" id="sched_id" name="sched_id" required>

                <label for="subject_id" class="form-label">Subject Name</label>
                <select class="form-control" id="subject_id" name="subject_id" required>
                    <option value="" disabled selected>Select subject name</option>
                    <?php 
                    $fetch_all_Subject = $db->fetch_all_Subject();
                    foreach ($fetch_all_Subject as $subject): 
                        $semester_ordinalFormat = $db->formatOrdinal($subject['semester']);
                        ?>
                        <option value="<?=$subject['subject_id']?>" data-designated_year_level="<?=$subject['designated_year_level']?>"><?=$subject['subject_name']?> (<?=$subject['hours']?> hours)- <?=$semester_ordinalFormat?> </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="subjectCode" class="form-label">Section</label>
                <select class="form-control" id="sectionId" name="sectionId" required>
                    <option value="" disabled selected>Select Section</option>
                    <?php
                    $fetch_all_Section = $db->fetch_all_Section();
                    foreach ($fetch_all_Section as $section): 
                        // Map year levels like '1st', '2nd' to numeric values
                        $numeric_year_level = (int) filter_var($section['year_level'], FILTER_SANITIZE_NUMBER_INT);
                    ?>
                        <option value="<?=$section['sectionId']?>" data-year-level="<?=$numeric_year_level?>"><?=$section['course']?>,<?=$section['section']?>,<?=$section['year_level']?></option>
                    <?php endforeach; ?>
                </select>
            </div>





            <div class="mb-3">
                <label for="roomCode" class="form-label">Room code</label>
                <input type="text" class="form-control" name="roomCode" placeholder="Enter Room code" required>
            </div>

            <div class="mb-3">
                <input hidden type="text" id="typeOfWorks" name="typeOfWorks" value="Teaching Work" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="subtStartTimeAssign" class="form-label">Subject Start Time</label>
                    <input type="time" class="form-control" id="subtStartTimeAssign" name="subtStartTimeAssign" placeholder="Enter Start Time" required>
                </div>
                <div class="col-md-6">
                    <label for="subtEndTimeAssign" class="form-label">Subject End Time</label>
                    <input type="time" class="form-control" id="subtEndTimeAssign" name="subtEndTimeAssign" placeholder="Enter End Time" required>
                </div>
            </div>

            <button type="submit" id="btnAssignSched" class="btn btn-primary">Assign</button>
        </form>
      </div>
    </div>
  </div>
</div>








<!-- Modal For Overload Schedule-->
<div class="modal fade" id="olModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignSubjectModalLabel">Assign Overload Works</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmAssign_OverLoad">

            <div id="spinner" class="spinner" style="display:none;">
                    <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <input hidden type="text" name="typeOfWorks" value="Teaching Work" required>
                </div>

                <input hidden type="text" id="sched_id_OverLoad" name="sched_id" required>
                <div hidden class="mb-3">
                    <label for="overload_work" class="form-label">WS_STATUS</label>
                    <input type="text" class="form-control" name="overload_work" value="overload_work" required>
                </div>


                <div class="mb-3">
                    <label for="subjectName" class="form-label">Subject Name</label>
                    <select class="form-control" id="subjectName" name="subject_id" required>
                        <option value="" disabled selected>Select subject name</option>
                        <?php 
                        $fetch_all_Subject = $db->fetch_all_Subject();
                        foreach ($fetch_all_Subject as $subject): ?>
                            <option value="<?=$subject['subject_id']?>" data-designated_year_level="<?=$subject['designated_year_level']?>"><?=$subject['subject_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subjectCode" class="form-label">Section</label>
                    <select class="form-control" id="subjectCode" name="sectionId" required>
                        <option value="" disabled selected>Select Section</option>
                        <?php
                        $fetch_all_Section = $db->fetch_all_Section();
                        foreach ($fetch_all_Section as $section): 
                            // Extract numeric value from year levels like '1st', '2nd', etc.
                            $numeric_year_level = (int) filter_var($section['year_level'], FILTER_SANITIZE_NUMBER_INT);
                        ?>
                            <option value="<?=$section['sectionId']?>" data-year-level="<?=$numeric_year_level?>"><?=$section['course']?>,<?=$section['section']?>,<?=$section['year_level']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>



                    <div class="mb-3">
                        <label for="roomCode" class="form-label" >Room Code</label>
                        <input type="text" class="form-control" name="roomCode" placeholder="Enter Room code" required>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="subtStartTimeAssign_OverLoad" class="form-label">Subject Start Time</label>
                            <input type="time" class="form-control" id="subtStartTimeAssign_OverLoad" name="subtStartTimeAssign" placeholder="Enter Start Time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="subtEndTimeAssign_OverLoad" class="form-label">Subject End Time</label>
                            <input type="time" class="form-control" id="subtEndTimeAssign_OverLoad" name="subtEndTimeAssign" placeholder="Enter End Time" required>
                        </div>
                    </div>

                    <button type="submit" id="btnAssignSched_OverLoad" class="btn btn-primary">Assign</button>
            
        </form>
      </div>
    </div>
  </div>
</div>












<!-- Modal FOr Other work -->
<div class="modal fade" id="assignOtherWorkModal" tabindex="-1" aria-labelledby="assignOtherWorkModalLabel" aria-hidden="true">
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


        <h5 class="modal-title" id="assignOtherWorkModalLabel">Assign Other Work</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmAssignOther">
            <div class="mb-3">
                <h6>Total Remaining Hrs : <span class='remaining_hours'></span></h6>
                <input hidden type="text" id="sched_id_other" name="sched_id">
            </div>
           
            <div class="mb-3">
                <label for="roomCode" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" placeholder="Enter Location">
            </div>


            <div class="mb-3">
                <label for="roomCode" class="form-label">Work Description</label>
                <input type="text" class="form-control" name="work_description" placeholder="Enter Work Description">
            </div>

            <div class="mb-3">
                <label for="typeOfWorks" class="form-label">Type of Work</label>
                <select id="typeOfWorks" name="typeOfWorks" class="form-control">
                    <option value="admin work">Admin Work</option>
                    <option value="off campus work">Off Campus Work</option>
                </select>
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

            <button type="submit" id="btnAssignOtherSched" class="btn btn-primary">Assign</button>
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
