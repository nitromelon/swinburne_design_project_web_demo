<?php
// Include the database connection settings
require_once("settings.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to sanitize input data
function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize error message
$errorMsg = "";

// Get data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = sanitise_input($_POST["name"]);
    $job_title = sanitise_input($_POST["job_title"]);
    $experience_level = sanitise_input($_POST["experience_level"]);
    $age = sanitise_input($_POST["age"]);
    $gender = sanitise_input($_POST["gender"]);
    $phone_number = sanitise_input($_POST["phone_number"]);
    $email = sanitise_input($_POST["email"]);
    $living_location = sanitise_input($_POST["living_location"]);
    $educational_background = sanitise_input($_POST["educational_background"]);
    $career_goal_introduction = sanitise_input($_POST["career_goal_introduction"]);


    // If there are no errors, insert data into the database
    if ($errorMsg == "") {
        $sql_table = "candidate_profile";
        $user_id = $_SESSION['user_id'];
        // Insert data into the database
        $query = "INSERT INTO $sql_table (user_id,name, job_title, experience_level, age, gender, phone_number, email, living_location, educational_background, career_goal_introduction) 
                  VALUES ('$user_id', '$name', '$job_title', '$experience_level', '$age', '$gender', '$phone_number', '$email', '$living_location', '$educational_background', '$career_goal_introduction')";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<p>Something went wrong: ", mysqli_error($conn), "</p>";
        } else {
            echo "Candidate profile added successfully!";
            // You can redirect the user to a success page if needed
            // header("Location: success.php");
            header("Location: index.php");
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo "Error: $errorMsg";
    }
}
