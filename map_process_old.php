<?php

try
{
	if(isset($_REQUEST['id']))
	{
		session_start();

		//check user logged
		if(!isset($_SESSION['user']) || $_SESSION['user'] == '')
		{
			echo json_encode(array(
					'result'	=> true,
					'data'		=> 'TIME_OUT'
				));
			die;
		}

		//get info
		$role		= $_SESSION['role'];
		$userState	= $_SESSION['userState'];
		$userName	= $_SESSION['user'];
		$userId		= $_SESSION['userID'];
		$facility	= $_SESSION['facility'];

		require_once 'config.php';

		$id	= mysql_real_escape_string($_REQUEST['id']);
		$action		= $_REQUEST['action'];

		if($action == 'do_dispatch')
		{

			$status		= $_POST['status'];
			$tech		= $_POST['tech'];

			if($_POST['status'] == '1')
			{
				$query = "UPDATE tblorderdetails
							SET fldDispatched = '$status',
								fldTechnologist = '$tech'
						WHERE fldID = '$id'";

				$message = 'Record dispatched success';
				$event	 = 'Dispatch';
			}
			else
			{
				$query = "UPDATE tblorderdetails
							SET fldDispatched = '$status', fldExamDate = '',fldTechnologist = '', fldTechComplete = 0
						WHERE fldID = '$id'";

				$message = 'Record undispatched success';
				$event	 = 'Undispatch';
			}

			if(mysql_query($query))
			{
				$currentDateTime = date('Y-m-d H:i:s');
				
				//insert to history
				$ids  = explode(',', $id);
				$temp = array();
				foreach($ids as $id)
				{
					$temp[] = "('$id', '$userName', '$event', '$currentDateTime')";
				}

				$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ".implode(',', $temp);

				mysql_query($query);

				echo json_encode(array(
					'result'	=> true,
					'data'		=> $message
				));
			}
			else
			{
				echo json_encode(array(
					'result'	=> false,
					'data'		=> 'Query error :'.$query
				));
			}

			mysql_close();
		}
		elseif($action == 'show_additional_details')
		{
//			$query	= "SELECT tblorderdetails.*,
//								DATE_FORMAT(tblorderdetails.fldDate,'%m-%d-%Y %H:%i') AS dateExam,
//								tblfacility.fldAddressLine1,
//								tblfacility.fldAddressLine2,
//								tblfacility.fldAddressCity,
//								tblfacility.fldAddressState
//							FROM tblorderdetails
//								INNER JOIN tblfacility
//										ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
//							WHERE tblorderdetails.fldID = '$id'";

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

			echo '<div style="width:100%; text-align:left;">';
			echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Additional Details</p>";
			echo "<p><b>Facility Name:</b> {$row['fldFacilityName']}</p>";
			echo "<p><b>Facility Station:</b> {$row['fldStation']}</p>";
			echo "<p><b>Patient Name:</b> {$row['fldLastName']} {$row['fldFirstName']} </p>";
			echo "<p><b>Phone Number:</b> {$row['fldPhoneNumber']}</p>";
			echo "<p><b>Fax Number:</b> {$row['fldFaxNumber']}</p>";
			echo "<p><b>Station Phone:</b>{$row['StationPhone']}</p>";
			echo "<p><b>Station Fax:</b>{$row['StationFax']}</p>";
			echo "<p><b>Date ordered :</b> {$row['dateExam']} </p>";

			if($row['fldOrderType'] != '3')
					$address = $row['fldAddressLine1']." ".$row['fldAddressLine2']." ".$row['fldAddressCity']." ".$row['fldAddressState'];
				else
					$address = $row['fldPrivateAddressLine1']." ".$row['fldPrivateAddressLine2']." ".$row['fldPrivateAddressCity']." ".$row['fldPrivateAddressState']." ".$row['fldPrivateAddressZip'];

			echo "<p><b>Address:</b> {$address}</p>";
			echo "<br/>";

			$procedure = array();
			for($i = 0 ; $i <= 10 ; $i++)
			{
				if($row['fldProcedure'.$i] != '')
					$procedure[] = "<p><b>Procedure{$i}:</b> ".$row['fldProcedure'.$i]." </p>";
			}
			$procedure = implode('', $procedure);

			echo "<p><b>Procedures:</b></p>";
			echo "$procedure";
			echo "<br/>";

			echo "<p><b>Main notes:</b> {$row['fldSymptoms']}</p>";

			$query	= "SELECT *,
							DATE_FORMAT(created_date, '%m-%d-%Y %H:%i') AS dateMake
							FROM order_notes WHERE order_id = '$id'";
			$result = mysql_query($query);

			if(mysql_num_rows($result))
			{
				while($row = mysql_fetch_assoc($result))
				{
					echo "<p><b>Notes:</b> {$row['notes']}</p>";
					echo "<p><b>On</b> {$row['dateMake']} <b>by</b> {$row['created_by']}</p>";
					echo "<br/>";
				}
			}

			echo '</div>';

			mysql_close();
		}
		elseif($action == 'show_patient')
		{
			$query = "SELECT tblorderdetails.*,
							DATE_FORMAT(fldDOB, '%m/%d/%Y') AS dateOfBirth
							FROM tblorderdetails
							WHERE tblorderdetails.fldID = '$id'";
			$result = mysql_query($query);
			$row	= mysql_fetch_assoc($result);
			mysql_close();

			$orderType = array(
				'1'	=> 'NH',
				'2'	=> 'CF',
				'3'	=> 'HB',
				'4'	=> 'Lab'
			);

			echo '<div style="width:100%; text-align:left;">';
			echo "<br/><br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Patient Info</p>";
			echo "<p>{$row['fldLastName']}, {$row['fldFirstName']}</p>";
			echo "<p>{$orderType[$row['fldOrderType']]}</p>";
			echo "<p>{$row['fldPatientSSN']}</p>";
			echo "<p>{$row['dateOfBirth']}</p>";
			echo "<p>{$row['fldGender']}</p>";
			echo '</div>';
		}
	}
}
catch (Exception $e)
{
	echo json_encode(array(
		'result'	=> false,
		'data'		=> 'Database error'
	));
}