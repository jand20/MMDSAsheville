<?
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include 'config.php';
header('Refresh: 120');
$user=$_SESSION['user'];
include('ps_pagination.php');
if($_SESSION['role'] =='biller') {
$redirecturl = "?pg=55";
header("Location:".$redirecturl);
}
?>
<script type="text/javascript">
function search_prompt() {
	var retVal=""
	var valReturned;
	retVal=showModalDialog('searchpop1.html');
	valReturned=retVal;
	location.replace(valReturned);
}
</script>
<?
if(isset($_GET['d']))
{
$div=$_GET['d'];
}
else {
$div="%";
}

$user = $_SESSION['user'];
$facility=$_SESSION['facility'];
$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));
$orphy=$sql_values_fetch['fldRealName'];
$facid=$sql_values_fetch['fldID'];

function formatDate($dDate){
$dNewDate = strtotime($dDate);
return date('Y-m-d H:i',$dNewDate);
}
$curtime=date("Y-m-d",time());
$curdate=formatdate($curtime);

//SonIT add
//if orderingphysician
if($_SESSION['role'] =='orderingphysician')
{
	//we just build slq for orderingphysician, LOL, i just copy from current code
	//we don't need copy code from this to that, LOL. Just check not set all var -> default
	if(!isset($_GET['all']) || $_GET['all']=='all') {
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' AND fldAuthorized = '0' order by ";
		
	}
	else if($_GET['all']=='week') {

		$stdate=date('c',strtotime(date('Y')."W".date('W')."0"));
		$etdate=date('c',strtotime(date('Y')."W".date('W')."7"));
		$sdate = strftime("%Y-%m-%d", strtotime($stdate));
		$edate = strftime("%Y-%m-%d", strtotime($etdate));

		$sdate .=" 00:00:00";
		$edate .=" 23:59:59";
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' and fldSchDate >= '$sdate' and fldSchDate <= '$edate' AND fldAuthorized = '0' order by ";
	}
	else if($_GET['all']=='month') {

		$curtime=date("Y-m-d",time());
		$sDate = split('-', $curtime);
		$num = cal_days_in_month(CAL_GREGORIAN, $sDate[1], $sDate[0]) ;
		$stdate=$sDate[0].'-'.$sDate[1].'-01 00:00:00';
		$enddate=$sDate[0].'-'.$sDate[1].'-'.$num. ' 23:59:59';

		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' and fldSchDate >= '$stdate' and fldSchDate <= '$enddate' AND fldAuthorized = '0' order by ";
	}
	else if($_GET['all']=='nondis') {

		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' AND fldAuthorized = '0'  AND fldDispatched=0 order by ";
	}

}
else
{

	//keep current process
	//we don't need remove line check
	//if($_SESSION['role'] =='orderingphysician')
	//$sql = "...";
	// in case we use it in future, leave it now.

	if($_GET['all']=='all') {
		if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='coder')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6, fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3 from tblorderdetails where fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div') order by ";
		if($_SESSION['role'] =='facilityuser')
		{
			$sql = "select a.*
                            from tblorderdetails AS a
                            INNER JOIN tbluserfacdetails AS b ON a.fldFacilityName = b.fldFacility AND b.flduserid = '$facid'
                            order by ";
			
		}
							
		if($_SESSION['role'] =='orderingphysician')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' AND fldAuthorized = '0' order by ";
		if($_SESSION['role'] =='technologist')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldTechnologist = '$user' order by ";
	}
	else if($_GET['all']=='week') {

		$stdate=date('c',strtotime(date('Y')."W".date('W')."0"));
		$etdate=date('c',strtotime(date('Y')."W".date('W')."7"));
		$sdate = strftime("%Y-%m-%d", strtotime($stdate));
		$edate = strftime("%Y-%m-%d", strtotime($etdate));

		$sdate .=" 00:00:00";
		$edate .=" 23:59:59";

		if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher'  || $_SESSION['role'] =='coder')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldSchDate >= '$sdate' and fldSchDate <= '$edate' and fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div') order by ";
		if($_SESSION['role'] =='facilityuser')
		$sql = "select a.*
                            from tblorderdetails AS a
                            INNER JOIN tbluserfacdetails AS b ON a.fldFacilityName = b.fldFacility AND b.flduserid = '$facid'
                            WHERE fldSchDate >= '$sdate' and fldSchDate <= '$edate' order by ";
		if($_SESSION['role'] =='orderingphysician')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' and fldSchDate >= '$sdate' and fldSchDate <= '$edate' AND fldAuthorized = '0' order by ";
		if($_SESSION['role'] =='technologist')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldTechnologist = '$user' and fldSchDate >= '$sdate' and fldSchDate <= '$edate' order by ";
	}
	else if($_GET['all']=='month') {

		$curtime=date("Y-m-d",time());
		$sDate = split('-', $curtime);
		$num = cal_days_in_month(CAL_GREGORIAN, $sDate[1], $sDate[0]) ;
		$stdate=$sDate[0].'-'.$sDate[1].'-01 00:00:00';
		$enddate=$sDate[0].'-'.$sDate[1].'-'.$num. ' 23:59:59';

		if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher'  || $_SESSION['role'] =='coder')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldSchDate >= '$stdate' and fldSchDate <= '$enddate' and fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div') order by ";
		if($_SESSION['role'] =='facilityuser')
		$sql = "select a.*
                            from tblorderdetails AS a
                            INNER JOIN tbluserfacdetails AS b ON a.fldFacilityName = b.fldFacility AND b.flduserid = '$facid'
                            WHERE fldSchDate >= '$stdate' and fldSchDate <= '$enddate' order by ";
		if($_SESSION['role'] =='orderingphysician')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' and fldSchDate >= '$stdate' and fldSchDate <= '$enddate' AND fldAuthorized = '0' order by ";
		if($_SESSION['role'] =='technologist')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldTechnologist = '$user' and fldSchDate >= '$stdate' and fldSchDate <= '$enddate' order by ";
	}
	else if($_GET['all']=='nondis') {

		$curtime=date("Y-m-d",time());
		$sDate = split('-', $curtime);
		$num = cal_days_in_month(CAL_GREGORIAN, $sDate[1], $sDate[0]) ;
		$stdate=$sDate[0].'-'.$sDate[1].'-01 00:00:00';
		$enddate=$sDate[0].'-'.$sDate[1].'-'.$num. ' 23:59:59';

		if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher'  || $_SESSION['role'] =='coder')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldDispatched=0 and fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div') order by ";
		if($_SESSION['role'] =='facilityuser')
		$sql = "select a.*
                            from tblorderdetails AS a
                            INNER JOIN tbluserfacdetails AS b ON a.fldFacilityName = b.fldFacility AND b.flduserid = '$facid'
                            WHERE fldDispatched=0 order by ";
		if($_SESSION['role'] =='orderingphysician')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' AND fldAuthorized = '0'  AND fldDispatched=0 order by ";
		if($_SESSION['role'] =='technologist')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldTechnologist = '$user' AND fldDispatched=0 order by ";
	}
	else {
		$stdate=$curtime.' 00:00:00';
		$enddate=$curtime.' 23:59:59';
		if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher'  || $_SESSION['role'] =='coder')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldSchDate >= '$stdate' and fldSchDate <= '$enddate' and fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$div') order by ";
		if($_SESSION['role'] =='facilityuser')
		$sql = "select a.*
                            from tblorderdetails AS a
                            INNER JOIN tbluserfacdetails AS b ON a.fldFacilityName = b.fldFacility AND b.flduserid = '$facid'
                            WHERE fldSchDate >= '$stdate' and fldSchDate <= '$enddate' order by ";
		if($_SESSION['role'] =='orderingphysician')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldOrderingPhysicians = '$orphy' and fldSchDate >= '$stdate' and fldSchDate <= '$enddate' AND fldAuthorized = '0' order by ";
		if($_SESSION['role'] =='technologist')
		$sql = "select fldID, fldFacilityName, fldSchDate, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldplr1, fldplr2, fldplr3, fldplr4, fldplr5, fldplr6,  fldRequestedBy, fldVerbal,fldCoded, fldException1, fldException2, fldException3  from tblorderdetails where fldTechnologist = '$user' and fldSchDate >= '$stdate' and fldSchDate <= '$enddate' order by ";
	}

}//end if
?>
<link href='tablesort.css'  rel="stylesheet" type="text/css" />
<link href="paginate.css"   rel="stylesheet" type="text/css" />

