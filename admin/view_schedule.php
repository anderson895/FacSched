<?php
include "components/header.php";

$teacher_id = $_GET['teacher_id'];

$view_AcademicSchedule = $db->view_AcademicSchedule($teacher_id);  // Query from tblworkschedule
$view_OtherSchedule = $db->view_OtherSchedule($teacher_id);  // Query from tblotherworkschedule

$teacher = $db->getTeacherInfo($teacher_id);  
$teacherName = ucfirst($teacher[0]['fname']) . ' ' . $teacher[0]['mname'] . ' ' . $teacher[0]['lname'];

// Collect sections for filter dropdown
$sections = [];

// Extract sections from Academic Schedule
foreach ($view_AcademicSchedule['schedule'] as $day => $entries) {
    foreach ($entries as $entry) {
        if (isset($entry['section'])) {
            $sections[] = $entry['section'];
        }
    }
}

// Extract sections from Other Work Schedule
foreach ($view_OtherSchedule['schedule'] as $day => $entries) {
    foreach ($entries as $entry) {
        if (isset($entry['section'])) {
            $sections[] = $entry['section'];
        }
    }
}

// Remove duplicate sections
$sections = array_unique($sections);
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Faculty Schedule for Teacher: <?= $teacherName; ?></h2>
   <!-- Print Buttons -->
   <div class="text-center mb-4">
        <button onclick="printAcademicSchedule()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Print Academic Schedule
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
            <option value="No Section">Vacant Hours</option>
        </select>
    </div>

 

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
                <?php include "backend/end-points/fetchAcademicSchedule.php";?>
            </tbody>
        </table>
    </div>

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
                            <?php include "backend/end-points/fetchOtherSchedule.php";?>
            </tbody>
        </table>
    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/function.js"></script>
