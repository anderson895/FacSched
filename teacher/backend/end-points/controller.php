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

        }else if ($_POST['requestType'] == 'UpdateSchedule') {


            $teacher_id = $_POST['teacher_id'];
            $scheduleId = $_POST['sched_id'];
            
            // Check if 'scheduleDay' is set and not empty, and assign '' if it's empty
            $scheduleDay = isset($_POST['scheduleDay']) && trim($_POST['scheduleDay']) !== '' ? $_POST['scheduleDay'] : '';
            
            // Get the other schedule details
            $scheduleStartTime = $_POST['scheduleStartTime'];
            $scheduleEndTime = $_POST['scheduleEndTime'];
            
            // Call the UpdateSchedule function
            $response = $db->UpdateSchedule($teacher_id, $scheduleDay, $scheduleStartTime, $scheduleEndTime, $scheduleId);
            
            // Return the response
            return $response;
            
            


        }else if ($_POST['requestType'] == 'ChooseWeeklyHrs') {


            $weeklyHours = $_POST['weeklyHours'];
            $teacher_id = $_POST['teacher_id'];
           
            
            // Call the UpdateSchedule function
            $response = $db->ChooseWeeklyHrs($teacher_id,$weeklyHours);
            
            // Return the response
            return $response;
            
            


        }

    }
}