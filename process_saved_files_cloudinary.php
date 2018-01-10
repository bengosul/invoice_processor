<?php
if(php_sapi_name()!="cli"){
	echo '<html><body bgcolor="#000000" text="white"><pre>';
}

require_once 'functions/general_functions.php';

session_start();
validate_session('Invalid session');

require_once 'functions/db_connection_pdo.php';
echo "Connected successfully";
insert_break();

require_once 'returncloudinarylist.php';		

		//only while testing
/*		$sql = "UPDATE {$dbname}.`processed_emails`
				SET parsed=0";
		$res=$conn->query($sql) or die($conn->error);
 */

// Check items that need processing, this query can be manipulated to only process some selection 
$sql = "SELECT * from {$dbname}.processed_emails WHERE parsed = 0 and attachments>0";

if (isset($_POST['repr'])){
echo "Reprocessing\n";
$sql = "SELECT * from {$dbname}.processed_emails WHERE id={$_POST['id_email']}";
			
}

$result = $conn->query($sql) or die(print_r($conn->errorInfo()['2']));
$result = $result->fetchAll(PDO::FETCH_ASSOC);

//if($result = $conn->query($sql))
if($result)
{
//$sql = "SELECT * from {$dbname}.processed_emails where parsed = 0 and attachments>0";

//maybe delete this first one if second works
$numrows = $conn->query($sql)->fetchColumn();
$numrows = count($result);

//    die ("SELECT COUNT(*) FROM {$dbname}.processed_emails where parsed = 0 and attachments>0");
	if($numrows==0){echo "No new emails"; insert_break(); exit();}
	$processedrow=1;
	
//	var_dump($result->fetchAll(PDO::FETCH_ASSOC));
	
	foreach($result as $row) {
//print_r($row);
		//retrieve config:
		$client_config=retrieve_config($row['from_address'],$conn);

		//mark email as processed - ! not good when one attachment is parsed and the other throws an error
		$sql = "UPDATE `{$dbname}`.`processed_emails`
				SET parsed =CURRENT_TIMESTAMP, partner = '".$client_config['partner']."'
				WHERE id =".$row['id'];
		echo "</br>line 79 sql: ". $sql;
        $res = $conn->query($sql) or die($conn->errorInfo);

		if(!isset($client_config)){
			echo "Processed row ".$processedrow." of ".$numrows ; insert_break(); 
			$processedrow++; 
			continue;}


		echo "For ".$row['from_address']." found Partner: ".$client_config['partner'];
		insert_break();
		//if ($client_config['partner']=='initial'){echo "config not found";continue;}
/*
		// Retrieve filenames that need processing;
	
		$filepattern= "../store/".sprintf('%06d',$row['id']);
		if (isset($_POST['repr'])){
		$filepattern= "../store/".sprintf('%06d',$row['id'])."_".sprintf('%02d',$_POST['id_attachment']);
		$filenames=glob("$filepattern*.*");
*/

// SOL1. GRAB THE FILENAME HERE AND EXTENSION AND COMPOSE THE URL
// SOL2. JUST RETRIEVE the matching array from cloudinary

    $cloudinaryEmailMatch=returnCloudinaryArray(sprintf('%06d',$row['id']), $_SESSION['username']);
    
		$processedfilename=1;
		foreach ($cloudinaryEmailMatch as $fileurl){
        
			$fileurl=$fileurl['url'];

            //DOWNLOAD AND DECRYPT TO fisier
            $downloadtofisier = httpPost("localhost/invoice_processor/downloadcloudinaryfile.php", array("cloudinary_url" => $fileurl,"fn"=>"doesnotmatter"));

			$extension = pathinfo($fileurl, PATHINFO_EXTENSION);
			$origStripFilename = substr(basename($fileurl, ".".$extension),15);
			
			//reset values
			$invoice_number ="";
			
			//check if it's PDF
			if (substr($fileurl,-3)=="pdf") {
				prepare_pdf('fisier');
                $origStripFilename=str_replace(".pdf",".txt",$origStripFilename);
//no longer applies				$fileurl=str_replace("/store/","/store/temp/",$fileurl);
				}


			echo "Processing row ".$processedrow." of ".$numrows."; file# ".$processedfilename." of ".count($cloudinaryEmailMatch).": ".$fileurl;

			//parse file
			$fh = fopen("fisier",'r');

			while ($line = fgets($fh)) {
				// <... Do your work with the line ...>
            //			 		echo("\n".$line);
			//					echo $client_config['inv_no_str']. $client_config['partner'];

				$pos=strpos($line, $client_config['inv_no_str']);
				if($pos===false) 
				{continue;}	
				else {
					$invoice_number= substr($line,$pos+strlen($client_config['inv_no_str']),strlen($line)-strlen($client_config['inv_no_str'])-1) ;
					//		$inv_no_str= preg_replace("/\r\n|\r|\n/", ' ', $inv_no_str);
					//					insert_break();
					//		echo "futere:". strlen($line);	

					break;							
				}
			}
			fclose($fh);
		
			//Update retrieved data
			if(strlen($invoice_number)<100){
				//echo "inv no length: ".strlen($inv_no_str);
/*				$sql = "UPDATE `emails`.`processed_emails`
						SET parsed =CURRENT_TIMESTAMP,
						invoice_number='$inv_no_str' 
							WHERE id =".$row['id'];
				//echo "line 79 sql: ". $sql;
*/
/*
				$sql = "SELECT * FROM `{$dbname}`.`processed_attachments`
						WHERE id_email =".$row['id']."
						AND id_attachment =".$processedfilename;
				$res=$conn->query($sql) or die($conn->error);
                die(print_r($res->fetch(PDO::FETCH_ASSOC)));    
*/
				$sql = "DELETE FROM `{$dbname}`.`processed_attachments`
						WHERE id_email =".$row['id']."
						AND id_attachment =".$processedfilename;
			
				$res=$conn->query($sql) or die($conn->error);

				$sql = "INSERT `{$dbname}`.`processed_attachments` (id_email, id_attachment, invoice_number, fn, extension)
						VALUES (".$row['id'].",".$processedfilename.",'$invoice_number','$origStripFilename','$extension')";
			
				$res=$conn->query($sql) or die($conn->error);
				insert_break();
				echo "updated";
				insert_break(); insert_break();
			}
			else {
				insert_break();
				echo "inv_no_str parse fail";
				//add this message to the table too
				insert_break();
			}
			

            //ENCRYPT AND SAVE PROCESSED FILE TO CLOUDINARY
			$unencryptedAtt=file_get_contents('fisier');
				
            //encrypt contents before uploading to cloudinary
			$pass = 'inv';
            $method = "AES-256-ECB";
            $encrypted=openssl_encrypt($unencryptedAtt, $method, $pass);
            file_put_contents('fisier',$encrypted);

            //upload to cloudinary to user_processed folder
            $res = \Cloudinary\Uploader::upload('fisier', array("unique_filename"=>FALSE,"public_id"=>'file_'.$origStripFilename,"folder"=>$_SESSION['username']."_processed","resource_type"=>"auto"));
			
			
			$processedfilename++;
		}
		$processedrow++;
	}

//	$conn->close();
}
else {echo "nothing new";}

