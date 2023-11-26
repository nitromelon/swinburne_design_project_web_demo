<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Information Form</title>
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
            max-width: 400px;
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

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
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

<h2>Company Information Form</h2>

<form action="insert_company.php" method="post">
    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" required>

    <label for="size">Company Size:</label>
    <select id="size" name="size" required>
        <option value="1-20 employees">1-20 employees</option>
        <option value="21-50 employees">21-50 employees</option>
        <option value="51-100 employees">51-100 employees</option>
        <option value="100+ employees">100+ employees</option>
    </select>

    <label for="introduction">Introduction:</label>
    <textarea id="introduction" name="introduction" rows="4" required></textarea>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <input type="submit" value="Submit">
</form>

</body>
</html>
