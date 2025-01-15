<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }













    public function UpdateAccountSetting($teacher_id, $firstName, $middleName, $lastName, $password) {
        // Start building the query
        $query = "UPDATE `tblfacultymember` SET 
            `fname` = '$firstName', `mname` = '$middleName', `lname` = '$lastName'";
    
        if (!empty($password)) {
            $query .= ", `Password` = '$password'";
        }
        $query .= " WHERE `teacher_id` = '$teacher_id'";
    
       
        // Execute the query
        $result = $this->conn->query($query);
    
        // Debugging: Check if the result is correct
        if ($result) {
            echo "Account updated successfully."; // Success message
        } else {
            // Return error with the actual MySQL error
            echo "Error executing the query: " . $this->conn->error;
        }
    }
    










    

    public function fetch_teacher_detail($teacher_id) {
        // Prepare the query with a placeholder for the teacher_id
        $query = $this->conn->prepare("SELECT * 
            FROM `tblfacultymember`
            WHERE teacher_status='1' AND teacher_id = ?");
        
        // Bind the teacher_id parameter to the prepared statement
        $query->bind_param("i", $teacher_id); // "i" is for integer type
        
        // Execute the query
        if ($query->execute()) {
            // Get the result
            $result = $query->get_result();
            return $result;
        } else {
            return false; // Handle the error if the query fails
        }
    }









    public function GetAvailableHours($teacher_id)
    {
        // Step 1: Get the teacher's total weekly hours from tblfacultymember
        $query = $this->conn->prepare("SELECT totalweekly_hrs FROM `tblfacultymember` WHERE `teacher_id` = ?");
        $query->bind_param("s", $teacher_id);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $teacherWeeklyHours = (int)$row['totalweekly_hrs'];
        } else {
            echo "Teacher not found";
            return false;
        }
        $query->close();
    
        // Step 2: Calculate the total hours already scheduled for the teacher
        $query = $this->conn->prepare("SELECT SUM(TIMESTAMPDIFF(HOUR, `sched_start_Hrs`, `sched_end_Hrs`)) AS total_hours 
            FROM `tblschedule` WHERE `sched_teacher_id` = ? AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) ");
        $query->bind_param("s", $teacher_id);
        $query->execute();
        $result = $query->get_result();
    
        $currentScheduledHours = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentScheduledHours = (int)$row['total_hours'];
        }
        $query->close();
    
        // Step 3: Calculate the remaining available hours
        $remainingHours = $teacherWeeklyHours - $currentScheduledHours;
    
        // Step 4: Return the remaining available hours
        return $remainingHours;
    }
    













    public function SetSchedule($teacher_id, $scheduleDay, $scheduleStartTime, $scheduleEndTime)
    {
        // Step 1: Check for schedule overlap (same logic as before)
        $query = $this->conn->prepare("SELECT * FROM `tblschedule` 
            WHERE `sched_teacher_id` = ? AND `sched_day` = ? AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) 
            AND ((`sched_start_Hrs` < ? AND `sched_end_Hrs` > ?) 
            OR (`sched_start_Hrs` < ? AND `sched_end_Hrs` > ?))");
            
        $query->bind_param("ssssss", $teacher_id, $scheduleDay, $scheduleStartTime, $scheduleStartTime, $scheduleEndTime, $scheduleEndTime);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            echo "Schedule Date is Not Available";
            $query->close();
            return false;
        }
    
        // Step 2: Get teacher's current total weekly hours
        $query = $this->conn->prepare("SELECT totalweekly_hrs FROM `tblfacultymember` WHERE `teacher_id` = ?");
        $query->bind_param("s", $teacher_id);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $teacherWeeklyHours = (int)$row['totalweekly_hrs'];
        } else {
            echo "Teacher not found";
            return false;
        }
        $query->close();
    
        // Step 3: Calculate the total hours for the new schedule
        $start = new DateTime($scheduleStartTime);
        $end = new DateTime($scheduleEndTime);
        $interval = $start->diff($end);
        $newScheduleHours = $interval->h + ($interval->i / 60); // Convert to hours
    
        // Step 4: Get the teacher's current total scheduled hours
        $query = $this->conn->prepare("SELECT SUM(TIMESTAMPDIFF(HOUR, `sched_start_Hrs`, `sched_end_Hrs`)) AS total_hours 
            FROM `tblschedule` WHERE `sched_teacher_id` = ? AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) ");
        $query->bind_param("s", $teacher_id);
        $query->execute();
        $result = $query->get_result();
    
        $currentScheduledHours = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentScheduledHours = (int)$row['total_hours'];
        }
        $query->close();
    
        // Step 5: Check if the total weekly hours will be exceeded
        if (($currentScheduledHours + $newScheduleHours) > $teacherWeeklyHours) {
            echo "Exceeds total weekly hours";
            return false;
        }
    
        // Step 6: If no overlap and total hours are within the limit, insert the new schedule
        $query = $this->conn->prepare("INSERT INTO `tblschedule` (`sched_teacher_id`, `sched_day`, `sched_start_Hrs`, `sched_end_Hrs`) 
            VALUES (?, ?, ?, ?)");
        if ($query === false) {
            return false;
        }
        $query->bind_param("ssss", $teacher_id, $scheduleDay, $scheduleStartTime, $scheduleEndTime);
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false;
        }
        $query->close();
    }
    







        public function UpdateSchedule($teacher_id, $scheduleDay, $scheduleStartTime, $scheduleEndTime, $scheduleId)
        {
            
            // Prepare the update query
            $updateQuery = "
                UPDATE `tblschedule`
                SET `sched_start_Hrs` = '$scheduleStartTime', `sched_end_Hrs` = '$scheduleEndTime'
            ";
        
            // Only include `sched_day` if `scheduleDay` is not empty
            if ($scheduleDay !== '' && $scheduleDay !== null) {
                $updateQuery .= ", `sched_day` = '$scheduleDay'";
            }
        
            $updateQuery .= " WHERE `sched_teacher_id` = '$teacher_id' AND `sched_id` = '$scheduleId'";
        
            // Execute the update query
            if ($this->conn->query($updateQuery)) {
                echo "200"; // Success
            } else {
                echo "Error updating schedule";
                return false;
            }
        
            return true;
        }
        



        public function UpdateReq_status($ws_id,$ActionStatus)
        {
            
            // Prepare the update query
            $updateQuery = "
                UPDATE `tblworkschedule`
                SET `ws_ol_request_status` = '$ActionStatus' where ws_id = '$ws_id'
            ";
        
            
            if ($this->conn->query($updateQuery)) {
                echo "200"; // Success
            } else {
                echo "Error updating schedule";
                return false;
            }
        
            return true;
        }
        

        
        

        
        
        
        public function ChooseWeeklyHrs($teacher_id,$weeklyHours)
        {
            
            // Prepare the update query
            $updateQuery = "
                UPDATE `tblfacultymember` SET `totalweekly_hrs`='$weeklyHours' WHERE teacher_id ='$teacher_id'
            ";
        
           
        
            // Execute the update query
            if ($this->conn->query($updateQuery)) {
                echo "200"; // Success
            } else {
                echo "Error updating schedule";
                return false;
            }
        
            return true;
        }
        

        




        public function CheckDayIfAlreadyTaken($teacher_id)
        {
            $takenDays = [];
            $query = $this->conn->prepare("SELECT `sched_day` FROM `tblschedule` 
                WHERE `sched_teacher_id` = ? AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) ");
            $query->bind_param("s", $teacher_id);
            
            // Execute the query
            $query->execute();
            
            // Get the result
            $result = $query->get_result();
            
            // Fetch all the taken days
            while ($row = $result->fetch_assoc()) {
                $takenDays[] = $row['sched_day']; // Add the taken day to the array
            }

            // Close the query
            $query->close();

            return $takenDays; // Return the array of taken days
        }

        

        public function check_account($user_id ) {
            $query = "SELECT * FROM tblfacultymember WHERE teacher_id = $user_id";
            $result = $this->conn->query($query);
    
            $items = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $items[] = $row;
                }
            }
            return $items; 
        }
    




        public function fetch_schedule($teacher_id)
        {
            $query = "SELECT * FROM `tblschedule` WHERE `sched_teacher_id` = $teacher_id AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) ";
            
            $result = $this->conn->query($query); 
            
            if ($result && $result->num_rows > 0) {
                $schedules = $result->fetch_all(MYSQLI_ASSOC);
                return $schedules; // Return array of schedules
            } else {
                return [];
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
            WHERE tblschedule.sched_id = '$sched_id' AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) 
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
            WHERE tblschedule.sched_id = '$sched_id' AND YEAR(tblschedule.sched_date_added) = YEAR(CURDATE()) 
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