<? # PMD 2012-01-23 
# check patid exists with different name
$patId = $_REQUEST['patientid'];
$patSSN = strtoupper(strip_tags(addslashes($_REQUEST['patientssn'])));
$patFirstName = strtoupper(strip_tags(addslashes($_REQUEST['firstname'])));
$patLastName = strtoupper(strip_tags(addslashes($_REQUEST['lastname'])));

$strSQL = "SELECT fldFirstName, fldLastName, fldPatientSSN 
			FROM tblorderdetails
			WHERE fldPatientId = '$patId' 
			AND fldFirstName NOT LIKE '%$patFirstName%'";
			#AND fldLastName LIKE '%$patLastName%'
			#AND fldPatientSSN LIKE '%$patSSN%'";
			
$result = mysql_query($strSQL);
if ( mysql_num_rows($result) != 0 )
{
	$row = mysql_fetch_row($result);
	mysql_free_result($result);
	$saveError = "Patient ID already in use for different name: ".$row[1].", ".$row[0]." ".$row[2];
}

if ( isset($saveError) )
{
	echo "<center><div class='war'>$saveError</div></center>";

	# date of birth	
	$dtDOB = new DateTime(str_replace("-","/",$_REQUEST['dob']));
	# Order Date
	$dtSchD = new DateTime(str_replace("-","/",$_REQUEST['schdate1']));
	$dtSchT = new DateTime($_REQUEST['schdate2']);
	$dtSch = new DateTime($dtSchD->format("Y-m-d") . " " . $dtSchT->format("H:i:s"));
	$sql_values_fetch['fldSchDate'] = $dtSch->format("Y-m-d H:i:s");
	$schdate1 = $dtSchD->format("m-d-Y");#'today date'
	$schdate2 = $dtSchT->format("h:i A");#'today time'	
	# Scheduled Date	
	$dtExm = new DateTime(str_replace("-","/",$_REQUEST['schdate12']));
	$sql_values_fetch['fldDate'] = $dtExm->format("Y-m-d")." 00:00:00";
	$schdate12 = $dtExm->format("m-d-Y");
	
	# stick values into something that looks like record from table ...
	$sql_values_fetch = array();
	$sql_values_fetch['fldLastName'] = $_REQUEST['lastname'];
	$sql_values_fetch['fldFirstName'] = $_REQUEST['firstname'];
	$sql_values_fetch['fldMiddleName'] = $_REQUEST['middlename'];
	$sql_values_fetch['fldSurName'] = $_REQUEST['surname'];
	$sql_values_fetch['fldPatientID'] = $_REQUEST['patientid'];
	$sql_values_fetch['fldDOB'] = $dtDOB->format("Y-m-d");
	$sql_values_fetch['fldPatientSSN'] = $_REQUEST['patientssn'];
	$sql_values_fetch['fldGender'] = $_REQUEST['sex'];
	$sql_values_fetch['fldPrivateAddressLine1'] = $_REQUEST['privatestreetaddress1'];
	$sql_values_fetch['fldPrivateAddressLine2'] = $_REQUEST['privatestreetaddress2'];
	$sql_values_fetch['fldPrivateAddressCity'] = $_REQUEST['privatecity'];
	$sql_values_fetch['fldPrivateAddressState'] = $_REQUEST['privatestate'];
	$sql_values_fetch['fldPrivateAddressZip'] = $_REQUEST['privatezipcode'];
	$sql_values_fetch['fldPrivatePhoneNumber'] = $_REQUEST['privatephone'];
	$sql_values_fetch['fldRequestedBy'] = $_REQUEST['requester'];
	$sql_values_fetch['fldFacilityName'] = $_REQUEST['facility'];
	$sql_values_fetch['fldFacPhone'] = $_REQUEST['facphone'];
	$sql_values_fetch['fldFacPhone'] = $_REQUEST['faccontact'];
	$sql_values_fetch['fldPatientroom'] = $_REQUEST['patientroom'];
	$sql_values_fetch['fldProcedure1'] = $_REQUEST['procedure1'];
	$sql_values_fetch['fldSymptom1'] = $_REQUEST['symptoms1'];
	$sql_values_fetch['fldProcedure2'] = $_REQUEST['procedure2'];
	$sql_values_fetch['fldSymptom2'] = $_REQUEST['symptoms2'];
	$sql_values_fetch['fldProcedure3'] = $_REQUEST['procedure3'];
	$sql_values_fetch['fldSymptom3'] = $_REQUEST['symptoms3'];
	$sql_values_fetch['fldProcedure4'] = $_REQUEST['procedure4'];
	$sql_values_fetch['fldSymptom4'] = $_REQUEST['symptoms4'];
	$sql_values_fetch['fldProcedure5'] = $_REQUEST['procedure5'];
	$sql_values_fetch['fldSymptom5'] = $_REQUEST['symptoms5'];
	$sql_values_fetch['fldProcedure6'] = $_REQUEST['procedure6'];
	$sql_values_fetch['fldSymptom6'] = $_REQUEST['symptoms6'];
	$sql_values_fetch['fldSymptoms'] = $_REQUEST['symptoms'];
	$sql_values_fetch['fldplr1'] = $_REQUEST['plr1'];
	$sql_values_fetch['fldplr2'] = $_REQUEST['plr2'];
	$sql_values_fetch['fldplr3'] = $_REQUEST['plr3'];
	$sql_values_fetch['fldplr4'] = $_REQUEST['plr4'];
	$sql_values_fetch['fldplr5'] = $_REQUEST['plr5'];
	$sql_values_fetch['fldplr6'] = $_REQUEST['plr6'];
	$sql_values_fetch['fldHistory'] = $_REQUEST['history'];
	$sql_values_fetch['fldPatNotes'] = $_REQUEST['patNotes'];
	$sql_values_fetch['fldOrderingPhysicians'] = $_REQUEST['orderingphysicians'];
	$sql_values_fetch['fldInsurance'] = $_REQUEST['insurance'];
	$sql_values_fetch['fldMedicareNumber'] = $_REQUEST['medicare'];
	$sql_values_fetch['fldMedicaidNumber'] = $_REQUEST['medicaid'];
	$sql_values_fetch['fldState'] = $_REQUEST['state'];
	$sql_values_fetch['fldInsuranceCompanyName'] = $_REQUEST['insurancecompanyname'];
	$sql_values_fetch['fldPolicy'] = $_REQUEST['policy'];
	$sql_values_fetch['fldGroup'] = $_REQUEST['group'];
	$sql_values_fetch['fldHmoContract'] = $_REQUEST['hmo_contract'];
	$sql_values_fetch['fldResponsiblePerson'] = $_REQUEST['responsibleperson'];
	$sql_values_fetch['fldRelationship'] = $_REQUEST['relationship'];
	$sql_values_fetch['fldNstairs'] = $_REQUEST['nstairs'];
	$sql_values_fetch['fldStairs'] = $_REQUEST['stairs'];
	$sql_values_fetch['fldStat'] = $_REQUEST['stat'];
	$sql_values_fetch['fldAfterhours'] = $_REQUEST['afterhours'];
}
else
{
	if( $_REQUEST['patientid'] == '' )
	{ # auto create patient ID
		$sql = "SELECT MAX(CONVERT(fldPatientID,SIGNED)) FROM tblorderdetails";
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);
		mysql_free_result($result);
		$pid = $row[0];
		if( $pid < 25001 ) $pid = 25000;
		$pid = $pid + 1;
	}
	else
	{
		$pid = $_REQUEST['patientid'];
	}

	$cretime = date("Y-m-d",time());
	
	$newdob = formatdate($_REQUEST['dob']);
	$orddate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate1']) . ' ' . $_REQUEST['schdate2']));
	$schdate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
	$cddate = formatdate($_REQUEST['cddate']);

	# fhat the wuck?
	$ordphy = $_REQUEST['orderingphysicians'];
	if( $ordphy == "new" ) $ordphy = $_REQUEST['phynew'];

	# autodispatch
	$row = mysql_fetch_row( mysql_query("SELECT varValue FROM tblsysvar WHERE varName='autodispatch'") );
	if ( $row[0] == 1 )
	{
		$dispatched = 0;
		$technologist = '';
		$facy = $_REQUEST['facility'];
		$sql_values_fetch_fac =	mysql_fetch_array(mysql_query("select * from tblfacility where fldFacilityName='$facy'"));
		$adisp = $sql_values_fetch_fac['fldAutoDispatch'];
		if( $adisp == 1 )
		{
			$dispatched=1;
			$technologist = $sql_values_fetch_fac['fldTechnologist'];
		}
	}
	
	# generate accession numbers
	$accession = new DateTime();
	$acsnum = array();
	for ($cntr=1;$cntr<7;$cntr++) $acsnum[$cntr] = $accession->format('Ymd-His').$cntr;

	$sql_insert = mysql_query("INSERT INTO tblorderdetails SET
	fldPatientID='".strtoupper(strip_tags(addslashes($pid)))."',
	fldSchDate='".strtoupper(strip_tags(addslashes($schdate)))."',
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
	fldPrivateAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress1'])))."',
	fldPrivateAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress2'])))."',
	fldPrivateAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['privatecity'])))."',
	fldPrivateAddressState='".(strip_tags(addslashes($_REQUEST['privatestate'])))."',
	fldPrivateAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['privatezipcode'])))."',
	fldPrivatePhoneNumber='".strtoupper(phone_number($_REQUEST['privatephone']))."',
	fldHomeAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress1'])))."',
	fldHomeAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress2'])))."',
	fldHomeAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['homecity'])))."',
	fldHomeAddressState='".(strip_tags(addslashes($_REQUEST['homestate'])))."',
	fldHomeAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['homezipcode'])))."',
	fldHomePhoneNumber='".strtoupper(strip_tags(addslashes($_REQUEST['homephone'])))."',
	fldStat='".strtoupper(strip_tags(addslashes($_REQUEST['stat'])))."',
	fldOrderingPhysicians='".(strip_tags(addslashes($ordphy)))."',
	fldRequestedBy='".strtoupper(strip_tags(addslashes($_REQUEST['requester'])))."',
	fldProcedure1='".(strip_tags(addslashes($_REQUEST['procedure1'])))."',
	fldProcedure2='".(strip_tags(addslashes($_REQUEST['procedure2'])))."',
	fldProcedure3='".(strip_tags(addslashes($_REQUEST['procedure3'])))."',
	fldProcedure4='".(strip_tags(addslashes($_REQUEST['procedure4'])))."',
	fldProcedure5='".(strip_tags(addslashes($_REQUEST['procedure5'])))."',
	fldProcedure6='".(strip_tags(addslashes($_REQUEST['procedure6'])))."',
	fldacsno1='".$acsnum[1]."',
	fldacsno2='".$acsnum[2]."',
	fldacsno3='".$acsnum[3]."',
	fldacsno4='".$acsnum[4]."',
	fldacsno5='".$acsnum[5]."',
	fldacsno6='".$acsnum[6]."',
	fldplr1='".(strip_tags(addslashes($_REQUEST['plr1'])))."',
	fldplr2='".(strip_tags(addslashes($_REQUEST['plr2'])))."',
	fldplr3='".(strip_tags(addslashes($_REQUEST['plr3'])))."',
	fldplr4='".(strip_tags(addslashes($_REQUEST['plr4'])))."',
	fldplr5='".(strip_tags(addslashes($_REQUEST['plr5'])))."',
	fldplr6='".(strip_tags(addslashes($_REQUEST['plr6'])))."',
	fldSymptom1='".(strip_tags(addslashes($_REQUEST['symptoms1'])))."',
	fldSymptom2='".(strip_tags(addslashes($_REQUEST['symptoms2'])))."',
	fldSymptom3='".(strip_tags(addslashes($_REQUEST['symptoms3'])))."',
	fldSymptom4='".(strip_tags(addslashes($_REQUEST['symptoms4'])))."',
	fldSymptom5='".(strip_tags(addslashes($_REQUEST['symptoms5'])))."',
	fldSymptom6='".(strip_tags(addslashes($_REQUEST['symptoms6'])))."',
	fldPatientroom='".strtoupper(strip_tags(addslashes($_REQUEST['patientroom'])))."',
	fldAfterhours='".strtoupper(strip_tags(addslashes($_REQUEST['afterhours'])))."',
	fldHistory='".strtoupper(strip_tags(addslashes($_REQUEST['history'])))."',
	fldCDRequested='".(strip_tags(addslashes($_REQUEST['cdrequested'])))."',
	fldSymptoms='".strtoupper(strip_tags(addslashes($_REQUEST['symptoms'])))."',
	fldCDAddr='".strtoupper(strip_tags(addslashes($_REQUEST['cdaddr'])))."',
	fldCDDate='".strtoupper(strip_tags(addslashes($cddate)))."',
	fldUserName='".strtoupper(strip_tags(addslashes($_SESSION['user'])))."',
	fldDate='".strtoupper(strip_tags(addslashes($orddate)))."',
	fldCreDate='".strtoupper(strip_tags(addslashes($cretime)))."',
	fldDispatched='".strtoupper(strip_tags(addslashes($dispatched)))."',
	fldTechnologist='".strtoupper(strip_tags(addslashes($technologist)))."',
	fldpps='".strtoupper(strip_tags(addslashes($_REQUEST['pps'])))."',
	created_by = '".$_SESSION['user']."',
	created_date = '".date('Y-m-d H:i:s')."',
	fldPatNotes = '".strip_tags(addslashes($_REQUEST['patNotes']))."'
	") or die (mysql_error());
	$id = mysql_insert_id();
	$txtid = $id;
	$id = $txtid;

	if($sql_insert)
	{
		$sql_insert_icd	= mysql_query("insert into tblicdcodes set 	fldOrderid='".(strip_tags(addslashes($id)))."'") or die (mysql_error());

		if($sql_insert_icd) include "pdf_neworder.php";

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


		$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblsettings"));
		$txtdest = $sql_values_fetch['flddmwl'];

		$stringData0 = "[RecordNum1] \r";
		$stringData0 .= "Patient Name = " . $_REQUEST['lastname'] . "\t^" . $_REQUEST['firstname'] . "\r";
		$stringData0 .= "Patient ID = " . $pid . "\r";

		$stringData0 .= "Date of Birth = " . $newdob . "\r";
		$stringData0 .= "Additional Patient History = " . $_REQUEST['history'] . "\r";
		$stemp = $_REQUEST['sex'];
		if ($stemp == 'male') $txtsex = 'M'; 
		if ($stemp == 'female') $txtsex = 'F';
		$stringData0 .= "Sex = " . $txtsex. "\r";
		function formatDatez($dDate){
			$dNewDate = strtotime($dDate);
			return date('Ymd-His',$dNewDate);
		}

		$stringData1 = "Referring Physician = " . $ordphy . "\r";
		$stringData1 .= "Scheduled AE Station = crvan \r";

		$schdate = date('Y-m-d',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
		$schtime = date('H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
		$stringData2 = "Scheduled Start Date = " . $schdate . "\r";
		$stringData2 .= "Scheduled Start Time = " . $schtime . "\r";

		$dob = $_REQUEST['dob'];
		$sDate = explode('-', $dob);
		$sDate1 = $sDate[2].$sDate[0].$sDate[1];
		$hi7_dob=$sDate1;


		$hi7dest="hi7/";
		$hi7_time=date("mdY",time());

		$hi7_1="MSH|^~\&|Ig bu|MDImaging|Test|MMDS Mobile X-ray|";
		$hi7_2 .="||ORM^O01|00000";
		$hi7_2 .=$hi7_time;
		$hi7_2 .="|P|2.3|||NE|NE" . "\r";
		$hi7_2 .="PID|";
		$hi7_2 .=$pid;
		$hi7_2 .="|";
		$hi7_2 .=$pid;
		$hi7_2 .="|";
		$hi7_2 .=$pid;
		$hi7_21 =$_REQUEST['lastname'] . "^" . $_REQUEST['firstname'] . "^" . $_REQUEST['middlename'] . "^" . $_REQUEST['surname'];
		$hi7_21 .="||";
		$hi7_21 .=$hi7_dob;
		$hi7_21 .="|";
		$hi7_21 .=$txtsex;
		$hi7_21 .="||U|||||U|||000-00-0000" . "\r";
		$hi7_21 .="PV1|";
		$hi7_21 .=$pid;
		$hi7_21 .="|O|BUF^^buffalo^MDImaging||||Referring|";
		$hi7_21 .=$ordphy . "\r";
		$hi7_21 .="ORC|SC|";
		$hi7_3 .="|S||^^^";
		$hi7_3 .=$hi7_time;
		$hi7_3 .="^^N||||||||||||||MMDS Mobile X-ray" . "\r";
		$hi7_3 .="OBR|1|";

		$pr1 = $_REQUEST['procedure1'];
		if($pr1)
		{
			$myFile = $txtdest . $txtid . "p1.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr1'"));
			$acsno = acsnum[1];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " . $_REQUEST['symptoms1'] . "\r" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r";
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr1'] . " " . $_REQUEST['procedure1'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr1'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr1'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms1'];

			fwrite($fh, $hi7_txt);
			fclose($fh);
		}

		$pr2 = $_REQUEST['procedure2'];
		if($pr2)
		{
			$myFile = $txtdest . $txtid . "p2.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr2'"));
			$acsno = acsnum[2];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms2'] . "\r" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr2'] . " " . $_REQUEST['procedure2'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-2||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr2'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr2'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms2'];

			fwrite($fh, $hi7_txt);
			fclose($fh);
		}

		$pr3 = $_REQUEST['procedure3'];
		if($pr3)
		{
			$myFile = $txtdest . $txtid . "p3.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr3'"));
			$acsno = acsnum[3];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms3'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr3'] . " " . $_REQUEST['procedure3'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-3||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr3'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr3'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms3'];

			fwrite($fh, $hi7_txt);
			fclose($fh);
		}

		$pr4 = $_REQUEST['procedure4'];
		if($pr4)
		{
			$myFile = $txtdest . $txtid . "p4.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr4'"));
			$acsno = $acsnum[4];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms4'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr4'] . " " . $_REQUEST['procedure4'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-4||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr4'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr4'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms4'];

			fwrite($fh, $hi7_txt);
			fclose($fh);
		}

		$pr5 = $_REQUEST['procedure5'];
		if($pr5)
		{
			$myFile = $txtdest . $txtid . "p5.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr5'"));
			$acsno = $acsnum[5];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms5'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr5'] . " " . $_REQUEST['procedure5'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-5||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr5'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr5'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms5'];

			fwrite($fh, $hi7_txt);
			fclose($fh);
		}

		$pr6 = $_REQUEST['procedure6'];
		if($pr6)
		{
			$myFile = $txtdest . $txtid . "p6.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr6'"));
			$acsno = $acsnum[6];
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms6'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
			$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr6'] . " " . $_REQUEST['procedure6'] . "\r";
			$stringData = strtoupper($stringData);
			fwrite($fh, $stringData);
			fclose($fh);

			$myFile = $hi7dest . $acsno . ".txt";
			$fh = fopen($myFile, 'w') or die("can't open file");

			$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-6||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr6'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr6'];
			$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms6'];

			fwrite($fh, $hi6_txt);
			fclose($fh);
		}
		$redirecturl = "index.php?pg=20";
		header("location:".$redirecturl);
	}
}
?>