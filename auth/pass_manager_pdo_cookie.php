<?php
//check that arrival here was with post
if (!isset($_POST["password"])) {
//	echo "no post, redirecting back";
	die("How did you get here?");
//	header("Location: "."login.php");
}

session_start();

//file to store login info
$fileName="../db/passfile.dat";
//check what's in the file, row by row
$existingArray = [];
if (file_exists(__dir__."/".$fileName)){
	foreach(file(__dir__."/".$fileName) as $line){
		array_push($existingArray ,unserialize($line));
	}
}
//check if matching
foreach ($existingArray as $item){
	if($_POST['username']==$item["username"]){
		
		if(password_verify($_POST["password"],$item["password"]))	{
		
			//if found, set a cookie with 2h expiration date with the second hash of the user's pass which is also used to decrypt the imap password
			session_regenerate_id();
			$hash2 = password_hash($_POST['password'], PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $item["salt"] ]);
			setcookie("hash2",$hash2,time()+60*60*2,'/');
				$_COOKIE["hash2"]=$hash2;
			$_SESSION["encr_mysql_pass"]=$item["encrypted_mysql_pass"];

			//PDO mysql
			require_once '../functions/db_connection_pdo.php';
			echo $servername.":". $username.":". $password.":". $dbname ;
			echo "Connected successfully";
			//this needs rebuilt, no more need to include passwords in l from mysql, also imap pass encr does not need to lie within the file
			$sql ="SELECT l.id, l.username, l.passhash, l.salt2, 
						sc.IMAP_HOST, sc.IMAP_PORT, sc.IMAP_USER, sc.imap_pass_encr 
					FROM {$dbname}.logins l right join {$dbname}.server_config sc 
					ON l.id=sc.id_login
					WHERE main = 1
					AND username='".$_POST['username']."'
				";
				$result = $conn->query($sql) or die($conn->error);
				$result = $result->fetch(PDO::FETCH_ASSOC);

			$_SESSION["IMAP_HOST"]=$result["IMAP_HOST"];
			$_SESSION["IMAP_PORT"]=$result["IMAP_PORT"];
			$_SESSION["IMAP_USER"]=$result["IMAP_USER"];
			$_SESSION["encr_pass"]=$result["imap_pass_encr"];
			$_SESSION["username"]=$result["username"];
			$_SESSION["agent"]=$_SERVER['HTTP_USER_AGENT'];
			$_SESSION["init_time"]=date("m/d/Y H:i:s");
			$_SESSION["refresh_time"]=date("m/d/Y H:i:s");

			header("Location: "."../server_config.php");
			return;	
		}
	}
	else {
		$_SESSION["message"]="No such username";
		header("Location: "."account.php");
		exit;
	}
}


//redirect back if not found
$_SESSION["message"]="Login failed";
header("Location: "."../account.php");
?>
