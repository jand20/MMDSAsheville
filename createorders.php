<?php
//ini_set('display_errors', 1);
//die(print_r($_REQUEST,true));

if(empty($_SESSION))
	session_start();

//if session is not set redirect the user
if(empty($_SESSION['user']))
	header("Location:index.php");

require_once 'common.php';
require_once "config.php";
require_once 'modalityWorklist.php';

$action = (isset($_REQUEST['action'])?$_REQUEST['action']:'');
$submit = (isset($_REQUEST['submit'])?$_REQUEST['submit']:'');

if( $_REQUEST['action'] === 'Save' )
{
	$_REQUEST['patientid']	= $_REQUEST['patientid1'];
	$_REQUEST['patientssn']	= $_REQUEST['patientssn1'];
	$_REQUEST['firstname']	= $_REQUEST['firstname1'];
	$_REQUEST['lastname']	= $_REQUEST['lastname1'];
}

function PIDGen()
{
	$sql	= "SELECT DISTINCT CAST(fldPatientID AS UNSIGNED) as fldPatientID from tblorderdetails where fldPatientID not rlike '^[[:alpha:]]' and fldPatientID <> '' order by fldPatientID asc";
	//echo $sql;
	$result = mysql_query($sql) or die(mysql_error()." $sql");
	$maxID = 1;

	if(mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_array($result))
		{
			$pid = preg_replace('/\D/', '', $row['fldPatientID']);

			if(intval($maxID) <= $pid)
			{
				$maxID = $pid + 1;
			}
		}
	}
	else
	{
		$pid = 25000;
	}

	//increase 1 and cast as a string so you dont get 10e12 or some nonsense.
	$pid = "$maxID";
	//return new/incremented pid
	return $pid;
}

function getPID()
{
	$pid = 1;
	if($_REQUEST['id'] === '' || !isset($_REQUEST['id']))
	{
		if($_REQUEST['patientid'] === '' || !isset($_REQUEST['patientid']))
		{
			$pid = PIDGen();
			//echo $pid." is generated";
		}
		else
		{
			$pid = $_REQUEST['patientid'];
			//echo $pid." is assumed";
		}
	}
	else
	{
		$sql	= "SELECT DISTINCT fldPatientID from tblorderdetails where fldID = '{$_REQUEST['id']}'";
		//die($sql);
		$result = mysql_fetch_assoc(mysql_query($sql));

		$pid = $result['fldPatientID'];

		$pid = (empty($pid)?PIDGen():$pid);
	}

	return $pid;
}

$eventtype = 'Add';

if (!empty($_REQUEST ['savennew']) || !empty($_REQUEST ['savecnew']))
{
	$_REQUEST ['submit'] = 'Add';
	$submit = 'Add';
}

#echo "type is: $type";

