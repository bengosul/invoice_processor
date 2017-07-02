<?php
// General database query
function dbQuery($sql)
{
	// set PDO for SQLite
	$db = new PDO("sqlite:db/emails.sqlite3");
	// set the params to query
	$params = ['id', 'account'];

	// query the database using the sql from the parameter
	foreach($db->query($sql) as $row)
	{
		// loop through the parameters given in the function
		// to only get those with the right key
/*		foreach($params as $param)
		{
			$objectParams[$param] = $row[$param];
		}
		// store the object params in an objects array
		$objects[] = $objectParams;
 */		// clear out the params array for next loop
		$objects[] = $row;

	 $objectParams = null;
	}
 	
//	$objects[]=$db->query($sql);


	$db = null;

	return $objects;
}

function getAllAccounts()
{
	    $sql = "SELECT * FROM accounts";
		    $accts = dbQuery($sql);
		    return $accts;
}

$accts=getAllAccounts();
var_dump($accts);

?>
