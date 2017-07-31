<?php 

require_once '../../configs/config.php';
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

// Check existing rows
$sql = "SELECT * from {$dbname}.accounts";
$result = $conn->query($sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
		    $data[] = array('id' => $row['id'], 'accname' => $row['accname']);
	}


//print_r( $data);
    print json_encode($data);

?>
