<?php
require_once 'sql.php';
require_once 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = execute_query($db, SQL::interview, array(
    ':user_id' => $user_id
));

if (is_string($result)) {
    echo "<p>" . $result . "</p>";
    exit();
}

$interview_id_array = array();
foreach ($result as $r) {
    $interview_id_array[] = $r['interview_id'];
}

$interview_on_the_go = array();
foreach ($interview_id_array as $interview_id) {
    $interview_on_the_go[] = execute_query($db, SQL::interview_on_the_go, array(
        ':interview_id' => $interview_id
    ));
}

$interview_on_the_go = array_filter($interview_on_the_go, function ($value) {
    return !is_string($value);
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview</title>
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
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        p {
            margin-top: 10px;
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
    <h2>Interview</h2>
    <?php
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Time</th>";
    echo "<th>Status</th>";
    echo "<th>Resume/CV</th>";
    echo "<th>Statement</th>";
    echo "<th>Question</th>";
    echo "</tr>";
    foreach ($result as $r) {
        echo "<tr>";
        echo "<td>" . $r['time'] . "</td>";
        echo "<td>" . $r['status'] . "</td>";
        echo "<td>" . $r['resume_cv'] . "</td>";
        echo "<td>" . $r['statement'] . "</td>";
        echo "<td>" . $r['question'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <h2>Link to the meeting</h2>
    <?php
    foreach ($interview_on_the_go as $interview) {
        echo "<p>" . $interview[0]['time'] . " - " . $interview[0]['link'] . "</p>";
    }
    ?>
    <a href="index.php">Back to home</a>
</body>

</html>