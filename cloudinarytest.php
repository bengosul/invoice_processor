<?php 

require_once __DIR__."/cloudinary/Config.php";

session_start();
var_dump($_SESSION);

insert_break();
	echo  GetCredentials('cloudinary_secret_encr');

//var_dump(phpinfo());

//$page=file_get_contents('http://goo.gl/yp6VAe');
$page=file_get_contents('http://lasmaderas.com/sites/default/files/images/events/8940995208_5da979c52f.jpg');
$pass = 'inv';
$method = "AES-256-ECB";
$encrypted=openssl_encrypt($page, $method, $pass);
file_put_contents('fisier',$encrypted);

//$res = \Cloudinary\Uploader::upload('http://domaingang.com/wp-content/uploads/2012/02/example.png', array("use_filename"=>TRUE,"folder"=>$_SESSION['username']));

echo '<pre>';
$res = \Cloudinary\Uploader::upload('fisier', array("use_filename"=>TRUE,"folder"=>$_SESSION['username'],"resource_type"=>"auto"));

var_dump($res); insert_break();

$page=file_get_contents($res['url']);
$decrypted=openssl_decrypt($page, $method, $pass);
file_put_contents('fisier',$decrypted);



$res = \Cloudinary\Uploader::upload('fisier', array("use_filename"=>TRUE,"folder"=>$_SESSION['username'],"resource_type"=>"auto"));

?>
