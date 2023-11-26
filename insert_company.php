<?php
// Include the database connection settings
require_once("settings.php");

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $company_name = mysqli_real_escape_string($conn, $_POST["company_name"]);
    $size = mysqli_real_escape_string($conn, $_POST["size"]);
    $introduction = mysqli_real_escape_string($conn, $_POST["introduction"]);
    $phone_number = mysqli_real_escape_string($conn, $_POST["phone_number"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Insert data into the database
    $sql_table = "company";
    $query = "INSERT INTO $sql_table (company_name, size, introduction, phone_number, email) 
              VALUES ('$company_name', '$size', '$introduction', '$phone_number', '$email')";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Something went wrong: ", mysqli_error($conn), "</p>";
    } else {
        echo "Company information added successfully!";
        // You can redirect the user to a success page if needed
        header("Location: index.php");
    }
}

// Close the database connection
mysqli_close($conn);
?>
