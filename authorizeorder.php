<?php 
session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
	header("Location:index.php");

include "config.php";
//ini_set('display_errors',1);

//function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message)
//{
//	$file = $path.$filename;
	//$file_size = filesize($file);
//	$handle = fopen($file, "r");
//	$content = fread($handle, $file_size);
//	fclose($handle);
//	$content = chunk_split(base64_encode($content));
//	$uid = md5(uniqid(time()));
//	$name = basename($file);
//	$header = "From: ".$from_name." <".$from_mail.">\r\n";
//	$header .= "Reply-To: ".$replyto."\r\n";
//	$header .= "MIME-Version: 1.0\r\n";
//	$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
//	$header .= "This is a multi-part message in MIME format.\r\n";
//	$header .= "--".$uid."\r\n";
//	$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
//	$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
//	$header .= $message."\r\n\r\n";
//	$header .= "--".$uid."\r\n";
//	$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
//	$header .= "Content-Transfer-Encoding: base64\r\n";
//	$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
//	$header .= $content."\r\n\r\n";
//	$header .= "--".$uid."--";
	
//	if (mail($mailto, $subject, "", $header))
//	{
//		//echo "mail send ... OK"; // or use booleans here
//	}
//	else
//	{
//		//echo "mail send ... ERROR!";
//	}
//}

$sql_values_fetch =	mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));

$time	= date("Y-m-d H:i",time());

function formatDate11($dDate)
{
	if(trim($dDate) === '' || substr($dDate,0,10) === '0000-00-00')
	{
		return '';
	}
	$dNewDate = strtotime($dDate);
	
	return date('m-d-Y',$dNewDate);
}

function formatDate12($dDate)
{
	if (trim($dDate) === '' || substr($dDate,0,10) == '0000-00-00')
	{
		return '';
	}
	
	$dNewDate = strtotime($dDate);
	return date('H:i',$dNewDate);
}
$orddate	= $time;
$time11		= formatdate11($orddate);
$time12		= formatdate12($orddate);

function formatDateddmmyy($dDate)
{
	if (trim($dDate) == '' || substr($dDate,0,10) === '0000-00-00')
	{
		return '';
	}
	$dNewDate = strtotime($dDate);
	return date('m-d-Y',$dNewDate);

}

$ddob	= "MM-DD-YYYY";
$fdob	= $sql_values_fetch['fldDOB'];

if($fdob !== '')
{
	$ddob = formatDateddmmyy($fdob);
}

function formatDate21($dDate)
{
	$dNewDate = strtotime($dDate);
	return date('m-d-Y',$dNewDate);
}

function formatDate22($dDate)
{
	$dNewDate = strtotime($dDate);
	return date('H:i',$dNewDate);
}

$schdte		= $sql_values_fetch['fldSchDate'];
$time11		= formatdate21($schdte);
$time12		= formatdate22($schdte);
$cddte		= $sql_values_fetch['fldCDDate'];
$cddate		= formatdate21($cddte);
$refph		= $sql_values_fetch['fldOrderingPhysicians'];
$sql_user	= mysql_fetch_array(mysql_query("SELECT * FROM tbluser where fldRealName='$refph'"));
$phyph		= $sql_user['fldPhone'];

?>


<script type="text/javascript">
$(document).ready(function() {
	$("#order").validate();
});

