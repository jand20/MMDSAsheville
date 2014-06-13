<?php session_start();
include "config.php";
$mon=$_REQUEST['dt2'];
$yr=$_REQUEST['dt1'];
$fname="Monthly-Detailed_" . $mon . $yr . ".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<title>MD Imaging</title>
</head>
<body>

<?

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

$d=$_REQUEST['d'];

if($d!='all')
{
$sql="select distinct fldFacilityName from tblorderdetails where fldFacilityName='$d' AND fldDate >= '$st_date' AND fldDate < '$end_date'";
}
else
{
$sql="select distinct fldFacilityName from tblorderdetails where fldDate >= '$st_date' AND fldDate < '$end_date'";
}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
<tr><td>
<?
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$facy=$row['fldFacilityName'];
$sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldFacilityName='$facy'"));
$facname=$sql_fac['fldFacilityName'];
$facaddr1=$sql_fac['fldAddressLine1'] . " " . $sql_fac['fldAddressLine2'];
$facaddr2=$sql_fac['fldAddressCity'] . ", " . $sql_fac['fldAddressState'] . ", " . $sql_fac['fldAddressZip'];
?>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="12"><div align="center"><?=$facname?></div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center"><?=$facaddr1?></div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center"><?=$facaddr2?></div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center">Date : <?=$month?> <?=$yr?></div></td>
    </tr>
  </table>
  <br />
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="12"><div align="center">Facility Utilization / Q.A. Report</div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center">Name of Facility : <?=$facname?></div></td>
    </tr>
	<tr>
	  <td width="4%">&nbsp;</td>
	  <td width="17%"><div align="center">Doctor</div></td>
	  <td width="3%"><div align="center">After Hours Mon-Fri</div></td>
	  <td width="3%"><div align="center">Weekend Patients Sat-Sun</div></td>
	  <td width="6%"><div align="center">Time Called In</div></td>
	  <td width="6%"><div align="center">Patient Chart #</div></td>
	  <td width="6%"><div align="center">Date of Service</div></td>
	  <td width="5%"><div align="center">PPS</div></td>
	  <td width="17%"><div align="center">Patient Name</div></td>
	  <td width="5%"><div align="center">Qty of Exams</div></td>
	  <td width="17%"><div align="center">Type of Exam</div></td>
	  <td width="6%"><div align="center">Neg/Pos</div></td>
	</tr>
<?
$sno=0;
$sql_1="select * from tblorderdetails where fldFacilityName='$facname' AND fldDate >= '$st_date' AND fldDate < '$end_date' ORDER BY fldDate";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$sno+=1;
$afterhours="No";
if($row_new['fldAfterhours']==1)
{
$afterhours="Yes";
}
$dtx=$row_new['fldDate'];
$phy=$row_new['fldOrderingPhysicians'];

$sql_temp=mysql_fetch_array(mysql_query("SELECT WEEKDAY('$dtx') as wk"));
$day_of_the_week = $sql_temp['wk'];
$wendpt="No";
if($day_of_the_week==5 || $day_of_the_week==6)
$wendpt="Yes";
$tci=date('m-d g:i A' , strtotime($row_new['fldReportDate']));
$pid=$row_new['fldPatientID'];
$dos=date('m-d-Y' , strtotime($row_new['fldDate']));
$pps=$row_new['fldpps'];
if($pps=='')
$pps='&nbsp;';
$name=$row_new['fldFirstName'] . '&nbsp;' . $row_new['fldMiddleName'] . ' ' . $row_new['fldLastName'] . ' ' . $row_new['fldSurName'];
$cnt=0;
$prc= '&nbsp;';
if($row_new['fldProcedure1']!='') { $prc.='<br/>' . $row_new['fldProcedure1'];$cnt++; }
if($row_new['fldProcedure2']!='') { $prc.='<br/>' . $row_new['fldProcedure2'];$cnt++; }
if($row_new['fldProcedure3']!='') { $prc.='<br/>' . $row_new['fldProcedure3'];$cnt++; }
if($row_new['fldProcedure4']!='') { $prc.='<br/>' . $row_new['fldProcedure4'];$cnt++; }
if($row_new['fldProcedure5']!='') { $prc.='<br/>' . $row_new['fldProcedure5'];$cnt++; }
if($row_new['fldProcedure6']!='') { $prc.='<br/>' . $row_new['fldProcedure6'];$cnt++; }
$qty=$cnt;
$etype=$prc;
if($etype=='')
$etype='&nbsp;';
if($phy=='')
$phy='&nbsp;';
$sign='&nbsp;';
$sign1='';
$sign2='';
$sign3='';
$sign4='';
$sign5='';
$sign6='';

if($row_new['fldsign1']==1)
{
$sign1="Pos";
}
if($row_new['fldsign2']==1)
{
$sign2="Pos";
}
if($row_new['fldsign3']==1)
{
$sign3="Pos";
}
if($row_new['fldsign4']==1)
{
$sign4="Pos";
}
if($row_new['fldsign5']==1)
{
$sign5="Pos";
}
if($row_new['fldsign6']==1)
{
$sign6="Pos";
}
if($row_new['fldsign1']==0)
{
$sign1="Neg";
}
if($row_new['fldsign2']==0)
{
$sign2="Neg";
}
if($row_new['fldsign3']==0)
{
$sign3="Neg";
}
if($row_new['fldsign4']==0)
{
$sign4="Neg";
}
if($row_new['fldsign5']==0)
{
$sign5="Neg";
}
if($row_new['fldsign6']==0)
{
$sign6="Neg";
}
if($row_new['fldProcedure1']!='') { $sign='<br/>' . $sign1; }
if($row_new['fldProcedure2']!='') { $sign.='<br/>' . $sign2; }
if($row_new['fldProcedure3']!='') { $sign.='<br/>' . $sign3; }
if($row_new['fldProcedure4']!='') { $sign.='<br/>' . $sign4; }
if($row_new['fldProcedure5']!='') { $sign.='<br/>' . $sign5; }
if($row_new['fldProcedure6']!='') { $sign.='<br/>' . $sign6; }
if($pid=='')
$pid='&nbsp;';
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$phy?></div></td>
	  <td><div align="center"><?=$afterhours?></div></td>
	  <td><div align="center"><?=$wendpt?></div></td>
	  <td><div align="center"><?=$tci?></div></td>
	  <td><div align="center"><?=$pid?></div></td>
	  <td><div align="center"><?=$dos?></div></td>
	  <td><div align="center"><?=$pps?></div></td>
	  <td><div align="center"><?=$name?></div></td>
	  <td><div align="center"><?=$qty?></div></td>
	  <td><div align="center"><?=$etype?></div></td>
	  <td><div align="center"><?=$sign?></div></td>
	</tr>
<? } ?>
  </table>
  <HR>
<? } ?>
</td></tr></table>
</body>
</html>