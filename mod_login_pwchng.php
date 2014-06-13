<?php  # a password change is required
if ( $submit == 'Change' )
{
	if ( $pw1 == '' || $pw2 == '' && $strErr == '' ) $strErr = "Must Enter Password Twice<br>";
	if ( $pw1 != $pw2 && $strErr == '' ) $strErr = "Passwords Do Not Match<br>";
	if ( $pw1 == $pw2 && $strErr == '' )
	{
		$md5pass = md5($pw1);
		$strSQL = "UPDATE tbluser SET `fldPWChange`='0',`fldPassword`='$md5pass' WHERE fldUserName='$username'";
		mysql_query($strSQL);
		$strErr = "";
		$submit = "";
	}
}

if ( $strErr != '' )
{
?>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" background="main.png" class="loginform">
	  <form action='' method=post>
	  <input type='hidden' name='username' value='<? echo $username; ?>'>
	  <tr><td colspan=3 style='text-align:center;' class=war>
		<B><? echo $strErr; ?></B>
	  </td></tr>				
	  <tr>
		<td width="34%">&nbsp;</td>
		<td width="11%" class="lab">New Password</td>
		<td width="55%"><input name="pw1" id="pw1" type="password" class="required" size="25"></td>
	  </tr>
	  <tr>
		<td width="34%">&nbsp;</td>
		<td class="lab">Retype Password</td>
		<td><input name="pw2"id="pw2" type="password" class="required password" size="25"></td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td colspan="2"><p align="center">&nbsp;</p></td>
		<td><input name="submit" id="submit" type="submit" value="Change" /></td>
	  </tr>
	  </form>
	</table>
<?
}
if ( $strErr == '' && $submit == '') include "mod_login_process.php";
?>