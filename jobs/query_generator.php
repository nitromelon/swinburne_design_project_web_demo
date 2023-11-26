<?php
// TODO: add :offset and :limit at the end of query
function generate_query($user_id = null, $post)
{
    $title = $post['title'];
    $salary_min = $post['salary_min'];
    $salary_max = $post['salary_max'];
    $experience_requirement = $post['experience_requirement'];
    $company_size = $post['company_size'];
    $working_format = $post['working_format'];
    $specialization = $post['specialization'];

    if ($salary_min == '') {
        $salary_min = null;
    }

    if ($salary_max == '') {
        $salary_max = null;
    }

    if ($experience_requirement == '---') {
        $experience_requirement = null;
    }

    if ($company_size == '---') {
        $company_size = null;
    }

    if ($working_format == '---') {
        $working_format = null;
    }

    if ($specialization == '---') {
        $specialization = null;
    }

    $salary_min = (int) $salary_min;
    $salary_max = (int) $salary_max;

    $query = "SELECT jobs.job_id, jobs.title, jobs.salary, jobs.company_id, company.company_name FROM jobs INNER JOIN company ON jobs.company_id = company.company_id WHERE title LIKE '%" . $title . "%'";
    if ($salary_min != null) {
        $query .= " AND salary >= " . $salary_min;
    }

    if ($salary_max != null) {
        $query .= " AND salary <= " . $salary_max;
    }

    if ($experience_requirement != null) {
        $query .= " AND experience_requirement = '" . $experience_requirement . "'";
    }

    if ($company_size != null) {
        $query .= " AND size = '" . $company_size . "'";
    }

    if ($working_format != null) {
        $query .= " AND working_format = '" . $working_format . "'";
    }

    if ($specialization != null) {
        $query .= " AND specialization = '" . $specialization . "'";
    }

    if ($user_id != null) {
        $query .= " AND job_id NOT IN (SELECT job_id FROM job_application WHERE user_id = " . $user_id . ")";
    }

    $query .= " ORDER BY jobs.job_id DESC LIMIT :offset, :limit";

    return $query;
}


function course_generate_query($title = null, $length_min = null, $length_max = null, $provider = null, $price_min = null, $price_max = null, $category = null)
{
    if ($title == '') {
        $title = null;
    }

    if ($length_min == '') {
        $length_min = null;
    }

    if ($length_max == '') {
        $length_max = null;
    }

    if ($provider == '---') {
        $provider = null;
    }

    if ($price_min == '') {
        $price_min = null;
    }

    if ($price_max == '') {
        $price_max = null;
    }

    if ($category == '---') {
        $category = null;
    }

    $length_min = (int) $length_min;
    $length_max = (int) $length_max;
    $price_min = (int) $price_min;
    $price_max = (int) $price_max;

    $query = "SELECT * FROM courses WHERE title LIKE '%" . $title . "%'";
    if ($length_min != null) {
        $query .= " AND length >= " . $length_min;
    }

    if ($length_max != null) {
        $query .= " AND length <= " . $length_max;
    }

    if ($provider != null) {
        $query .= " AND provider = '" . $provider . "'";
    }

    if ($price_min != null) {
        $query .= " AND price >= " . $price_min;
    }

    if ($price_max != null) {
        $query .= " AND price <= " . $price_max;
    }

    if ($category != null) {
        $query .= " AND category = '" . $category . "'";
    }

    $query .= " ORDER BY course_id DESC";

    return $query;
}
