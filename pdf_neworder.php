<?
require_once 'config.php';
require_once 'fpdf/html_table.php';


$currentDate = date('m-d-Y');
$currentTime = date('H:i:s');

$orderSql			= "select * from tblorderdetails where fldID='$id'";
$result				= mysql_query($orderSql);

$sql_values_fetch	= mysql_fetch_array($result);

$orddate			= $sql_values_fetch['fldDate'];

$ptFirstName		= $sql_values_fetch['fldFirstName'];
$ptLastName			= $sql_values_fetch['fldLastName'];
$ptMidName			= $sql_values_fetch['fldMiddleName'];
$ptSurName			= $sql_values_fetch['fldSurName'];
$patientid			= $sql_values_fetch['fldPatientID'];

$ptDOB				= $sql_values_fetch['fldDOB'];
list($y,$m,$d,$h,$i,$s)	= preg_split('/-|:|\s/', $ptDOB);
$ptDOB				= date('m-d-Y',mktime(0,0,0,$m,$d,$y));

$facility			= (!empty($sql_values_fetch['fldLocFacName']))?$sql_values_fetch['fldLocFacName']:$sql_values_fetch['fldFacilityName'];
$orderingFac		= $sql_values_fetch['fldFacilityName'];
$requestedBy		= $sql_values_fetch['fldRequestedBy'];
$phone				= $sql_values_fetch['fldPhone'];

$ptSSN				= $sql_values_fetch['fldPatientSSN'];
$ptGender			= $sql_values_fetch['fldGender'];
$room				= $sql_values_fetch['fldPatientroom'];

$isSTAT				= ($sql_values_fetch['fldStat'] == '1')?"STAT":"normal";

$afterhours			= ($sql_values_fetch['fldAfterhours'] == '1')?"Yes":"No";

$additionalinfo		= $sql_values_fetch['fldSymptoms'];
$history			= $sql_values_fetch['fldHistory'];
$orderingDr			= $sql_values_fetch['fldOrderingPhysicians'];
$isEsigned			= ($sql_values_fetch['fldAuthorized'] === '1')?'s':'u';

$schedDate			= $sql_values_fetch['fldSchDate'];
$schedTime			= $sql_values_fetch['fldSchTime'];

$cdNeeded			= ($sql_values_fetch['fldCDRequested'] == '1')?"Yes":"No";
$cdDate				= (!empty($sql_values_fetch['fldCDDate']))?$sql_values_fetch['fldCDDate']:'';

$relationship		= $sql_values_fetch['fldRelationship'];
$privateAddress1	= $sql_values_fetch['fldPrivateAddressLine1'];
$privateAddress2	= $sql_values_fetch['fldPrivateAddressLine2'];
$paCity				= $sql_values_fetch['fldPrivateAddressCity'];
$paState			= $sql_values_fetch['fldPrivateAddressState'];
$paZipCode			= $sql_values_fetch['fldPrivateAddressZip'];
$privatePhone		= $sql_values_fetch['fldPrivatePhoneNumber'];

$medicare			= $sql_values_fetch['fldMedicareNumber'];
$medicaid			= $sql_values_fetch['fldMedicaidNumber'];
$inscompany			= $sql_values_fetch['fldInsuranceCompanyName'];
$state				= $sql_values_fetch['fldState'];
$hmoContract		= $sql_values_fetch['fldHmoContract'];
$policy				= $sql_values_fetch['fldPolicy'];
$group				= $sql_values_fetch['fldGroup'];

$responsibleParty	= (!empty($sql_values_fetch['fldResponsiblePerson']))?$sql_values_fetch['fldResponsiblePerson']:'';

$dxReportDetails	= (!empty($sql_values_fetch['fldReportDetails'])?strtoupper($sql_values_fetch['fldReportDetails']):'');
list($y,$m,$d,$h,$i,$i)	= preg_split('/-|:|\s/', $sql_values_fetch['fldReportDate']);
$reportDate			= date('m-d-Y H:i:s', mktime($h,$i,$s,$m,$d,$y));

$reportCalledTo		= $sql_values_fetch['fldReportCalledTo'];
$radiologist		= $sql_values_fetch['fldRadiologist'];
$examDT				= !empty($sql_values_fetch['fldExamDate'])?$sql_values_fetch['fldExamDate']:'';


