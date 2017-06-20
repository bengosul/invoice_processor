<?php
require_once 'functions/return_processed_emails_array.php';
?>


<html> 

<head>
<meta charset="utf-8" />
<title></title>
<script src="http://code.jquery.com/jquery-2.0.3.min.js" data-semver="2.0.3" data-require="jquery"></script>
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

<body style="text:cyan; bgcolor:black">

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
			<th>Processed</th>
			<th>Sent</th>
			<th style='display:none;'>Success</th>
			<th>Partner</th>
			<th>Amount</th>
			<th>InvNo</th>
			<th>InvDate</th>
			<th>Orig</th>	
			<th>Txt</th>
	</tr>
	</thead>
	<tbody>

<?php


$storelocation="/store/";

	while($row = $result->fetch_assoc()) {

		//		        echo "id: " . $row["id"]. " Subject: " . $row["subject"]. "<br>";

	//	print_r($row);
		$sql = "SELECT *, a.id as aid
			from emails.processed_attachments p
			left join emails.accounts a
			on '{$row['partner']}'=a.id
			WHERE id_email={$row['id']}";

		$result_att = $conn->query($sql);

	while($row_att=$result_att->fetch_assoc()){

		$filename_orig=$storelocation.sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".".$row_att['extension'];
		$filename_txt=$storelocation."temp/".sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".txt";
		$dlname_orig=$row_att['accname']."_".sprintf('%06d',$row_att['id_email']).'_'.sprintf('%02d',$row_att['id_attachment']).'_'.$row_att['fn'].".".$row_att['extension'];
		// var_dump($row);
		echo "<tr>
				<td>{$row['parsed']}</td>
				<td>{$row['received']}</td>
				<td style='display:none;'>";
if ($row_att['invoice_number']) {echo true;} else {echo false;} echo "</td>
				<td>{$row_att['accname']}</td>
				<td>{$row_att['invoice_amount']}</td>
				<td>{$row_att['invoice_number']}</td>
				<td>{$row_att['invoice_date']}</td>
				<td><a download='{$dlname_orig}' href='{$filename_orig}'>Download</a></td>
				<td><a href='{$filename_txt}'>Download</a></td>
			</tr>";
		}
	}
?>
	</tbody>
</table>
</body>

</html>

