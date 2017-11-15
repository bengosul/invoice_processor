<html>
<body>

<?php
session_start();
require_once "functions/general_functions.php";

//var_dump($_COOKIE);
//TROUBLESHOOT SESSION
//var_dump( preg_grep("/^sess_/", scandir(ini_get("session.save_path"))) );
//echo ini_get("session.save_path");
//echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
var_dump($_SESSION);
if (isset($_POST['logout'])) {
	invalidate_session('You have successfully logout');
}
//VALIDATE AUTH
if(valid_session()==true){

	echo "<p>You are logged in as ".$_SESSION["username"]." </p>\n";

	echo "<form action='account.php' method = 'post'>\n";
	echo "<input type='submit' name='logout' value='Log Out'></br>\n";
	echo "</form>\n";
//	echo "</body>\n";
//	echo "</html>\n";

//	exit;
}
elseif(!isset($_SESSION["hash2"])){
	echo isset($_SESSION["message"]) ? "<p style='color:red;'>{$_SESSION["message"]}</p><br>" : null ;
	unset($_SESSION['message']);

	echo "<form action = 'auth/pass_manager_pdo_cookie.php' method='post'>\n";
	echo "Username: <input type='text' name='username' value='admin'></br>\n";
	echo "Password: <input type='password' name='password' autofocus></br>\n";
	echo "<input type='submit' value = 'Login'>\n";
	echo "</form>";
}
else {echo 'wtf';}

?>
<a href="index.php">Main</a></br>
</body>
</html>
