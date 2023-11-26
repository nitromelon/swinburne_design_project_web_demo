<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        p {
            font-size: 18px;
        }

        a {
            text-decoration: none;
            color: #fff;
            margin: 5px;
            display: inline-block;
            padding: 8px 15px;
            background-color: #4CAF50;
            border-radius: 5px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <p>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo "Welcome " . $_SESSION['username'];
        } else {
            echo "Welcome guest";
        }
        ?>
    </p>

    <a href="courses.php">Courses</a>
    <a href="jobs.php">Jobs</a>

    <?php
    if (isset($_SESSION['username'])) {
        echo "<a href='logout.php'>Logout</a>";
        echo "<br>";
        echo "<a href='upload_job.php'>Upload job</a>";
        echo "<br>";
        echo "<a href='upload_course.php'>Upload course</a>";
        echo "<br>";
        echo "<a href='job_application.php'>Apply for jobs</a>";
        echo "<br>";
        echo "<a href='course_paid.php'>Registered courses</a>";
        echo "<br>";
        echo "<a href='interview.php'>Interview Schedule</a>";
        echo "<br>";
        echo "<a href='candidate.php'>Create your candidate profile</a>";
    } else {
        echo "<a href='login.php'>Login</a> ";
        echo "<a href='signup.php'>Signup</a>";
    }
    ?>

    <a href="./contact.php">Contact</a>
</body>

</html>