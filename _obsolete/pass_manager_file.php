<?php
//check that arrival here was with post
if (!isset($_POST["password"])) {
//	echo "no post, redirecting back";
die("How did you get here?");
//	header("Location: "."login.php");
}

session_start();

//file to store login info
$fileName="db/passfile.dat";
//check what's in the file, row by row
$existingArray = [];
if (file_exists(__dir__."/".$fileName)){
	foreach(file(__dir__."/".$fileName) as $line){
		array_push($existingArray ,unserialize($line));
	}
}

//check if matching
foreach ($existingArray as $item){
	if(password_verify($_POST["password"],$item["password"]))	{
		echo "Aliluia\n"; // return 1;
		if ($_POST["username"]==$item["username"]){
//old method			setcookie("credentials",$hash2,time()+30);
//if found, set session with a new hash of the user's pass which is also used to decrypt the imap password
			$hash2 = password_hash($item["password"], PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $item["salt"] ]);
			$_SESSION["hash2"]=$hash2;
			$_SESSION["encr_pass"]=$item["encrypted_imap_pass"];

			header("Location: "."server_config.php");
		return;	
		}
	}
}
//redirect back if not found
/*
if (!isset($_SESSION["credentials"])){ 
	echo "not found";
}
else echo $_SESSION["credentials"];
 */

$_SESSION["message"]="Login failed";
header("Location: "."account.php");
?>
