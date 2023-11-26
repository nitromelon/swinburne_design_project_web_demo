<?php
require_once 'config.php';
require_once 'sql.php';
require_once 'jobs/query_generator.php';

session_start();

$text = '';
$offset = 0;
$limit = 5;

if (isset($_GET['page'])) {
    $offset = (int) $_GET['page'] * $limit;
}

$result = null;

$is_post = $_SERVER["REQUEST_METHOD"] == 'GET'; // fix hehe.
$array_value = array('title', 'salary_min', 'salary_max', 'experience_requirement', 'company_size', 'working_format', 'specialization');
$is_post = $is_post && array_reduce($array_value, function ($carry, $item) {
    return $carry && isset($_GET[$item]);
}, true);

if (isset($_SESSION['user_id'])) {
    if (!$is_post) {
        $result = execute_query($db, SQL::jobs_if_login, array(':user_id' => $_SESSION['user_id'], ':offset' => $offset, ':limit' => $limit));
    } else {
        $query = generate_query($_SESSION['user_id'], $_GET);
        $result = execute_query($db, $query, array_merge(array(':offset' => $offset, ':limit' => $limit)));
    }
} else {
    if (!$is_post) {
        $result = execute_query($db, SQL::jobs, array(':offset' => $offset, ':limit' => $limit));
    } else {
        $query = generate_query(null, $_GET);
        $result = execute_query($db, $query, array_merge(array(':offset' => $offset, ':limit' => $limit)));
    }
}

if (is_string($result)) {
    $text = $result;
}

if (count($result) == 0) {
    $text = "No courses found";
    if ($offset > 0) {
        header("Location: jobs.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
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
            text-align: center;
            margin-top: 20px;
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
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <?php
    if ($text != '') {
        echo "<p>" . $text . "</p>";
    }
    ?>

    <?php require_once 'jobs/searchjob.php'; ?>

    <br>
    <table>
        <?php
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Company</th>";
        echo "<th>Salaray</th>";
        echo "<th>Detail</th>";

        if (isset($_SESSION['user_id'])) {
            echo "<th>Submit?</th>";
        }

        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['company_name'] . "</td>";
            echo "<td>$" . number_format((int) $row['salary']) . "</td>";
            echo "<td><a href='job_detail.php?job_id=" . $row['job_id'] . "'>Detail</a></td>";
            if (isset($_SESSION['user_id'])) {
                echo "<td><a href='job_application.php?job_id=" . $row['job_id'] . "'>Submit</a></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    if ($offset > 0) {
        $params = $_GET;
        $params['page'] = $offset / $limit - 1;
        echo "<a href='jobs.php?" . http_build_query($params) . "'>Previous</a>";
    }
    ?>

    <a href="index.php">Home</a>

    <?php
    if (count($result) == $limit) {
        $params = $_GET;
        $params['page'] = $offset / $limit + 1;
        echo "<a href='jobs.php?" . http_build_query($params) . "'>Next</a>";
    }
    ?>

    <?php require_once 'footer.html'; ?>
</body>

</html>