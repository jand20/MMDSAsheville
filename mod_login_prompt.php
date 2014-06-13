<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="logForm" id="logForm" >
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" background="main.png" class="loginform">
  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="3" align="middle" class="war">
	 <?
	  if ( isset($_GET['msg']) ) echo mysql_real_escape_string($_GET['msg']);
	?>		
	</td>
  </tr>
  <tr>
	<td width="34%">&nbsp;</td>
	<td width="11%" class="lab">User Name</td>
	<td width="55%"><input name="username" id="username" type="text" class="required"size="25"></td>
  </tr>
  <tr>
	<td width="34%">&nbsp;</td>
	<td class="lab">Password</td>
	<td><input name="password" id="password" type="password" class="required password" size="25"></td>
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
	<td><input name="submit" id="submit" type="submit" value="Login" /></td>
   </tr>
   <tr>
	<td colspan="2"><p align="center">&nbsp;</p></td>
	<td><div><a href="?pg=67">Request Access</a></div></td>
  </tr>
</table>
</form>