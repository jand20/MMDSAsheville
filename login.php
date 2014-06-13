<?php # PMD 2012-01-17
require_once "config.php";
/*
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
*/
$submit = "";
$username = "";
$password = "";
$pw1 = "";
$pw2 = "";

if ( isset($_REQUEST['submit']) ) $submit = $_REQUEST['submit'];
if ( isset($_REQUEST['username']) ) $username = $_REQUEST['username'];
if ( isset($_REQUEST['password']) ) $password = $_REQUEST['password'];
if ( isset($_REQUEST['pw1']) ) $pw1 = $_REQUEST['pw1'];
if ( isset($_REQUEST['pw2']) ) $pw2 = $_REQUEST['pw2'];

if ( $submit == "Change" ) include "mod_login_pwchng.php";

if ( $username != '' && $submit == 'Login' )
{
	$strSQL = "SELECT * FROM tbluser WHERE fldUserName='$username'";
	$result = mysql_query($strSQL) or die ("ERROR: ".mysql_error());
	if ( mysql_num_rows($result) == 1 ) 
	{
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
	}
	# does the password entered match?
	if ( md5($password) !== $row['fldPassword'] )
	{
		$msg = urlencode("Invalid Login. Please try again with correct user name and password. ");
		header("Location: index.php?&msg=$msg");
	}
	# do we need to change password?
	if ( $row['fldPWChange'] == 1 )
	{
		$submit = "";
		$strErr = "You Must Change Your Password At This Time<br>";
		include "mod_login_pwchng.php";
	}
	
	if ( md5($password) == $row['fldPassword'] && $submit == 'Login' ) include "mod_login_process.php";
}

if ( $_SESSION['user'] == '' && $strErr == '' ) include "mod_login_prompt.php";
?>