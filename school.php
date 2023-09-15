<?php
    require ("connection2.php");

    class Register{
        public $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function emailExists($email){
        $stmt = $this->db->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    public function addstudentdetails($firstname, $lastname, $age, $gender, $date_of_birth, $email, $phone_number, $home_address, $password, $confirmpassword) {
        $errors =[];
       
        if ($this->emailExists($email)) {
            echo  "<script>alert('Student record already exists in database. Please log in.'); window.location.href = 'login.php';</script>";
           
        } elseif ($password !== $confirmpassword) {
            echo  "<script>alert('Passwords do not match.'); window.location.href = 'studentregistration.php';</script>";
           
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
            // Using prepared statements to input data
            $studentInsert = $this->db->prepare("INSERT INTO students (first_name, last_name, age, gender, date_of_birth, email, phone_number, home_address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $studentInsert->bind_param("ssissssss", $firstname, $lastname, $age, $gender, $date_of_birth, $email, $phone_number, $home_address, $hashed_password);
    
            if ($studentInsert->execute()) {
                echo "<script>alert('Student Record entered successfully. Please log in.'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Error adding student record.'); window.location.href = 'login.php';</script>". $studentInsert->error;
            }
            $studentInsert->close(); // Close prepared statement
            
        }
    }
}

    $register = new Register($connection);

    if (isset($_POST['add_student'])) {

        $firstname = mysqli_real_escape_string($connection, $_POST['first_name']) ;
        $lastname = mysqli_real_escape_string($connection, $_POST['last_name']);
        $age =mysqli_real_escape_string($connection, $_POST['age']);
        $gender = mysqli_real_escape_string($connection, $_POST['gender']);
        $date_of_birth = mysqli_real_escape_string($connection, $_POST['date_of_birth']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phone_number = mysqli_real_escape_string($connection, $_POST['phone_number']);
        $home_address = mysqli_real_escape_string($connection, $_POST['home_address']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $confirmpassword = mysqli_real_escape_string($connection, $_POST['confirmpassword']);

        $register->addstudentdetails($firstname, $lastname, $age, $gender, $date_of_birth, $email, $phone_number, $home_address, $password, $confirmpassword);
    }
?>