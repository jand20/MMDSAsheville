<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td height="90" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td class="lab" align="center">Select Technologist
      <select name="technologist" STYLE="width: 200px">
        <option selected="selected" value="">Select</option>
        <?
	  $sql="SELECT * FROM tbluser where fldRole='technologist' order by fldRealName";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	   {?>
        <option value="<?=$row['fldUserName']?>">
        <?=$row['fldRealName']?>
        </option>
        <? } ?>
      </select></td>
      <td width="20%">&nbsp;</td>
    </tr>
     <tr>
      <td height="10" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" value="Dispatch" /></td>
    </tr>
    <tr>
      <td height="102" colspan="4">&nbsp;</td>
    </tr>
  </table>
</form>
<?
if($_REQUEST['submit']!='')
{
$sql_insert	= mysql_query("update tblorderdetails set fldDispatched=1, fldTechnologist='".strtoupper($_REQUEST['technologist'])."' where fldID='".$id."'");
$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
}
?>