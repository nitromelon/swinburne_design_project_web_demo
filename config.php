<?php
require_once 'secret/key.php';

function connect_database($host, $user, $pswd, $dbnm)
{
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbnm", $user, $pswd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}

function execute_query($pdo, $query, $parameters = array())
{
    if (!$pdo instanceof PDO) {
        return $pdo;
    }

    try {
        $stmt = $pdo->prepare($query);
        foreach ($parameters as $key => &$value) {
            if (is_int($value)) {
                $stmt->bindParam($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Query failed: " . $e->getMessage();
    }
}

$db = connect_database(DB::HOST, DB::USER, DB::PSWD, DB::DBNM);

if (is_string($db)) {
    echo $db;
    exit();
}
