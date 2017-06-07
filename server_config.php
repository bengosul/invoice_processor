<?php
require_once "../configs/config.php";


?>
<html>
<body bgcolor="#000000" text="#8888FF">
<form action="server_config.php" method = "post"> 
<?php

echo "IMAP_HOST: <input type='text' value=".Config::IMAP_HOST."></br>";
echo "IMAP_PORT: <input type='text' value=".Config::IMAP_PORT."></br>";
echo "SMTP_USER: <input type='text' value=".Config::SMTP_USER."></br>";
echo "SMTP_PASSWORD: <input type='text' value=''></br>";

echo "<input type='submit' value='update'></br>";
?>

</form>
</body>
</html>
