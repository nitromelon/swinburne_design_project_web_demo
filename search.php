<?php
require_once 'sql.php';
require_once 'config.php';
require_once 'search_engine.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header("Location: index.php");
    exit();
}

$search_type = $_GET['search_type'];
$value = $_GET['search'];

$raw_result = get_search_json($value, $search_type);

$result = array();

foreach ($raw_result as $row) {
    $temp = [];
    if ($search_type == 'jobs') {
        $temp = execute_query($db, SQL::search_engine_job, array(
            ':title' => $row
        ));
    } else if ($search_type == 'courses') {
        $temp = execute_query($db, SQL::search_engine_course, array(
            ':title' => $row
        ));
    }

    if (is_string($temp)) {
        echo "<p>" . $temp . "</p>";
        exit();
    } else {
        array_push($result, $temp[0]);
    }
}

$other_type = $search_type == 'jobs' ? 'courses' : 'jobs';
// for each of the result, search for array of other type
$result2 = array();
foreach ($result as $row) {
    $temp = get_search_json($row['title'], $other_type);
    $row['other_type'] = $temp;
    // run query for each of the other type
    foreach ($temp as $other_row) {
        if ($other_type == 'jobs') {
            $temp2 = execute_query($db, SQL::search_engine_job, array(
                ':title' => $other_row
            ));
        } else if ($other_type == 'courses') {
            $temp2 = execute_query($db, SQL::search_engine_course, array(
                ':title' => $other_row
            ));
        }

        if (is_string($temp2)) {
            echo "<p>" . $temp2 . "</p>";
            exit();
        } else {
            $row['other_type_result'] = $temp2;
        }
    }

    array_push($result2, $row);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search engine</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            font-size: 14px;
            color: #828282;
            background-color: #f6f6ef;
        }
        a {
            color: #000;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        h1, h2, h3, h4 {
            font-weight: normal;
        }
        .post {
            border-bottom: 1px solid #828282;
            padding: 10px 0;
        }
        .post a {
            color: #000;
        }
        .post h2 {
            margin: 0;
        }
        .post p {
            margin: 5px 0;
        }
        .related {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Search engine</h1>
    <?php if (count($result) == 0) { ?>
        <p>No result found</p>
    <?php } else { ?>
        <?php for ($i = 0; $i < count($result); $i++) { ?>
            <div class="post">
                <h2><a href="<?php
                    echo $search_type == 'jobs' ? 'job_detail.php?job_id=' . $result[$i]['job_id']
                                                : 'course_detail.php?course_id=' . $result[$i]['course_id'];
                ?>"><?php echo $result[$i]['title']; ?></a></h2>
                <p>
                    <?php echo $search_type == 'jobs' ? $result[$i]['employer'] : $result[$i]['introduction']; ?>
                </p>

                <?php if (count($result2[$i]['other_type_result']) > 0) { ?>
                    <div class="related">
                        <h3>Related <?php echo $search_type == 'jobs' ? 'courses' : 'jobs'; ?></h3>
                        <?php for ($j = 0; $j < count($result2[$i]['other_type_result']); $j++) { ?>
                            <div>
                                <h4><a href="<?php
                                    echo $search_type == 'jobs' ? 'course_detail.php?course_id=' . $result2[$i]['other_type_result'][$j]['course_id']
                                                                : 'job_detail.php?job_id=' . $result2[$i]['other_type_result'][$j]['job_id'];
                                ?>"><?php echo $result2[$i]['other_type_result'][$j]['title']; ?></a></h4>
                                <p>
                                    <?php echo $search_type == 'jobs' ? $result2[$i]['other_type_result'][$j]['introduction'] : $result2[$i]['other_type_result'][$j]['employer']; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
    <br>

    <?php include 'footer.html'; ?>

    <a href="search_engine.php">Back to search engine</a>
    <a href="index.php">Home</a>
</body>
</html>