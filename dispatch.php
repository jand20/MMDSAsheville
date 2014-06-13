<?php #vesko ooe
session_start();
# if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");

require_once "config.php";

//ini_set('display_errors', 1);
?>

<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form1").validate();
		
		$(".datetimepicker").datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "mm-dd-yy",
			yearRange: "-01:+01",
			timeFormat: "HH:mm"
		});
	});
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />
<form id="form1" name="form1" method="post" action="">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
	<tr>
		<td height="90" colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="center">Date/Time<input type='text' name='dispatchedDateTime' id='dispatchedDateTime' class='required datetimepicker'/></td>
	</tr>
	<tr>
		<td align="center">Select Technologist
			<select name="technologist" class='required'>
				<option selected="selected" value="">Select</option>
		
			<?$techOnline = "";
			#$techOnline = " AND fldOnline='1' ";
			$sql = "SELECT * FROM tbluser WHERE fldRole='technologist' AND fldStatus='Enabled' $techOnline ORDER BY fldRealName";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)):?>
				<option value="<?=$row['fldUserName']?>"><?=($row['fldOnline'] === '1')?$row['fldRealName'].'*':$row['fldRealName'];?></option>
			<?endwhile;?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"><br/></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><input type="submit" name="submit" value="Dispatch" /></td>
	</tr>
	</table>
</form>
<?
if($_REQUEST['submit']!='')
{
	list($m,$d,$y,$h,$i) = preg_split('/-|:|\s/', $_REQUEST['dispatchedDateTime']);
	//die("$m/$d/$y $h:$i");
	$dispatchDate	= date("Y-m-d H:i", mktime($h,$i,0,$m,$d,$y));
	
	$dispatchSQL	= "update tblorderdetails set fldDispatched=1, fldDispatchedDate = '$dispatchDate', fldTechnologist='".strtoupper($_REQUEST['technologist'])."' where fldID='$id'";
	//die($dispatchSQL);
	
	$sql_insert		= mysql_query($dispatchSQL);
	
	$redirecturl	= "index.php?pg=20";
	header("location:".$redirecturl);
}
?>