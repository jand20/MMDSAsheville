<?php # PMD 2012-01-20 editorders1.php
session_start(); // if session is not set redirect the user
if(empty($_SESSION['user'])) header("Location:index.php");
include "config.php";
$user = $_SESSION['user'];
$sql_values_fetch_usr = mysql_fetch_array(mysql_query("select * FROM tbluser WHERE fldUserName='$user'"));
$fac = $sql_values_fetch_usr['fldFacility'];
$uid = $sql_values_fetch_usr['fldID'];

$sql_values_fetch =	mysql_fetch_array(mysql_query("select * FROM tblorderdetails WHERE fldID='$id'"));
$acsnum = array();
for ($cntr=1;$cntr<7;$cntr++) $acsnum[$cntr] = $sql_values_fetch['fldacsno'.$cntr];

$sql_values_icd = mysql_fetch_array(mysql_query("select * FROM tblicdcodes WHERE fldOrderid='$id'"));

?>
<script type="text/javascript">
function cdenable()
{
	if (document.getElementById('cdrequested').value != 0){
	document.getElementById('cdaddrlab').style.display = '';
	document.getElementById('cddatelab').style.display = '';
	document.getElementById('cdaddr').style.display = '';
	document.getElementById('cddate').style.display = '';
} 
else
{
	document.getElementById('cddatelab').style.display = 'none';
	document.getElementById('cdaddrlab').style.display = 'none';
	document.getElementById('cdaddr').style.display = 'none';
	document.getElementById('cddate').style.display = 'none';
};

function phyenable()
{
	if (document.forms[0].orderingphysicians.value == "new")
	{
		document.forms[0].phynew.style.display = "";
	} 
	else
	{
		document.forms[0].phynew.style.display = "none";
	};
}
</script>
<script type="text/javascript" src="facility.js"></script>
<style type="text/css">
@import "timer/jquery.timeentry.css";
</style>

<link rel="stylesheet" type="text/css" href="datepick.css" /> 
<script type='text/javascript' src='datepick.js'></script>

<script type="text/javascript" src="timer/jquery-1.3.2.js"></script>
<script type="text/javascript" src="timer/jquery.min.js"></script>
<script type="text/javascript" src="timer/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () {
	$('#schdate2').timeEntry({spinnerImage: ''});
    $('#schdate22').timeEntry({spinnerImage: ''});

});
</script>
<? # <script type="text/javascript" src="jquery-latest.js"></script> ?>
 <script type="text/javascript" src="jquery.validate.js"></script>
 <script type="text/javascript">
  $.validator.addMethod(
      "aDate",
      function(value, element) {
          return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
      },
      "Please enter a date in the format mm-dd-yyyy"
  );
  $.validator.addMethod(
      "aDate1",
      function(value, element) {
          var temp = new Array();
		  temp = value.split('-');
		  month=temp[0];
		  days=temp[1];
		  year=temp[2];
		  flag=1;
		  if(value.length<10)
		  flag=0;
		  if(year.length<4)
		  flag=0;
		  if(year<1600 || year>2400)
		  flag=0;
		  if(month.length<2)
		  flag=0;
		  if(month<1 || month>12)
		  flag=0;
		  if(days.length<2)
		  flag=0;
          if ((parseInt(year)%4) == 0){
              if (parseInt(year)%100 == 0){
                  if (parseInt(year)%400 != 0){
		    		mdays=28;
                  }
                 if (parseInt(year)%400 == 0){
		    		mdays=29;
                  }
              }
              if (parseInt(year)%100 != 0){
		    	mdays=29;
              }
          }
          if ((parseInt(year)%4) != 0){
		  mdays=28;
          }
          if(month=='01'||month=='03'||month=='05'||month=='07'||month=='08'||month=='10'||month=='12')
          mdays=31;
          if(month=='04'||month=='06'||month=='09'||month=='11')
          mdays=30;
		  if(days<1 || days>mdays)
		  flag=0;
          if(flag==1)
          return true;
          else
          return false;
      },
      "Please enter a date in the format mm-dd-yyyy"
  );
    $(document).ready(function() {
      $("#myform").validate({
        rules: {
        lastname: {
          required: true
        },
        firstname: {
          required: true
        },
        patientid: {
          required: false
        },
        dob: {
          required: true,
          aDate: true,
          aDate1: true
        },
        patientssn: {
          required: true
        },
        sex: {
          required: true
        },
        requester: {
          required: false
        },
        facility: {
          required: true
        },
        orderingphysicians: {
          required: true
        }
        }
      });
    });
  </script>
