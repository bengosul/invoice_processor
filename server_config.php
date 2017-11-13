<html>
<body bgcolor="#000000" text="#8888FF">
<form action="server_config.php" method = "post"> 

<?php

require_once "functions/general_functions.php";

session_start();

//die (var_dump($_SESSION));

validate_session('Invalid session');
/*
//process mailserver pass
if(isset($_COOKIE["hash2"])){
	echo "<p>cookie: ".$_COOKIE["hash2"]."</p>";
	echo "init_time: ".$_SESSION['init_time'].'</br></br>';
	$data_init=strtotime($_SESSION['init_time']);

	if($data_init<time()-60*60*2){
		echo 'data_init: '.$data_init.'</br>';
		echo 'data_init_conv: '.date("m/d/Y H:i:s",$data_init);
		echo 'time: '.time().'</br>';
		echo 'time_conv: '.date("m/d/Y H:i:s",time());
		session_destroy();
		die("SESSION EXPIRED </br><a href=\"/account.php\">Account</a></br>");
	}
//	echo date("m/d/Y h:i:s", $data_init);
//	echo time().'</br>';
//	echo $data_init.'</br>';
}else{
	session_destroy();
	die ("No cookie? not logged in".'</br><a href="index.php">Main</a></br>');
}

//isset($_SESSION['hash2']) ?: die ("Not logged in");

if(!$_SERVER['HTTP_USER_AGENT']==$_SESSION['agent'])
{
	session_destroy();
	die ("Hijack");
}  

//var_dump($_SESSION);
//echo date("m/d/Y h:i:s");
//retrieve info
 */

require_once "../configs/config.php";

//$pass= $_SESSION['hash2'];
/*$pass= $_COOKIE['hash2'];
$method = "AES-256-ECB";

$decrypted_imap_pass=openssl_decrypt($_SESSION['encr_pass'], $method, $pass);
 */

$decrypted_imap_pass=ImapCred();


/*
if(isset($_COOKIE["cook"])){
echo "<p>cookie: ".$_COOKIE["cook"]."</p>";
}
 */

//echo "IMAP_HOST: <input type='text' value=".Config::IMAP_HOST."></br>";
echo "IMAP_HOST: <input type='text' value=".$_SESSION['IMAP_HOST']."></br>";
//echo "IMAP_PORT: <input type='text' value=".Config::IMAP_PORT."></br>";
echo "IMAP_PORT: <input type='text' value=".$_SESSION['IMAP_PORT']."></br>";
//echo "SMTP_USER: <input type='text' value=".Config::SMTP_USER."></br>";
echo "IMAP_USER: <input type='text' value=".$_SESSION['IMAP_USER']."></br>";
echo "SMTP_PASSWORD: <input type='text' value='{$decrypted_imap_pass}'></br>";

echo "<input type='submit' name='subname' value='update'></br>";
?>
</form>

</br>
<a href="index.php">Main</a></br>

</body>
</html>
