<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tblsettings"));
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post">
<table width="100%" border="0" background="main.png">
  <tr>
    <td height="5" colspan="4">
    <?
	/********************MESSAGES*************************************************
	This code is to show messages
	**************************************************************************/
	if (isset($_GET['msg'])) {
	$msg = mysql_real_escape_string($_GET['msg']);
	echo "<div class=\"msg\">$msg</div>";
	}
	/******************************* END ********************************/
	?>    </td>
  </tr>
  <tr>
    <td width="16%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="67%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">DMWL Location</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="dmwl" value="<?=$sql_values_fetch['flddmwl']?>"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><br></td>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Update"></td>
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

$sql_insert = mysql_query("update tblsettings set
flddmwl='".strip_tags(addslashes($_REQUEST['dmwl']))."'
where 1
");

if($sql_insert)
{
$msg = urlencode("Details Updated Succesfully. ");
$redirecturl = "index.php?pg=7&msg=$msg";
header("location:".$redirecturl);
}
}
?>