function open_win()
{
	<?$sql_values_fetch_pdf =	mysql_fetch_array(mysql_query("select * from tblsettings"));
		if($sql_values_fetch['fldAuthorized'] === '1')
		{
			$dest	= $sql_values_fetch_pdf['fldPDFSignedOrders'];
			$sign	= "s";
		}
		else
		{
			$dest	= $sql_values_fetch_pdf['fldPDFUnsignedOrders'];
			$sign	= "u";
		}
	
	$filename = $dest . $sign . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";?>
	
	window.open("<?=$filename?>");
}
</script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" id="order">
<table width="1050" border="0" cellpadding="0" cellspacing="0" background="main.png">
	<tr>
		<td>
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td class="lab">&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td width="9%"><span class="lab">Today Date</span></td>
										<td width="16%"><span class="dis">
											<?echo date('m-d-Y' ,strtotime($sql_values_fetch['fldDate']));?>
											</span></td>
										<td width="13%" class="lab">Today Time </td>
										<td width="31%"><span class="dis">
											<?echo date('g:i A' ,strtotime($sql_values_fetch['fldDate']));?>
										</span>
										</td>
										<td width="6%">&nbsp;</td>
										<td width="25%">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="9%"><span class="lab">Last name</span></td>
										<td width="16%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldLastName'])?>
										</span></td>
										<td width="13%"><span class="lab">First name</span></td>
										<td width="17%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldFirstName'])?>
										</span></td>
										<td width="9%"><span class="lab">Middle name</span></td>
										<td width="17%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldMiddleName'])?>
										</span></td>
										<td width="6%"><span class="lab">Jr, Sr, II</span></td>
										<td width="13%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSurName'])?>
										</span></td>
									</tr>
									<tr>
										<td class="lab">Patient MR# </td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPatientID'])?>
										</span></td>
										<td><span class="lab">DOB (MM-DD-YYYY)</span></td>
										<td><span class="dis">
											<?=$ddob?>
										</span></td>
										<td><span class="lab">Patient SSN</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPatientSSN'])?>
										</span></td>
										<td><span class="lab">Sex</span></td>
										<td><span class="dis"><?=strtoupper($sql_values_fetch['fldGender'])?></span></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><span class="lab">Contact</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldRequestedBy'])?>
										</span></td>
										<td width="9%"><span class="lab">Facility Name </span></td>
										<td colspan="5"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldFacilityName'])?>
										</span></td>
										<td class="lab"> Phone </td>
										<td colspan="2" class="lab"><div id="txtHint"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldFacPhone'])
										?>
										</span></div></td>
									</tr>
									<tr>
										<td width="7%"><span class="lab">Room #</span></td>
										<td width="15%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPatientroom'])?>
										</span></td>
										<td><span class="lab">Urgent/Normal</span></td>
										<td width="8%"><span class="dis"><?=($sql_values_fetch['fldStat'] === '1')?'URGENT':'NORMAL';?>
										</span></td>
										<td width="9%"><span class="lab">After Hours</span></td>
										<td width="9%"><span class="dis"><?=($sql_values_fetch['fldAfterhours'] === '1')?'YES':'NO';?>
										</span></td>
										<td width="12%"><span class="lab">Date Exam needed: </span></td>
										<td width="9%"><span class="dis"><?=date('m-d-Y' ,strtotime($sql_values_fetch['fldSchDate']));?>
										</span></td>
										<td width="12%"><span class="lab">Time exam needed</span></td>
										<td width="10%"><span class="dis"><?=date('g:i A' ,strtotime($sql_values_fetch['fldSchDate']));?>
										</span></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="10%"><span class="lab">Procedure #1</span></td>
										<td width="24%"><span class="lab"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure1'])?>
										</span>
											<label></label>
										</span></td>
										<td width="8%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr1'])?>
										</span></td>
										<td width="7%"><span class="lab">Symptom </span></td>
										<td width="26%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom1'])?>
										</span></td>
										<td width="5%" class="lab">Ac No :</td>
										<td width="20%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno1'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Procedure #2</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure2'])?>
										</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr2'])?>
										</span></td>
										<td><span class="lab">Symptom </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom2'])?>
										</span></td>
										<td><span class="lab">Ac No :</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno2'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Procedure #3</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure3'])?>
										</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr3'])?>
										</span></td>
										<td><span class="lab">Symptom </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom3'])?>
										</span></td>
										<td><span class="lab">Ac No :</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno3'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Procedure #4</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure4'])?>
										</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr4'])?>
										</span></td>
										<td><span class="lab">Symptom </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom4'])?>
										</span></td>
										<td><span class="lab">Ac No :</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno4'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Procedure #5</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure5'])?>
										</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr5'])?>
										</span></td>
										<td><span class="lab">Symptom </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom5'])?>
										</span></td>
										<td><span class="lab">Ac No :</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno5'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Procedure #6</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldProcedure6'])?>
										</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldplr6'])?>
										</span></td>
										<td><span class="lab">Symptom </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptom6'])?>
										</span></td>
										<td><span class="lab">Ac No :</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldacsno6'])?>
										</span></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><span class="lab">Additional Patient Info</span></td>
									</tr>
									<tr>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldSymptoms'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">History:</span></td>
									</tr>
									<tr>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldHistory'])?>
										</span></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="9%"><span class="lab">Referring Dr. </span></td>
										<td colspan="6" width="62%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldOrderingPhysicians'])?>
										</span></td>
										<?
										
										?>
										<td><span class="lab">Phone : </span></td>
										<td><span class="dis">
											<?=strtoupper($phyph)?>
										</span></td>
									</tr>
									<tr>
										<td class="lab">CD Needed ? </td>
										<td width="12%"><span class="dis"><?=($sql_values_fetch['fldCDRequested'] === '1')?'YES':'NO';?>
										</span></td>
									<?if($sql_values_fetch['fldCDRequested'] === '1'):?>
										<td width="7%"><span class="lab">Location</span></td>
										<td colspan="4"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldCDAddr'])?>
										</span></td>
										<td width="10%" class="lab">Date CD needed </td>
										<td width="14%"><span class="dis">
											<?=strtoupper($cddate)?>
										</span></td>
									<?else:?>
										<td colspan="7">&nbsp;</td>
									<?endif;?>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td><span class="lab">Insurance Type</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldInsurance'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td width="13%"><span class="lab">Medicare #</span></td>
										<td width="28%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldMedicareNumber'])?>
										</span></td>
										<td width="8%"><span class="lab">Medicaid #</span></td>
										<td width="24%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldMedicaidNumber'])?>
										</span></td>
										<td width="6%"><span class="lab">State #</span></td>
										<td width="21%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldState'])?>
										</span></td>
										</tr>
										<tr>
										<td><span class="lab">Insurance Company </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldInsuranceCompanyName'])?>
										</span></td>
										<td><span class="lab">Policy #</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPolicy'])?>
										</span></td>
										<td><span class="lab">Group #</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldGroup'])?>
										</span></td>
										</tr>
										<tr>
										<td><span class="lab">HMO Name/Contract </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldHmoContract'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="13%"><span class="lab">Responsible Party:</span></td>
										<td width="28%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldResponsiblePerson'])?>
										</span></td>
										<td width="8%"><span class="lab">Relationship</span></td>
										<td width="51%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldRelationship'])?>
										</span></td>
									</tr>
									<tr>
										<td><span class="lab">Address #1</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivateAddressLine1'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span class="lab">Address #2 </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivateAddressLine2'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span class="lab">City</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivateAddressCity'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span class="lab">State </span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivateAddressState'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span class="lab">Zip</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivateAddressZip'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span class="lab">Phone #</span></td>
										<td><span class="dis">
											<?=strtoupper($sql_values_fetch['fldPrivatePhoneNumber'])?>
										</span></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="13%"><span class="lab">Verbal Date</span></td>
										<td width="18%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldReportDate'])?>
										</span></td>
										<td width="12%"><span class="lab">Report Called To</span></td>
										<td width="22%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldReportCalledTo'])?>
										</span></td>
										<td width="9%"><span class="lab">Report Details</span></td>
										<td width="26%"><span class="dis">
											<?=strtoupper($sql_values_fetch['fldReportDetails'])?>
										</span></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="5%"><span class="lab">Email</span></td>
										<td width="62%"><input type="text" name="temail" />
											<input name="email" type="submit" id="email" value="Email" /></td>
										<td width="33%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="3">
											<input type="checkbox" name="confirmbox" class="required" onclick="$('#authorized_dateTime').val(new Date().toLocaleString());"/>
											This Patient would find it physically and/or psychologically taxing because of advanced age and/or physical limitations to receive an X-ray or EKG outside this location. This test is medically necessary for the diagnosis and treatment of this patient.</td>
									</tr>
									<tr>
										<td><input type="hidden" id="authorized_dateTime" name="authorized_dateTime" value=''/></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table align="center">
									<tr>
										<td align="center">
										<?if($_SESSION['role'] =='orderingphysician'):?>
											<input type="submit" name="submit" value="Submit">
										<?else:?>
											<input type="submit" name="back" value="Back" />
										<?endif;?>
										</td>
										<td align="center"><input type="button" name="print" value="Print" onclick="window.print()" ></td>
										<td align="center"><input type="button" name="pdf" value="PDF" onclick="open_win()" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
