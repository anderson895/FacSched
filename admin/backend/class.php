<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
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












    public function AssignSched($sched_id, $subject_id,$sectionId,$roomCode,$typeOfWorks,$subtStartTimeAssign,$subtEndTimeAssign)
    {
        $query = $this->conn->prepare("INSERT INTO `tblworkschedule` (`ws_schedule_id`,`ws_sectionId`, `ws_roomCode`,`ws_CurriculumID`, `ws_subtStartTimeAssign`,ws_subtEndTimeAssign,`ws_typeOfWork`) VALUES (?,?,?, ?, ?,?,?)");
        if ($query === false) {
            return false; 
        }
        $query->bind_param("sssssss", $sched_id,$sectionId,$roomCode,$subject_id,$subtStartTimeAssign,$subtEndTimeAssign,$typeOfWorks);
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




    public function fetch_schedule()
    {
        $query = $this->conn->prepare("
               SELECT
    tblschedule.sched_teacher_id, 
    IFNULL(GROUP_CONCAT(tblschedule.sched_day ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')), NULL) AS days,
    IFNULL(GROUP_CONCAT(CONCAT(tblschedule.sched_id, ':', tblschedule.sched_day) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')), NULL) AS sched_ids_per_day,
    IFNULL(GROUP_CONCAT(CONCAT(tblschedule.sched_start_Hrs, ' - ', tblschedule.sched_end_Hrs) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')), NULL) AS schedule_times,
    IFNULL(GROUP_CONCAT(TIMESTAMPDIFF(HOUR, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs) ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')), NULL) AS total_hours_per_day,
    CONCAT(tblfacultymember.fname, ' ', tblfacultymember.mname, ' ', tblfacultymember.lname) AS teacher_name,

    -- Summing up total work schedule hours for the same ws_schedule_id
    IFNULL(
        GROUP_CONCAT(
            IFNULL(
                (SELECT SUM(TIMESTAMPDIFF(HOUR, ws_subtStartTimeAssign, ws_subtEndTimeAssign))
                 FROM tblworkschedule w
                 WHERE w.ws_schedule_id = tblschedule.sched_id
                 GROUP BY w.ws_schedule_id), 0
            )
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')
        ),
        '0'  -- Default to 0 if there are no entries in tblworkschedule
    ) AS total_hours_workschedule,

    -- Subtract total work schedule hours from total hours per day
    IFNULL(
        GROUP_CONCAT(
            TIMESTAMPDIFF(HOUR, tblschedule.sched_start_Hrs, tblschedule.sched_end_Hrs) - 
            COALESCE(
                (SELECT SUM(TIMESTAMPDIFF(HOUR, ws_subtStartTimeAssign, ws_subtEndTimeAssign))
                 FROM tblworkschedule w
                 WHERE w.ws_schedule_id = tblschedule.sched_id
                 GROUP BY w.ws_schedule_id), 0
            )
            ORDER BY FIELD(tblschedule.sched_day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday')
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
    
    


}