<html>
<body>

<?php
session_start();
// var_dump($_SESSION);
if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: "."account.php");
	exit;
}

if (isset($_SESSION["hash2"])){
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


	echo "<form action = 'pass_manager_sqlite.php' method='post'>\n";
	echo "Username: <input type='text' name='username' value='admin'></br>\n";
	echo "Password: <input type='password' name='password' autofocus></br>\n";
	echo "<input type='submit' value = 'Login'>\n";
	echo "</form>";
}
?>
</body>
</html>
