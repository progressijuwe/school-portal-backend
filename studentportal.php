<?php
    session_start();

    if (!isset($_SESSION["user_email"])){
        header("Location: login.php");
    }

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Portal</title>
    <link rel="stylesheet" href="studentportal.css"> 
</head>
<body>
    <header>
        <h1>School Portal</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Registration</a></li>
            <li><a href="#">Exams</a></li>
            <li><a href="#">Grades</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="studentlogout.php" class="logout" >Logout</a></li>
        </ul>
    </nav>

    <main>
        <section class="featured">
            <h2>Welcome to Our School Portal <?php echo $_SESSION["user_email"]; ?></h2>
            <p>Access important information about courses, exams, events, and more.</p>
        </section>

        <section class="news">
            <h2>Latest News</h2>
            <div class="news-item">
                <h3>Upcoming Seminar</h3>
                <p>Join us for an informative seminar on career opportunities.</p>
            </div>
            <div class="news-item">
                <h3>New Course Announcement</h3>
                <p>We're introducing an exciting new course for advanced students.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 School Portal. All rights reserved.</p>
    </footer>
</body>
</html>
