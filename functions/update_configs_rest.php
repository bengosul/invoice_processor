<?php 

session_start();
require_once 'db_connection_pdo.php';
//require_once 'db_connection_mysqli.php';
/*
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
*/
/*
// Check existing rows
$sql = "SELECT * from emails.match_config";
$result = $conn->query($sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row;
}
print json_encode($data);
 */

$_POST = json_decode(file_get_contents('php://input'), true);
if(!empty($_POST['id']))
{
	$upd_query="UPDATE {$dbname}.match_config set config_name='{$_POST['config_name']}', partner='{$_POST['partner']}' where id = {$_POST['id']}";
}
else{
	$upd_query="INSERT {$dbname}.match_config (config_name) VALUES('{$_POST['config_name']}')";

}


echo $upd_query;
/*
$result= $conn->query($upd_query) or die(mysqli_error($conn)) ;

// echo json_encode($result->fetchAll());
var_dump($result);
if (!mysqli_affected_rows($conn)) {
	echo "<html><body><script type='text/javascript'>".mysqli_error($conn).$result."alert('fuck thiss');</script></body></html>";
}

*/

$result = $conn->prepare($upd_query);
$result->execute();

/* Return number of rows that were deleted */
print("Return number of rows that were deleted:\n");
$count = $result->rowCount();
print("Updated  $count rows.\n");

if (!$count) {
	echo "<html><body><script type='text/javascript'>".mysqli_error($conn).$result."alert('fuck thiss');</script></body></html>";
}
?>
