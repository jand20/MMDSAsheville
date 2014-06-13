<?php session_start();
include "config.php";
$user = $_SESSION['user'];
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
$sql="select * from tblorderdetails where fldFacilityName = '$d' AND (
(fldExp1Date >= '$st_date' AND fldExp1Date <= '$end_date') OR
(fldExp2Date >= '$st_date' AND fldExp2Date <= '$end_date') OR
(fldExp3Date >= '$st_date' AND fldExp3Date <= '$end_date'))
";

//echo $sql;

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
  <table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="6"><div align="center">Exception Report</div></td>
    </tr>
	<tr>
	  <td width="5%">&nbsp;</td>
	  <td width="25%"><div align="center">Patient Name</div></td>
	  <td width="10%"><div align="center">Patient ID</div></td>
	  <td width="15%"><div align="center">Exception</div></td>
	  <td width="10%"><div align="center">Exception Date</div></td>
	  <td width="10%"><div align="center">Exception Rescheduled</div></td>
	</tr>
<?
$sno=0;
$sql_1="select * from tblorderdetails where fldFacilityName = '$d' AND (
(fldExp1Date >= '$st_date' AND fldExp1Date <= '$end_date') OR
(fldExp2Date >= '$st_date' AND fldExp2Date <= '$end_date') OR
(fldExp3Date >= '$st_date' AND fldExp3Date <= '$end_date'))
";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$pr1 = $row_new['fldException1'];
if($row_new['fldExp1Date'] > $st_date && $row_new['fldExp1Date'] <= $end_date)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?=$row_new['fldException1']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldExp1Date']))?></div></td>
	  <td><div align="center"><?=$row_new['fldExp1Resh']?></div></td>
	</tr>
<? }
$pr2 = $row_new['fldException2'];
if($row_new['fldExp2Date'] > $st_date && $row_new['fldExp2Date'] <= $end_date)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?=$row_new['fldException2']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldExp2Date']))?></div></td>
	  <td><div align="center"><?=$row_new['fldExp2Resh']?></div></td>
	</tr>
<? }
$pr3 = $row_new['fldException3'];
if($row_new['fldExp3Date'] > $st_date && $row_new['fldExp3Date'] <= $end_date)
{
$sno+=1;
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$row_new['fldPatientID']?></div></td>
	  <td><div align="center"><?=$row_new['fldException3']?></div></td>
	  <td><div align="center"><?echo strftime("%m-%d-%Y", strtotime($row_new['fldExp3Date']))?></div></td>
	  <td><div align="center"><?=$row_new['fldExp3Resh']?></div></td>
	</tr>
<? }
} ?>
  </table>
  <HR>
<? } ?>
</td></tr></table>
</body>
</html>