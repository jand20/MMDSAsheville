<?
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include 'config.php';
$user=$_SESSION['user'];
?>
<?
$id=$_GET['id'];
$sql_1=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldid='$id'"));
?>
<link href='tablesort.css'  rel="stylesheet" type="text/css" />
<form action="" method="post">
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<tbody>
  <tr>
    <td height="20" colspan="5"></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">Contract #</td>
    <td width="20%"><?=$sql_1['fldcontract']?></td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">Bill Amount</td>
    <td width="20%"><input type="text" <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="billamt" value="<?=$sql_1['fldbillamount']?>"></td>
    <td width="20%"><input type="text" name="billdate" readonly="yes" value="<?=$sql_1['fldbilldate']?>"></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">Payment 1</td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay1amt" value="<?=$sql_1['fldpayment1']?>"></td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay1date" value="<?=$sql_1['fldpay1date']?>"></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">Payment 2</td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay2amt" value="<?=$sql_1['fldpayment2']?>"></td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay2date" value="<?=$sql_1['fldpay2date']?>"></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">Payment 3</td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay3amt" value="<?=$sql_1['fldpayment3']?>"></td>
    <td width="20%"><input type="text"  <? if($_SESSION['role'] =='biller') { ?> readonly='yes' <? } ?> name="pay3date" value="<?=$sql_1['fldpay3date']?>"></td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
   <? if($_SESSION['role'] !='biller') { ?>
  <tr>
    <td colspan="5" align="middle"><input type="submit" name="submit" value="Update"></td>
  </tr>
  <? } else { ?>
  <tr>
    <td colspan="5" align="middle"><input type="submit" name="back" value="Back"></td>
  </tr>
  <? } ?>
    <td height="10" colspan="5"></td>
  </tr>
  </tbody>
</table>
</form>
<?
if($_REQUEST['submit']!='')
{
$date1=date('Y-m-d' , time());
$sql_insert = mysql_query("update tblfacbilling set
fldpayment1='".strip_tags(addslashes($_REQUEST['pay1amt']))."',
fldpayment2='".strip_tags(addslashes($_REQUEST['pay2amt']))."',
fldpayment3='".strip_tags(addslashes($_REQUEST['pay3amt']))."',
fldpay1date='".strip_tags(addslashes($_REQUEST['pay1date']))."',
fldpay2date='".strip_tags(addslashes($_REQUEST['pay2date']))."',
fldpay3date='".strip_tags(addslashes($_REQUEST['pay3date']))."'
where fldid='$id'
");
$redirecturl = "?pg=55";
header("Location:".$redirecturl);
}
if($_REQUEST['back']!='')
{
$redirecturl = "?pg=55";
header("Location:".$redirecturl);
}
?>

