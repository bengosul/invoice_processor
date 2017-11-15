
<?php
/**
 *  * This code will benchmark your server to determine how high of a cost you can
 *   * afford. You want to set the highest cost that you can without slowing down
 *    * you server too much. 8-10 is a good baseline, and more is good if your servers
 *     * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
 *      * which is a good baseline for systems handling interactive logins.
 *       */
$timeTarget = 0.200; // 50 milliseconds 

$cost = 8;
do {
	    $cost++;
		    $start = microtime(true);
		   $result= password_hash("test", PASSWORD_DEFAULT, ["cost" => $cost]);
			    $end = microtime(true);

		echo $end - $start." for ".$result."\n";
		if (password_verify('test', $result)) {
			    echo 'Password is valid!';
		} else {
			    echo 'Invalid password.';
		}

} while (($end - $start) < $timeTarget);


echo "Appropriate Cost Found: " . $cost . "\n";
?>
