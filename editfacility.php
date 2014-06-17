<?php # PMD 2012-01-23
session_start(); // if session is not set redirect the user
if( empty($_SESSION['user']) ) header("Location:index.php");
require_once "config.php";
require_once "mod_facfuncs.php";
require_once 'common.php';

$row = mysql_fetch_row( mysql_query("SELECT varValue FROM tblsysvar WHERE varName='autodispatch'") );
$autodispatch = $row[0];
$sql_values_fetch = mysql_fetch_array( mysql_query("select * from tblfacility where fldID='$id'") );

$stateRes = getDBArray("tblstates", 'where active = 1 order by fldState');
//die(print_r($stateRes,1));
$states = ($stateRes['error_code'] == 0)? $stateRes['results']:die("An error has occured aquiring states");
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script>
$(document).ready(function() {
	$("#editfacility").validate();
	$(".phone").mask("(999) 999-9999");
});
</script>
<style type="text/css">
td:not(.lab) {text-align: left;}
</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="editfacility" action="" method="post" onsubmit="tech();">
	<table style="width:100%; background:URL('main.png'); padding: 50px;">
	<? if(isset($_GET['msg'])):
		$err=$_GET['msg'];?>
		<tr>
			<td colspan="4"><div align="center" class="war"><?=$err?></div></td>
		</tr>
	<?endif;?>
		<tr>
			<td class="lab">Facility Name:</td>
			<td><input class="required" type="text" name="facilityname" value="<?=$sql_values_fetch['fldFacilityName']?>"></td>
		</tr>
		<tr>
			<td class="lab">Disabled:</td>
			<td><input type="checkbox" name="disabled" value="1" <? if($sql_values_fetch['fldFacilityDisabled'] == 1) {?> checked="checked" <? } ?>></td>
		</tr>
		<?/* <tr>
			<td>&nbsp;</td>
			<td class="lab">Facility Organizational Type</td>
			<td><strong>:</strong></td>
			<td>
					<select name='facorgtype' id='facorgtype' class='myselect3'>
					<option value=''></option>
					<option value='Skilled'<? if( $sql_values_fetch['fldFacilityOrgType'] == 'Skilled') echo " selected"; ?>>Skilled Nursing</option>
					<option value='Assisted Living'<? if( $sql_values_fetch['fldFacilityOrgType'] == 'SAssisted Living') echo " selected"; ?>>Assisted Living</option>
					<option value='Correctional'<? if( $sql_values_fetch['fldFacilityOrgType'] == 'Correctional') echo " selected"; ?>>Correctional</option>
					<option value='Physician PracticeClinic'<? if( $sql_values_fetch['fldFacilityOrgType'] == 'Physician PracticeClinic') echo " selected"; ?>>Physician Practice Clinic</option>
					<option value='Home Health'<? if( $sql_values_fetch['fldFacilityOrgType'] == 'Home Health') echo " selected"; ?>>Home Health</option>
					</select>
		</tr> */?>	
		 <tr>
			<td class="lab">Zone</td>
			<td><input type="text" name="facilityzone" value="<?=$sql_values_fetch['fldAreaZone']?>"></td>
		</tr>
		<tr>
			<td class="lab">Facility Type:</td>
			<td><? doSelect('facilitytype',$ftypearray,$sql_values_fetch['fldFacilityType'],'required'); ?></td>
		</tr>
		<tr>
			<td class="lab">Administrators Name:</td>
			<td><input type="text" name="administratorsname" value="<?=$sql_values_fetch['fldAdminName']?>"></td>
		</tr>
		<tr>
			<td class="lab">Division Name:</td>
			<td>
				<select name="divisionname">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'division' order by fldValue";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>"<?=($sql_values_fetch['fldDivisionName'] === $row['fldValue'])?'selected="selected"':''?>><?=$row['fldValue']?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="lab">Street Address 1:</td>
			<td><input class="required" type="text" name="streetaddress1" value="<?=$sql_values_fetch['fldAddressLine1']?>"></td>
		</tr>
		<tr>
			<td class="lab">Street Address 2:</td>
			<td><input type="text" name="streetaddress2" value="<?=$sql_values_fetch['fldAddressLine2']?>"></td>
		</tr>
		<tr>
			<td class="lab">City:</td>
			<td><input class="required" type="text" name="city" value="<?=$sql_values_fetch['fldAddressCity']?>"></td>
		</tr>
		<tr>
			<td class="lab">State:</td>
			<td>
				<select class="required" name="state">
					<option value=''></option>
				<?
			foreach ($states as $state):
				$selected = ($sql_values_fetch['fldAddressState'] === $state['fldSt'])?'selected="selected"':'';
				echo "<option value='{$state['fldSt']}' $selected>{$state['fldState']}</option>";
			endforeach;
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="lab">Zip Code:</td>
			<td><input class="required" type="text" name="zipcode" value="<?=$sql_values_fetch['fldAddressZip']?>"></td>
		</tr>
		<tr>
			<td class="lab">Phone Number:</td>
			<td><input id="phonenumber" class="required phone" type="text" name="phonenumber" value="<?=$sql_values_fetch['fldPhoneNumber']?>"></td>
		</tr>
		<tr>
			<td class="lab">Fax Number:</td>
			<td><input id="faxnumber" class="phone" type="text" name="faxnumber" value="<?=$sql_values_fetch['fldFaxNumber']?>"></td>
		</tr>
		<tr>
			<td class="lab">Email:</td>
			<td><input type="text" name="email" value="<?=$sql_values_fetch['fldEmail']?>"></td>
		</tr>
		<tr>
			<td class="lab">Email Order:</td>
			<td><input type="checkbox" name="emailorder" value="1" <? if($sql_values_fetch['fldEmailOrder'] == 1) {?> checked="checked" <? } ?>></td>
		</tr>
		<tr>
			<td class="lab">Main State:</td>
			<td>
				<select class="required" name='mainstate' id='mainstate'>
					<option value=''></option>
				<?foreach ($states as $state):
					$selected = ($sql_values_fetch['fldMainState'] === $state['fldSt'])?'selected="selected"':'';
					echo "<option value='{$state['fldSt']}' $selected>{$state['fldState']}</option>";
				endforeach;?>
				</select>
			</td>
		</tr>
	<?
	if($autodispatch == 1):?>
		<tr>
			<td class="lab">Auto Dispatch:</td>
			<td><input type="checkbox" name="autodis" value="1" <? if($sql_values_fetch['fldAutoDispatch'] == 1) {?> checked="checked" <? } ?>></td>
		</tr>
		<tr>
			<td class="lab">Select Technologist:</td>
			<td>
				<select name="technologist">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbluser where fldRole='technologist' AND fldStatus='Enabled' order by fldRealName";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldUserName']?>" <?=($sql_values_fetch['fldTechnologist'] === $row['fldUserName'])?'selected="selected"':''?>><?=$row['fldRealName']?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
	<?endif;?>
	
	<script type="text/javascript">
	function openWindow()
	{
		window.showModalDialog('facstationpop.php?facID=<?=$sql_values_fetch['fldID']?>');
	}
	</script>
	
		<tr>
			<td class="lab">Stations:</td>
			<td><input type=button value='Stations ...' onclick='openWindow();'></td>
		</tr>
		<tr>
			<td class="lab">Billing Contact Name:</td>
			<td><input type="text" name="facBillingContact" value="<?=$sql_values_fetch['fldBillingContact']?>"></td>
		</tr>
		<tr>
			<td class="lab">Billing Phone #:</td>
			<td><input type="text" name="facBillingPhone" value="<?=$sql_values_fetch['fldBillingPhone']?>"></td>
		</tr>
		<tr>
			<td class="lab">Billing fax #:</td>
			<td><input type="text" name="facBillingFax" value="<?=$sql_values_fetch['fldBillingFax']?>"></td>
		</tr>
		<tr>
			<td class="lab">Billing Rep:</td>
			<td><input type="text" name="facBillingRep" value="<?=$sql_values_fetch['fldBillingRep']?>"></td>
		</tr>
		<tr>
			<td class="lab">Billing Account #:</td>
			<td><input type="text" name="facBillingAccNum" value="<?=$sql_values_fetch['fldBillingAccNum']?>"></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;"><br/><br/><input type="submit" name="submit" value="Update"></td>
		</tr>
	</table>
