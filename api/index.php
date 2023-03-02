<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
session_start();
include_once("util.php");
include_once("config.php");
include_once("db.php");
include_once("application.php");
include_once("rest.php");

// connect to the database PDO
    $host = DBHOST;
    $db   = DB;
    $user = DBUSER;
    $pass = DBPASSWORD;
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

// Connect to the database (old version)
/*
try {
    connectDB(DBHOST, DBUSER, DBPASSWORD, DB);
} catch (Exception $e) {
    rest::setHttpHeaders(422, true);
} */

// Get requested method
$method = $_SERVER['REQUEST_METHOD'];

// Read post, put, delete data from client
$dataFromClient = json_decode(file_get_contents('php://input'));

// Read get data from client
foreach ( $_GET as $pname => $pvalue ) {
    if ( !$dataFromClient )  $dataFromClient = new stdClass();
    $dataFromClient->$pname = $pvalue;
}

// Run controller
$dataToClient = controller( $method, $dataFromClient->ressource, $dataFromClient->id ?? null, $dataFromClient, $pdo);

// Send response to client
rest::sendStatusAndData($dataToClient['status'], $dataToClient['data']);

?>
