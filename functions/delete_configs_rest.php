<?php 

session_start();
require_once 'db_connection_pdo.php';
/*
require_once '../config.php';
$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$dbname = config::MYSQL_EMAILDB;

$decrypted_mysql_pass=GetMysqlCredentials('encr_mysql_pass');
$password = $decrypted_mysql_pass;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
 */

$_POST = json_decode(file_get_contents('php://input'), true);
if(!empty($_POST['id']))
{
	$upd_query="DELETE from {$dbname}.match_config where id = {$_POST['id']}";
}
else{
	console.log('un cacat');
}


echo $upd_query;


$result= $conn->query($upd_query) or die(mysqli_error($conn)) ;



$result = $conn->prepare($upd_query);
$result->execute();

/* Return number of rows that were deleted */
print("Return number of rows that were deleted:\n");
$count = $result->rowCount();

// echo json_encode($result->fetchAll());
//var_dump($result);
//if (!mysqli_affected_rows($conn)) {


if (!$count) {
echo "<html><body><script type='text/javascript'>alert('fuck this');</script></body></html>";
}




?>