/* Patient Conflict in development //FIXME
if($_REQUEST['submit'] !== '')
{
	//PT Conflict

	if($_REQUEST['action'] != 'Continue Anyway' && $_REQUEST['patientssn'] ):
		if($_REQUEST['submit'] == 'Save'):
			$sql = "SELECT * FROM tblorderdetails WHERE fldID != '{$_REQUEST['fldID']}' AND fldPatientSSN = '{$_REQUEST['patientssn']}' AND (fldFirstName != '{$_REQUEST['firstname']}' OR fldLastName != '{$_REQUEST['lastname']}' OR fldPatientID <> '".getPID()."')";
		else:
			$sql = "SELECT * FROM tblorderdetails WHERE fldPatientSSN = '{$_REQUEST['patientssn']}' AND (fldFirstName <> '{$_REQUEST['firstname']}' OR fldLastName <> '{$_REQUEST['lastname']}' OR fldPatientID <> '".getPID()."')";
		endif;

		//die(print_r($sql,true));

		$result = mysql_query($sql);

		$errcount = mysql_num_rows($result);
		if($errcount > 0):
			$row = mysql_fetch_array($result);?>

			<style type="text/css">
				.rowone td{background-color:#FFFFFF;vertical-align:top;padding:10px;}
				.rowtwo td{background-color:#E9E9E9;vertical-align:top;padding:10px;}
			</style>
			<center>
				<form method='post'>

			<?echo "<input type='hidden' name='conflictorder' value='{$row['fldID']}'>\n";

			foreach ($_REQUEST as $key => $value):
				echo "<input type='hidden' name='$key' value='$value'>\n";
			endforeach;?>

			<table>
				<tr class='rowone'>
					<td colspan='3'>There is a conflict in patient info!<br/><?//=$sql?></td>
				</tr>
				<tr class='rowtwo'>
					<td></td>
					<td>Existing Record <?=$row['fldID']?></td>
					<td>New Record</td></tr>
				<tr class='rowone'>
					<td>Patient ID</td>
					<td><?=$row['fldPatientID']?></td>
					<td>
						<input type='text' name='patientid1' value="<?=strtoupper($_REQUEST['patientid'])?>"/>
					</td>
				</tr>
				<tr class='rowone'>
					<td>Patient SSN</td>
					<td><?=$row['fldPatientSSN']?></td>
					<td>
						<input type='text' name='patientssn1' value="<?=strtoupper($_REQUEST['patientssn'])?>"/>
					</td>
				</tr>
				<tr class='rowtwo'>
					<td>First Name</td>
					<td><?=$row['fldFirstName']?></td>
					<td>
						<input type='text' name='firstname1' value="<?=strtoupper($_REQUEST['firstname'])?>"/>
					</td>
				</tr>
				<tr class='rowone'>
					<td>Last Name</td>
					<td><?=$row['fldLastName']?></td>
					<td>
						<input type='text' name='lastname1' value="<?=strtoupper($_REQUEST['lastname'])?>">
					</td>
				</tr>
				<tr class='rowtwo'>
					<td colspan='3'>
						<input type='submit' name='action' value='Continue Anyway'>
						<input type='submit' name='action' value='Save'>
					</td>
				</tr>
			</table>
		</form></center><?//this finishes the tags from index.php... FIXME?>
		<?exit(0);

		endif;
	endif;
}
*/

	$user				= $_SESSION['user'];
	$sql_values_fetch	= mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));

	$fac				= $sql_values_fetch['fldFacility'];
	$uid				= $sql_values_fetch['fldID'];
	$loginstate			= $sql_values_fetch['fldMainState'];
	$loginrole			= $sql_values_fetch['fldRole'];

	$facy				= (isset($_REQUEST['facility'])?$_REQUEST['facility']:'');

	$facstate			= mysql_fetch_row(mysql_query("select * from tblfacility where fldFacilityName='$facy'"));

	$host				= "mail.mdipacs.net";
	$username			= "dpotter";
	$password			= "brasil06";

	$loadrecord		= (isset($_REQUEST['load'])?$_REQUEST['load']:'');

	$type				= (isset($_REQUEST['order_type'])?$_REQUEST['order_type']:'');
	//get order record if edit
	if(!empty($_REQUEST['id']))
	{
		$ordRes = getDBArray('tblorderdetails',"where fldid = {$_REQUEST['id']}");
		//var_dump($ordRes);
		$sql_values_fetch	= ($ordRes['error_code'] == 0)?$ordRes['results']:die('error retrieving order');
		$type = (isset($_GET['order_type']) && !empty($_GET['order_type']))?$_GET['order_type']:$sql_values_fetch['fldOrderType'];

		//die(var_dump($sql_values_fetch));
	}

	$typesqlarray		= array("","Nursing Home", "Correctional Facility", "Home Health", "Physicians Lab");

	//die(print_r("Type is -> $type",1));

	if ($type < 1 ) $type = 0;

	$eventtype		= 'Add';

	//die($type);
	//die($submit);

	if($submit !== ''):
		function formatdate($sDate1)
		{
			$sDate = split('-', $sDate1);
			$sDate1 = $sDate[2].'-'.$sDate[0].'-'.$sDate[1];
			return $sDate1;
		}

		function phone_number($sPhone)
		{
			$sPhone = ereg_replace("[^0-9]",'',$sPhone);
			if(strlen($sPhone) != 10) return(False);
			$sArea = substr($sPhone,0,3);
			$sPrefix = substr($sPhone,3,3);
			$sNumber = substr($sPhone,6,4);
			$sPhone = "($sArea)$sPrefix-$sNumber";
			return($sPhone);
		}

		$newdob		= formatdate($_REQUEST['dob']);

		$cretime	= date("Y-m-d",time());

		$orddate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate1']) . ' ' . $_REQUEST['schdate2']));

		$schdate = ($type == 4)
			?date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate12']).' '.$_REQUEST['fldSOtime']))
			:date('Y-m-d',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));

		$cddate = formatdate($_REQUEST['cddate']);
		$ordphynidb = 0;
		$ordphy = $_REQUEST['orderingphysicians'];

		if($ordphy === "new"):
			$ordphy = $_REQUEST['phynew'];
			$ordphynidb = 1;
		endif;

		$dispatched = 0;
		$facy = $_REQUEST['facility'];

		$adisp = $sql_values_fetch_fac['fldAutoDispatch'];
		if($adisp==1):
			$sql_values_fetch_fac = mysql_fetch_array(mysql_query("select * from tblfacility where fldFacilityName='$facy'"));
			$technologist=$sql_values_fetch_fac['fldTechnologist'];
			$dispatched=1;
		endif;

		$billed = ($_REQUEST['billfacility'])?'facility':'insurance';

		if($_REQUEST['testpriority1']) $testpriority = '1';

		if($_REQUEST['testpriority2']) $_REQUEST['stat'] = '1';

		if($_REQUEST['fieldrepeat'] != 1 ):
			$_REQUEST['repeatdays'] = '';
			$_REQUEST['repeattimes'] = '';
		endif;

		if($_REQUEST['station'] === 'Select') $_REQUEST['station'] = '';

		if($_REQUEST['facility'] === 'Select') $_REQUEST['facility'] = '';

		if($_REQUEST['sex'] === 'Select') $_REQUEST['sex'] = '';

		if($_REQUEST['fldPrivateAddressState'] === 'Select a State') $_REQUEST['fldPrivateAddressState'] = '';

		$fieldschedday;

		if($_REQUEST['fldID'] !== '' && $_REQUEST['neworder'] != 1):
			$startsql = "UPDATE tblorderdetails SET modified_by = '".$_SESSION['user']."',modified_date=NOW(),";
			$eventtype = 'Edit';
		else:
			$startsql = "INSERT INTO tblorderdetails SET fldDispatched='".strtoupper(strip_tags(addslashes($dispatched)))."', created_date = '".date('Y-m-d H:i:s')."', fldCreDate='".strtoupper(strip_tags(addslashes($cretime)))."',created_by = '".$_SESSION['user']."',";
		endif;

		$setsql .= "fldPatientID='".strtoupper(strip_tags(addslashes(getPID())))."',
					fldDate='".strtoupper(strip_tags(addslashes($orddate)))."',
					fldPatientSSN='".strtoupper(strip_tags(addslashes($_REQUEST['patientssn'])))."',
					fldFirstName='".strtoupper(strip_tags(addslashes($_REQUEST['firstname'])))."',
					fldLastName='".strtoupper(strip_tags(addslashes($_REQUEST['lastname'])))."',
					fldMiddleName='".strtoupper(strip_tags(addslashes($_REQUEST['middlename'])))."',
					fldSurName='".strtoupper(strip_tags(addslashes($_REQUEST['surname'])))."',
					fldDOB='".strtoupper(strip_tags(addslashes($newdob)))."',
					fldGender='".(strip_tags(addslashes($_REQUEST['sex'])))."',
					fldInsurance='".(strip_tags(addslashes($_REQUEST['insurance'])))."',
					fldMedicareNumber='".strtoupper(strip_tags(addslashes($_REQUEST['medicare'])))."',
					fldMedicaidNumber='".strtoupper(strip_tags(addslashes($_REQUEST['medicaid'])))."',
					fldState='".(strip_tags(addslashes($_REQUEST['state'])))."',
					fldInsuranceCompanyName='".strtoupper(strip_tags(addslashes($_REQUEST['insurancecompanyname'])))."',
					fldHmoContract='".strtoupper(strip_tags(addslashes($_REQUEST['hmo_contract'])))."',
					fldPolicy='".strtoupper(strip_tags(addslashes($_REQUEST['policy'])))."',
					fldGroup='".strtoupper(strip_tags(addslashes($_REQUEST['group'])))."',
					fldResponsiblePerson='".strtoupper(strip_tags(addslashes($_REQUEST['responsibleperson'])))."',
					fldRelationship='".(strip_tags(addslashes($_REQUEST['relationship'])))."',
					fldFacilityName='".(strip_tags(addslashes($_REQUEST['facility'])))."',
					fldFacPhone='".(phone_number($_REQUEST['faccontact']))."',
					fldFacFax='".(phone_number($_REQUEST['faccontactfax']))."',
					fldPrivateAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress1'])))."',
					fldPrivateAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress2'])))."',
					fldPrivateAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['privatecity'])))."',
					fldPrivateAddressState='".(strip_tags(addslashes($_REQUEST['privatestate'])))."',
					fldPrivateAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['privatezipcode'])))."',
					fldPrivatePhoneNumber='".strtoupper(phone_number($_REQUEST['privatephone']))."',
					fldPrivateResidenceNumber='".strtoupper(strip_tags(addslashes($_REQUEST['fldprivateresidencenumber'])))."',
					fldHomeAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress1'])))."',
					fldHomeAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress2'])))."',
					fldHomeAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['homecity'])))."',
					fldHomeAddressState='".(strip_tags(addslashes($_REQUEST['homestate'])))."',
					fldHomeAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['homezipcode'])))."',
					fldHomePhoneNumber='".strtoupper(strip_tags(addslashes($_REQUEST['homephone'])))."',
					fldStat='".(!empty($_REQUEST['stat'])?1:0)."',
					fldOrderingPhysicians='".(strip_tags(addslashes($ordphy)))."',
					fldRequestedBy='".strtoupper(strip_tags(addslashes($_REQUEST['requester'])))."',
					fldProcedure1='".(strip_tags(addslashes($_REQUEST['procedure1'])))."',
					fldProcedure2='".(strip_tags(addslashes($_REQUEST['procedure2'])))."',
					fldProcedure3='".(strip_tags(addslashes($_REQUEST['procedure3'])))."',
					fldProcedure4='".(strip_tags(addslashes($_REQUEST['procedure4'])))."',
					fldProcedure5='".(strip_tags(addslashes($_REQUEST['procedure5'])))."',
					fldProcedure6='".(strip_tags(addslashes($_REQUEST['procedure6'])))."',
					fldProcedure7='".(strip_tags(addslashes($_REQUEST['procedure7'])))."',
					fldProcedure8='".(strip_tags(addslashes($_REQUEST['procedure8'])))."',
					fldProcedure9='".(strip_tags(addslashes($_REQUEST['procedure9'])))."',
					fldProcedure10='".(strip_tags(addslashes($_REQUEST['procedure10'])))."',
					fldplr1='".(strip_tags(addslashes($_REQUEST['plr1'])))."',
					fldplr2='".(strip_tags(addslashes($_REQUEST['plr2'])))."',
					fldplr3='".(strip_tags(addslashes($_REQUEST['plr3'])))."',
					fldplr4='".(strip_tags(addslashes($_REQUEST['plr4'])))."',
					fldplr5='".(strip_tags(addslashes($_REQUEST['plr5'])))."',
					fldplr6='".(strip_tags(addslashes($_REQUEST['plr6'])))."',
					fldplr7='".(strip_tags(addslashes($_REQUEST['plr7'])))."',
					fldplr8='".(strip_tags(addslashes($_REQUEST['plr8'])))."',
					fldplr9='".(strip_tags(addslashes($_REQUEST['plr9'])))."',
					fldplr10='".(strip_tags(addslashes($_REQUEST['plr10'])))."',
					fldSymptom1='".(strip_tags(addslashes($_REQUEST['symptoms1'])))."',
					fldSymptom2='".(strip_tags(addslashes($_REQUEST['symptoms2'])))."',
					fldSymptom3='".(strip_tags(addslashes($_REQUEST['symptoms3'])))."',
					fldSymptom4='".(strip_tags(addslashes($_REQUEST['symptoms4'])))."',
					fldSymptom5='".(strip_tags(addslashes($_REQUEST['symptoms5'])))."',
					fldSymptom6='".(strip_tags(addslashes($_REQUEST['symptoms6'])))."',
					fldSymptom7='".(strip_tags(addslashes($_REQUEST['symptoms7'])))."',
					fldSymptom8='".(strip_tags(addslashes($_REQUEST['symptoms8'])))."',
					fldSymptom9='".(strip_tags(addslashes($_REQUEST['symptoms9'])))."',
					fldSymptom10='".(strip_tags(addslashes($_REQUEST['symptoms10'])))."',
					fldacsno1='".date('Ymd-His').'1'."',
					fldacsno2='".date('Ymd-His').'2'."',
					fldacsno3='".date('Ymd-His').'3'."',
					fldacsno4='".date('Ymd-His').'4'."',
					fldacsno5='".date('Ymd-His').'5'."',
					fldacsno6='".date('Ymd-His').'6'."',
					fldacsno7='".date('Ymd-His').'7'."',
					fldacsno8='".date('Ymd-His').'8'."',
					fldacsno9='".date('Ymd-His').'9'."',
					fldacsno10='".date('Ymd-His').'10'."',
					fldPatientroom='".strtoupper(strip_tags(addslashes($_REQUEST['patientroom'])))."',
					fldAfterhours='".strtoupper(strip_tags(addslashes($_REQUEST['afterhours'])))."',
					fldHistory='".strtoupper(strip_tags(addslashes($_REQUEST['history'])))."',
					fldCDRequested='".(strip_tags(addslashes($_REQUEST['cdrequested'])))."',
					fldSymptoms='".strtoupper(strip_tags(addslashes($_REQUEST['symptoms'])))."',
					fldCDAddr='".strtoupper(strip_tags(addslashes($_REQUEST['cdaddr'])))."',
					fldCDDate='".strtoupper(strip_tags(addslashes($cddate)))."',
					fldUserName='".strtoupper(strip_tags(addslashes($_SESSION['user'])))."',
					fldpps='".strtoupper(strip_tags(addslashes($_REQUEST['pps'])))."',
					fldOrderingPhysiciansPhone ='".strtoupper(strip_tags(addslashes($_REQUEST['ordering_dr_phone'])))."',
					fldOrderingPhysiciansFax ='".strtoupper(strip_tags(addslashes($_REQUEST['ordering_dr_fax'])))."',
					fldPrivateHousingNo ='".strtoupper(strip_tags(addslashes($_REQUEST['privatehousingno'])))."',
					fldReportFax ='".strtoupper(strip_tags(addslashes($_REQUEST['reportfax'])))."',
					fldBackupPhone ='".strtoupper(strip_tags(addslashes($_REQUEST['backupphone'])))."',
					fldBackupFax ='".strtoupper(strip_tags(addslashes($_REQUEST['backupfax'])))."',
					fldStation ='".strtoupper(strip_tags(addslashes($_REQUEST['station'])))."',
					fldDiagnosisReuired1 ='".strtoupper(strip_tags(addslashes($_REQUEST['diagnosisrequired1'])))."',
					fldDiagnosisReuired2 ='".strtoupper(strip_tags(addslashes($_REQUEST['diagnosisrequired2'])))."',
					fldDiagnosisReuired3 ='".strtoupper(strip_tags(addslashes($_REQUEST['diagnosisrequired3'])))."',
					fldLocFacName ='".strtoupper(strip_tags(addslashes($_REQUEST['locfacility'])))."',
					fldlabtype ='".$_REQUEST['fldlabtype']."',
					fldTestPriority ='".$testpriority."',
					fldNotes ='".strip_tags(addslashes($_REQUEST['notes']))."',
					fldbilled ='".$billed."',
					fldOPNotinDB ='".$ordphynidb."',
					fldHospice ='".$_REQUEST['hospice']."',
					fldOrderType ='".$type."'";

		$repeatsql = "fldRepeat ='".$_REQUEST['fieldrepeat']."', fldSchDate='".strtoupper(strip_tags(addslashes($schdate)))."', fldSchTime = '".$_POST['fldSchTime']."', fldRepeatDays ='".$_REQUEST['repeatdays']."', fldRepeatTimes ='".$_REQUEST['repeattimes']."'";

		$insertsql = ($_REQUEST['fldID'] && $_REQUEST['neworder'] != 1)?"$startsql $setsql,$repeatsql WHERE fldID='".$_REQUEST['fldID']."'":"$startsql $setsql,$repeatsql";

		$check_result = mysql_query("select * from tblorderdetails where fldID='".$_REQUEST['fldID']."'");
		$check_values = mysql_fetch_array( $check_result );

		//die(print_r($insertsql, true));
		$sql_insert = mysql_query($insertsql) or die(mysql_error()." $insertsql");

		if($_REQUEST['fldID']):
			$id = $_REQUEST['fldID'];
		else:
			$id		= mysql_insert_id();
			$txtid	= $id;
		endif;

		if($sql_insert):
			//insert into icd table for no apparent reason
			$sqlinsertquery = "insert into tblicdcodes set fldOrderid='".(strip_tags(addslashes($id)))."'";
			$sql_insert_icd = mysql_query($sqlinsertquery) or die (mysql_error().$sqlinsertquery);

			//create unsigned pdf of order
			if($sql_insert_icd)
			{
				include "pdf_neworder.php";
				echo "PDF OK<br/>";
			}

			//if all that works create MWL entry
			if(createMWL($id) === FALSE):
				echo "<br/>MWL Fail<br/>";
				die("Error: MWL file not created");
			endif;
			echo "MWL OK<br/>";
		endif;

		$sql = "INSERT INTO tblhistory(fldID,fldEventType,flduser) values ('$id','$eventtype','".$_SESSION['user']."');";
		mysql_query($sql) or die(mysql_error()." on query:<br/> $sql");
		echo "History OK";
	endif;

	if($id !== ""):
		if($_REQUEST['neworder'] == 1 && $submit === ''):
			if($type === '3'):
				$address = ",fldPatientroom,fldPrivateAddressLine1,fldPrivateAddressLine2,fldPrivateAddressCity,fldPrivateAddressState,fldPrivateAddressZip,fldPrivateResidenceNumber";
			endif;

			$sql = "select fldFirstName,fldLastName,fldMiddleName,fldSurName,fldDOB,fldGender,fldPatientSSN,fldPatientID,fldSurName,fldGender,fldFacilityName,fldLocFacName,fldStation,fldOrderingPhysicians,fldInsurance,fldMedicareNumber,fldMedicaidNumber,fldInsuranceCompanyName,fldHmoContract,fldPolicy,fldGroup,fldResponsiblePerson,fldRelationship,fldPrivatePhoneNumber,fldbilled,fldpps,fldState $address FROM tblorderdetails where fldID = '$id'";
			$id = '';
		else: $sql = "select * from tblorderdetails where fldID = '$id'";
		endif;

		//echo "<br/> $sql";

		$result = mysql_query($sql) or die (mysql_error()." $sql");

		$sql_values_fetch = mysql_fetch_array($result);

		$type =($sql_values_fetch['fldOrderType'] > 0 && $type < 1 )?$sql_values_fetch['fldOrderType']:$type;
	endif;


	//if($loadrecord == 1) $type = 0;

	# NEW SEARCH FEATURE

	if(isset($_REQUEST['ssn']) && empty($sql_values_fetch['fldPatientSSN'])):
		$sql_values_fetch['fldPatientSSN'] = $_REQUEST['ssn'];
	elseif(isset($_REQUEST['fname']) && empty($sql_values_fetch['fldFirstName'])):
		$sql_values_fetch['fldFirstName'] = $_REQUEST['fname'];
	elseif(isset($_REQUEST['lname']) && empty($sql_values_fetch['fldLastName'])):
		$sql_values_fetch['fldLastName'] = $_REQUEST['lname'];
	elseif(isset($_REQUEST['fclty']) && empty($sql_values_fetch['fldFacilityName'])):
		$sql_values_fetch['fldFacilityName'] = $_REQUEST['fclty'];
	elseif(isset($_REQUEST['flddate']) && empty($sql_values_fetch['fldDate'])):
		$sql_values_fetch['fldDate'] = $_REQUEST['flddate'];
	elseif(isset($_REQUEST['exmdate']) && empty($sql_values_fetch['fldSchDate'])):
		$sql_values_fetch['fldSchDate'] = $_REQUEST['exmdate'];
	endif;

	//echo "<br/>savennew is: <br/>".$_REQUEST['savennew']."<br/>savecnew is: <br/>".$_REQUEST['savecnew'];

