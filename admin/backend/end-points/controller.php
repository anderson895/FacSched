<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'addSubject') {
            $subjectCode = $_POST['subjectCode'];
            $subjectName = $_POST['subjectName'];
            $lab = $_POST['lab'];
            $lec = $_POST['lec'];
            $hrs = $_POST['hrs'];
            $Sem = $_POST['Sem'];
            $yrlvl = $_POST['yrlvl'];
            $response = $db->addSubject($subjectCode, $subjectName,$lab,$lec,$hrs,$Sem,$yrlvl);

          return $response;


        }else if ($_POST['requestType'] == 'addSection') {
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $section = $_POST['section'];
            $response = $db->addSection($course, $year_level,$section);

          return $response;

        }else if ($_POST['requestType'] == 'UpdateSection') {
            $sectionId = $_POST['sectionId'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $section = $_POST['section'];
            $response = $db->UpdateSection($course, $year_level,$section,$sectionId);

          return $response;


        }else if ($_POST['requestType'] == 'updateSubject') {
            $subjectId = $_POST['subjectId'];
            $subjectCode = $_POST['subjectCode'];
            $subject_name = $_POST['subject_name'];
            $lab_num = $_POST['lab_num'];
            $lec_num = $_POST['lec_num'];
            $hours = $_POST['hours'];
            $semester = $_POST['semester'];
            $designated_year_level = $_POST['designated_year_level'];

            $response = $db->updateSubject($subjectId, $subjectCode,$subject_name,$lab_num,$lec_num,$hours,$semester,$designated_year_level);

          return $response;


        } else if ($_POST['requestType'] == 'deleteSection') {
            $sectionId = $_POST['sectionId'];
            $response = $db->deleteSection($sectionId);

          return $response;


        }else if ($_POST['requestType'] == 'deleteSection') {
          $sectionId = $_POST['sectionId'];
          $response = $db->deleteSection($sectionId);

        return $response;


        }else if ($_POST['requestType'] == 'deleteTeacher') {
            $teacher_id = $_POST['teacher_id'];
            $response = $db->deleteTeacher($teacher_id);

          return $response;


        }else if ($_POST['requestType'] == 'addTeacher') {
          $teacherCode = $_POST['teacherCode'];
          $fname = $_POST['fname'];
          $mname = $_POST['mname'];
          $lname = $_POST['lname'];
          $designation = $_POST['designation'];
          $password = $lname;
          $response = $db->addTeacher($teacherCode, $fname,$mname,$lname,$designation,$password);

        return $response;


        } else if ($_POST['requestType'] == 'updateTeacher') {
          $teacher_id = $_POST['teacher_id'];
          $teacherCode = $_POST['teacherCode'];
          $fname = $_POST['fname'];
          $mname = $_POST['mname'];
          $lname = $_POST['lname'];
          $designation = $_POST['designation'];
          $password = $_POST['newpassword'];
          $response = $db->updateTeacher($teacher_id,$teacherCode, $fname,$mname,$lname,$designation,$password);

        return $response;


        }else if ($_POST['requestType'] == 'AssignSched') {


          $sched_id = $_POST['sched_id'];
          $subject_id = $_POST['subject_id'];
          $sectionId = $_POST['sectionId'];
          $roomCode = $_POST['roomCode'];
          $typeOfWorks = $_POST['typeOfWorks'];
          $subtStartTimeAssign = $_POST['subtStartTimeAssign'];
          $subtEndTimeAssign = $_POST['subtEndTimeAssign'];
          $response = $db->AssignSched($sched_id, $subject_id,$sectionId,$roomCode,$typeOfWorks,$subtStartTimeAssign,$subtEndTimeAssign);

        return $response;


        }else if ($_POST['requestType'] == 'AssignSched_OverLoad') {


          echo "<pre>";
          print_r($_POST);
          echo "</pre>";
          $sched_id = $_POST['sched_id'];
          $overload_work = $_POST['overload_work'];
          $subject_id = $_POST['subject_id'];
          $sectionId = $_POST['sectionId'];
          $roomCode = $_POST['roomCode'];
          $typeOfWorks = $_POST['typeOfWorks'];
          $subtStartTimeAssign = $_POST['subtStartTimeAssign'];
          $subtEndTimeAssign = $_POST['subtEndTimeAssign'];
          $response = $db->AssignSched_OverLoad($sched_id, $subject_id,$sectionId,$roomCode,$typeOfWorks,$subtStartTimeAssign,$subtEndTimeAssign,$overload_work);

        return $response;


        }else if ($_POST['requestType'] == 'AssignSchedOthers') {


          $sched_id = $_POST['sched_id'];
          $location = $_POST['location'];
          $work_description = $_POST['work_description'];

          $typeOfWorks = $_POST['typeOfWorks'];
          $subtStartTimeAssign = $_POST['subtStartTimeAssign'];
          $subtEndTimeAssign = $_POST['subtEndTimeAssign'];
          $response = $db->AssignSchedOthers($sched_id,$location,$work_description,$typeOfWorks,$subtStartTimeAssign,$subtEndTimeAssign);

        return $response;


        }else if ($_POST['requestType'] == 'DeleteWorkSchedule') {


          $ws_id = $_POST['ws_id'];
          $response = $db->DeleteWorkSchedule($ws_id);

        return $response;


        }else if ($_POST['requestType'] == 'DeleteWorkScheduleOther') {


          $ows_id = $_POST['ows_id'];
          $response = $db->DeleteWorkScheduleOther($ows_id);

        return $response;


        }else {
              echo 'Invalid request type';
          }


        











    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Access Denied! No Request Type.'
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'GET requests are not supported for login.'
    ]);
}
?>