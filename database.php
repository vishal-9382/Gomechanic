<?php
// Look for Railway's variables, otherwise use local XAMPP defaults
$host = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$dbname = getenv('MYSQLDATABASE') ?: 'onlinemachanicfinder';
$port = getenv('MYSQLPORT') ?: 3306;

$connection = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
