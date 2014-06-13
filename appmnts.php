<?php
session_start();
include "config.php";

function DetermineAge ($YYYYMMDD_In)
{

  $yIn=substr($YYYYMMDD_In, 0, 4);
  $mIn=substr($YYYYMMDD_In, 4, 2);
  $dIn=substr($YYYYMMDD_In, 6, 2);

  $ddiff = date("d") - $dIn;
  $mdiff = date("m") - $mIn;
  $ydiff = date("Y") - $yIn;

  if ($mdiff < 0)
  {
    $ydiff--;
  } elseif ($mdiff==0)
  {
    if ($ddiff < 0)
    {
      $ydiff--;
    }
  }
  return $ydiff;
}

$dt1=$_REQUEST['dt1'];
$dt2=$_REQUEST['dt2'];
$d=$_REQUEST['d'];

$title1='Date ranges from ' . $dt1 . ' to ' . $dt2 . ' for ' . $d;


$dt1 .=" 00:00:00";
$dt2 .=" 23:59:59";


$conn = mysql_connect('localhost', $host2, '!mdi634');
mysql_select_db($table2,$conn);

$sql="select * from study where studydate>='$dt1' and studydate<='$dt2'";
$result = mysql_query($sql);

require('fpdf/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
    //Logo
    //$this->Image('logo_pb.png',10,8,33);
    //Arial bold 15
    $this->SetFont('Arial','B',12);
    //Move to the right
    $this->Cell(2);
    $this->Cell(30,10,'Column Appointments',0,0,'L');
    $this->SetFont('Arial','',5);
    $this->Cell(125);
    //$this->Cell(30,10,'aksdh',0,0,'R');
    $this->ln(5);
    $this->Cell(3);
    $this->SetFont('Arial','B',7);
    $this->Cell(30,10,'MD Imaging',0,0,'L');
    $this->ln(10);
    $this->Cell(190,0,'',1,0,'L');
    $this->ln(0);
    $this->Cell(10,10,'Time',0,0,'L');
	$this->Cell(30,10,'Patient',0,0,'L');
	$this->Cell(10);
	$this->Cell(10,10,'Chart #',0,0,'L');
	$this->Cell(5);
	$this->Cell(5,10,'Age',0,0,'L');
	$this->Cell(5);
	$this->Cell(15,10,'Home Phone',0,0,'L');
	$this->Cell(5);
	$this->Cell(20,10,'Appt Type',0,0,'L');
	$this->Cell(5);
	$this->Cell(10,10,'Column',0,0,'L');
	$this->Cell(5);
    $this->Cell(30,10,'Comments',0,0,'L');
    $this->ln(9);
    $this->Cell(190,0,'',1,0,'L');
    //Line break
    $this->Ln(2);
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->Cell(30,10,$title1,0,0,'L');


while($row = mysql_fetch_array($result)) {
$acsno=$row['accessionnum'];


$conn1 = mysql_connect('localhost', $host1, '!mdi634');
mysql_select_db($table1,$conn1);

$sql_values_fetch_ord = mysql_fetch_array(mysql_query("select * from tblorderdetails
where fldFacilityName in (select fldFacilityName from tblfacility where fldDivisionName LIKE '$d')
AND (fldacsno1 =  '$acsno' OR fldacsno2 =  '$acsno' OR fldacsno3 =  '$acsno' OR fldacsno4 =  '$acsno' OR fldacsno5 =  '$acsno' OR fldacsno6 =  '$acsno')"));


if($sql_values_fetch_ord)
{

$sql_1 = "select * from tblorderdetails where fldacsno1 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure1'];
}
}
$sql_1 = "select * from tblorderdetails where fldacsno2 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure2'];
}
}
$sql_1 = "select * from tblorderdetails where fldacsno3 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure3'];
}
}
$sql_1 = "select * from tblorderdetails where fldacsno4 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure4'];
}
}
$sql_1 = "select * from tblorderdetails where fldacsno5 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure5'];
}
}
$sql_1 = "select * from tblorderdetails where fldacsno6 =  '$acsno'";
$result_1 = mysql_query($sql_1) or die (mysql_error());
$num = mysql_num_rows($result_1);
if($num)
{
while($row_1 = mysql_fetch_array($result_1))
{
$proc= $row_1['fldProcedure6'];
}
}

$dob=strftime("%Y%m%d", strtotime($sql_values_fetch_ord['fldDOB']));
$age= DetermineAge($dob);

$pdf->Cell(10,10,strftime("%H:%M", strtotime($row['studytime'])),0,0,'L');
$pname=$sql_values_fetch_ord['fldLastName']. ',' .$sql_values_fetch_ord['fldFirstName'];
$pdf->Cell(30,10,$pname,0,0,'L');
$pdf->Cell(10);
$pdf->Cell(10,10,$sql_values_fetch_ord['fldPatientID'],0,0,'L');
$pdf->Cell(5);
$pdf->Cell(5,10,$age,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(15,10,$sql_values_fetch_ord['fldPrivatePhoneNumber'],0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,10,$proc,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(10,10,$sql_values_fetch_ord['fldTechnologist'],0,0,'L');
$pdf->Cell(5);
$ordtime='CALL  ' . strftime("%m/%d %H:%M", strtotime($sql_values_fetch_ord['fldDate']));
$pdf->Cell(30,10,$ordtime,0,0,'L');
$pdf->ln(3);
$pdf->Cell(135);
$pdf->Cell(30,10,strtoupper($sql_values_fetch_ord['fldFacilityName']),0,0,'L');
$pdf->ln(5);
}
}
$pdf->Output();
?>