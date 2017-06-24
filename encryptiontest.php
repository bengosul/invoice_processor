<?php

$texttoencrypt="parolaimap";

$pass = "pass";


$method = "AES-256-ECB";


$encrypted=openssl_encrypt($texttoencrypt, $method, $pass);

echo $encrypted;

$decrypted=openssl_decrypt($encrypted, $method, $pass);

echo $decrypted;

?>
