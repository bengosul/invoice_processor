<?php
//check that arrival here was with post
if (!isset($_POST["pass"])) {
//	echo "no post, redirecting back";
die(print_r($_POST));
	header("Location: "."login.php");
}

//file to store login info
$fileName="passfile.dat";
//check what's in the file, row by row
$existingArray = [];
if (file_exists(__dir__."/".$fileName)){
	foreach(file(__dir__."/".$fileName) as $line){
		array_push($existingArray ,unserialize($line));
	}
}
//print_r ($existingArray);

//check if matching
foreach ($existingArray as $item){
	if(password_verify($_POST["pass"],$item["password"]))	{
		echo "Aliluia\n"; // return 1;
		setcookie("cook",$item["password"],time()+30);
		header("Location: "."server_config.php");
		return;	
	}
}
//redirect back if not found
header("Location: "."login.php");

/*
//new credentials
$user = [];
$user["login"]="utilizator";
$passhash=password_hash("password", PASSWORD_DEFAULT, ["cost" => 10]);
$user["password"]=$passhash;
//make them an array object and write to file
$ser = serialize($user)."\n";
file_put_contents($fileName, $ser, FILE_APPEND);
*/

?>
