<?php
include('../class.php');
$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['requestType'] == 'statistics') {
            // Fetch the data
            $data = $db->statistics();
            if ($data !== false) {
                // Return the data as JSON
                header('Content-Type: application/json');
                echo json_encode($data); // Encode here
            } else {
                // Handle errors
                http_response_code(500); // Internal Server Error
                echo json_encode(['error' => 'Failed to fetch data.']);
            }
        }
    
}
?>