<style>
.fdtablePaginatorWrapTop { display:none; }
</style>
<script type="text/javascript">
function show_confirm()
{
var r=confirm("Are you sure you want  to delete this Order");
if (r==true)
  {
  return true;
  }
else
  {
  return false;
  }
}
</script>

<form action="" method="post">

<?
	if($_REQUEST['val']=="0")
	{
	$sql .= "fldDate";
	}
	else if($_REQUEST['val']=="1")
	{
	$sql .= "fldSchDate";
	}
	else if($_REQUEST['val']=="2")
	{
	$sql .= "fldPatientID";
	}
	else if($_REQUEST['val']=="3")
	{
	$sql .= "fldLastName,fldFirstName";
	}
	else if($_REQUEST['val']=="4")
	{
	$sql .= "fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure1";
	}
	else if($_REQUEST['val']=="5")
	{
	$sql .= "fldOrderingPhysicians";
	}
	else if($_REQUEST['val']=="6")
	{
	$sql .= "fldRequestedBy";
	}
	else if($_REQUEST['val']=="7")
	{
	$sql .= "fldFacilityName";
	}
	else
	{
	$sql .= "fldSchDate";
	}

	if($_REQUEST['ord']=="2")
	{
	$sql .= " desc";
	}

	$ord=$_REQUEST['ord'];
	if($ord=="")
	{
	$ord="1";
	}
	else if($ord=="1")
	{
	$ord="2";
	}
	else if($ord=="2")
	{
	$ord="1";
	}
	$all=$_REQUEST['all'];

	$conn = mysql_connect('localhost', $host1, '!mdi634');
	mysql_select_db($table1,$conn);
	
	//echo $sql;die;

    $res = mysql_query($sql) or die (mysql_error());
    $num = mysql_num_rows($res);

	$pgr = "pg=20&all=" . $all . "&val=0&ord=2";

	$pager = new PS_Pagination($conn, $sql, 10, 5, $pgr);

	if(empty($_GET['all']) || $_GET['page']=='all') {
	$pager = new PS_Pagination($conn, $sql, $num, 5, $pgr);
	}
	$rs = $pager->paginate();
