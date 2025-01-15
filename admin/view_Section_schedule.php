<?php
include "components/header.php";

$sectionId = $_GET['sectionId'];

$view_AcademicSchedule = $db->view_AcademicSchedule_Section($sectionId);  // Query from tblworkschedule

$section = $db->getSectionInfo($sectionId);  
$sectionDetails = strtoupper(ucfirst($section[0]['course']))  . ' ' . strtoupper($section[0]['section']. ' , ' . strtoupper($section[0]['year_level']));


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


// Remove duplicate sections
$sections = array_unique($sections);
?>
<div class="container mt-5">
    <?php include "backend/end-points/fetchAcademicSchedule_Section.php";?>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/function.js"></script>

