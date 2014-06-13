<?php session_start();
include "config.php";
$user = $_SESSION['user'];
$sql_values_fetch_usr = mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));
$facid=$sql_values_fetch_usr['fldID'];
?>
<html>
<head>
<title>MD Imaging</title>
</head>
<body>
<link href="style.css" rel="stylesheet" type="text/css" />
<?
$st_date=$dt1.' 00:00:00';
$end_date=$dt2.' 23:59:59';
$sql="select * from tblorderdetails where fldSchDate >= '$st_date' AND fldSchDate <= '$end_date' AND  fldFacilityName in (select fldfacilityname from tbluserfacdetails where flduserid = '$facid')";
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
<tr><td>
<?
$result = mysql_query($sql);
$num = mysql_num_rows($result);

if(!$num)
{
?>
<table  align="center"><tbody>
  <tr><td colspan="14" height="50"><div  class="lab">No Records Found</div></td></tr>
</tbody></table>
<?
}
else
{
?>
  <br />
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="12"><div align="center">Facility Report</div></td>
    </tr>
	<tr>
	  <td width="5%">&nbsp;</td>
	  <td width="15%"><div align="center">Patient Name</div></td>
	  <td width="5%"><div align="center">Patient ID</div></td>
	  <td width="15%"><div align="center">DOB</div></td>
	  <td width="10%"><div align="center">Room#</div></td>
	  <td width="10%"><div align="center">Symptoms</div></td>
	  <td width="10%"><div align="center">L/R/B</div></td>
	  <td width="15%"><div align="center">Procedure Description</div></td>
	  <td width="15%"><div align="center">Date Needed</div></td>
	</tr>
<?
$sno=0;
$sql_1="select * from tblorderdetails where fldSchDate >= '$st_date' AND fldSchDate <= '$end_date' AND  fldFacilityName in (select fldfacilityname from tbluserfacdetails where flduserid = '$facid')";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$pr1 = $row_new['fldProcedure1'];
if($pr1)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom1']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr1']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure1']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
$pr2 = $row_new['fldProcedure2'];
if($pr2)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom2']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr2']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure2']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
$pr3 = $row_new['fldProcedure3'];
if($pr3)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom3']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr3']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure3']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
$pr4 = $row_new['fldProcedure4'];
if($pr4)
{ $sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom4']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr4']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure4']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
$pr5 = $row_new['fldProcedure5'];
if($pr5)
{ $sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom5']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr5']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure5']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
$pr6 = $row_new['fldProcedure6'];
if($pr6)
{ $sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldDOB']))?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientroom']?></div></td>
	  <td><div align="center"><?=$row_new['fldSymptom6']?></div></td>
	  <td><div align="center"><?=$row_new['fldplr6']?></div></td>
	  <td><div align="center"><?=$row_new['fldProcedure6']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?></div></td>
	</tr>
<? }
} ?>
  </table>
  <HR>
<? } ?>
</td></tr></table>
</body>
</html>