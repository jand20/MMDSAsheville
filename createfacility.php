<?php # PMD 20120130
//TODO fix formatting
session_start(); // if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");
require_once "config.php";
require_once "mod_facfuncs.php";
require_once 'common.php';

$row = mysql_fetch_row( mysql_query("SELECT varValue FROM tblsysvar WHERE varName='autodispatch'") );
$autodispatch = $row[0];

$stateRes = getDBArray("tblstates", 'where active = 1 order by fldState');
//die(print_r($stateRes,1));
$states = ($stateRes['error_code'] == 0)? $stateRes['results']:die("An error has occured aquiring states");
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script>
$(document).ready(function() {
	$("#createfacility").validate();
	$(".phone").mask("(999) 999-9999");
});
</script>
<form id="createfacility" action="" method="post" id='newfacility'>
	<table width="100%" border="0" background="main.png">
		<tr>
			<td width="16%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="2%">&nbsp;</td>
			<td width="67%">&nbsp;</td>
		</tr>
		<? if(isset($_GET['msg'])) 
		{
		    $err=$_GET['msg'];?>
		<tr>
			<td colspan="4"height"10"><div align="center" class="war">
					<?=$err?>
				</div></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<? } ?>
		<tr>
		    <td>&nbsp;</td>
		    <td class="lab">Active Account</td>
		    <td><strong>:</strong></td>
		    <td><input type="checkbox" name="facActive" checked="checked" value="0"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Facility Name</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facilityname" class="required" id="Facility Name"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<!-- <tr>
    <td>&nbsp;</td>
    <td class="lab">Facility Organizational Type</td>
    <td><strong>:</strong></td>
    <td>
        <select name='facorgtype' id='facorgtype' class='myselect3'>
        <option value=''></option>
        <option value='Skilled Nursing'>Skilled Nursing</option>
        <option value='Assisted Living'>Assisted Living</option>
        <option value='Correctional'>Correctional</option>
        <option value='Physician PracticeClinic'>Physician Practice Clinic</option>
        <option value='Home Health'>Home Health</option>
        </select>
  </tr> unused -->
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Zone</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facilityzone"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Facility Order Type</td>
			<td><strong>:</strong></td>
			<td><? doSelect('facilitytype',$ftypearray,'','required'); ?></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Administrators Name</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="administratorsname"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Division Name</td>
			<td><strong>:</strong></td>
			<td><select name="divisionname">
					<option selected="selected" value="">Select</option>
					<?
					$sql="SELECT * FROM tbllists where fldListName = 'division' order by fldValue";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result))
     {?>
					<option value="<?=$row['fldValue']?>">
						<?=$row['fldValue']?>
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
			<td class="lab">Street Address 1</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="streetaddress1" class="required"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Street Address 2</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="streetaddress2"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">City</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="city" class="required"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">State</td>
			<td><strong>:</strong></td>
			<td><select name='state' id='state' class='required'>
					<option value=''></option>
				<?
				if(is_array($states[0])):
					foreach ($states as $state):
						$selected = ($sql_values_fetch['fldAddressState'] === $state['fldState'])?'selected="selected"':'';
						echo "<option value='{$state['fldSt']}' $selected>{$state['fldState']}</option>";
					endforeach;
				else:
					echo "<option value='{$states['fldSt']}' selected='selected'>{$states['fldState']}</option>";
				endif;
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Zip Code</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="zipcode" class="required"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Phone Number</td>
			<td><strong>:</strong></td>
			<td><input type="text" id="phonenumber" name="phonenumber" class="required phone"></td>
		</tr>
		<tr>
			<td height="5" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Fax Number</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="faxnumber" class="phone"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Email</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Email Order</td>
			<td><strong>:</strong></td>
			<td><input type="checkbox" name="emailorder" value="1"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td class="lab">Main State</td>
			<td><strong>:</strong></td>
			<td><select name='mainstate' id='mainstate' class='required'>
					<option value=''></option>
				<?
				if(is_array($states[0])):
					foreach ($states as $state):
						$selected = ($sql_values_fetch['fldMainState'] === $state['fldState'])?'selected="selected"':'';
						echo "<option value='{$state['fldSt']}' $selected>{$state['fldState']}</option>";
					endforeach;
				else:
					echo "<option value='{$states['fldSt']}' selected='selected'>{$states['fldState']}</option>";
				endif;
				?>
			</select>
		
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Billing Contact Name</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facBillingContact"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Billing Phone #</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facBillingPhone"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Billing fax #</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facBillingFax"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Billing Rep</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facBillingRep"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Billing Account #</td>
			<td><strong>:</strong></td>
			<td><input type="text" name="facBillingAccNum"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>

		<?php 
		if ( $autodispatch == 1 )
{ ?>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Auto Dispatch</td>
			<td><strong>:</strong></td>
			<td><input type="checkbox" name="autodis" value="1"></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="lab">Select Technologist</td>
			<td><strong>:</strong></td>
			<td><select name="technologist" STYLE="width: 200px">
					<option selected="selected" value="">Select</option>
					<?
      $sql="SELECT * FROM tbluser WHERE fldRole='technologist' AND fldStatus='Enabled' ORDER BY fldRealName";
      $result = mysql_query($sql);
      while($row = mysql_fetch_array($result))
      {?>
					<option value="<?=$row['fldUserName']?>">
						<?=$row['fldRealName']?>
					</option>
					<? } ?>
			</select></td>
		</tr>
		<tr>
			<td height="10" colspan="4"></td>
		</tr>


		<? 
} ?>
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

if($_REQUEST['submit']!='')
{

    $usr = $_REQUEST['facilityname'];
    $rs_duplicate = mysql_query("select count(*) as total from tblfacility where fldFacilityName='$usr'") or die(mysql_error());
    list($total) = mysql_fetch_row($rs_duplicate);
    if ($total > 0)
    {
        header("Location: index.php?pg=12&msg=Facility Already Exist");
        exit();
    }

    $tech = '';
    $autodis = 0 ;
    if ( isset($_REQUEST['autodis']) ) $autodis = 1;

    if($autodis==1 && $_REQUEST['technologist']=='')
    {
        header("Location: index.php?pg=12&msg=Please Select Technologist");
        exit();
    }
    
    if( $autodis == 1 ) $tech=$_REQUEST['technologist'];

    function phone_number($sPhone){
        $sPhone = preg_replace("#[^0-9]#",'',$sPhone);
        if(strlen($sPhone) != 10) return(False);
        $sArea = substr($sPhone,0,3);
        $sPrefix = substr($sPhone,3,3);
        $sNumber = substr($sPhone,6,4);
        $sPhone = "(".$sArea.")".$sPrefix."-".$sNumber;
        return($sPhone);
    }

    $tech='';
    if ( $autodispatch == 1 )
    {
        if( $autodis == 1 )
        $tech = $_REQUEST['technologist'];
    }
    
    $varFacDisabled = 0;
    
    if(!isset($_REQUEST['facActive']))
    {
        print_r($_REQUEST['facActive']);
        exit();
    }
    
    

    $strSQL =  "INSERT INTO tblfacility SET
    fldFacilityName='".strip_tags(addslashes($_REQUEST['facilityname']))."',
    fldFacilityType='".strip_tags(addslashes($_REQUEST['facilitytype']))."',
    "/* fldFacilityOrgType='".strip_tags(addslashes($_REQUEST['facorgtype']))."', unused*/."
    fldAdminName='".strip_tags(addslashes($_REQUEST['administratorsname']))."',
    fldDivisionName='".strip_tags(addslashes($_REQUEST['divisionname']))."',
    fldAddressLine1='".strip_tags(addslashes($_REQUEST['streetaddress1']))."',
    fldAddressLine2='".strip_tags(addslashes($_REQUEST['streetaddress2']))."',
    fldAddressCity='".strip_tags(addslashes($_REQUEST['city']))."',
    fldAddressState='".strip_tags(addslashes($_REQUEST['state']))."',
    fldAddressZip='".strip_tags(addslashes($_REQUEST['zipcode']))."',
    fldPhoneNumber='".phone_number($_REQUEST['phonenumber'])."',
    fldFaxNumber='".strip_tags(addslashes($_REQUEST['faxnumber']))."',
    fldEmail='".strip_tags(addslashes($_REQUEST['email']))."',
    fldAutoDispatch='$autodis',
    fldEmailOrder='".strip_tags(addslashes($_REQUEST['emailorder']))."',
    fldTechnologist='".strip_tags(addslashes($tech))."',
    fldBillingContact='".strip_tags(addslashes($_REQUEST['facBillingContact']))."',
    fldBillingPhone='".strip_tags(addslashes($_REQUEST['facBillingPhone']))."',
    fldBillingFax='".strip_tags(addslashes($_REQUEST['facBillingFax']))."',
    fldBillingRep='".strip_tags(addslashes($_REQUEST['facBillingRep']))."',
    fldBillingAccNum='".strip_tags(addslashes($_REQUEST['facBillingAccNum']))."',
    fldMainState='".$_REQUEST['mainstate']."',
    fldStartDate='".$_REQUEST['startdate']."',
	fldAreaZone='".$_REQUEST['facilityzone']."',
    fldFacilityDisabled='".strip_tags(addslashes($_REQUEST['facActive']))."'";
    
    /* print_r($strSQL);
    
    exit(); */
    
    $sql_insert = mysql_query($strSQL) or die('you suck'.mysql_error());

    if($sql_insert)
    {
        $redirecturl = "index.php?pg=13";
        header("location:".$redirecturl);
    }
}
?>

