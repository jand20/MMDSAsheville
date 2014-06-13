<?php session_start();
include "config.php";
$st_date=$dt1 . " 00:00:00";
$end_date=$dt2 . " 23:59:59";
$fname="PARTA_REPOT_" . $d . '_' . $dt1 . '_' . $dt2 . ".xls";
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
if($d!='all')
{
$sql="select distinct fldFacilityName from tblorderdetails where fldFacilityName='$d' AND fldExamDate >= '$st_date' AND fldExamDate < '$end_date'";
}
else
{
$sql="select distinct fldFacilityName from tblorderdetails where fldExamDate >= '$st_date' AND fldExamDate < '$end_date'";
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
$facadminname=$sql_fac['fldAdminName'];
$facphone=$sql_fac['fldPhoneNumber'];
?>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="12"><div align="center">Weekly Facility Billing Information</div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="left"><b>To : Medical Records Billing Supervisor</b></div></td>
    </tr>
    <tr>
      <td colspan="12"><div align="center">&nbsp;</div></td>
    </tr>

    <tr>
      <td colspan="12"><div align="left">Please return this form to via fax to MD Imaging, Inc. as soon as possible, so that we can expediate<br/>
      the information you need to complete your billing, as well as ours. The return fax number is 816-455-2902 <br />
      If you need help or have question with this form, please call 816-413-8355.</div></td>
    </tr>
    <tr>
      <td colspan="12">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="12"><div align="left">Please place an X in appropriate column across from the patient name indicating what payor source this <br />
      patient's exam should be billed under. Please sign, date the document, and <b><u>fax it back</u></b> to us at 816-455-2902.<br />
      If you need help or have question with this form, please call 816-413-8355.</div></td>
    </tr>
    <tr>
      <td colspan="12">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td colspan="8"><div align="center">Facility Name : <?=$facname?> </div></td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">Contact Person : <?=$facadminname?></div></td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">Telephone Number : <?=$facphone?></div></td>
    </tr>
	<tr>
	  <td width="10">&nbsp;</td>
	  <td width="10%">&nbsp;</td>
	  <td width="15%">&nbsp;</td>
	  <td width="10%"><div align="center">Bill to Facility</div></td>
	  <td width="10%"><div align="center">Bill to Facility</div></td>
	  <td width="10%"><div align="center">Bill to Carrier</div></td>
	  <td width="10%"><div align="center">HOSPICE INFO</div></td>
	  <td width="25%">&nbsp;</td>
	</tr>
	<tr>
	  <td><div align="center">DOS</div></td>
	  <td><div align="center">PATIENT'S NAME</div></td>
	  <td><div align="center">EXAM</div></td>
	  <td><div align="center">Medicare Part A</div></td>
	  <td><div align="center">HMO/VA Contract Bill Facility</div></td>
	  <td><div align="center">Medicaid/ Medicare Part B / HMO</div></td>
	  <td><div align="center">Hospice Name</div></td>
	  <td>&nbsp;</td>
	</tr>
<?
$sno=0;
$sql_1="select * from tblorderdetails where fldFacilityName='$facname' AND fldExamDate >= '$st_date' AND fldExamDate < '$end_date' ORDER BY fldExamDate";
$result_1 = mysql_query($sql_1);
while($row_new = mysql_fetch_array($result_1))
{
$prc= '&nbsp;';
if($row_new['fldProcedure1']!='') { $prc=$row_new['fldProcedure1'];$cnt++; }
if($row_new['fldProcedure2']!='') { $prc.='<br/>' . $row_new['fldProcedure2']; }
if($row_new['fldProcedure3']!='') { $prc.='<br/>' . $row_new['fldProcedure3']; }
if($row_new['fldProcedure4']!='') { $prc.='<br/>' . $row_new['fldProcedure4']; }
if($row_new['fldProcedure5']!='') { $prc.='<br/>' . $row_new['fldProcedure5']; }
if($row_new['fldProcedure6']!='') { $prc.='<br/>' . $row_new['fldProcedure6']; }
$name=$row_new['fldFirstName'] . '&nbsp;' . $row_new['fldMiddleName'] . ' ' . $row_new['fldLastName'] . ' ' . $row_new['fldSurName'];
?>
	<tr>
	  <td><div align="center"><?=$row_new['fldExamDate']?></div></td>
	  <td><div align="center"><?=$name?></div></td>
	  <td><div align="center"><?=$prc?></div></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
<? } ?>
  </table>
  <HR>
<? } ?>
</td></tr></table>
</body>
</html>