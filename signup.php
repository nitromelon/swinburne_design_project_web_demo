<?php
require_once 'config.php';
require_once 'sql.php';

session_start();
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($email) || empty($phone) || empty($role)) {
        header("Location: signup.php");
    }

    $result = execute_query($db, SQL::signup_check_exists, array(':email' => $email));

    if (is_string($result)) {
        echo $result;
        exit();
    }

    if (count($result) > 0) {
        echo "Email already exists";
        exit();
    }

    $result = execute_query($db, SQL::signup, array(':username' => $username, ':password' => $password, ':email' => $email, ':phone' => $phone, ':role' => $role));

    if (is_string($result)) {
        echo $result;
        exit();
    }

    $user_id = execute_query($db, SQL::signup_user_id, array(':email' => $email))[0]['user_id'];
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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

        input,
        select {
            width: 100%;
            padding: 8px;
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
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password</label>
        <input type="text" name="password" id="password">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone">
        <br>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="candidate">Candidate</option>
            <option value="employer">Employer</option>
        </select>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>