<?php
ini_set('display_errors',1);
set_time_limit(0);
ini_set('memory_limit',-1);

//all mysql setting put in this file
//please use your config.php file
include 'config.php';

//must have this file
require_once 'division_config.php';

//color for row shaded
define('FILL_COLOR_SHADED','CCCCCC');

//include PHPExcel library
require_once 'PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("SonIT")
							 ->setLastModifiedBy("SonIT")
							 ->setTitle("Call report")
							 ->setSubject("Call report")
							 ->setDescription("Call report")
							 ->setKeywords("Call report")
							 ->setCategory("Call report");
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0);

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
						->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                        ->setHorizontalCentered(true);

$sheet->getHeaderFooter()->setAlignWithMargins(true);

$pageMargins = $sheet->getPageMargins();
$margin = 0.1;
$pageMargins->setLeft($margin);
$pageMargins->setRight($margin);
$pageMargins->setTop(0.1);
$pageMargins->setBottom(0.7);


//build conditions
$where = array();

if(isset($_POST['division']) && $_POST['division'] != '')
{
	$divisionList = $_POST['division'];
	$childWhere = array();
	foreach($divisionList as $division)
	{
		$childWhere[] = "tblfacility.fldDivisionName = '".mysql_real_escape_string($division)."'";
	}
	$where[] = '('.implode(' OR ', $childWhere).')';
}

if(isset($_POST['state']) && $_POST['state'] != '')
{
	$where[] = "tblfacility.fldAddressState = '".  mysql_real_escape_string($_POST['state'])."'";
}

//fromDate
if($_POST['fromDate'] != '')
{
	$fromDate	= date("Y-m-d", strtotime($_POST['fromDate']));
	$where[]	= "DATE(tblorderdetails.fldSchDate) >= '$fromDate'";
}

//toDate
if($_POST['toDate'] != '')
{
	$toDate		= date("Y-m-d", strtotime($_POST['toDate']));
	$where[]	= "DATE(tblorderdetails.fldSchDate) <= '$toDate'";
}

//modality
if(isset($_POST['modality']) && $_POST['modality'] != '')
{
	$modality = mysql_real_escape_string($_POST['modality']);
	$childQuery = "SELECT DISTINCT(fldDescription) FROM tblproceduremanagment WHERE fldModality = '$modality'";

	$childWhere = array();
	for($i = 1; $i <= 10 ;$i++)
	{
		$childWhere[] = "tblorderdetails.fldProcedure{$i} IN ($childQuery)";
	}

	$where[] = '('.implode(' OR ', $childWhere).')';
}

//exclude cancel
$where[] = 'tblorderdetails.fldStatus <> 1';


//build where
if(!empty($where))
{
	$where = "WHERE " .implode(" AND " ,$where);
}
else
{
	$where = '';
}

$query = "SELECT tblorderdetails.*,
					DATE_FORMAT(tblorderdetails.fldSchDate,'%m-%d-%Y') as dateCreate,
					DATE_FORMAT(tblorderdetails.fldMarkCompletedDate,'%m-%d-%Y %H:%i') as completeDate
		FROM tblorderdetails
			INNER JOIN tblfacility
					ON tblfacility.fldFacilityName = tblorderdetails.fldFacilityName
		$where
		ORDER BY tblorderdetails.fldLastName";

//echo $query;die;

