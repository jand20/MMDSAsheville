<?php
session_start();
ob_start();
// if session is not set redirect the user
//if(empty($_SESSION['user']))
//header("Location:index.php");
include 'config.php';
$user=$_SESSION['user'];

$orderType = $_GET['order_type'];
?>
<script type="text/javascript">
function search_prompt() {
    var retVal="";
    var valReturned;
    retVal=showModalDialog('searchpop1.html');
    valReturned=retVal;
    location.replace(valReturned);
};
</script>
<script type="text/javascript" src="paginate.min.js"></script>
<script type="text/javascript" src="tablesort.min.js"></script>
<script type="text/javascript" src="tablefilter.min.js"></script>
<link href="tablesort.css"       rel="stylesheet" type="text/css" />
<link href="paginate.css"   rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="paginate-ie.css"   rel="stylesheet" type="text/css" />
<![endif]-->
<link href="filter.css"   rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<link href="filter-ie6.css"   rel="stylesheet" type="text/css" />
<![endif]-->
<style>
.fdtablePaginatorWrapTop { display:none; }
</style>
<?
// Search
if($key!="")
{
    $key = str_replace("*", "%", $key);
    $sql = "SELECT fldID, fldDate, fldSchDate, fldPatientID, fldLastName, fldFirstName, fldDOB, fldPatientSSN FROM tblorderdetails WHERE ";
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
        $sql .="fldSchDate = '$shdate'";
    }

    $user = $_SESSION['user'];
    
    if ( $_SESSION['role'] == 'technologist' )
    {
        $sql .= " AND fldDispatched='1' AND fldTechnologist='$user'";
    }   
    
    if( $_SESSION['role'] == 'facilityuser' )
    {
        $sql .= " AND fldfacilityname in (
                    SELECT * FROM tbluserfacdetails UFD
                    JOIN tbluser U ON U.fldID = UFD.fldUserID
                    WHERE U.fldUserName = '$user'
                    )";
    }
    
    if ( $_SESSION['role'] == 'orderingphysician' )
    {
        $sql .=" AND fldOrderingPhysicians = '$user'";
    }
    $sql .=" ORDER BY fldID LIMIT 0 , 500";
}
?>
<?
if( $key != "" )
{ 
    $res = mysql_query($sql) or die (mysql_error());
    $num = mysql_num_rows($res);
    if(!$num)
    {
        if($keyword == 'fldPatientSSN' ){
            $ssn = $key;
            $data = '<select onchange="window.location.href=this.value;">';
            $data .= "<option value=''>< - - SELECT - - ></option>";
            $data .= "<option value='index.php?pg=21&order_type=1&ssn=$ssn'>Add Nursing Home Order for SSN : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=2&ssn=$ssn'>Add Correctional Facility Order for SSN : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=3&ssn=$ssn'>Add Home Bound Order for SSN : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=4&ssn=$ssn'>Add Lab Order for SSN : $ssn</option>";
            $data .= '</select>';
        }
        else if($keyword == 'fldLastName' ){
            $ssn = $key;
            $data = '<select onchange="window.location.href=this.value;">';
            $data .= "<option value=''>< - - SELECT - - ></option>";
            $data .= "<option value='index.php?pg=21&order_type=1&lname=$ssn'>Add Nursing Home Order for Last Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=2&lname=$ssn'>Add Correctional Facility Order for Last Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=3&lname=$ssn'>Add Home Bound Order for Last Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=4&lname=$ssn'>Add Lab Order for Last Name : $ssn</option>";
            $data .= '</select>';
        }
        else if($keyword == 'fldFirstName' ){
            $ssn = $key;
            $data = '<select onchange="window.location.href=this.value;">';
            $data .= "<option value=''>< - - SELECT - - ></option>";
            $data .= "<option value='index.php?pg=21&order_type=1&fname=$ssn'>Add Nursing Home Order for First Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=2&fname=$ssn'>Add Correctional Facility Order for First Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=3&fname=$ssn'>Add Home Bound Order for First Name : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=4&fname=$ssn'>Add Lab Order for First Name : $ssn</option>";
            $data .= '</select>';
        }            
        else if($keyword == 'fldFacilityName' ){
            $ssn = $key;
            $data = '<select onchange="window.location.href=this.value;">';
            $data .= "<option value=''>< - - SELECT - - ></option>";
            $data .= "<option value='index.php?pg=21&order_type=1&fclty=$ssn'>Add Nursing Home Order for Facility : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=2&fclty=$ssn'>Add Correctional Facility Order for Facility : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=3&fclty=$ssn'>Add Home Bound Order for Facility : $ssn</option>";
            $data .= "<option value='index.php?pg=21&order_type=4&fclty=$ssn'>Add Lab Order for Facility : $ssn</option>";
            $data .= '</select>';
        } 
    
    ?>
    <table id="searchres" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-3r no-arrow colstyle-alt rowstyle-alt paginate-10 max-pages-10 paginationcallback-callbackTest-calculateTotalRating sortcompletecallback-callbackTest-calculateTotalRating">
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
      <tr><td class="total" height="50"><?=$data?></td></tr>
    </tbody></table>
    <?
    }
    else
    {
    ?>
    <table>
    <thead>
      <tr>
        <th width="11%" class="sortable-text">Order Date</th>
        <th width="11%" class="sortable-text">Exam Date</th>
        <th width="11%" class="sortable-text">Patient ID</th>
        <th width="11%" class="sortable-text">Last Name</th>
        <th width="11%" class="sortable-text">First Name</th>
        <th width="11%" class="sortable-text">DOB</th>
        <th width="11%" class="sortable-text">SSN</th>
      </tr>
    </thead>
    <tbody>
    <?
    while($row = mysql_fetch_assoc($res)) {
    ?>
      <tr class="alt">
        <? $dt = $row['fldDate'];$dt1 = $row['fldSchDate']; ?>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><? echo strftime("%m-%d-%Y %H:%M", strtotime($dt));?></a></td>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><? echo strftime("%m-%d-%Y", strtotime($dt1));?></a></td>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><?=$row['fldPatientID']?></a></td>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><?=$row['fldLastName']?></a></td>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><?=$row['fldFirstName']?></a></td>
        <td width="11%"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><?=$row['fldDOB']?></a></td>
        <td width="11%" class="lft"><a href="index.php?pg=21&id=<?=$row['fldID']?>&pid=<?=$row['fldPatientID']?>&neworder=1&order_type=<?=$orderType?>"><?=$row['fldPatientSSN']?></a></td>
      </tr>
    <? } ?>
    </tbody>
    </table>
    <?
    }
}
?>
