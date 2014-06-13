<?php session_start();
//if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="myform" action="" method="post">
<table width="1050" border="0" cellpadding="0" cellspacing="0" background="main.png">
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="middle">
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td align="middle"> Cannot Delete an Order with Exception</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td align="middle"><input type="submit" name="submit" value="Go Back"></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
<?php

if($_REQUEST['submit']!='')
{
$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
}
?>