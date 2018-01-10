<?php
session_start();
require_once 'functions/general_functions.php';
validate_session('Invalid session');

//WTF is this?!

if (isset($_SESSION['post_data'])) {
	$_POST = $_SESSION['post_data'];
    $_SERVER['REQUEST_METHOD'] = 'POST';
    unset($_SESSION['post_data']);
}

require_once 'functions/return_processed_emails_array.php';
?>


<html> 

<head>
<meta charset="utf-8" />
<title></title>
<script src="//code.jquery.com/jquery-2.0.3.min.js" data-semver="2.0.3" data-require="jquery"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables_themeroller.css" rel="stylesheet" data-semver="1.9.4" data-require="datatables@*" />
<link href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.css" rel="stylesheet" data-semver="1.9.4" data-require="datatables@*" />
<link href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/demo_table_jui.css" rel="stylesheet" data-semver="1.9.4" data-require="datatables@*" />
<link href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/demo_table.css" rel="stylesheet" data-semver="1.9.4" data-require="datatables@*" />
<link href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/demo_page.css" rel="stylesheet" data-semver="1.9.4" data-require="datatables@*" />
<link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
<script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.js" data-semver="1.9.4" data-require="datatables@*"></script>
<link href="style.css" rel="stylesheet" />
<script src="results.js"></script>
</head>

<!-- <body style="text:cyan; bgcolor:black"> -->
<body bgcolor="#000000" text="wheat">

<p>
<?php
echo "session id:  " .session_id();
?>

</p>
<a style="float:left;" href="config_angular/configs.php"> To Config Page</a>

<button id="btnExport" style="float:right;">Export</button></br></br>

<div id="success_filter" style="float:right;">Successful: 
 <select id="success_filter_value">
  <option value=true>Yes</option>
  <option value=false>No</option>
  <option selected value=all>All</option>
</select> 
</div>

<div id="date_filter" style="float:right;">
<span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
<span id="date-label-to" class="date-label">To: </span><input class="date_range_filter date" type="text" id="datepicker_to" />
</div>


<table width="100%" class="display" id="datatable">
	<thead>
		<tr>
			<th width = "170">Processed</th>
			<th width = "170">Sent</th>
			<th style='display:none;'>Success</th>
			<th>Partner</th>
			<th>Amount</th>
			<th>InvNo</th>
			<th>InvDate</th>
			<th>Orig</th>	
			<th>Txt</th>
			<th>Repr</th>
	</tr>
	</thead>
	<tbody>

<?php


$storelocation="/store/";

//MYSQLI
//	while($row = $result->fetch_assoc()) {
//PDO with MySQL
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		//		        echo "id: " . $row["id"]. " Subject: " . $row["subject"]. "<br>";

	//	print_r($row);
		$sql = "SELECT *, a.id as aid
			from {$dbname}.processed_attachments p
			left join {$dbname}.accounts a
			on '{$row['partner']}'=a.id
			WHERE id_email={$row['id']}";

		echo $sql;

		$result_att = $conn->query($sql);
		
//MYSQLI
//	while($row_att=$result_att->fetch_assoc()){
//PDO with MySQL	
	while($row_att=$result_att->fetch(PDO::FETCH_ASSOC)) {

		$filename_orig=$storelocation.sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".".$row_att['extension'];
        $filename_orig='http://res.cloudinary.com/hiuo9fkio/raw/upload/v1513359568/'.$_SESSION['username'].'/file_'.
                        sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).
                        '_'.$row_att['fn'].".".$row_att['extension'];
//die ($filename_orig);
		$filename_txt=$storelocation."temp/".sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".txt";
		$dlname_orig=$row_att['accname']."_".sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".".$row_att['extension'];
//		echo "\nrowdmp: ".	 var_dump($row);
		echo "<tr>
				<td>{$row['parsed']}</td>
				<td>{$row['received']}</td>
				<td style='display:none;'>";
if ($row_att['invoice_number']) {echo true;} else {echo false;} echo "</td>
				<td>{$row_att['accname']}</td>
				<td>{$row_att['invoice_amount']}</td>
				<td>{$row_att['invoice_number']}</td>
				<td>{$row_att['invoice_date']}</td>
".
/*				<td><a download='{$dlname_orig}' href='{$filename_orig}'>Download</a></td>

	         	<td>
				<form target=\"_blank\" style=\"display:inline\" name=\"f2\" action=\"returncloudinaryfile.php\" method=\"post\" >
						<input type=\"hidden\" value=\"{$row_att['url']}\" name=\"cloudarity_url\">
						<input type=\"hidden\" value=\"{$row_att['fn']}\" name=\"fn\">
						<input  style=\"width:100%;height:100%;padding-bottom:0px\" id=\"repr\" type=\"submit\" name=\"repr\" value=\"Download\" />
					 </form>
				</td>

*/
"

	         	<td>
				<form target=\"_blank\" style=\"display:inline\" name=\"f2\" action=\"downloadcloudinaryfile.php\" method=\"post\" >
						<input type=\"hidden\" value=\"{$filename_orig}\" name=\"cloudinary_url\">
						<input type=\"hidden\" value=\"{$dlname_orig}\" name=\"fn\">
						<input  style=\"width:100%;height:100%;padding-bottom:0px\" id=\"repr\" type=\"submit\" name=\"repr\" value=\"Download\" />
					 </form>
				</td>



				<td><a href='{$filename_txt}'>Download</a></td>
	         	<td>
				<form style=\"display:inline\" name=\"f2\" action=\"process_saved_files_cloudinary.php\" method=\"post\" >
						<input type=\"hidden\" value=\"{$row_att['id_email']}\" name=\"id_email\">
						<input type=\"hidden\" value=\"{$row_att['id_attachment']}\" name=\"id_attachment\">
						<input type=\"hidden\" value=\"download\" name=\"purpose\">						
						<input  style=\"width:100%;height:100%;padding-bottom:0px\" id=\"repr\" type=\"submit\" name=\"repr\" value=\"Rerun\" />
					 </form>
				</td>
	
	
				</tr>";
		}
	}
?>
	</tbody>
</table>

</br><a href="index.php">Main Page</a></br>

</body>

</html>

