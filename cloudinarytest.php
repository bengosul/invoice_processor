<?php 

require_once "functions/general_functions.php";

require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Cloudinary.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Uploader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Api.php';

session_start();

var_dump($_SESSION);


Cloudinary::config(array(
	"cloud_name" 	=> $_SESSION["cloudarity_name"],
	"api_key"	=> $_SESSION["cloudarity_api_key"],
	"api_secret" => GetCredentials('cloudarity_secret_encr')

));

	echo  GetCredentials('cloudarity_secret_encr');

//var_dump(phpinfo());

$page=file_get_contents('http://goo.gl/yp6VAe');
$pass = 'inv';
$method = "AES-256-ECB";
$encrypted=openssl_encrypt($page, $method, $pass);
file_put_contents('fisier',$encrypted);

//$res = \Cloudinary\Uploader::upload('http://domaingang.com/wp-content/uploads/2012/02/example.png', array("use_filename"=>TRUE,"folder"=>$_SESSION['username']));

$res = \Cloudinary\Uploader::upload('fisier', array("use_filename"=>TRUE,"folder"=>$_SESSION['username'],"resource_type"=>"auto"));

var_dump($res);

$page=file_get_contents($res['url']);
$decrypted=openssl_decrypt($page, $method, $pass);
file_put_contents('fisier',$decrypted);



$res = \Cloudinary\Uploader::upload('fisier', array("use_filename"=>TRUE,"folder"=>$_SESSION['username'],"resource_type"=>"auto"));

?>