<link href="style.css" rel="stylesheet" type="text/css" />

<? include_once("mod_editfuncs.php"); ?>

<form id="myform" action="" method="post">
<table width="1050" border="0" cellpadding="0" cellspacing="0" background="main.png">
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <? if ($newpt != 1 && $num == 0 && $pid != 0 && $pid !="") 
	  {?>
      <tr>
        <td><div align="center"><span class="war"><strong>Patient doesn't exist</strong></span></div></td>
      </tr>
      <?
	  $sql = "SELECT max(fldPatientID) as maxid from tblorderdetails where 1";
	  $result = mysql_query($sql) or die (mysql_error());
	  while($row = mysql_fetch_array($result))
	  {
		  $newptid=$row[maxid];
		  if ($newptid < 25001) $newptid=25000;
		  $newptid = $newptid + 1;
	  }
	  $pid = $newptid;
      }?>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%"><span class="lab">Today Date</span></td>
            <td width="16%"><? doDatePick('schdate1',date('m-d-Y' ,strtotime($sql_values_fetch['fldDate']))); ?></td>
			<td width="13%" class="lab">Today Time </td>
            <td width="31%"><input name="schdate2" type="text" size="6" id="schdate2" value="<?echo date('g:i A' , strtotime($sql_values_fetch['fldDate']));?>"/></td>
            <td width="6%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
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
            <td width="16%"><input name="lastname" type="text" class="myinput1" value="<?=$sql_values_fetch['fldLastName']?>" /></td>
            <td width="13%"><span class="lab">First name</span></td>
            <td width="17%"><input name="firstname" type="text" class="myinput1" value="<?=$sql_values_fetch['fldFirstName']?>" /></td>
            <td width="9%"><span class="lab">Middle name</span></td>
            <td width="17%"><input name="middlename" type="text" class="myinput1" value="<?=$sql_values_fetch['fldMiddleName']?>" /></td>
            <td width="6%"><span class="lab">Jr, Sr, II</span></td>
            <td width="13%"><input name="surname" type="text" class="myinput2" value="<?=$sql_values_fetch['fldSurName']?>" size="10" /></td>
          </tr>
          <tr>
            <td><span class="lab">Patient MR#</span></td>
            <td><input name="patientid" type="text" class="myinput2" value="<?=$sql_values_fetch['fldPatientID']?>" size="10" /></td>
            <?
			function formatDateddmmyy($dDate)
			{
				if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') return '';
				$dNewDate = strtotime($dDate);
				return date('m-d-Y',$dNewDate);
			}
			$ddob="MM-DD-YYYY";
			$fdob = $sql_values_fetch['fldDOB'];
			if($fdob!='') $ddob = formatDateddmmyy($fdob);
			?>
            <td><span class="lab">DOB (MM-DD-YYYY)</span></td>
            <td><input name="dob" type="text" value="<?=$ddob?>" class="myinput1" /></td>
			<td><span class="lab">Patient SSN</span></td>
            <td><input name="patientssn" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPatientSSN']?>" /></td>
			<td><span class="lab">Sex</span></td>
            <td><select name="sex">
              <option value="" <? if($sql_values_fetch['fldGender'] == '') {?> selected="selected" <? } ?>>Select</option>
              <option value="female" <? if($sql_values_fetch['fldGender'] == 'female') {?> selected="selected" <? } ?>>FEMALE</option>
              <option value="male" <? if($sql_values_fetch['fldGender'] == 'male') {?> selected="selected" <? } ?>>MALE</option>
            </select></td>
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
            <td><input name="requester" type="text" class="myinput1"  value="<?=$sql_values_fetch['fldRequestedBy']?>" /></td>
            <td width="9%"><span class="lab">Facility Name </span></td>
            <td colspan="3"><select name="facility" class="myselect5" onchange="showUser(this.value)">
              <option selected="selected" value="">Select</option>
             <?
			$sql = "SELECT * FROM tblfacility where 1 order by fldFacilityName";
			//if($_SESSION['role'] =='facilityuser') { $sql="select * from tbluserfacdetails where fldUserID = '$uid'"; }
			if($_SESSION['role'] == 'facilityuser') $sql="select fldFacility as 'fldFacilityName' from tbluserfacdetails where fldUserID = '$uid'";
			//if($_SESSION['role'] =='facilityuser') { $sql="select * from tbluserfacdetails where fldUserID = '$uid'"; }
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{?>
              <option value="<?=$row['fldFacilityName']?>" <? if($sql_values_fetch['fldFacilityName'] == $row['fldFacilityName']) {?> selected="selected" <? } ?>>
              <?=strtoupper($row['fldFacilityName'])?>
              </option>
             <?
			 }?>
            </select></td>
            <td width="5%" class="lab"> Phone </td>
            <td width="19%"><div id="txtHint"><input name='faccontact' type='text' class='myinput1'  value='<?=$sql_values_fetch['fldFacPhone']?>' /></div></td>
          </tr>
          <tr>
            <td width="7%"><span class="lab">Room #</span></td>
            <td width="15%"><input name="patientroom" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPatientroom']?>" /></td>
            <td><span class="lab">Stat</span></td>
            <td width="3%"><input name="stat" type="checkbox" class="chk" value="1" <? if($sql_values_fetch['fldStat'] == 1) {?>checked="checked"<? } ?> /></td>
         </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
