<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


        public function Login($email, $password)
    {

        // Prepare the SQL query
        $query = $this->conn->prepare("SELECT * FROM `admin` WHERE `admin_email` = ? AND `admin_password` = ? AND admin_status = '1'");

        // Bind the email and the hashed password
        $query->bind_param("ss", $email, $password);
        
        // Execute the query
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Start the session and store user info
                session_start();
                $_SESSION['admin_id'] = $user['admin_id'];

                return $user;  // Return user data
            } else {
                return false;  // User not found or incorrect credentials
            }
        } else {
            return false;  // Query failed to execute
        }
    }

}