?>
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<thead>
  <tr>
    <th width="7%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=0&ord=<?=$ord?>">Date</a></th>
    <th width="7%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=1&ord=<?=$ord?>">Exam Date</a></th>
    <th width="6%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=2&ord=<?=$ord?>">Patient ID</a></th>
    <th width="8%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=3&ord=<?=$ord?>">Patient Name</a></th>
    <th width="9%" class="sortable-text"> <a href="index.php?pg=20&all=<?=$all?>&page=1&val=4&ord=<?=$ord?>">Procedure</a></th>
    <th width="10%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=5&ord=<?=$ord?>">Ordering Physician</a></th>
    <th width="10%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=6&ord=<?=$ord?>">Ordered By</a></th>
    <th width="8%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=7&ord=<?=$ord?>">Facility</a></th>
    <? if($_SESSION['role'] =='admin'  || $_SESSION['role'] =='dispatcher') { ?>
    <th width="6%">&nbsp;</th>
    <? } ?>
    <? //if($_SESSION['role'] =='admin'  || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='technologist') { ?>
    <th width="12%" colspan="2"><input name="retrive" type="button" onclick="search_prompt()" value="Search" /></th>
    <? //} ?>
    <th colspan="3" align="center" valign="middle"><div align="right">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="105" height="23">
        <param name="movie" value="button1.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#CAE8EA" />
        <embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="105" height="23" bgcolor="#CAE8EA"></embed>
      </object>
    </div></th>
    </tr>
    <?	if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='coder')
	{ ?>
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
    <th colspan="6"><input name="div" id="div" type="submit" value="Load" /></th>
    </tr>
     <? } ?>
 </thead>
