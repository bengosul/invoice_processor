<html>
<body bgcolor="#000000" text="#8888FF">
<form action="server_config.php" method = "post"> 
<?php
require_once "../configs/config.php";
session_start();
isset($_SESSION['hash2']) ?: die ("Not logged in");

$pass= $_SESSION['hash2'];
$method = "AES-256-ECB";

$decrypted_imap_pass=openssl_decrypt($_SESSION['encr_pass'], $method, $pass);

/*
if(isset($_COOKIE["cook"])){
echo "<p>cookie: ".$_COOKIE["cook"]."</p>";
}
 */

echo "IMAP_HOST: <input type='text' value=".Config::IMAP_HOST."></br>";
echo "IMAP_PORT: <input type='text' value=".Config::IMAP_PORT."></br>";
echo "SMTP_USER: <input type='text' value=".Config::SMTP_USER."></br>";
echo "SMTP_PASSWORD: <input type='text' value='{$decrypted_imap_pass}'></br>";

echo "<input type='submit' name='subname' value='update'></br>";
?>
</form>

</br>
<a href="index.php">Main</a></br>

</body>
</html>
