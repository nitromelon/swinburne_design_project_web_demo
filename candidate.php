<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your candidate profile</title>
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

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Create your candidate profile</h2>

<form method="post" action="./candidate_profile.php" novalidate>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="job_title">Job Title:</label>
    <input type="text" id="job_title" name="job_title" required>

    <label for="experience_level">Experience Level:</label>
    <select id="experience_level" name="experience_level" required>
        <option value="Internship">Internship</option>
        <option value="Entry level">Entry level</option>
        <option value="Junior">Junior</option>
        <option value="Mid-level">Mid-level</option>
        <option value="Senior">Senior</option>
    </select>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="living_location">Living Location:</label>
    <input type="text" id="living_location" name="living_location" required>

    <label for="educational_background">Educational Background:</label>
    <input type="text" id="educational_background" name="educational_background" required>

    <label for="career_goal_introduction">Career Goal Introduction:</label>
    <textarea id="career_goal_introduction" name="career_goal_introduction" rows="4" required></textarea>

    <input type="submit" value="Save">
</form>

</body>
</html>
