<?php
    require ("connection2.php");
    require ("school.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Form</title>
        <link rel="stylesheet" href="studentregistration.css">
    </head>
    <body>
        <h1>Student Registration Form</h1>
        <form action="studentregistration.php" method="post">
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
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required >
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone_number">Phone:</label>
            <input type="tel" id="phone_number" name="phone_number" required>

            <label for="home_address">Home Address:</label>
            <input type="text" id="home_address" name="home_address" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" required>
           
            <input type="submit" value="Register" name="add_student">
            <div id="txt">Registered student? <a href="login.php">Log in</a></div>
            
        </form>
    </body>
</html>