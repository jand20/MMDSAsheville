<?php #MDI OOE Upgrade Version 12/3/12
//ini_set('display_errors', 1);
if(!isset($_SESSION))
	session_start();

// if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");
include "config.php";
$sql_values_fetch = mysql_fetch_array( mysql_query("select *,
		DATE_FORMAT(created_date,'%m/%d/%Y %H:%i') AS created_date_formated,
		DATE_FORMAT(modified_date,'%m/%d/%Y %H:%i') AS modified_date_formated
		from tblorderdetails where fldID='$id'"));
$sql_values_icd =   mysql_fetch_array( mysql_query("select * from tblicdcodes where fldOrderid='$id'"));
/*
 require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
$host = "mail.mdipacs.net";
$username = "dpotter";
$password = "brasil06";
*/

$type = $sql_values_fetch['fldOrderType'];
$typearray = array("","Nursing Home Order","Correctional Facility","Home Health Orders","Lab Orders");

function formatDateddmmyy($dDate)
{
	$dNewDate = strtotime($dDate);
	return date('m-d-Y',$dNewDate);
}

$ddob="MM-DD-YYYY";

$fdob = $sql_values_fetch['fldDOB'];

if($fdob!=''):
	$ddob = formatDateddmmyy($fdob);
endif;

$time=date("Y-m-d H:i",time());

function formatDate21($dDate)
{
	$dNewDate = strtotime($dDate);
	return date('m-d-Y',$dNewDate);
}

function formatDate22($dDate)
{
	$dNewDate = strtotime($dDate);
	$t = date('g:i A',$dNewDate);
	
	if( $t == '12:00 AM' ):
		return '';
	else:
		return '$t';
	endif;
}

$schdte		= $sql_values_fetch['fldSchDate'];
$time11		= formatdate21($schdte);
$time12		= formatdate22($schdte);
$cddte		= $sql_values_fetch['fldCDDate'];
$cddate		= formatdate21($cddte);
$refph		= $sql_values_fetch['fldOrderingPhysicians'];
$sql_user	= mysql_fetch_array(mysql_query("SELECT * FROM tbluser where fldRealName='$refph'"));
$phyph		= $sql_user['fldPhone'];

?>
<script type="text/javascript">
function open_win()
{
	<?
		$sql_values_fetch_pdf =	mysql_fetch_array(mysql_query("select * from tblsettings"));
		if($sql_values_fetch['fldAuthorized'] == 1)
		{
			$dest=$sql_values_fetch_pdf['fldPDFSignedOrders'];
			$pdate=$sql_values_fetch['fldAuthDate'];
			$sign="s";
		}
		else
		{
			$dest=$sql_values_fetch_pdf['fldPDFUnsignedOrders'];
			$pdate=$sql_values_fetch['fldCreDate'];
			$sign="u";
		}
	
	$filename = $dest . $sign . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";
	
	//die(print_r($filename,true));
	?>
	window.open("<?=$filename; ?>");
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" style="background: url(main.png);">
	<table>
		<tr>
			<td colspan='8' style='text-align: right;'>
				<span class='ordertypelabel'><?=$typearray[$type]?> </span>
			</td>
		</tr>
		<tr>
			<td colspan="8" style='text-align: left;'><?//show user created and modified dates if role is dispatcher or admin
			if($_SESSION['role']==='admin' || $_SESSION['role']==='dispatcher'):
				$myTemp = array();
				
				if(!empty($sql_values_fetch['created_by'])):
					$myTemp[] = "<span class='label'>Ordered by:</span><span class='display'> {$sql_values_fetch['created_by']} {$sql_values_fetch['created_date_formated']}</span>";
				endif;

				if(!empty($sql_values_fetch['modified_by'])):
					$myTemp[] = "<span class='label'>Last Edited by:</span><span class='display'> {$sql_values_fetch['modified_by']} {$sql_values_fetch['modified_date_formated']}</span>";
				endif;
				
				echo implode('<br/>', $myTemp);
			endif;//=date('m/d/Y g:i A', strtotime($sql_values_fetch['fldDate']));?>
			</td>
		</tr>
		<tr><td><br/></td></tr><!-- blank row -->
		<tr>
			<td class="label">Last Name:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldLastName'])?></td>
			<td class="label">First Name:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldFirstName'])?></td>
			<td class="label">Middle Name:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldMiddleName'])?></td>
			<td class="label">Jr, Sr, II:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldSurName'])?></td>
		</tr>
		<tr>
			<td class="label"><?=($type==2)?"Inmate ID#:":"Patient MR#:";?></td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPatientID'])?></td>
			<td class="label">DOB:</td>
			<td class="display"><?=$ddob?> </td>
	<?if($type == 1 || $type == 3|| $type == 4):?>
			<td class="label">Patient SSN:</td>
			<td class="display"> <?=strtoupper($sql_values_fetch['fldPatientSSN'])?></td>
	<?else:?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	<?endif;?>
			<td class="label">Sex:</td>
			<td class="display"> <?=strtoupper($sql_values_fetch['fldGender'])?></td>
		</tr>
	<?if ($type == 2):?>
		<tr>
			<td class="label">Housing #:</td>
			<td><?=$sql_values_fetch['fldPrivateHousingNo']?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="label">Station:</td>
			<td class="display"><?=$sql_values_fetch['fldStation']?></td>
		</tr>
		<tr>
			<td class='label'>Stat:</td>
			<td class='display'><?=($sql_values_fetch['fldStat'] == 1)?'YES':'NO'?></td>
		</tr>
	<?endif;
if($type==3 || $type==4):?>
		<tr>
			<td class="label">Location/Facility:</td>
			<td colspan="3" class="display"><?=$sql_values_fetch['fldLocFacName']?></td>
		</tr>
	<?if($type == 4):?>
		<tr>
			<td class="label">Station:</td>
			<td class="display"><?=$sql_values_fetch['fldStation']?></td>
		</tr>
		<tr>
			<td class="label">Room #:</td>
			<td class="display"><?=$sql_values_fetch['fldPatientroom']?></td>
		</tr>
	<?endif;?>
		<tr>
			<td class="label">Address #1:</td>
			<td class="display"><?=($sql_values_fetch['fldPrivateAddressLine1']==='UNDEFINED'?'':$sql_values_fetch['fldPrivateAddressLine1'])?></td>
		</tr>
		<tr>
			<td class="label">Address #2:</td>
			<td class="display"><?=($sql_values_fetch['fldPrivateAddressLine2']=='UNDEFINED'?'':$sql_values_fetch['fldPrivateAddressLine2'])?></td>
		</tr>
		<tr>
			<td class="label">City:</td>
			<td class="display"><?=($sql_values_fetch['fldPrivateAddressCity']=='UNDEFINED'?'':$sql_values_fetch['fldPrivateAddressCity'])?></td>
		</tr>
		<tr>
			<td class="label">State:</td>
			<td class="display"><?=($sql_values_fetch['fldPrivateAddressState']=='UNDEFINED'?'':$sql_values_fetch['fldPrivateAddressState'])?></td>
		</tr>
		<tr>
			<td class="label">Zip:</td>
			<td class="display"><?=($sql_values_fetch['fldPrivateAddressZip']=='UNDEFINED'?'':$sql_values_fetch['fldPrivateAddressZip'])?></td>
		</tr>
	<?if($type == 3 ):?>
		<tr>
			<td class="label">Phone #:</td>
			<td class="display"> <?=strtoupper($sql_values_fetch['fldPrivateResidenceNumber'])?></td>
		</tr>
	<?endif;
endif;
if($type == 4):?>
		<tr>
			<td class="label">Test Priority:</td>
			<td class="display">Weekend : <?=$sql_values_fetch['fldTestPriority']?></td>
			<td class="display">Stat : <?=$sql_values_fetch['fldStat']?></td>
		</tr>
		<tr>
			<td class="label">Ordering Dr.:</td>
			<td class="display"><?=$sql_values_fetch['fldOrderingPhysicians']?></td>
		</tr>
		<tr>
			<td class="label" colspan='2'>Diagnosis Required 1)</td>
			<td class="display"><?=$sql_values_fetch['fldDiagnosisReuired1']?></td>
		</tr>
		<tr>
			<td class="label" style='text-align: right;' colspan='2'>2)</td>
			<td class="display"><?=$sql_values_fetch['fldDiagnosisReuired2']?></td>
		</tr>
		<tr>
			<td class="label" style='text-align: right;' colspan='2'>3)</td>
			<td class="display"><?=$sql_values_fetch['fldDiagnosisReuired3']?></td>
		</tr>
		<?endif;

