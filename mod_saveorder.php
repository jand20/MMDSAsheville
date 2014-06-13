<?php # PMD mod_saveorder.php 
if($_REQUEST['submit']!='')
{
	$newdob = formatdate($_REQUEST['dob']);
	$orddate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate1']) . ' ' . $_REQUEST['schdate2']));
	$schdate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
	$cddate = formatdate($_REQUEST['cddate']);

	$ordphy = $_REQUEST['orderingphysicians'];
	if($ordphy == "new") $ordphy=$_REQUEST['phynew'];

	$pr1lr='';
	$pr1sy='';
	$pr1icd1='';
	$pr1icd2='';
	$pr1icd3='';
	$pr1icd4='';
	$pr1dig='';
	$pr2lr='';
	$pr2lr='';
	$pr2sy='';
	$pr2icd1='';
	$pr2icd2='';
	$pr2icd3='';
	$pr2icd4='';
	$pr2dig='';
	$pr3lr='';
	$pr3lr='';
	$pr3sy='';
	$pr3icd1='';
	$pr3icd2='';
	$pr3icd3='';
	$pr3icd4='';
	$pr3dig='';
	$pr4lr='';
	$pr4lr='';
	$pr4sy='';
	$pr4icd1='';
	$pr4icd2='';
	$pr4icd3='';
	$pr4icd4='';
	$pr4dig='';
	$pr5lr='';
	$pr5lr='';
	$pr5sy='';
	$pr5icd1='';
	$pr5icd2='';
	$pr5icd3='';
	$pr5icd4='';
	$pr5dig='';
	$pr5lr='';
	$pr6sy='';
	$pr6icd1='';
	$pr6icd2='';
	$pr6icd3='';
	$pr6icd4='';
	$pr6dig='';
	$sql_values_icd =	mysql_fetch_array(mysql_query("select * from tblicdcodes where fldOrderid='$id'"));
	######
	$pr1 = $_REQUEST['procedure1'];
	if($pr1)
	{
		$pr1lr=$_REQUEST['plr1'];
		$pr1sy=$_REQUEST['symptoms1'];
		$pr1icd1=$_REQUEST['proc1icd1'];
		$pr1icd2=$_REQUEST['proc1icd2'];
		$pr1icd3=$_REQUEST['proc1icd3'];
		$pr1icd4=$_REQUEST['proc1icd4'];
		$pr1dig=$_REQUEST['proc1dig'];
	}
	$pr2 = $_REQUEST['procedure2'];
	if($pr2)
	{
		$pr2lr=$_REQUEST['plr2'];
		$pr2sy=$_REQUEST['symptoms2'];
		$pr2icd1=$_REQUEST['proc2icd1'];
		$pr2icd2=$_REQUEST['proc2icd2'];
		$pr2icd3=$_REQUEST['proc2icd3'];
		$pr2icd4=$_REQUEST['proc2icd4'];
		$pr2dig=$_REQUEST['proc2dig'];
	}
	$pr3 = $_REQUEST['procedure3'];
	if($pr3)
	{
		$pr3lr=$_REQUEST['plr3'];
		$pr3sy=$_REQUEST['symptoms3'];
		$pr3icd1=$_REQUEST['proc3icd1'];
		$pr3icd2=$_REQUEST['proc3icd2'];
		$pr3icd3=$_REQUEST['proc3icd3'];
		$pr3icd4=$_REQUEST['proc3icd4'];
		$pr3dig=$_REQUEST['proc3dig'];
	}
	$pr4 = $_REQUEST['procedure4'];
	if($pr4)
	{
		$pr4lr=$_REQUEST['plr4'];
		$pr4sy=$_REQUEST['symptoms4'];
		$pr4icd1=$_REQUEST['proc4icd1'];
		$pr4icd2=$_REQUEST['proc4icd2'];
		$pr4icd3=$_REQUEST['proc4icd3'];
		$pr4icd4=$_REQUEST['proc4icd4'];
		$pr4dig=$_REQUEST['proc4dig'];
	}
	$pr5 = $_REQUEST['procedure5'];
	if($pr5)
	{
		$pr5lr=$_REQUEST['plr5'];
		$pr5sy=$_REQUEST['symptoms5'];
		$pr5icd1=$_REQUEST['proc5icd1'];
		$pr5icd2=$_REQUEST['proc5icd2'];
		$pr5icd3=$_REQUEST['proc5icd3'];
		$pr5icd4=$_REQUEST['proc5icd4'];
		$pr5dig=$_REQUEST['proc5dig'];
	}
	$pr6 = $_REQUEST['procedure6'];
	if($pr6)
	{
		$pr6lr=$_REQUEST['plr6'];
		$pr6sy=$_REQUEST['symptoms6'];
		$pr6icd1=$_REQUEST['proc6icd1'];
		$pr6icd2=$_REQUEST['proc6icd2'];
		$pr6icd3=$_REQUEST['proc6icd3'];
		$pr6icd4=$_REQUEST['proc6icd4'];
		$pr6dig=$_REQUEST['proc6dig'];
	}
	
	# Autodispatch
	$dispatched = 0;
	$technologist = '';

	if( $sql_values_fetch['fldDispatched'] == 1 )
	{
		$dispatched = 1;
		$technologist = $sql_values_fetch['fldTechnologist'];
	}

	$facy = $_REQUEST['facility'];
	$sql_values_fetch_fac =	mysql_fetch_array( mysql_query("SELECT * FROM tblfacility WHERE fldFacilityName='$facy'") );
	if( $sql_values_fetch_fac['fldAutoDispatch'] == 1 )
	{
		$examDateFile = new DateTime($sql_values_fetch['fldSchDate']);
		$examDateEdit = new DateTime(str_replace("-","/",$_REQUEST['schdate12']));

		if ( $sql_values_fetch['fldDispatched'] == 0 || $examDateFile->format("m-d-Y") != $examDateEdit->format("m-d-Y") )
		{
			$dispatched = 1;
			$schDayOfWeek = $examDateEdit->format("D");
			$dateArray = array(
				'Mon'	=> 'fldTechnologist',
				'Wed'	=> 'fldTechnologist2',
				'Tue'	=> 'fldTechnologist3',
				'Thu'	=> 'fldTechnologist4',
				'Fri'	=> 'fldTechnologist5',
				'Sat'	=> 'fldTechnologist6',
				'Sun'	=> 'fldTechnologist7'
			);
			$technologist = $sql_values_fetch_fac[$dateArray[$schDayOfWeek]];
		}
	}
	
	# auto create patient ID
	if( $_REQUEST['patientid'] == '' )
	{ 
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
	
	# update the order record
	$strSQL = "UPDATE tblorderdetails SET
		fldPatientID='".strtoupper(strip_tags(addslashes($pid)))."',
		fldSchDate='".strtoupper(strip_tags(addslashes($schdate)))."',
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
		fldProcedure1='".(strip_tags(addslashes($pr1)))."',
		fldProcedure2='".(strip_tags(addslashes($pr2)))."',
		fldProcedure3='".(strip_tags(addslashes($pr3)))."',
		fldProcedure4='".(strip_tags(addslashes($pr4)))."',
		fldProcedure5='".(strip_tags(addslashes($pr5)))."',
		fldProcedure6='".(strip_tags(addslashes($pr6)))."',
		fldplr1='".(strip_tags(addslashes($pr1lr)))."',
		fldplr2='".(strip_tags(addslashes($pr2lr)))."',
		fldplr3='".(strip_tags(addslashes($pr3lr)))."',
		fldplr4='".(strip_tags(addslashes($pr4lr)))."',
		fldplr5='".(strip_tags(addslashes($pr5lr)))."',
		fldplr6='".(strip_tags(addslashes($pr6lr)))."',
		fldSymptom1='".(strip_tags(addslashes($pr1sy)))."',
		fldSymptom2='".(strip_tags(addslashes($pr2sy)))."',
		fldSymptom3='".(strip_tags(addslashes($pr3sy)))."',
		fldSymptom4='".(strip_tags(addslashes($pr4sy)))."',
		fldSymptom5='".(strip_tags(addslashes($pr5sy)))."',
		fldSymptom6='".(strip_tags(addslashes($pr6sy)))."',
		fldPatientroom='".strtoupper(strip_tags(addslashes($_REQUEST['patientroom'])))."',
		fldAfterhours='".strtoupper(strip_tags(addslashes($_REQUEST['afterhours'])))."',
		fldHistory='".strtoupper(strip_tags(addslashes($_REQUEST['history'])))."',
		fldSymptoms='".strtoupper(strip_tags(addslashes($_REQUEST['symptoms'])))."',
		fldCDRequested='".(strip_tags(addslashes($_REQUEST['cdrequested'])))."',
		fldCDAddr='".strtoupper(strip_tags(addslashes($_REQUEST['cdaddr'])))."',
		fldCDDate='".strtoupper(strip_tags(addslashes($cddate)))."',
		fldUserName='".strtoupper(strip_tags(addslashes($_SESSION['user'])))."',
		fldDispatched='".strtoupper(strip_tags(addslashes($dispatched)))."',
		fldTechnologist='".strtoupper(strip_tags(addslashes($technologist)))."',
		modified_by = '".$_SESSION['user']."',
		modified_date = '".date('Y-m-d H:i:s')."',
		fldPatNotes = '".strip_tags(addslashes($_REQUEST['patNotes']))."'
		where fldID='".$id."'");
	$sql_insert	= mysql_query($strSQL) or die ( mysql_error() );
	
	# update the related icd code record if admin/coder
	if( $sql_insert && ( $_SESSION['role'] == "admin" || $_SESSION['role'] == "coder" ) )
	{
		$strSQL = "UPDATE tblicdcodes SET
			fldProc1icd1='".(strip_tags(addslashes($pr1icd1)))."',
			fldProc1icd2='".(strip_tags(addslashes($pr1icd2)))."',
			fldProc1icd3='".(strip_tags(addslashes($pr1icd3)))."',
			fldProc1icd4='".(strip_tags(addslashes($pr1icd4)))."',
			fldProc2icd1='".(strip_tags(addslashes($pr2icd1)))."',
			fldProc2icd2='".(strip_tags(addslashes($pr2icd2)))."',
			fldProc2icd3='".(strip_tags(addslashes($pr2icd3)))."',
			fldProc2icd4='".(strip_tags(addslashes($pr2icd4)))."',
			fldProc3icd1='".(strip_tags(addslashes($pr3icd1)))."',
			fldProc3icd2='".(strip_tags(addslashes($pr3icd2)))."',
			fldProc3icd3='".(strip_tags(addslashes($pr3icd3)))."',
			fldProc3icd4='".(strip_tags(addslashes($pr3icd4)))."',
			fldProc4icd1='".(strip_tags(addslashes($pr4icd1)))."',
			fldProc4icd2='".(strip_tags(addslashes($pr4icd2)))."',
			fldProc4icd3='".(strip_tags(addslashes($pr4icd3)))."',
			fldProc4icd4='".(strip_tags(addslashes($pr4icd4)))."',
			fldProc5icd1='".(strip_tags(addslashes($pr5icd1)))."',
			fldProc5icd2='".(strip_tags(addslashes($pr5icd2)))."',
			fldProc5icd3='".(strip_tags(addslashes($pr5icd3)))."',
			fldProc5icd4='".(strip_tags(addslashes($pr5icd4)))."',
			fldProc6icd1='".(strip_tags(addslashes($pr6icd1)))."',
			fldProc6icd2='".(strip_tags(addslashes($pr6icd2)))."',
			fldProc6icd3='".(strip_tags(addslashes($pr6icd3)))."',
			fldProc6icd4='".(strip_tags(addslashes($pr6icd4)))."',
			fldProc1dig='".(strip_tags(addslashes($pr1dig)))."',
			fldProc2dig='".(strip_tags(addslashes($pr2dig)))."',
			fldProc3dig='".(strip_tags(addslashes($pr3dig)))."',
			fldProc4dig='".(strip_tags(addslashes($pr4dig)))."',
			fldProc5dig='".(strip_tags(addslashes($pr5dig)))."',
			fldProc6dig='".(strip_tags(addslashes($pr6dig)))."'
			where fldOrderid='".$id."'");
		$sql_update	= mysql_query($strSQL);
	}
	
	# Create HL7 Data
	if($sql_insert)
	{ 
		$sql_values_fetch = mysql_fetch_array( mysql_query("SELECT * FROM tblsettings") );
		$txtdest = $sql_values_fetch['flddmwl'];
		$stringData0 = "[RecordNum1] \r";
		$stringData0 .= "Patient Name = " . $_REQUEST['lastname'] . "\t^" . $_REQUEST['firstname'] . "\r";
		$stringData0 .= "Patient ID = " . $_REQUEST['patientid'] . "\r";
		$stringData0 .= "Date of Birth = " . $newdob . "\r";
		$stringData0 .= "Additional Patient History = " . $_REQUEST['history'] . "\r";
		
		$stemp = $_REQUEST['sex'];
		if ($stemp == 'male') $txtsex = 'M';
		if ($stemp == 'female') $txtsex = 'F';
		$stringData0 .= "Sex = " . $txtsex. "\r";
		
		function formatDatez($dDate)
		{
			if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
			$dNewDate = strtotime($dDate);
			return date('Ymd-His',$dNewDate);
		}

		$stringData1 = "Referring Physician = " . $ordphy . "\r";
		$stringData1 .= "Scheduled AE Station = crvan \r";

		function formatschstdate($dDate)
		{
			if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
			$dNewDate = strtotime($dDate);
			return date('Y-m-d',$dNewDate);
		}
		$schdate = date('Y-m-d',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
		$schtime = date('H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));

		$stringData2 = "Scheduled Start Date = " . $schdate . "\r";
		$stringData2 .= "Scheduled Start Time = " . $schtime . "\r";

		$dob = $_REQUEST['dob'];
		$sDate = explode('-', $dob);
		$sDate1 = $sDate[2].$sDate[0].$sDate[1];
		$hi7_dob = $sDate1;

		$hi7dest =" hi7/";
		$hi7_time =d ate("mdY",time());

		$hi7_1 = "MSH|^~\&|Ig bu|MDImaging|Test|MD Imaging|";
		$hi7_2 .= "||ORM^O01|00000";
		$hi7_2 .= $hi7_time;
		$hi7_2 .= "|P|2.3|||NE|NE" . "\r";
		$hi7_2 .= "PID|";
		$hi7_2 .= $_REQUEST['patientid'];
		$hi7_2 .= "|";
		$hi7_2 .= $_REQUEST['patientid'];
		$hi7_2 .= "|";
		$hi7_2 .= $_REQUEST['patientid'];
		$hi7_21 = $_REQUEST['lastname'] . "^" . $_REQUEST['firstname'] . "^" . $_REQUEST['middlename'] . "^" . $_REQUEST['surname'];
		$hi7_21 .= "||";
		$hi7_21 .= $hi7_dob;
		$hi7_21 .= "|";
		$hi7_21 .= $txtsex;
		$hi7_21 .= "||U|||||U|||000-00-0000" . "\r";
		$hi7_21 .= "PV1|";
		$hi7_21 .= $_REQUEST['patientid'];
		$hi7_21 .= "|O|BUF^^buffalo^MDImaging||||Referring|";
		$hi7_21 .= $ordphy . "\r";
		$hi7_21 .= "ORC|SC|";
		$hi7_3 .= "|S||^^^";
		$hi7_3 .= $hi7_time;
		$hi7_3 .= "^^N||||||||||||||MD Imaging" . "\r";
		$hi7_3 .= "OBR|1|";

		$pr1 = $_REQUEST['procedure1'];
		if($pr1)
		{
			$myFile = $txtdest . $txtid . "p1.txt";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr1'"));
			$acsno = $acsnum[1];
			
			$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " . str_replace("/","",$_REQUEST['symptoms1']) . "\r" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r";
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
			$acsno = $acsnum[2];

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
			$acsno = $acsnum[3];
			
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
	}
	$id = $txtid;
	require('fpdf/html_table.php');

	$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));
	$orddate=$sql_values_fetch['fldDate'];
	$time=date("Y-m-d H:i",time());
	function formatDate21($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('d-m-Y',$dNewDate);
	}
	function formatDate22($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('H:i',$dNewDate);
	}
	$time11=formatdate21($orddate);
	$time12=formatdate22($orddate);
	$rperson=$sql_values_fetch['fldRequestedBy'];
	$facility = $sql_values_fetch['fldFacilityName'];
	$phone=$sql_values_fetch['fldPhone'];
	$fname = $sql_values_fetch['fldFirstName'];
	$lname = $sql_values_fetch['fldLastName'];
	$mname=$sql_values_fetch['fldMiddleName'];
	$sname=$sql_values_fetch['fldSurName'];
	$patientid=$sql_values_fetch['fldPatientID'];
	$sDate1 = $sql_values_fetch['fldDOB'];
	$sDate2 = explode('-', $sDate1);
	$dob = $sDate2[1].'-'.$sDate2[2].'-'.$sDate2[0];

	$ssn=$sql_values_fetch['fldPatientSSN'];
	$gender=$sql_values_fetch['fldGender'];
	$room=$sql_values_fetch['fldPatientroom'];
	
	$urgent="No";
	if( $sql_values_fetch['fldStat']==1 ) $urgent="Yes";
	
	$afterhours="No";
	if( $sql_values_fetch['fldAfterhours'] == 1 ) $afterhours="Yes";

	$symptom1=$sql_values_fetch['fldSymptom1'];
	$symptom2=$sql_values_fetch['fldSymptom2'];
	$symptom3=$sql_values_fetch['fldSymptom3'];
	$symptom4=$sql_values_fetch['fldSymptom4'];
	$symptom5=$sql_values_fetch['fldSymptom5'];
	$symptom6=$sql_values_fetch['fldSymptom6'];
	$plr1=$sql_values_fetch['fldplr1'];
	$plr2=$sql_values_fetch['fldplr2'];
	$plr3=$sql_values_fetch['fldplr3'];
	$plr4=$sql_values_fetch['fldplr4'];
	$plr5=$sql_values_fetch['fldplr5'];
	$plr6=$sql_values_fetch['fldplr6'];
	$additionalinfo=$sql_values_fetch['fldSymptoms'];
	$history=$sql_values_fetch['fldHistory'];
	$physician=$sql_values_fetch['fldOrderingPhysicians'];
	function formatDate1a($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('m-d-Y',$dNewDate);
	}
	
	function formatDate1b($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('H:i',$dNewDate);
	}
	$schdte=$sql_values_fetch['fldSchDate'];
	$shdate=formatdate1a($schdte);
	//$sDate1 = $shdate;
	//$sDate2 = explode('-', $sDate1);
	//$shdate = $sDate2[1].'-'.$sDate2[2].'-'.$sDate2[0];

	$shtime=formatdate1b($schdte);
	$cdneeded="No";
	if($sql_values_fetch['fldCDRequested']==1)
	{
		$cdneeded="Yes";
		$cddt=$sql_values_fetch['fldCDDate'];
		$cddate=formatdate1a($cddt);
		$cdaddr=$sql_values_fetch['fldCDAddr'];
	}
	$medicare=$sql_values_fetch['fldMedicareNumber'];
	$medicaid=$sql_values_fetch['fldMedicaidNumber'];
	$state=$sql_values_fetch['fldState'];
	$inscompany=$sql_values_fetch['fldInsuranceCompanyName'];
	$relation=$sql_values_fetch['fldRelationship'];
	$addr1=$sql_values_fetch['fldPrivateAddressLine1'];
	$addr2=$sql_values_fetch['fldPrivateAddressLine2'];
	$addrcity=$sql_values_fetch['fldPrivateAddressCity'];
	$addrstate=$sql_values_fetch['fldPrivateAddressState'];
	$addrzip=$sql_values_fetch['fldPrivateAddressZip'];
	$addrph=$sql_values_fetch['fldPrivatePhoneNumber'];
	//$addrphone=substr($addrph, 0, 3)."-".substr($addrph, 3, 3)."-".substr($addrph, 6, 4);
	$addrphone=$addrph;
	$hmo_contract=$sql_values_fetch['fldHmoContract'];
	$policy=$sql_values_fetch['fldPolicy'];
	$group=$sql_values_fetch['fldGroup'];
	$verbalrep=strtoupper($sql_values_fetch['fldReportDetails']);
	$repdate=$sql_values_fetch['fldReportDate'];

	$resperson=$sql_values_fetch['fldResponsiblePerson'];
	if(!$resperson) $resperson='&nbsp;';

	function formatDate1d($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('m-d-Y H:i',$dNewDate);
	}
	$rpdate=formatdate1d($repdate);
	$repcalledto=$sql_values_fetch['fldReportCalledTo'];
	$radiologist=$sql_values_fetch['fldRadiologist'];
	$noofpatients=$sql_values_fetch['fldVerbalnoofpat'];
	$noofviews=$sql_values_fetch['fldnoofviews'];
	$examtime=$sql_values_fetch['fldExamDate'];
	function formatDate1c($dDate)
	{
		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
		$dNewDate = strtotime($dDate);
		return date('Y-m-d',$dNewDate);
	}
	$credt=$sql_values_fetch['fldDate'];
	$cretime=formatdate1c($credt);

	$proc=$sql_values_fetch['fldProcedure1'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt1=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc1=$sql_values_fetch_proc['fldDescription'];
	$proc=$sql_values_fetch['fldProcedure2'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt2=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc2=$sql_values_fetch_proc['fldDescription'];
	$proc=$sql_values_fetch['fldProcedure3'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt3=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc3=$sql_values_fetch_proc['fldDescription'];
	$proc=$sql_values_fetch['fldProcedure4'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt4=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc4=$sql_values_fetch_proc['fldDescription'];
	$proc=$sql_values_fetch['fldProcedure5'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt5=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc5=$sql_values_fetch_proc['fldDescription'];
	$proc=$sql_values_fetch['fldProcedure6'];
	$sql_values_fetch_proc =    mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$proc'"));
	$cbt6=$sql_values_fetch_proc['fldCBTCode'];
	$pdesc6=$sql_values_fetch_proc['fldDescription'];

	$sql_fac=mysql_fetch_array(mysql_query("SELECT * FROM tblfacility where fldFacilityName='$facility'"));
	$facph=$sql_fac['fldPhoneNumber'];
	$facphone=$facph;

	$sql_user=mysql_fetch_array(mysql_query("SELECT * FROM tbluser where fldRealName='$physician'"));
	$phyph=$sql_user['fldPhone'];

	$plr1=strtoupper($plr1);
	$plr2=strtoupper($plr2);
	$plr3=strtoupper($plr3);
	$plr4=strtoupper($plr4);
	$plr5=strtoupper($plr5);
	$plr6=strtoupper($plr6);
	if(!$noofviews) $noofviews='&nbsp;';
	if(!$examtime) $examtime='&nbsp;';

	if(!$phyph) $phyph='&nbsp;';
	if(!$facphone) $facphone='&nbsp;';
	if(!$time11) $time11='&nbsp;';
	if(!$time12) $time12='&nbsp;';
	if(!$rperson) $rperson='&nbsp;';
	if(!$facility ) $facility ='&nbsp;';
	if(!$phone) $phone='&nbsp;';
	if(!$patientid) $patientid='&nbsp;';
	if(!$dob) $dob='&nbsp;';
	if(!$ssn) $ssn='&nbsp;';
	if(!$gender) $gender='&nbsp;';
	if(!$room) $room='&nbsp;';
	if(!$urgent) $urgent='&nbsp;';
	if(!$afterhours) $afterhours='&nbsp;';
	if(!$plr1) $plr1='&nbsp;';
	if(!$plr2) $plr2='&nbsp;';
	if(!$plr3) $plr3='&nbsp;';
	if(!$plr4) $plr4='&nbsp;';
	if(!$plr5) $plr5='&nbsp;';
	if(!$plr6) $plr6='&nbsp;';
	if(!$physician) $physician='&nbsp;';
	if(!$shdate) $shdate='&nbsp;';
	if(!$shtime) $shtime='&nbsp;';
	if(!$cdneeded) $cdneeded='&nbsp;';
	if(!$cdaddr) $cdaddr='&nbsp;';
	if(!$medicare) $medicare='&nbsp;';
	if(!$medicaid) $medicaid='&nbsp;';
	if(!$state) $state='&nbsp;';
	if(!$inscompany) $inscompany='&nbsp;';
	if(!$relation) $relation='&nbsp;';
	if(!$addr1) $addr1='&nbsp;';
	if(!$addr2) $addr2='&nbsp;';
	if(!$addrcity) $addrcity='&nbsp;';
	if(!$addrstate) $addrstate='&nbsp;';
	if(!$addrphone) $addrphone='&nbsp;';
	if(!$hmo_contract) $hmo_contract='&nbsp;';
	if(!$policy) $policy='&nbsp;';
	if(!$group) $group='&nbsp;';
	if(!$repdate) $repdate='&nbsp;';
	if(!$rpdate) $rpdate='&nbsp;';
	if(!$repcalledto) $repcalledto='&nbsp;';
	if(!$radiologist) $radiologist='&nbsp;';
	if(!$noofpatients) $noofpatients='&nbsp;';
	if(!$cbt1) $cbt1='&nbsp;';
	if(!$pdesc1) $pdesc1='&nbsp;';
	if(!$cbt2) $cbt2='&nbsp;';
	if(!$pdesc2) $pdesc2='&nbsp;';
	if(!$cbt3) $cbt3='&nbsp;';
	if(!$pdesc3) $pdesc3='&nbsp;';
	if(!$cbt4) $cbt4='&nbsp;';
	if(!$pdesc4) $pdesc4='&nbsp;';
	if(!$cbt5) $cbt5='&nbsp;';
	if(!$pdesc5) $pdesc5='&nbsp;';
	if(!$cbt6) $cbt6='&nbsp;';
	if(!$pdesc6) $pdesc6='&nbsp;';
	if(!$noofviews) $noofviews='&nbsp;';
	if(!$examtime) $examtime='&nbsp;';


	$sDate1 = $time11;
	$sDate2 = explode('-', $sDate1);
	$dt1 = $sDate2[1].'-'.$sDate2[0].'-'.$sDate2[2];

	$pdf=new PDF();
	$pdf->AddPage();

	$html='<table border="0">
	<tr>
	<td width="50" height="30">Date :</td>
	<strong><td width="100" height="30">';
	$html.=$dt1;
	$html.='</td></strong>
	<td width="50" height="30">Time :</td>
	<strong><td width="100" height="30">';
	$html.=$time12;
	$html.='</td></strong>
	</tr>
	<tr>
	<td height="10"></td>
	</tr>
	<tr>
	<td width="55" height="30">Facility : </td>
	<strong><td width="350" height="30">';
	$html.=$facility;
	$html.='</td></strong>
	<td width="60" height="30">Contact : </td>
	<strong><td width="150" height="30">';
	$html.=$rperson;
	$html.='</td></strong>
	<td width="50" height="30">Phone : </td>
	<strong><td width="90" height="30">';
	$html.=$facphone;
	$html.='</td></strong>
	</tr>
	<tr>
	<td width="90" height="30">Patient Name : </td>
	<strong><td width="110" height="30">';
	$html.=$fname . ' ' . $mname . ' ' . $lname;
	$html.='</td></strong>
	</tr>
	<tr>
	<td width="90" height="30">Patient MR#</td>
	<strong><td width="90" height="30">';
	$html.=$patientid;
	$html.='</td></strong>
	<td width="40" height="30">DOB : </td>
	<strong><td width="150" height="30">';
	$html.=$dob;
	$html.='</td></strong>
	<td width="40" height="30">SSN# </td>
	<strong><td width="180" height="30">';
	$html.=$ssn;
	$html.='</td>
	</strong><td width="40" height="30">Sex : </td>
	<strong><td width="50" height="30">';
	$html.=strtoupper($gender);
	$html.='</td></strong>
	</tr>
	<tr>
	<td width="60" height="30">Room# </td>
	<strong><td width="80" height="30">';
	$html.=$room;
	$html.='</td></strong>
	<td width="60" height="30">Urgent? </td>
	<strong><td width="50" height="30">';
	$html.=$urgent;
	$html.='</td></strong>
	<td width="80" height="30">After hours? </td>
	<strong><td width="40" height="30">';
	$html.=$afterhours;
	$html.='</td></strong>
	<td width="120" height="30">Date Exam needed: </td>
	<strong><td width="100" height="30">';
	$html.=$shdate;
	$html.='</td></strong>
	<td width="120" height="30">Time exam needed: </td>
	<strong><td width="50" height="30">';
	$html.=$shtime;
	$html.='</td></strong>
	</tr>
	<tr>
	</tr>
	<tr>
	<td width="90" height="30">Procedure1# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc1;
	$html.='<td width="90" height="30">';
	$html.=$plr1;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom1);
	$html.='</td></strong>
	</tr>
	<td width="90" height="30">Procedure2# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc2;
	$html.='<td width="90" height="30">';
	$html.=$plr2;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom2);
	$html.='</td></strong>
	</tr>
	<td width="90" height="30">Procedure3# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc3;
	$html.='<td width="90" height="30">';
	$html.=$plr3;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom3);
	$html.='</td></strong>
	</tr>
	<td width="90" height="30">Procedure4# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc4;
	$html.='<td width="90" height="30">';
	$html.=$plr4;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom4);
	$html.='</td></strong>
	</tr>
	<td width="90" height="30">Procedure5# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc5;
	$html.='<td width="90" height="30">';
	$html.=$plr5;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom5);
	$html.='</td></strong>
	</tr>
	<td width="90" height="30">Procedure6# </td>
	<strong><td width="160" height="30">';
	$html.=$pdesc6;
	$html.='<td width="90" height="30">';
	$html.=$plr6;
	$html.='</td></strong>
	<td width="90" height="30">Symptoms: </td>
	<strong><td width="120" height="30">';
	$html.=strtoupper($symptom6);
	$html.='</td></strong>
	</tr>
	<tr>
	</tr>
	</table>';

	$html1='<table border="0">
	<tr>
	<td width="90" height="30">Ordering Dr. </td>
	<strong><td width="330" height="30">';
	$html1.=strtoupper($physician);
	$html1.='</td></strong>
	<td width="50" height="30">Phone# </td>
	<strong><td width="250" height="30">';
	$html1.=$phyph;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="90" height="30">CD Needed ? </td>
	<strong><td width="75" height="30">';
	$html1.=$cdneeded;
	if($cdneeded!='No')
	{
	$html1.='</td></strong>
	<td width="60" height="30">Location : </td>
	<strong><td width="325" height="30">';
	$html1.=$cdaddr;
	$html1.='</td></strong>
	<td width="100" height="30">Date Needed By : </td>
	<strong><td width="80" height="30">';
	$html1.=$cddate;
	}
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="90" height="30">Medicare# </td>
	<strong><td width="330" height="30">';
	$html1.=$medicare;
	$html1.='</td></strong>
	<u><strong><td width="140" height="30">Responsible Party </td></strong></u>
	</tr>
	<tr>
	<td width="90" height="30">Medicaid# </td>
	<strong><td width="180" height="30">';
	$html1.=$medicaid;
	$html1.='</td></strong>
	<td width="30" height="30">ST </td>
	<strong><td width="120" height="30">';
	$html1.=$state;
	$html1.='</td></strong>
	<td width="140" height="30">Name :</td>
	<strong><td width="120" height="30">';
	$html1.=$resperson;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="420" height="30">&nbsp;</td>
	<td width="140" height="30">Relationship :</td>
	<strong><td width="120" height="30">';
	$html1.=$relation;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="110" height="30">Supplementary Ins :</td>
	<strong><td width="310" height="30">';
	$html1.=$inscompany;
	$html1.='</td></strong>
	<td width="140" height="30">Address :</td>
	<strong><td width="120" height="30">';
	$html1.=$addr1;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="110" height="30">Policy# </td>
	<strong><td width="310" height="30">';
	$html1.=$policy;
	$html1.='</td></strong>
	<td width="140" height="30">&nbsp;</td>
	<strong><td width="120" height="30">';
	$html1.=$addr2;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="110" height="30">Group# </td>
	<strong><td width="310" height="30">';
	$html1.=$group;
	$html1.='</td></strong>
	<td width="140" height="30">&nbsp;</td>
	<strong><td width="120" height="30">';
	$html1.=$addrcity;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="110" height="30">HMO :</td>
	<strong><td width="310" height="30">';
	$html1.=$hmo_contract;
	$html1.='</td></strong>
	<td width="140" height="30">&nbsp;</td>
	<strong><td width="120" height="30">';
	$html1.=$addrstate . "," . $addrzip;
	$html1.='</td></strong>
	</tr>
	<tr>
	<td width="420" height="30">&nbsp;</td>
	<td width="140" height="30">Phone </td>
	<strong><td width="120" height="30">';
	$html1.=$addrphone;
	$html1.='</td></strong>
	</tr>
	<tr>
	</tr>
	<tr>
	<td width="560" height="30">I request that payment of authorized Medicare and/or Medigap benefits be made either to me or on my behalf to MD Imaging</td>
	</tr>
	<tr>
	<td width="560" height="30">Services and/or the interpreting physician for any services furnished me by that physician or supplier. I authorize any holder of</td>
	</tr>
	<tr>
	<td width="560" height="30">medical information about me to release to the Center for Medicare and Medicaid Services and its agents any information</td>
	</tr>
	<tr>
	<td width="560" height="30">needed to determine these benefits payable for related services.</td>
	</tr>
	<tr>
	</tr>
	<tr>
	<u><td width="300" height="30">X                                         </td></u>
	<u><td width="220" height="30">X                                         </td></u>
	</tr>
	<tr>
	<td width="300" height="30">Patient Signature</td>
	<td width="220" height="30">Nurse’s Signature (if patient unable to sign)</td>
	</tr>
	<tr>
	</tr>
	</table>';
	$html2='<table border="0">
	<tr>
	<td width="90" height="30">Time Called in :</td>
	<strong><td width="130" height="30">';
	$html2.=$rpdate;
	$html2.='</td></strong>
	<td width="110" height="30">Report Called to :</td>
	<strong><td width="110" height="30">';
	$html2.=$repcalledto;
	$html2.='</td></strong>
	<td width="120" height="30">Reading Radiologist :</td>
	<strong><td width="110" height="30">';
	$html2.=$radiologist;
	$html2.='</td></strong>
	</tr>
	<tr>
	<td width="130" height="30"># of Patients this Trip :</td>
	<strong><td width="90" height="30">';
	$html2.=$noofpatients;
	$html2.='</td></strong>
	<td width="100" height="30"># of Views Done :</td>
	<strong><td width="120" height="30">';
	$html2.=$noofviews;
	$html2.='</td></strong>
	<td width="100" height="30">Time Exam Done :</td>
	<strong><td width="50" height="30">';
	$examtm=formatdate1b($examtime);
	$html2.=$examtm;
	$html2.='</td></strong>
	</tr>
	<tr>
	</tr>
	</table>';
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(110,10,'MD Imaging, Inc.   ',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(90,10,'Phone 847-626-0800  Fax 847-626-0817',0,0,'C');
	$pdf->Ln(15);
	$pdf->SetFont('Arial','',9);
	$pdf->WriteHTML($html);
	$pdf->Cell(90,10,'Additonal patient Info');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(90,10,$additionalinfo);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(90,10,'History');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(90,10,$history);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',9);
	$pdf->WriteHTML($html1);
	$pdf->Cell(90,10,'Verbal Report');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	//new code for verbal
	function splitString($string, $amount)
	{
		$start = 0;
		$end = $amount;
		while ($end < strlen($string)+$amount)
		{
			$strArray[] = substr($string, $start, $amount);
			$start = $end;
			$end = $end + $amount;
		}
		return $strArray;
	}
	
	$len=strlen($verbalrep);
	$count=$len/100;
	$count=$count+0.5;
	$count=round($count);
	$veb = splitString($verbalrep, 100);
	for($i=0;$i<$count;$i++)
	{
		$pdf->Cell(90,10,$veb[$i]);
		$pdf->Ln(5);
	}
	//$pdf->Cell(90,10,$verbalrep);

	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->WriteHTML($html2);

	$sql_values_fetch = mysql_fetch_array(mysql_query("SELECT * FROM tblsettings"));
	$dest=$sql_values_fetch['fldPDFUnsignedOrders'];
	$filename = $dest . "u" . $cretime . $lname . $fname . "_" . $id . ".pdf";
	unlink($filename);
	$pdf->Output($filename,'F');

	$redirecturl = "index.php?pg=20";
	header("location:".$redirecturl);
	}
}
?>