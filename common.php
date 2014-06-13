<?php

//----------------------
// SONIT
//function cloned code from map_process.php
function getAdditionContent($id)
{
	//			$query	= "SELECT tblorderdetails.*,
	//						DATE_FORMAT(tblorderdetails.fldDate,'%m-%d-%Y %H:%i') AS dateExam,
	//						tblfacility.fldAddressLine1,
	//						tblfacility.fldAddressLine2,
	//						tblfacility.fldAddressCity,
	//						tblfacility.fldAddressState
	//					FROM tblorderdetails
	//						INNER JOIN tblfacility
	//								ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
	//					WHERE tblorderdetails.fldID = '$id'";
	$query = "SELECT tblfacility.*,
						tblorderdetails.fldStation,
						tblstations.StationPhone,
						tblstations.StationFax,
						tblorderdetails.fldOrderType,
						tblorderdetails.fldPrivateAddressLine1,
						tblorderdetails.fldPrivateAddressLine2,
						tblorderdetails.fldPrivateAddressCity,
						tblorderdetails.fldPrivateAddressState,
						tblorderdetails.fldPrivateAddressZip,
						DATE_FORMAT(tblorderdetails.fldDate,'%m-%d-%Y %H:%i') AS dateExam,
						tblfacility.fldAddressLine1,
						tblfacility.fldAddressLine2,
						tblfacility.fldAddressCity,
						tblfacility.fldAddressState,
						tblorderdetails.fldSymptoms,
						tblorderdetails.fldLastName,
						tblorderdetails.fldFirstName,
						tblorderdetails.fldProcedure1,
						tblorderdetails.fldProcedure2,
						tblorderdetails.fldProcedure3,
						tblorderdetails.fldProcedure4,
						tblorderdetails.fldProcedure5,
						tblorderdetails.fldProcedure6,
						tblorderdetails.fldProcedure7,
						tblorderdetails.fldProcedure8,
						tblorderdetails.fldProcedure9,
						tblorderdetails.fldProcedure10
					FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						LEFT JOIN tblstations
							ON tblorderdetails.fldStation = tblstations.StationName
								AND tblstations.facId = tblfacility.fldID
					WHERE tblorderdetails.fldID = '$id'";

		//echo $query;die;

		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);

		$content = array();

		$content[] = '<div style="width:600px; text-align:left;">';
		$content[] = "<p style='font-size:16px; font-weight:bold;color:#0000FF'>Additional Details</p>";
		$content[] = "<p><b>Facility Name:</b> {$row['fldFacilityName']}</p>";
		$content[] = "<p><b>Facility Station:</b> {$row['fldStation']}</p>";
		$content[] = "<p><b>Patient Name:</b> {$row['fldLastName']} {$row['fldFirstName']} </p>";
		$content[] = "<p><b>Phone Number:</b> {$row['fldPhoneNumber']}</p>";
		$content[] = "<p><b>Fax Number:</b> {$row['fldFaxNumber']}</p>";
		$content[] = "<p><b>Station Phone:</b>{$row['StationPhone']}</p>";
		$content[] = "<p><b>Station Fax:</b>{$row['StationFax']}</p>";
		$content[] = "<p><b>Date ordered :</b> {$row['dateExam']} </p>";

		if($row['fldOrderType'] != '3')
				$address = $row['fldAddressLine1']." ".$row['fldAddressLine2']." ".$row['fldAddressCity']." ".$row['fldAddressState'];
			else
				$address = $row['fldPrivateAddressLine1']." ".$row['fldPrivateAddressLine2']." ".$row['fldPrivateAddressCity']." ".$row['fldPrivateAddressState']." ".$row['fldPrivateAddressZip'];

		$content[] = "<p><b>Address:</b> {$address}</p>";
		$content[] = "<br/>";

		$procedure = array();
		for($i = 0 ; $i <= 10 ; $i++)
		{
			if($row['fldProcedure'.$i] != '')
				$procedure[] = "<p><b>Procedure{$i}:</b> ".$row['fldProcedure'.$i]." </p>";
		}
		$procedure = implode('', $procedure);

		$content[] = "<p><b>Procedures:</b></p>";
		$content[] = "$procedure";
		$content[] = "<br/>";

		$content[] = "<p><b>Main notes:</b> {$row['fldSymptoms']}</p>";

		$query	= "SELECT *,
						DATE_FORMAT(created_date, '%m-%d-%Y %H:%i') AS dateMake
						FROM order_notes WHERE order_id = '$id'";
		$result = mysql_query($query);

		if(mysql_num_rows($result))
		{
			while($row = mysql_fetch_assoc($result))
			{
				$content[] = "<p><b>Notes:</b> {$row['notes']}</p>";
				$content[] = "<p><b>On</b> {$row['dateMake']} <b>by</b> {$row['created_by']}</p>";
				$content[] = "<br/>";
			}
		}

		$content[] = '</div>';

		return implode('', $content);
}

