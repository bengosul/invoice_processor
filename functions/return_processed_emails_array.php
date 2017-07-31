<?php 

require_once 'general_functions.php';
require_once '../configs/config.php';
$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;
$dbname = config::MYSQL_EMAILDB;


echo $servername.":". $username.":". $password.":". $dbname ;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
insert_break();

// Check existing rows
$sql = "SELECT * from processed_emails";
$result = $conn->query($sql);

// echo "--- printing top 10 existing in db---";
$numrows=mysqli_num_rows($result);

echo "\n Number of rows = {$numrows}";

?>