</form>

<?php
// Getting Values from the registration to create Master Account
if( $_REQUEST['submit'] !=	''	)
{
		$autodis = 0 ;
		if ( isset($_REQUEST['autodis']) ) $autodis = 1;
		if( $autodis == 1 && $_REQUEST['technologist']=='')
		{
				header("Location: index.php?pg=14&id=$id&msg=Please Select Technologist");
				exit();
		}

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

		$tech='';
		if ( $autodispatch == 1 )
		{
				if( $autodis == 1 )
				$tech = $_REQUEST['technologist'];
		}

		$strSQL = "UPDATE tblfacility SET
				fldFacilityName='".strip_tags(addslashes($_REQUEST['facilityname']))."',
				fldFacilityType='".strip_tags(addslashes($_REQUEST['facilitytype']))./* "',		unused ATM
				fldFacilityOrgType='".strip_tags(addslashes($_REQUEST['facorgtype']))." */"',
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
				fldFacilityDisabled='".strip_tags(addslashes($_REQUEST['disabled']))."',
				fldTechnologist='".strip_tags(addslashes($tech))."',
				fldBillingContact='".strip_tags(addslashes($_REQUEST['facBillingContact']))."',
				fldBillingPhone='".strip_tags(addslashes($_REQUEST['facBillingPhone']))."',
				fldBillingFax='".strip_tags(addslashes($_REQUEST['facBillingFax']))."',
				fldBillingRep='".strip_tags(addslashes($_REQUEST['facBillingRep']))."',
				fldAreaZone='".$_REQUEST['facilityzone']."',
				fldBillingAccNum='".strip_tags(addslashes($_REQUEST['facBillingAccNum']))."',
				fldMainState='".$_REQUEST['mainstate']."'
				where fldID='".$id."'";
		
		$sql_insert = mysql_query($strSQL);

		if($sql_insert)
		{
				$redirecturl = "index.php?pg=13";
				header("location:".$redirecturl);
		}
}
?>