//
//FUNCTIONS
//

function retrieve_config($from_address,$connection){
    global $dbname;
	$array = array(
			"from_address"=> "",
			"partner"=> "initial",
			"inv_no_str" => ""
			);
//echo $from_address;
	$sql = "SELECT * from {$dbname}.match_config WHERE email ='$from_address'";
//echo $sql;
	insert_break();
	if($result_config = $connection->query($sql)->fetch(PDO::FETCH_ASSOC) )
	{
//print_r($result_config);
//$x="SELECT COUNT(*) FROM {$dbname}.match_config WHERE email ='$from_address'";

        $numrows_config = $connection->query("SELECT COUNT(*) FROM {$dbname}.match_config WHERE email ='$from_address'")->fetchColumn();
//echo $numrows_config;
		if($numrows_config==0){echo "Partner not found for: ".$from_address ;insert_break();return;}
		
		echo "found something in config for partnerid : ".$result_config['partner'];
//print_r($result_config);		
		$array['partner']=$result_config['partner'];
		$array['inv_no_str']=$result_config['inv_no_str'];
	}
	else {
		echo $connection->error; 
	}

	return $array;
}


//THIS NEEDS REBUILT
function prepare_pdf($fn){
	echo "Preparing PDF ".$fn;
	insert_break();
	echo exec("qpdf --decrypt \"".$fn."\"  \"" .str_replace(".pdf",".pdf", str_replace("/store/","/store/temp/",$fn)) . "\""  );
echo " Now converting to text ";
	echo exec("pdftotext \"".str_replace("/store/","/store/temp/",$fn)."\"  \"" .str_replace(".pdf",".txt", str_replace("/store/","/store/temp/",$fn)) . "\""  );
	}

//$conn->close();

if (isset($_POST['repr'])){
    die();
	session_start();
	$_SESSION['post_data'] = $_POST;
	header('Location: results.php');
}
?>