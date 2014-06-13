<?php session_start();

include "config.php";
$id = "8";
require('fpdf/html_table.php');

$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));
$orddate=$sql_values_fetch['fldDate'];
$time=date("Y-m-d H:i",time());
function formatDate21($dDate){
$dNewDate = strtotime($dDate);
return date('d-m-Y',$dNewDate);
}
function formatDate22($dDate){
$dNewDate = strtotime($dDate);
return date('H:i',$dNewDate);
}
$time11=formatdate21($orddate);
$time12=formatdate22($orddate);
$rperson=$sql_values_fetch['fldResponsiblePerson'];
$facility = $sql_values_fetch['fldFacilityName'];
$phone=$sql_values_fetch['fldPhone'];
$fname = $sql_values_fetch['fldFirstName'];
$lname = $sql_values_fetch['fldLastName'];
$mname=$sql_values_fetch['fldMiddleName'];
$sname=$sql_values_fetch['fldSurName'];
$patientid=$sql_values_fetch['fldPatientID'];
$sDate1 = $sql_values_fetch['fldDOB'];
$sDate2 = split('-', $sDate1);
$dob = $sDate2[1].'-'.$sDate2[2].'-'.$sDate2[0];

$ssn=$sql_values_fetch['fldPatientSSN'];
$gender=$sql_values_fetch['fldGender'];
$room=$sql_values_fetch['fldPatientroom'];
$urgent="No";
if($sql_values_fetch['fldStat']==1)
{
$urgent="Yes";
}
$afterhours="No";
if($sql_values_fetch['fldAfterhours']==1)
{
$afterhours="Yes";
}
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


function formatDate1a($dDate){
if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') {
    return '';
}
$dNewDate = strtotime($dDate);
return date('m-d-Y',$dNewDate);
}


function formatDate1b($dDate){
if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') {
    return '';
}
$dNewDate = strtotime($dDate);
return ':'.date('H:i',$dNewDate);
}
$schdte=$sql_values_fetch['fldSchDate'];
$shdate=formatdate1a($schdte);
//$sDate1 = $shdate;
//$sDate2 = split('-', $sDate1);
//$shdate = $sDate2[1].'-'.$sDate2[2].'-'.$sDate2[0];

$shtime=formatdate1b($schdte);
$cdneeded="No";
if($sql_values_fetch['fldCDRequested']==1)
{
$cdneeded="Yes";
}
$cdaddr=$sql_values_fetch['fldCDAddr'];
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
$verbalrep=$sql_values_fetch['fldReportDetails'];
$repdate=$sql_values_fetch['fldReportDate'];
$rpdate=formatdate1a($repdate);
$rptime=formatdate1b($repdate);
$repcalledto=$sql_values_fetch['fldReportCalledTo'];
$radiologist=$sql_values_fetch['fldRadiologist'];
$noofpatients=$sql_values_fetch['fldVerbalnoofpat'];
$noofviews=$sql_values_fetch['fldnoofviews'];
$examtime=$sql_values_fetch['fldExamDate'];
$cddt=$sql_values_fetch['fldCDDate'];
$cddate=formatdate1a($cddt);



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

if(!$noofviews) $noofviews='&nbsp;';
if(!$examtime) $examtime='&nbsp;';

