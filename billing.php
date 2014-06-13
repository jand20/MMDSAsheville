<?
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include 'config.php';
header('Refresh: 120');
$user=$_SESSION['user'];
include('ps_pagination.php');
?>
<?
if(isset($_GET['d']))
{
$div=$_GET['d'];
}
else {
$div="%";
}
?>
<link href='tablesort.css'  rel="stylesheet" type="text/css" />
<link href="paginate.css"   rel="stylesheet" type="text/css" />
<style>
.fdtablePaginatorWrapTop { display:none; }
</style>
<form action="" method="post">
<?
$yr=2010;
//include 'proccalc.php';
$user = $_SESSION['user'];
$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));
$facid=$sql_values_fetch['fldID'];
if($_SESSION['role'] =='admin')
{
$sql_main="SELECT distinct fldContract from tblfacility where fldfacilityname in (select distinct fldfacilityname from tblorderdetails where fldfacilityname in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div'))";
$sql_1=mysql_fetch_array(mysql_query("select count(*) as pos from tblorderdetails where fldfacilityname in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div')"));
}
if($_SESSION['role'] =='biller')
{
$sql_main="SELECT distinct fldContract from tblfacility where fldfacilityname in (SELECT fldfacilityname from tblorderdetails where fldfacilityname in (select fldfacility from tbluserfacdetails where flduserid='$facid'))";
$sql_1=mysql_fetch_array(mysql_query("select count(*) as pos from tblorderdetails where fldfacilityname in (select fldfacility from tbluserfacdetails where flduserid='$facid')"));
}
$num=$sql_1['pos'];

$yr1=$yr + 1;
$st1=$yr . '-01-01';
$st2=$yr . '-02-01';
$st3=$yr . '-03-01';
$st4=$yr . '-04-01';
$st5=$yr . '-05-01';
$st6=$yr . '-06-01';
$st7=$yr . '-07-01';
$st8=$yr . '-08-01';
$st9=$yr . '-09-01';
$st10=$yr . '-10-01';
$st11=$yr . '-11-01';
$st12=$yr . '-12-01';
$st13=$yr1 . '-01-01';

//echo $sql;
//$conn = mysql_connect('localhost', $host1, '');
//mysql_select_db($table1,$conn);
//$res = mysql_query($sql) or die (mysql_error());
//$num = mysql_num_rows($res);
//$pgr = "pg=20&all=" . $all . "&val=0&ord=2";
//$pager = new PS_Pagination($conn, $sql, 10, 5, $pgr);
//if(empty($_GET['all']) || $_GET['page']=='all') {
//$pager = new PS_Pagination($conn, $sql, $num, 5, $pgr);
//}
//$rs = $pager->paginate();
?>
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<thead>
  <tr>
    <th width="16%" class="sortable-text">Facility / Contract #</th>
    <th width="7%" class="sortable-text">JAN</th>
    <th width="7%" class="sortable-text">FEB</th>
    <th width="7%" class="sortable-text">MAR</th>
    <th width="7%" class="sortable-text">APR</th>
    <th width="7%" class="sortable-text">MAY</th>
    <th width="7%" class="sortable-text">JUN</th>
    <th width="7%" class="sortable-text">JUL</th>
    <th width="7%" class="sortable-text">AUG</th>
    <th width="7%" class="sortable-text">SEP</th>
    <th width="7%" class="sortable-text">OCT</th>
    <th width="7%" class="sortable-text">NOV</th>
    <th width="7%" class="sortable-text">DEC</th>
  </tr>
  <? if($_SESSION['role'] =='admin') { ?>
  <tr>
    <th colspan="2">&nbsp;</th>
    <th colspan="2">Select Division Name</th>
    <th colspan="4">
	   <select name="divisionname" id="divisionname" class="myselect3">
       <option selected="selected" value="">Select</option>
       <?
         $sql="SELECT distinct fldDivisionName FROM tblfacility order by fldDivisionName";
	 $result = mysql_query($sql);
	 while($row = mysql_fetch_array($result))
	 {?>
       <option value="<?=$row['fldDivisionName']?>"><?=$row['fldDivisionName']?></option>
       <? } ?>
	 </select>
       </th>
       <th colspan="5"><input name="div" id="div" type="submit" value="Load" /></th>
    </tr>
  <? } ?>
