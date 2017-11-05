<?php
//check that arrival here was with post
if (!isset($_POST["password"])) {
//	echo "no post, redirecting back";
	die("How did you get here?");
//	header("Location: "."login.php");
}

session_start();

//PDO mysql
require_once 'functions/db_connection_pdo.php';

echo $servername.":". $username.":". $password.":". $dbname ;
echo "Connected successfully";

$sql = "select * from {$dbname}.logins where username='".$_POST['username']."' limit 1";
$result = $conn->query($sql) or die($conn->error);
$result = $result->fetch();


//check if username exists
if(!$result){
	$_SESSION["message"]="No such username";
	header("Location: "."account.php");
	exit;
}
// echo "<pre>";
/*
echo "<p>POST: ".$_POST["password"];
echo "<p>ITEM: ".$result["passhash"];
 */

//check if matching
if(password_verify($_POST["password"],$result["passhash"]))	{
	//if found, set a cookie with 2h expiration date with the second hash of the user's pass which is also used to decrypt the imap password
		session_regenerate_id();

		$hash2 = password_hash($_POST['password'], PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $result["salt2"] ]);
//		$_SESSION["hash2"]=$hash2;
		setcookie("hash2",$hash2,time()+60*60*2);

		$_SESSION["encr_pass"]=$result["imap_pass_enc"];
		$_SESSION["username"]=$result["username"];
		$_SESSION["agent"]=$_SERVER['HTTP_USER_AGENT'];
		$_SESSION["init_time"]=date("m/d/Y H:i:s");
		$_SESSION["refresh_time"]=date("m/d/Y H:i:s");

		header("Location: "."server_config.php");
	return;	
}


//redirect back if not found
$_SESSION["message"]="Login failed";
header("Location: "."account.php");
?>
