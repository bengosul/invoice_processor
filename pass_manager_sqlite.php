<?php
//check that arrival here was with post
if (!isset($_POST["password"])) {
//	echo "no post, redirecting back";
die("How did you get here?");
//	header("Location: "."login.php");
}

session_start();

//sqlite connection
$db = new SQLite3('db/emails.sqlite3');
$sql = "select * from logins where username='".$_POST['username']."' limit 1";
$result = $db->query($sql)->fetchArray(SQLITE3_ASSOC) ;

//check if username exists
if(!$result){
$_SESSION["message"]="No such username";
header("Location: "."account.php");
exit;
}


echo "<p>POST: ".$_POST["password"];
echo "<p>ITEM: ".$result["passhash"];

//check if matching
if(password_verify($_POST["password"],$result["passhash"]))	{
		//if found, set session with a new hash of the user's pass which is also used to decrypt the imap password
		$hash2 = password_hash($_POST['password'], PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $result["salt2"] ]);
		$_SESSION["hash2"]=$hash2;
		$_SESSION["encr_pass"]=$result["imap_pass_enc"];
		$_SESSION["username"]=$result["username"];
		header("Location: "."server_config.php");
	return;	
}

//redirect back if not found
$_SESSION["message"]="Login failed";
header("Location: "."account.php");
?>
