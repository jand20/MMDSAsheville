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
            <input name="date1" type="text" class="myinput1" value="MM-DD-YYYY" />
          </span></td>
          <td width="15%"><span class="lab">End Date</span></td>
          <td width="10%"><span class="lab">
            <input name="date2" type="text" class="myinput1" id="date2" value="MM-DD-YYYY" />
          </span></td>
          <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="1"><span class="lab">Select Facility Name </span></td>
        <td colspan="3">
	   <select name="divisionname" id="divisionname" class="myselect3">
       <option selected="selected" value="">Select</option>
       <?
       $sql="SELECT distinct fldFacilityName FROM tblfacility order by fldFacilityName";
	   $result = mysql_query($sql);
	   while($row = mysql_fetch_array($result))
	   {?>
       <option value="<?=$row['fldFacilityName']?>"><?=$row['fldFacilityName']?></option>
       <? } ?>
	   </select>
       </td>
       </tr.
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
$div=$_REQUEST['divisionname'];
$redirecturl = "?pg=62&dt1=$dt_1&dt2=$dt_2&d=$div";
header("location:".$redirecturl);
}
?>