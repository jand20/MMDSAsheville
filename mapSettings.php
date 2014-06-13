<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
	header("Location:index.php");
require_once "config.php";

$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tblsettings"));

/********************MESSAGES*************************************************
 This code is to show messages
**************************************************************************/
$msg = (isset($_GET['msg']))?"<div class=\"msg\">".mysql_real_escape_string($_GET['msg'])."</div>":'';
/******************************* END ********************************/
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post">
	<table style="background: url('main.png');">
		<tr>
			<td><?=$msg?></td>
		</tr>
		<tr>
			<td class="lab">Central MapIt Address</td>
			<td><input type="text" name="mapAddress" value="<?=$sql_values_fetch['mapAddress']?>"></td>
		</tr>
		<tr>
			<td class="lab">Latitude/Longitude</td>
			<td><input type="text" name="mapLatLong" value="<?=$sql_values_fetch['mapLatLong']?>"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Update"></td>
		</tr>
	</table>
</form>

<?php
	// Getting Values from the registration to create Master Account
if ($_REQUEST ['submit'] != '')
{
	$address = mysql_real_escape_string($_POST['mapAddress']);
	$latLong = mysql_real_escape_string($_POST['mapLatLong']);
	
	$sql = "update tblsettings set mapAddress = '$address', mapLatLong = '$latLong'";
	
	if (mysql_query($sql))
	{
		$msg = urlencode ( "Map details updated succesfully." );
		$redirecturl = "index.php?pg=75&msg=$msg";
		header ( "location:$redirecturl" );
	}
}
?>
