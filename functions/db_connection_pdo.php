<?php 
session_id() ?: session_start();
require_once __DIR__.'/general_functions.php';
require_once __DIR__.'/../config.php';
/*
//require_once '../../configs/config.php';
function GetMysqlCredentials($srv='encr_mysql_pass'){
	// supposed to prevent cookie hijack
	isset($_COOKIE['hash2']) ?: invalidate_session('Suspicious activity');

	$pass= $_COOKIE['hash2'];
	$method = "AES-256-ECB";
	$decrypted_pass=openssl_decrypt($_SESSION[$srv], $method, $pass);
	return $decrypted_pass;
}
*/
$decrypted_mysql_pass=GetCredentials('encr_mysql_pass');
$password = $decrypted_mysql_pass;

$servername = config::MYSQL_SERVER;
$username = config::MYSQL_USER;
$dbname = config::MYSQL_EMAILDB;


// Create connection PDO MYSQL
//$conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
try {
	     $conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
} catch (PDOException $e) {
	     echo 'Connection failed with: server-'.$servername.' user-'.$username.' pass- dbname-'.$dbname.' ERROR:' . $e->getMessage();
} 
/*
// Check connection
if ($conn->errorInfo) {
//	die("Connection failed: " . $conn->connect_error);
	die("Connection failed: " . $conn->errorInfo);
} 
 */
?>