if(!empty($_REQUEST['savennew']))://if add and create new order for same ORDER TYPE
	header("Location: index.php?pg=21&order_type=$type");
	exit;
elseif(!empty($_REQUEST['savecnew']))://if add and create new order for PATIENT
	header("Location: index.php?pg=21&id=$id&pid=".getPID()."&neworder=1&order_type=$type");
	exit;
else://new BLANK order
?>

<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="facility.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">
	function checkUserRole()
	{
		var stat = document.getElementsByName('stat')[0];
		if (stat && stat.checked)
			<?=($_SESSION['role'] === 'facilityuser')?'alert("your text here"); return false;':'';?>

		return true;
	}

	function search_prompt()
	{
		var retVal="";
		retVal = showModalDialog('searchpop.php?order_type='+ "<?=$type?>");
		if(retVal !== undefined)
		{
			location.replace(retVal);
		}
		else
		{
			alert("There was an error getting patient data. Please try again or call support");
		}
	}

	function newpt()
	{
		location.replace('?pg=42');
	}

	function selectOrderType(type)
	{
		$location = window.location.href.replace(/&load\=1/,'&neworder=1');
		window.location.href = $location.replace(/#$/,'')+'&order_type='+type;
	}


	function cdenable()
	{
		if (document.getElementById('cdrequested').value != 0){
			document.getElementById('cdaddrlab').style.display = '';
			document.getElementById('cddatelab').style.display = '';
			document.getElementById('cdaddr').style.display = '';
			document.getElementById('cddate').style.display = '';
		}
		else
		{
			document.getElementById('cddatelab').style.display = 'none';
			document.getElementById('cdaddrlab').style.display = 'none';
			document.getElementById('cdaddr').style.display = 'none';
			document.getElementById('cddate').style.display = 'none';
		}
	}
	function phyenable()
	{
		if (document.forms[0].orderingphysicians.value == "new")
		{
			document.forms[0].phynew.style.display = "";
		}
		else
		{
			document.forms[0].phynew.style.display = "none";
		};
	}

	function showPatientHistory()
	{
		if (!document.getElementById('lastname').value)
		{
			alert("Please enter Last Name!");
			return false;
		}

		if (!document.getElementById('patientid').value)
		{
			alert("Please enter Patient ID!");
			return false;
		}

		showModalDialog("patienthistory.php?lastname="+document.getElementById('lastname').value+"&patientmr="+document.getElementById('patientid').value);
		//window.open("patienthistory.php?lastname="+document.getElementById('lastname').value+"&patientmr="+document.getElementById('patientid').value,'history')
	}

	$.validator.addMethod
	(
		"formatSSN",
		function (value, ssnobj)
		{
			ssnobj.value = ssnobj.replace(/\w/,'');
			if(ssnobj.value.length == 11)
			{
				var re = /(\d\d\d)(\d\d)(\d\d\d\d)/;

				if(ssnobj.value.match(re))
				{
					ssnobj.value = RegExp.$1+"-"+RegExp.$2+"-"+RegExp.$3;
				}

				return true;
			}
		},"Invalid SSN"
	);

	$.validator.addMethod(
	  "checkSymptom",
	  function(value, element) {

		if (<?=$type?> == 4) return true;
		var name = element.name.replace('symptoms','');
		var procedure = document.getElementById('procedure'+name);

		if(value != ''){

			if(procedure.selectedIndex == 0 ){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			if(procedure.selectedIndex == 0 ){
				return true;
			}
			else{
				return false;
			}
		}
	  },
	  "<font color='red'>**</font>"
  );

	$.validator.addMethod(
	  "checkplr",
	  function(value, element) {
		if (<?=$type?> == 4) return true;
		var name = element.name.replace('plr','');
		var procedure = document.getElementById('procedure'+name);

		if(value != ''){

			if(procedure.selectedIndex == 0 ){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			if(procedure.selectedIndex == 0 ){
				return true;
			}
			else{
				return false;
			}
		}
	  },
	  "<font color='red'>**</font>"
  );

	$(document).ready(function() {
	  $("#myform").validate({
		rules: {
			patientssn: {
				formatSSN:true
			},
			symptoms2: {
			  checkSymptom:true
			},
			symptoms3: {
			  checkSymptom:true
			},
			symptoms4: {
			  checkSymptom:true
			},
			symptoms5: {
			  checkSymptom:true
			},
			symptoms6: {
			  checkSymptom:true
			},
			symptoms7: {
			  checkSymptom:true
			},
			symptoms8: {
			  checkSymptom:true
			},
			symptoms9: {
			  checkSymptom:true
			},
			symptoms10: {
			  checkSymptom:true
			},
			plr1: {
			  checkplr: true
			},
			plr2: {
			  checkplr: true
			},
			plr3: {
			  checkplr: true
			},
			plr4: {
			  checkplr: true
			},
			plr5: {
			  checkplr: true
			},
			plr6: {
			  checkplr: true
			},
			plr7: {
			  checkplr: true
			},
			plr8: {
			  checkplr: true
			},
			plr9: {
			  checkplr: true
			},
			plr10: {
			  checkplr: true
			}
		}
	});

	$("#fldSchTime").mask("99:99");
	$("#schdate2").mask("99:99");
	$("#patientssn").mask("999-99-9999");
	$("#dob").mask("99-99-9999");
	$("[id^='schdate1']").mask("99-99-9999");


  	$(".datepicker").datepicker({
  		changeMonth: true,
  		changeYear: true,
  		dateFormat: "mm-dd-yy",
  		autoSize: true,
  		yearRange: "-01:+01"
  	});

  	$(".dobdatepicker").datepicker({
  		changeMonth: true,
  		changeYear: true,
  		dateFormat: "mm-dd-yy",
  		autoSize: true,
  		yearRange: "1850:2050"
  	});

  	$(".datepickerSO").datepicker({
  		changeMonth: true,
  		changeYear: true,
  		dateFormat: "mm-dd-yy",
  		autoSize: true,
  		yearRange: "-01:+01",
  		altField: "#schdate12"
  	});

  	$(".timepicker").timepicker({
  		timeFormat: "HH:mm"
  	});

<?//Created datetime
if(isset($sql_values_fetch['fldDate']))://if date exam create has a value
	list($y,$M,$d,$h,$m,$s) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldDate']);//split flddate into seperate variables?>
	var timeOrdered = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>, <?=$s?>);
	$("#schdate1").datepicker('setDate',timeOrdered);
	$("#schdate2").timepicker('setTime',timeOrdered);
<?else://use current date/time from user?>
	var timeOrdered = new Date();
	$("#schdate1").datepicker('setDate',timeOrdered);
	$("#schdate2").timepicker('setTime',timeOrdered);
<?endif;

//Scheduled date
if(isset($sql_values_fetch['fldSchDate']))://if schdate has a value
	if(!empty($sql_values_fetch['fldSchTime']) && $sql_values_fetch['fldSchTime'] != 'N/A')://and schtime has a value
		list($y,$M,$d,$h,$m) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldSchDate'].' '.$sql_values_fetch['fldSchTime']);//concat schdate and schtime and split into variables?>
		var examDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>);

		$("#schdate12").datepicker('setDate',examDate);
		$("#fldSchTime").timepicker('setTime',examDate);
	<?else://schtime has no value (ASAP order or error either way give general time for now)
		list($y,$M,$d,$h,$m) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldSchDate']);?>
		var examDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>);

		$("#schdate12").datepicker('setDate',examDate);
		$("#fldSchTime").timepicker('setTime',new Date());
	<?endif;?>
<?else://no scheduled date set -- use current date time from user?>
	var examDate = new Date();

	$("#schdate12").datepicker('setDate',examDate);
	$("#fldSchTime").timepicker('setTime',examDate);
<?endif;?>

	});//end doc.ready
