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
            "INSERT INTO tblfacultymember (ID_code, fname, mname, lname, designation, Password) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        if ($query === false) {
            return false; // Query preparation failed
        }
    
        // Bind the parameters and execute the insert query
        $query->bind_param("ssssss", $teacherCode, $fname, $mname, $lname, $designation, $password);
        if ($query->execute()) {
            echo "200"; // Success
        } else {
            return false; // Query execution failed
        }
    
        $query->close();
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

}