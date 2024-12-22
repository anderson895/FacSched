<?php 
include "components/header.php";
?>

<div class="container mt-5">
    <!-- Title -->
    <h2 class="text-center mb-4">List of Schedules</h2>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Teacher's Name">
    </div>

    <!-- Cards Container -->
    <div class="row" id="scheduleList">
        <?php 
        $fetch_schedule = $db->fetch_schedule();
        foreach ($fetch_schedule as $schedule):  // Loop through all schedules
        ?>
        <div class="col-md-4 mb-4 card-item" data-teacher-name="<?= strtolower($schedule['teacher_name']) ?>">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Display Teacher's Name -->
                    <h5 class="card-title mb-3"><?= ucfirst($schedule['teacher_name']) ?></h5>

                    <!-- Loop through the days and corresponding schedule times -->
                    <?php 
                    $days = explode(',', $schedule['days']); // Days as an array
                    $times = explode(',', $schedule['schedule_times']); // Times as an array

                    foreach ($days as $index => $day):
                        // Split the schedule times (start and end)
                        $time_range = explode('-', $times[$index]);
                        $start_time = $time_range[0];
                        $end_time = $time_range[1];

                        // Calculate total hours
                        $start_timestamp = strtotime($start_time);
                        $end_timestamp = strtotime($end_time);
                        $total_hours = round(abs($end_timestamp - $start_timestamp) / 3600, 2); // Total hours
                    ?>
                    <div class="d-flex justify-content-between mb-3 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                        <span class="text-muted" style="font-weight: bold;"><?= ucfirst($day) ?>:</span>
                        <span class="text-muted"><?= date('h:i A', strtotime($start_time)) ?> - <?= date('h:i A', strtotime($end_time)) ?></span>
                    </div>

                    <p class="text-muted mb-3" style="font-size: 0.9rem;">Total Hours: <?=$total_hours?></p>

                    <!-- Assigned Subjects and Hours (Static details) -->
                    <ul class="list-unstyled mb-3">
                        <li class="d-flex justify-content-between align-items-center">
                            <span>BSIT11A , CP1 9:30am - 10:30am | Room 103</span>
                            <button class="btn btn-sm btn-outline-danger" type="button">×</button>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <span>BSIT11A , CP2 11:30am - 1:30pm | Room 103</span>
                            <button class="btn btn-sm btn-outline-danger" type="button">×</button>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-outline-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#assignSubjectModal">Teaching work</a>
                    <a href="#" class="btn btn-outline-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#">Other work</a>
                    <a href="#" class="btn btn-outline-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#olModal">Overload</a>
                    <hr class="my-3">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
        No search results found.
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center" id="pagination">
            <li class="page-item" id="prevPage"><a class="page-link" href="#">Previous</a></li>
            <ul class="pagination" id="pageNumbers"></ul> <!-- Page numbers will be inserted here -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
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





<!-- Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subject & Section</h5>
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



            <div class="mb-3">
                <label for="roomCode" class="form-label">Type of works</label>
                <select class="form-select" name="typeOfWorks" id="typeOfWorks" required>
                    <option value="">Select type</option>
                    <option value="Offcampus work">Offcampus work</option>
                    <option value="Admin work">Admin work</option>
                    <option value="Teaching work">Teaching work</option>
                </select>
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
