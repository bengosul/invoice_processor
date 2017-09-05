<html>
<body>

<?php
session_start();
//TROUBLESHOOT SESSION
//var_dump( preg_grep("/^sess_/", scandir(ini_get("session.save_path"))) );
//echo ini_get("session.save_path");
//echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
//var_dump($_SESSION);
if (isset($_POST['logout'])) {
	session_regenerate_id();
	session_destroy();
	setcookie("hash2",null,time()-60*60*24*365*30);
	header("Location: "."account.php");
	exit;
}
//VALIDATE AUTH
if($_SESSION['init_time'] && strtotime($_SESSION['init_time'])>time()-60*60*2 && $_SERVER['HTTP_USER_AGENT']==$_SESSION['agent']){
	//if (isset($_SESSION["hash2"])){
//	echo 'init: '.strtotime($_SESSION['init_time']);
//	echo '</br> time: ';
	if(strtotime($_SESSION['refresh_time'])<time()-20) {
	   	session_regenerate_id();
		$_SESSION["refresh_time"]=date("m/d/Y H:i:s");
	}
	
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


	echo "<form action = 'pass_manager_sqlite_cookie.php' method='post'>\n";
	echo "Username: <input type='text' name='username' value='admin'></br>\n";
	echo "Password: <input type='password' name='password' autofocus></br>\n";
	echo "<input type='submit' value = 'Login'>\n";
	echo "</form>";
}
?>
<a href="index.php">Main</a></br>
</body>
</html>
