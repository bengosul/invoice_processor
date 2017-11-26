<?php

//$ch=curl_init('http://goo.gl/yp6VAe');
//$ch=curl_init('http://res.cloudinary.com/hiuo9fkio/image/upload/v1511536359/admin/example_wgimfq.png');
//curl_exec($ch);

require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Cloudinary.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Uploader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Api.php';
require_once "functions/general_functions.php";
session_start();

//file_get_contents('http://goo.gl/yp6VAe');
//header('Content-Disposition: attachment; filename="caca.png"');
//readfile('goo.gl/oMeP1B');

Cloudinary::config(array(
	"cloud_name" 	=> $_SESSION["cloudinary_name"],
	"api_key"	=> $_SESSION["cloudinary_api_key"],
	"api_secret" => GetCredentials('cloudinary_secret_encr')

));

$api = new \Cloudinary\Api();
$resources = ((array) $api->resources(["type" => "upload", "prefix" => "admin"])['resources']);
echo "<pre>";
foreach ($resources as $resource) {
//echo $resource['public_id']."</br>";
var_dump($resource);
//echo cl_image_tag($resource['public_id']);
}


?>


