<?php
    session_start();

    if (!isset($_SESSION["user_email"])){
        header("Location: teacher_login.php");
    }

?>  
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>University Staff Portal</title>
        <link rel="stylesheet" href="staffportal.css">
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <img src="logo.png" alt="University Logo">
            </div>
            <div class="navigation">
                <a href="#" class="active">Dashboard</a>
                <a href="#">Email</a>
                <a href="#">Calendar</a>
                <a href="#">Documents</a>
            </div>
            <div class="user-profile">
                <a href="stafflogout.php">Logout</a>
            </div>
        </div>
        <div class="main-dashboard">
            <div class="announcements">
                <div class="announcement-card">
                    <h2>Important Announcement</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque mattis tellus vel fermentum vestibulum.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
                <div class="announcement-card">
                    <h2>Upcoming Event</h2>
                    <p>Join us for the Annual Staff Conference on October 15th. Don't miss out!</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
                <div class="announcement-card">
                    <h2>New Staff Guidelines</h2>
                    <p>We have updated our staff guidelines. Please review them in the Documents section.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>
            <div class="quick-links">
                <a href="#" class="quick-link">Email</a>
                <a href="#" class="quick-link">Calendar</a>
                <a href="#" class="quick-link">Documents</a>
            </div>
        </div>
            <footer class="footer">
                <p>&copy; 2023 University Name. All rights reserved. <a href="#">Privacy Policy</a></p>
            </footer>
    </body>
</html>
