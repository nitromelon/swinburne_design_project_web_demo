<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_GET['job_id'])) {
    header("Location: jobs.php");
    exit();
}

$text = '';
$job = null;
$job_id = intval($_GET['job_id']);
$result = execute_query($db, SQL::job_detail, array(':job_id' => $job_id));

if (is_string($result)) {
    $text = $result;
} else if (count($result) == 0) {
    $text = "No job found";
} else {
    if (count($result) == 0) {
        $text = "No job found";
    } else {
        $job = $result[0];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job detail</title>
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
            color: #333;
        }

        p {
            margin: 10px 0;
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

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .job-details {
            margin-bottom: 20px;
        }

        .company-details {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php require_once 'header.html'; ?>

    <h2><?php echo $job["title"]; ?></h2>
    <p>Experience requirement: <?php echo $job["experience_requirement"]; ?></p>
    <p>Working format: <?php echo $job["working_format"]; ?></p>
    <p>Specialization: <?php echo $job["specialization"]; ?></p>
    <p>Employer: <?php echo $job["employer"]; ?></p>
    <p>Benefits: <?php echo $job["benefits"]; ?></p>
    <p>Application deadline: <?php echo $job["application_deadline"]; ?></p>
    <p>Salary: <?php echo $job["salary"]; ?></p>
    <p>Working location: <?php echo $job["working_location"]; ?></p>
    <p>Scope of work: <?php echo $job["scope_of_work"]; ?></p>
    <br>
    <h2>Company details</h2>
    <p>Company name: <?php echo $job["company_name"]; ?></p>
    <p>Size: <?php echo $job["size"]; ?></p>
    <p>Introduction: <?php echo $job["introduction"]; ?></p>
    <p>Phone number: <?php echo $job["phone_number"]; ?></p>
    <p>Email: <?php echo $job["email"]; ?></p>
    <br>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo "<a href='job_application.php?job_id=" . $job['job_id'] . "'>Submit now</a>";
    } else {
        echo "<a href='login.php'>Login</a> ";
        echo "<a href='signup.php'>Signup</a>";
    }
    ?>
    <br><br>
    <a href="index.php">Home</a>
    <a href="jobs.php">Back to job list</a>

    <?php require_once 'footer.html'; ?>
</body>
</html>