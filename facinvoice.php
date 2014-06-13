<?php session_start();
include "config.php";
include "proccalc.php";
$pg=$_GET['pg'];
$yr=$_GET['dt1'];
$mon=$_GET['dt2'];
$st_date=$yr . '-' . $mon . '-' . '01 00:00:00';
$yr_new=$yr;
if($pg==60)
{
$fname="CALL_REPORT_" . $d . '_' . $mon . '_' . $yr . ".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
}
?>
<?
ob_start();
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

function phone_number($sPhone){
    $sPhone = ereg_replace("[^0-9]",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.") ".$sPrefix."-".$sNumber;
    return($sPhone);
}

$sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldFacilityName='$d'"));
$facname=$sql_fac['fldFacilityName'];
$facaddr1=$sql_fac['fldAddressLine1'] . " " . $sql_fac['fldAddressLine2'];
$facaddr2=$sql_fac['fldAddressCity'] . ", " . $sql_fac['fldAddressState'] . ", " . $sql_fac['fldAddressZip'];
$facph=phone_number($sql_fac['fldPhoneNumber']);
$rcode=$sql_fac['fldRcode'];
$zone=$sql_fac['fldZone'];
$sql_rcode=mysql_fetch_array(mysql_query("SELECT * FROM tblrcode where fldzone='$zone'"));
$amount=round($sql_rcode['fldamount'],2);

$sql_admin=mysql_fetch_array(mysql_query("SELECT * FROM tblsettings where 1"));
$invoice=$sql_admin['fldInvoice'];
$inv=$invoice+1;
$sql_admin_insert = mysql_query("update tblsettings set fldInvoice='".$inv."' where fldInvoice='".$invoice."'");


if($rcode=='standard')
$famount=$amount;
if($rcode=='double')
$famount=$amount * 2;
if($rcode=='no')
$famount=0;
$famount=round($famount,2);
?>
<form action="" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
 <tr><td>
<?
$sql_cnt=mysql_fetch_array(mysql_query("select count(*) as cnt from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d'"));
$valid=$sql_cnt['cnt'];
if($valid>0)
{
?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td colspan="2"><div align="right">&nbsp;</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">REMIT TO</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">&nbsp;</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">TECH CARE X-RAY</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">3717 CARRINGTON PLACE</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">TALLAHASSEE FL 32303</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">&nbsp;</div></td>
	</tr>
	<tr>
	  <td><div align="left"><?=$facname?></div></td>
	  <td><div align="right">&nbsp;</div></td>
	</tr>
	<tr>
	  <td><div align="left"><?=$facaddr1?></div></td>
	  <td><div align="right"><?=$facph?></div></td>
	</tr>
	<tr>
	  <td><div align="left"><?=$facaddr2?></div></td>
	  <td><div align="right">TAX - ID : <?=$sql_fac['fldTaxid']?></div></td>
	</tr>
	<tr>
	  <td><div align="left">CONTRACT NO.: <?=$sql_fac['fldContract']?></div></td>
	  <td><div align="right">INVOICE NO.: INV <?=$invoice?></div></td>
	</tr>
	<tr>
	  <td><div align="left">ATTN : <?=$sql_fac['fldBattn']?></div></td>
	  <td><div align="right"><?=$month?> <?=$yr?></div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="right">&nbsp;</div></td>
	</tr>
	<tr>
	  <td colspan="2"><div align="left"><u>EXAM FEES :</u></div></td>
	</tr>
</table>
&nbsp;
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td><div><b>Date of Service</div></b></td>
<?
$i=0;
$sql="select distinct category from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d' order by examdate";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$cat[$i]=$row['category'];
?>
	  <td><div><b><?=$cat[$i]?></b></div></td>
<? $i++; }
?>
	  <td><div><b>Total # of XRAY</b></div></td>
	  <td><div><b>TOTAL</div></b></td>
	</tr>
<?
$j=0;
$sql="select distinct examdate from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d' order by examdate";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$date1=$row['examdate']; ?>
	<tr>
	  <td><div><?=$date1?></div></b></td>
<?
for($j=0;$j<$i;$j++)
{

$sql_cnt=mysql_fetch_array(mysql_query("select count(*) as cnt from fldproc where examdate ='$date1' and category = '$cat[$j]' and facname='$d'"));
$cunt=$sql_cnt['cnt'];
$count[$j]=$count[$j]+$cunt;
$tot=$tot+$cunt;
?>
	  <td><div><?=$cunt?></div></td>
<?
}
$sql_cnt1=mysql_fetch_array(mysql_query("select count(*) as cnt from fldproc where examdate ='$date1' and facname='$d'"));
$count1=$sql_cnt1['cnt'];
?>
	  <td><div><?=$count1?></div></td>
	  <td><div>&nbsp;</div></td>
	</tr>
<? } ?>
	<tr>
	  <td><div><b>TOTAL</b></div></td>
