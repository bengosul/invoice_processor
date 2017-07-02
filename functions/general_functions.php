<?php

function insert_break(){	
	if(PHP_SAPI!='cli'){$brstr= "<br>";}else{$brstr= "\n";}
	echo $brstr;
}


function ImapCred(){
	$pass= $_SESSION['hash2'];
	$method = "AES-256-ECB";
	$decrypted_imap_pass=openssl_decrypt($_SESSION['encr_pass'], $method, $pass);
	return $decrypted_imap_pass;
}


?>