<?
if(!$num)
{
?>
<tbody>
  <tr><td colspan="14" class="total" height="50">No Records Found</td></tr>
</tbody></table>
<?
}
else
{
?>
 <tbody>
  <? while($row = mysql_fetch_assoc($rs)) { ?>
		  <?
		  if($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 0 && $row['fldAuthorized'] == 1)
		  {
		  $tdclass = "blue";
		  }
		  else if($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 0 && $row['fldAuthorized'] == 0)
		  {
		  $tdclass = "bluebold";
		  }
		  else if($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 1 && $row['fldAuthorized'] == 0)
		  {
		  $tdclass = "green";
		  }
		  else if($row['fldAfterhours'] == 0 && $row['fldStat'] == 0 && $row['fldDispatched'] == 1 && $row['fldAuthorized'] == 1)
		  {
		  $tdclass = "greenbold";
		  }
		  else if($row['fldStat'] == 1 && $row['fldDispatched'] == 0 && $row['fldAuthorized'] == 0)
		  {
		  $tdclass = "redbold";
		  }
		  else if($row['fldStat'] == 1 && $row['fldDispatched'] == 0 && $row['fldAuthorized'] == 1)
		  {
		  $tdclass = "red";
		  }
		  else if($row['fldDispatched'] == 1 && $row['fldStat'] == 1 && $row['fldAuthorized'] == 0)
		  {
		  $tdclass = "orangebold";
		  }
		  else if($row['fldDispatched'] == 1 && $row['fldStat'] == 1 && $row['fldAuthorized'] == 1)
		  {
		  $tdclass = "orange";
		  }
		  else if($row['fldAuthorized'] == 0)
		  {
		  $tdclass = "black";
		  }
		  else if($row['fldAuthorized'] == 1)
		  {
		  $tdclass = "blackbold";
		  }
		  ?>
     <tr>
		<td class="<? echo $tdclass;?>"><?echo strftime("%m-%d-%Y %H:%M", strtotime($row['fldDate']));?></td>
	    <td class="<? echo $tdclass;?>"><?echo strftime("%m-%d-%Y %H:%M", strtotime($row['fldSchDate']));?></td>
		<td class="<? echo $tdclass;?>"><?=$row['fldPatientID']?></td>
		<td class="<? echo $tdclass;?>"><?=$row['fldLastName']?>, <?=$row['fldFirstName']?></td>
		<td class="<? echo $tdclass;?>"><?=$row['fldProcedure1']?> , <?=$row['fldplr1'];?>
		<? if($row['fldProcedure2']!='') { ?> <br /><?=$row['fldProcedure2']?> , <?=$row['fldplr2']; } ?>
		<? if($row['fldProcedure3']!='') { ?> <br /><?=$row['fldProcedure3']?> , <?=$row['fldplr3']; } ?>
		<? if($row['fldProcedure4']!='') { ?> <br /><?=$row['fldProcedure4']?> , <?=$row['fldplr4']; } ?>
		<? if($row['fldProcedure5']!='') { ?> <br /><?=$row['fldProcedure5']?> , <?=$row['fldplr5']; } ?>
		<? if($row['fldProcedure6']!='') { ?> <br /><?=$row['fldProcedure6']?> , <?=$row['fldplr6']; } ?>
		</td>
		<td class="<? echo $tdclass;?>"><?=strtoupper($row['fldOrderingPhysicians'])?></td>
		<td class="<? echo $tdclass;?>"><?=$row['fldRequestedBy']?></td>
		<td class="<? echo $tdclass;?>"><?=$row['fldFacilityName']?></td>
		<td class="<? echo $tdclass;?>">
			<?php
				if($_SESSION['role'] =='admin' || $_SESSION['role'] =='coder')
				{
					if($row['fldAuthorized'] == '0')
					{
						echo '<a href="index.php?pg=30&id='.$row['fldID'].'">Edit</a>'; // is this field name correct ?
					}
					elseif($row['fldAuthorized'] == '1')
					{
						echo 'E-Signed / <a href="index.php?pg=30&id='.$row['fldID'].'">Edit</a>';
					}
				}
			?>
		    <?php
				if($_SESSION['role'] =='dispatcher'|| $_SESSION['role'] =='technologist' || $_SESSION['role'] =='facilityuser')
				{
					if($row['fldAuthorized'] == '0')
					{
						echo '<a href="index.php?pg=23&id='.$row['fldID'].'">Edit</a>'; // is this field name correct ?
					}
					elseif($row['fldAuthorized'] == '1')
					{
						echo 'E-Signed';
					}
				}
			?>
		
		</td>

<? if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='technologist') { ?>
	<td width="6%" class="<? echo $tdclass;?>">
	<?
		if($row['fldVerbal'] == '1')
		{
		?>Called In / <a class="<? echo $tdclass;?>" href="index.php?pg=31&id=<?=$row['fldID']?>">Verbal</a>
		<? }
		else if($row['fldVerbal'] == '2')
		{
		?>Received / <a class="<? echo $tdclass;?>" href="index.php?pg=31&id=<?=$row['fldID']?>">Verbal</a>
		<?
		}
			else
			{ ?>
			<a class="<? echo $tdclass;?>" href="index.php?pg=27&id=<?=$row['fldID']?>">Verbal</a>
			<? } ?>
	</td>
<? } ?>

<? if($_SESSION['role'] =='coder') { ?>
	<td width="6%" class="<? echo $tdclass;?>">
	<? if($row['fldCoded'] == '1')
	{ ?>Coded
	<? } else { ?>
	<a class="<? echo $tdclass;?>" href="index.php?pg=28&id=<?=$row['fldID']?>">Not Coded</a>
	<? } ?>
	</td>
<? } ?>

<? if($_SESSION['role'] =='orderingphysician') { ?>
	<td width="6%" class="<? echo $tdclass;?>">
	<a class="<? echo $tdclass;?>" href="index.php?pg=22&id=<?=$row['fldID']?>">E-Sign</a>
	</td>
<? } ?>

<? if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher') { ?>
	<td width="6%" class="<? echo $tdclass;?>">
	<? if($row['fldDispatched'] == '1')
	{ ?>
	<?=$row['fldTechnologist']?> / <a class="<? echo $tdclass;?>" href="index.php?pg=26&id=<?=$row['fldID']?>">Undispatch</a>
	<? } else { ?>
	<a class="<? echo $tdclass;?>" href="index.php?pg=25&id=<?=$row['fldID']?>">Dispatch</a>
	<? } ?>
	</td>
<? } ?>
<? if($_SESSION['role'] =='facilityuser') { ?>
	<td width="6%" class="<? echo $tdclass;?>">
	<?
	if($row['fldDispatched'] == 1)
	{ ?>
	<?=$row['fldTechnologist']?>
	<? } else { ?>
	To be Dispatched
	<? } ?>
	</td>
<? } ?>


