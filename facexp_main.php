<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td width="37%" colspan="5" class="lab"><div align="center">Enter the Date Range to Produce Report </div></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
     <tr>
      <td height="10" colspan="5"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="15%"><span class="lab">Start Date </span></td>
          <td width="30%"><span class="lab">
            <input name="date1" type="text" class="myinput1" value="<?echo date('m-d-Y' , time());?>" />
          </span></td>
          <td width="15%"><span class="lab">End Date</span></td>
          <td width="10%"><span class="lab">
            <input name="date2" type="text" class="myinput1" id="date2" value="<?echo date('m-d-Y' , time());?>" />
          </span></td>
          <td width="20%">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
     <tr>
       <td height="10" colspan="5">&nbsp;</td>
     </tr>
    <tr>
      <td colspan="5" align="center"><input type="submit" name="submit" value="Display" /></td>
    </tr>
    <tr>
      <td height="102" colspan="5">&nbsp;</td>
    </tr>
  </table>
</form>
<?
if($_REQUEST['submit']!='')
{
$dt1=$_REQUEST['date1'];
$sDate2 = split('-', $dt1);
$dt_1 = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];
$dt2=$_REQUEST['date2'];
$sDate2 = split('-', $dt2);
$dt_2 = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];

$user = $_SESSION['user'];
$sql_values_u = mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));
$fac=$sql_values_u['fldFacility'];
$uid=$sql_values_u['fldID'];
$sql_values_f = mysql_fetch_array(mysql_query("select * from tbluserfacdetails where flduserid = '$uid'"));
$fac=$sql_values_f['fldFacility'];
//echo 'fac ' . $fac;
$redirecturl = "?pg=64&dt1=$dt_1&dt2=$dt_2&d=$fac";
header("location:".$redirecturl);
}
?>