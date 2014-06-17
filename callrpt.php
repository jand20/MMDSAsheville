<?php
session_start();
include "config.php";
$mon=$_REQUEST['dt2'];
$yr=$_REQUEST['dt1'];
$fname="CALL_REPORT_" . $d . '_' . $mon . '_' . $yr . ".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
$st_date=$yr . '-' . $mon . '-' . '01 00:00:00';
$yr_new=$yr;
$emon=$mon+1;
if($emon==13)
{
$yr_new=$yr+1;
$emon=1;
}
$end_date=$yr_new . '-' . $emon . '-' . '01 00:00:00';
if($mon=='01')
$month="January";
if($mon=='02')
$month="February";
if($mon=='03')
$month="March";
if($mon=='04')
$month="April";
if($mon=='05')
$month="May";
if($mon=='06')
$month="June";
if($mon=='07')
$month="July";
if($mon=='08')
$month="August";
if($mon=='09')
$month="September";
if($mon=='10')
$month="October";
if($mon=='11')
$month="November";
if($mon=='12')
$month="December";
if($d=='all')
$dis="All Facility";
else
$dis=$d;
?>
<html>
<head>
<title>MMDS Mobile X-ray</title>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
<tr><td>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td><div align="center"><b>MONTHLY - NIGHT, WEEKEND and HOLIDAY CALL REPORT</b></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="left"> AREA : <?=$dis?></div></td>
    </tr>
    <tr>
      <td><div align="left"> MONTH : <?=$month?></div></td>
    </tr>
  </table>
  <br />
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
	<tr>
	  <td><div align="center"><b>Day</b></div></td>
	  <td><div align="center"><b>Date</b></div></td>
	  <td><div align="center"><b>Facility</b></div></td>
	  <td><div align="center"><b>Patient Name</b></div></td>
	  <td><div align="center"><b>Time Called in By Facility</b></div></td>
	  <td><div align="center"><b>Time Exam Performed</b></div></td>
	  <td><div align="center"><b>Type of Exam</b></div></td>
	  <td><div align="center"><b>Time Report Called to Facility</b></div></td>
	  <td><div align="center"><b>Report Called to Facility</b></div></td>
	  <td><b>Tech</b></td>
	</tr>
<?
if($d!='all')
{
$sql="select * from tblorderdetails where fldFacilityName='$d' AND fldSchDate >= '$st_date' AND fldSchDate < '$end_date'";
}
else
{
$sql="select * from tblorderdetails where fldSchDate >= '$st_date' AND fldSchDate < '$end_date'";
}
$result = mysql_query($sql) or die (mysql_error());
while($row_new = mysql_fetch_array($result))
{
$dt_w=$row_new['fldDate'];
$sql_temp=mysql_fetch_array(mysql_query("SELECT WEEKDAY('$dt_w') as wk"));
$day = $sql_temp['wk'];

if($day=='0')
$day_of_the_week="Monday";
if($day=='1')
$day_of_the_week="Tuesday";
if($day=='2')
$day_of_the_week="Wednesday";
if($day=='3')
$day_of_the_week="Thursday";
if($day=='4')
$day_of_the_week="Friday";
if($day=='5')
$day_of_the_week="Saturday";
if($day=='6')
$day_of_the_week="Sunday";

$name=$row_new['fldFirstName'] . '&nbsp;' . $row_new['fldMiddleName'] . ' ' . $row_new['fldLastName'] . ' ' . $row_new['fldSurName'];
if($row_new['fldAfterhours']==1 || $day==5 || $day==6)
{
$prc= '&nbsp;';
if($row_new['fldProcedure1']!='') { $prc=$row_new['fldProcedure1'];$cnt++; }
if($row_new['fldProcedure2']!='') { $prc.='<br/>' . $row_new['fldProcedure2']; }
if($row_new['fldProcedure3']!='') { $prc.='<br/>' . $row_new['fldProcedure3']; }
if($row_new['fldProcedure4']!='') { $prc.='<br/>' . $row_new['fldProcedure4']; }
if($row_new['fldProcedure5']!='') { $prc.='<br/>' . $row_new['fldProcedure5']; }
if($row_new['fldProcedure6']!='') { $prc.='<br/>' . $row_new['fldProcedure6']; }
?>
	<tr>
	  <td><div align="center"><?=$day_of_the_week?></div></td>
	  <td><div align="center"><?echo date('m-d-Y' ,strtotime($row_new['fldDate']));?></div></td>
	  <td><div align="center"><?=$row_new['fldFacilityName']?></div></td>
	  <td><div align="center"><?=$name?></div></td>
	  <td><div align="center"><?echo date('g:i A' , strtotime($row_new['fldDate']));?></div></td>
	  <td><div align="center"><?echo date('g:i A' , strtotime($row_new['fldExamDate']));?></div></td>
	  <td><div align="center"><?=$prc?></div></td>
	  <td><div align="center"><?echo date('g:i A' , strtotime($row_new['fldReportDate']));?></div></td>
	  <td><div align="center"><?=strtoupper($row_new['fldReportCalledTo'])?></div></td>
	  <td><?=strtoupper($row_new['fldTechnologist'])?></td>
	</tr>
<? } } ?>
  </table>
</td></tr></table>
</body>
</html>