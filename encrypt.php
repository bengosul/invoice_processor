<?php

$texttoencrypt="parola";

$salt2='saremarededouazeciplus';
$hash2 = password_hash($texttoencrypt, PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $salt2 ]);
$pass = $hash2;


$method = "AES-256-ECB";

$encrypted=openssl_encrypt($texttoencrypt, $method, $pass);

echo $hash2."\n";
echo $encrypted."\n";

$decrypted=openssl_decrypt($encrypted, $method, $pass);

echo $decrypted."\n";

?>
