<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tbllists where fldID='$id'"));
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post">
<table width="100%" border="0" background="main.png">
  <tr>
    <td width="22%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="67%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">List Name</td>
    <td><strong>:</strong></td>
    <td>
		<select name="listname">
			<option>Select</option>
			<option value="division" <?=($sql_values_fetch['fldListName'] === 'division')? 'selected="selected"':'';?>>Division</option>
			<option value="exception" <?=($sql_values_fetch['fldListName'] === 'exception')? 'selected="selected"':'';?>>Exception</option>
			<option value="facilitytype" <?=($sql_values_fetch['fldListName'] === 'facilitytype')? 'selected="selected"':'';?>>Facility Type</option>
			<option value="icd" <?=($sql_values_fetch['fldListName'] === 'icd')? 'selected="selected"':'';?>>ICD Code</option>
			<option value="insurance" <?=($sql_values_fetch['fldListName'] === 'insurance')? 'selected="selected"':'';?>>Insurance</option>
			<option value="modality" <?=($sql_values_fetch['fldListName'] === 'modality')? 'selected="selected"':'';?>>Modality</option>
			<option value="pcategory" <?=($sql_values_fetch['fldListName'] === 'pcategory')? 'selected="selected"':'';?>>Procedure Category</option>
			<option value="radiologist" <?=($sql_values_fetch['fldListName'] === 'radiologist')? 'selected="selected"':'';?>>Radiologist</option>
			<option value="relationship" <?=($sql_values_fetch['fldListName'] === 'relationship')? 'selected="selected"':'';?>>Relationship</option>
			<option value="LAB" <?=($sql_values_fetch['fldListName'] === 'relationship')? 'selected="selected"':'';?>>LAB</option>
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
    <td><input type="text" name="listvalue" value="<?=$sql_values_fetch['fldValue']?>"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td class="lab">Active</td>
    <td><strong>:</strong></td>
  	<td><input type="checkbox" name="activefield" value="<?=$sql_values_fetch['fldActiveValue']?>" <?=$sql_values_fetch['fldActiveValue'] == '1' ? 'checked = "checked"' : ''?> /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><br></td>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Update"></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td class="lab">Code/NPI/Note</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="codevalue" value="<?=$sql_values_fetch['code']?>"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
</table>
</form>

<?php
// Getting Values from the registration to create Master Account


if($_REQUEST['submit']!='')
{
	$active = 0;
	if ($_REQUEST['activefield'] == 'true')
	{
		$active = 1;
	}

$sql_insert = mysql_query("update tbllists set
fldListName='".strip_tags(addslashes($_REQUEST['listname']))."',
fldValue='".strip_tags(addslashes($_REQUEST['listvalue']))."',
code='".strip_tags(addslashes($_REQUEST['codevalue']))."',
fldActiveValue='".strip_tags(addslashes($_REQUEST['activefield']))."'
where fldID='".$id."'");

if($sql_insert)
{
$redirecturl = "index.php?pg=17";
header("location:".$redirecturl);
}
}
?>