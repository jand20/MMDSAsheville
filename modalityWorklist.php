<?php
require_once 'config.php';
/* The purpose of this file is to take the data from the database and create a text file to be added to the modality worklist.
 1) Pull order data from DB using orderID as a reference point
 2)	Format Data
 3) Write to text file. Filepath is determined by whereever the modality worklist text files are stored.
 */

/*The worklist text file should be formatted according to the following Windows .INI styles: 
 
[RecordNum1] 
 
Patient Name = Maximum 64 characters 
Patient ID = Maximum 64 characters 
Date of Birth = YYYY-MM-DD 
Sex = Maximum 16 characters 
Accession Number = Maximum 16 characters 
Referring Physician = Lastname^Firstname^Middlename^Prefix^Suffix (Maximum 64 characters) 
Requesting Physician = Lastname^Firstname^Middlename^Prefix^Suffix (Maximum 64 characters) 
 
Requested Procedure ID = Maximum 16 characters 
Requested Procedure Description = Maximum 64 characters 
Requested Procedure Priority = Maximum 16 characters 
 
Scheduled AE Station = Maximum 16 characters 
Modality = Maximum 16 characters 
Scheduled Start Date = YYYY-MM-DD 
Scheduled Start Time = HH:mm 
Performing Physician = Lastname^Firstname^Middlename^Prefix^Suffix (Maximum 64 characters) 
Scheduled Procedure ID = Maximum 16 characters 
Scheduled Procedure Description = Maximum 64 characters 
Scheduled Procedure Location = Maximum 16 characters 
Scheduled Procedure Pre-Medication = Maximum 64 characters 
Scheduled Procedure Contrast Agent = Maximum 64 characters 
 
Procedure Code Value = Maximum 16 characters 
Procedure Code Meaning = Maximum 64 characters 
Procedure Code Scheme = Maximum 16 characters 
Procedure Code Scheme Version = Maximum 16 characters 
 
Protocol Code Value = Maximum 16 characters 
Protocol Code Meaning = Maximum 64 characters 
Protocol Code Scheme = Maximum 16 characters 
Protocol Code Scheme Version = Maximum 16 characters
*/



function createMWL($orderId)
{
	$fileSql = "select flddmwl from tblsettings";
	if($dmwlRes = mysql_query($fileSql))
	{
		$dmwl		= mysql_fetch_assoc($dmwlRes);
		$filepath	= $dmwl['flddmwl'];
	}
	else 
	{
		echo mysql_error();
		return FALSE;
	}
	
	/*
	die('1');//*/
	$orderSql = "select * from tblorderdetails where fldid = $orderId";
	$result = mysql_query($orderSql) or die(mysql_error()." $orderSql");//sql to get order info goes here
	$orderInfo = mysql_fetch_assoc($result);//orderinfo is now an associative array
		
	//create vars
	$patientName		= $orderInfo['fldFirstName'].'^'.$orderInfo['fldLastName'].'^'.$orderInfo['fldMiddleName'].'^^'.$orderInfo['fldSurName'];
	$patientId			= $orderInfo['fldPatientID'];
	$dateOfBirth		= $orderInfo['fldDOB'];
	$sex				= $orderInfo['fldGender'];
	$referringPhysician	= $orderInfo['fldOrderingPhysicians'];
	$scheduledAEStation	= (empty($orderInfo['fldTechnologist'])?'NONE':$orderInfo['fldTechnologist']);
	$schStartDate		= $orderInfo['fldSchDate'];
	$schStartTime		= $orderInfo['fldSchTime'];
	
	//create mwl template string
	$mwlStr = "[RECORDNUM1]\r\n";
	$mwlStr .= "PATIENT NAME = \"$patientName\"\r\n";
	$mwlStr .= "PATIENT ID = \"$patientId\"\r\n";
	$mwlStr .= "DATE OF BIRTH = $dateOfBirth\r\n";
	$mwlStr .= "SEX = \"$sex\"\r\n";
	$mwlStr .= "REFERRING PHYSICIAN = \"$referringPhysician\"\r\n";
	$mwlStr .= "SCHEDULED AE STATION = \"$scheduledAEStation\"\r\n";
	$mwlStr .= "SCHEDULED START DATE = $schStartDate\r\n";
	$mwlStr .= "SCHEDULED START TIME = $schStartTime\r\n";
		
	//loop thru procedures
	for($i = 1; $i < 11; $i++)//FIXME Loop does not make additional orders for each procedure.
	{
		$mwlLoopStr = '';
		//dont do more work than you need
		//if procedure$i is blank all the following procedures are as well so... break the loop
		if(empty($orderInfo["fldProcedure$i"])) break;
		
		//get modality based on procedure 1
		$procedureSql = "select fldCBTCode, fldModality from tblproceduremanagment where fldDescription = '".$orderInfo["fldProcedure$i"]."'";
		if ($result = mysql_query($procedureSql))
		{
			$procedureRes = mysql_fetch_assoc($result);
			$modality = $procedureRes['fldModality'];
			$cptCode = $procedureRes['fldCBTCode'];
		}
		
		//if modality empty return false to denote mwl not created.
		if(empty($modality))
		{
			echo 'mod empty';
			return FALSE;//FIXME handle this more gracefully
		}
		
		//finish per procedure section of mwl entries
		$mwlLoopStr .= "MODALITY = $modality\r\n";//FIXME join procedure management table to get the correct modality or alter function to accept this as an argument
		$mwlLoopStr .= "ACCESSION NUMBER = ".$orderInfo["fldacsno$i"]."\r\n";
		$mwlLoopStr .= "ADMITTING DIAGNOSES DISCRIPTION = \"".$orderInfo["fldSymptom$i"]."\"\r\n";//symptom for this procedure (reason for study)
		$mwlLoopStr .= "REQUESTED PROCEDURE ID = $cptCode\r\n";//cptcode
		$mwlLoopStr .= "REQUESTED PROCEDURE DESCRIPTION = \"".$orderInfo["fldProcedure$i"]."\"\r\n";//procedure name
		
		$filename	= $orderId.$i.".txt";
		$filepath	= getcwd().'\txt\\'.$filename;
		
		$fileHandle = fopen($filepath, "w");
		
		if($fileHandle)
		{
			if(fwrite($fileHandle, $mwlStr.$mwlLoopStr) === FALSE)
			{
				echo "Unable to write MWL file.";
				return FALSE;
			}
		}
		else
		{
			echo "Error accessing DMWL location.";
			return FALSE;
		}
	}
	return TRUE;
}
?>
