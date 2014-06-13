<?php # pmd 2012-01-10
include 'config.php';

if ( $_POST['doLogin'] == 'Update' )
{
	if( $_POST['pwd1'] != $_POST['pwd2'] )
	{ # no match try again
		$msg = urlencode("Confirm Password doesnt Match. Please try again.");
		header("Location: index.php?pg=43&msg=$msg");
	}
	# inputs match - encrypt
	$savepass = md5(strip_tags(addslashes($_POST['pwd1']))); 
	
	if( $_SESSION['role'] != 'admin' )
	{	
		$md5pass = md5( mysql_real_escape_string($_POST['pwd']) ); # old

		# get the old password make sure it matches	
		$sql = "SELECT * FROM tbluser WHERE fldUserName = '".$_SESSION['user']."' AND fldPassword = '$md5pass'";
		$result = mysql_query($sql) or die (mysql_error());
		$num = mysql_num_rows($result);
		if( $num == 1 )
		{
			session_start(); # this re-sets variables in the session
			while($row = mysql_fetch_array($result))
			{
				$_SESSION['user'] = $row['fldUserName'];
				$_SESSION['password'] = $_POST['pwd1'];
				$_SESSION['role'] = $row['fldRole'];
				$_SESSION['facility'] = $row['fldFacility'];
				$uid = $row['fldID'];
			}
			$sql_insert = mysql_query("update tbluser set fldPassword='$savepass' where fldID='".$uid."'") or die (mysql_error());
			if($sql_insert)
			{
				$redirecturl = "index.php?pg=20";
				header("location:".$redirecturl);
			}
		}
		else
		{
			$msg = urlencode("Invalid Old Password. Please try again with correct password. ");
			header("Location: index.php?pg=43&msg=$msg");
		}
	}
	else
	{	# admin save user password
		$username = mysql_real_escape_string($_POST['username']);
		$sql = "SELECT fldID FROM tbluser WHERE fldUserName='$username'";
		$result = mysql_query($sql);
		if ( mysql_num_rows($result) != 1 )
		{

			$msg = urlencode("Invalid Username. Please try again with correct username. ");
			header("Location: index.php?pg=43&msg=$msg");
		}
		$row = mysql_fetch_row($result);
		mysql_free_result($result);
		$uid = $row[0];
		$sql = "UPDATE tbluser SET fldPassword='$savepass' where fldID='".$uid."'";
		$sql_insert = mysql_query($sql) or die (mysql_error());
	}
}
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" name="logForm" id="logForm" method="post">
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" background="main.png"  class="loginform">
	  <tr>
		<td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="3" align="middle" class="war">
		 <?
		 if (isset($_GET['msg'])) 
		 {
			  $msg = mysql_real_escape_string($_GET['msg']);
			  echo $msg;
		 }
  		?>		
		</td>
	  </tr>
<? 
if( $_SESSION['role'] == 'admin' )
{ # allow admin to change anybodys pw ?>	  
	  <tr>
	    <td width="34%">&nbsp;</td>
		<td width="13%" class="lab">User Name</td>
		<td width="53%"><input type="text" name="username" id="username" class="required" size="25"></td>
	  </tr>
<?
}

if( $_SESSION['role'] != 'admin' )
{ # if I am not admin get the old password
?>
	  <tr>
	  	<td width="34%">&nbsp;</td>
		<td class="lab">Old Password</td>
		<td><input type="password" name="pwd" id="pwd" class="required password" size="25"></td>
	  </tr>
<? 
} 
?>
	  <tr>
	  	<td width="34%">&nbsp;</td>
		<td class="lab">New Password</td>
		<td><input type="password" name="pwd1" id="pwd1" class="required password" size="25"></td>
	  </tr>
	  <tr>
	  	<td width="34%">&nbsp;</td>
		<td class="lab">Confirm Password</td>
		<td><input type="password" name="pwd2" id="pwd2" class="required password" size="25"></td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td colspan="2"><p align="center">&nbsp;</p></td>
	    <td><input name="doLogin" id="dologin" type="submit" value="Update" /></td>
	  </tr>
  </table>
</form>