if($type == 1):?>
		<tr><td><br/></td></tr><!-- blank row -->
		<tr>
			<td class="label">Facility Name:</td>
			<td colspan="2" class="display"> <?=strtoupper($sql_values_fetch['fldFacilityName'])?></td>
		</tr>
		<tr>
			<td class="label">Phone:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldFacPhone'])?></td>
			<td class="label">Fax:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldFacFax'])?></td>
			<td class="label">Contact Person:</td>
			<td class="display"> <?=strtoupper($sql_values_fetch['fldRequestedBy'])?></td>
		</tr>
		<tr>
			<td class="label">Room #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPatientroom'])?></td>
			<td class="label">Stat/Normal:</td>
			<td class="display"> <?=($sql_values_fetch['fldStat'] == 1)?"Stat":"NORMAL"?></td>
			<td class="label">After Hours:</td>
			<td class="display"> <?=($sql_values_fetch['fldAfterhours'] == 1)?"YES":"NO"?></td>
		</tr>
		<tr>
			<td class="label">Station:</td>
			<td class="display"><?=$sql_values_fetch['fldStation']?></td>
		</tr>
<?elseif($type == 2 ):?>
		<tr>
			<td class="label">Facility Name:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldFacilityName'])?></td>
			<td class="label">Report Phone:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldFacPhone'])?></td>
		</tr>
		<tr>
			<td class="label">Room #1:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPatientroom'])?></td>
			<td class="label">Report Fax:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldReportFax'])?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td class="label">Backup Phone:</td>
			<td class="display"><?=$sql_values_fetch['fldBackupPhone']?></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td class="label">Backup Fax:</td>
			<td class="display"><?=$sql_values_fetch['fldBackupFax']?></td>
		</tr>
