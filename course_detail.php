<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_GET['course_id'])) {
    header('Location: course.php');
    exit();
}

$course_id = $_GET['course_id'];
$course = execute_query($db, SQL::course_detail, [':course_id' => $course_id]);
if (is_string($course)) {
    echo $course;
    exit();
}

$title = $course[0]['title'];
$introduction = $course[0]['introduction'];
$length = $course[0]['length'];
$outline = $course[0]['outline'];
$provider = $course[0]['provider'];
$benefit = $course[0]['benefit'];
$price = $course[0]['price'];
$category = $course[0]['category'];
$review_count = count($course);
$rating = 0;
foreach ($course as $c) {
    $rating += (int)$c['rating'];
}

$review_array = array();
foreach ($course as $c) {
    $review_array[] = $c['review'];
}

$reivew_username_array = array();
foreach ($course as $c) {
    $reivew_username_array[] = $c['username'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course details</title>
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

        h2, h3 {
            margin-top: 20px;
        }

        p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
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

        .navigation {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <h2>Course detail</h2>
    <h3><?php echo $title; ?></h3>
    <p>Introduction: <?php echo $introduction; ?></p>
    <p>Length: <?php echo $length; ?></p>
    <p>Outline: <?php echo $outline; ?></p>
    <p>Provider: <?php echo $provider; ?></p>
    <p>Benefit: <?php echo $benefit; ?></p>
    <p>Price: <?php echo $price; ?></p>
    <p>Category: <?php echo $category; ?></p>
    <p>Rating: <?php echo $rating / $review_count; ?></p>

    <?php
    echo "<table>";
    echo "<tr>";
    echo "<th>Review</th>";
    echo "<th>Rating</th>";
    echo "<th>Username</th>";
    echo "</tr>";
    for ($i = 0; $i < $review_count; $i++) {
        echo "<tr>";
        echo "<td>" . $review_array[$i] . "</td>";
        echo "<td>" . $course[$i]['rating'] . "</td>";
        echo "<td>" . $reivew_username_array[$i] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <a href="index.php">Home</a>
    <a href="courses.php">Back to course</a>

    <?php require_once 'footer.html'; ?>
</body>

</html>