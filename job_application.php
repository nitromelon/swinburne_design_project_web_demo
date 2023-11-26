<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$offset = 0;
$limit = 5;

// if has get and job_id then show form
// if not have job_id then show table

$is_job_id = isset($_GET['job_id']);
if ($is_job_id) {
    $is_applied = execute_query($db, SQL::job_application_all, array(
        ':user_id' => $_SESSION['user_id']
    ));

    if (is_string($is_applied)) {
        echo "<p>" . $is_applied . "</p>";
    } else {
        foreach ($is_applied as $row) {
            if ($row['job_id'] == $_GET['job_id']) {
                echo "<p>You have already applied for this job</p>";
                $is_job_id = false;
                header("Location: job_application.php");
                exit();
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST' && $is_job_id) {
        $result = execute_query($db, SQL::job_application_insert, array(
            ':user_id' => $_SESSION['user_id'],
            ':job_id' => $_POST['job_id'],
            ':resume_cv' => $_POST['resume_cv'],
            ':statement' => $_POST['statement'],
            ':question' => $_POST['question']
        ));
        if (is_string($result)) {
            echo "<p>" . $result . "</p>";
        } else {
            echo "<p>Job application submitted</p>";
            header("Location: job_application.php");
            exit();
        }
    }
} else {
    $result = execute_query($db, SQL::job_application, array(
        ':user_id' => $_SESSION['user_id'],
        ':offset' => $offset,
        ':limit' => $limit
    ));
    if (is_string($result)) {
        echo "<p>" . $result . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job application</title>
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

        h1 {
            margin-top: 20px;
        }

        p {
            margin: 10px 0;
            color: green;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            /* color: #fff; */
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <?php if ($is_job_id) { ?>
        <h1>Apply for job</h1>
        <form action="job_application.php?job_id=<?php echo $_GET['job_id']; ?>" method="post">
            <input type="hidden" name="job_id" value="<?php echo $_GET['job_id']; ?>">
            <label for="resume_cv">Resume/CV</label>
            <input type="text" name="resume_cv" id="resume_cv">
            <br>
            <label for="statement">Statement</label>
            <input type="text" name="statement" id="statement">
            <br>
            <label for="question">Question</label>
            <input type="text" name="question" id="question">
            <br>
            <input type="submit" value="Submit">
        </form>
        <br>
        <br>
    <?php } else { ?>
        <table>
            <?php
            echo "<tr>";
            echo "<th>Job title</th>";
            echo "<th>Resume/CV</th>";
            echo "<th>Statement</th>";
            echo "<th>Question</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['resume_cv'] . "</td>";
                echo "<td>" . $row['statement'] . "</td>";
                echo "<td>" . $row['question'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php } ?>

    <?php if ($offset > 0) { ?>
        <a href="job_application.php?page=<?php echo $_GET['page'] - 1; ?>">Previous</a>
    <?php } ?>

    <a href="jobs.php">Back to jobs</a>
    <?php if ($is_job_id) { ?>
        <a href="job_application.php?job_id=<?php echo $_GET['job_id']; ?>">Apply for job</a>
    <?php } ?>

    <?php if (count($result) == $limit) { ?>
        <a href="job_application.php?page=<?php echo $_GET['page'] + 1; ?>">Next</a>
    <?php } ?>
</body>

</html>