<?elseif($type == 3 ):?>
		<tr>
			<td class="label">Stat:</td>
			<td class="display"><?=($sql_values_fetch['fldStat'] == 1)?'Yes':'No'?></td>
		</tr>
		<tr>
			<td class="label">Ordering Facility:</td>
			<td colspan="3" class="display"><?=$sql_values_fetch['fldFacilityName']?></td>
			<td class="label">Phone:</td>
			<td class="display"><?=$sql_values_fetch['fldFacPhone']?></td>
			<td class="label">Fax:</td>
			<td class="display"><?=$sql_values_fetch['fldFacFax']?></td>
		</tr>
		<tr>
			<td class="label">Stairs:</td>
			<td class="display"><?=($sql_values_fetch['fldStairs'] == 1)?"YES":"NO"?></td>
			<td class="label"># of stairs:</td>
			<td class="display"><?=$sql_values_fetch['fldNstairs']?></td>
			<td class="label">Pets:</td>
			<td class="display"><?=($sql_values_fetch['fldPets'] == 1)?"YES":"NO"?></td>
		</tr>
		<tr>
			<td class="label">Notes:</td>
		</tr>
		<tr>
			<td class="display"><?=strtoupper($sql_values_fetch['fldSymptoms'])?></td>
		</tr>
<?endif;

if($type != 4 ): # loop start
	for ( $pntr = 1; $pntr < 11; $pntr++):
		if(!empty($sql_values_fetch["fldProcedure$pntr"])):?>
			<tr><td><br/></td></tr><!-- blank row -->
			<tr>
				<td class="label">Procedure #<?=$pntr?>:</td>
				<td colspan="2" class="display"><?=strtoupper($sql_values_fetch["fldProcedure$pntr"])?></td>
				<td class="display"><?=strtoupper($sql_values_fetch["fldplr$pntr"])?></td>
				<td class="label">Symptom:</td>
				<td colspan="2" class="display"><?=strtoupper($sql_values_fetch["fldSymptom$pntr"])?></td>
			</tr>
			<tr>
				<td class="label">Accession #:</td>
				<td class="display"><?=strtoupper($sql_values_fetch["fldacsno$pntr"])?></td>
			</tr>
			
			<!-- <tr><?//TODO find out the legitamacy of this section?>
				<td class="label">ICD9A:</td>
				<td colspan="2" class="display"><?=strtoupper($sql_values_icd["fldProc{$pntr}icd1"])?></td>
			</tr>
			<tr>
				<td class="label">ICD9B:</td>
				<td colspan="2" class="display"><?=strtoupper($sql_values_icd["fldProc{$pntr}icd2"])?></td>
			</tr>
			<tr>
				<td class="label">ICD9C:</td>
				<td class="display"><?=strtoupper($sql_values_icd["fldProc{$pntr}icd3"])?></td>
			</tr>
			<tr>
				<td class="label">ICD9D:</td>
				<td class="display"><?=strtoupper($sql_values_icd["fldProc{$pntr}icd4"])?></td>
			</tr>
			<tr>
				<td class="label">Definiative Diagnosis:</td>
				<td colspan="6" class="display"><?=strtoupper($sql_values_icd["fldProc{$pntr}dig"])?></td>
			</tr>-->
			<tr><td><br/></td></tr>
		<?else:
			break;
		endif;
	endfor;//loop end
