<html>
<body bgcolor="#000000" text="#8888FF">

<?php

require_once "functions/general_functions.php";

session_start();

//die (var_dump($_SESSION));

validate_session('Invalid session');
require_once "config.php";


$decrypted_imap_pass=GetCredentials();

if(!isset($_POST['adduser'])){
	echo "<form action = 'add_user.php' method='post'>\n";
	echo "Username: <input type='text' name='username' value=''></br>\n";
	echo "Password: <input type='password' name='password' autofocus></br>\n";
	echo "<input type='submit' name='adduser' value = 'Add User'>\n";
	echo "</form>";
}
else{
$credentials=array();

$credentials['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
$credentials['username']=$_POST['username'];
$credentials['salt']="saremarededouazeciplus";

	$masterpass=$_POST['password'];
	$texttoencrypt=$_POST['password'];
	$salt2='saremarededouazeciplus';
	$hash2 = password_hash($masterpass, PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $salt2 ]);
	$pass = $hash2;
	$method = "AES-256-ECB";
	$encrypted=openssl_encrypt($texttoencrypt, $method, $pass);

$credentials["encrypted_imap_pass"]=$encrypted;

	$decrypted_mysql_pass=GetCredentials('encr_mysql_pass');
	$encrypted=openssl_encrypt($decrypted_mysql_pass, $method, $pass);

$credentials["encrypted_mysql_pass"]=$encrypted;
$credentials['cloudinary_name']="hiuo9fkio";
$credentials['cloudinary_api_key']="963173329168911";

	$decrypted_cloudinary_pass=GetCredentials('cloudinary_secret_encr');
	$encrypted=openssl_encrypt($decrypted_cloudinary_pass, $method, $pass);

$credentials["cloudinary_secret_encr"]=$encrypted;

//$decrypted=openssl_decrypt($encrypted, $method, $pass);

//$decrypted=openssl_decrypt('rzM3QGpWO9h9E2zuYpkLOA==', $method, $pass);

file_put_contents('db/passfile.dat',serialize($credentials).PHP_EOL,FILE_APPEND) ;

}
echo "IMAP_HOST: <input type='text' value=".$_SESSION['IMAP_HOST']."></br>";
echo "IMAP_PORT: <input type='text' value=".$_SESSION['IMAP_PORT']."></br>";
echo "IMAP_USER: <input type='text' value=".$_SESSION['IMAP_USER']."></br>";
echo "SMTP_PASSWORD: <input type='password' value='{$decrypted_imap_pass}'></br></br>";

echo "MYSQL_SERVER: <input type='text' value=".config::MYSQL_SERVER."></br>";
echo "MYSQL_USER: <input type='text' value=".config::MYSQL_USER."></br>";
echo "MYSQL_EMAILDB: <input type='text' value=".config::MYSQL_EMAILDB."></br>";
echo "MYSQL_PWD: <input type='text' value=".GetCredentials('encr_mysql_pass')."></br>";


echo "<input type='submit' name='subname' value='update'></br>";

//var_dump($_COOKIE);
var_dump($_SESSION);
?>
</form>

</br>
<a href="index.php">Main</a></br>

</body>
</html>
