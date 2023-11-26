<?php
require_once 'config.php';
require_once 'sql.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = execute_query($db, SQL::upload_job_user_in_company, array(':user_id' => $user_id));
if (is_string($result) || count($result) == 0) {
    header("Location: jobs.php");
}

$company_id = (int) $result[0]['company_id'];

$result = execute_query($db, SQL::upload_job_get_company_name, array(':company_id' => $company_id));
if (is_string($result) || count($result) == 0) {
    header("Location: jobs.php");
}

$name = $result[0]['company_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $experience_requirement = $_POST['experience_requirement'];
    $working_format = $_POST['working_format'];
    $specialization = $_POST['specialization'];
    $title = $_POST['title'];
    $benefits = $_POST['benefits'];
    $salary = $_POST['salary'];
    $working_location = $_POST['working_location'];
    $scope_of_work = $_POST['scope_of_work'];
    $company_id = $_POST['company_id'];
    $name = $_POST['company_name'];

    $result = execute_query($db, SQL::upload_job, array(
        ':company_id' => $company_id,
        ':experience_requirement' => $experience_requirement,
        ':working_format' => $working_format,
        ':specialization' => $specialization,
        ':title' => $title,
        ':benefits' => $benefits,
        ':salary' => $salary,
        ':working_location' => $working_location,
        ':scope_of_work' => $scope_of_work,
        ':employer' => $name
    ));

    if (is_string($result)) {
        echo $result;
    } else {
        header("Location: jobs.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload job</title>
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

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        select,
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
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
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <h2>You are from company: "<?php echo $name; ?>"</h2>
    <form action="upload_job.php" method="post">
        <label for="experience_requirement">Experience requirement</label>
        <select name="experience_requirement" id="experience_requirement">
            <option value="Junior">Junior</option>
            <option value="Entry_level">Entry level</option>
            <option value="Mid-level">Mid-level</option>
            <option value="Internship">Internship</option>
            <option value="Senior">Senior</option>
        </select>
        <br>
        <label for="working_format">Working format</label>
        <select name="working_format" id="working_format">
            <option value="Hybrid">Hybrid</option>
            <option value="On-site">On-site</option>
            <option value="Remote">Remote</option>
        </select>
        <br>
        <label for="specialization">Specialization</label>
        <input type="text" name="specialization" id="specialization">
        <br>
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
        <br>
        <label for="benefits">Benefits</label>
        <br>
        <textarea name="benefits" id="benefits" cols="30" rows="10"></textarea>
        <br>
        <label for="salary">Salary</label>
        <input type="number" name="salary" id="salary">
        <br>
        <label for="working_location">Working location</label>
        <input type="text" name="working_location" id="working_location">
        <br>
        <label for="scope_of_work">Scope of work</label>
        <br>
        <textarea name="scope_of_work" id="scope_of_work" cols="30" rows="10"></textarea>
        <br>
        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
        <input type="hidden" name="company_name" value="<?php echo $name; ?>">
        <br>
        <input type="submit" value="Upload">
    </form>
    <br>
    <a href="./index.php">Home</a>
    <a href="./courses.php">Back to courses</a>
</body>

</html>