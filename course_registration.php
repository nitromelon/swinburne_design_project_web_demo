<?php
require_once 'config.php';
require_once 'sql.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['course_id'])) {
    header("Location: course_paid.php");
    exit();
}

$text = '';
$register = false;

$name = $_SESSION['username'];
$user_id = intval($_SESSION['user_id']);
$course_id = intval($_GET['course_id']);

$result = execute_query($db, SQL::course_registration, array(':user_id' => $user_id, ':course_id' => $course_id));

if (is_string($result)) {
    $text = $result;
} else if (count($result) > 0) {
    $text = "You have already registered this course";
    $register = true;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name = $_POST['name'];
    $age = (int) $_POST['age'];
    $gender = $_POST['gender'];
    $living_location = $_POST['living_location'];
    $bank = $_POST['bank'];
    $card_number = $_POST['card_number'];
    $account_name = $_POST['account_name'];

    $sql = SQL::course_registration_insert;

    if (!$register) {
        $result = execute_query($db, $sql, array(
            ':user_id' => $user_id, ':course_id' => $course_id, ':name' => $name,
            ':age' => $age, ':gender' => $gender, ':living_location' => $living_location,
            ':bank' => $bank, ':card_number' => $card_number, ':account_name' => $account_name
        ));

        $course_id = execute_query($db, SQL::upload_course_get_course_id, array(':user_id' => $user_id));

        if (is_string($course_id)) {
            $text = $course_id;
        } else {
            $course_id = $course_id[0]['course_id'];
            $result = execute_query($db, SQL::upload_course_to_registered, array(
                ':user_id' => $_SESSION['user_id'],
                ':course_id' => $course_id
            ));
        }

        if (is_string($result)) {
            $text = $result;
        } else {
            $text = "Register successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
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

        h2 {
            text-align: center;
            padding: 20px 0;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
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
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <?php if ($text != '') {
        echo "<p>" . $text . "</p>";
    } else { ?>
        <h1> Register for "<?php
                            $result = execute_query($db, SQL::courses_information, array(':course_id' => $course_id));
                            echo $result[0]['title'];
                            ?>" Course
        </h1>
        <form method="post" action="course_registration.php?course_id=<?php echo $_GET['course_id']; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
            <label for="age">Age:</label><br>
            <input type="text" id="age" name="age"><br>
            <label for="gender">Gender:</label><br>
            <select id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select><br>
            <label for="living_location">Living Location:</label><br>
            <input type="text" id="living_location" name="living_location"><br>
            <label for="bank">Bank:</label><br>
            <input type="text" id="bank" name="bank"><br>
            <label for="card_number">Card Number:</label><br>
            <input type="text" id="card_number" name="card_number"><br>
            <label for="account_name">Account Name:</label><br>
            <input type="text" id="account_name" name="account_name" value="<?php echo $name; ?>"><br>
            <input type="submit" value="Submit">
        </form>
    <?php } ?>
    <a href="courses.php">Back to Courses</a>
</body>

</html>