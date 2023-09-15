<?php
    require ("connection2.php");

    class StaffRegister{
        private $db;

    public function __construct($db){
        $this->db = $db;
    }

    private function emailExists($email){
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    public function addstaffdetails($firstname, $lastname, $age, $email, $phone_number, $home_address, $password, $confirmpassword) {
        $errors =[];
       
        if ($this->emailexists($email)) {
            echo  "<script>alert('Staff record already exists in database. Please log in.'); window.location.href = 'teacher_login.php';</script>";
            array_push($errors, "Email already in use");
        } elseif ($password !== $confirmpassword) {
            echo "<script>alert('Passwords do not match.'); window.location.href = 'staffregistration.php';</script>";
            array_push($errors,"Passwords do not match!");
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
            // Using prepared statements to input data
            $staffInsert = $this->db->prepare("INSERT INTO staff (first_name, last_name, age, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $staffInsert->bind_param("ssissss", $firstname, $lastname, $age, $email, $phone_number, $home_address, $hashed_password);
        
            if ($staffInsert->execute()) {
                echo "<script>alert('Staff Record entered successfully. Please log in.'); window.location.href = 'teacher_login.php';</script>";
            } else {
                echo "<script>alert('Error adding staff record.'); window.location.href = 'teacher_login.php';</script>". $staffInsert->error;
            }
            $staffInsert->close(); // Close prepared statement
        }        
    }
}

    $staffregister = new StaffRegister($connection);

    if (isset($_POST['add_staff'])) {
        $firstname = mysqli_real_escape_string($connection, $_POST['first_name']) ;
        $lastname = mysqli_real_escape_string($connection, $_POST['last_name']);
        $age =mysqli_real_escape_string($connection, $_POST['age']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $phone_number = mysqli_real_escape_string($connection, $_POST['phone']);
        $home_address =mysqli_real_escape_string($connection, $_POST['address']);
        $password =mysqli_real_escape_string($connection, $_POST['password']);
        $confirmpassword =mysqli_real_escape_string($connection, $_POST['confirm_password']);

        $errors = [];

        if ($email === false) {
            array_push($errors, "Invalid email address");
        }

        if (empty($firstname) || empty($lastname) || empty($age) || empty($phone_number) || empty($home_address) ||  empty($password) || empty($confirmpassword)) {
            array_push($errors, "All fields are required.");
        } 
        
        if (empty($errors)) {
            $staffregister->addstaffdetails($firstname, $lastname, $age, $email, $phone_number, $home_address, $password, $confirmpassword);
        }else{
            foreach($errors as $error){
                echo htmlspecialchars($error) . "<br>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Staff Registration</title>
        <link rel="stylesheet" href="staffregistration.css">
    </head>
    <body>
        <div class="container">
        <h1>Staff Registration</h1>
        <br>
        <form action="staffregistration.php" method="post" class="registration-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" required>
                </div>
            </div>
            
            <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" required>
            </div>
            
            <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="register-button" name="add_staff">Register</button>
        </form>
        </div>
    </body>
</html>
