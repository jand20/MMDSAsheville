<?php
	//ini_set('display_errors',1);
	function factoryResult($data, $result = true)
	{
		return json_encode(array(
			'data'		=> $data,
			'result'	=> $result
		));
	}

	session_start();

	//check user logged
	if(!isset($_SESSION['user']) || $_SESSION['user'] == '')
	{
		echo factoryResult('TIME_OUT');
		die;
	}

	//get info
	$role		= $_SESSION['role'];
	$userState	= $_SESSION['userState'];
	$userName	= $_SESSION['user'];
	$userId		= $_SESSION['userID'];
	$facility	= $_SESSION['facility'];

	require_once 'config.php';

	$id = mysql_real_escape_string($_REQUEST['id']);
	$action = $_REQUEST['action'];

	if($action == 'mark_completed')
	{
		$currentDateTime = getCurrentDate($role, $userState);

		//$id can be single id or string of id already for use : 1,2,3..
		$query = "UPDATE tblorderdetails
				SET fldTechComplete = 1,
					fldMarkCompletedBy = '$userName',
					fldMarkCompletedDate = '$currentDateTime'
				WHERE fldID IN ($id)";

		if(mysql_query($query))
		{
			//insert to history
			$ids  = explode(',', $id);
			$temp = array();
			foreach($ids as $id)
			{
				$temp[] = "('$id', '$userName', 'Mark Completed', '$currentDateTime')";
			}

			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ".implode(',', $temp);

			mysql_query($query);

			mysql_close();
			echo factoryResult('Mark Completed success');
			die;
		}
		else
		{
			mysql_close();
			echo factoryResult('Error '.mysql_error(), false);
			die;
		}
	}
	elseif($action == 'show_note')
	{
		$query	= "SELECT fldSymptoms FROM tblorderdetails WHERE fldID = '$id'";
		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);

		echo '<div style="width:100%; text-align:left;">';
		echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Notes</p>";
		echo "<p><b>Main notes:</b> {$row['fldSymptoms']}</p>";

		$query	= "SELECT *,
						DATE_FORMAT(created_date, '%m-%d-%Y %H:%i') AS dateMake
						FROM order_notes WHERE order_id = '$id'";
		$result = mysql_query($query);

		if(mysql_num_rows($result))
		{
			echo "<table width='100%'>
				<tr>
					<th>Notes</th>
					<th>Date</th>
					<th>By</th>
				</tr>";

			while($row = mysql_fetch_assoc($result))
			{
				echo "<tr>
						<td>{$row['notes']}</td>
						<td>{$row['dateMake']}</td>
						<td>{$row['created_by']}</td>
					</tr>";
			}

			echo '</table>';
		}

		echo '<hr/><p><b>Add new notes for order #'.$id.'</b></p>
					<p>
						<textarea style="width:400px; height:150px;" id="orderNotes"></textarea>
						<input type="hidden" value="'.$id.'" id="orderRecordId" />
					</p>
					<p><input type="button" value="Add" id="doAddOrderNotes" /></p>';

		echo '</div>';

		mysql_close();
	}
	elseif($action == 'show_completed_info')
	{
		$query	= "SELECT fldMarkCompletedBy AS userDo,
						DATE_FORMAT(fldMarkCompletedDate, '%m/%d/%Y %H:%i') AS dateDo
						FROM tblorderdetails WHERE fldID = '$id'";
		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);
		mysql_close();

		echo 'Marked completed by '.$row['userDo']. ' on '.$row['dateDo'];
	}
	elseif($action === 'batch_dispatch')
	{
		$tech = mysql_real_escape_string($_REQUEST['tech']);
		$currentDateTime = getCurrentDate($role, $userState);

		//id is a string of ids in this case, seperated with ,
		$query = "UPDATE tblorderdetails
						SET fldDispatched = '1',
							fldTechnologist = '$tech',
							fldDispatchedDate = NOW()
					WHERE fldID IN ($id)";

		if(mysql_query($query))
		{
			//insert to history
			$ids  = explode(',', $id);
			$temp = array();
			foreach($ids as $id)
			{
				$temp[] = "('$id', '$userName', 'Dispatch', '$currentDateTime')";
			}

			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ".implode(',', $temp);

			mysql_query($query);

			mysql_close();
			echo factoryResult('Records are dispatched success');
			die;
		}
		else
		{
			mysql_close();
			echo factoryResult('Error '.mysql_error(), false);
			die;
		}
	}
	elseif($action == 'statistic')
	{
		$currentDate = date('Y-m-d');

		$query	= "(SELECT COUNT(1) AS value,
						'undist_az' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 0 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'AZ' AND tblorderdetails.fldStatus = 0)

					UNION

					(SELECT COUNT(1) AS value,
						'dist_incomplete_az' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 1	AND fldTechComplete = 0 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'AZ' AND tblorderdetails.fldStatus = 0)

					UNION

					(SELECT COUNT(1) AS value,
						'dist_completed_az' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 1	AND fldTechComplete = 1 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'AZ' AND tblorderdetails.fldStatus = 0)

					UNION
						(SELECT COUNT(1) AS value,
						'canceled_az' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE DATE(fldSchDate) = '$currentDate'
							AND  tblfacility.fldAddressState = 'AZ' AND tblorderdetails.fldStatus = 1)

					UNION

					(SELECT COUNT(1) AS value,
						'undist_co' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 0 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'CO' AND tblorderdetails.fldStatus = 0)

					UNION

					(SELECT COUNT(1) AS value,
						'dist_incomplete_co' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 1	AND fldTechComplete = 0 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'CO' AND tblorderdetails.fldStatus = 0)

					UNION

					(SELECT COUNT(1) AS value,
						'dist_completed_co' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE fldDispatched = 1	AND fldTechComplete = 1 AND DATE(fldSchDate) = '$currentDate'
							AND tblfacility.fldAddressState = 'CO' AND tblorderdetails.fldStatus = 0)
					UNION
						(SELECT COUNT(1) AS value,
						'canceled_co' AS type
						FROM tblorderdetails
						INNER JOIN tblfacility
							ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
						WHERE  DATE(fldSchDate) = '$currentDate'
							AND  tblfacility.fldAddressState = 'CO' AND tblorderdetails.fldStatus = 1)

					";

		$result = mysql_query($query);
		$temp = array();
		while($row	= mysql_fetch_assoc($result))
		{
			$temp[$row['type']] = $row['value'];
		}
		mysql_close();

		echo '<div style="width:100%; text-align:left;">';
		echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Running Totals for Today's Orders</p>";

		echo "<table width='600'>
				<tr>
					<th>State</th>
					<th>Non dispatched</th>
					<th>Dispatched but incomplete</th>
					<th>Completed</th>
					<th>Canceled</th>
					<th>Total</th>
				</tr>";
		if($role == 'admin')
		{
			echo "<tr>
					<td>AZ</td>
					<td>{$temp['undist_az']}</td>
					<td>{$temp['dist_incomplete_az']}</td>
					<td>{$temp['dist_completed_az']}</td>
					<td>{$temp['canceled_az']}</td>
					<td>".($temp['undist_az'] + $temp['dist_incomplete_az'] + $temp['dist_completed_az'] + $temp['canceled_az'])."</td>
				</tr>";
			echo "<tr>
					<td>CO</td>
					<td>{$temp['undist_co']}</td>
					<td>{$temp['dist_incomplete_co']}</td>
					<td>{$temp['dist_completed_co']}</td>
					<td>{$temp['canceled_co']}</td>
					<td>".($temp['undist_co'] + $temp['dist_incomplete_co'] + $temp['dist_completed_co'] + $temp['canceled_co'])."</td>
				</tr>";

			echo "<tr>
					<td>Total</td>
					<td>".($temp['undist_az'] + $temp['undist_co'])."</td>
					<td>".($temp['dist_incomplete_az'] + $temp['dist_incomplete_co'])."</td>
					<td>".($temp['dist_completed_az'] + $temp['dist_completed_co'])."</td>
					<td>".($temp['canceled_az'] + $temp['canceled_co'])."</td>
					<td>".($temp['undist_az'] + $temp['dist_incomplete_az'] + $temp['dist_completed_az'] + $temp['canceled_az'] +
						$temp['undist_co'] + $temp['dist_incomplete_co'] + $temp['dist_completed_co'] + $temp['canceled_co'])."</td>
				</tr>";
		}
		elseif($role == 'dispatcher')
		{
			if($userState == 'AZ')
			{
				echo "<tr>
					<td>AZ</td>
					<td>{$temp['undist_az']}</td>
					<td>{$temp['dist_incomplete_az']}</td>
					<td>{$temp['dist_completed_az']}</td>
					<td>{$temp['canceled_az']}</td>
					<td>".($temp['undist_az'] + $temp['dist_incomplete_az'] + $temp['dist_completed_az'] + $temp['canceled_az'])."</td>
				</tr>";
			}
			elseif($userState == 'CO')
			{
				echo "<tr>
					<td>CO</td>
					<td>{$temp['undist_co']}</td>
					<td>{$temp['dist_incomplete_co']}</td>
					<td>{$temp['dist_completed_co']}</td>
					<td>{$temp['canceled_co']}</td>
					<td>".($temp['undist_co'] + $temp['dist_incomplete_co'] + $temp['dist_completed_co'] + $temp['canceled_co'])."</td>
				</tr>";
			}
		}

		echo "</table>";

		echo '</div>';
	}
	elseif($action == 'show_fac')
	{
		$query = "SELECT tblfacility.*,
							tblorderdetails.fldStation,
							tblstations.StationPhone,
							tblstations.StationFax,
							tblorderdetails.fldOrderType,
							tblorderdetails.fldPrivateAddressLine1,
							tblorderdetails.fldPrivateAddressLine2,
							tblorderdetails.fldPrivateAddressCity,
							tblorderdetails.fldPrivateAddressState,
							tblorderdetails.fldPrivateAddressZip
						FROM tblorderdetails
							INNER JOIN tblfacility
								ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
							LEFT JOIN tblstations
								ON tblorderdetails.fldStation = tblstations.StationName
									AND tblstations.facId = tblfacility.fldID
						WHERE tblorderdetails.fldID = '$id'";
		/**
		 * test query
		 * SELECT tblfacility.*, tblfacility.fldID,tblorderdetails.fldStation,
							tblstations.StationPhone,
							tblstations.StationFax
						FROM tblorderdetails
							INNER JOIN tblfacility
								ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
							LEFT JOIN tblstations
								ON tblorderdetails.fldStation = tblstations.StationName
								AND tblstations.facId = tblfacility.fldID
						WHERE tblorderdetails.fldID = '38909'

			-- SKILLED, BRIGHTON GARDENS SUNCITY
			SELECT fldStation, fldFacilityName FROM tblorderdetails WHERE tblorderdetails.fldID = '38909'

			-- 363
			SELECT fldID FROM tblfacility WHERE fldFacilityName = 'BRIGHTON GARDENS SUNCITY'

			-- STATION = ''
			SELECT * FROM tblstations WHERE facID = 363

			-- empty
			SELECT * FROM tblstations WHERE facID = 363 AND StationName = 'SKILLED'
		 */

		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);
		mysql_close();

		echo '<div style="width:100%; text-align:left;">';
		echo "<br/><br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Facility Info</p>";
		echo "<p><b>Facility Name:</b> {$row['fldFacilityName']}</p>";
		echo "<p><b>Facility Station:</b> {$row['fldStation']}</p>";
		echo "<p><b>Phone Number:</b> {$row['fldPhoneNumber']}</p>";
		echo "<p><b>Fax Number:</b> {$row['fldFaxNumber']}</p>";
		echo "<p><b>Station Phone:</b>{$row['StationPhone']}</p>";
		echo "<p><b>Station Fax:</b>{$row['StationFax']}</p>";

		if($row['fldOrderType'] != '3')
		{
			echo "<p><b>Address</b>:{$row['fldAddressLine1']},{$row['fldAddressLine2']}<br/>";
			echo "{$row['fldAddressCity']},{$row['fldAddressState']},{$row['fldAddressZip']}</p>";
		}
		else
		{
			echo "<p><b>Private Address</b>:{$row['fldPrivateAddressLine1']},{$row['fldPrivateAddressLine2']}<br/>";
			echo "{$row['fldPrivateAddressCity']},{$row['fldPrivateAddressState']},{$row['fldPrivateAddresszip']}</p>";
		}

		echo '</div>';
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
	elseif($action == 'do_cancel')
	{
		$notes = mysql_real_escape_string($_REQUEST['notes']);
		$currentDateTime = getCurrentDate($role, $userState);

		//id is a string of ids in this case, seperated with ,
		$query = "UPDATE tblorderdetails
					SET fldStatus = 1,
						fldCancelNotes = '$notes',
						fldCanceledBy	= '$userName',
						fldCanceledDate = '$currentDateTime'
					WHERE fldID IN ($id)";

		if(mysql_query($query))
		{
			//insert to history
			$ids  = explode(',', $id);
			$temp = array();
			foreach($ids as $id)
			{
				$temp[] = "('$id', '$userName', 'Cancel', '$currentDateTime')";
			}

			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ".implode(',', $temp);

			mysql_query($query);

			mysql_close();
			echo factoryResult('Records are canceled success');
			die;
		}
		else
		{
			mysql_close();
			echo factoryResult('Error '.mysql_error(), false);
			die;
		}
	}
	elseif($action == 'show_cancel_info')
	{
		$query	= "SELECT fldCancelNotes AS notes,
							fldCanceledBy AS canceledBy,
							DATE_FORMAT(fldCanceledDate,'%m-%d-%Y %H:%i') AS canceledOn
						FROM tblorderdetails WHERE fldID = '$id'";
		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);
		mysql_close();

		echo '<div style="width:100%; text-align:left;">';
		echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>Cancel Info</p>";
		echo "<p>Canceled by: {$row['canceledBy']}</p>";
		echo "<p>Canceled on: {$row['canceledOn']}</p>";
		echo "<p>Notes: {$row['notes']}</p>";
		echo '</div>';
	}
	elseif($action == 'do_add_notes')
	{
		$notes = mysql_real_escape_string($_REQUEST['notes']);
		$currentDateTime = getCurrentDate($role, $userState);

		//id is a string of ids in this case, seperated with ,
		$query = "INSERT INTO order_notes
					SET order_id	= '$id',
						notes		= '$notes',
						created_by	= '$userName',
						created_date= '$currentDateTime'";

		if(mysql_query($query))
		{
			mysql_close();
			echo factoryResult('Notes added success');
			die;
		}
		else
		{
			mysql_close();
			echo factoryResult('Error '.mysql_error(), false);
			die;
		}
	}
	elseif($action == 'show_history')
	{
		$query	= "SELECT	DATE_FORMAT(fldDate,'%m-%d-%Y %H:%i') AS orderDate,
							DATE_FORMAT(fldSchDate,'%m-%d-%Y') AS examDate
						FROM tblorderdetails WHERE fldID = '$id'";
		$result = mysql_query($query);
		$row	= mysql_fetch_assoc($result);

		echo '<div style="width:400px; text-align:left;">';
		echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF;text-align:center;'>History</p>";
		echo "<p><b>Order Date:</b>     {$row['orderDate']}</p>";
		echo "<p><b>Scheduled Date:</b> {$row['examDate']}</p>";

		$query	= "SELECT DATE_FORMAT(fldEventDateTime, '%m-%d-%Y %H:%i') AS eventDate,
							fldEventType AS eventType,
							flduser AS user
						FROM tblhistory WHERE fldID = '$id'";
		$result = mysql_query($query);

		if(mysql_num_rows($result))
		{
			echo "<table width='100%'>
				<tr>
					<th>Event Type</th>
					<th>Date</th>
					<th>By</th>
				</tr>";

			while($row = mysql_fetch_assoc($result))
			{
				echo "<tr>
						<td>{$row['eventType']}</td>
						<td>{$row['eventDate']}</td>
						<td>{$row['user']}</td>
					</tr>";
			}
			echo '</table>';
		}
		else
		{
			echo '<p>No event</p>';
		}

		echo '</div>';

		mysql_close();
	}
	
	elseif ($action === 'show_esign_info'){
		$query	= "SELECT fldOrderingPhysicians, fldAuthDate FROM tblorderdetails WHERE fldID = '$id'";

		//die(print_r($query,true));

		$result	= mysql_query($query);
		$row	= mysql_fetch_assoc($result);
		mysql_close();

		//die(print_r($row,true));
		echo '<div style="width:100%; text-align:left;">';
		echo "<br/><p style='font-size:16px; font-weight:bold;color:#0000FF'>E-sign Info</p>";
		echo "<p>E-signed by: {$row['fldOrderingPhysicians']}</p>";
		echo "<p>E-signed on: {$row['fldAuthDate']}</p>";
		echo '</div>';
	}
