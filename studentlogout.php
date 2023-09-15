<?php
class StudentLogout{
    public function logoutprocess(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$logout = new StudentLogout();
$logout ->logoutprocess();
?>