</script>
<form id="myform" action="" method="post" onsubmit="checkUserRole()">
	<input type='hidden' name='order_type' value='<?=$type?>'/>
	<input type='hidden' name='fldID' value='<?=$id?>'/>
<?if($type < 1):
	//die("Type is $type");?>
	<form id='select_type'>
		<table style="padding: 20px; background: url(main.png); width: 1050px">
			<tr>
				<td class="dis">Please select the order type</td>
			</tr>
			<tr style="text-align: center;">
				<td>
					<input type='radio' id="order_type1" name="order_type" value="1" onClick="selectOrderType('1')"/>
					<label for="order_type1"><strong>Nursing Home Order</strong></label>
				</td>
				<td>
					<input type='radio' id="order_type2" name='order_type' value="2" onClick="selectOrderType('2')"/>
					<label for="order_type2"><strong>Correctional Facility</strong></label>
				</td>
				<td>
					<input type='radio' id="order_type3" name='order_type' value="3" onClick="selectOrderType('3')"/>
					<label for="order_type3"><strong>Home Health Orders</strong></label>
				</td>
				<td>
					<!--<input type='radio' id="order_type4" name='order_type' value="4" onClick="selectOrderType('4')">
					<label for="order_type4"><strong>Lab Orders</strong></label>-->
				</td>
			</tr>
		</table>
	</form>
	<?exit(0);
