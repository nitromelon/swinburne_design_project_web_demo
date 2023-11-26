<?php
require_once 'config.php';
require_once 'sql.php';

$text = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = SQL::login;
    $result = execute_query($db, $sql, array(':username' => $username, ':password' => $password));

    if (is_string($result)) {
        $text = $result;
    }

    if (count($result) == 1) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $result[0]['user_id'];
        $text = "Login successfully";
    } else {
        $text = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
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

        p {
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <?php
    require_once 'header.html';

    if (isset($_SESSION['username'])) {
        echo "<p>Welcome " . $_SESSION['username'] . "</p>";
        echo "<p><a href='index.php'>Home</a></p>";
        echo "<p><a href='courses.php'>Courses</a></p>";
        echo "<p><a href='logout.php'>Logout</a></p>";
        exit();
    }

    if ($text != '') {
        echo "<p>" . $text . "</p>";
    }
    ?>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password"><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>