//loop thru procedures and get info
$procedures = array();//multidimentional array containing procedure name, cpt code, l/r info, and symptom (reason for study) for each ordered procedure
for($i = 1; $i < 11; $i++)
{
	$proc		= $sql_values_fetch["fldProcedure$i"];
	
	if(empty($sql_values_fetch["fldProcedure$i"]))
	{
		break;
		//Stopped until a good spacing solution can be found
		/* $procedures[$i]['procedureName']	= "\t";
		$procedures[$i]['cpt']				= "\t";
		$procedures[$i]['lr']				= "\t";
		$procedures[$i]['symptom']			= "\t"; */
	}
	else 
	{
		$prcQuery	= "select * from tblproceduremanagment where fldDescription='$proc'";
		
		if($prcRes = mysql_query($prcQuery))
		{
			while($prcInfo = mysql_fetch_array($prcRes))
			{
				$procedures[$i]['procedureName']	= $prcInfo['fldDescription'];
				$procedures[$i]['cpt']				= $prcInfo['fldCBTCode'];
				$procedures[$i]['lr']				= $sql_values_fetch["fldplr$i"];
				$procedures[$i]['symptom']			= $sql_values_fetch["fldSymptom$i"];
			}
		}
		else
		{
			die("PDF not created for this order. Please check query:<br/>".mysql_error()."<br/>$prcQuery");
		}
	}
}

$facQuery	= "SELECT * FROM tblfacility where fldFacilityName='$facility'";
$facRes		= mysql_query($facQuery);
while($facInfo = mysql_fetch_array($facRes))
{
	$facilityPhone = $facRes['fldPhoneNumber'];
}

$drQuery			= "SELECT * FROM tbluser where fldRealName='$orderingDr'";
$drRes				= mysql_query($drQuery);
$orderingDrInfo		= mysql_fetch_array($drRes);
$orderingDrPhone	= $orderingDrInfo['fldPhone'];

$destQuery			= "select * from tblsettings";
if($destRes = mysql_query($destQuery))
{
	$sql_values_fetch	= mysql_fetch_array($destRes);
	$dest				= ($isEsigned === 'u')?$sql_values_fetch['fldPDFUnsignedOrders']:$sql_values_fetch['fldPDFSignedOrders'];
	$filename			= $dest . $isEsigned . $ptLastName . $ptFirstName . "_" . $id . ".pdf";
	//echo $filename;
}
else
{
	die("There was a database error retrieving file destination: <br/>".mysql_error()."<br/>$destQuery");
}

$pdf	= new PDF();
$pdf->AddPage();

$dtHeader	= <<<TOP
<table>
	<tr><td colspan='3'><hr>&nbsp;</hr></td></tr>
	<tr>
		<td>Date: <b>$currentDate</b></td>
		<td>Time: <strong>$currentTime</strong></td>
	</tr>
	<tr>
		<td>Ordering Facility: <strong>$orderingFac</strong></td>
		<td>Hospice: </td>
	</tr>
	<tr>
		<td>Called By: <strong>$requestedBy</strong></td>
		<td>Phone: <strong></strong></td>
	</tr>
</table>
TOP;

$html	= 
"<table>
	<tr><td colspan='3'><hr>&nbsp;</hr></td></tr>
	<tr>
		<td>Facility: <strong>$facility</strong></td>
		<td>Contact: <strong>$requestedBy</strong></td>
		<td>Phone: <strong>$facilityPhone</strong></td>
	</tr>
	<tr>
		<td>Patient Last: <strong>$ptLastName</strong></td>
		<td>Patient First: <strong>$ptFirstName</strong></td>
		<td>Patient Middle: <strong>$ptMidName</strong></td>
		<td>DOB: <strong>$ptDOB</strong></td>
		<td>Sex: <strong>$ptGender</strong></td>
	</tr>
	<tr>
		<td>Patient MR#: <strong>$patientid</strong></td>
		<td>SSN: <strong>$ptSSN</strong></td>
	</tr>
	<tr>
		<td>Room# <strong>$room</strong></td>
		<td>Procedure Priority: <strong>$isSTAT</strong></td>
		<td>After hours? <strong>$afterhours</strong></td>
		<td>Date/Time Exam needed: <strong>$schedDate $schedTime</strong></td>
	</tr>
</table>
<table>
	<tr><td colspan='3'><hr>&nbsp;</hr></td></tr>";
for($i = 1; $i < 11; $i++)
{
	if(empty($procedures[$i]))
	{
		break;
	}
	
	$html .= 
	"<tr>
		<td>Procedure #$i</td>
		<td><strong>".$procedures[$i]['procedureName']."</strong></td>
		<td><strong>".$procedures[$i]['lr']."</strong></td>
		<td>Symptoms:</td>
		<td><strong>".$procedures[$i]['symptom']."</strong></td>
	</tr>";
}

