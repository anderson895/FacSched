<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }













    public function statistics() {
        // Define the query to get the counts
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM tblcurriculum WHERE subject_status = '1') AS total_curriculum,
                (SELECT COUNT(*) FROM tblsection WHERE section_status = 1) AS total_section,
                (SELECT COUNT(*) FROM tblfacultymember WHERE teacher_status = '1') AS total_faculty
        ";
        
        // Execute the query using MySQLi
        $result = $this->conn->query($query);
        
        if ($result) {
            // Fetch the result as an associative array
            $data = $result->fetch_assoc();
            
            // Create the response array
            $response = [
                'total_curriculum' => $data['total_curriculum'],
                'total_section' => $data['total_section'],
                'total_faculty' => $data['total_faculty']
            ];
            
            // Return the response array
            return $response;
        } else {
            return false; // If the query fails
        }
    }
    
    




    public function formatOrdinal($number) {
        $suffix = 'th Sem';
    
        // Special cases for 1, 2, and 3 (but not 11, 12, 13)
        if ($number % 100 < 11 || $number % 100 > 13) {
            switch ($number % 10) {
                case 1: $suffix = 'st Sem'; break;
                case 2: $suffix = 'nd Sem'; break;
                case 3: $suffix = 'rd Sem'; break;
            }
        }
    
        return $number . $suffix;
    }
    
 
    










    public function getTeacherInfo($teacher_id){
        $query = "
            SELECT *
            FROM tblfacultymember as teacher
            WHERE teacher.teacher_id  = '$teacher_id'
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            if ($result->num_rows > 0) {
                $schedules = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $schedules;
            } else {
                $result->free();
                return [];
            }
        } else {
            return false;
        }

    }


    public function view_OtherSchedule($teacher_id){
        // Access the connection from the parent class
        $conn = $this->conn;
    
        // Fetch earliest and latest time for the teacher's schedule
        $sql_time = "
            SELECT 
                MIN(tws.ows_subtStartTimeAssign) AS min_start_time, 
                MAX(tws.ows_subtEndTimeAssign) AS max_end_time
            FROM tblotherworkschedule tws
            JOIN tblschedule ts ON ts.sched_id = tws.ows_schedule_id
            WHERE ts.sched_teacher_id = $teacher_id
        ";
        $result_time = $conn->query($sql_time);
    
        if ($result_time && $result_time->num_rows > 0) {
            $row_time = $result_time->fetch_assoc();
            $min_start_time = strtotime($row_time['min_start_time']);
            $max_end_time = strtotime($row_time['max_end_time']);
        } else {
            die("No schedule found for the specified teacher.");
        }
    
        // Generate hourly time slots (based on start and end times)
        $time_slots = [];
        $current_time = $min_start_time;
    
        while ($current_time < $max_end_time) {
            $start_time = date("g:i A", $current_time); // Human-readable start time
            $end_time = date("g:i A", $current_time + 3600); // Human-readable end time
            $time_slots[] = ['start' => $current_time, 'label' => "$start_time - $end_time"];
            $current_time += 3600;
        }
    
        // Fetch the schedule details for the teacher without the subject and section part
        $sql_schedule = "
        SELECT 
            ts.sched_day, 
            tws.ows_subtStartTimeAssign, 
            tws.ows_subtEndTimeAssign, 
            tws.ows_typeOfWork, 
            tws.ows_location AS room,
            tws.ows_work_description  -- Include the work description here
        FROM tblschedule ts
        JOIN tblotherworkschedule tws ON ts.sched_id = tws.ows_schedule_id
        WHERE ts.sched_teacher_id = $teacher_id
        ORDER BY 
            FIELD(ts.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
            tws.ows_subtStartTimeAssign
        ";
    
        $result_schedule = $conn->query($sql_schedule);
    
        if (!$result_schedule) {
            die("Error fetching schedule: " . $conn->error);
        }
    
        // Organize schedule data by day and time
        $schedule = [];
        while ($row_schedule = $result_schedule->fetch_assoc()) {
            $day = ucfirst($row_schedule['sched_day']);
            $start_time = strtotime($row_schedule['ows_subtStartTimeAssign']);
            $end_time = strtotime($row_schedule['ows_subtEndTimeAssign']);
            
            // Format the start and end times into human-readable format
            $formatted_start_time = date('g:i A', $start_time);  // Format: hh:mm AM/PM
            $formatted_end_time = date('g:i A', $end_time);      // Format: hh:mm AM/PM
            
            $schedule[$day][] = [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'work' => $row_schedule['ows_typeOfWork'],
                'room' => $row_schedule['room'],
                'work_description' => $row_schedule['ows_work_description'],
                'formatted_start_time' => $formatted_start_time,
                'formatted_end_time' => $formatted_end_time
            ];
        }
    
        // Return the schedule and time slots
        return [
            'schedule' => $schedule,
            'time_slots' => $time_slots
        ]; // This will be used in the front-end for rendering the schedule.
    }
    
    
    



    public function view_AcademicSchedule($teacher_id)
    {
    // Access the connection from the parent class
    $conn = $this->conn;

    // Fetch earliest and latest time for the teacher's schedule
    $sql_time = "
        SELECT 
            MIN(tws.ws_subtStartTimeAssign) AS min_start_time, 
            MAX(tws.ws_subtEndTimeAssign) AS max_end_time
        FROM tblworkschedule tws
        JOIN tblschedule ts ON ts.sched_id = tws.ws_schedule_id
        WHERE ts.sched_teacher_id = $teacher_id 
        AND (ws_ol_request_status IS NULL OR ws_ol_request_status = 'accept')
    ";
    $result_time = $conn->query($sql_time);

    if ($result_time && $result_time->num_rows > 0) {
        $row_time = $result_time->fetch_assoc();
        $min_start_time = strtotime($row_time['min_start_time']);
        $max_end_time = strtotime($row_time['max_end_time']);
    } else {
        die("No schedule found for the specified teacher.");
    }
    // Generate hourly time slots
    $time_slots = [];
    $current_time = $min_start_time;

    while ($current_time < $max_end_time) {
        $start_time = date("g:i A", $current_time);
        $end_time = date("g:i A", $current_time + 3600);
        $time_slots[] = ['start' => $current_time, 'label' => "$start_time - $end_time"];
        $current_time += 3600;
    }

    // Fetch the schedule details for the teacher
    $sql_schedule = "
        SELECT 
            ts.sched_day, 
            tws.ws_subtStartTimeAssign, 
            tws.ws_subtEndTimeAssign, 
            tws.ws_typeOfWork, 
            tws.ws_status, 
            tws.ws_roomCode, 
            tc.subject_name, 
            tc.semester, 
            CONCAT(tsc.course, ' ', tsc.section) AS section
        FROM tblschedule ts
        JOIN tblworkschedule tws ON ts.sched_id = tws.ws_schedule_id
        JOIN tblcurriculum tc ON tc.subject_id = tws.ws_CurriculumID
        JOIN tblsection tsc ON tsc.sectionId = tws.ws_sectionId
        WHERE ts.sched_teacher_id = $teacher_id
        ORDER BY 
            FIELD(ts.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
            tws.ws_subtStartTimeAssign
    ";
    $result_schedule = $conn->query($sql_schedule);

    if (!$result_schedule) {
        die("Error fetching schedule: " . $conn->error);
    }

    // Organize schedule data by day and time
    $schedule = [];
    while ($row_schedule = $result_schedule->fetch_assoc()) {
        $day = ucfirst($row_schedule['sched_day']);
        $start_time = strtotime($row_schedule['ws_subtStartTimeAssign']);
        $end_time = strtotime($row_schedule['ws_subtEndTimeAssign']);
        $schedule[$day][] = [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'work' => $row_schedule['ws_typeOfWork'],
            'room' => $row_schedule['ws_roomCode'],
            'subject_name' => $row_schedule['subject_name'],
            'section' => $row_schedule['section'],
            'ws_status' => $row_schedule['ws_status'],
            'semester' => $row_schedule['semester']
        ];
    }

    // Return the schedule and time slots
    return [
        'schedule' => $schedule,
        'time_slots' => $time_slots
    ]; // This will be used in the front-end for rendering the schedule.
}




    public function check_account($user_id ) {
        $query = "SELECT * FROM admin WHERE admin_id = $user_id";
        $result = $this->conn->query($query);

        $items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items; 
    }


    public function addSubject($subjectCode, $subjectName, $lab, $lec, $hrs, $Sem, $yrlvl) {
        // Prepare the SQL query
        $query = $this->conn->prepare(
            "INSERT INTO TblCurriculum (subject_code, subject_name, lab_num, lec_num, hours, semester, designated_year_level) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        if ($query === false) {
            return false;
        }
        $query->bind_param("ssssssi", $subjectCode, $subjectName, $lab, $lec, $hrs, $Sem, $yrlvl);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }
    

    public function addTeacher($teacherCode, $fname, $mname, $lname, $designation, $password) {


        $totalweekly_hrs=null;

        if($designation=='Part Time'){
                $totalweekly_hrs = "12";
        }

        // First, check if the teacher code already exists
        $checkQuery = $this->conn->prepare("SELECT COUNT(*) FROM tblfacultymember WHERE ID_code = ?");
        if ($checkQuery === false) {
            return false; // Query preparation failed
        }
    
        $checkQuery->bind_param("s", $teacherCode);
        $checkQuery->execute();
        $checkQuery->bind_result($count);
        $checkQuery->fetch();
        $checkQuery->close();
    
        // If the teacher code exists, return an error
        if ($count > 0) {
            echo "Teacher code already exists."; // Or return an error message
            return false;
        }
    
        // Prepare the insert query
        $query = $this->conn->prepare(
            "INSERT INTO tblfacultymember (ID_code, fname, mname, lname, designation,totalweekly_hrs, Password) 
            VALUES (?, ?, ?, ?, ?, ?,?)"
        );
        if ($query === false) {
            return false; // Query preparation failed
        }
    
        // Bind the parameters and execute the insert query
        $query->bind_param("sssssss", $teacherCode, $fname, $mname, $lname, $designation,$totalweekly_hrs, $password);
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false; // Query execution failed
        }
    
        $query->close();
    }
    
    
   






        public function addSection($course, $year_level, $section)
    {
        $query = $this->conn->prepare("INSERT INTO `tblsection` (`course`, `year_level`, `section`) VALUES (?, ?, ?)");
        if ($query === false) {
            return false; 
        }
        $query->bind_param("sss", $course, $year_level, $section);
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }



















    public function UpdateSection($course, $year_level, $section, $sectionId)
    {
        $query = $this->conn->prepare("UPDATE `tblsection` SET `course` = ?, `year_level` = ?, `section` = ? WHERE `sectionId` = ?");
    
        if ($query === false) {
            return false;
        }
    
        $query->bind_param("sssi", $course, $year_level, $section, $sectionId);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }


    
    public function updateTeacher($teacher_id, $teacherCode, $fname, $mname, $lname, $designation, $password)
    {
        // Base SQL query
        $sql = "
            UPDATE `tblfacultymember` 
            SET `ID_code` = ?, `fname` = ?, `mname` = ?, `lname` = ?, `designation` = ?
        ";
    
        // Add the `Password` field to the query only if $password is not empty
        $params = [$teacherCode, $fname, $mname, $lname, $designation];
        $types = "sssss";
    
        if (!empty($password)) {
            $sql .= ", `Password` = ?";
            $params[] = $password;
            $types .= "s";
        }
    
        $sql .= " WHERE `teacher_id` = ?";
        $params[] = $teacher_id;
        $types .= "i";
    
        // Prepare the query
        $query = $this->conn->prepare($sql);
        if ($query === false) {
            return false;
        }
    
        // Bind the parameters dynamically
        $query->bind_param($types, ...$params);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
            $query->close();
            return true;
        }
    }
    
    
    





    public function updateSubject($subjectId, $subjectCode, $subject_name, $lab_num, $lec_num, $hours, $semester, $designated_year_level)
    {
        // Prepare the SQL update query
        $query = $this->conn->prepare("UPDATE `tblcurriculum` 
                                        SET `subject_code` = ?, 
                                            `subject_name` = ?, 
                                            `lab_num` = ?, 
                                            `lec_num` = ?, 
                                            `hours` = ?, 
                                            `semester` = ?, 
                                            `designated_year_level` = ?
                                        WHERE `subject_id` = ?");
        
        if ($query === false) {
            return false;
        }
    
        // Bind the parameters to the prepared statement
        $query->bind_param("sssssssi", $subjectCode, $subject_name, $lab_num, $lec_num, $hours, $semester, $designated_year_level, $subjectId);
        
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
    
        $query->close();
    }
    

    public function deleteSection($sectionId)
    {
        $query = $this->conn->prepare("UPDATE `tblsection` SET `section_status` = '0' WHERE `sectionId` = ?");
    
        if ($query === false) {
            return false;
        }
    
        $query->bind_param("i", $sectionId);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }




    public function deleteTeacher($teacher_id)
    {
        $query = $this->conn->prepare("UPDATE `tblfacultymember` SET `teacher_status` = '0' WHERE `teacher_id` = ?");
    
        if ($query === false) {
            return false;
        }
    
        $query->bind_param("i", $teacher_id);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }


    public function deleteSubject($subject_id)
    {
        $query = $this->conn->prepare("UPDATE `tblcurriculum` SET `subject_status` = '0' WHERE `subject_id` = ?");
    
        if ($query === false) {
            return false;
        }
    
        $query->bind_param("i", $subject_id);
    
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }
    
    
    public function fetch_all_Section()
    {
        $query = $this->conn->prepare("SELECT * 
        FROM `tblsection`
        where section_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_Subject()
    {
        $query = $this->conn->prepare("SELECT * 
        FROM `TblCurriculum`
        where subject_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetchAllteachers()
    {
        $query = $this->conn->prepare("SELECT * 
        FROM `tblfacultymember`
        where teacher_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }





    
    public function AssignSched($sched_id, $subject_id, $sectionId, $roomCode, $typeOfWorks, $subtStartTimeAssign, $subtEndTimeAssign)
{
    // Step 1: Check for conflicts in the same room and day
    $conflictQuery = "
        SELECT 1
        FROM tblworkschedule ws
        JOIN tblschedule ts ON ts.sched_id = ws.ws_schedule_id
        WHERE (
            -- Conflict for the same room
            (ws.ws_roomCode = '$roomCode' 
             AND ts.sched_day = (SELECT sched_day FROM tblschedule WHERE sched_id = '$sched_id') 
             AND (
                 ws.ws_subtStartTimeAssign < '$subtEndTimeAssign' AND ws.ws_subtEndTimeAssign > '$subtStartTimeAssign'
             )
            ) OR
            -- Conflict for the same ws_schedule_id, different room
            (ws.ws_roomCode != '$roomCode' 
             AND ws.ws_schedule_id = '$sched_id'
             AND (
                 ws.ws_subtStartTimeAssign < '$subtEndTimeAssign' AND ws.ws_subtEndTimeAssign > '$subtStartTimeAssign'
             )
            )
        )
    ";
    
    $conflictResult = $this->conn->query($conflictQuery);
    
    if ($conflictResult->num_rows > 0) {
        echo "Conflict detected: The time range overlaps with an existing schedule."; // Error
        return false;
    }

    // Step 2: Check if the subject is already assigned on the same day
    $subjectConflictQuery = "
        SELECT 1
        FROM tblworkschedule ws
        JOIN tblschedule ts ON ts.sched_id = ws.ws_schedule_id
        WHERE ts.sched_day = (SELECT sched_day FROM tblschedule WHERE sched_id = '$sched_id')
        AND ws.ws_CurriculumID = '$subject_id' AND ws.ws_sectionId = '$sectionId'
    ";

    $subjectConflictResult = $this->conn->query($subjectConflictQuery);

    if ($subjectConflictResult->num_rows > 0) {
        echo "Conflict detected: The subject is already scheduled on the same day."; // Error
        return false;
    }

    // Step 3: Fetch schedule details and calculate remaining minutes
    $scheduleQuery = "
        SELECT 
            ts.sched_day, ts.sched_start_Hrs, ts.sched_end_Hrs,
            TIMESTAMPDIFF(MINUTE, ts.sched_start_Hrs, ts.sched_end_Hrs) AS total_minutes_per_day,
            COALESCE(
                (SELECT SUM(TIMESTAMPDIFF(MINUTE, ws.ws_subtStartTimeAssign, ws.ws_subtEndTimeAssign))
                 FROM tblworkschedule ws
                 WHERE ws.ws_schedule_id = ts.sched_id
                 GROUP BY ws.ws_schedule_id), 0
            ) AS total_minutes_workschedule
        FROM tblschedule ts
        WHERE ts.sched_id = '$sched_id'
    ";

    $scheduleResult = $this->conn->query($scheduleQuery);

    if ($scheduleResult->num_rows > 0) {
        $schedule = $scheduleResult->fetch_assoc();

        $sched_day = $schedule['sched_day'];
        $sched_start_Hrs = $schedule['sched_start_Hrs'];
        $sched_end_Hrs = $schedule['sched_end_Hrs'];
        $total_minutes_per_day = $schedule['total_minutes_per_day'];
        $total_minutes_workschedule = $schedule['total_minutes_workschedule'];

        $remaining_minutes = $total_minutes_per_day - $total_minutes_workschedule;
        $new_work_minutes = (strtotime($subtEndTimeAssign) - strtotime($subtStartTimeAssign)) / 60;

        // Step 4: Validate the time range and remaining minutes
        if (strtotime($subtStartTimeAssign) >= strtotime($sched_start_Hrs) && strtotime($subtEndTimeAssign) <= strtotime($sched_end_Hrs)) {
            if ($new_work_minutes <= $remaining_minutes) {
                // Insert the new work schedule
                $insertQuery = "
                    INSERT INTO tblworkschedule (ws_schedule_id, ws_sectionId, ws_roomCode, ws_CurriculumID, ws_subtStartTimeAssign, ws_subtEndTimeAssign, ws_typeOfWork)
                    VALUES ('$sched_id', '$sectionId', '$roomCode', '$subject_id', '$subtStartTimeAssign', '$subtEndTimeAssign', '$typeOfWorks')
                ";
                if ($this->conn->query($insertQuery)) {
                    echo "200"; // Success
                } else {
                    echo "Failed to assign schedule."; // Error
                    return false;
                }
            } else {
                echo "Insufficient available time for this schedule on $sched_day."; // Error
                return false;
            }
        } else {
            echo "Time range is outside the allowed schedule for $sched_day."; // Error
            return false;
        }
    } else {
        echo "Schedule with ID $sched_id not found."; // Error
        return false;
    }
}

    
    

















    public function AssignSched_OverLoad($sched_id, $subject_id, $sectionId, $roomCode, $typeOfWorks, $subtStartTimeAssign, $subtEndTimeAssign, $overload_work)
    {
        // Step 1: Check for conflicts
        $conflictQuery = "
            SELECT 1 
            FROM tblworkschedule ws
            WHERE 
                ws.ws_schedule_id = '$sched_id'
                AND (
                    -- Conflict in the same room
                    (ws.ws_roomCode = '$roomCode' 
                     AND (
                         ws.ws_subtStartTimeAssign < '$subtEndTimeAssign' AND ws.ws_subtEndTimeAssign > '$subtStartTimeAssign'
                     )
                    )
                    OR
                    -- Conflict in a different room for the same schedule ID
                    (ws.ws_roomCode != '$roomCode'
                     AND (
                         ws.ws_subtStartTimeAssign < '$subtEndTimeAssign' AND ws.ws_subtEndTimeAssign > '$subtStartTimeAssign'
                     )
                    )
                )
        ";
        $conflictResult = $this->conn->query($conflictQuery);
    
        if ($conflictResult->num_rows > 0) {
            echo "Conflict with an existing schedule."; // Error
            return false;
        }
    
        // Step 2: Fetch schedule details and calculate remaining minutes
        $scheduleQuery = "
            SELECT 
                sched_start_Hrs, sched_end_Hrs,
                TIMESTAMPDIFF(MINUTE, sched_start_Hrs, sched_end_Hrs) AS total_minutes_per_day,
                COALESCE(
                    (SELECT SUM(TIMESTAMPDIFF(MINUTE, ws.ws_subtStartTimeAssign, ws.ws_subtEndTimeAssign))
                     FROM tblworkschedule ws
                     WHERE ws.ws_schedule_id = tblschedule.sched_id
                     GROUP BY ws.ws_schedule_id), 0
                ) AS total_minutes_workschedule
            FROM tblschedule
            WHERE sched_id = '$sched_id'
        ";
        $scheduleResult = $this->conn->query($scheduleQuery);
    
        if ($scheduleResult->num_rows > 0) {
            $schedule = $scheduleResult->fetch_assoc();
    
            $sched_start_Hrs = $schedule['sched_start_Hrs'];
            $sched_end_Hrs = $schedule['sched_end_Hrs'];
            $total_minutes_per_day = $schedule['total_minutes_per_day'];
            $total_minutes_workschedule = $schedule['total_minutes_workschedule'];
    
            // Step 3: Calculate remaining minutes and the new work's duration
            $remaining_minutes = $total_minutes_per_day - $total_minutes_workschedule;
            $new_work_minutes = (strtotime($subtEndTimeAssign) - strtotime($subtStartTimeAssign)) / 60;
    
            // Validate time range and remaining minutes
            // if (strtotime($subtStartTimeAssign) >= strtotime($sched_start_Hrs) && strtotime($subtEndTimeAssign) <= strtotime($sched_end_Hrs)) {
            //     if ($new_work_minutes <= $remaining_minutes) {
                    // Step 4: Insert the new overload work schedule
                    $status = 'pending';
                    $insertQuery = "
                        INSERT INTO tblworkschedule 
                        (ws_schedule_id, ws_sectionId, ws_roomCode, ws_CurriculumID, ws_subtStartTimeAssign, ws_subtEndTimeAssign, ws_typeOfWork, ws_ol_request_status, ws_status) 
                        VALUES ('$sched_id', '$sectionId', '$roomCode', '$subject_id', '$subtStartTimeAssign', '$subtEndTimeAssign', '$typeOfWorks', '$status', '$overload_work')
                    ";
                    if ($this->conn->query($insertQuery)) {
                        echo "200"; // Success
                    } else {
                        echo "Error: " . $this->conn->error; // Log the error
                        return false;
                    }
            //     } else {
            //         echo "Work schedule exceeds available time for this day."; // Error
            //         return false;
            //     }
            // } else {
            //     echo "Work schedule is out of the allowed class time range."; // Error
            //     return false;
            // }
        } else {
            echo "Schedule not found."; // Error: No matching schedule found
            return false;
        }
    }
    

    

    

    public function AssignSchedOthers($sched_id,$location,$work_description,$typeOfWorks,$subtStartTimeAssign,$subtEndTimeAssign)
    {

       

        // Step 1: Fetch the total scheduled hours for the day and the schedule's start and end hours
        $query = $this->conn->prepare("
            SELECT 
                tblschedule.sched_start_Hrs,
                tblschedule.sched_end_Hrs,
                IFNULL(TIMESTAMPDIFF(MINUTE, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs), 0) AS total_minutes_per_day,
                IFNULL(
                    (SELECT SUM(TIMESTAMPDIFF(MINUTE, ows_subtStartTimeAssign, ows_subtEndTimeAssign))
                     FROM tblotherworkschedule w
                     WHERE w.ows_schedule_id = tblschedule.sched_id
                     GROUP BY w.ows_schedule_id), 0
                ) AS total_minutes_workschedule
            FROM tblschedule
            WHERE sched_id = ?
        ");
        $query->bind_param("s", $sched_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $schedule = $result->fetch_assoc();
                
                $sched_start_Hrs = $schedule['sched_start_Hrs'];
                $sched_end_Hrs = $schedule['sched_end_Hrs'];
                $total_minutes_per_day = $schedule['total_minutes_per_day'];
                $total_minutes_workschedule = $schedule['total_minutes_workschedule'];
                
                // Step 2: Calculate remaining minutes available for work schedule
                $remaining_minutes = $total_minutes_per_day - $total_minutes_workschedule;
                
                // Step 3: Calculate the minutes for the new assigned work
                $start_timestamp = strtotime($subtStartTimeAssign);
                $end_timestamp = strtotime($subtEndTimeAssign);
                $new_work_minutes = abs($end_timestamp - $start_timestamp) / 60; // Convert to minutes
    
                // Step 4: Check if the new work schedule fits within the available time range
                 if (strtotime($subtStartTimeAssign) >= strtotime($sched_start_Hrs) && strtotime($subtEndTimeAssign) <= strtotime($sched_end_Hrs)) {
                    // Step 5: Validate if new work schedule does not exceed the remaining time
                    if ($new_work_minutes <= $remaining_minutes) {
                        // Proceed with the assignment if within limits
                        $query = $this->conn->prepare("INSERT INTO `tblotherworkschedule` (`ows_schedule_id`, `ows_location`, `ows_work_description`, `ows_subtStartTimeAssign`, `ows_subtEndTimeAssign`, `ows_typeOfWork`) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
                        $query->bind_param("ssssss", $sched_id, $location, $work_description, $subtStartTimeAssign, $subtEndTimeAssign, $typeOfWorks);
    
                        if ($query->execute()) {
                            echo "200"; // Success
                        } else {
                            return false;
                        }
                    } else {
                        echo "Work schedule exceeds available time for this day.";//Error:
                        return false;
                    }
                } else {
                    echo "Work schedule is out of the allowed class time range.";//Error:
                    return false;
                }
            } else {
                echo "Schedule not found.";//Error:
                return false;
            }
            $query->close();
        } else {
            echo "Query execution failed."; //Error: 
            return false;
        }
    }
    
    



    public function fetch_schedule()
    {
        $query = $this->conn->prepare("
           SELECT
    tblschedule.sched_teacher_id, 
    IFNULL(GROUP_CONCAT(tblschedule.sched_day ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')), NULL) AS days,
    IFNULL(GROUP_CONCAT(CONCAT(tblschedule.sched_id, ':', tblschedule.sched_day) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')), NULL) AS sched_ids_per_day,
    IFNULL(GROUP_CONCAT(CONCAT(tblschedule.sched_start_Hrs, ' - ', tblschedule.sched_end_Hrs) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')), NULL) AS schedule_times,

    -- Calculate total hours and minutes per day
    IFNULL(
        GROUP_CONCAT(
            TIMESTAMPDIFF(MINUTE, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ), 
        NULL
    ) AS total_minutes_per_day,

    -- Calculate total hours per day from minutes, rounding to hours
    IFNULL(
        GROUP_CONCAT(
            FLOOR(TIMESTAMPDIFF(MINUTE, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs) / 60) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ), 
        NULL
    ) AS total_hours_per_day,
    
    -- Teacher name
    CONCAT(tblfacultymember.fname, ' ', tblfacultymember.mname, ' ', tblfacultymember.lname) AS teacher_name,

    -- Summing up total work schedule hours for the same ws_schedule_id, including minutes (tblworkschedule + tblotherworkschedule)
    IFNULL(
        GROUP_CONCAT(
            IFNULL(
                (SELECT 
                    SUM(TIMESTAMPDIFF(MINUTE, ws_subtStartTimeAssign, ws_subtEndTimeAssign))
                 FROM tblworkschedule w
                 WHERE w.ws_schedule_id = tblschedule.sched_id AND w.ws_status='regular_work'
                 GROUP BY w.ws_schedule_id), 0
            ) 
            +
            IFNULL(
                (SELECT 
                    SUM(TIMESTAMPDIFF(MINUTE, ows_subtStartTimeAssign, ows_subtEndTimeAssign))
                 FROM tblotherworkschedule o
                 WHERE o.ows_schedule_id = tblschedule.sched_id
                 GROUP BY o.ows_schedule_id), 0
            )
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ),
        '0'  -- Default to 0 if there are no entries in tblworkschedule or tblotherworkschedule
    ) AS total_minutes_workschedule,

    -- Calculate total off-campus work time (in minutes) for each day
    IFNULL(
        GROUP_CONCAT(
            IFNULL(
                (SELECT 
                    SUM(TIMESTAMPDIFF(MINUTE, ows_subtStartTimeAssign, ows_subtEndTimeAssign))
                 FROM tblotherworkschedule o
                 WHERE o.ows_schedule_id = tblschedule.sched_id AND o.ows_typeOfWork = 'off campus work'
                 GROUP BY o.ows_schedule_id), 0
            ) 
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ),
        '0'  -- Default to 0 if there are no off-campus work entries
    ) AS total_offcampus_work_time,

    -- Calculate total admin work time (in minutes) for each day
    IFNULL(
        GROUP_CONCAT(
            IFNULL(
                (SELECT 
                    SUM(TIMESTAMPDIFF(MINUTE, ows_subtStartTimeAssign, ows_subtEndTimeAssign))
                 FROM tblotherworkschedule o
                 WHERE o.ows_schedule_id = tblschedule.sched_id AND o.ows_typeOfWork = 'admin work'
                 GROUP BY o.ows_schedule_id), 0
            ) 
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ),
        '0'  -- Default to 0 if there are no admin work entries
    ) AS total_admin_work_time,

    -- Calculate remaining minutes per day by subtracting total work schedule time (tblworkschedule + tblotherworkschedule) from total scheduled time
    IFNULL(
        GROUP_CONCAT(
            (TIMESTAMPDIFF(MINUTE, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs) - 
            (
                COALESCE(
                    (SELECT SUM(TIMESTAMPDIFF(MINUTE, ws_subtStartTimeAssign, ws_subtEndTimeAssign))
                     FROM tblworkschedule w 
                     WHERE w.ws_schedule_id = tblschedule.sched_id AND w.ws_status='regular_work'
                     GROUP BY w.ws_schedule_id), 0
                ) 
                +
                COALESCE(
                    (SELECT SUM(TIMESTAMPDIFF(MINUTE, ows_subtStartTimeAssign, ows_subtEndTimeAssign))
                     FROM tblotherworkschedule o
                     WHERE o.ows_schedule_id = tblschedule.sched_id
                     GROUP BY o.ows_schedule_id), 0
                )
            )) / 60  -- Convert remaining minutes to hours
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
        ),
        NULL
    ) AS remaining_hours_per_day
FROM tblschedule
LEFT JOIN tblfacultymember ON tblschedule.sched_teacher_id = tblfacultymember.teacher_id
WHERE tblfacultymember.teacher_status = 1
GROUP BY tblschedule.sched_teacher_id;



        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
    
            if ($result->num_rows > 0) {
                $schedules = $result->fetch_all(MYSQLI_ASSOC);
    
                // Calculate total hours per day for each schedule
                foreach ($schedules as &$schedule) {
                    $days = explode(',', $schedule['days']); // Days as an array
                    $times = explode(',', $schedule['schedule_times']); // Times as an array
                    $sched_ids_per_day = explode(',', $schedule['sched_ids_per_day']); // Schedule IDs as an array
    
                    $total_hours_per_day = []; // Initialize array to store total hours for each day
    
                    foreach ($days as $index => $day) {
                        // Split the schedule times (start and end)
                        $time_range = explode('-', $times[$index]);
                        $start_time = $time_range[0];
                        $end_time = $time_range[1];
    
                        // Calculate total hours for this schedule
                        $start_timestamp = strtotime($start_time);
                        $end_timestamp = strtotime($end_time);
                        $total_hours = round(abs($end_timestamp - $start_timestamp) / 3600, 2); // Total hours
    
                        // Add the total hours to the corresponding day in the array
                        if (!isset($total_hours_per_day[$day])) {
                            $total_hours_per_day[$day] = 0;
                        }
                        $total_hours_per_day[$day] += $total_hours;
                    }
    
                    // Add total_hours_per_day to the schedule data
                    $schedule['total_hours_per_day'] = $total_hours_per_day;
                }
    
                $query->close();
                return $schedules;
            } else {
                $query->close();
                return [];
            }
        } else {
            $query->close();
            return false;
        }
    }
    




    public function fetch_workschedule($sched_id)
    {
        $query = "
            SELECT *
            FROM tblschedule
            LEFT JOIN tblworkschedule ON tblschedule.sched_id = tblworkschedule.ws_schedule_id
            LEFT JOIN tblsection ON tblsection.sectionId = tblworkschedule.ws_sectionId
            LEFT JOIN tblcurriculum ON tblcurriculum.subject_id = tblworkschedule.ws_CurriculumID
            WHERE tblschedule.sched_id = '$sched_id'
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            if ($result->num_rows > 0) {
                $schedules = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $schedules;
            } else {
                $result->free();
                return [];
            }
        } else {
            return false;
        }
    }




    public function fetch_workscheduleOther($sched_id)
    {
        $query = "
            SELECT *
            FROM tblschedule
            LEFT JOIN tblotherworkschedule ON tblschedule.sched_id = tblotherworkschedule.ows_schedule_id
            WHERE tblschedule.sched_id = '$sched_id'
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            if ($result->num_rows > 0) {
                $schedules = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $schedules;
            } else {
                $result->free();
                return [];
            }
        } else {
            return false;
        }
    }


    

    public function DeleteWorkSchedule($ws_id) {
        $query = $this->conn->prepare("DELETE FROM `tblworkschedule` WHERE `ws_id` = ?");
        if ($query === false) {
            return false;
        }

        $query->bind_param("i", $ws_id);
        
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }



    public function DeleteWorkScheduleOther($ows_id) {

        $query = $this->conn->prepare("DELETE FROM `tblotherworkschedule` WHERE `ows_id` = ?");
        if ($query === false) {
            return false;
        }

        $query->bind_param("i", $ows_id);
        
        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }
    
    
    


}