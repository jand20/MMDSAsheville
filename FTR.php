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

//get params
$division   = $_GET['division'];
$xday		= intval($_GET['xday']);


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

//file name
if($division == '-1')
{
	$filename	= 'Facility_Tracking_Report_All_Division_noordersfor_'.$xday.'days.xls';
	$sheet->getHeaderFooter()->setOddFooter("&L&BFacility Tracking Report \n".'&L&BAll Division no orders for '.$xday.'days '.'&RPage &P of &N');
}
else
{
	$filename	= "Facility_Tracking_Report_".$division.'_previous_'.$xday.'days.xls';
	$sheet->getHeaderFooter()->setOddFooter("&L&BFacility Tracking Report \n".'&L&B' .$division.' no orders for '.$xday.'days '.'&RPage &P of &N');
}

$pageMargins = $sheet->getPageMargins();
$margin = 0.1;
$pageMargins->setLeft($margin);
$pageMargins->setRight($margin);
$pageMargins->setTop(0.1);
$pageMargins->setBottom(0.7);

//get previous date
$checkDate = date('Y-m-d',  strtotime(' -'.$xday.' days'));

if($division == '-1')
{
	$query = "	SELECT temp1.*
				FROM
				(SELECT tblfacility.fldFacilityName, DATE_FORMAT(temp.lastOrder,'%m-%d-%Y') AS lastOrder, temp.dateRange
				FROM tblfacility
				LEFT JOIN
					(SELECT fldFacilityName, max(fldSchDate) AS lastOrder, DATEDIFF(max(fldSchDate),'$checkDate') AS dateRange
					FROM tblorderdetails
					GROUP BY fldFacilityName) AS temp
				ON tblfacility.fldFacilityName = temp.fldFacilityName) AS temp1
				HAVING dateRange < 0 or dateRange IS NULL
				ORDER BY fldFacilityName ";
	$division = 'All Division';
}
else
{
	$temp_divison = mysql_real_escape_string($division);
	$query = "	SELECT temp1.*
				FROM
				(SELECT tblfacility.fldFacilityName, DATE_FORMAT(temp.lastOrder,'%m-%d-%Y') AS lastOrder, temp.dateRange
				FROM tblfacility
				LEFT JOIN
					(SELECT fldFacilityName, max(fldSchDate) AS lastOrder, DATEDIFF(max(fldSchDate),'$checkDate') AS dateRange
					FROM tblorderdetails
					GROUP BY fldFacilityName) AS temp
				ON tblfacility.fldFacilityName = temp.fldFacilityName
				WHERE tblfacility.fldDivisionName LIKE '%$temp_divison%') AS temp1
				HAVING dateRange < 0 or dateRange IS NULL
				ORDER BY fldFacilityName ";
}


$result     = mysql_query($query);
$rowSub = 0;
if(mysql_num_rows($result) > 0)
{
	$rowSub ++;
	$sheet->mergeCells('A'.$rowSub.':C'.$rowSub);
	$sheet->getRowDimension($rowSub)->setRowHeight(30);
	$sheet->setCellValue('A'.$rowSub, "Facility Orders Tracking Report");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->getStyle('A'.$rowSub)->getFont()->setSize(18);
	$sheet->getStyle('A'.$rowSub)->getFont()->setBold(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setWrapText(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$rowSub ++;
	$sheet->mergeCells('A'.$rowSub.':C'.$rowSub);
	$sheet->getRowDimension($rowSub)->setRowHeight(25);
	$sheet->setCellValue('A'.$rowSub, "No orders placed for more than $xday Days");
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE );
	$sheet->getStyle('A'.$rowSub)->getFont()->setSize(12);
	$sheet->getStyle('A'.$rowSub)->getFont()->setBold(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setWrapText(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
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
			'bold' => true
	));

	$fillArray	= array('fill'	=> array(
        'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => FILL_COLOR_SHADED),
        'endcolor'   => array('rgb' => FILL_COLOR_SHADED)
	));

	//headers
	$rowSub++;
	$sheet->getStyle('A'.$rowSub.':C'.$rowSub)->applyFromArray(array_merge($borderArray,$alignArray,$fontArray));
	$sheet->setCellValue('A'.$rowSub, "Facility");
	$sheet->setCellValue('B'.$rowSub, "last order placed");
	$sheet->setCellValue('C'.$rowSub, "# of days since last order");

	$sheet->getColumnDimension('A')->setWidth(55);
	$sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(20);

	$rowSub++;

	while(($row  = mysql_fetch_assoc($result)))
	{
		
		$sheet->setCellValue('A'.$rowSub, $row['fldFacilityName']);
		$sheet->setCellValue('B'.$rowSub, $row['lastOrder']);
		if($row['lastOrder'] != '')
		{
			$sheet->setCellValue('C'.$rowSub, abs(intval($row['dateRange'])) + $xday);
		}

		$sheet->getStyle('A'.$rowSub.':C'.$rowSub)->applyFromArray(array_merge($borderArray,$alignArray));
		$sheet->getStyle('A'.$rowSub)->applyFromArray($leftAlignArray);
		if($rowSub % 2 != 0)
		{
			$sheet->getStyle('A'.$rowSub.':C'.$rowSub)->applyFromArray($fillArray);
		}
		
		$rowSub++;
	}//while
}
else
{
	$rowSub++;
	$sheet->mergeCells('A'.$rowSub.':K'.$rowSub);
	$sheet->setCellValue('A'.$rowSub,"No Facility found based coditions given");
	$sheet->getStyle('A'.$rowSub)->getFont()->setSize(13);
	$sheet->getStyle('A'.$rowSub)->getFont()->setBold(true);
	$sheet->getStyle('A'.$rowSub)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED );
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setWrapText(true);
	$sheet->getStyle('A'.$rowSub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
}

// Redirect output to a client web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;




