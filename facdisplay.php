<?php # pmd 2012-02-01 facdisplay.php
include "config.php";

$faclility = "";
if ( isset($_REQUEST['facility']) ) $facility = $_REQUEST['facility'];

function doSelect($selname,$selarray,$seldef,$sclass) 
{ # do a select box from array and default value passed
	echo "<select ";
	if ( $sclass != '' ) echo "class='$sclass' ";
	echo "name='$selname' id='$selname'>";
	for ($tcntr = 0; $tcntr < count($selarray); $tcntr++) 
	{
		echo "<option value=";
		if ( $selarray[$tcntr] == "Select" ) echo "''";
		else echo "'".$selarray[$tcntr]."'";
		if ( $seldef == $selarray[$tcntr] ) echo " selected";
		echo ">".$selarray[$tcntr]."</option>\n";
	}
	echo "</select>\n";
}

# get dispatcher default state
$myState = "";
$strSQL = "SELECT fldMainState FROM tbluser WHERE fldID=".$_SESSION['userID'];
$result = mysql_query($strSQL);
$row = mysql_fetch_row($result);
mysql_free_result($result);
$myState = $row[0];

# get facility array
$facilities = array();
$strSQL = "SELECT `fldFacilityName` FROM `tblfacility`";
if ( $myState != '' ) $strSQL .= " WHERE `fldMainState`='$myState' ";
$strSQL .= "ORDER BY `fldFacilityName`";
$result = mysql_query($strSQL);
while ( $row = mysql_fetch_row($result) ) array_push($facilities,$row[0]);
mysql_free_result($result);

echo "<div style='background-color:#DEE7EF;'><center>";
echo "<form action='' method='post'>";
echo "<div class=lab style='text-align:center;'>Display Facility Info for:&nbsp;";
doSelect('facility',$facilities,$facility,'select2');
echo "<input type=submit value=Lookup></div><br>";
echo "</form>";

if ( isset($facility) ) 
{	
	$strSQL = "SELECT * FROM tblfacility WHERE fldFacilityName='$facility'";
	$result = mysql_query($strSQL);
	$row = mysql_fetch_array($result);
?>
	<table>
	<? /*<tr><td class=lab>fldID</td><td class=dis><? echo $row['fldID']; ?>&nbsp;</td></tr> */ ?>
	<tr><td class=lab style='width:200px;'>Facility Name</td><td class=dis style='width:500px;'><? echo $row['fldFacilityName']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Admin Name</td><td class=dis><? echo $row['fldAdminName']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Division Name</td><td class=dis><? echo $row['fldDivisionName']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Address 1</td><td class=dis><? echo $row['fldAddressLine1']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Address 2</td><td class=dis><? echo $row['fldAddressLine2']; ?>&nbsp;</td></tr>
	<tr><td class=lab>City</td><td class=dis><? echo $row['fldAddressCity']; ?>&nbsp;</td></tr>
	<tr><td class=lab>State</td><td class=dis><? echo $row['fldAddressState']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Zip</td><td class=dis><? echo $row['fldAddressZip']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Phone</td><td class=dis><? echo $row['fldPhoneNumber']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Fax</td><td class=dis><? echo $row['fldFaxNumber']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Email</td><td class=dis><? echo $row['fldEmail']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Email Order</td><td class=dis><? echo $row['fldEmailOrder']; ?>&nbsp;</td></tr>
	<? /*
	<tr><td class=lab>AutoDispatch</td><td class=dis><? echo $row['fldAutoDispatch']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Technologist</td><td class=dis><? echo $row['fldTechnologist']; ?>&nbsp;</td></tr>
	*/ ?>
	<tr><td class=lab>Req Dis</td><td class=dis><? echo $row['fldReqDis']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Main State</td><td class=dis><? echo $row['fldMainState']; ?>&nbsp;</td></tr>
	<tr><td class=lab>Facility Type</td><td class=dis><? echo $row['fldFacilityType']; ?>&nbsp;</td></tr>
	</table>
<?
}
echo "</center><br></div\n";
?>