else:
	$typearray = array("","Nursing Home Order","Correctional Facility","Home Health Orders","Lab Orders");?>
	<table style="width:1050; border:0; align:center; cellpadding:0; cellspacing:0; background:url('main.png'); padding: 10px;">
		<tr>
			<td colspan='8' style='text-align: right; font-weight: bold; font-size: 1.2em; text-decoration: underline;'>
				<font face='arial' size='2em'><?=strtoupper($typearray[$type])?></font>
			</td>
		</tr>
		<!-- Timing of order -->
		<tr>
			<td colspan="2"><span class="lab">Date/Time Order Placed</span></td>
			<td colspan="2"><span class="lab">Date/Time Exam Scheduled </span></td>
			<td><span class="lab" style="color: red;">STAT</span></td>
			<td><span class="lab" style="color: red;">Hospice</span></td>
		</tr>
		<tr>
			<td colspan="2">
				<input id="schdate1" name="schdate1" class="datepicker required" type="text" value="<?=(($sql_values_fetch['created_date'] != '')?date('m-d-Y' , strtotime($sql_values_fetch['created_date'])):'')?>"/>
				<input name="schdate2" type="text" id="schdate2" value="" class="timepicker required"/>
			</td>
			<td colspan="2">
				<input id="schdate12" name="schdate12" type="text" class="datepicker required" value="<?=($sql_values_fetch['fldSchDate'] != ''?date('m-d-Y' , strtotime($sql_values_fetch['fldSchDate'])):'')?>"/>
				<input name="fldSchTime" type="text" id="fldSchTime" class="timepicker required" value=""/>
			</td>
			<td><input name="stat" type="checkbox" class="chk" <?=($sql_values_fetch['fldStat'] == 1)?'checked="checked"':''?>/></td>
			<td>
				<select id="hospice" name="hospice">
					<?php
						$hospiceOption = array(
							'1'	=> 'Yes',
							'0'	=> 'No'
						);
						foreach($hospiceOption as $value => $text)
						{
							if($sql_values_fetch['fldHospice'] == $value)
							{
								echo "<option value='$value' selected='selected'>$text</option>";
							}
							else
							{
								echo "<option value='$value'>$text</option>";
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td colspan='8'>&nbsp;<hr/></td></tr>
		<!-- Patient Demographics -->
		<tr>
			<td colspan="2">
				<input name="retrive" type="button" onclick="search_prompt()" value="Search" /> <!--<input name="new" type="submit" id="new" value="New" />-->
				<input name="history" type="button" id="new" value="History" onClick="showPatientHistory();" />
			</td>
		</tr>
		<tr>
			<td><span class="lab">Last name</span></td>
			<td><span class="lab">First name</span></td>
			<td><span class="lab">Middle name</span></td>
			<td><span class="lab">Suffix (Jr, Sr, II)</span></td>
		</tr>
		<tr>
			<td><input name="lastname" id="lastname" type="text" value="<?=$sql_values_fetch['fldLastName']?>" class="required"/></td>
			<td><input name="firstname" type="text" value="<?=$sql_values_fetch['fldFirstName']?>" class="required"/></td>
			<td><input name="middlename" type="text" value="<?=$sql_values_fetch['fldMiddleName']?>" /></td>
			<td><input name="surname" type="text" value="<?=$sql_values_fetch['fldSurName']?>" /></td>
		</tr>
		<tr>
			<td><span class="lab"><?=($type == 2)?"Inmate ID#: ":"Patient MR#: ";?></span></td>
			<td><span class="lab">DOB (MM-DD-YYYY)</span></td>
			<td><span class="lab">Patient SSN</span></td>
			<td><span class="lab">Sex</span></td>
		</tr>
		<tr>
			<td><input name="patientid" id="patientid" type="text" value="<?=getPID()?>"/></td>
			<td><input id="dob" name="dob" type="text" class="dobdatepicker" value="<?=($sql_values_fetch['fldDOB']!=''?date('m-d-Y' , strtotime($sql_values_fetch['fldDOB'])):'')?>"/></td>
			<td><input id="patientssn" name="patientssn" type="text" maxlength='11' value="<?=$sql_values_fetch['fldPatientSSN']?>" /></td>
			<td>
				<select name="sex" class="required">
					<option value="" <?=($sql_values_fetch['fldGender'] === '')?'selected="selected"':''?>>Select</option>
					<option value="female" <?=($sql_values_fetch['fldGender'] === 'female')?'selected="selected"':''?>>FEMALE</option>
					<option value="male" <?=($sql_values_fetch['fldGender'] === 'male')?'selected="selected"':''?>>MALE</option>
				</select>
			</td>
		</tr>
		<tr><td colspan='8'>&nbsp;<hr/></td></tr>
		<!-- Facility/Location Information-->
		<!-- All orders use same general ordering facility info -->
		<tr>
			<td colspan="2"><span class="lab">Ordering Facility Name</span></td>
			<td><span class="lab">Contact Person</span></td>
		</tr>
		<tr>
			<td colspan="2">
				<select name="facility" id="facility" onchange="showUser(this.value);showStations(this.value);" class="required">
					<option selected="selected" value="">Select</option>
			<?if($_SESSION['role'] === 'facilityuser' || $_SESSION['role'] === 'orderingphysician'):
				$sql="select fldFacilityName FROM tblfacility JOIN tbluserfacdetails on (fldfacility = fldfacilityname and fldUserID = '$uid') AND fldFacilityType = '".$typesqlarray[$type]."' ORDER BY fldFacilityName";
			/* elseif($_SESSION['role'] === 'admin'):
				$sql="SELECT * FROM tblfacility WHERE fldFacilityDisabled != '1' AND fldFacilityType = '".$typesqlarray[$type]."' ORDER BY fldFacilityName"; */
			else:
				$sql="SELECT * FROM tblfacility WHERE fldFacilityDisabled != '1' AND fldFacilityType = '".$typesqlarray[$type]."' ORDER BY fldFacilityName";
			endif;

			#echo $sql;
			$result = mysql_query($sql);

			while($row = mysql_fetch_array($result)):
				$selected = '';
				if(strtoupper($sql_values_fetch['fldFacilityName']) === strtoupper($row['fldFacilityName'])):
					$selectedFacId = $row['fldID'];
					$selected = 'selected="selected"';
				endif;?>
					<option value="<?=$row['fldFacilityName']?>" <?=$selected?>><?=strtoupper($row['fldFacilityName'])?></option>
			<?endwhile;?>
				</select>
			</td>
			<td><input name="requester" type="text" value="<?=$sql_values_fetch['fldRequestedBy']?>" class="required"/></td>
		</tr>
		<tr>
			<td colspan="2"><span class="lab">Phone</span></td>
			<td><span class="lab">Fax</span></td>
		</tr>
		<tr>
			<td colspan="2"><input name='faccontact' id='faccontact' type='text' value='<?=$sql_values_fetch['fldFacPhone']?>'/></td>
			<td><input name='faccontactfax' id='faccontactfax' type='text' value='<?=$sql_values_fetch['fldFacFax']?>'/></td>
		</tr>
	<?if($type == 1):?>
		<tr><td colspan="5"><span class="lab" ><label for="station">Station:</label></span></tr>
		<tr>
			<td colspan="5">
				<select name="station" id="station" onchange='showStationData(this.value);'>
					<option value=''>Select</option>
				<?if(isset($sql_values_fetch['fldFacilityName'])):
					$sql = "SELECT fldID FROM tblfacility WHERE fldFacilityName = '".$sql_values_fetch['fldFacilityName']."'";
					list($selectedFacId) = mysql_fetch_array(mysql_query($sql));
				endif;

				$sql = "SELECT * FROM tblstations WHERE facId='$selectedFacId'";

				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):?>
					<option value='<?=strtoupper($row['StationName'])?>' <?=($row['StationName'] === $sql_values_fetch['fldStation'])?'selected="selected"':'';?>>
						<?=strtoupper($row['StationName'])?>
					</option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
	<?endif;
	if($type==3 || $type==4):?>
		<tr>
			<td><span class="lab">Location/Facility </span></td>
		</tr>
		<tr>
			<td colspan="3">
				<select name="locfacility" id="locfacility" class="required" onchange="showAddress(this.value);showStations(this.value);">
					<option selected="selected" value="">Select</option>
				<?if($_SESSION['role'] === 'facilityuser' || $_SESSION['role'] === 'orderingphysician'):
					 $sql="select fldFacility AS fldFacilityName FROM tbluserfacdetails where fldUserID = '$uid'";
				//elseif($_SESSION['role'] === 'admin'): $sql="SELECT * FROM tblfacility WHERE fldFacilityDisabled != '1' ORDER BY fldFacilityName";
				else: $sql="SELECT * FROM tblfacility WHERE fldFacilityDisabled != '1' ORDER BY fldFacilityName";
				endif;

				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):
					$selected = '';
					if(strtoupper($sql_values_fetch['fldLocFacName']) === strtoupper($row['fldFacilityName'])):
						$selectedFacId = $row['fldID'];
						$selected = 'selected="selected"';
					endif;?>
						<option value="<?=$row['fldFacilityName']?>" <?=$selected?>><?=strtoupper($row['fldFacilityName'])?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr><td colspan="5"><span class="lab" ><label for="station">Station:</label></span></tr>
		<tr>
			<td colspan="5">
				<select name="station" id="station" onchange='showStationData(this.value);'>
					<option value=''>Select</option>
				<?if(isset($sql_values_fetch['fldFacilityName'])):
					$sql = "SELECT fldID FROM tblfacility WHERE fldFacilityName = '".$sql_values_fetch['fldFacilityName']."'";
					list($selectedFacId) = mysql_fetch_array(mysql_query($sql));
				endif;

				$sql = "SELECT * FROM tblstations WHERE facId='$selectedFacId'";

				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):?>
					<option value='<?=strtoupper($row['StationName'])?>' <?=($row['StationName'] === $sql_values_fetch['fldStation'])?'selected="selected"':'';?>>
						<?=strtoupper($row['StationName'])?>
					</option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="lab">Phone #</span></td>
		</tr>
		<tr>
			<td><input name="fldprivateresidencenumber" type="text" value="<?=$sql_values_fetch['fldPrivateResidenceNumber']?>" /></td>
		</tr>
		<tr>
			<td><span class="lab">Address Line 1</span></td>
		</tr>
		<tr>
			<td><input name="privatestreetaddress1" id="privatestreetaddress1" type="text" value="<?=$sql_values_fetch['fldPrivateAddressLine1']?>" /></td>
		</tr>
		<tr>
			<td><span class="lab">Address Line 2 </span></td>
		</tr>
		<tr>
			<td><input name="privatestreetaddress2" id="privatestreetaddress2" type="text" value="<?=$sql_values_fetch['fldPrivateAddressLine2']?>" /></td>
		</tr>
		<tr>
			<td><span class="lab">City</span></td>
			<td><span class="lab">State </span></td>
			<td><span class="lab">Zip</span></td>
		</tr>
		<tr>
			<td><input name="privatecity" id="privatecity" type="text" value="<?=$sql_values_fetch['fldPrivateAddressCity']?>" /></td>
			<td>
				<select name="privatestate" size="1" id="privatestate">
					<option selected="selected" value="">Select a State</option>
				<?$statesql = "select * from tblstates";
				$stateres = mysql_query($statesql);
				while($state = mysql_fetch_assoc($stateres)):?>
					<option value="<?=$state['fldState']?>" <?=($sql_values_fetch['fldPrivateAddressState'] === $state['fldState'])?'selected="selected"':'';?>><?=$state['fldState'];?></option>
				<?endwhile;?>
				</select>
			</td>
			<td><input name="privatezipcode" id="privatezipcode" type="text" value="<?=$sql_values_fetch['fldPrivateAddressZip']?>" /></td>
		</tr>
	<?endif;?>
		<tr>
			<td><span class="lab">Room #:</span></td>
			<?=($type == 2)?'<td><span class="lab">Housing #:</span></td>':'';?>
		</tr>
		<tr>
			<td><input name="patientroom" type="text" value="<?=$sql_values_fetch['fldPatientroom']?>" class="required"/></td>
			<?=($type == 2)?'<td><input name="privatehousingno" type="text" value="'.$sql_values_fetch['fldPrivateHousingNo'].'" class="required"/></td>':''?>
		</tr>
	<?if($type==3):?>
		<tr><td><br/></td></tr>
		<tr>
			<td><span class="lab">Stairs</span></td>
			<td><span class="lab"># of stairs</span></td>
			<td><span class="lab">Pets</span></td>
		</tr>
		<tr>
			<td><input name="stairs" type="checkbox" <?=($sql_values_fetch['fldStairs'] == 1)?'checked="checked"':'';?>/></td>
			<td><input name="nstairs" type="text" value="<?=$sql_values_fetch['fldNstairs']?>"/></td>
			<td><input name="pets" type="checkbox" <?=($sql_values_fetch['fldPets'] == 1)?'checked="checked"':'';?>/></td>
		</tr>
		<tr>
			<td colspan="8"><span class="lab">Notes</span></td>
		</tr>
		<tr>
			<td colspan="8"><input name="symptoms" type="text" value="<?=$sql_values_fetch['fldSymptoms']?>" size="150" /></td>
		</tr>
	<?endif;

	if($type!=4):?>
		<tr><td colspan='8'>&nbsp;<hr/></td></tr>
		<?if(empty($sql_values_fetch['fldPatientID']) || empty($sql_values_fetch['fldProcedure1'])):?>
		<!-- Exam(s) procedure information -->
		<tr>
			<td>
				<span class="lab">Procedure Type:</span>
				<select class="required" onchange="showProcedure(this.value)">
					<option value=''>Select</option>
					<option value='ECHO'>ECHO</option>
					<option value='EKG'>EKG</option>
					<option value='XRAY'>X-Ray</option>
					<option value='US'>US</option>
				</select>
			</td>
			<td colspan="5" class="lab" style="color: red;">
				If you need to place an order for this patient
				for another procedure type, please complete this order and
				select the add &amp; create new order for same patient button at
				the bottom of the screen.
			</td>
		</tr>
		<?endif;?>
		<tr><td><br/></td></tr>
		<?for($i = 1; $i <= 10; $i++):?>
		<tr>
			<td><span class="lab">Procedure #<?=$i?></span></td>
			<td><span class="lab">
				<select name="procedure<?=$i?>" id="procedure<?=$i?>" <?=($i==1)?'class="required"':''?>>
						<option selected="selected" value="">Select</option>
				<?if($sql_values_fetch["fldProcedure$i"]):
					$sql="SELECT * FROM tblproceduremanagment WHERE fldModality !='LAB' order by fldDescription";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)):?>
						<option value="<?=$row['fldDescription']?>" <?=($sql_values_fetch["fldProcedure$i"] === $row['fldDescription'])?'selected="selected"':'';?>><?=strtoupper($row['fldDescription'])?></option>
					<?endwhile;
				endif;?>
				</select>
				<select name='plr<?=$i?>'>
					<option value=''>SELECT</option>
					<option value='NA' <?=($sql_values_fetch["fldplr$i"] === 'NA')?'selected="selected"':'';?>>N/A</option>
					<option value='LEFT' <?=($sql_values_fetch["fldplr$i"] === 'LEFT')?'selected="selected"':'';?>>LEFT</option>
					<option value='RIGHT' <?=($sql_values_fetch["fldplr$i"] === 'RIGHT')?'selected="selected"':'';?>>RIGHT</option>
					<option value='BILATERAL' <?=($sql_values_fetch["fldplr$i"] === 'BILATERAL')?'selected="selected"':'';?>>BILATERAL</option>
				</select>
				</span>
			</td>
			<td><span class="lab">Symptom </span></td>
			<td><span class="lab">
				<select name='symptoms<?=$i?>' <?=($i==1)?'class="required"':''?>>
					<option value="">Select</option>
				<?$sql="SELECT fldValue FROM tbllists WHERE fldListName='icd' order by fldValue";
				$result = mysql_query($sql);

				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>" <?=($sql_values_fetch["fldSymptom$i"] === $row['fldValue'])?'selected="selected"':'';?>><?=strtoupper($row['fldValue'])?></option>
				<?endwhile;?>
				</select>
				</span>
			</td>
		</tr>
		<?endfor;
	else:
		for($i = 1; $i < 10; $i++):?>
		<tr>
			<td><span class="lab">Test #<?=$i?></span></td>
			<td><span class="lab">
				<select name="procedure1" class="required">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tblproceduremanagment WHERE fldModality='LAB' order by fldDescription";
				$result = mysql_query($sql);

				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldDescription']?>" <?=($sql_values_fetch["fldProcedure$i"] === $row['fldDescription'])?'selected="selected"':''?>><?=strtoupper($row['fldDescription'])?></option>
				<?endwhile;?>
				</select>
				</span>
			</td>
		</tr>
		<?endfor;
	endif;?>
		<tr><td><br/></td></tr>
		<tr><td colspan="2"><span class="lab">Additional Patient Info and Special Instructions</span></td></tr>
		<tr><td colspan="8"><input name="symptoms" type="text" value="<?=$sql_values_fetch['fldSymptoms']?>" size="150" /></td></tr>
		<tr><td><span class="lab">History:</span></td></tr>
		<tr><td colspan="8"><input name="history" type="text" value="<?=$sql_values_fetch['fldHistory']?>" size="150" /></td></tr>
		<tr>
		<!-- Billing Section -->
		<tr><td colspan='8'>&nbsp;<hr/></td></tr>
		<tr>
			<td><span class="lab">Ordering Dr.</span></td>
			<td colspan="2">
				<?if($_SESSION['role'] === 'facilityuser'):
					$sql="SELECT * FROM tbluser where fldRole='orderingphysician' AND fldStatus='Enabled' order by fldRealName";
				elseif($_SESSION['role'] === 'admin'):
					$sql="SELECT * FROM tbluser where fldRole='orderingphysician' AND fldStatus='Enabled' order by fldRealName";
				else:
					$sql="SELECT * FROM tbluser where fldRole='orderingphysician' AND fldStatus='Enabled' order by fldRealName";
				endif;
				$result = mysql_query($sql);?>
				<select name="orderingphysicians" class="required" onChange="phyenable();showDr(this.value);">
					<option selected="selected" value="">Select</option>
				<?while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldRealName']?>" <?=(!isset($_GET['neworder']) && ($sql_values_fetch['fldOrderingPhysicians'] === $row['fldRealName'])?'selected="selected"':'');?>><?=strtoupper($row['fldRealName'])?></option>
				<?endwhile;

				$orderID = $_GET['id'];
				$sql = "SELECT * FROM tblorderdetails WHERE fldID = $orderID";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);

				//die(print_r($row,1));?>
					<option value="new" <?=($row['fldOPNotinDB'] === '1')?'selected="selected"':'';?>>Not In List</option>
				</select>
				<input name="phynew" id="phynew" <?=($row['fldOPNotinDB'] !== '1')?'style="display: none"':''?> value ="<?=(!isset($_GET['neworder']) && ($row['fldOPNotinDB'] == 1))?$row['fldOrderingPhysicians']:''?>"/>
			</td>
		</tr>
		<tr>
			<td><span class="lab">Phone</span></td>
			<td><input id="ordering_dr_phone" name="ordering_dr_phone" type="text" value="<?=$sql_values_fetch['fldOrderingPhysiciansPhone']?>"/></td>
			<td><span class="lab">Fax</span></td>
			<td><input id="ordering_dr_fax" name="ordering_dr_fax" type="text" value="<?=$sql_values_fetch['fldOrderingPhysiciansFax']?>"/></td>
		</tr>
	<?if($type==1):?>
		<tr><td><br/></td></tr>
		<tr>
			<td colspan="8">
				<span class="lab">
					Is this Resident currently a Medicare
					Skilled PPS, or Part A Patient?
					<br/><strong>OR</strong><br/>
					ARE YOU TAKING MEDICARE NOTES ON THIS PATIENT?
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<select name="pps">
					<option value="" <?=($sql_values_fetch['fldpps'] === '')?'selected="selected"':''?>>Select</option>
					<option value="yes" <?=($sql_values_fetch['fldpps'] === 'YES')?'selected="selected"':''?>>Yes</option>
					<option value="no" <?=($sql_values_fetch['fldpps'] === 'NO')?'selected="selected"':''?>>No</option>
				</select>
			</td>
		</tr>
	<?endif;
	if($type!=2):
		if($type==1 || $type==4):?>
		<tr><td><br/></td></tr>
		<tr>
			<td class="lab">Bill Insurance</td>
			<td><input type='checkbox' name='billinsurance' <?=($sql_values_fetch['fldbilled'] === 'insurance')?'checked="checked"':''?>></td>
			<td class="lab">Bill Facility</td>
			<td><input type='checkbox' name='billfacility' <?=($sql_values_fetch['fldbilled'] === 'facility')?'checked="checked"':''?>></td>
		</tr>
		<?endif;?>
		<tr>
			<td><span class="lab">Insurance Type</span></td>
			<td>
				<select name="insurance">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'insurance' order by fldValue";
				$result = mysql_query($sql);

				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>" <?=($sql_values_fetch['fldInsurance'] === $row['fldValue'])?'selected="selected"':''?>><?=strtoupper($row['fldValue'])?></option>
				<?endwhile;//TODO continue here?>
			</select></td>
		</tr>
		<tr>
			<td><span class="lab">Medicare #</span></td>
			<td><input name="medicare" type="text" value="<?=$sql_values_fetch['fldMedicareNumber']?>" /></td>
			<td><span class="lab">Medicaid #</span></td>
			<td><input name="medicaid" type="text" value="<?=$sql_values_fetch['fldMedicaidNumber']?>" /></td>
			<td><span class="lab">State #</span></td>
			<td>
				<select name="state" size="1" id="state">
					<option selected="selected" value="">Select a State</option>
				<?$statesql = "select * from tblstates";
				$stateres = mysql_query($statesql);

				while($state = mysql_fetch_assoc($stateres)):?>
					<option value="<?=$state['fldSt']?>" <?=($sql_values_fetch['fldState'] === $state['fldSt'])?'selected="selected"':'';?>><?=$state['fldSt'];?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="lab">Insurance Company </span></td>
			<td><input name="insurancecompanyname" type="text" value="<?=$sql_values_fetch['fldInsuranceCompanyName']?>" /></td>
			<td><span class="lab">Policy #</span></td>
			<td><input name="policy" type="text" value="<?=$sql_values_fetch['fldPolicy']?>" /></td>
			<td><span class="lab">Group #</span></td>
			<td><input name="group" type="text" value="<?=$sql_values_fetch['fldGroup']?>" /></td>
		</tr>
		<tr>
			<td><span class="lab">HMO Name/Contract </span></td>
			<td><input name="hmo_contract" type="text" value="<?=$sql_values_fetch['fldHmoContract']?>" /></td>
		</tr>
	<?endif;

	if($type !=4):?>
		<tr>
			<td><span class="lab"><?=($type==2)?"Guarantor:":"Responsible Party:";?></span></td>
			<td><input name="responsibleperson" type="text" value="<?=$sql_values_fetch['fldResponsiblePerson']?>" /></td>
			<td><span class="lab">Relationship</span></td>
			<td>
				<select name="relationship">
					<option selected="selected" value="">Select</option>
				<?$sql="SELECT * FROM tbllists where fldListName = 'relationship' order by fldValue";
				$result = mysql_query($sql);

				while($row = mysql_fetch_array($result)):?>
					<option value="<?=$row['fldValue']?>" <?=($sql_values_fetch['fldRelationship'] === $row['fldValue'])?'selected="selected"':''?>><?=strtoupper($row['fldValue'])?></option>
				<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="lab">Phone #</span></td>
			<td><input name="privatephone" type="text" value="<?=$sql_values_fetch['fldPrivatePhoneNumber']?>"/></td>
		</tr>
	<?endif;

	if($type==1 || $type==3):?>
		<tr>
			<td class="declaration" colspan="8" style="text-align: center;">
				<p>This Patient would find it physically and/or psychologically taxing because of advanced age and/or physical limitations to receive an X-ray or EKG outside this location. This test is medically necessary for the diagnosis and treatment of this patient.</p>
			</td>
		</tr>
	<?endif;?>
		<tr>
			<td colspan="8">
				<div align="center">
					<input type="submit" name="submit" value="<?=($_REQUEST['id'] )?"Save":"Add";?>"/>
					<input name="savennew" type="submit" value="<?=($_REQUEST['id'] )?"Save":"Add";?> & Start New <?=$typesqlarray[$type]?> Order" />
					<input name="savecnew" type="submit" value="<?=($_REQUEST['id'] )?"Save":"Add";?> & Create new order for same patient"/>
				</div>
			</td>
		</tr>
