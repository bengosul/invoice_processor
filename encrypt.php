<?php

//$texttoencrypt="parola";
$masterpass=$argv[1];
$texttoencrypt=$argv[2];

$salt2='saremarededouazeciplus';

$hash2 = password_hash($masterpass, PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $salt2 ]);
//$hash2 = password_hash($texttoencrypt, PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $salt2 ]);

$pass = $hash2;


$method = "AES-256-ECB";

$encrypted=openssl_encrypt($texttoencrypt, $method, $pass);

//echo $hash2."\n";
echo $encrypted."\n";
echo strlen($encrypted)."\n";

$decrypted=openssl_decrypt($encrypted, $method, $pass);

$decrypted=openssl_decrypt('rzM3QGpWO9h9E2zuYpkLOA==', $method, $pass);

//echo $decrypted."\n";

?>
