<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
	header("Location:index.php");
include "config.php";
?>
<link
	href="style.css" rel="stylesheet" type="text/css" />
<form style="width: 100%; background: url(main.png)" action="" method="post">
	<table style="width: 100%; background: url(main.png)">
		<tr><td><br/></td></tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">List Name</td>
			<td><strong>:</strong></td>
			<td><select name="listname">
					<option selected="selected" value="">Select</option>
					<option value="division">Division</option>
					<option value="exception">Exception</option>
					<option value="icd">ICD Code</option>
					<option value="insurance">Insurance</option>
					<option value="modality">Modality</option>
					<option value="pcategory">Procedure Category</option>
					<option value="radiologist">Radiologist</option>
					<option value="relationship">Relationship</option>
					<option value="Lab">Lab</option>
			</select>
			</td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Value</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="listvalue"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Code/NPI/NOTE</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="codevalue"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><br></td>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Create"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
	</table>
</form>

<?php

if($_REQUEST['submit']!='')
{
	$sql_insert = mysql_query("insert into tbllists set
fldListName='".strip_tags(addslashes($_REQUEST['listname']))."',
fldValue='".strip_tags(addslashes($_REQUEST['listvalue']))."',
code='".strip_tags(addslashes($_REQUEST['codevalue']))."'
");

if($sql_insert)
{
	$redirecturl = "index.php?pg=17";
	header("location:".$redirecturl);
}
}
?>

