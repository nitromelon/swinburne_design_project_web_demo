<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

$text = '';
$offset = 0;
$limit = 5;

if (isset($_GET['page'])) {
    $offset = (int) $_GET['page'] * $limit;
}

$result = null;

if (isset($_SESSION['user_id'])) {
    $result = execute_query($db, SQL::courses_if_login, array(':user_id' => $_SESSION['user_id'], ':offset' => $offset, ':limit' => $limit));
} else {
    $result = execute_query($db, SQL::courses, array(':offset' => $offset, ':limit' => $limit));
}

if (is_string($result)) {
    $text = $result;
}

if (count($result) == 0) {
    $text = "No courses found";
    if ($offset > 0) {
        header("Location: courses.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
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
    <?php
    if ($text != '') {
        echo "<p>" . $text . "</p>";
    }
    ?>
    <table>
        <?php
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Introduction</th>";
        echo "<th>Length</th>";
        echo "<th>Outline</th>";
        echo "<th>Provider</th>";
        echo "<th>Benefit</th>";
        echo "<th>Price</th>";
        echo "<th>Category</th>";

        if (isset($_SESSION['user_id'])) {
            echo "<th>Submit?</th>";
        }

        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['introduction'] . "</td>";
            if ($row['length'] == 1) {
                echo "<td>" . $row['length'] . " hour</td>";
            } else {
                echo "<td>" . $row['length'] . " hours</td>";
            }
            echo "<td>" . str_replace("\n", "<br>", $row['outline']) . "</td>";
            echo "<td>" . $row['provider'] . "</td>";
            echo "<td>" . $row['benefit'] . "</td>";
            echo "<td>$" . $row['price'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            if (isset($_SESSION['user_id'])) {
                echo "<td><a href='course_registration.php?course_id=" . $row['course_id'] . "'>Submit</a></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
    <!-- if offset = 0 then ignore previous link-->

    <?php
    if ($offset > 0) {
        echo "<a href='courses.php?page=" . ($offset / $limit - 1) . "'>Previous</a>";
    }
    ?>

    <a href="index.php">Home</a>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo "<a href='course_paid.php'>Paid Courses</a>";
    }
    ?>

    <a href="course_search.php">Search for Courses</a>

    <?php
    if (count($result) == $limit) {
        echo "<a href='courses.php?page=" . ($offset / $limit + 1) . "'>Next</a>";
    }
    ?>

    <?php require_once 'footer.html'; ?>
</body>

</html>