<?php 

require_once 'general_functions.php';
/*
require_once '../configs/config.php';
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
 */

//require_once 'db_connection_mysqli.php';
require_once 'db_connection_pdo.php';

echo $servername.":". $username.":". $password.":". $dbname ;
echo "Connected successfully";
insert_break();

// Check existing rows
$sql = "SELECT * from {$dbname}.processed_emails";
$result = $conn->query($sql) or die($conn->error);


// echo "--- printing top 10 existing in db---";

//mysqli
//$numrows=mysqli_num_rows($result);
//PDO
$numrows = $conn->query("SELECT COUNT(*) FROM  {$dbname}.processed_emails")->fetchColumn();

echo "\n Number of rows = {$numrows}";

?>
