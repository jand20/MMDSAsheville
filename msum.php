<?php session_start();
include "config.php";
$mon=$_REQUEST['dt2'];
$yr=$_REQUEST['dt1'];
$fname="Monthly-Summary_" . $mon . $yr . ".xls";
include('ps_pagination.php');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<title>PMD</title>
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
$facaddr1=$sql_fac['fldAddressLine1'] . "," . $sql_fac['fldAddressLine2'];
$facaddr2=$sql_fac['fldAddressCity'] . ", " . $sql_fac['fldAddressState'] . ", " . $sql_fac['fldAddressZip'];
?>
  <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="8"><div align="center">MONTHLY ORDER SUMMARY</div></td>
    </tr>
  </table>
  <br />
  <table width="90%" border="2" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="8"><div align="center">FACILITY : <?=$facname?></div></td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">Month / Year : <?=$month?> <?=$yr?></div></td>
    </tr>
  </table>
  <br />
<?

$sql_1=mysql_fetch_array(mysql_query("select count(*) as ahr from tblorderdetails where fldFacilityName='$facname' AND fldAfterhours=1 AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$ahr=$sql_1['ahr'];

$cnt=0;
$sql_1="select * from tblorderdetails where fldFacilityName='$facname' AND fldDate >= '$st_date' AND fldDate < '$end_date'";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$dt_w=$row_new['fldDate'];
$sql_temp=mysql_fetch_array(mysql_query("SELECT WEEKDAY('$dt_w') as wk"));
$day_of_the_week = $sql_temp['wk'];
if($day_of_the_week==5 || $day_of_the_week==6)
$cnt++;
}

$twend=$cnt;

$sql_1=mysql_fetch_array(mysql_query("select count(*) as pps from tblorderdetails where fldFacilityName='$facname' AND fldpps!='' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$tpps=$sql_1['pps'];

$sql_1="select distinct fldPatientID from tblorderdetails where fldFacilityName='$facname' AND fldDate >= '$st_date' AND fldDate < '$end_date'";
$res = mysql_query($sql_1) or die (mysql_error());
$tpt = mysql_num_rows($res);

$sql_1=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure1 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_2=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure2 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_3=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure3 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_4=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure4 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_5=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure5 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_6=mysql_fetch_array(mysql_query("select count(*) as cst from tblorderdetails where fldFacilityName='$facname' AND fldProcedure6 LIKE '%chest%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$tcst=$sql_1['cst']+$sql_2['cst']+$sql_3['cst']+$sql_4['cst']+$sql_5['cst']+$sql_6['cst'];

$sql_1=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure1 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_2=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure2 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_3=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure3 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_4=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure4 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_5=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure5 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_6=mysql_fetch_array(mysql_query("select count(*) as ekg from tblorderdetails where fldFacilityName='$facname' AND fldProcedure6 LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$tekg=$sql_1['ekg']+$sql_2['ekg']+$sql_3['ekg']+$sql_4['ekg']+$sql_5['ekg']+$sql_6['ekg'];

$sql_1=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure1 != '' AND fldProcedure1 NOT LIKE '%chest%' AND fldProcedure1 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_2=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure2 != '' AND fldProcedure2 NOT LIKE '%chest%' AND fldProcedure2 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_3=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure3 != '' AND fldProcedure3 NOT LIKE '%chest%' AND fldProcedure3 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_4=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure4 != '' AND fldProcedure4 NOT LIKE '%chest%' AND fldProcedure4 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_5=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure5 != '' AND fldProcedure5 NOT LIKE '%chest%' AND fldProcedure5 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$sql_6=mysql_fetch_array(mysql_query("select count(*) as oth from tblorderdetails where fldFacilityName='$facname' AND fldProcedure6 != '' AND fldProcedure6 NOT LIKE '%chest%'  AND fldProcedure6 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$toth=$sql_1['oth']+$sql_2['oth']+$sql_3['oth']+$sql_4['oth']+$sql_5['oth']+$sql_6['oth'];

$tall=$tcst+$tekg+$toth;

$sql_1=mysql_fetch_array(mysql_query("select count(*) as pos from tblorderdetails where fldFacilityName='$facname' AND (fldsign1=1 OR fldsign2=1 OR fldsign3=1 OR fldsign4=1 OR fldsign5=1 OR fldsign6=1) AND fldProcedure1 NOT LIKE '%ekg%' AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$tpfx=$sql_1['pos'];

$sql_1=mysql_fetch_array(mysql_query("select count(*) as pcct from tblorderdetails where fldFacilityName='$facname' AND (fldProcedure1 LIKE '%chest%' OR fldProcedure2 LIKE '%chest%' OR fldProcedure3 LIKE '%chest%' OR fldProcedure4 LIKE '%chest%' OR fldProcedure5 LIKE '%chest%' OR fldProcedure6 LIKE '%chest%' ) AND (fldsign1=1 OR fldsign2=1 OR fldsign3=1 OR fldsign4=1 OR fldsign5=1 OR fldsign6=1) AND fldDate >= '$st_date' AND fldDate < '$end_date'"));
$tpcct=$sql_1['pcct'];

?>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <th width="10%">Total "After Hours" Patients</th>
      <th width="10%">Total PPS</th>
      <th width="10%">Total Patient Visits</th>
      <th width="20%" colspan="2">Type of Exam Totals</th>
      <th width="20%" colspan="2">Results</th>
    </tr>
    <tr>
      <td rowspan="4"><div align="center"><?=$ahr?></div></td>
      <td rowspan="4"><div align="center"><?=$tpps?></div></td>
      <td rowspan="4"><div align="center"><?=$tall?></div></td>
      <td>Total Chest =</td>
      <td><div align="center"><?=$tcst?></div></td>
      <td>Total Positive FX =</td>
      <td><div align="center"><?=$tpfx?></div></td>
    </tr>
    <tr>
      <td>Total EKG =</td>
      <td><div align="center"><?=$tekg?></div></td>
      <td>Total Positive Chest =</td>
      <td><div align="center"><?=$tpcct?></div></td>
    </tr>
    <tr>
      <td>Total Other =</td>
      <td><div align="center"><?=$toth?></div></td>
    </tr>
    <tr>
      <td>Total of All Exams =</td>
      <td><div align="center"><?=$tall?></div></td>
    </tr>
</table>
  <HR>
<? } ?>
</td></tr></table>
<?
?>
</body>
</html>