if(!$phyph) $phyph='&nbsp;';
if(!$facphone) $facphone='&nbsp;';
if(!$time11) $time11='&nbsp;';
if(!$time12) $time12='&nbsp;';
if(!$rperson) $rperson='&nbsp;';
if(!$facility ) $facility ='&nbsp;';
if(!$phone) $phone='&nbsp;';
if(!$fname ) $fname ='&nbsp;';
if(!$patientid) $patientid='&nbsp;';
if(!$dob) $dob='&nbsp;';
if(!$ssn) $ssn='&nbsp;';
if(!$gender) $gender='&nbsp;';
if(!$room) $room='&nbsp;';
if(!$urgent) $urgent='&nbsp;';
if(!$afterhours) $afterhours='&nbsp;';
if(!$symptom1) $symptom1='&nbsp;';
if(!$symptom2) $symptom2='&nbsp;';
if(!$symptom3) $symptom3='&nbsp;';
if(!$symptom4) $symptom4='&nbsp;';
if(!$symptom5) $symptom5='&nbsp;';
if(!$symptom6) $symptom6='&nbsp;';
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
if(!$addrzip) $addrzip='&nbsp;';
if(!$addrphone) $addrphone='&nbsp;';
if(!$hmo_contract) $hmo_contract='&nbsp;';
if(!$policy) $policy='&nbsp;';
if(!$group) $group='&nbsp;';
if(!$repdate) $repdate='&nbsp;';
if(!$rpdate) $rpdate='&nbsp;';
if(!$rptime) $rptime='';
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
$sDate2 = split('-', $sDate1);
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
<td width="60" height="30">Contact : </td>
<strong><td width="220" height="30">';
$html.=$rperson;
$html.='</td></strong>
<td width="55" height="30">Facility : </td>
<strong><td width="255" height="30">';
$html.=$facility;
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
$html.=$symptom1;
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
$html.=$symptom2;
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
$html.=$symptom3;
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
$html.=$symptom4;
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
$html.=$symptom5;
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
$html.=$symptom6;
$html.='</td></strong>
</tr>
<tr>
</tr>
</table>';

$html1='<table border="0">
<tr>
<td width="90" height="30">Ordering Dr. </td>
<strong><td width="330" height="30">';
$html1.=$physician;
$html1.='</td></strong>
<td width="50" height="30">Phone# </td>
<strong><td width="250" height="30">';
$html1.=$phyph;
$html1.='</td></strong>
</tr>
<tr>
<td width="90" height="30">CD Needed ? </td>
<strong><td width="100" height="30">';
$html1.=$cdneeded;
if($cdneeded!='No')
{
$html1.='</td></strong>
<td width="60" height="30">Location : </td>
<strong><td width="170" height="30">';
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
$html1.=$rperson;
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
<td width="560" height="30">I request that payment of authorized Medicare and/or Medigap benefits be made either to me or </td>
</tr>
<tr>
<td width="560" height="30">on my behalf to Pacific Mobile Diagnostics and/or the interpreting physician for any services </td>
</tr>
<tr>
<td width="560" height="30">furnished me by that physician or supplier. I authorize any holder of medical information about </td>
</tr>
<tr>
<td width="560" height="30">me to release to the Center for Medicare and Medicaid Services and its agents any information </td>
</tr>
<tr>
<td width="560" height="30">needed to determine these benefits payable for related services.</td>
</tr>
<tr>
</tr>
<tr>
<u><td width="300" height="30">X                             </td></u>
<u><td width="220" height="30">X                             </td></u>
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
$html2.=$rpdate . $rptime;
$html2.='</td></strong>
<td width="110" height="30">Report Called to :</td>
<strong><td width="110" height="30">';
$html2.=$repcalledto;
$html2.='</td></strong>
<td width="110" height="30">Reading Radiologist :</td>
<strong><td width="110" height="30">';
$html2.=$radiologist;
$noofpatients="10";
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
$html2.=$examtime;
$html2.='</td></strong>
</tr>
<tr>
</tr>
</table>';
$verbalrep="hdfdklhgklhdfbdbvmbxcmvb kzhvkhkzj dzkvhjkzhvjk zhvkjhjkcxh zcxvhjklhxzklcv zcvjkhvbklc zkchvbklhkzcvhbkl sjdfhjkshf jkashdkjhkjhjkcsa";

function splitString($string, $amount)
{
$start = 0;
$end = $amount;
while ($end < strlen($string)+$amount) //while $end is less than the length of $string + $amount to make sure it gets is all
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
$verb = splitString($verbalrep, 100); //$return = the array of 10 letter strings

$pdf->Ln(10);
$pdf->SetFont('Arial','B',20);
$pdf->Cell(110,10,'Pacific Mobile Diagnostics, Inc.   ',0,0,'C');
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
$pdf->Ln(10);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,10,'History');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(90,10,$history);
$pdf->Ln(15);
$pdf->SetFont('Arial','',9);
$pdf->WriteHTML($html1);
$pdf->Cell(90,10,'Verbal Report');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(90,10,$count);
$pdf->Ln();
$pdf->Cell(90,10,$verb[1]);
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->WriteHTML($html2);


//$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblsettings"));
//$dest=$sql_values_fetch['fldPDFUnsignedOrders'];
//$filename = "test.pdf";
$pdf->Output($filename,'I');
?>