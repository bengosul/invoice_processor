<?php
$username=$argv[1];
$password=$argv[2];
$salt2='saremarededouazeciplus';
$imap_pass=$argv[3];

//hash and encrypt
$passhash=password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);

$hash2 = password_hash($password, PASSWORD_DEFAULT, [ "cost" => 10, "salt"=> $salt2 ]);
$method = "AES-256-ECB";
$imap_pass_enc=openssl_encrypt($imap_pass, $method, $hash2);


function selectFromSqlite (){
	$db = new SQLite3('db/emails.sqlite3');

	$result = $db->query('select * from accounts');

	while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
		echo "ID = ". $row['id'] . "\n";
		echo "NAME = ".$row['accname'] ."\n\n";
	}
}


function insertIntoSqlite (){
	$db = new SQLite3('db/emails.sqlite3');
	$sql= "insert into logins values ('','".$GLOBALS['username']."','".$GLOBALS['passhash']."','".$GLOBALS['salt2']."','".$GLOBALS['imap_pass_enc']."')";
	echo $sql;
	$result = $db->exec($sql);
}

//insertIntoSqlite();

echo $hash2;

?>