<?
for($j=0;$j<$i;$j++)
{
?>
	  <td><div><?=$count[$j]?></div></td>
<? } ?>
	  <td><div><b><?=$tot?></b></div></td>
<?
$sql_x=mysql_fetch_array(mysql_query("select sum(amount) as totamt from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d'"));
$totamt=round($sql_x['totamt'],2);
?>
	  <td><div><b>$<?printf('%02.2f', $totamt);?></b></div></td>
</tr>
</table>
&nbsp;
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td colspan="2"><div align="left"><u>SET-UP/TRANSPORT FEES :</u></div></td>
	</tr>
</table>
&nbsp;
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td><div><b>DATE OF SERVICE</b></div></td>
	  <td><div><b>R CODE</b></div></td>
	  <td><div><b>AMOUNT OF CHARGE</b></div></td>
	  <td><div><b>TOTAL</b></div></td>
	</tr>
<?
$tot_count_id = 0;
$tot_amount = 0;
$sql="select distinct examdate from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d' order by examdate";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$date1=$row['examdate'];
$count_id=0;
$sql_id="select distinct id from fldproc where examdate ='$date1' and facname='$d'  order by examdate";
$result_id = mysql_query($sql_id);
while($row_id = mysql_fetch_array($result_id))
{
$count_id++;
}
//$finamount=$famount * $count_id;
$finamount=round($famount,2);
$tot_count_id = $tot_count_id + $count_id;
$tot_amount = $tot_amount + $finamount;
?>
	<tr>
	  <td><div><?=$date1?></div></td>
	  <td><div><?=$zone?></div></td>
	  <td><div>$<?printf('%02.2f', $famount);?></div></td>
	  <td><div>$<?printf('%02.2f', $finamount);?></div></td>
    </tr>
<? } ?>
	<tr>
	  <td><div><b>TOTAL</b></div></td>
	  <td><div>&nbsp;</div></td>
	  <td><div>&nbsp;</div></td>
	  <td><div>$<?printf('%02.2f', $tot_amount);?></div></td>
    </tr>
</table>
&nbsp;
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td><div>
<?
echo $tot . ' PERFORMED';
echo '<br/>';
$final_amt=$tot_amount+$totamt;
echo 'BALANCE UPON RECEIPT    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $';printf('%02.2f', $final_amt);
?>
</div></td>
    </tr>
</table>
&nbsp;
<div align="center"><b>EXAM LOG</b></div>
&nbsp;
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td><div><b>DATE OF SERVICE</b></div></td>
	<td><div><b>PATIENT NAME</b></div></td>
	<td><div><b>PATIENT ID</b></div></td>
	<td><div><b>EXAM</b></div></td>
	<td><div><b>CPT Code</b></div></td>
	<td><div><b>Rate</b></div></td>
  </tr>
<?
$sql="select * from fldproc where examdate >='$st_date' and examdate < '$end_date' and facname='$d' order by examdate";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$oid=$row['id'];
$sql_x=mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$oid'"));
$name=$sql_x['fldFirstName'] . '&nbsp;' . $sql_x['fldMiddleName'] . ' ' . $sql_x['fldLastName'] . ' ' . $sql_x['fldSurName'];
$pid=$sql_x['fldPatientID'] . '&nbsp;';
$rate_x=round($row['amount'], 2);
?>
  <tr>
	<td><div><?=$row['examdate']?></div></td>
	<td><div><?=$name?></div></td>
	<td><div><?=$pid?></div></td>
	<td><div><?=$row['proc']?></div></td>
	<td><div><?=$row['cpt']?></div></td>
	<td><div>$<?printf('%02.2f',$rate_x );?></td>
  </tr>
<? } ?>
</table>
<?
}
else
{
?>
<div align="center"><b>Nothing to Report</b></div>
<? } ?>
</td></tr>
</table>
<?
$out2 = ob_get_contents();
ob_end_clean();
echo $out2;
$pattern = "/(<[^>]+class=)\"([^\"]*)\"/i";
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
<tr><td height="10">&nbsp;</td></tr>
<tr>
    <td><div align="center"><input type="submit" name="submit" value="E-Mail"></div></td>
</tr>
<tr><td height="10">&nbsp;</td></tr>
</table>
</form>

<?php

if($_REQUEST['submit']!='')
{
$redirecturl = "index.php?pg=60&d=$d&dt1=$dt1&dt2=$dt2";
header("location:".$redirecturl);
}
?>