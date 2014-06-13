<?php
$strSQL = "SELECT * FROM tbluser WHERE fldUserName='$username'";
$result = mysql_query($strSQL) or die ("ERROR: ".mysql_error());
if ( mysql_num_rows($result) == 1 ) 
{
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
}

session_start(); # set the variables in the session
$_SESSION['userID'] = $row['fldID'];
$_SESSION['user'] = $row['fldUserName'];
$_SESSION['password'] = $row['fldPassword'];
$_SESSION['facility'] = $row['fldFacility'];
$_SESSION['role'] = $row['fldRole'];
$_SESSION['userState'] = $row['fldMainState'];
$role = $_SESSION['role'];

if ( $role == "technologist" )
{ # log to table, event id: 1 == login, 0 == logout
	$liTime = new DateTime();
	$strSQL = "INSERT INTO tbltechlog 
				(`techId`,`event`,`eventDateTime`) 
				VALUES 
				('".$_SESSION['userID']."','1','".$liTime->format('Y-m-d H:i:s')."')";
	mysql_query($strSQL);
	# flag as logged in
	$strSQL = "UPDATE tbluser SET `fldOnline`='1' WHERE fldID='".$_SESSION['userID']."'";
	echo "[$strSQL]";
	mysql_query($strSQL);
}
	
# log to fs file
$logtime = date("Y-m-d H:i",time());
$myFile = "logindetails.csv";
$fh = fopen($myFile, 'a') or die("can't open $myFile");
$stringData = $logtime . "," . $_SESSION['user'] . "\n";
fwrite($fh, $stringData);
fclose($fh);

# set a cookie witout expiry until 60 days
if(isset($_POST['rememberme']))
{
	setcookie("user", $_SESSION['user'], time()+60*60*24*60, "/");
	setcookie("role", $_SESSION['role'], time()+60*60*24*60, "/");
	setcookie("password", $_SESSION['password'], time()+60*60*24*60, "/");
}
# navagate based on role
if ( $role == 'biller' ) $redirecturl = "index.php?pg=55";
else $redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
?>