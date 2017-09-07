<?php 

require_once __DIR__.'/../../configs/config.php';
//require_once '../../configs/config.php';

$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;
$dbname = config::MYSQL_EMAILDB;

// Create connection PDO MYSQL
//$conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
try {
	     $conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
} catch (PDOException $e) {
	     echo 'Connection failed: ' . $e->getMessage();
}
/*
// Check connection
if ($conn->errorInfo) {
//	die("Connection failed: " . $conn->connect_error);
	die("Connection failed: " . $conn->errorInfo);
} 
 */
?>
