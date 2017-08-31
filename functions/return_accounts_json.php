<?php 
require_once 'db_connection_mysqli.php';

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
