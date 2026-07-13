<?php
// Look for Railway's variables, otherwise use local XAMPP defaults
$host = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$dbname = getenv('MYSQLDATABASE') ?: 'onlinemachanicfinder';
$port = getenv('MYSQLPORT') ?: 3306;

try {
    $connection = mysqli_connect($host, $user, $pass, $dbname, $port);
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("<h1>Database Error!</h1><p>Failed to connect to the database. Make sure your variables are linked correctly on Railway.</p><p>Error: " . $e->getMessage() . "</p>");
}
?>
