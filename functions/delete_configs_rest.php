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


$_POST = json_decode(file_get_contents('php://input'), true);
if(!empty($_POST['id']))
{
	$upd_query="DELETE from emails.match_config where id = {$_POST['id']}";
}
else{
	console.log('un cacat');
}


echo $upd_query;


$result= $conn->query($upd_query) or die(mysqli_error($conn)) ;


// echo json_encode($result->fetchAll());
var_dump($result);
if (!mysqli_affected_rows($conn)) {
echo "<html><body><script type='text/javascript'>alert('fuck this');</script></body></html>";
}




?>