</thead>
<?
if(!$num)
{
?>
<tbody>
  <tr><td colspan="13" class="total" height="50">No Records Found</td></tr>
</tbody></table>
<?
}
else
{
?>
 <tbody>
 <?  $result = mysql_query($sql_main);
  while($row = mysql_fetch_array($result)) {
$fac=$row['fldContract'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st1' and examdate <'$st2'"));
$jan=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st2' and examdate <'$st3'"));
$feb=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st3' and examdate <'$st4'"));
$mar=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st4' and examdate <'$st5'"));
$apr=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st5' and examdate <'$st6'"));
$may=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st6' and examdate <'$st7'"));
$jun=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st7' and examdate <'$st8'"));
$jul=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st8' and examdate <'$st9'"));
$aug=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st9' and examdate <'$st10'"));
$sep=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st10' and examdate <'$st11'"));
$oct=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st11' and examdate <'$st12'"));
$nov=$sql_1['tot'];
$sql_1=mysql_fetch_array(mysql_query("select sum(amount) as tot from fldproc where facility='$fac' and examdate >='$st12' and examdate <'$st13'"));
$dec=$sql_1['tot'];

$dd=date('d' , time());
$date2=date('Y-m-d' , time());
	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='01'"));
	$cnt=$sql_2['cnt'];
//echo $jan;
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='01',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($jan))."',
		fldpaid='Pending'
		");
        $jan_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st1&ed=$st2'>Pending</a>" . ' / ' . $jan;
		if($jan==0)
		$jan_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='01'"));
	$nodays='Unpaid' . ' - ';
	$id = $sql_3['fldid'];
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	$jan_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st1&ed=$st2'>" . $sql_3['fldpaid'] . '</a>' . ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$jan_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $jan_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st1&ed=$st2'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='02'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='02',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($feb))."',
		fldpaid='Pending'
		");
        $feb_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st2&ed=$st3'>Pending</a>" . ' / ' . $feb;
		if($feb==0)
		$feb_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='02'"));
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$feb_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st2&ed=$st3'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$feb_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $feb_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st2&ed=$st3'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='03'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='03',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($mar))."',
		fldpaid='Pending'
		");
                $mar_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st3&ed=$st4'>Pending</a>" . ' / ' . $mar;
		if($mar==0)
		$dec_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='03'"));
	$nodays='Unpaid' . ' - ';
	$id = $sql_3['fldid'];
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$mar_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st3&ed=$st4'>" . $sql_3['fldpaid'] . '</a>' . ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$mar_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $mar_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st3&ed=$st4'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='04'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='04',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($apr))."',
		fldpaid='Pending'
		");
                $apr_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st4&ed=$st5'>Pending</a>" . ' / ' . $apr;
		if($apr==0)
		$apr_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='04'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$apr_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st4&ed=$st5'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$apr_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $apr_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st4&ed=$st5'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='05'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='05',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($may))."',
		fldpaid='Pending'
		");
                $may_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st5&ed=$st6'>Pending</a>" . ' / ' . $may;
		if($may==0)
		$may_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='05'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$may_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st5&ed=$st6'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$may_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $may_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st5&ed=$st6'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='06'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='06',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($jun))."',
		fldpaid='Pending'
		");
                $jun_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st6&ed=$st7'>Pending</a>" . ' / ' . $jun;
		if($jun==0)
		$jun_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='06'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );

	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';

	$jun_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st6&ed=$st7'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$jun_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $jun_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st6&ed=$st7'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='07'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='07',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($jul))."',
		fldpaid='Pending'
		");
                $jul_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st7&ed=$st8'>Pending</a>" . ' / ' . $jul;
		if($jul==0)
		$jul_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='07'"));

	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );

	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$jul_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st7&ed=$st8'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$jul_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $jul_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st7&ed=$st8'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='08'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='08',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($aug))."',
		fldpaid='Pending'
		");
        $aug_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st8&ed=$st9'>Pending</a>" . ' / ' . $aug;
		if($aug==0)
		$aug_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='08'"));
	$nodays='Unpaid' . ' - ';
	$id = $sql_3['fldid'];
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$aug_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st8&ed=$st9'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$aug_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $aug_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st8&ed=$st9'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='09'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='09',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($sep))."',
		fldpaid='Pending'
		");
                $sep_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st9&ed=$st10'>Pending</a>" . ' / ' . $sep;

		if($sep==0)
		$sep_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='09'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$sep_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st9&ed=$st10'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$sep_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $sep_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st9&ed=$st10'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='10'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='10',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($oct))."',
		fldpaid='Pending'
		");
                $oct_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st10&ed=$st11'>Pending</a>" . ' / ' . $oct;
		if($oct==0)
		$oct_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='10'"));
		$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$oct_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st10&ed=$st11'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$oct_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $oct_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st10&ed=$st11'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='11'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='11',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($nov))."',
		fldpaid='Pending'
		");
                $nov_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st11&ed=$st12'>Pending</a>" . ' / ' . $nov;
		if($nov==0)
		$nov_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='11'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$nov_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st11&ed=$st12'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$nov_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $nov_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st11&ed=$st12'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

	$sql_2=mysql_fetch_array(mysql_query("select count(*) as cnt from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='12'"));
	$cnt=$sql_2['cnt'];
	if($cnt==0)
	{
		$sql_insert = mysql_query("insert into tblfacbilling set
		fldcontract='".strip_tags(addslashes($fac))."',
		fldyear='".strip_tags(addslashes($yr))."',
		fldmonth='12',
		flddate='".strip_tags(addslashes($dd))."',
		fldbillamount='".strip_tags(addslashes($dec))."',
		fldpaid='Pending'
		");
        $dec_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st12&ed=$st13'>Pending</a>" . ' / ' . $dec;
		if($dec==0)
		$dec_det="No Payment Due";
	}
	else
	{
	$sql_3=mysql_fetch_array(mysql_query("select * from tblfacbilling where fldcontract='$fac' and fldyear='$yr' and fldmonth='12'"));
	$id = $sql_3['fldid'];
	$nodays='Unpaid' . ' - ';
	$date1 = $sql_3['fldbilldate'];
	$days = round( abs(strtotime($date2) - strtotime($date1))/ 86400 );


	if($days>30)
	$nodays='More than 30 Days' . ' - ';
	if($days>60)
	$nodays='More than 60 Days' . ' - ';
	if($days>90)
	$nodays='More than 90 Days' . ' - ';

	$pay=$sql_3['fldbillamount'] - $sql_3['fldpayment1'] - $sql_3['fldpayment2'] - $sql_3['fldpayment3'];
	$pay=round($pay,2);
	if($pay==0)
	{
	$nodays='Paid in Full';
	$pay='';
	}
	if($pay < $sql_3['fldbillamount'] && $pay !=0)
	$nodays='Partial' . ' - ';
	$dec_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st12&ed=$st13'>" . $sql_3['fldpaid'] . '</a>' .  ' / ' . $nodays . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	if($sql_3['fldbillamount']==0)
	$dec_det="No Payment Due";
    if($sql_3['fldpaid']=='Pending' && $sql_3['fldbillamount']!=0)
    $dec_det="<a class='<? echo $tdclass;?>' href='index.php?pg=56&id=$fac&sd=$st12&ed=$st13'>Pending</a>" . ' / ' . "<a class='<? echo $tdclass;?>' href='index.php?pg=57&id=" . $id . "'>" . $pay . '</a>';
	}

$facility='';
$sql_con="SELECT distinct fldfacilityname from tblfacility where fldContract = '$fac'";
$result_con = mysql_query($sql_con);
while($row_con = mysql_fetch_array($result_con)) {
$facility = $facility . '<br />' . $row_con['fldfacilityname'];
}
$facility = $facility . ' / ' . $fac;

?>
  <tr>
    <td><?=strtoupper($facility)?></td>
    <td><?=$jan_det?></td>
    <td><?=$feb_det?></td>
    <td><?=$mar_det?></td>
    <td><?=$apr_det?></td>
    <td><?=$may_det?></td>
    <td><?=$jun_det?></td>
    <td><?=$jul_det?></td>
    <td><?=$aug_det?></td>
    <td><?=$sep_det?></td>
    <td><?=$oct_det?></td>
    <td><?=$nov_det?></td>
    <td><?=$dec_det?></td>
  </tr>
	<? } ?>
  </tbody>
</table><? } ?>
</form>
<table height="10" border="0"><tr><td class="nb">&nbsp;</td></tr></table>
<?
if($_REQUEST['div']!='')
{
$div=$_REQUEST['divisionname'];
$redirecturl = $_SERVER['HTTP_REFERER'];
$redirecturl .='&d=' . $div;
header("Location:".$redirecturl);
}
?>

