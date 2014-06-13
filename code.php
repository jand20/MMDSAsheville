<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
	header("Location:index.php");
include "config.php";
$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));

$sqlICD	= "SELECT * FROM tbllists where fldListName = 'icd' order by fldValue";
$resultICD = mysql_query($sqlICD);

$icdCodes = array();

while($icd = mysql_fetch_assoc($resultICD)):
	$icdCodes[$icd["fldValue"]] = $icd;
endwhile;

$sqlProcedures = "select * from tblproceduremanagment order by fldDescription";
$resultProcecures = mysql_query($sqlProcedures);

$procedures = array();

while($pro = mysql_fetch_assoc($resultProcecures)):
	$procedures[$pro["fldDescription"]] = $pro;
endwhile;
?>

<link
	href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" onsubmit="return validate_form(this);">
	<table width="80%" border="0" background="main.png">
		<tr>
			<td colspan="11">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="11" align="center"><?=(isset($_GET['msg'])?$_GET['msg']:'')?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Patient ID</td>
			<td class="dis"><?=$sql_values_fetch['fldPatientID']?></td>
			<td class="lab">Patient SSN</td>
			<td class="dis"><?=$sql_values_fetch['fldPatientSSN']?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">First name</td>
			<td class="dis"><?=$sql_values_fetch['fldFirstName']?></td>
			<td class="lab">Middle name</td>
			<td class="dis"><?=$sql_values_fetch['fldMiddleName']?></td>
			<td class="lab">Last name</td>
			<td class="dis"><?=$sql_values_fetch['fldLastName']?></td>
			<td class="lab">Jr, Sr, II, III</td>
			<td class="dis"><?=$sql_values_fetch['fldSurName']?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">DOB</td>
			<td class="dis"><?=$sql_values_fetch['fldDOB']?></td>
			<td class="lab">Sex</td>
			<td class="dis"><?=$sql_values_fetch['fldGender']?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Insurance Type</td>
			<td class="dis"><?=$sql_values_fetch['fldInsurance']?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Medicare #</td>
			<td class="dis"><?=$sql_values_fetch['fldMedicareNumber']?></td>
			<td class="lab">Medicare #</td>
			<td class="dis"><?=$sql_values_fetch['fldMedicaidNumber']?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Insurance Company</td>
			<td class="dis"><?=$sql_values_fetch['fldInsuranceCompanyName']?></td>
			<td class="lab">Policy #</td>
			<td class="dis"><?=$sql_values_fetch['fldPolicy']?></td>
			<td class="lab">Group #</td>
			<td class="dis"><?=$sql_values_fetch['fldGroup']?></td>
		</tr>
		<tr>
			<td>&nbsp;<?//print_r($procedures)?></td>
		</tr>		
<?for($i = 1; $i < 11; $i++):
	if(!empty($sql_values_fetch["fldProcedure$i"])):?>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Procedure #<?=$i?></td>
			<td class="dis"><?=$sql_values_fetch["fldProcedure$i"]?></td>
			<td class="lab">L/R</td>
			<td class="dis"><?=$sql_values_fetch["fldplr$i"]?></td>
			<td class="lab">CPT:</td>
			<td class="dis"><?=$procedures[$sql_values_fetch["fldProcedure$i"]]["fldCBTCode"]?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Definiative Diagnosis</td>
			<td colspan="3" class="dis"><input name="proc<?=$i?>dig" type="text" id="proc<?=$i?>dig" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">ICD9A</td>
			<td colspan="2">
				<select name="proc<?=$i?>icd1" id="proc<?=$i?>icd1">
					<option selected="selected" value="">Select</option>
				<?foreach ($icdCodes as $code):
					$selected = ($code['fldValue'] === $sql_values_fetch["fldSymptom$i"])?'selected="selected"':'';?>
					<option value="<?=$code['fldValue']?>" <?=$selected?>><?="{$code['fldValue']}-{$code['code']}"?></option>
				<?endforeach;?>
				</select><?//"{$sql_values_fetch["fldSymptom$i"]}"?>
			</td>
			<td class="lab">ICD9B</td>
			<td colspan="2">
				<select name="proc<?=$i?>icd2" id="proc<?=$i?>icd2">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'icd'";
				$result = mysql_query($sql);
				
				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>"><?=$row['fldValue']?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">ICD9C</td>
			<td colspan="2">
				<select name="proc<?=$i?>icd3" id="proc<?=$i?>icd3">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'icd'";
				$result = mysql_query($sql);
				
				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>"><?=$row['fldValue']?></option>
				<?endwhile;?>
				</select>
			</td>
			<td class="lab">ICD9D</td>
			<td colspan="2">
				<select name="proc<?=$i?>icd4" id="proc<?=$i?>icd4">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'icd'";
				$result = mysql_query($sql);
				
				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>"><?=$row['fldValue']?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr><td><br/></td></tr>
	<?endif;
	endfor;?>
		<tr>
			<td align="center" colspan="10"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
