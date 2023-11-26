<?php

function get_search_json($input, $type) {
    $python_script = "semantics_search.py";
    $command = "python $python_script $input $type";
    $output = exec($command);
    $output = str_replace("'", '"', $output);
    $jsonOutput = json_decode($output);
    $out = array();
    foreach($jsonOutput as $row) {
        array_push($out, $row->title);
    }
    return $out;
}


