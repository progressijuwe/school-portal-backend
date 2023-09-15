<?php
class StaffLogout{
    public function logoutprocess(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: teacher_login.php");
        exit();
    }
}

$logout = new StaffLogout();
$logout ->logoutprocess();
?>