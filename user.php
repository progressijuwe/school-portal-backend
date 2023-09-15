<?php

require './connection2.php';

class School{
    public $school;
    public $db;

    public function __construct($db){
        $this->db = $db;
    }

    //student table functions

    public function addstudentdetails($firstname, $lastname, $age, $gender, $date_of_birth, $email, $phone_number, $home_address, $password, $confirmpassword) {
        // Check if the student record already exists
        $result = $this->db->query("SELECT * FROM students WHERE email = '$email'");
        if ($result->num_rows > 0) {
            echo "This student record already exists in the database";
        } elseif ($password !== $confirmpassword) {
            echo "Password and confirmation password do not match.";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
            // Using prepared statements to input data
            $studentInsert = $this->db->prepare("INSERT INTO students (first_name, last_name, age, gender, date_of_birth, email, phone_number, home_address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $studentInsert->bind_param("ssissssss", $firstname, $lastname, $age, $gender, $date_of_birth, $email, $phone_number, $home_address, $hashed_password);
    
            if ($studentInsert->execute()) {
                echo "Student record entered successfully";
            } else {
                echo "Error adding student record: " . $studentInsert->error;
            }
            $studentInsert->close(); // Close prepared statement
        }
    }
    
   
    public function editStudentDetails($id, $fieldToUpdate, $newValue) {
        $allowedFields = ["first_name", "last_name", "age", "gender", "date_of_birth", "email", "phone_number", "home_address"];
        
        if (!in_array($fieldToUpdate, $allowedFields)) {
            echo "Invalid field name.";
            return;
        }
        
        $studentUpdate = $this->db->prepare("UPDATE students SET $fieldToUpdate = ? WHERE id = ?");
        $studentUpdate->bind_param("si", $newValue, $id);
        
        if ($studentUpdate->execute()) {
            if ($studentUpdate->affected_rows > 0) {
                echo "Student ".$fieldToUpdate." for ID: " . $id . " has been updated.";
            } else {
                echo "No changes were made to the student record.";
            }
        } else {
            echo "Error updating student record: " . $studentUpdate->error;
        }
        
        $studentUpdate->close();
    }
    
    public function removeStudentDetails($id) {
        $getsid = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $getsid->bind_param("i", $id);
        $getsid->execute();
    
        $result = $getsid->get_result();
    
        if ($result->num_rows > 0) {
            $sql = "DELETE FROM students WHERE id = ?";
    
            $deleteQuery = $this->db->prepare($sql);
            $deleteQuery->bind_param("i", $id);
    
            if ($deleteQuery->execute()) {
                echo "Student record has been deleted successfully.";
            } else {
                echo "Error deleting student record: " . $deleteQuery->error;
            }
    
            $deleteQuery->close(); // Close the deletequery prepared statement  
        } else {
            echo "Student ID does not exist in the database.";
        }
    
        $getsid->close(); // Close the getid prepared statement
    }
    

    //Guardian table functions 
    public function addguardian ($studentid, $firstname, $lastname, $phone_number, $email){
        $result = $this->db->query("SELECT * FROM guardian where student_id = '$studentid'");
        
        if ($result -> num_rows > 0){
            echo "Guardian already exists for student.";
        }
        else {
            $guardianInsert = $this->db->prepare("INSERT INTO guardian (studentid, first_name, last_name, phone_number, email) VALUES (?, ?, ?, ?, ?) ");
            $guardianInsert->bind_param("issss", $studentid, $firstname, $lastname, $phone_number, $email);

            if ($studentid != ""){
                
                if ($guardianInsert->execute()){
                    return "Guardian Record has been entered successfully!";
                }
                else{
                    return "Error inputting Guardian record ". $guardianInsert->error; 
                }
            }
            else{
                echo " Error: Student Id field cannot be left blank ". $this->db->error;
            }
        }
    }

    public function editGuardianDetails($id, $fieldToUpdate, $newValue) {
        $allowedFields = ["studentid", "first_name", "last_name", "phone_number", "email"];
        
        if (!in_array($fieldToUpdate, $allowedFields)) {
            echo "Invalid field name.";
            return;
        }
        
        $guardianUpdate = $this->db->prepare("UPDATE guardian SET $fieldToUpdate = ? WHERE id = ?");
        $guardianUpdate->bind_param("si", $newValue, $id);
        
        if ($guardianUpdate->execute()) {
            if ($guardianUpdate->affected_rows > 0) {
                echo "Guardian ".$fieldToUpdate." for ID: " . $id . " has been updated.";
            } else {
                echo "No changes were made to the guardian record.";
            }
        } else {
            echo "Error updating student record: " . $guardianUpdate->error;
        }
        
        $guardianUpdate->close();
    }
    public function removeGuardianDetails($id) {
        $getgid = $this->db->prepare("SELECT * FROM guardian WHERE id = ?");
        $getgid->bind_param("i", $id);
        $getgid->execute();
    
        $result = $getgid->get_result();
    
        if ($result->num_rows > 0) {
            $sql = "DELETE FROM guardian WHERE id = ?";
    
            $deleteGQuery = $this->db->prepare($sql);
            $deleteGQuery->bind_param("i", $id);
    
            if ($deleteGQuery->execute()) {
                echo "Guardian record has been deleted successfully.";
            } else {
                echo "Error deleting guardian record: " . $deleteGQuery->error;
            }
    
            $deleteGQuery->close(); // Close the deletequery prepared statement
        } else {
            echo "Guardian ID does not exist in the database.";
        }
    
        $getgid->close(); // Close the getid prepared statement
    }
}


// $student = new School($connection);

// echo "Delete student record ". "\n";
// $student->removeStudentDetails(5);

// echo "Add student record"."\n";
// $student->addstudentdetails("John", "Doe", 22,"Male","23-07-2001", "johndoe@gmail.com", "08173573973", "3 Y.P.O. Shodeinde Street");

// echo "Edit student record"."\n";
// $student->editStudentDetails(2, "first_name", "Abdul");

$guardian = new School($connection);

// echo "Add guardian record"."\n";
// $guardian-> addguardian(5, "Peter", "Pan", "09167392739", "peterpan@gmail.com");

// echo "Edit guardian record"."\n";
// $guardian->editGuardianDetails(1, "first_name", "Chidera");

// echo "Delete guardian record ". "\n";
// $guardian->removeGuardianDetails(6);

?>