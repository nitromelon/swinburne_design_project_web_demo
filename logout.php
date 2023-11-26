<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        p {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
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
    <?php
    require_once 'header.html';
    ?>
    <p>
        <?php
        session_start();
        session_unset();
        session_destroy();
        echo "Logout successfully";
        ?>
    </p>
    <a href="index.php">Home</a>
</body>

</html>