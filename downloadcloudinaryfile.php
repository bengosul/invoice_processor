<?php 


$url=$_POST['cloudinary_url'];
$fn=$_POST['fn'];

// echo "URL: ".$url."  Filenmame: ".$fn."  ";


$page=file_get_contents($url);
$pass = 'inv';
$method = "AES-256-ECB";
$decrypted=openssl_decrypt($page, $method, $pass);
file_put_contents('fisier',$decrypted);

is_null(error_get_last())?:die(var_dump(error_get_last()));

if($_POST['purpose']='download'){
    header('Content-Disposition: attachment; filename="'.$fn.'"');
    readfile('fisier');
}

?>
