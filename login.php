<?php
    require ("connection2.php");
    session_start();

class StudentLogin{
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    private function showErrorMessage($message){
        echo "<script>alert('$message'); window.location.href = 'login.php';</script>";
    } 
    public function loginprocess(){
        
        $errors = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
    
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password =$_POST['password'];
    
            if (!$email) {
                array_push($errors, 'test');
                echo "Invalid email format.";
                exit();
            }
    
            // Sanitize input
            $stmt = $this->connection->prepare("SELECT password FROM students WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hashedPasswordFromDb = $row['password'];
        
                // Verify the provided password against the stored hashed password
                if (!password_verify($password, $hashedPasswordFromDb)) {
                    array_push($errors, "Invalid password");
                    $this->showErrorMessage("Invalid password");
                } else {
                    // Password is correct
                    if (count($errors) == 0) {
                        # code...
                        $_SESSION["user_email"] = $email;
                        header("Location: studentportal.php");
                        exit;
                    }
                }
                
            } else {
                $this->showErrorMessage("Invalid email");
                array_push($errors, "Invalid password");
            }
        }
    }
} 

$login = new StudentLogin($connection);
$login ->loginprocess();


?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <h1>Student Login</h1>
        <form method="post" action="">
            <label for ="email">Email: </label>
            <input type="email" name="email" id="email" required>
            
            <label for= "password">Password: </label>
            <input type="password" name= "password" id="password" required>

            <input type="submit" value="Login">
            <a href="studentregistration.php" id= "register">Register?</a>
        </form>
    </body>
</html>

