<?php
require_once 'config.php';
require_once 'sql.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $introduction = $_POST['introduction'];
    $length = $_POST['length'];
    $outline = $_POST['outline'];
    $provider = $_POST['provider'];
    $benefit = $_POST['benefit'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $result = execute_query($db, SQL::upload_course, array(
        ':title' => $title,
        ':introduction' => $introduction,
        ':length' => $length,
        ':outline' => $outline,
        ':provider' => $provider,
        ':benefit' => $benefit,
        ':price' => $price,
        ':category' => $category
    ));

    if (is_string($result)) {
        echo $result;
    } else {
        header("Location: courses.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post course</title>
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

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
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
    <form action="upload_course.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="introduction">Introduction</label>
        <input type="text" name="introduction" id="introduction" required>
        <br>
        <label for="length">Length</label>
        <input type="text" name="length" id="length" required>
        <br>
        <label for="outline">Outline</label>
        <input type="text" name="outline" id="outline" required>
        <br>
        <label for="provider">Provider</label>
        <br>
        <textarea name="provider" id="provider" cols="30" rows="10" required></textarea>
        <br>
        <label for="benefit">Benefit</label>
        <br>
        <textarea name="benefit" id="benefit" cols="30" rows="10" required></textarea>
        <br>
        <label for="price">Price</label>
        <input type="text" name="price" id="price" required>
        <br>
        <label for="category">Category</label>
        <input type="text" name="category" id="category" required>
        <br>
        <input type="submit" value="Post">
    </form>
    <a href="courses.php">Back to courses</a>
    <a href="./index.php">Back to home</a>
</body>

</html>