</form>

<?php
if($_REQUEST['submit']!='')
{
	$sql_insert	= mysql_query("insert into tblicdcodes set
fldOrderid='".strip_tags(addslashes($id))."',
fldProc1icd1='".strip_tags(addslashes($_REQUEST['proc1icd1']))."',
fldProc1icd2='".strip_tags(addslashes($_REQUEST['proc1icd2']))."',
fldProc1icd3='".strip_tags(addslashes($_REQUEST['proc1icd3']))."',
fldProc1icd4='".strip_tags(addslashes($_REQUEST['proc1icd4']))."',
fldProc2icd1='".strip_tags(addslashes($_REQUEST['proc2icd1']))."',
fldProc2icd2='".strip_tags(addslashes($_REQUEST['proc2icd2']))."',
fldProc2icd3='".strip_tags(addslashes($_REQUEST['proc2icd3']))."',
fldProc2icd4='".strip_tags(addslashes($_REQUEST['proc2icd4']))."',
fldProc3icd1='".strip_tags(addslashes($_REQUEST['proc3icd1']))."',
fldProc3icd2='".strip_tags(addslashes($_REQUEST['proc3icd2']))."',
fldProc3icd3='".strip_tags(addslashes($_REQUEST['proc3icd3']))."',
fldProc3icd4='".strip_tags(addslashes($_REQUEST['proc3icd4']))."',
fldProc4icd1='".strip_tags(addslashes($_REQUEST['proc4icd1']))."',
fldProc4icd2='".strip_tags(addslashes($_REQUEST['proc4icd2']))."',
fldProc4icd3='".strip_tags(addslashes($_REQUEST['proc4icd3']))."',
fldProc4icd4='".strip_tags(addslashes($_REQUEST['proc4icd4']))."',
fldProc5icd1='".strip_tags(addslashes($_REQUEST['proc5icd1']))."',
fldProc5icd2='".strip_tags(addslashes($_REQUEST['proc5icd2']))."',
fldProc5icd3='".strip_tags(addslashes($_REQUEST['proc5icd3']))."',
fldProc5icd4='".strip_tags(addslashes($_REQUEST['proc5icd4']))."',
fldProc6icd1='".strip_tags(addslashes($_REQUEST['proc6icd1']))."',
fldProc6icd2='".strip_tags(addslashes($_REQUEST['proc6icd2']))."',
fldProc6icd3='".strip_tags(addslashes($_REQUEST['proc6icd3']))."',
fldProc6icd4='".strip_tags(addslashes($_REQUEST['proc6icd4']))."',
fldProc1dig='".strip_tags(addslashes($_REQUEST['proc1dig']))."',
fldProc2dig='".strip_tags(addslashes($_REQUEST['proc2dig']))."',
fldProc3dig='".strip_tags(addslashes($_REQUEST['proc3dig']))."',
fldProc4dig='".strip_tags(addslashes($_REQUEST['proc4dig']))."',
fldProc5dig='".strip_tags(addslashes($_REQUEST['proc5dig']))."',
fldProc6dig='".strip_tags(addslashes($_REQUEST['proc6dig']))."'
") or die (mysql_error());

if($sql_insert)
{
	$sql_update	= mysql_query("update tblorderdetails set fldCoded=1 where fldID='".$id."'");
}
if($sql_update)
{
	$redirecturl = "index.php?pg=20";
	header("location:".$redirecturl);
}
}
?>