$html .=
"</table>
<table>
	<tr><td colspan='3'><hr>&nbsp;</hr></td></tr>
	<tr>
		<td>Referring Physician</td>
		<td><strong>$orderingDr</strong></td>
		<td>Phone</td>
		<td><strong>$orderingDrPhone</strong></td>
	</tr>
	<tr>
		<td>CD Requested:</td>
		<td><strong>$cdNeeded</strong></td>
		<td>Date Needed By:</td>
		<td><strong>$cdDate</strong></td>
	</tr>
	<tr>
		<td>Medicare#</td>
		<td><strong>$medicare</strong></td>
		<td><strong>Responsible Party</strong></td>
	</tr>
	<tr>
		<td>Medicaid#</td>
		<td><strong>$medicaid</strong></td>
		<td>State</td>
		<td><strong>$state</strong></td>
		<td>Responsible Party:</td>
		<strong><td>$responsibleParty</strong></td>
	</tr>
	<tr>
		<td>Relationship to Patient:</td>
		<td><strong>$relationship</strong></td>
	</tr>
	<tr>
		<td>Supplementary Insurance:</td>
		<td><strong>$inscompany</strong></td>
		<td>Address:</td>
		<td><strong>$privateAddress1</strong></td>
	</tr>
	<tr>
		<td>Policy#</td>
		<td><strong>$policy</strong></td>
		<td>&nbsp;</td>
		<td><strong>$privateAddress2</strong></td>
	</tr>
	<tr>
		<td>Group#</td>
		<td><strong>$group</strong></td>
		<td>&nbsp;</td>
		<td><strong>$paCity</strong></td>
	</tr>
	<tr>
		<td>HMO:</td>
		<td><strong>$hmoContract</strong></td>
		<td>&nbsp;</td>
		<td><strong>$paState, $paZipCode</strong></td>
	</tr>
	<tr>
		<td>Phone </td>
		<td><strong>$privatePhone</strong></td>
	</tr>
	<tr>
		<td>
			<p>
			I request that payment of authorized Medicare and/or Medigap benefits be made either to me or on my behalf to ".PAGE_TITLE."<br/>
			and/or the interpreting physician for any services furnished me by that physician or supplier. I authorize any holder of medical information<br/>
			about me to release to the Center for Medicare and Medicaid Services and its agents any information needed to determine these benefits<br/>
			payable for related services.
			</p>
		</td>
	</tr>
	<tr>
		<td><u>X                                         </u></td>
		<td><u>X                                         </u></td>
	</tr>
	<tr>
		<td>Patient Signature</td>
		<td>Technologist Signature</td>
	</tr>
	<tr>
		<td>Reading Radiologist:</td>
		<td><strong>$radiologist</strong></td>
	</tr>
	<tr>
		<td>Time Exam Done:</td>
		<td><strong>$examDT</strong></td>
	</tr>
</table>";
	
//echo "test $html";

//echo $filename;die;
//$pdf->Ln( 10 );
$pdf->SetFont( 'Arial', 'B', 20 );
$pdf->Image('images/logo.png',1,1,50);
$pdf->Ln(20);
//$pdf->Cell( 110, 10, PAGE_TITLE, 0, 0, 'C' );
$pdf->SetFont( 'Arial', 'B', 10);
$pdf->Cell( 0, 0, 'P.O. Box 3396, Edmond, Oklahoma 73093  405/330-0055', 0);
$pdf->SetFont( 'Arial', '', 8 );
$pdf->Ln(5);
$pdf->WriteHTML($dtHeader);
$pdf->WriteHTML($html);

$pdf->Output( $filename, 'F' );

/*
$pdf->Cell( 90, 10, 'Additonal patient Info' );
$pdf->Ln( 5 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 90, 10, $additionalinfo );
$pdf->Ln( 10 );
$pdf->SetFont( 'Arial', '', 9 );
$pdf->Cell( 90, 10, 'History' );
$pdf->Ln( 5 );
$pdf->SetFont( 'Arial', 'B', 9 );
$pdf->Cell( 90, 10, $history );
$pdf->Ln( 10 );
$pdf->SetFont( 'Arial', '', 9 );
//$pdf->WriteHTML( $html1 );
$pdf->Cell( 90, 10, 'Verbal Report' );
$pdf->Ln( 5 );
$pdf->SetFont( 'Arial', 'B', 9 );
// new code for verbal
function splitString($string, $amount) {
	$start	= 0;
	$end	= $amount;
	while( $end < strlen( $string ) + $amount ) {
		$strArray []	= substr( $string, $start, $amount );
		$start	= $end;
		$end	= $end + $amount;
	}
	return $strArray;
}
$len	= strlen( $dxReportDetails );
$count	= $len / 100;
$count	= $count + 0.5;
$count	= round( $count );
$veb	= splitString( $dxReportDetails, 100 );
for($i	= 0; $i < $count; $i ++) {
	$pdf->Cell( 90, 10, $veb [$i] );
	$pdf->Ln( 5 );
}
// $pdf->Cell(90,10,$dxReportDetails);
$pdf->Ln();
$pdf->SetFont( 'Arial', '', 9 );
//$pdf->WriteHTML( $html2 );
*/

?>