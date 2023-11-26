<?php
require_once 'config.php';
require_once 'sql.php';

$salary_range = execute_query($db, SQL::jobs_salary_range);
$experience_requirement = execute_query($db, SQL::jobs_experience_requirement);
$company_size = execute_query($db, SQL::jobs_company_size);
$working_format = execute_query($db, SQL::jobs_working_format);
$specialization = execute_query($db, SQL::jobs_specialization);

if (is_string($salary_range) || is_string($experience_requirement) || is_string($company_size) || is_string($working_format) || is_string($specialization)) {
    $text = "Error: cannot load search engine";
}

$salary_range = array_map(function ($x) {
    return (int) $x;
}, $salary_range[0]);

$experience_requirement = array_map(function ($x) {
    return $x['exp'];
}, $experience_requirement);

$company_size = array_map(function ($x) {
    return $x['size'];
}, $company_size);

$working_format = array_map(function ($x) {
    return $x['format'];
}, $working_format);

$specialization = array_map(function ($x) {
    return $x['specialization'];
}, $specialization);
?>

<h2>Seach engine</h2>
<form method="get" action="jobs.php">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required value="<?php echo isset($_GET['title']) ? $_GET['title'] : ''; ?>"><br>

    <label for="salary_min">Min salary (from $<?php echo $salary_range['min']; ?>):</label><br>
    <input type="number" id="salary_min" name="salary_min" value="<?php echo $salary_range['min']; ?>" max="<?php echo $salary_range['max']; ?>" min="<?php echo $salary_range['min']; ?>"><br>

    <label for="salary_max">Max salary (to $<?php echo $salary_range['max']; ?>):</label><br>
    <input type="number" id="salary_max" name="salary_max" value="<?php echo $salary_range['max']; ?>" max="<?php echo $salary_range['max']; ?>" min="<?php echo $salary_range['min']; ?>"><br>

    <label for="experience_requirement">Experience Requirement:</label><br>
    <select id="experience_requirement" name="experience_requirement">
        <option value="---">---</option>
        <?php
        foreach ($experience_requirement as $exp) {
            echo "<option value=\"" . $exp . "\">" . $exp . "</option>";
        }
        ?>
    </select><br>
    <label for="company_size">Company Size:</label><br>
    <select id="company_size" name="company_size">
        <option value="---">---</option>
        <?php
        foreach ($company_size as $size) {
            echo "<option value=\"" . $size . "\">" . $size . "</option>";
        }
        ?>
    </select><br>
    <label for="working_format">Working Format:</label><br>
    <select id="working_format" name="working_format">
        <option value="---">---</option>
        <?php
        foreach ($working_format as $format) {
            echo "<option value=\"" . $format . "\">" . $format . "</option>";
        }
        ?>
    </select><br>
    <label for="specialization">Specialization:</label><br>
    <select id="specialization" name="specialization">
        <option value="---">---</option>
        <?php
        foreach ($specialization as $special) {
            echo "<option value=\"" . $special . "\">" . $special . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Search">
</form>
<br>
<style>
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
</style>