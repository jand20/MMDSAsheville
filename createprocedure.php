<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post">
<table width="100%" border="0" background="main.png">
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
  </tr>
    <? if(isset($_GET['msg'])) { ?>
    <tr>
        <td colspan="13" height"10"><div align="center" class="war">CPT Code Already Exist</div></td>
    </tr>
    <tr>
        <td height="5" colspan="13"></td>
    </tr>
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">CPT Code</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="cbtcode"></td>
    <td>&nbsp;</td>
    <td class="lab">Description</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="description"></td> 
    <td>&nbsp;</td>
    <td class="lab">Modality</td>
    <td><strong>:</strong></td>
    <td>
      <select name="modality">
	  <option selected="selected" value="">Select</option>
	  <?
	  $sql="SELECT * FROM tbllists where fldListName = 'modality' order by fldValue";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	   {?>
	  <option value="<?=$row['fldValue']?>"><?=$row['fldValue']?></option>
	  <? } ?>
	  </select>    </td>
    <td>&nbsp;</td>
 </tr>
  <tr>
    <td height="5" colspan="13"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Category</td>
    <td><strong>:</strong></td>
    <td>
      <select name="pcategory">
	  <option selected="selected" value="">Select</option>
	  <?
	  $sql="SELECT * FROM tbllists where fldListName = 'pcategory' order by fldValue";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	   {?>
	  <option value="<?=$row['fldValue']?>"><?=$row['fldValue']?></option>
	  <? } ?>
	  </select>    </td>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
 </tr>
  
  <tr>
    <td height="5" colspan="13"></td>
  </tr>
  <tr>
 
  </tr>
  <tr>
    <td height="10" colspan="13"></td>
  </tr>
  <tr>
    <td colspan="13" align="middle"><input type="submit" name="submit" value="Create"></td>
  </tr>
  <tr>
    <td height="10" colspan="13"></td>
  </tr>
</table>
</form>

<?php

if($_REQUEST['submit']!='')
{
$usr = $_REQUEST['cbtcode'];
$rs_duplicate = mysql_query("select count(*) as total from tblproceduremanagment where fldCBTCode='$usr'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

$sql_insert = mysql_query("insert into tblproceduremanagment set
fldCBTCode='".strip_tags(addslashes($_REQUEST['cbtcode']))."',
fldDescription='".strip_tags(addslashes($_REQUEST['description']))."',
fldModality='".strip_tags(addslashes($_REQUEST['modality']))."',
fldCategory='".strip_tags(addslashes($_REQUEST['pcategory']))."' 
") or die (mysql_error());

if($sql_insert)
{
$redirecturl = "index.php?pg=9";
header("location:".$redirecturl);
}
}
?>

