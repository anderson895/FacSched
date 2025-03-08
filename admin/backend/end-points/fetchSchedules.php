<?php
// Start output buffering to prevent premature output
ob_start();

include('../class.php');

$db = new global_class();
$teacher_id = $_GET['teacher_id'];

$view_AcademicSchedule = $db->view_AcademicSchedule($teacher_id);
$view_OtherSchedule = $db->view_OtherSchedule($teacher_id);

// Debugging output (write to logs, not the browser)
error_log("Academic Schedule Data: " . print_r($view_AcademicSchedule, true));
error_log("Other Schedule Data: " . print_r($view_OtherSchedule, true));

// Merge both schedules
$schedules = [];

// Combine unique time slots
$time_slots = array_merge(
    $view_AcademicSchedule['time_slots'] ?? [],
    $view_OtherSchedule['time_slots'] ?? []
);
$unique_time_slots = [];

// Ensure uniqueness using the 'start' timestamp as a key
foreach ($time_slots as $slot) {
    $unique_time_slots[$slot['start']] = $slot;
}

// Sort time slots by start timestamp
usort($unique_time_slots, function ($a, $b) {
    return $a['start'] - $b['start'];
});

// Initialize and populate the final schedule array
foreach ($unique_time_slots as $slot) {
    $time = $slot['label'];
    $slot_start_timestamp = $slot['start'];
    $entry = ['time' => $time];

    // Initialize empty slots for each day
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    foreach ($days as $day) {
        $entry[$day] = '';
    }

    // Populate the schedule for each day
    foreach (['academic' => $view_AcademicSchedule, 'other' => $view_OtherSchedule] as $scheduleType => $schedule) {
        if (!isset($schedule['schedule'])) continue;

        foreach ($schedule['schedule'] as $day => $entries) {
            $day = strtolower($day); // Normalize day names

            foreach ($entries as $schedule_entry) {
                if (!isset($schedule_entry['start_time'], $schedule_entry['end_time'])) continue;

                // Convert to integer timestamps for comparison
                $entry_start = (int) $schedule_entry['start_time'];
                $entry_end = (int) $schedule_entry['end_time'];

               // Check if the slot falls within the scheduled time
                if ($slot_start_timestamp >= $entry_start && $slot_start_timestamp < $entry_end) {
                    $details = ($scheduleType === 'academic' && isset($schedule_entry['subject_name']))
                        ? "{$schedule_entry['subject_name']}<br>
                        Section: {$schedule_entry['section']}<br>
                        Year Level: {$schedule_entry['year_level']}<br>
                        Semester: {$schedule_entry['semester']}<br>
                        Room: {$schedule_entry['room']}"
                        : "{$schedule_entry['work']}<br>
                        Description: {$schedule_entry['work_description']}<br>
                        Room: {$schedule_entry['room']}<br>
                        Time: {$schedule_entry['formatted_start_time']} - {$schedule_entry['formatted_end_time']}";

                    // Append details to the respective day with line breaks
                    $entry[$day] .= ($entry[$day] ? "<br><br>" : "") . $details;
                }


            }
        }
    }

    $schedules[] = $entry;
}

// Ensure no previous output and return JSON response
ob_end_clean();
header('Content-Type: application/json');
echo json_encode($schedules);
exit;
