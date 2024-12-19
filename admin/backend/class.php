<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


        public function addSection($course, $year_level, $section)
    {
        // Prepare the SQL query
        $query = $this->conn->prepare("INSERT INTO `tblsection` (`course`, `year_level`, `section`) VALUES (?, ?, ?)");

        // Check if the query was prepared successfully
        if ($query === false) {
            return false; // Query preparation failed
        }

        // Bind the parameters (s for string)
        $query->bind_param("sss", $course, $year_level, $section);

        // Execute the query
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false; // Query failed to execute
        }

        // Close the prepared statement (optional but recommended)
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
}