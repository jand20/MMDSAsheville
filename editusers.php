<?php #pmd 20120130
session_start();
// if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");
require_once "config.php";
require_once 'common.php';

$sql_values_fetch =	mysql_fetch_array(mysql_query("SELECT * FROM tbluser WHERE fldID='$id'"));

$stateRes = getDBArray("tblstates", 'where active = 1 order by fldState');
//die(print_r($stateRes,1));
$states = ($stateRes['error_code'] == 0)? $stateRes['results']:die("An error has occured aquiring states");
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script>
$(document).ready(function() {
	$("#edituser").validate();
	$("#phone").mask("(999) 999-9999");
	$("#fax").mask("(999) 999-9999");
});
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="edituser" action="" method="post">
<table width="100%" border="0" background="main.png">
  <tr>
    <td>&nbsp;</td>
    <td class="lab">User ID</td>
    <td><strong>:</strong></td>
    <td><input class="required" type="text" name="userid"  value="<?=$sql_values_fetch['fldUserID']?>" readonly="true"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Real Name</td>
    <td><strong>:</strong></td>
    <td><input class="required" type="text" name="realname"  value="<?=$sql_values_fetch['fldRealName']?>"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">User Name</td>
    <td><strong>:</strong></td>
    <td><input class="required" type="text" name="username"  value="<?=$sql_values_fetch['fldUserName']?>"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Email</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="email"  value="<?=$sql_values_fetch['fldEmail']?>">
      <input name="emailchk" type="checkbox" class="chk " value="1" <?=($sql_values_fetch['fldEmailPref'] == 1)?'checked="checked"':''?> /></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Role</td>
    <td><strong>:</strong></td>
    <td>
	  <select class="required" name="role">
	  <option value="">Select</option>
	  <option value="admin" <? if($sql_values_fetch['fldRole'] == 'admin') {?> selected="selected" <? } ?>>Admin</option>
	  <option value="coder" <? if($sql_values_fetch['fldRole'] == 'coder') {?> selected="selected" <? } ?>>Coder</option>
	  <option value="dispatcher" <? if($sql_values_fetch['fldRole'] == 'dispatcher') {?> selected="selected" <? } ?>>Dispatcher</option>
	  <option value="facilityuser" <? if($sql_values_fetch['fldRole'] == 'facilityuser') {?> selected="selected" <? } ?>>Facility User  </option>
	  <option value="orderingphysician" <? if($sql_values_fetch['fldRole'] == 'orderingphysician') {?> selected="selected" <? } ?>>Ordering Physician </option>
	  <option value="technologist" <? if($sql_values_fetch['fldRole'] == 'technologist') {?> selected="selected" <? } ?>>Technologist</option>
	  </select>    </td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Facility</td>
    <td><strong>:</strong></td>
    <td>
     <select name="facility[]" class="myselect1" multiple="true" size="3">
      <?
	  $sql="SELECT * FROM tblfacility where 1";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	    { ?>
        <option value="<?=$row['fldFacilityName']?>" <?
		$sql1 = "select * from tbluserfacdetails where fldUserID='$id'";
		$result1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
	    {
        if($row1['fldFacility'] == $row['fldFacilityName']) {?> selected="selected" <? }
        }
        ?>>
          <?=$row['fldFacilityName']?>
        </option>
      <? } ?>
     </select>
    </td>
  </tr>
  <tr>
      <td height="5" colspan="4"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="lab">Phone</td>
      <td><strong>:</strong></td>
      <td><input id="phone" type="text" name="phone"  value="<?=$sql_values_fetch['fldPhone']?>">
      <input name="phonechk" type="checkbox" class="chk " value="1" <? if($sql_values_fetch['fldSMSPref'] == 1) {?>checked="checked"<? } ?> /></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Fax</td>
    <td><strong>:</strong></td>
    <td><input id="fax" type="text" name="fax" value="<?=$sql_values_fetch['fldFax']?>"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
  
  <tr>
    <td height="10" colspan="4"></td>
  </tr>  
  
    <tr>
    <td>&nbsp;</td>
    <td class="lab">Force Password Change at Next Login</td>
    <td><strong>:</strong></td>
    <td>
	<input name="pwchange" type="checkbox" class="chk " value="1" <? if($sql_values_fetch['fldPWChange'] == 1) {?>checked="checked"<? } ?> /></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>  
   
  <tr>
    <td>&nbsp;</td>
    <td><br></td>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Update"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
</table>
</form>

<?php
// Getting Values from the registration to create Master Account
function phone_number($sPhone)
{
    $sPhone = preg_replace("#[^0-9]#",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.")".$sPrefix."-".$sNumber;
    return($sPhone);
}

if($_REQUEST['submit']!='') # fldFacility='".strip_tags(addslashes($_REQUEST['facility']))."', 
{
	$strSQL = "UPDATE tbluser SET
		fldRealName='".strip_tags(addslashes($_REQUEST['realname']))."',
		fldUserName='".strip_tags(addslashes($_REQUEST['username']))."',
		fldEmail='".strip_tags(addslashes($_REQUEST['email']))."',
		fldRole='".strip_tags(addslashes($_REQUEST['role']))."',
		fldFacility='".$_REQUEST['facility']."',
		fldPhone='".phone_number($_REQUEST['phone'])."',
		fldEmailPref='".strip_tags(addslashes($_REQUEST['emailchk']))."',
		fldSMSPref='".strip_tags(addslashes($_REQUEST['phonechk']))."',
		fldPWChange='".$_REQUEST['pwchange']."'
		WHERE fldID='".$id."'";
		
		#echo "[$strSQL]";

	//fldPassword='".md5(strip_tags(addslashes($_REQUEST['password'])))."',
	$sql_insert	= mysql_query($strSQL) or die (mysql_error());

	if($sql_insert)
	{
		$mySelected=$_POST['facility'];
		if($mySelected!="")
		{
		$sql_delete_facility = mysql_query("DELETE FROM tbluserfacdetails WHERE fldUserID='".strip_tags(addslashes($id))."'");
			foreach ($mySelected as $item)
			{
				$sql_insert_facility = mysql_query("INSERT INTO tbluserfacdetails SET
				fldFacility='".strip_tags(addslashes($item))."',
				fldUserID='".strip_tags(addslashes($id))."'
				") or die (mysql_error());
			}
		}
	}

	if($sql_insert)
	{
		$redirecturl = "index.php?pg=2";
		header("location:".$redirecturl);
	}
}
?>
