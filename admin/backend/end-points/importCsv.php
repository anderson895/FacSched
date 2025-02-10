<?php
include('../class.php');

$db = new global_class();

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data was received and properly decoded
if ($data === null) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON format received'
    ]);
    exit;
}

// Check if the data is not empty
if (!empty($data)) {
    $insertedCount = 0; // Counter for successful inserts

    // Loop through each subject in the received data
    foreach ($data as $subject) {
        // Basic sanitization
        $subjectCode = htmlspecialchars($subject['subject_code'], ENT_QUOTES, 'UTF-8');
        $subjectName = htmlspecialchars($subject['subject_name'], ENT_QUOTES, 'UTF-8');
        $lab = htmlspecialchars($subject['lab'], ENT_QUOTES, 'UTF-8');
        $lec = htmlspecialchars($subject['lec'], ENT_QUOTES, 'UTF-8');
        $hrs = htmlspecialchars($subject['hrs'], ENT_QUOTES, 'UTF-8');
        $Sem = htmlspecialchars($subject['sem'], ENT_QUOTES, 'UTF-8');
        $yrlvl = htmlspecialchars($subject['year_level'], ENT_QUOTES, 'UTF-8');
        $sy = htmlspecialchars($subject['school_year'], ENT_QUOTES, 'UTF-8');

        // Insert subject data if valid
        if ($db->addSubject($subjectCode, $subjectName, $lab, $lec, $hrs, $Sem, $yrlvl, $sy)) {
            $insertedCount++;
        }
    }

    // Send JSON response
    echo json_encode([
        'status' => 'success',
        'message' => "Data received successfully. $insertedCount subjects inserted.",
        'inserted' => $insertedCount
    ]);

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No valid data received'
    ]);
}
?>
