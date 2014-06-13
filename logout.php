<?php # PMD 2012-01-17
session_start();

include 'config.php';

if ( $_SESSION['role'] == "technologist" )
{ # log to table, event id: 1 == login, 0 == logout
	$liTime = new DateTime();
	$strSQL = "INSERT INTO tbltechlog
				(`techId`,`event`,`eventDateTime`)
				VALUES
				('".$_SESSION['userID']."','0','".$liTime->format('Y-m-d H:i:s')."')";
	mysql_query($strSQL);
	# flag as logged in
	$strSQL = "UPDATE tbluser SET `fldOnline`='0' WHERE fldID='".$_SESSION['userID']."'";
	echo "[$strSQL]";
	mysql_query($strSQL);
}

# Delete the session vars
unset($_SESSION['userID']);
unset($_SESSION['user']);
unset($_SESSION['role']);
unset($_SESSION['formCached']);

# Delete the cookies
setcookie("user", '', time()-60*60*24*60, "/");
setcookie("role", '', time()-60*60*24*60, "/");

# Close the database
mysql_close($link);

# After Logout redirect to login page
header("Location: index.php");
?>