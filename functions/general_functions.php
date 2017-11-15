<?php

function insert_break(){	
	if(PHP_SAPI!='cli'){$brstr= "<br>";}else{$brstr= "\n";}
echo $brstr;
}


function GetCredentials($srv='encr_pass'){
	// supposed to prevent cookie hijack
	 isset($_COOKIE['hash2']) ?: invalidate_session('Suspicious activity');

	$pass= $_COOKIE['hash2'];
	$method = "AES-256-ECB";
	$decrypted_pass=openssl_decrypt($_SESSION[$srv], $method, $pass);
//die ($decrypted_pass);
	return $decrypted_pass;
}

function valid_session(){
	if(array_key_exists('init_time', $_SESSION) && strtotime($_SESSION['init_time'])>time()-60*60*2 && $_SERVER['HTTP_USER_AGENT']==$_SESSION['agent']){		
		if(strtotime($_SESSION['refresh_time'])<time()-20) {	
			session_regenerate_id();
			$_SESSION["refresh_time"]=date("m/d/Y H:i:s");
		}
		return true;
	}
	else {
		return false;	
		//die('auth failed </br><a href=index.php>Main</a></br>');
	}
}

function invalidate_session($message=null){
	setcookie("hash2",'xxx',time()-60*60*24*365*30);
	setcookie("hash2",'xxx',time()-60*60*24*365*30,'/');
	session_destroy();
	session_start();
	session_regenerate_id();
	$_SESSION["message"]=$message;
	header("Location: "."/invoice_processor/account.php");
	exit;
}

function validate_session($message=null){
	if (valid_session()==true){
		//echo "<p>Logged in as: {$_SESSION['username']}</p></br>";
		return true; }
	else{invalidate_session($message);}
}

?>
