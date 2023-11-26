<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$text = '';

if (!isset($_GET['course_id'])) {
    $result = execute_query($db, SQL::registered_courses, array(':user_id' => $_SESSION['user_id']));
} else {
    $result = execute_query($db, SQL::registered_courses_with_course_id, array(':user_id' => $_SESSION['user_id'], ':course_id' => $_GET['course_id']));
}

if (is_string($result)) {
    $text = $result;
} else if (count($result) == 0) {
    $text = "You have not registered this course";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status of your course study process</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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

        h2 {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        p {
            margin-top: 20px;
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
    <h2>
        <?php
        if (isset($_SESSION['username'])) {
            echo "Hi " . $_SESSION['username'];
        }
        ?>
    </h2>

    <?php
    if ($text != '') {
        echo "<p>" . $text . "</p>";
    }

    if (count($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Enrollment date</th>";
        echo "<th>Status</th>";
        echo "</tr>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['enrollment_date'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>

    <br>
    <a href="course_paid.php">Back to paid courses</a>
    <br>
    <a href="courses.php">Back to courses</a>
    <br>
    <a href="index.php">Back to home</a>
</body>

</html>