<?php # pmd 20120130
session_start();
// if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");
require_once "config.php";
require_once 'common.php';

$stateRes = getDBArray("tblstates", 'where active = 1 order by fldState');
//die(print_r($stateRes,1));
$states = ($stateRes['error_code'] == 0)? $stateRes['results']:die("An error has occured aquiring states");

//die(var_dump($states));

?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script>
$(document).ready(function() {
	$("#createuser").validate();
	$("#phone").mask("(999) 999-9999");
	$("#fax").mask("(999) 999-9999");
});
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="createuser" action="" method="post">
<table width="100%" border="0" background="main.png">
  <tr>
    <td width="21%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="67%">&nbsp;</td>
  </tr>
  <? if(isset($_GET['msg'])) { ?>
  <tr>
      <td colspan="4" height"10"><div align="center" class="war">User Name Already Exist</div></td>
  </tr>
  <tr>
      <td height="5" colspan="4"></td>
  </tr>
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Real Name</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="realname" class="required" <?=isset($_REQUEST['md'])?'value="'.$_REQUEST['md'].'"':''?>/></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">User Name</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="username" class="required"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Password</td>
    <td><strong>:</strong></td>
    <td><input type="password" name="password" class="required"></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Email</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="email">
      <input name="emailchk" type="checkbox" class="chk " value="1" /></td>
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
	  <option selected="selected" Value="">Select</option>
	  <option Value="admin">Admin</option>
	  <option Value="coder">Coder</option>
	  <option Value="dispatcher">Dispatcher</option>
	  <option Value="facilityuser">Facility User  </option>
	  <option Value="orderingphysician">Ordering Physician </option>
	  <option value="technologist">Technologist</option>
	  </select>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Facility</td>
    <td><strong>:</strong></td>
    <td>
      <select name="facility[]" multiple="true" size="3">
	  <option selected="selected" value="">Select</option>
	  <?
	  $sql="SELECT * FROM tblfacility where 1";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	   {?>
	  <option value="<?=$row['fldFacilityName']?>"><?=$row['fldFacilityName']?></option>
	  <? } ?>
	  </select>  </td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Phone</td>
    <td><strong>:</strong></td>
    <td><input id="phone" type="text" name="phone">
      <input name="phonechk" type="checkbox" class="chk " value="1" /></td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lab">Fax</td>
    <td><strong>:</strong></td>
    <td><input id="fax" type="text" name="fax"></td>
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
	<input name="pwchange" type="checkbox" class="chk " value="1" <?=($sql_values_fetch['fldPWChange'] == 1)?'checked="checked"':'';?> /></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>  
  
  
  
  <tr>
    <td>&nbsp;</td>
    <td><br></td>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Create"></td>
  </tr>
  <tr>
    <td height="10" colspan="4"></td>
  </tr>
</table>
</form>
<?php
// Getting Values from the registration to create Master Account
if( $_REQUEST['submit'] != '' )
{
	$usr = $_REQUEST['username'];
	$rs_duplicate = mysql_query("select count(*) as total from tbluser where fldUserName='$usr'") or die(mysql_error());
	list($total) = mysql_fetch_row($rs_duplicate);
	if ($total > 0)
	{
		header("Location: index.php?pg=1&msg='err'");
		exit();
	}

	// Generate a random character string
	$length = 8;
	$chars = '1234567890';

	// Length of character list
	$chars_length = (strlen($chars) - 1);

	// Start our string
	$string = $chars{rand(0, $chars_length)};

	// Generate random string
	for ($i = 1; $i < $length; $i = strlen($string))
	{
		// Grab a random character from our list
		$r = $chars{rand(0, $chars_length)};

		// Make sure the same two characters dont appear next to each other
		if ($r != $string{$i - 1}) $string .=  $r;
	}

	function phone_number($sPhone){
		$sPhone = Preg_replace("#[^0-9]#",'',$sPhone);
		if(strlen($sPhone) != 10) return(False);
		$sArea = substr($sPhone,0,3);
		$sPrefix = substr($sPhone,3,3);
		$sNumber = substr($sPhone,6,4);
		$sPhone = "(".$sArea.")".$sPrefix."-".$sNumber;
		return($sPhone);
	}
	//Insert the records in to tblAdminAccount

	$strSQL = "INSERT INTO tbluser SET fldUserID='".$string."',
		fldRealName='".strip_tags(addslashes($_REQUEST['realname']))."',
		fldUserName='".strip_tags(addslashes($_REQUEST['username']))."',
		fldPassword='".md5(strip_tags(addslashes($_REQUEST['password'])))."',
		fldEmail='".strip_tags(addslashes($_REQUEST['email']))."',
		fldRole='".strip_tags(addslashes($_REQUEST['role']))."',
		fldFacility='".strip_tags(addslashes($_REQUEST['facility']))."',
		fldPhone='".phone_number($_REQUEST['phone'])."',
		fldFax='".phone_number($_REQUEST['fax'])."',
		fldEmailPref='".strip_tags(addslashes($_REQUEST['emailchk']))."',
		fldSMSPref='".strip_tags(addslashes($_REQUEST['phonechk']))."',
		fldPWChange='".$_REQUEST['pwchange']."'";
	
	$sql_insert	= mysql_query($strSQL);

	if($sql_insert)
	{
		$id = mysql_insert_id();
		$mySelected = $_POST['facility'];
		foreach ($mySelected as $item)
		{
			$sql_insert_facility = mysql_query("insert into tbluserfacdetails set
			fldFacility='".strip_tags(addslashes($item))."',
			fldUserID='".strip_tags(addslashes($id))."'");
		}
	}

	if($sql_insert_facility)
	{
		//echo "Your User ID is " .$string;
		$last_inserted_id	=	mysql_insert_id();
		$redirecturl = "index.php?pg=2";
		header("Location:".$redirecturl);
	}
}
?>

