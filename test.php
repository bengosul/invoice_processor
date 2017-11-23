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

$res = \Cloudinary\Uploader::upload('http://domaingang.com/wp-content/uploads/2012/02/example.png');

var_dump($res);

?>
