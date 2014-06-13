<?php # mod_editfuncs 2012-01-17

# functions, load arrays - used by editorders, createorder, orderdetails

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

function doRadio($varname,$varvalue,$curvalue,$prompt) 
{ # radio box
	echo "<input type='radio' name='$varname' value='$varvalue'";
	if ( $varvalue == $curvalue ) echo " checked='checked'"; 
	echo ">&nbsp;$prompt\n";	
}

function doDatePick($varname,$varvalue)
{
	echo "<table border=0><tr>\n";
	echo "<td style='vertical-align:bottom'><input type='text' name='$varname' id='$varname' value='$varvalue' style='width:70px'></td>\n";
	echo "<td style='vertical-align:bottom'><img src='calendar-icon.jpg' alt='Select Date' onclick=\"displayDatePicker('$varname');\"></td>\n";
	echo "</tr></table>";
}

function phone_number($sPhone)
{
	$sPhone = preg_replace("#[^0-9]#",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.")".$sPrefix."-".$sNumber;
    return($sPhone);
}

function formatdate($sDate1)
{
	$sDate = explode('-', $sDate1);
	$sDate1 = $sDate[2].'-'.$sDate[0].'-'.$sDate[1];
	return $sDate1;
}

# build states array
$statesarray = array("Select");
$sql = "SELECT fldState FROM tblstates WHERE active=1 ORDER BY fldState";
$result = mysql_query($sql);
while($row = mysql_fetch_row($result)) array_push($statesarray, strtoupper($row[0]));
mysql_free_result($result);	

# build st array
$starray = array("");
$sql = "SELECT fldSt FROM tblstates WHERE active=1 ORDER BY fldSt";
$result = mysql_query($sql);
while($row = mysql_fetch_row($result)) array_push($starray, strtoupper($row[0]));
mysql_free_result($result);

# build procedure array 
$pcntr = 0;
$procarray = array("Select");
$sql = "SELECT * FROM tblproceduremanagment order by fldDescription";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) array_push($procarray, strtoupper($row['fldDescription']));
mysql_free_result($result);	

#build icd9 code array
$icd9array = array("Select");
$sql = "SELECT * FROM tbllists where fldListName = 'icd'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) array_push($icd9array, $row['fldValue']);
mysql_free_result($result);

?>