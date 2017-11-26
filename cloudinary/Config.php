<?php

require_once __DIR__."/../functions/general_functions.php";

require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Cloudinary.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Uploader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/invoice_processor/cloudinary/Api.php';

session_start();


Cloudinary::config(array(
	"cloud_name" 	=> $_SESSION["cloudinary_name"],
	"api_key"	=> $_SESSION["cloudinary_api_key"],
	"api_secret" => GetCredentials('cloudinary_secret_encr')

));


?>