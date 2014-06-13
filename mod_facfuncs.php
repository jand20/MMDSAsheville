<?php #PMD 20120130 facfuncs.php

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

# build facilitytype array 
$pcntr = 0;
$ftypearray = array("Select");
$sql = "SELECT * FROM tbllists WHERE fldListName='facilitytype' ORDER BY fldValue";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) array_push($ftypearray, strtoupper($row['fldValue']));
mysql_free_result($result);	

?>