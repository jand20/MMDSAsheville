<? # pmd 2012-01-10
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include 'config.php';
$user=$_SESSION['user'];
include('ps_pagination.php');
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

function formatDate($dDate){
    $dNewDate = strtotime($dDate);
    return date('Y-m-d H:i',$dNewDate);
}
$curtime=date("Y-m-d",time());
$curdate=formatdate($curtime);

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
if($key!="")
{
    $key = str_replace("*", "%", $key);
    $sql = "SELECT fldID, fldFacilityName, fldOrderingPhysicians, fldAuthorized, fldTechnologist, fldDate, fldSchDate, fldAfterhours, fldStat, fldDispatched, fldPatientID, fldLastName, fldFirstName, fldDOB, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldRequestedBy, fldVerbal,fldCoded from tblorderdetails where ";
    if($keyword == 'fldDate')
    {
        $key1 = $key;
        $sDate2 = explode('-', $key1);
        $shdate = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];
        $key = $shdate;
        $sql .="fldDate > '";
        $sql .=$key . " 00:00:00";
        $sql .="' AND fldDate < '";
        $sql .=$key . " 23:59:59";
        $sql .="'";
    }
    if($keyword == 'fldLastName')
    {
        $sql .="fldLastName LIKE '";
        $sql .=$key;
        $sql .="'";
    }
    if($keyword == 'fldFirstName')
    {
        $sql .="fldFirstName LIKE '";
        $sql .=$key;
        $sql .="'";
    }
    if($keyword == 'fldDOB')
    {
        $key1 = $key;
        $sDate2 = explode('-', $key1);
        $shdate = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];
        $key = $shdate;
        $sql .="fldDOB > '";
        $sql .=$key . " 00:00:00";
        $sql .="' AND fldDOB < '";
        $sql .=$key . " 23:59:59";
        $sql .="'";
    }
    if($keyword == 'fldPatientSSN')
    {
        $sql .="fldPatientSSN LIKE '";
        $sql .=$key;
        $sql .="'";
    }
    if($keyword == 'fldPatientID')
    {
        $sql .="fldPatientID LIKE '";
        $sql .=$key;
        $sql .="'";
    }
    if($keyword == 'fldFacilityName')
    {
        $sql .="fldFacilityName LIKE '";
        $sql .=$key;
        $sql .="'";
    }
    if($keyword == 'fldSchDate')
    {
        $key1 = $key;
        $sDate2 = explode('-', $key1);
        $shdate = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];
        $key = $shdate;
        $sql .= " fldSchDate = '$shdate' ";
    }

    $user = $_SESSION['user'];
    
    if ( $_SESSION['role'] == 'technologist' )
    {
        $sql .= " AND fldDispatched='1' AND fldTechnologist = '$user'";
    }   

    if( $_SESSION['role'] == 'facilityuser' )
    {
        $sql .= " AND fldfacilityname in (
                    SELECT UFD.fldFacility FROM tbluserfacdetails UFD
                    JOIN tbluser U ON U.fldID = UFD.fldUserID
                    WHERE U.fldUserName = '$user'
                    )";
    }
    
    if( $_SESSION['role'] == 'orderingphysician' )
    {
        $sql .=" AND fldOrderingPhysicians = '$user'";
    }
    
    $sql .=" ORDER BY ";
}

