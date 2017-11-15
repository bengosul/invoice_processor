<?php 


//require_once 'db_connection_mysqli.php';
require_once 'db_connection_pdo.php';


// Check existing rows
$sql = "SELECT * from {$dbname}.accounts";
$result = $conn->query($sql);

$data = array();

//while ($row = mysqli_fetch_array($result)) 
while($row=$result->fetch(PDO::FETCH_ASSOC)) {
		    $data[] = array('id' => $row['id'], 'accname' => $row['accname']);
	}

//print_r( $data);
 //   header('Content-Type: application/json; charset=utf-8');
 //   header('Vary: Accept-Encoding');
    print json_encode($data);

?>
