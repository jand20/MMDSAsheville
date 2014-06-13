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
$sql="select * from tblorderdetails where fldSchDate >= '$st_date' AND fldSchDate <= '$end_date' AND  fldCDRequested = 1 order by fldCDDate";
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
      <td colspan="12"><div align="center">CD Requested Report</div></td>
    </tr>
	<tr>
	  <td width="5%">&nbsp;</td>
	  <td width="15%"><div align="center">Patient Name</div></td>
	  <td width="10%"><div align="center">Facility</div></td>
	  <td width="30%"><div align="center">Facility Address</div></td>
	  <td width="10%"><div align="center">Date Exam Needed</div></td>
	  <td width="10%"><div align="center">Date CD Requested</div></td>
	  <td width="10%"><div align="center">Date CD Shipped</div></td>
	  <td width="30%"><div align="center">CD Ship to Location</div></td>
	</tr>
<?
$sno=0;
$sql_1="select * from tblorderdetails where fldSchDate >= '$st_date' AND fldSchDate <= '$end_date' AND  fldCDRequested = 1 order by fldCDDate";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$sno+=1;
$facy=$row_new['fldFacilityName'];
$sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldFacilityName='$facy'"));
$facname=$sql_fac['fldFacilityName'];
$facaddr=$sql_fac['fldAddressLine1'] . "</br>" . $sql_fac['fldAddressLine2'] . "</br>" . $sql_fac['fldAddressCity'] . "</br>" . $sql_fac['fldAddressState'] . "</br>" . $sql_fac['fldAddressZip'];
?>
	<tr>
	  <td><div align="center"><?=$sno?></div></td>
	  <td><div align="center"><?=$row_new['fldLastName']?> <?=$row_new['fldFirstName']?></div></td>
	  <td><div align="center"><?=$facname?></div></td>
	  <td><div align="center"><?=$facaddr?></div></td>
	  <td><div align="center">
	  <?echo strftime("%m-%d-%Y", strtotime($row_new['fldSchDate']))?>
	  </div></td>
	  <td><div align="center">
				<?
				$e1dt=$row_new['fldCDDate'];
				if($e1dt > '1900-01-01')
				{
				echo strftime("%m-%d-%Y", strtotime($e1dt));
				}
				else
				{
				echo '&nbsp;';
				}
				?>
	  </div></td>
	  <td><div align="center">
				<?
				$e2dt=$row_new['fldCDShipDate'];
				if($e2dt > '1900-01-01')
				{
				echo strftime("%m-%d-%Y", strtotime($e2dt));
				}
				else
				{
				echo '&nbsp;';
				}
				?>
	  </div></td>
	  <td><div align="center"><?=$row_new['fldCDAddr']?></div></td>
	</tr>
<? } ?>
  </table>
  <HR>
<? } ?>
</td></tr></table>
</body>
</html>