$result     = mysql_query($query);
$rowSub = 0;
if(mysql_num_rows($result) > 0)
{
	$rowSub ++;
	$sheet->mergeCells('A'.$rowSub.':J'.$rowSub);
	$sheet->getRowDimension($rowSub)->setRowHeight(30);
	$sheet->setCellValue('A'.$rowSub, "Daily Report");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->getStyle('A'.$rowSub)->getFont()->setSize(18);
	$sheet->getStyle('A'.$rowSub)->getFont()->setBold(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setWrapText(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$rowSub ++;
	$sheet->setCellValue('A'.$rowSub, "From Date");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->mergeCells('B'.$rowSub.':F'.$rowSub);
	$sheet->setCellValue('B'.$rowSub, $_POST['fromDate']);

	$rowSub ++;
	$sheet->setCellValue('A'.$rowSub, "To Date");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->mergeCells('B'.$rowSub.':F'.$rowSub);
	$sheet->setCellValue('B'.$rowSub, $_POST['toDate']);

	$rowSub ++;
	$sheet->setCellValue('A'.$rowSub, "State");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->mergeCells('B'.$rowSub.':F'.$rowSub);
	$sheet->setCellValue('B'.$rowSub, ($_POST['state'] == '' ? 'All' : $_POST['state']));

	$rowSub ++;
	$sheet->setCellValue('A'.$rowSub, "Division");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->mergeCells('B'.$rowSub.':F'.$rowSub);
	$sheet->setCellValue('B'.$rowSub, (count($_POST['division']) == 0 ? 'All' : implode(",", $_POST['division'])));
	$sheet->getStyle('B'.$rowSub)->getAlignment()->setWrapText(true);

	$rowSub ++;
	$sheet->setCellValue('A'.$rowSub, "Modality");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->mergeCells('B'.$rowSub.':F'.$rowSub);
	$sheet->setCellValue('B'.$rowSub, ($_POST['modality'] == '' ? 'All' : $_POST['modality']));
	$sheet->getStyle('B'.$rowSub)->getAlignment()->setWrapText(true);

	$rowSub++;
	$borderArray = array('borders' => array(
												'left' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'right' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'top' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'bottom' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN
												),
												'inside' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN
												)

											)
	);

	$alignArray = array('alignment' => array(
							'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'wrap'          => true
						 ));
	$leftAlignArray = array('alignment' => array(
							'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'wrap'          => true
						 ));
	$fontArray	= array('font'	=> array(
			'bold'  => true,
			'size'	=> 12
	));

	$fillArray	= array('fill'	=> array(
        'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => FILL_COLOR_SHADED),
        'endcolor'   => array('rgb' => FILL_COLOR_SHADED)
	));

	//headers
	$rowSub++;
	$sheet->getStyle('A'.$rowSub.':J'.$rowSub)->applyFromArray(array_merge($borderArray,$alignArray,$fontArray));
	$sheet->setCellValue('A'.$rowSub, "Date Requested");
	$sheet->setCellValue('B'.$rowSub, "Patient Name");
	$sheet->setCellValue('C'.$rowSub, "Facility");
	$sheet->setCellValue('D'.$rowSub, "Exam(s)");
	$sheet->setCellValue('E'.$rowSub, "Tech");
	$sheet->setCellValue('F'.$rowSub, "DOS");//fldMarkCompletedDate
	$sheet->setCellValue('G'.$rowSub, "Stat");//fldMarkCompletedDate
	$sheet->setCellValue('H'.$rowSub, "Weekend");//fldMarkCompletedDate
	$sheet->setCellValue('I'.$rowSub, "Repeat");
	$sheet->setCellValue('J'.$rowSub, "Testing Lab");

	$sheet->getColumnDimension('A')->setWidth(10);
	$sheet->getColumnDimension('B')->setWidth(20);
	$sheet->getColumnDimension('C')->setWidth(20);
	$sheet->getColumnDimension('D')->setWidth(16);
	$sheet->getColumnDimension('E')->setWidth(15);
	$sheet->getColumnDimension('F')->setWidth(15);
	$sheet->getColumnDimension('G')->setWidth(15);
	$sheet->getColumnDimension('H')->setWidth(15);
	$sheet->getColumnDimension('I')->setWidth(15);
	$sheet->getColumnDimension('J')->setWidth(15);

	$fontArray	= array('font'	=> array(
			'size'	=> 10
	));

	$rowSub++;
	while(($row  = mysql_fetch_assoc($result)))
	{

		$sheet->setCellValue('A'.$rowSub, $row['dateCreate']);
		$sheet->setCellValue('B'.$rowSub, $row['fldLastName'].' '.$row['fldFirstName']);
		$sheet->setCellValue('C'.$rowSub, $row['fldFacilityName']);

		$produce = array();
		for($i = 1; $i <= 10 ;$i++)
		{
			if($row['fldProcedure'.$i] != '') $produce[] = $row['fldProcedure'.$i];
		}
		$produce = implode("\n", $produce);
		$sheet->setCellValue('D'.$rowSub, $produce);

		$sheet->setCellValue('E'.$rowSub, $row['fldTechnologist']);
		$sheet->setCellValue('F'.$rowSub, $row['completeDate']);

		$sheet->setCellValue('G'.$rowSub, ($row['fldStat'] == 1 ? 'Yes' : ''));
		$sheet->setCellValue('H'.$rowSub, ($row['fldAfterHours'] == 1 ? 'Yes' : ''));
		$sheet->setCellValue('I'.$rowSub, ($row['fldrepeatreason1'] != '' ? 'Yes' : ''));
		$sheet->setCellValue('J'.$rowSub, $row['labSentTo']);

		$sheet->getStyle('A'.$rowSub.':J'.$rowSub)->applyFromArray(array_merge($borderArray,$leftAlignArray,$fontArray));

		$sheet->getStyle('G'.$rowSub)->applyFromArray($alignArray);
		$sheet->getStyle('H'.$rowSub)->applyFromArray($alignArray);

		if($rowSub % 2 != 0)
		{
			$sheet->getStyle('A'.$rowSub.':J'.$rowSub)->applyFromArray($fillArray);
		}

		$rowSub++;
	}//while
}
else
{
	$rowSub++;
	$sheet->mergeCells('A'.$rowSub.':J'.$rowSub);
	$sheet->setCellValue('A'.$rowSub,"No Facility found based conditions given");
	$sheet->getStyle('A'.$rowSub)->getFont()->setSize(13);
	$sheet->getStyle('A'.$rowSub)->getFont()->setBold(true);
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED );
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setWrapText(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
}

$filename = 'Daily_report.xls';

// Redirect output to a client web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;




