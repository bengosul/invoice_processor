<?php

function insert_break(){	
	if(PHP_SAPI!='cli'){$brstr= "<br>";}else{$brstr= "\n";}
echo $brstr;
}


function ImapCred(){
	$pass= $_COOKIE['hash2'];
	$method = "AES-256-ECB";
	$decrypted_imap_pass=openssl_decrypt($_SESSION['encr_pass'], $method, $pass);
	return $decrypted_imap_pass;
}

function valid_session(){
	if($_SESSION['init_time'] && strtotime($_SESSION['init_time'])>time()-60*60*2 && $_SERVER['HTTP_USER_AGENT']==$_SESSION['agent']){		
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
	session_destroy();
	setcookie("hash2",null,time()-60*60*24*365*30);
	session_start();
	session_regenerate_id();
	$_SESSION["message"]=$message;
	header("Location: "."/invoice_processor/account.php");
	exit;
}

function validate_session($message=null){
	if (valid_session()==true){return true; }
	else{invalidate_session($message);}
}

?>
