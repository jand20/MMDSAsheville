<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td height="90" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td><span class="lab">Date/Time </span></td>
      <?
	$time=date("Y-m-d H:i",time());
      function formatDate11($dDate){
  	$dNewDate = strtotime($dDate);
  	return date('d-m-Y',$dNewDate);
  	}
  	function formatDate12($dDate){
  	$dNewDate = strtotime($dDate);
  	return date('H:i',$dNewDate);
  	}
    $dt1=$sql_values_fetch['fldReportDate'];
    $time11=formatdate11($dt1);
  	$time12=formatdate12($dt1);
      ?>
      <td width="20%"><input name="schdate1" type="text" value="<?=$time11?>" id="schdate1" size="8"/>
      <input name="schdate2" type="text" value="<?=$time12?>" id="schdate2" size="2"/></td>
      <td>&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td><span class="lab">Report Called To </span></td>
      <td width="20%"><input name="repcallto" type="text" id="repcallto" class="myinput1" value="<?=$sql_values_fetch['fldReportCalledTo']?>"/></td>
      <td>&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td><span class="lab">Report Details</span></td>
      <td width="20%"><textarea name="repdet" type="textarea" height="3" id="repdet"><?=$sql_values_fetch['fldReportDetails']?></textarea></td>
      <td>&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
     <tr>
      <td height="10" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" value="Update" /></td>
    </tr>
    <tr>
      <td height="102" colspan="4">&nbsp;</td>
    </tr>
  </table>
</form>
<?
if($_REQUEST['submit']!='')
{

function formatDate2($dDate){
$dNewDate = strtotime($dDate);
return date('Y-m-d H:i',$dNewDate);
}
$time1=$_REQUEST['schdate1'] . " " . $_REQUEST['schdate2'];
$time=formatdate2($time1);

$sql_insert	= mysql_query("update tblorderdetails set fldVerbal=1,
fldReportDate='".$time."',
fldReportCalledTo='".$_REQUEST['repcallto']."',
fldReportDetails='".$_REQUEST['repdet']."'
where fldID='".$id."'");
if($sql_insert)
{
$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
}
}
?>