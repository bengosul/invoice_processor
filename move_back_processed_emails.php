<?php

if(php_sapi_name()!="cli"){
echo '<html><body bgcolor="#000000" text="white"><pre>';
}

require_once 'functions/general_functions.php';
session_start();
validate_session('Invalid session');
require_once '../configs/config.php';
$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$password = config::MYSQL_PASS;

// Begin reading emails	
require_once 'inbox_class.php';

$email_object = New Email_reader();

$email_object->change_folder('Processed');
$inbox_array=$email_object->output();
echo "Found ".count($inbox_array). " new emails"; insert_break();
echo "<a href='maintenance.html'>Main Page</a>";

foreach ($inbox_array as $email){



	// move the email to Processed folder on the server
//	$r=@imap_createmailbox($email_object->conn, imap_utf7_encode("{".config::IMAP_HOST."}Processed"));
	//	echo "</br>".$r."</br>"	 ; 
	//	print_r(imap_list($email_object->conn,"{".config::IMAP_HOST."}","*"));
	//	  $email_object->move($email['index'],"Processed");
	$email_object->move(1,"INBOX");
}

?>
