<?php # facstationpop.php PMD 2012-01-23
session_start(); // if session is not set redirect the user
if( empty($_SESSION['user']) ) header("Location:index.php");

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/

include "config.php";
$facID = $_REQUEST['facID'];

if ( $_REQUEST['submit'] == 'Add' )
{
    $sName = $_REQUEST['sName'];
    $sPhone = $_REQUEST['sPhone'];
    $sFax = $_REQUEST['sFax'];
    $strSQL =  "INSERT INTO tblstations (`facID`,`StationName`,`StationPhone`,`StationFax`) VALUES ('$facID','$sName','$sPhone','$sFax')";
#    echo "[ $strSQL ]";
    $result = mysql_query($strSQL) or die ("INSERT error: ".mysql_error());
}
else if ( $_REQUEST['submit'] == 'Save' )
{
    $sName = $_REQUEST['sName'];
    $sPhone = $_REQUEST['sPhone'];
    $sFax = $_REQUEST['sFax'];
    $strSQL =  "UPDATE tblstations SET `facID`='$facID',`StationName`='$sName',`StationPhone`='$sPhone',`StationFax`='$sFax' WHERE `Id`='".$_REQUEST['id']."'";
#    echo "[ $strSQL ]";
    $result = mysql_query($strSQL) or die ("INSERT error: ".mysql_error());
    echo"<center>Saved Successfully</center>";

}

# get faciliity name
$strSQL = "SELECT `fldFacilityName` FROM `tblfacility` WHERE `tblfacility`.`fldID`='$facID'";
$result = mysql_query($strSQL) or die ("SELECT error: ".mysql_error());
$row = mysql_fetch_row($result);
mysql_free_result($result);
$facName = $row[0];

if($_REQUEST['action'] == 'edit' && $_REQUEST['id']){
    $sql = "SELECT * FROM `tblstations` WHERE `facID`='$facID' AND `active`='1' AND id='".$_REQUEST['id']."'";
    $row = mysql_fetch_array(mysql_query($sql)) or die ("SELECT error: ".mysql_error());

}
if($_REQUEST['action'] == 'delete' && $_REQUEST['id']){
    $sql = "DELETE FROM `tblstations` WHERE `facID`='$facID' AND `active`='1' AND id='".$_REQUEST['id']."'";
    $row = mysql_query($sql) or die ("SELECT error: ".mysql_error());
    echo"<center>Deleted Successfully</center>";
}

?>
<script>
window.resizeTo(700, 400);
window.status.enable = 0;
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<body bgcolor=#DEE7EF>
<div class=header2>Facility Stations</div><br>
<div class=lab>Facility:&nbsp;<? echo $facName; ?></div><br>
<table><tr>
<form action="facstationpop.php?facID=<?=$facID?>" method="post">
<?if($_REQUEST['action'] == 'edit'){?><input type='hidden' name='id' value='<?=$_REQUEST['id']?>'><?}?>
<tr><th class=lab style='text-align:left;'>Name</th><th class=lab style='text-align:left;'>Phone</th><th class=lab style='text-align:left;'>Fax</th><th></th><th></th></tr>
<tr>
<td><input type=text name=sName value='<?=$row['StationName']?>'></td>
<td><input type=text name=sPhone value='<?=$row['StationPhone']?>'></td>
<td><input type=text name=sFax value='<?=$row['StationFax']?>'></td>
<td><input name=submit id=submit type=submit value='<?if($_REQUEST['action'] == 'edit'){echo 'Save';}else{echo 'Add';}?>'></td>
<td><input name=close id=close type=button value=Close onclick='window.close();'></td>
</tr>
</form>
</tr></table>
<table width="100%" border="0" >
<?
# get existing stations

$strSQL = "SELECT * FROM `tblstations` WHERE `facID`='$facID' AND `active`='1'";
$result = mysql_query($strSQL) or die ("SELECT error: ".mysql_error());

echo "<br><div class=dis>Existing Stations:</div><br>";
echo "<table border='0' background='main.png'>";
echo "<tr><th><div class=lab style='text-align:left;'>Name</div></th>
        <th><div class=lab style='text-align:left;'>Phone</div></th>
        <th><div class=lab style='text-align:left;'>Fax</div></th></tr>";
while ($row = mysql_fetch_array($result))
{
    $stid = $row['Id'];
    echo "<tr>";
    #echo "<td bgcolor=white width=200px><div class=lab>".$row['active']."</div></td>";
    echo "<td bgcolor=white width=200px><div class=lab>".$row['StationName']."</div></td>";
    echo "<td bgcolor=white width=200px><div class=lab>".$row['StationPhone']."</div></td>";
    echo "<td bgcolor=white width=200px><div class=lab>".$row['StationFax']."</div></td>";
    echo "<td bgcolor=white> <a href='facstationpop.php?facID=$facID&id=$stid&action=edit'>Edit</a> </td>";
    echo "<td bgcolor=white> <a href='#' onClick='if(confirm(\"Are you sure to delete thhe selected station?\")){window.location.href=\"facstationpop.php?facID=$facID&id=$stid&action=delete\"}'>Delete</a> </td>";
    echo "</tr>";
}
echo "</table>";
mysql_free_result($result);

?>
</table>
</body>
</html>
