<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$text = '';

$result = execute_query($db, SQL::course_paid, array(':user_id' => $_SESSION['user_id']));
if (is_string($result)) {
    $text = $result;
} else if (count($result) == 0) {
    $text = "You have not registered any course";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All paid course</title>
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
    ?>
    <table>
        <?php
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Bank</th>";
        echo "<th>Card number</th>";
        echo "<th>Account name</th>";
        echo "<th>Title</th>";
        echo "<th>Provider</th>";
        echo "<th>Price</th>";
        echo "<th>Category</th>";
        echo "<th>Status</th>";
        echo "</tr>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['bank'] . "</td>";
            echo "<td>" . $row['card_number'] . "</td>";
            echo "<td>" . $row['account_name'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['provider'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td><a href='registered_courses.php?course_id=" . $row['course_id'] . "'>More</a></td>";
            echo "</tr>";
        }

        ?>
    </table>
    <p>
        <?php
        $total = 0;
        foreach ($result as $row) {
            $total += $row['price'];
        }
        echo "Total paid money: $" . $total;
        ?>
    </p>
    <a href="courses.php">Back to courses</a>
    <br>
    <a href="index.php">Home</a>
</body>

</html>