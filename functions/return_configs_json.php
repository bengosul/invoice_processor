<?php 

require_once '../../configs/config.php';
$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

// Check existing rows
$sql = "SELECT * from emails.match_config";
$result = $conn->query($sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	  $data[] = $row;
}
    print json_encode($data);

?>