<?php
if(!empty($_REQUEST['back']))
{
	$redirecturl = "index.php?pg=20";
	header("location:".$redirecturl);
}
if(!empty($_REQUEST['email']));
{
	$sql_values_fetch_pdf =	mysql_fetch_array(mysql_query("select * from tblsettings"));
	
	if($sql_values_fetch['fldAuthorized'] === '1')
	{
		$dest	= $sql_values_fetch_pdf['fldPDFSignedOrders'];
		$sign	= "s";
	}
	else
	{
		$dest	= $sql_values_fetch_pdf['fldPDFUnsignedOrders'];
		$sign	= "u";
	}

	$filename = $dest . $sign . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";
	
	// Read POST request params into global vars
	$to=$_REQUEST['temail'];
	
	// how to use
	$my_file = $filename; //"test.pdf"
	$my_mail = "manigce@gmail.com";
	$my_replyto = "manigce@gmail.com";
	
	$my_name = "MDI Imaging - Reffering Physician";
	$my_subject = "MDI Imaging & Reffering Physician - Order";
	$my_message = "Hi,\r\n\r\nPlease find the Copy of your Order. \r\n\r\nRegards\r\nMDF Imaging & Referring Physician";
// 	mail_attachment($my_file, $dest, $to, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
}

if(!empty($_REQUEST['submit']))
{
	$esignDT = date("Y-m-d H:i:s",strtotime($_REQUEST['authorized_dateTime']));
	$esignSQL = "update tblorderdetails set fldAuthorized=1, fldAuthDate = '$esignDT' where fldID= '$id'";
	$sql_insert = mysql_query($esignSQL);
	
	if($sql_insert)
	{
		include 'pdf_neworder.php';
	
		// Read POST request params into global vars
		$to1=$sql_values_fetch['fldEmailSignedOrders1'];
		$to2=$sql_values_fetch['fldEmailSignedOrders2'];
		
		// how to use
		$my_file = $filename;
		$my_mail = "manigce@gmail.com";
		$my_replyto = "manigce@gmail.com";
		
		$my_name = "MDI Imaging - Reffering Physician";
		$my_subject = "MDI Imaging & Reffering Physician - Order";
		$my_message = "Hi,\r\n\r\nPlease find the Copy of Authorised Order Placed at MDI Imaging and Referring Physician\r\n\r\nRegards\r\nMDF Imaging & Referring Physician";
		mail_attachment($my_file, $dest, "$to1, $to2", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
		
		$redirecturl = "index.php?pg=20";
		header("location:".$redirecturl);
	}
	else 
	{
		die(mysql_error()." Invalid DB query");
	}
	
}
?>