else:
	# loop start
	for ( $pntr = 1; $pntr < 11; $pntr++):
		if(!empty($sql_values_fetch["fldProcedure$pntr"])):?>
			<tr>
				<td class="label">Test #<?=$pntr?>:</td>
				<td colspan="4" class="display"><?=strtoupper($sql_values_fetch["fldProcedure$pntr"])?></td>
			</tr>
			<tr><td><br/></td></tr>
		<?else:
			break;
		endif;
	endfor;
endif;

if($type != 3 ):?>
		<tr>
			<td class="label">Additional Patient Info:</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="display" colspan ="7"> <?=strtoupper($sql_values_fetch['fldSymptoms'])?></td>
		</tr>
		<?endif;

if($type != 4 ):?>
		<tr>
			<td class="label">Patient History:</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="display" colspan ="7"><?=strtoupper($sql_values_fetch['fldHistory'])?></td>
		</tr>
		<tr>
			<td class="label">Ordering Dr.:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldOrderingPhysicians'])?></td>
			<td class="label">Phone:</td>
			<td class="display"><?=$sql_values_fetch['fldOrderingPhysiciansPhone']?></td>
			<td class="label">Fax:</td>
			<td class="display"><?=$sql_values_fetch['fldOrderingPhysiciansFax']?></td>
		</tr>
		<tr>
			<td class="label">Date Exam Needed:</td>
			<td class="display"><?="$time11 $time12"?></td>
		</tr>
	<?if($type == 4):?>
		<tr>
			<td class="label">CD Needed ?</td>
			<td class="display"><?=($sql_values_fetch['fldCDRequested'] == 1)?"YES":"NO"?></td>
		<?if($sql_values_fetch['fldCDRequested'] == 1):?>
			<td class="label">Location:</td>
			<td colspan="4" class="display"><?=strtoupper($sql_values_fetch['fldCDAddr'])?></td>
			<td class="label">Date CD Needed:</td>
			<td class="display"><?=strtoupper($cddate)?></td>
		<?else:?>
			<td colspan="7">&nbsp;</td>
		<?endif;?>
		</tr>
	<?else:?>
		<tr>
			<td class="label">Date Draw/Order Requested:</td>
			<td class='display'><?=formatDateddmmyy($sql_values_fetch['fldSchDate'])?></td>
			<td class="label">&nbsp;&nbsp;Standing Order?</td>
			<td class="display"><?=($sql_values_fetch['fldRepeat'] == 1?'YES': 'NO')?></td>
		</tr>
		<tr>
			<td class="label">Repeat Every:</td>
			<td class="display"><?=$sql_values_fetch['fldRepeatDays']?> Days.</td>
		<tr/>
		<tr>
			<td class="label">Repeat:</td>
			<td class="display"><?=$sql_values_fetch['fldRepeatTimes']?> Times.</td>
		</tr>
	<?endif;?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
	<?if($type == 1 || $type == 4 ):?>
		<tr>
			<td class='label'>Bill:</td>
			<td class='display'><?=($sql_values_fetch['fldbilled'] === 'insurance')?'Insurance':'Facility'?></td>
		</tr>
	<?endif;

if($type != 2):?>
		<tr>
			<td class="label">Insurance Type:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldInsurance'])?>
			</td>
		</tr>
		<tr>
			<td class="label">Medicare #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldMedicareNumber'])?></td>
			<td class="label">Medicaid #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldMedicaidNumber'])?></td>
			<td class="label">State #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldState'])?></td>
		</tr>
		<tr>
			<td class="label">Insurance Company:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldInsuranceCompanyName'])?></td>
			<td class="label">Policy #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPolicy'])?></td>
			<td class="label">Group #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldGroup'])?></td>
		</tr>
		<tr>
			<td class="label">HMO Name/Contract:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldHmoContract'])?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="label">Responsible Party:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldResponsiblePerson'])?></td>
			<td class="label">Relationship to Patient:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldRelationship'])?></td>
		</tr>
<?elseif($type == 2 ):?>
		<tr>
			<td class="label">Guarantor:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldResponsiblePerson'])?></td>
		</tr>
<?endif;

if($type == 1 || $type == 2):?>
		<tr>
			<td class="label">Address #1:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivateAddressLine1'])?></td>
		</tr>
		<tr>
			<td class="label">Address #2:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivateAddressLine2'])?></td>
		</tr>
		<tr>
			<td class="label">City:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivateAddressCity'])?></td>
		</tr>
		<tr>
			<td class="label">State:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivateAddressState'])?></td>
		</tr>
		<tr>
			<td class="label">Zip:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivateAddressZip'])?></td>
		</tr>
