<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Profiles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
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
            background-color: #4caf50;
            color: white;
        }
    </style>
</head>
<body>

<h2>Candidate Profiles</h2>

<?php
// Include the database connection settings
require_once("settings.php");

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch candidate profiles from the database
$sql_table = "candidate_profile";
$query = "SELECT * FROM $sql_table";
$result = mysqli_query($conn, $query);

if ($result) {
    // Display the table if there are records
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Job Title</th><th>Experience Level</th><th>Age</th><th>Gender</th><th>Phone Number</th><th>Email</th><th>Living Location</th><th>Educational Background</th><th>Career Goal Introduction</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['job_title'] . "</td>";
            echo "<td>" . $row['experience_level'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['phone_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['living_location'] . "</td>";
            echo "<td>" . $row['educational_background'] . "</td>";
            echo "<td>" . $row['career_goal_introduction'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No candidate profiles found.</p>";
    }

    // Close the result set
    mysqli_free_result($result);
} else {
    echo "<p>Something went wrong: ", mysqli_error($conn), "</p>";
}

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
