<?php
// Include the database connection settings
require_once("settings.php");

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all companies from the database
$sql_table = "company";
$query = "SELECT * FROM $sql_table";
$result = mysqli_query($conn, $query);

// Display the list of companies
if ($result) {
    echo "<h2>List of Companies</h2>";
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Company Name</th><th>Size</th><th>Introduction</th><th>Phone Number</th><th>Email</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['company_name'] . "</td>";
            echo "<td>" . $row['size'] . "</td>";
            echo "<td>" . $row['introduction'] . "</td>";
            echo "<td>" . $row['phone_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No companies found.</p>";
    }

    // Close the result set
    mysqli_free_result($result);
} else {
    echo "<p>Something went wrong: ", mysqli_error($conn), "</p>";
}

// Close the database connection
mysqli_close($conn);
?>
