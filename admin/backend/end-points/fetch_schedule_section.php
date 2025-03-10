<?php
include('../class.php');

$db = new global_class();

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
    <?php include "backend/end-points/fetchAcademicSchedule.php";?>
    <?php include "backend/end-points/fetchOtherSchedule.php";?>
</div>