<?
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include 'config.php';
$user=$_SESSION['user'];
?>
<?
function phone_number($sPhone){
    $sPhone = ereg_replace("[^0-9]",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.") ".$sPrefix."-".$sNumber;
    return($sPhone);
}
$startdate=$_GET['sd'];
$enddate=$_GET['ed'];
$sDate = split('-', $startdate);
$yr=$sDate[0];
$mon=$sDate[1];
$d=$_GET['id'];

?>
<link href='tablesort.css'  rel="stylesheet" type="text/css" />
<form action="" method="post">
<?
include 'proccalc.php';
$con=$_GET['id'];
$sql_main="select * from fldproc where facility='$con' and examdate >= '$startdate' and examdate < '$enddate'";
$sql_1=mysql_fetch_array(mysql_query("select count(*) as cnt from fldproc where facility='$con' and examdate >= '$startdate' and examdate < '$enddate'"));
$num=$sql_1['cnt'];

$sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldContract='$con'"));
$facname=$sql_fac['fldFacilityName'];
$facaddr1=$sql_fac['fldAddressLine1'] . " " . $sql_fac['fldAddressLine2'];
$facaddr2=$sql_fac['fldAddressCity'] . ", " . $sql_fac['fldAddressState'] . ", " . $sql_fac['fldAddressZip'];
$facph=phone_number($sql_fac['fldPhoneNumber']);
$rcode=$sql_fac['fldRcode'];
$zone=$sql_fac['fldZone'];
$sql_rcode=mysql_fetch_array(mysql_query("SELECT * FROM tblrcode where fldzone='$zone'"));
$amount=round($sql_rcode['fldamount'],2);

?>
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<thead>
  <tr>
    <th width="10%" class="sortable-text">Contract #</th>
    <th width="10%" class="sortable-text">Patient ID</th>
    <th width="20%" class="sortable-text">Patient Name</th>
    <th width="10%" class="sortable-text">Exam Date</th>
    <th width="20%" class="sortable-text">Procedure Description</th>
    <th width="20%" class="sortable-text">CPT Code</th>
    <th width="10%" class="sortable-text">Amount</th>
  </tr>
</thead>
<?
if(!$num)
{
?>
<tbody>
  <tr><td colspan="6" class="total" height="50">No Records Found</td></tr>
</tbody></table>
<?
}
else
{
?>
 <tbody>
<?
$famount=0;
$result = mysql_query($sql_main);
while($row = mysql_fetch_array($result)) {
$oid=$row['id'];
$sql_x=mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$oid'"));
$name=$sql_x['fldFirstName'] . '&nbsp;' . $sql_x['fldMiddleName'] . ' ' . $sql_x['fldLastName'] . ' ' . $sql_x['fldSurName'];
$pid=$sql_x['fldPatientID'] . '&nbsp;';
$t_amount=$t_amount + $row['amount'];
?>
  <tr>
    <td><?=strtoupper($con)?></td>
    <td><?=$pid?></td>
    <td><?=$name?></td>
    <td><?=$row['examdate']?></td>
    <td><?=$row['proc']?></td>
    <td><?=$row['cpt']?></td>
    <td>$<?=$row['amount']?></td>
  </tr>
<? } ?>
	<tr>
	  <td colspan="6"><b>TOTAL AMOUNT OF PROCEDURE CHARGE</b></td>
	  <td>$<?printf('%02.2f', $t_amount);?></td>
    </tr>
  </tbody>
</table>
&nbsp;
<div align="left"><h5>SET-UP/TRANSPORT FEES :</h1></div>
&nbsp;
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
<thead>
	<tr>
	  <th>DATE OF SERVICE</th>
	  <th>R CODE</th>
	  <th>AMOUNT OF CHARGE</th>
	  <th>TOTAL</th>
	</tr>
</thead>
<tbody>
<?
$tot_count_id = 0;
$tot_amount = 0;
$sql="select distinct examdate from fldproc where examdate >='$startdate' and examdate < '$enddate' and facility='$con' order by examdate";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$date1=$row['examdate'];
$finamount=round($famount,2);
$tot_amount = $tot_amount + $finamount;
?>
	<tr>
	  <td><?=$date1?></td>
	  <td><?=$rcode?></td>
	  <td>$<?printf('%02.2f', $famount);?></td>
	  <td>$<?printf('%02.2f', $finamount);?></td>
    </tr>
<? } ?>
	<tr>
	  <td colspan="3"><b>TOTAL AMOUNT OF SET-UP/TRANSPORT FEES </b></td>
	  <td>$<?printf('%02.2f', $tot_amount);?></td>
    </tr>
 </tbody>
</table>
&nbsp;
<?
$X=$tot_amount+$t_amount;
?>
<div align="left"><h5>TOTAL AMOUNT OF CHARGES FOR THIS MONTH :    $ <?printf('%02.2f', $X);?></h1></div>
&nbsp;
&nbsp;
<table id="order" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="1">
<tbody>
<?
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$con' and fldyear='$yr' and fldmonth='$mon'"));
	$status = $sql_3['fldpaid'];
	if($status!='Final' && $_SESSION['role'] =='admin')
	{
	?>
  <tr>
	    <td>Email ID</td>
	    <td><input type="text" name="email" value="Specify Email ID"></td>
	    <td align="middle"><input type="submit" name="submit" value="Email Facility"></td>
	    <td><input type="button" name="print" value="Print" onclick="window.print()" ></td>
	    <td>&nbsp;</td>
  </tr>
  <? } else if($status=='Final' && $_SESSION['role'] =='admin') { ?>
  <tr>
	    <td width="20%">Email ID</td>
	    <td width="20%"><input type="text" name="email" value="Specify Email ID"></td>
	    <td width="20%" align="middle"><input type="submit" name="resend" value="Resend"></td>
	    <td width="20%"><input type="button" name="print" value="Print" onclick="window.print()" ></td>
	    <td width="20%">&nbsp;</td>
  </tr>
  <? } else if($_SESSION['role'] =='biller') { ?>
  <tr>
	    <td colspan="5" align="middle"><input type="button" name="print" value="Print" onclick="window.print()" ></td>
  </tr>
  <? } ?>
 </tbody>
 </table>
<? } ?>
</form>
<?
if($_REQUEST['submit']!='')
{
$date1=date('Y-m-d' , time());
$sql_insert = mysql_query("update tblfacbilling set
fldbilldate='".strip_tags(addslashes($date1))."',
fldpaid='Final'
where fldcontract='$con' and fldyear='$yr' and fldmonth='$mon'
");
$redirecturl = $_SERVER['HTTP_REFERER'];
header("Location:".$redirecturl);
}
if($_REQUEST['resend']!='')
{
}
?>