<td class="<? echo $tdclass;?>"><a class="<? echo $tdclass;?>" href="index.php?pg=<?if($_SESSION['role'] =='admin' || $_SESSION['role'] =='coder'){?>29<?} else {?>22<?}?>&id=<?=$row['fldID']?>">Details</a></td>


<? if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='technologist' || $_SESSION['role'] =='facilityuser') {
$exp='';
if($row['fldException1']!='' && $row['fldException2']=='')
$exp='';
else if($row['fldException1']!='' && $row['fldException2']!='' && $row['fldException3']=='')
$exp='';
else if($row['fldException3']!='')
$exp='';
?>
	<td class="<? echo $tdclass;?>"><?=$exp?></td>
<?
}
if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='technologist') {
?>
	<td class="<? echo $tdclass;?>">
	<a class="<? echo $tdclass;?>" href="index.php?pg=24&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a>
	</td>
<? } ?>

	</tr>
	<? } ?>
  </tbody>
</table>
<? echo $pager->renderFullNav() . $pager->renderAll(); } ?>
</form>
<table height="10" border="0"><tr><td class="nb">&nbsp;</td></tr></table>
<?
if($_REQUEST['submit']!='')
{
$redirecturl = "index.php?pg=21";
header("location:".$redirecturl);
}
if($_REQUEST['div']!='')
{
$div=$_REQUEST['divisionname'];
$redirecturl = $_SERVER['HTTP_REFERER'];
$redirecturl .='&d=' . $div;
header("Location:".$redirecturl);
}
?>

