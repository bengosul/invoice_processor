<!--
	/*
	* Add edit delete rows dynamically using jquery and php
	* http://www.amitpatil.me/
	*
	* @version
	* 2.0 (4/19/2014)
	* 
	* @copyright
	* Copyright (C) 2014-2015 
	*
	* @Auther
	* Amit Patil
	* Maharashtra (India)
	*
	* @license
	* This file is part of Add edit delete rows dynamically using jquery and php.
	* 
	* Add edit delete rows dynamically using jquery and php is freeware script. you can redistribute it and/or 
	* modify it under the terms of the GNU Lesser General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* (at your option) any later version.
	* 
	* Add edit delete rows dynamically using jquery and php is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	* 
	* You should have received a copy of the GNU General Public License
	* along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
	*/
-->
<?php
	// Show only compile error
//	error_reporting(E_COMPILE_ERROR );
	require_once("ajax_table.class.php");
	$obj = new ajax_table(); 

	$records = $obj->getRecords();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>Ajax Table Inline Edit</title>
  <script>
	 // Column names must be identical to the actual column names in the database, if you dont want to reveal the column names, you can map them with the different names at the server side.
	 var columns = new Array("fname","lname","tech","email","address");
	 var placeholder = new Array("Enter First Name","Enter Last Name","Enter Technology","Enter Email","Enter Address");
	 var inputType = new Array("text","text","text","text","textarea");
	 var table = "tableDemo";
	 
	 // Set button class names 
	 var savebutton = "ajaxSave";
	 var deletebutton = "ajaxDelete";
	 var editbutton = "ajaxEdit";
	 var updatebutton = "ajaxUpdate";
	 var cancelbutton = "cancel";
	 
	 var saveImage = "images/save.png"
	 var editImage = "images/edit.png"
	 var deleteImage = "images/remove.png"
	 var cancelImage = "images/back.png"
	 var updateImage = "images/save.png"

	 // Set highlight animation delay (higher the value longer will be the animation)
	 var saveAnimationDelay = 3000; 
	 var deleteAnimationDelay = 1000;
	  
	 // 2 effects available available 1) slide 2) flash
	 var effect = "flash"; 
  
  </script>
  <script src="js/jquery-1.11.0.min.js"></script>	
  <script src="js/jquery-ui.js"></script>	
  <script src="js/script.js"></script>	
  <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
	<table border="0" class="tableDemo bordered">
		<tr class="ajaxTitle">
			<th width="2%">Sr</th>
			<th width="8%">First Name</th>
			<th width="8%">Last Name</th>
			<th width="8%">Technology</th>
			<th width="8%">Email</th>
			<th width="8%">Address</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
			<th width="8%">Action</th>
		</tr>
		<?php
		if(count($records)){
		 $i = 1;	
		 foreach($records as $key=>$eachRecord){

?>
		<tr id="<?php=$eachRecord['id'];?>">
			<td><?php echo $i++;?></td>
			<td class="fname"><?php echo $eachRecord['id'];?></td>
			<td class="lname"><?php echo $eachRecord['partner'];?></td>
			<td class="tech"><?php echo $eachRecord['config_name'];?></td>
			<td class="email"><?php echo $eachRecord['email'];?></td>
			<td class="address"><?php echo $eachRecord['subject'];?></td>
			<td class="address"><?php echo $eachRecord['atttype'];?></td>
			<td class="address"><?php echo $eachRecord['inv_no_str'];?></td>
			<td class="address"><?php echo $eachRecord['inv_no_col_offset'];?></td>
			<td class="address"><?php echo $eachRecord['inv_no_row_offset'];?></td>
			<td class="address"><?php echo $eachRecord['inv_date_str'];?></td>
			<td class="address"><?php echo $eachRecord['inv_date_col_offset'];?></td>
			<td class="address"><?php echo $eachRecord['inv_date_row_offset'];?></td>
			<td class="address"><?php echo $eachRecord['inv_date_format'];?></td>
			<td>
				<a href="javascript:;" id="<?php echo $eachRecord['id'];?>" class="ajaxEdit"><img src="" class="eimage"></a>
				<a href="javascript:;" id="<?php echo $eachRecord['id'];?>" class="ajaxDelete"><img src="" class="dimage"></a>
			</td>
		</tr>
		<?php }
		}
		?>
	</table>  
 </body>
</html>
