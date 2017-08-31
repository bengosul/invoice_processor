<?php 

require_once __DIR__.'/../../configs/config.php';
//require_once '../../configs/config.php';

$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;
$dbname = config::MYSQL_EMAILDB;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

?>
