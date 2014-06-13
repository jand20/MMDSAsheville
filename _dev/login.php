<?php

include 'config.php';

if ($_POST['doLogin']=='Login')
{
$user = mysql_real_escape_string($_POST['username']);
$md5pass = MD5(mysql_real_escape_string($_POST['pwd']));

$sql = "SELECT * FROM tbluser WHERE fldUserName = '$user' AND fldPassword = '$md5pass'";
$result = mysql_query($sql) or die (mysql_error());
$num = mysql_num_rows($result);
	if($num)
	{

		session_start();
		// this sets variables in the session
		while($row = mysql_fetch_array($result))
		{
		$_SESSION['user']= $row['fldUserName'];
		$_SESSION['password']= $row['fldPassword'];
		$_SESSION['role']= $row['fldRole'];
		$role= $_SESSION['role'];
		$_SESSION['facility']= $row['fldFacility'];
		}
		//set a cookie witout expiry until 60 days

		if(isset($_POST['rememberme'])){
				  setcookie("user", $_SESSION['user'], time()+60*60*24*60, "/");
				  setcookie("role", $_SESSION['role'], time()+60*60*24*60, "/");
				  setcookie("password", $_SESSION['password'], time()+60*60*24*60, "/");
				   }
	$logtime=date("Y-m-d H:i",time());

	$myFile = "logindetails.csv";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = $logtime . "," . $_SESSION['user'] . "\n";
	fwrite($fh, $stringData);
	fclose($fh);

	if($role=='biller')
	{
		$redirecturl = "index.php?pg=55";
	}
	else
	{
		$redirecturl = "index.php?pg=20";
	}

	header("location:".$redirecturl);
	}
	else
	{
		$msg = urlencode("Invalid Login. Please try again with correct user name and password. ");
		header("Location: index.php?&msg=$msg");
	}

}

?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="logForm" id="logForm" >
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" background="main.png"  class="loginform">
	  <tr>
		<td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="3" align="middle" class="war">
		  <?
		  if (isset($_GET['msg'])) {
		  $msg = mysql_real_escape_string($_GET['msg']);
		  echo $msg;
		  }
  		?>		</td>
	  </tr>
	  <tr>
	    <td width="34%">&nbsp;</td>
		<td width="11%" class="lab">User Name</td>
		<td width="55%"><input name="username" type="text" class="required" id="txtbox" size="25"></td>
	  </tr>
	  <tr>
	  	<td width="34%">&nbsp;</td>
		<td class="lab">Password</td>
		<td><input name="pwd" type="password" class="required password" id="txtbox" size="25"></td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	    <td>
	      <input name="rememberme" type="checkbox" id="remember" value="1" />
	    </div></td>
	    <td> Remember Me</td>
	  </tr>
	  <tr>
		<td height="10"><div align="center"></div></td>
	  </tr>
	  <tr>
		<td colspan="2"><p align="center">&nbsp;</p></td>
	    <td><input name="doLogin" type="submit" id="dologin" value="Login" /></td>
	   </tr>
	   <tr>
	    <td colspan="2"><p align="center">&nbsp;</p></td>
		<td><div><a href="?pg=67">Request Access</a></div></td>
	  </tr>
  </table>
</form>

