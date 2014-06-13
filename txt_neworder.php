<?
$sql_values_fetch_settings = mysql_fetch_array(mysql_query("select * from tblsettings"));
$txtdest=$sql_values_fetch_settings['flddmwl'];
$sql_values_fetch_ord = mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));


$stringData0 = "[RecordNum1] \n";
$stringData0 .= "Patient Name = " . $sql_values_fetch_ord['fldLastName'] . "\t^" . $sql_values_fetch_ord['fldFirstName'] . "\n";
$stringData0 .= "Patient ID = " . $sql_values_fetch_ord['fldPatientID'] . "\n";
$stringData0 .= "Date of Birth = " . formatdatedis($sql_values_fetch_ord['fldDOB']) . "\n";
$stringData0 .= "Additional Patient History = " . $sql_values_fetch_ord['fldHistory'] . "\n";
$stemp = $sql_values_fetch_ord['fldGender'];
if ($stemp == 'male')
{
$txtsex = 'M';
}
if ($stemp == 'female')
{
$txtsex = 'F';
}

$stringData0 .= "Sex = " . $txtsex. "\n";
function formatDatez($dDate){
$dNewDate = strtotime($dDate);
return date('Ymd-His',$dNewDate);
}

$stringData1 = "Referring Physician = " . $ordphy . "\n";
$stringData1 .= "Scheduled AE Station = crvan \n";

function formatschstdate($dDate){
$dNewDate = strtotime($dDate);
return date('Y-m-d',$dNewDate);
}
function formatschsttime($dDate){
$dNewDate = strtotime($dDate);
return date('H:i',$dNewDate);
}
$schdate=formatschstdate($time);
$schtime=formatschsttime($time);
$stringData2 = "Scheduled Start Date = " . $schdate . "\n";
$stringData2 .= "Scheduled Start Time = " . $schtime . "\n";

$hi7dest="hi7/";
$hi7_time=date("mdY",time());

$hi7_1="MSH|^~\&|Ig bu|MDImaging|Test|MD Imaging|";
$hi7_2 .="||ORM^O01|00000";
$hi7_2 .=$hi7_time;
$hi7_2 .="|P|2.3|||NE|NE" . "\n";
$hi7_2 .="PID|";
$hi7_2 .=$sql_values_fetch_ord['patientid'];
$hi7_2 .="|";
$hi7_2 .=$sql_values_fetch_ord['patientid'];
$hi7_2 .="|";
$hi7_2 .=$sql_values_fetch_ord['patientid'];
$hi7_21 =$sql_values_fetch_ord['lastname'] . "^" . $sql_values_fetch_ord['firstname'] . "^" . $sql_values_fetch_ord['middlename'] . "^" . $sql_values_fetch_ord['surname'];
$hi7_21 .="||";
$hi7_21 .=$hi7_dob;
$hi7_21 .="|";
$hi7_21 .=$txtsex;
$hi7_21 .="||U|||||U|||000-00-0000" . "\n";
$hi7_21 .="PV1|";
$hi7_21 .=$sql_values_fetch_ord['patientid'];
$hi7_21 .="|O|BUF^^buffalo^MDImaging||||Referring|";
$hi7_21 .=$ordphy . "\n";
$hi7_21 .="ORC|SC|";
$hi7_3 .="|S||^^^";
$hi7_3 .=$hi7_time;
$hi7_3 .="^^N||||||||||||||MD Imaging" . "\n";
$hi7_3 .="OBR|1|";

$pr1 = $sql_values_fetch_ord['procedure1'];
if($pr1)
{
$myFile = $txtdest . $txtid . "p1.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr1'"));
$atime=date("Y-m-d H:i:s",time() + 1);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno1='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " . $sql_values_fetch_ord['symptoms1'] . "\n" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n";
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr1'] . " " . $sql_values_fetch_ord['procedure1'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-1||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr1'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr1'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms1'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr2 = $sql_values_fetch_ord['procedure2'];
if($pr2)
{
$myFile = $txtdest . $txtid . "p2.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr2'"));
$atime=date("Y-m-d H:i:s",time() + 2);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno2='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " .$sql_values_fetch_ord['symptoms2'] . "\n" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr2'] . " " . $sql_values_fetch_ord['procedure2'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-2||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr2'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr2'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms2'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr3 = $sql_values_fetch_ord['procedure3'];
if($pr3)
{
$myFile = $txtdest . $txtid . "p3.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr3'"));
$atime=date("Y-m-d H:i:s",time() + 3);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno3='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " .$sql_values_fetch_ord['symptoms3'] . "\n" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr3'] . " " . $sql_values_fetch_ord['procedure3'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-3||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr3'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr3'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms3'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr4 = $sql_values_fetch_ord['procedure4'];
if($pr4)
{
$myFile = $txtdest . $txtid . "p4.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr4'"));
$atime=date("Y-m-d H:i:s",time() + 4);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno4='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " .$sql_values_fetch_ord['symptoms4'] . "\n" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr4'] . " " . $sql_values_fetch_ord['procedure4'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-4||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr4'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr4'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms4'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr5 = $sql_values_fetch_ord['procedure5'];
if($pr5)
{
$myFile = $txtdest . $txtid . "p5.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr5'"));
$atime=date("Y-m-d H:i:s",time() + 5);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno5='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " .$sql_values_fetch_ord['symptoms5'] . "\n" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr5'] . " " . $sql_values_fetch_ord['procedure5'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-5||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr5'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr5'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms5'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr6 = $sql_values_fetch_ord['procedure6'];
if($pr6)
{
$myFile = $txtdest . $txtid . "p6.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$sql_values_fetch_mod = mysql_fetch_array(mysql_query("select * from tblproceduremanagment where fldDescription='$pr6'"));
$atime=date("Y-m-d H:i:s",time() + 6);
$acsno = formatDatez($atime);

$sql_Update	= mysql_query("update tblorderdetails set
fldacsno6='".strtoupper(strip_tags(addslashes($acsno)))."'
where fldID='".$id."'") or die (mysql_error());

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\n" . "Admitting Diagnoses Discription  = " .$sql_values_fetch_ord['symptoms6'] . "\n" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\n" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\n"  . "Requested Procedure Description = " . $sql_values_fetch_ord['plr6'] . " " . $sql_values_fetch_ord['procedure6'] . "\n";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");

$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-6||" . $hi7_21 . $acsno . "||^" . $sql_values_fetch_ord['plr6'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . $sql_values_fetch_ord['plr6'];
$hi7_txt .="|||||||||||||||||||||||||||" . $sql_values_fetch_ord['symptoms6'];

fwrite($fh, $hi6_txt);
fclose($fh);
}
?>