<html>
<body bgcolor="#000000" text="#8888FF">
<form action="server_config.php" method = "post"> 

<?php

require_once "functions/general_functions.php";

session_start();

//die (var_dump($_SESSION));

validate_session('Invalid session');
require_once "config.php";

$decrypted_imap_pass=GetCredentials();
if(isset($_POST['subname'])){
require_once('functions/db_connection_pdo.php');
// de encryptat aici imap_pass

if(!$_POST['isnew']){
// de rezolvat cu id user
// de facut aici update
	$upd_query="INSERT {$dbname}.server_config (main, id_login, imap_host, imap_port, imap_user, imap_pass_encr) VALUES('1','','{$_POST['imap_host']}','{$_POST['imap_port']}','{$_POST['imap_user']}','{$_POST['imap_pass']}')";
}
else{
	$upd_query="INSERT {$dbname}.server_config (main, id_login, imap_host, imap_port, imap_user, imap_pass_encr) VALUES('1','1','{$_POST['imap_host']}','{$_POST['imap_port']}','{$_POST['imap_user']}','{$_POST['imap_pass']}')";

}


$result = $conn->prepare($upd_query);
$result->execute();

print("Return number of rows that were affected:\n");
$count = $result->rowCount();
print("Updated  $count rows.\n");

if (!$count) {
	echo "<html><body><script type='text/javascript'>".print_r($result->errorInfo())."alert('fuck thiss');</script></body></html>";
}

echo "</br>";
}


echo "<form action = 'server_config.php' method='post'>\n";
echo "<input type='hidden' name='isnew' value=".!isset($_SESSION['IMAP_HOST'])."></br>";
echo "IMAP_HOST: <input type='text' name='imap_host' value=".$_SESSION['IMAP_HOST']."></br>";
echo "IMAP_PORT: <input type='text' name='imap_port' value=".$_SESSION['IMAP_PORT']."></br>";
echo "IMAP_USER: <input type='text' name='imap_user' value=".$_SESSION['IMAP_USER']."></br>";
echo "SMTP_PASSWORD: <input type='password' name='imap_pass' value='{$decrypted_imap_pass}'></br></br>";

echo "MYSQL_SERVER: <input size=".strlen(trim(config::MYSQL_SERVER))." type='text' value=".config::MYSQL_SERVER." disabled></br>";
echo "MYSQL_USER: <input type='text' value=".config::MYSQL_USER." disabled></br>";
echo "MYSQL_EMAILDB: <input type='text' value=".config::MYSQL_EMAILDB." disabled></br>";
echo "MYSQL_PWD: <input type='text' value=".GetCredentials('encr_mysql_pass')." disabled></br></br>";

echo "Cloudinary_Name: <input type='text' value=".$_SESSION['cloudinary_name']." disabled></br>";
echo "Cloudinary_Key: <input type='text' value=".$_SESSION['cloudinary_api_key']." disabled></br>";
echo "Cloudinary_secret: <input size=".strlen(Getcredentials('cloudinary_secret_encr')) ." type='text' value=".GetCredentials('cloudinary_secret_encr')." disabled></br></br>";

echo "<input type='submit' name='subname' value='update'></br>";
echo "</form>";
//var_dump($_COOKIE);
var_dump($_SESSION);
?>
</form>

</br>
<a href="index.php">Main</a></br>

</body>
</html>
