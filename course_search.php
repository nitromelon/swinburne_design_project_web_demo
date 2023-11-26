<?php
require_once 'config.php';
require_once 'sql.php';
require_once 'jobs/query_generator.php';

session_start();
$text = '';

$result = array();

$length1 = execute_query($db, SQL::course_length);
$provider1 = execute_query($db, SQL::course_provider);
$price1 = execute_query($db, SQL::course_price);
$category1 = execute_query($db, SQL::course_category);

// print_r($provider);

$title = $_GET['title'] ?? '';
$length_min = $_GET['length_min'] ?? $length1[0]['min'];
$length_max = $_GET['length_max'] ?? $length1[0]['max'];
$provider = $_GET['provider'] ?? '---';
$price_min = $_GET['price_min'] ?? $price1[0]['min'];
$price_max = $_GET['price_max'] ?? $price1[0]['max'];
$category = $_GET['category'] ?? '---';

$query = course_generate_query($title, $length_min, $length_max, $provider, $price_min, $price_max, $category);
$result = execute_query($db, $query);
if (is_string($result)) {
    $text = $result;
}

if (count($result) == 0) {
    $text = "No courses found";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for course</title>
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
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

        .navigation {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php require_once 'header.html'; ?>
    <h2>
        <?php
        if (isset($_SESSION['username'])) {
            echo "Hi " . $_SESSION['username'];
        }
        ?>
    </h2>
    <form method="get" action="course_search.php">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?php echo isset($_GET['title']) ? $_GET['title'] : ''; ?>">
        <br>
        <label for="length_min">Length (min)</label>
        <input type="number" name="length_min" id="length_min" value="<?php echo isset($_GET['length_min']) ? $_GET['length_min'] : $length1[0]['min']; ?>">
        <br>
        <label for="length_max">Length (max)</label>
        <input type="number" name="length_max" id="length_max" value="<?php echo isset($_GET['length_max']) ? $_GET['length_max'] : $length1[0]['max']; ?>">
        <br>
        <label for="provider">Provider</label>
        <select name="provider" id="provider">
            <?php
            echo "<option value='---'>---</option>";
            foreach ($provider1 as $row) {
                if ($row['provider'] == $provider) {
                    echo "<option value='" . $row['provider'] . "' selected>" . $row['provider'] . "</option>";
                } else {
                    echo "<option value='" . $row['provider'] . "'>" . $row['provider'] . "</option>";
                }
            }
            ?>
        </select>
        <br>
        <label for="price_min">Price (min)</label>
        <input type="number" name="price_min" id="price_min" value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : $price1[0]['min']; ?>">
        <br>
        <label for="price_max">Price (max)</label>
        <input type="number" name="price_max" id="price_max" value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : $price1[0]['max']; ?>">
        <br>
        <label for="category">Category</label>
        <select name="category" id="category">
            <?php
            echo "<option value='---'>---</option>";
            foreach ($category1 as $row) {
                if ($row['category'] == $category) {
                    echo "<option value='" . $row['category'] . "' selected>" . $row['category'] . "</option>";
                } else {
                    echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
                }
            }
            ?>
        </select>
        <br>
        <br>
        <input type="submit" value="Search">
    </form>
    <h2>
        Search for course
    </h2>
    <?php
    if ($text != '') {
        echo "<p>" . $text . "</p>";
    }
    ?>
    <table>
        <?php
        echo "<tr>";
        echo "<th>Title</th>";
        // echo "<th>Introduction</th>";
        // echo "<th>Length</th>";
        // echo "<th>Outline</th>";
        // echo "<th>Provider</th>";
        // echo "<th>Benefit</th>";
        echo "<th>Price</th>";
        echo "<th>Category</th>";
        echo "<th>Details</th>";

        if (isset($_SESSION['user_id'])) {
            echo "<th>Submit?</th>";
        }

        echo "</tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            // echo "<td>" . $row['introduction'] . "</td>";
            // if ($row['length'] == 1) {
            //     echo "<td>" . $row['length'] . " hour</td>";
            // } else {
            //     echo "<td>" . $row['length'] . " hours</td>";
            // }
            // echo "<td>" . str_replace("\n", "<br>", $row['outline']) . "</td>";
            // echo "<td>" . $row['provider'] . "</td>";
            // echo "<td>" . $row['benefit'] . "</td>";
            echo "<td>$" . $row['price'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td><a href='course_detail.php?course_id=" . $row['course_id'] . "'>Details</a></td>";
            if (isset($_SESSION['user_id'])) {
                echo "<td><a href='course_registration.php?course_id=" . $row['course_id'] . "'>Submit</a></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
    <?php require_once 'footer.html'; ?>
    <a href="index.php">Home</a>
    <a href="courses.php">Back to courses</a>
</body>

</html>