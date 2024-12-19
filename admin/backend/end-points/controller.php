<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'addSection') {
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $section = $_POST['section'];

            // Call the Login method and get the result
            $response = $db->addSection($course, $year_level,$section);

          return $response;


        }else if ($_POST['requestType'] == 'UpdateSection') {
            $sectionId = $_POST['sectionId'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $section = $_POST['section'];

            // Call the Login method and get the result
            $response = $db->UpdateSection($course, $year_level,$section,$sectionId);

          return $response;


        } else if ($_POST['requestType'] == 'deleteSection') {
            $sectionId = $_POST['sectionId'];
           

            // Call the Login method and get the result
            $response = $db->deleteSection($sectionId);

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