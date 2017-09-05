<?php
error_reporting(E_ERROR);
if(php_sapi_name()!="cli"){
echo '<html><body bgcolor="#000000" text="white"><pre>';
}

require_once 'functions/general_functions.php';
session_start();
validate_session('Invalid session');
require_once '../configs/config.php';

echo "<a href='index.php'>Main Page</a>";
insert_break();

// Setup default values
$subject = "test";
$received = "2017-03-25";
$attachments = "";
$partner = "";
$from_address="";
$invoice_date = "";
$invoice_amount = "";
$invoice_number ="";

// Begin reading emails	
require_once 'inbox_class.php';

$email_object = New Email_reader();

//list folders
$folders=imap_list($email_object->conn, "{".config::IMAP_HOST."/ssl}","*");
echo "<div class='column' style='width:300px; float:left;'>";
echo "Listing Folders:"; insert_break();
print_r($folders); insert_break();
echo "</div>";

$box="INBOX";
if(isset($_GET["box"]) && $_GET["box"]!==""){
$box = $_GET["box"];
}
?>

<div class='column' style='width:300px; float:right;'>
<form>
Check specific folder:
<input type="text" name="box" value="<?php echo $box;?>"></br>
<input type="submit" name="check" value="check">
</form>
</div>

<?php
echo "<div style='clear:both;'><hr>";
echo "<h3>Checking Folder: ".$box."</h3>"; 

$email_object->change_folder($box);
$inbox_array=$email_object->output();
echo "<h3>Found ".count($inbox_array). " new emails</h3>"; insert_break();

foreach ($inbox_array as $email){
	insert_break();	echo "adding"; insert_break();
	$subj= $email["index"].$email["header"]->subject;
	$from_name= $email["header"]->fromaddress;
	$from_address = $email['header']->from[0]->mailbox."@".$email['header']->from[0]->host;
//	$received= $email["index"].$email["header"]->date;
	$received= $email["header"]->date;
	$received= date('Y-m-d H:i:s',strtotime($received));

	// print_r($value["structure"]);
	$subject= iconv_mime_decode($subj,0,"UTF-8");
//	$subject=mysqli_real_escape_string($conn, $subject);
	$count=0;

	//Insert email data to retrieve index
	$sql = "INSERT into `emails`.`processed_emails`(subject, received, attachments, partner, from_address,parsed)
		VALUES ('$subject','$received','$attachments','$partner','$from_address','$invoice_date')";

echo $sql;
	echo  count($email['structure']->parts);
/*

			// if this attachment has ifparameters, then proceed as above
			if ($email['structure']->parts[$i]->ifparameters) {
				foreach ($email['structure']->parts[$i]->parameters as $object) {
					if (strtolower($object->attribute) == 'name') {
						$attachments[$i]['is_attachment'] = TRUE;
						$attachments[$i]['name']          = $object->value;
					}
				}
			}

			// if we found a valid attachment for this 'part' of the email, process the attachment
			if ($attachments[$i]['is_attachment']) {
				$count++;


				// get the content of the attachment
				$attachments[$i]['attachment'] = imap_fetchbody($email_object->conn, $email['index'], $i+1);

				// check if this is base64 encoding
				if ($email['structure']->parts[$i]->encoding == 3) { // 3 = BASE64
					$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
				}
				// otherwise, check if this is "quoted-printable" format
				elseif ($email['structure']->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
					$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
				}

				echo	"</br>insertid: ".$conn->insert_id;
//				print_r($attachments[$i]);
				file_put_contents("../store/".sprintf('%06d',$conn->insert_id)."_".sprintf('%02d',$count)."_".$attachments[$i]['filename'], $attachments[$i]['attachment']);
				// echo	mkdir("/store/xxx2");	
			}
		}
	}
 
	//print_r($attachments);
	$attachments=$count;
	//Insert email data to retrieve index
	$sql = "UPDATE `emails`.`processed_emails`
		SET attachments = $attachments
		WHERE id = $conn->insert_id";
	$result=$conn->query($sql) or die($conn->error);


	// move the email to Processed folder on the server
	$r=@imap_createmailbox($email_object->conn, imap_utf7_encode("{".config::IMAP_HOST."}Processed"));
	//	echo "</br>".$r."</br>"	 ; 
	//	print_r(imap_list($email_object->conn,"{".config::IMAP_HOST."}","*"));
	//	  $email_object->move($email['index'],"Processed");
	$email_object->move(1,"Processed");
 */

}
// $conn->close();

?>