if($_REQUEST['val']=="1")
{
    $sql .= "fldDate";
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
else if($_REQUEST['val']=="8")
{
    $sql .= "fldSchDate";
}
else
{
    $sql .= "fldID";
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
$all = $_REQUEST['all'];

$conn = mysql_connect('localhost', $host1, '!mdi634');
mysql_select_db($table1,$conn);
$pgr = "pg=33&srch=" . $key . "&keyword=" . $keyword . "&all=" . $all . "&val=0&ord=1";
$pager = new PS_Pagination($conn, $sql, 10, 5, $pgr);
$rs = $pager->paginate();
?>
<?
$res = mysql_query($sql) or die (mysql_error());
$num = mysql_num_rows($res);
if(!$num)
{
?>
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<thead>
    <th align="center" valign="middle"><div align="right">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="105" height="23">
        <param name="movie" value="button1.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#CAE8EA" />
        <embed src="button1.swf" quality="high" pluginspage="https://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="105" height="23" bgcolor="#CAE8EA"></embed>
      </object>
    </div></th>
</thead>
<tbody>
  <tr><td class="total" height="50">No Records Found</td></tr>
</tbody></table>
<?
}
else
{
?>
<table id="orders" width="1050px" aligh="left" cellpadding="0" cellspacing="0" border="0">
<thead>
  <tr>
    <th width="7%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=1&ord=<?=$ord?>">Order Date</a></th>
    <th width="6%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=8&ord=<?=$ord?>">Exam Date</a></th>
    <th width="11%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=2&ord=<?=$ord?>">Patient ID</a></th>
    <th width="11%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=3&ord=<?=$ord?>">Patient Name</a></th>
    <th width="9%" class="sortable-text"> <a href="index.php?pg=20&all=<?=$all?>&page=1&val=4&ord=<?=$ord?>">Procedure</a></th>
    <th width="14%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=5&ord=<?=$ord?>">Ordering Physician</a></th>
    <th width="15%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=6&ord=<?=$ord?>">Ordered By</a></th>
    <th width="11%" class="sortable-text"><a href="index.php?pg=20&all=<?=$all?>&page=1&val=7&ord=<?=$ord?>">Facility</a></th>
    <th width="8%"><input name="retrive" type="button" onclick="search_prompt()" value="Search" /></th>
    <th width="6%">&nbsp;</th>
    <? if($_SESSION['role'] =='admin'  || $_SESSION['role'] =='dispatcher') { ?>
    <th width="11%">&nbsp;</th>
    <th width="11%"><input name="retrive" type="button" onclick="search_prompt()" value="Search" /></th>
    <? } ?>
    <th align="center" valign="middle"><div align="right">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="105" height="23">
        <param name="movie" value="button1.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#CAE8EA" />
        <embed src="button1.swf" quality="high" pluginspage="https://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="105" height="23" bgcolor="#CAE8EA"></embed>
      </object>
    </div></th>
    </tr>
 </thead>
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
    <? $dt = $row['fldDate'];$dt1 = $row['fldSchDate']; ?>
        <td class="<? echo $tdclass;?>"><?echo strftime("%m-%d-%Y %H:%M", strtotime($dt));?></td>
        <td class="<? echo $tdclass;?>"><?echo strftime("%m-%d-%Y", strtotime($dt1));?></td>
        <td class="<? echo $tdclass;?>"><?=$row['fldPatientID']?></td>
        <td class="<? echo $tdclass;?>"><?=$row['fldLastName']?>, <?=$row['fldFirstName']?></td>
        <td class="<? echo $tdclass;?>"><?=$row['fldProcedure1']?>
        <? if($row['fldProcedure2']!='') { ?> <br /><?=$row['fldProcedure2']; } ?>
        <? if($row['fldProcedure3']!='') { ?> <br /><?=$row['fldProcedure3']; } ?>
        <? if($row['fldProcedure4']!='') { ?> <br /><?=$row['fldProcedure4']; } ?>
        </td>
        <td class="<? echo $tdclass;?>"><?=strtoupper($row['fldOrderingPhysicians'])?></td>
        <td class="<? echo $tdclass;?>"><?=$row['fldRequestedBy']?></td>
        <td class="<? echo $tdclass;?>"><?=$row['fldFacilityName']?></td>


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

        <td width="6%" class="<? echo $tdclass;?>"><? if($row['fldAuthorized'] == '0') { ?><a href="index.php?pg=<?if($_SESSION['role'] =='admin' || $_SESSION['role'] =='coder'){?>21<?} else {?>21<?}?>&id=<?=$row['fldID']?>">Edit</a><? } else { ?>E-Signed<? } ?></td>

        <td width="6%" class="<? echo $tdclass;?>">
        <? if($_SESSION['role'] =='admin' || $_SESSION['role'] =='dispatcher' || $_SESSION['role'] =='technologist') { ?>
        <a class="<? echo $tdclass;?>" href="index.php?pg=24&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a>
        <? } ?>
        <? if($_SESSION['role'] =='orderingphysician') { ?>
        <a class="<? echo $tdclass;?>" href="index.php?pg=22&id=<?=$row['fldID']?>">E-Sign</a>
        <? } ?>



        <? if($_SESSION['role'] =='facilityuser')
        {
        if($row['fldDispatched'] == 1)
        { ?>
        <?=$row['fldTechnologist']?>
        <? } else { ?>
        To be Dispatched
        <? } } ?>
        <? if($_SESSION['role'] =='coder') { ?>
                <? if($row['fldCoded'] == '1')
                { ?>Coded
                <? } else { ?>
                <a class="<? echo $tdclass;?>" href="index.php?pg=28&id=<?=$row['fldID']?>">Not Coded</a>
                <? } ?>
        <? } ?>
        </td>

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

        <td width="15%" class="<? echo $tdclass;?>"><a class="<? echo $tdclass;?>" href="index.php?pg=<?if($_SESSION['role'] =='admin' || $_SESSION['role'] =='coder'){?>29<?} else {?>22<?}?>&id=<?=$row['fldID']?>">Details</a></td>
    </tr>
<? } ?>
  </tbody>
</table>
<? echo $pager->renderFullNav(); } ?>
</form>
<table height="10" border="0"><tr><td class="nb">&nbsp;</td></tr></table>
<?
if($_REQUEST['submit']!='')
{
$redirecturl = "index.php?pg=21";
header("location:".$redirecturl);
}
?>