<?elseif($type == 3):?>
		<tr>
			<td class="label">Phone #:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldPrivatePhoneNumber'])?></td>
		</tr>
<?endif;?>
		<tr>
			<td>&nbsp;</td>
		</tr>
<?if($type != 4):?>
		<tr>
			<td class="label">Verbal Confirmation Date:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldReportDate'])?></td>
			<td class="label">Report Called To:</td>
			<td class="display"><?=strtoupper($sql_values_fetch['fldReportCalledTo'])?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="label">Report Details:</td>
			<td style="word-wrap: break-word" colspan="5" class="display"><?=strtoupper($sql_values_fetch['fldReportDetails'])?></td>
		</tr>
<?endif;
		
if($_SESSION['role']=='admin' || $_SESSION['role']=='dispatcher'):
	preg_match("/(\d{4})-(\d\d)-(\d\d) (\d\d:\d\d:\d\d)/",$sql_values_fetch['created_date'],$matches);
		
	$sql_values_fetch['created_date'] = $matches[2]."-".$matches[3]."-".$matches[1]." ".$matches[4];//FIXME what is this?!

	if($type==1 || $type==3):
		if( $sql_values_fetch['fldAuthorized'] == 1 ):
			preg_match("/(\d\d\d\d)\-(\d\d)\-(\d\d) (\d\d\:\d\d\:\d\d)/",$sql_values_fetch['fldAuthDate'],$matches);
			$sql_values_fetch['fldAuthDate'] = $matches[2]."-".$matches[3]."-".$matches[1]." ".$matches[4];

			echo "<tr><td class=\"dis\">Esigned by {$sql_values_fetch['fldOrderingPhysicians']} on  {$sql_values_fetch['fldAuthDate']}</td></tr>";
		endif;
		
		$sql = "SELECT * FROM tblfacility WHERE fldFacilityName='{$sql_values_fetch['fldFacilityName']}'";
		
		$res = mysql_query($sql);
		$fac = mysql_fetch_array($res);
		
		if($fac['fldReqDis'] ==='0'):?>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan='6' style='text-align: center;'>
					<p>This patient would find it physically and/or psychologically taxing because of advanced age and/or physical limitation to receive an x-ray or EKG outside this location.<br/>
					This test is medically necessary for the diagnosis and treatment of this patient.</p>
				</td>
				<td>&nbsp;</td>
			</tr>
		<?endif;
	endif;
endif;

endif;?>
		<tr>
			<td colspan='8' style='text-align: center;'>
				<input type="submit" name="back" value="Back"/>
				<input type="button" name="print" value="RePrint" onclick="open_win()"/>
			</td>
		</tr>
	</table>
</form>
<?php
if(isset($_REQUEST['back'])):
	$redirecturl = "index.php?pg=20";
	header("location:".$redirecturl);
endif;

if(isset($_REQUEST['email'])):
	$sql_values_fetch_pdf = mysql_fetch_array(mysql_query("select * from tblsettings"));
	if($sql_values_fetch['fldAuthorized'] == 1):
		$dest=$sql_values_fetch_pdf['fldPDFSignedOrders'];
		$pdate=$sql_values_fetch['fldAuthDate'];
		$sign="s";
	else:
		$dest=$sql_values_fetch_pdf['fldPDFUnsignedOrders'];
		$pdate=$sql_values_fetch['fldCreDate'];
		$sign="u";
	endif;

	$filename = $dest . $sign . $pdate . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";

	////////////////////////////////////////
	// Read POST request params into global vars
	//$from = "Douglas <dpotter@mdipacs.net>";
	//$to=$_REQUEST['temail'];
	//$subject = "MDI Imaging & Reffering Physician - Order";
	//$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
	//$text = "Hi,\r\n\r\nPlease find the Copy of your Order. \r\n\r\nRegards\r\nMDF Imaging & Referring Physician.";
	//$file = $filename; // attachment
	//$crlf = "\n";
	//$mime = new Mail_mime($crlf);
	//$mime->setTXTBody($text);
	//$mime->addAttachment($file, 'text/plain');
	//do not ever try to call these lines in reverse order
	//$body = $mime->get();
	//$headers = $mime->headers($headers);
	//$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => false, 'username' => $username,'password' => $password));
	//$mail = $smtp->send($to, $headers, $body);
endif;?>