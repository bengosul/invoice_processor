<?php 

require_once 'general_functions.php';
require_once '../configs/config.php';
$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
insert_break();

// Check existing rows
$sql = "SELECT * from emails.processed_emails LIMIT 10";
$result = $conn->query($sql);

echo "--- printing top 10 existing in db---";

?>
