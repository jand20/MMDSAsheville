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
  <tr><td height="5" colspan="4">&nbsp;</td></tr>
  <tr>
    <td height="5" colspan="4" align="middle">
    <?
	if (isset($_GET['msg'])) {
	$msg = mysql_real_escape_string($_GET['msg']);
	echo $msg;
	}
	?>    </td>
  </tr>
  <tr>
    <td width="18%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="67%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">PDF Unsigned Orders</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="pdfunsignedorders" value="<?=$sql_values_fetch['fldPDFUnsignedOrders']?>"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">PDF Signed Orders</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="pdfsignedorders" value="<?=$sql_values_fetch['fldPDFSignedOrders']?>"></td>
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
fldPDFUnsignedOrders='".strip_tags(addslashes($_REQUEST['pdfunsignedorders']))."',
fldPDFSignedOrders='".strip_tags(addslashes($_REQUEST['pdfsignedorders']))."'
");

if($sql_insert)
{
$msg = urlencode("Details Updated Succesfully. ");
$redirecturl = "index.php?pg=6&msg=$msg";
header("location:".$redirecturl);
}
}
?>

