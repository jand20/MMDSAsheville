<?php

function notifyTechnologist($tecnologistUserName, $orderID)
{
	$res = mysql_query("select fldPhone from tbluser where upper(fldUsername) = '$tecnologistUserName'");
	if (!$res)
	{
		global $_errm_;
		$_errm_ = "could not fetch the phone number";
		return false;
	}
	$res = mysql_fetch_array($res);
	$phoneNum = converPhoneNumber($res['fldPhone']);
	
	$sql = "SELECT o.fldFirstName,
					o.fldLastName,
					o.fldFacilityName,
					o.fldPatientroom,
					o.fldPrivateAddressLine1,
					o.fldPrivateAddressCity,
					o.fldPrivateAddressState,
					o.fldProcedure1,
					o.fldacsno1,
					o.fldacsno2,
					o.fldacsno3,
					o.fldacsno4,
					o.fldacsno5,
					o.fldacsno6,	
					o.fldFacPhone,
					DATE_FORMAT(o.fldSchDate,'%m-%d-%Y') AS fldSchDate,
					o.fldProcedure2,
					o.fldProcedure3,
					o.fldProcedure4,
					o.fldProcedure5,
					o.fldProcedure6,
					o.fldplr1,
					o.fldplr2,
					o.fldplr3,
					o.fldplr4,
					o.fldplr5,
					o.fldplr6,
					DATE_FORMAT(o.fldDOB,'%m-%d-%Y') AS fldDOB,
					o.fldOrderingPhysicians,
					o.fldMedicareNumber,
					f.fldaddressline1,
					f.fldaddresscity,
					o.fldstation,
					o.fldStat,
					o.fldRequestedBy
			FROM tblorderdetails AS o
				INNER JOIN tblfacility AS f ON 
					f.fldFacilityName = o.fldFacilityName
			WHERE o.fldID = '$orderID'";
			
	$res = mysql_query($sql);
	if (!$res)
	{
		global $_errm_;
		$_errm_ = "could not fetch the order details";
		return false;
	}
		
	$res = mysql_fetch_array($res);
	
	$stationInfo = "select s.* from tblstations s where s.stationname in (select o.fldstation from tblorderdetails o where o.fldid = $orderID) and s.facid in (select fldid from tblfacility where fldfacilityname = '{$res['fldFacilityName']}'";
	$stationInfo = mysql_query($stationInfo);
	$stationInfo = mysql_fetch_assoc($stationInfo);
	
	$fldFirstName  		        = $res['fldFirstName'] ;   
	$fldLastName  		        = $res['fldLastName'] ;    
	$fldFacilityName  	        = $res['fldFacilityName'] ;
	if($res['fldstation'] != '')
	{
		$fldFacilityName.= " \nStation: ".$stationInfo['StationName'];
	}
	$fldPatientroom  			= $res['fldPatientroom'] ;
	$fldPrivateAddressLine1  	= $res['fldPrivateAddressLine1'] ;
	$fldPrivateAddressCity  	= $res['fldPrivateAddressCity'] ;
	$fldPrivateAddressState  	= $res['fldPrivateAddressState'] ;	
	$fldProcedure1  	        = $res['fldProcedure1'] ; 
	$fldProcedure2  	        = $res['fldProcedure2'] ; 
	$fldProcedure3  	        = $res['fldProcedure3'] ; 
	$fldProcedure4  	        = $res['fldProcedure4'] ; 
	$fldProcedure5  	        = $res['fldProcedure5'] ; 
	$fldProcedure6  	        = $res['fldProcedure6'] ; 
	$fldplr1                    = $res['fldplr1'];        
	$fldplr2                    = $res['fldplr2'];        
	$fldplr3                    = $res['fldplr3'];        
	$fldplr4                    = $res['fldplr4'];        
	$fldplr5                    = $res['fldplr5'];        
	$fldplr6                    = $res['fldplr6'];
	$fldSchDate             	= $res['fldSchDate'];
	$fldFacPhone           		= $res['fldFacPhone'];
	if ($res['fldstation'] != '')
	{
		$fldFacPhone = ($stationInfo['StationPhone']!==''?$stationInfo['StationPhone']:$fldFacPhone/* .=' no station phone available' */);
	}
	$fldacsno1                  = $res['fldacsno1'];         
	$fldacsno2                  = $res['fldacsno2'];         
	$fldacsno3                  = $res['fldacsno3'];         
	$fldacsno4                  = $res['fldacsno4'];         
	$fldacsno5                  = $res['fldacsno5'];         
	$fldacsno6                  = $res['fldacsno6'];         
	$fldaddressline1            = $res['fldaddresscity'] ;   
	$fldMedicareNumber          = $res['fldMedicareNumber'] ;
	$fldDOB                     = $res['fldDOB'] ;           
    $fldOrderingPhysicians  	= $res['fldOrderingPhysicians'] ;
    $stat 						= $res['fldStat']?"STAT!":"";
    $contact					= $res['fldRequestedBy'];
 	

$smsText = "$stat
$fldSchDate
$fldFacilityName
$contact
$fldFacPhone
$fldFirstName $fldLastName
RM: $fldPatientroom

Exams: $fldProcedure1 $fldplr1";

if ($fldProcedure2)
	$smsText .= ', '.$fldProcedure2.' '.$fldplr2;
if ($fldProcedure3)
	$smsText .=  ', '.$fldProcedure3.' '.$fldplr3;
if ($fldProcedure4)
	$smsText .=  ', '.$fldProcedure4.' '.$fldplr4;
if ($fldProcedure5)
	$smsText .=  ', '.$fldProcedure5.' '.$fldplr5;
if ($fldProcedure6)
	$smsText .=  ', '.$fldProcedure6.' '.$fldplr6;
	
	$res = sendSMS($phoneNum, $smsText);
	if (!$res)
	{
		global $_errm_;
		$_errm_ = "Could not send the SMS: $_errm_";
		return false;
	}
	return true;
}

function sendSMS($phone, $message)
{
	$msg = $message;
	$msg = urlencode($message);
	// are we wins? I did not recieve a mesage 
	// 
	
	if (!$phone || $phone == "1")
	{
		global $_errm_;
		$_errm_ = "bad phone number: \"$phone\"";
		return false;
	}
	
	$url = "http://api.clickatell.com/http/sendmsg?user=Alamoxray&password=alamomobile1&api_id=3380514&to=$phone&text=$msg&from=19722013350&mo=1";
	//die($url);
	$f = fopen($url, 'r');
	if (!$f)
	{
		global $_errm_;
		$_errm_ = "could not open the url";
		return false;
	}
	$serverResponce = '';
	while (!feof($f))
	{
		$serverResponce .= fread($f, 10000);
	}
	if (strlen($serverResponce) == 0)
	{
		global $_errm_;
		$_errm_ = "empty server responce";
		return false;
	}
	if (strpos($serverResponce, 'ID: ') !== false)
	{
		//die($serverResponce);
		return true;
	}
	global $_errm_;
	$_errm_ = "An unknown error: $serverResponce";
	return false;
}

function converPhoneNumber($phone)
{
	$res = str_replace('(', '', $phone);
	$res = str_replace(')', '', $res);
	$res = str_replace('-', '', $res);
	$res = str_replace(' ', '', $res);
	$res = '1'.$res;
	return $res;
}

?>