<? # loop start
for ( $pntr = 1; $pntr < 7; $pntr++)
{	
?>	
<tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">		
	<tr>
		<td width="9%"><span class="lab">Procedure #<? echo $pntr; ?></span></td>
		<td colspan="2"><span class="lab">
		<? doSelect("procedure".$pntr, $procarray, $sql_values_fetch['fldProcedure'.$pntr],'myselect2'); ?>
		</span></td>
		<td colspan="2"><span class="lab">
		<? 
		doRadio("plr".$pntr, "LEFT", $sql_values_fetch['fldplr'.$pntr],"L"); 
		doRadio("plr".$pntr, "RIGHT", $sql_values_fetch['fldplr'.$pntr],"R"); 
		doRadio("plr".$pntr, "BILATERAL", $sql_values_fetch['fldplr'.$pntr],"B"); 
		?>
		</span></td>
		<td><span class="lab">Symptom </span></td>
		<td colspan="3"><span class="lab">
		  <input name="symptoms<? echo $pntr; ?>" type="text" class="myinput3" value="<?=$sql_values_fetch['fldSymptom'.$pntr]?>" size="40" />
			&nbsp;&nbsp;&nbsp;# of Films&nbsp;
			<? doSelect('numViews'.$pntr, $viewarray, $sql_values_fetch['fldNumOfViews'.$pntr],''); ?>
		</span></td>
	</tr>
	
	<tr>
		<td><span class="lab">ICD9A</span></td>
		<td colspan="2">
		<? doSelect("proc".$pntr."icd1", $icd9array, $sql_values_icd['fldProc'.$pntr.'icd1'],'myselect2'); ?>
		</td>
		<td width="5%"><span class="lab">ICD9B</span></td>
		<td width="19%">
		<? doSelect("proc".$pntr."icd2", $icd9array, $sql_values_icd['fldProc'.$pntr.'icd2'],'myselect2'); ?>
		</td>
		<td width="6%"><span class="lab">ICD9C</span></td>
		<td width="18%">
		<? doSelect("proc".$pntr."icd3", $icd9array, $sql_values_icd['fldProc'.$pntr.'icd3'],'myselect2'); ?>
		</td>
		<td width="5%"><span class="lab">ICD9D</span></td>
		<td width="20%">
		<? doSelect("proc".$pntr."icd4", $icd9array, $sql_values_icd['fldProc'.$pntr.'icd4'],'myselect2'); ?>
		</td>
	</tr>

	<tr>
		<td colspan="2"><span class="lab">Definiative Diagnosis </span></td>
		<td colspan="3"><span class="lab">
		  <input type="text" name="proc<? echo $pntr ?>dig" id="proc<? echo $pntr ?>dig" value="<?=$sql_values_icd['fldProc'.$pntr.'dig']?>" />
		</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</table>
</td></tr>
<? # End loop
}
?> 	  
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><span class="lab">Additional Patient Info</span></td>
          </tr>
          <tr>
            <td><input name="symptoms" type="text"  value="<?=$sql_values_fetch['fldSymptoms']?>" size="150" /></td>
          </tr>
          <tr>
            <td><span class="lab">History:</span></td>
          </tr>
          <tr>
            <td><input name="history" type="text"  value="<?=$sql_values_fetch['fldHistory']?>" size="150" /></td>
          </tr>
		  <tr>
            <td><span class="lab">Patient Notes:</span></td>
          </tr>
          <tr>
            <td><textarea rows='4' cols='113' name='patNotes' id='patNotes' style=' resize:none;'><?=$sql_values_fetch['fldPatNotes']?></textarea></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  <? ############################# ?>
            <td width="8%"><span class="lab">Referring Dr. </span></td>
            <td width="26%"><select name="orderingphysicians" class="myselect1" onChange="phyenable();">
              <?
			  $phy = $sql_values_fetch['fldOrderingPhysicians'];
			  $sql_values_fetch_phy = "SELECT * FROM tbluser where fldRole='orderingphysician' and fldRealName='$phy'";
			  $result = mysql_query($sql_values_fetch_phy) or die (mysql_error());
			  $phyind = 0;
			  $phyind = mysql_num_rows($result);

			  if($_SESSION['role'] =='facilityuser')
    		  {
				$sql="Select * from tbluser where fldRole='orderingphysician' and fldID in (Select fldUserID from tbluserfacdetails where                           fldFacility in (Select fldFacility from tbluserfacdetails where fldUserID in(Select fldid from tbluser where fldUserName='$user')))                           Order by FldRealName";
			  } 
			  else
			  {
				$sql="SELECT * FROM tbluser where fldRole='orderingphysician' order by fldRealName";
			  }
			  $result = mysql_query($sql);
			  while($row = mysql_fetch_array($result))
	     	  {?>
              <option value="<?=$row['fldRealName']?>" <? if($sql_values_fetch['fldOrderingPhysicians'] == $row['fldRealName']) {?> selected="selected" <? } ?>>
              <?=strtoupper($row['fldRealName'])?>
              </option>
              <? } ?>
              <option value="new" <?if(!$phyind) {?> selected="selected" <?}?>>Not In List</option>
            </select></td>
            <td width="14%"><input name="phynew" id="phynew" <?if($phyind) { ?> style="display: none;" <?}?> value="<? echo $phy; ?>"/></td>
            <td width="15%"><span class="lab">Date Exam needed: </span></td>
            <td width="16%"><? doDatePick('schdate12',date('m-d-Y' ,strtotime($sql_values_fetch['fldSchDate']))); ?></td>
            <td width="16%"><span class="lab">Time exam needed</span></td>
            <td width="5%"><input name="schdate22" type="text" value="<?echo date('g:i A' ,strtotime($sql_values_fetch['fldSchDate']));?>" id="schdate22" size="8"/></td>
          </tr>
          <tr>
            <td class="lab">CD Needed ? </td>
            <td>
     		<select name="cdrequested" id="cdrequested" onChange="cdenable();"> >
     		<option value="1" <? if($sql_values_fetch['fldCDRequested'] == "1") {?> selected="selected" <? } ?>>Y</option>
     		<option value="0" <? if($sql_values_fetch['fldCDRequested'] == "0") {?> selected="selected" <? } ?>>N</option>
			</select></td>
            <td class="lab"><label name="cdaddrlab" id="cdaddrlab" <? if($sql_values_fetch['fldCDRequested'] == "0") { ?> style="display: none;" <? } ?>>Location</label></td>
            <td colspan="2"><textarea name="cdaddr"  cols="30" rows="4" id="cdaddr"
            <? if($sql_values_fetch['fldCDRequested'] == "0") { ?>style="display: none;"<? } ?>><?if($sql_values_fetch['fldCDRequested'] == "1") { echo $sql_values_fetch['fldCDAddr']; } ?>
            </textarea>
            <td  class="lab"><label align="LEFT" name="cddatelab" id="cddatelab" <? if($sql_values_fetch['fldCDRequested'] == "0") { ?>style="display: none;"<? } ?>>Date CD needed :</label></td>
            <td><input name="cddate" type="text" value="<?echo date('m-d-Y' ,strtotime($sql_values_fetch['fldCDDate']));?>" id="cddate" size="8"  <? if($sql_values_fetch['fldCDRequested'] == "0") { ?>style="display: none;"<? } ?>/></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><span class="lab">Is this Resident currently a Medicare Skilled PPS, or Part A Patient? In other words,  ARE YOU TAKING MEDICARE NOTES ON THIS PATIENT?</span></td>
          </tr>
          <td width="10%"><select name="pps">
				<option value="" <? if($sql_values_fetch['fldpps'] == '') {?> selected="selected" <? } ?>>Select</option>
				<option value="yes" <? if($sql_values_fetch['fldpps'] == 'yes') {?> selected="selected" <? } ?>>Yes</option>
				<option value="no" <? if($sql_values_fetch['fldpps'] == 'no') {?> selected="selected" <? } ?>>No</option>
				</select>
			 </td>
        </table></td>
      </tr>
	  
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><span class="lab">Insurance Type</span></td>
            <td><select name="insurance" class="myselect1">
              <option selected="selected" value="">Select</option>
              <?
	  		  $sql="SELECT * FROM tbllists where fldListName = 'insurance' order by fldValue";
	  		  $result = mysql_query($sql);
	  		  while($row = mysql_fetch_array($result))
	  		  {?>
              <option value="<?=$row['fldValue']?>"<? if($sql_values_fetch['fldInsurance'] == $row['fldValue']) {?> selected="selected" <? } ?>>
              <?=strtoupper($row['fldValue'])?>
              </option>
              <? } ?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="13%"><span class="lab">Medicare #</span></td>
            <td width="28%"><input name="medicare" type="text" class="myinput1" value="<?=$sql_values_fetch['fldMedicareNumber']?>" /></td>
            <td width="11%"><span class="lab">Medicaid #</span></td>
            <td width="21%"><input name="medicaid" type="text" class="myinput1" value="<?=$sql_values_fetch['fldMedicaidNumber']?>" /></td>
            <td width="7%"><span class="lab">State</span></td>
            <td width="20%"><? doSelect("state", $starray, $sql_values_fetch['fldState'], ''); ?></td>
          </tr>
          <tr>
            <td><span class="lab">Insurance Company </span></td>
            <td><input name="insurancecompanyname" type="text" class="myinput1" value="<?=$sql_values_fetch['fldInsuranceCompanyName']?>" /></td>
            <td><span class="lab">Policy #</span></td>
            <td><input name="policy" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPolicy']?>" /></td>
            <td><span class="lab">Group #</span></td>
            <td><input name="group" type="text" class="myinput1" value="<?=$sql_values_fetch['fldGroup']?>" /></td>
          </tr>
          <tr>
            <td><span class="lab">HMO Name/Contract </span></td>
            <td><input name="hmo_contract" type="text" class="myinput1" value="<?=$sql_values_fetch['fldHmoContract']?>" /></td>
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
            <td width="28%"><input name="responsibleperson" type="text" class="myinput3"  value="<?=$sql_values_fetch['fldResponsiblePerson']?>" /></td>
            <td width="11%"><span class="lab">Relationship</span></td>
            <td width="48%"><select name="relationship" class="myselect2">
              <option selected="selected" value="">Select</option>
              <?
    		  $sql="SELECT * FROM tbllists where fldListName = 'relationship' order by fldValue";
    		  $result = mysql_query($sql);
    		  while($row = mysql_fetch_array($result))
    		  {?>
              <option value="<?=$row['fldValue']?>" <? if($sql_values_fetch['fldRelationship'] == $row['fldValue']) {?> selected="selected" <? } ?>>
              <?=strtoupper($row['fldValue'])?>
              </option>
              <? } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="lab">Address #1</span></td>
            <td><input name="privatestreetaddress1" type="text" class="myinput3" value="<?=$sql_values_fetch['fldPrivateAddressLine1']?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Address #2 </span></td>
            <td><input name="privatestreetaddress2" type="text" class="myinput3" value="<?=$sql_values_fetch['fldPrivateAddressLine2']?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">City</span></td>
            <td><input name="privatecity" type="text" class="myinput3" value="<?=$sql_values_fetch['fldPrivateAddressCity']?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">State </span></td>
            <td><? doSelect("privatestate", $statesarray, $sql_values_fetch['fldPrivateAddressState'], 'myselect2'); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Zip</span></td>
            <td><input name="privatezipcode" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPrivateAddressZip']?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Phone #</span></td>
            <td><input name="privatephone" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPrivatePhoneNumber']?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>This Patient would find it physically and/or psychologically taxing because of advanced age and/or physical limitations to receive an X-ray or EKG outside this location. This test is medically necessary for the diagnosis and treatment of this patient.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center">
              <input type="submit" name="submit" value="Update" />
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</form>
<?php
// Getting Values from the registration to create Master Account
include "mod_saveorder.php";
?>