function getPatientInfo($id)
{
	$query = "SELECT tblorderdetails.*,
						DATE_FORMAT(fldDOB, '%m/%d/%Y') AS dateOfBirth
						FROM tblorderdetails
						WHERE tblorderdetails.fldID = '$id'";
		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);

		$orderType = array(
			'1'	=> 'NH',
			'2'	=> 'CF',
			'3'	=> 'HB',
			'4'	=> 'Lab'
		);

		$content = array();
		$content[] = '<div style="width:400px; text-align:left;">';
		$content[] = "<p style='font-size:16px; font-weight:bold;color:#0000FF'>Patient Info</p>";
		$content[] = "<p><b>Patient Name :</b> {$row['fldLastName']}, {$row['fldFirstName']}</p>";
		$content[] = "<p><b>Order Type :</b> {$orderType[$row['fldOrderType']]}</p>";
		$content[] = "<p><b>Patient SSN :</b>{$row['fldPatientSSN']}</p>";
		$content[] = "<p><b>DOB :</b> {$row['dateOfBirth']}</p>";
		$content[] = "<p><b>Gender :</b> {$row['fldGender']}</p>";
		$content[] = '</div>';

		return implode('', $content);
}

/**
 * 
 * @param string $table
 * @param string $condition
 * @param array $fields
 * @return array resulting assoc array
 */
function getDBArray($table, $condition = NULL, $fields = NULL, $safe = 1)
{
	if($safe)
	{
		$whereStr = ($condition)? mysql_real_escape_string($condition) : ''; //if conditions, sterilize and make a string else nothing
		$fieldsStr = (!empty($fields)? mysql_real_escape_string(implode(', ', $fields)):'*'); //if fields specified create string and sterilize else select *
		$tableStr = mysql_real_escape_string($table);
	}
	else 
	{
		$whereStr = $condition;
		$fieldsStr = !empty($fields)?(is_array($fields)?implode(', ', $fields):$fields):'*';
		$tableStr = $table;
	}
	
	$sql = "select $fieldsStr from $tableStr $whereStr";
	/*
	die(print_r($sql, 1));// debug*/
	$ret['error_code'] = -1;
	
	$result = mysql_query($sql);
	
	if($result && mysql_num_rows($result))
	{
		$ret = '';
		if(mysql_num_rows($result) > 1)
		{
			while($row = mysql_fetch_assoc($result))
			{
				$ret['results'][] = $row;
			}
		}
		else 
		{
			$ret['results'] = mysql_fetch_assoc($result);
		}
		
		$ret['error_code'] = 0;
	}
	
	if($ret['error_code'] < 0)
	{
		$ret['results'][] = mysql_error();
		$ret['results'][] = $sql;
	}
	
	return $ret;
}

function phoneFormatter($ph)
{
	if(strlen($ph)<1)
		return '';

	$phone = $ph;

	$newphone = preg_replace('(\D+)','',$phone);

	$result = (strlen($newphone)!= 10?false:true);

	if(!$result)
		return "Invalid Phone #";

	$pattern = '/(\d{3})(\d{3})(\d{4})/';

	$replacement = '($1) $2-$3';

	$limit = -1;

	$count;

	$formattedPhone = preg_replace($pattern,$replacement, $newphone, $limit, $count);

	$result = (strlen($formattedPhone) == 14)?true:false;

	if($result)
		return $formattedPhone;
	else
		return "Invalid Phone #";
}