<?endif;?>
	</table>
</form>
<?php

if($submit !== '')
{
	//////////////////////////
	// Read POST request params into global vars
	//$to1=$sql_values_fetch['fldEmailSendOrders1'];
	//$to2=$sql_values_fetch['fldEmailSendOrders2'];

	//$from = "Douglas <dpotter@mdipacs.net>";
	//$to=$to1 . ";" . $to2;
	//$subject = "MDI Imaging & Reffering Physician - Order";
	//$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
	//$text = "Hi,\r\n\r\nPlease find the attached receipt for Order Placed at MDF Imaging & Referring Physician\r\n\r\nRegards\r\nMDF Imaging & Referring Physician";
	//$file = $filename; // attachment
	//$crlf = "\n";
	//  $mime = new Mail_mime($crlf);
	//  $mime->setTXTBody($text);
	//  $mime->addAttachment($file, 'text/plain');
	//  $body = $mime->get();
	//  $headers = $mime->headers($headers);
	//  $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => false, 'username' => $username,'password' => $password));
	//  $mail = $smtp->send($to, $headers, $body);

	//email to facility
	//$fac = $_REQUEST['facility'];
	//$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblfacility where fldFacilityName = '$fac'"));
	//if($sql_values_fetch['fldEmailOrder'] == 1)
		//{
		//$to = $sql_values_fetch['fldEmail'];
		//$mail = $smtp->send($to, $headers, $body);
		//}


	if($_REQUEST['savennew']!= "")
	{
		$redirecturl = "index.php?pg=21&order_type=$type";
		header("location:".$redirecturl);
	}
	else if($_REQUEST['savecnew']!= "")
	{
		$redirecturl = "index.php?pg=21&order_type=$type&id=$id&neworder=1";
		header("location:".$redirecturl);
	}
	else
	{
		$redirecturl = "index.php?pg=20";
		header("location:".$redirecturl);
	}
}
endif;
?>
