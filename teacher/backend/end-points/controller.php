<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'SetSchedule') {
            $teacher_id = $_POST['teacher_id'];
            $scheduleDay = $_POST['scheduleDay'];
            $scheduleStartTime = $_POST['scheduleStartTime'];
            $scheduleEndTime = $_POST['scheduleEndTime'];
          
            $response = $db->SetSchedule($teacher_id, $scheduleDay,$scheduleStartTime,$scheduleEndTime);

          return $response;


        }

    }
}