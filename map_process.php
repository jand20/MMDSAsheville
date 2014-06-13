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
		require_once 'common.php';

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
				$currentDateTime = getCurrentDate($role, $userState);

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
			echo getAdditionContent($id);
			mysql_close();
		}
		elseif($action == 'show_patient')
		{
			echo getPatientInfo($id);
			mysql_close();
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