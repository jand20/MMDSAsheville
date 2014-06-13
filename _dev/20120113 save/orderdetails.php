<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql_values_fetch =	mysql_fetch_array(mysql_query("select *,
													DATE_FORMAT(created_date,'%m/%d/%Y %H:%i') AS created_date_formated,
													DATE_FORMAT(modified_date,'%m/%d/%Y %H:%i') AS modified_date_formated
													from tblorderdetails where fldID='$id'"));
$sql_values_icd =	mysql_fetch_array(mysql_query("select * from tblicdcodes where fldOrderid='$id'"));
///////////////require_once "Mail.php"; // PEAR Mail package
///////////////require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
$host = "mail.mdipacs.net";
$username = "dpotter";
$password = "brasil06";
?>
<script type="text/javascript">
function open_win()
{
<?
$sql_values_fetch_pdf =	mysql_fetch_array(mysql_query("select * from tblsettings"));
	if($sql_values_fetch['fldAuthorized'] == 1)
	{
	$dest=$sql_values_fetch_pdf['fldPDFSignedOrders'];
	$pdate=$sql_values_fetch['fldAuthDate'];
	$sign="s";
	}
	else
	{
	$dest=$sql_values_fetch_pdf['fldPDFUnsignedOrders'];
	$pdate=$sql_values_fetch['fldCreDate'];
	$sign="u";
	}

$filename = $dest . $sign . $pdate . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";
?>
window.open("<?echo $filename; ?>")
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form action="" method="post">
<table width="1050" border="0" cellpadding="0" cellspacing="0" background="main.png">
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            <td width="16%"><span class="dis">
              <?echo date('g:i A' ,strtotime($sql_values_fetch['fldDate']));?>
            </span></td>
            <td colspan="2" width="46%" align="left">
				<?php
					$myTemp = array();
					if($sql_values_fetch['created_by'] != '')
					{
						$myTemp[] = '<span class="lab"">Ordered by:</span><span class="dis"> '.$sql_values_fetch['created_by'].' '.$sql_values_fetch['created_date_formated'].'</span>';
					}
					
					if($sql_values_fetch['modified_by'] != '')
					{
						$myTemp[] = '<span class="lab"">Last Edited by:</span><span class="dis"> '.$sql_values_fetch['modified_by'].' '.$sql_values_fetch['modified_date_formated'].'</span>';
					}
					
					echo implode('&nbsp;&nbsp;', $myTemp);
				?>
			</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

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
            <?
	 		function formatDateddmmyy($dDate){
			$dNewDate = strtotime($dDate);
			return date('m-d-Y',$dNewDate);
			}
			$ddob="MM-DD-YYYY";
			$fdob = $sql_values_fetch['fldDOB'];
			if($fdob!='')
			{
			$ddob = formatDateddmmyy($fdob);
			}
			?>
            <td><span class="lab">DOB (MM-DD-YYYY)</span></td>
            <td><span class="dis">
              <?=$ddob?>
            </span></td>
            <td><span class="lab">Patient SSN</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldPatientSSN'])?>
            </span></td>
            <td><span class="lab">Sex</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldGender'])?>
            </span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            <td><span class="lab">Stat/Normal</span></td>
            <td width="8%"><span class="dis">
              <? if($sql_values_fetch['fldStat'] == 1) {?>
              Stat
              <? } else { ?>
              NORMAL
              <? } ?>
            </span></td>
            <td width="9%"><span class="lab">After Hours</span></td>
            <td width="9%"><span class="dis">
              <? if($sql_values_fetch['fldAfterhours'] == 1) {?>
              YES
              <? } else { ?>
              NO
              <? } ?>
            </span></td>
            <td width="12%"><span class="lab">Date Exam needed: </span></td>
            <td width="9%"><span class="dis">
              <?echo date('m-d-Y' ,strtotime($sql_values_fetch['fldSchDate']));?>
            </span></td>
            <td width="12%"><span class="lab">Time exam needed</span></td>
            <td width="10%"><span class="dis">
              <?echo date('g:i A' ,strtotime($sql_values_fetch['fldSchDate']));?>
            </span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%"><span class="lab">Procedure #1</span></td>
            <td colspan="4"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure1'])?>
            </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr1'])?>
            </span></td>
            <td><span class="lab">Symptom</span></td>
            <td colspan="4"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom1'])?>
                        </span></td>
            </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc1icd1'])?>
            </span></td>
            <td width="7%"><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc1icd2'])?>
            </span></td>
            <td width="6%"><span class="lab">ICD9C</span></td>
            <td width="17%"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc1icd3'])?>
            </span></td>
            <td width="7%"><span class="lab">ICD9D</span></td>
            <td width="20%"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc1icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc1dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno1'])?>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #2</span></td>
            <td colspan="4"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure2'])?></span><span class="lab"></span>              <div align="right"></div></td>
            <td width="9%"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr2'])?>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom2'])?>
            </span></td>
          </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc2icd1'])?>
            </span></td>
            <td><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc2icd2'])?>
            </span></td>
            <td><span class="lab">ICD9C</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc2icd3'])?>
            </span></td>
            <td><span class="lab">ICD9D</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc2icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc2dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno2'])?>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #3</span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure3'])?>
            </span><span class="lab">
              <label></label>
            </span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr3'])?>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom3'])?>
            </span></td>
          </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc3icd1'])?>
            </span></td>
            <td><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc3icd2'])?>
            </span></td>
            <td><span class="lab">ICD9C</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc3icd3'])?>
            </span></td>
            <td><span class="lab">ICD9D</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc3icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc3dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno3'])?>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #4</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure4'])?>
            </span></td>
            <td><span class="lab">
              <label>L/R </label>
            </span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr4'])?>
            </span></td>
            <td><span class="lab">Symptom</span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom4'])?>
            </span></td>
          </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc4icd1'])?>
            </span></td>
            <td><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc4icd2'])?>
            </span></td>
            <td><span class="lab">ICD9C</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc4icd3'])?>
            </span></td>
            <td><span class="lab">ICD9D</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc4icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc4dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno4'])?>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #5</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure5'])?>
            </span></td>
            <td><span class="lab">
              <label>L/R </label>
            </span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr5'])?>
            </span></td>
            <td><span class="lab">Symptom</span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom5'])?>
            </span></td>
          </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc5icd1'])?>
            </span></td>
            <td><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc5icd2'])?>
            </span></td>
            <td><span class="lab">ICD9C</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc5icd3'])?>
            </span></td>
            <td><span class="lab">ICD9D</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc5icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc5dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno5'])?>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #6</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldProcedure6'])?>
            </span></td>
            <td><span class="lab">
              <label>L/R </label>
            </span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldplr6'])?>
            </span></td>
            <td><span class="lab">Symptom</span></td>
            <td colspan="3"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldSymptom6'])?>
            </span></td>
          </tr>
          <tr>
            <td><span class="lab">ICD9A</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc6icd1'])?>
            </span></td>
            <td><span class="lab">ICD9B</span></td>
            <td colspan="2"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc6icd2'])?>
            </span></td>
            <td><span class="lab">ICD9C</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc6icd3'])?>
            </span></td>
            <td><span class="lab">ICD9D</span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc6icd4'])?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
            <td colspan="6"><span class="dis">
              <?=strtoupper($sql_values_icd['fldProc6dig'])?>
            </span></td>
            <td><span class="lab">Ac No : </span></td>
            <td><span class="dis">
              <?=strtoupper($sql_values_fetch['fldacsno6'])?>
            </span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%"><span class="lab">Referring Dr. </span></td>
            <td colspan="6" width="62%"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldOrderingPhysicians'])?>
            </span></td>
            <?
		  $time=date("Y-m-d H:i",time());
		  function formatDate21($dDate){
		  $dNewDate = strtotime($dDate);
		  return date('m-d-Y',$dNewDate);
		  }
		  function formatDate22($dDate){
		  $dNewDate = strtotime($dDate);
		  return date('H:i',$dNewDate);
		  }
		  $schdte=$sql_values_fetch['fldSchDate'];
		  $time11=formatdate21($schdte);
		  $time12=formatdate22($schdte);
		  $cddte=$sql_values_fetch['fldCDDate'];
		  $cddate=formatdate21($cddte);
		  $refph=$sql_values_fetch['fldOrderingPhysicians'];
		  $sql_user=mysql_fetch_array(mysql_query("SELECT * FROM tbluser where fldRealName='$refph'"));
		  $phyph=$sql_user['fldPhone'];
		  ?>
            <td><span class="lab">Phone : </span></td>
            <td><span class="dis">
              <?=strtoupper($phyph)?>
            </span></td>
          </tr>
          <tr>
            <td class="lab">CD Needed ? </td>
            <td width="12%"><span class="dis">
              <? if($sql_values_fetch['fldCDRequested'] == 1) {?>
              YES
              <? } else { ?>
              NO
              <? } ?>
            </span></td>
            <? if($sql_values_fetch['fldCDRequested'] == 1) {?>
            <td width="7%"><span class="lab">Location</span></td>
            <td colspan="4"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldCDAddr'])?>
            </span></td>
            <td width="10%" class="lab">Date CD needed </td>
            <td width="14%"><span class="dis">
              <?=strtoupper($cddate)?>
            </span></td>
            <? }
            else
            { ?>
            <td colspan="7">&nbsp;</td>
            <? } ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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

        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12%"><span class="lab">Verbal Date</span></td>
            <td width="18%"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldReportDate'])?>
            </span></td>
            <td width="12%"><span class="lab">Report Called To</span></td>
            <td width="22%"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldReportCalledTo'])?>
            </span></td>
            <td width="36%">&nbsp;</td>
          <tr>
            <td width="12%" ><span class="lab">Report Details</span></td>
            <td width="90%" style="word-wrap: break-word" colspan="5"><span class="dis">
              <?=strtoupper($sql_values_fetch['fldReportDetails'])?>
            </span></td>
          </tr>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table align="center">
          <tr>
            <td align="center"><input type="submit" name="back" value="Back" /></td>
            <td align="center"><input type="button" name="print" value="Print" onclick="window.print()"></td>
            <td align="center"><input type="button" name="pdf" value="PDF" onclick="open_win()" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</form>
