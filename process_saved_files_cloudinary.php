<?php
if(php_sapi_name()!="cli"){
	echo '<html><body bgcolor="#000000" text="white"><pre>';
}

require_once 'pdfparser/vendor/autoload.php';

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

        $workingFN = 'fisier';
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
            
            $origFilename=basename($fileurl['public_id']);
			$fileurl=$fileurl['url'];

            //DOWNLOAD AND DECRYPT TO fisier
            $downloadtofisier = httpPost("localhost/invoice_processor/downloadcloudinaryfile.php", array("cloudinary_url" => $fileurl,"fn"=>"doesnotmatter"));

			$extension = pathinfo($fileurl, PATHINFO_EXTENSION);
			$origStripFilename = substr(basename($fileurl, ".".$extension),15);
	
	
			//check if it's PDF
			if (substr($fileurl,-3)=="pdf") {
				prepare_pdf($workingFN);
                $origFilename=str_replace(".pdf",".txt",$origFilename);
                $workingFN = $workingFN.'.txt';
//no longer applies				$fileurl=str_replace("/store/","/store/temp/",$fileurl);
				}


			echo "Processing row ".$processedrow." of ".$numrows."; file# ".$processedfilename." of ".count($cloudinaryEmailMatch).": ".$fileurl;

			//parse file
			$fh = fopen($workingFN,'r');


			//reset values
			$invoice_number ="";
			$invoice_date ="";
			
            $til_invno=$client_config['inv_no_row_offset'];
            $til_invno_on=false;
            $til_invdate=$client_config['inv_date_row_offset'];
            $til_invdate_on=false;

            $i = 0;
            
echo "\nINVNOSTR: ".$client_config['inv_no_str'];
echo "\nINVDATESTR: ".$client_config['inv_date_str'];
           
			while ($line = fgets($fh)) {
                $i++; echo "\n\nLine ".($i)." : ".$line;
				$pos_invno=strpos($line, $client_config['inv_no_str']);
				$pos_invdate=strpos($line, $client_config['inv_date_str']);

                echo "POSINVNO: ". $pos_invno;
                echo "POSINVDT: ". $pos_invdate;
                
                //if match found
			    if($pos_invno!==false) {
			        echo "inv match found\n";
			        //if on the right row
			        if($til_invno==0){
			            echo "row not yet: {$til_invno}"."\n";
			            //if there was no row hunting in place
                        if($til_invno_on==false){
                            echo "updating invno no hunting \n";
                            $invoice_number= substr($line,$pos_invno+strlen($client_config['inv_no_str']),strlen($line)-strlen($client_config['inv_no_str'])-1);
                            }
                        }
                    //match found but now row hunting
			        else {
			            echo "invno row hunt set\n";
                        $til_invno_on=true;
                        }
                    }
                else{
                    //match not found, checking if it was previously found
                    echo "\ninvno match not found, checking if previously found";
                    if($til_invno_on==true){
                        echo "\nprev found indeed";
                        $til_invno=$til_invno-1;
                        if($til_invno==0){
                            echo "\nupdating invno with hunting";
                            $invoice_number=explode(' ',$line)[0];
                        }
                    }
                }

                //if match found
			    if($pos_invdate!==false) {
                    echo "date match found\n";
                    //if on the right row
			        if($til_invdate==0){
			            echo "date row not yet\n";			            
			            //if there was no row hunting in place
                        if($til_invdate_on==false){
                            echo "\nupdating date no hunting \n";                            
                            $invoice_date= substr($line,$pos_invdate+strlen($client_config['inv_date_str']),strlen($line)-strlen($client_config['inv_date_str'])-1);
                            }
                        }
                    //match found but now row hunting
			        else {
			            echo "date row hunt set\n";			            
                        $til_invdate_on=true;
                        }
                    }
                else{
                    //match not found, checking if it was previously found
                    echo "\ninvdate match not found, checking if previously found";
                    if($til_invdate_on==true){
                        $til_invdate=$til_invdate-1;
                        if($til_invdate==0){
                            echo "\nupdating invdate with hunting";
                            $invoice_date=explode(' ',$line)[0];
                        }
                    }
                }
                    

                //if all is found break loop
                if($invoice_number and $invoice_date){
                    echo "\nINVNO: ".$invoice_number ." INVDATE: ".$invoice_date;
                    echo "\nBREAKING\n";
                    break;}

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

				$sql = "INSERT `{$dbname}`.`processed_attachments` (id_email, id_attachment, invoice_date, invoice_number, fn, extension)
						VALUES (".$row['id'].",".$processedfilename.",'".date('Y-m-d',strtotime($invoice_date))."','$invoice_number','$origStripFilename','$extension')";
			echo '\n\n'.$sql;
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
			$unencryptedAtt=file_get_contents($workingFN);
				
            //encrypt contents before uploading to cloudinary
			$pass = 'inv';
            $method = "AES-256-ECB";
            $encrypted=openssl_encrypt($unencryptedAtt, $method, $pass);
            file_put_contents($workingFN,$encrypted);

            //upload to cloudinary to user_processed folder
            //need to catch error here !
            $res = \Cloudinary\Uploader::upload($workingFN, array("unique_filename"=>FALSE,"public_id"=>$origFilename,"folder"=>$_SESSION['username']."_processed","resource_type"=>"auto"));
			
			
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
    /*
	$array = array(
			"from_address"=> "",
			"partner"=> "initial",
			"inv_no_str" => ""
			);
			*/
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
//		$array['partner']=$result_config['partner'];
//		$array['inv_no_str']=$result_config['inv_no_str'];

        $array = $result_config;
		
	}
	else {
		echo $connection->error; 
	}

	return $array;
}


function prepare_pdf($fn){
    
    //need to catch some errors here !
   
   $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($fn);
     
    $text = $pdf->getText();
  
	echo "Preparing PDF ".$fn;
	insert_break();
//	echo exec("qpdf --decrypt \"".$fn."\"  \"" .str_replace(".pdf",".pdf", str_replace("/store/","/store/temp/",$fn)) . "\""  );
    echo " Now converting to text ";
//	echo exec("pdftotext \"".str_replace("/store/","/store/temp/",$fn)."\"  \"" .str_replace(".pdf",".txt", str_replace("/store/","/store/temp/",$fn)) . "\""  );
    file_put_contents($fn.'.txt',$text);
	}


//UNUSED THIS NEEDS REBUILT
function prepare_pdf_linux($fn){
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