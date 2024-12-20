<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
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



        public function SetSchedule($teacher_id, $scheduleDay, $scheduleStartTime, $scheduleEndTime)
        {
            $query = $this->conn->prepare("SELECT * FROM `tblschedule` 
                WHERE `sched_teacher_id` = ? AND `sched_day` = ? 
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
            // If no overlap, proceed with inserting the new schedule
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
            // Check for overlapping schedules
            if ($scheduleDay !== '' && $scheduleDay !== null) {
                // Prepare query to check for overlapping schedules
                $query = "
                    SELECT * FROM `tblschedule`
                    WHERE `sched_teacher_id` = '$teacher_id' 
                    AND `sched_day` = '$scheduleDay' 
                    AND `sched_id` != '$scheduleId' 
                    AND (
                        (`sched_start_Hrs` < '$scheduleStartTime' AND `sched_end_Hrs` > '$scheduleStartTime') 
                        OR (`sched_start_Hrs` < '$scheduleEndTime' AND `sched_end_Hrs` > '$scheduleEndTime')
                    )
                ";
            } else {
                // Prepare query to check for overlapping schedules when no `scheduleDay` is provided
                $query = "
                    SELECT * FROM `tblschedule`
                    WHERE `sched_teacher_id` = '$teacher_id' 
                    AND `sched_id` != '$scheduleId' 
                    AND (
                        (`sched_start_Hrs` < '$scheduleStartTime' AND `sched_end_Hrs` > '$scheduleStartTime') 
                        OR (`sched_start_Hrs` < '$scheduleEndTime' AND `sched_end_Hrs` > '$scheduleEndTime')
                    )
                ";
            }
        
            // Execute the query
            $result = $this->conn->query($query);
            
            // Check if any overlapping schedule exists
            if ($result->num_rows > 0) {
                echo "Schedule Date is Not Available"; // Overlap detected
                return false;
            }
        
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
        

        
        

        

        

        

        




        public function CheckDayIfAlreadyTaken($teacher_id)
        {
            $takenDays = [];
            $query = $this->conn->prepare("SELECT `sched_day` FROM `tblschedule` 
                WHERE `sched_teacher_id` = ?");
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

        






        public function fetch_schedule($teacher_id)
        {
            $query = $this->conn->prepare("SELECT * FROM `tblschedule` WHERE `sched_teacher_id` = ?");
            $query->bind_param("i", $teacher_id); // Ensure the parameter type matches your DB schema
        
            if ($query->execute()) {
                $result = $query->get_result();
        
                // Fetch all schedules into an array if rows exist
                if ($result->num_rows > 0) {
                    $schedules = $result->fetch_all(MYSQLI_ASSOC);
                    $query->close();
                    return $schedules; // Return array of schedules
                } else {
                    $query->close();
                    return []; // Return an empty array instead of null for better handling
                }
            } else {
                $query->close();
                return false; // Return false on execution failure
            }
        }
        

        


    
}