<?php
if($_REQUEST['back']!='')
{
$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
}
if($_REQUEST['email']!='')
{
$sql_values_fetch_pdf =	mysql_fetch_array(mysql_query("select * from tblsettings"));
	if($sql_values_fetch['fldAuthorized'] == 1)
	{
	$dest=$sql_values_fetch_pdf['fldPDFSignedOrders'];
	$pdate=$sql_values_fetch['fldAuthDate'];
	$sign="s";
	}
	else
	{
	$dest=$sql_values_fetch_pdf['fldPDFUnsignedOrders'];
	$pdate=$sql_values_fetch['fldCreDate'];
	$sign="u";
	}

$filename = $dest . $sign . $pdate . $sql_values_fetch['fldLastName'] . $sql_values_fetch['fldFirstName'] . "_" . $id . ".pdf";

////////////////////////////////////////
// Read POST request params into global vars
//$from = "Douglas <dpotter@mdipacs.net>";
//$to=$_REQUEST['temail'];
//$subject = "MDI Imaging & Reffering Physician - Order";
//$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
//$text = "Hi,\r\n\r\nPlease find the Copy of your Order. \r\n\r\nRegards\r\nMDF Imaging & Referring Physician.";
//$file = $filename; // attachment
//$crlf = "\n";
//$mime = new Mail_mime($crlf);
//$mime->setTXTBody($text);
//$mime->addAttachment($file, 'text/plain');
//do not ever try to call these lines in reverse order
//$body = $mime->get();
//$headers = $mime->headers($headers);
//$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => false, 'username' => $username,'password' => $password));
//$mail = $smtp->send($to, $headers, $body);

}
?>