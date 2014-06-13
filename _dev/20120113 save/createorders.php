<?php session_start();
//if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");

include "config.php";
$user = $_SESSION['user'];
$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tbluser where fldUserName='$user'"));
$fac=$sql_values_fetch['fldFacility'];
$uid=$sql_values_fetch['fldID'];

//  require_once "Mail.php"; // PEAR Mail package
//  require_once ('Mail/mime.php'); // PEAR Mail_Mime packge

$host = "mail.mdipacs.net";
$username = "dpotter";
$password = "brasil06";

if($id !="")
{
$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));
$sql = "select * from tblorderdetails where fldID like '$id'";
$result = mysql_query($sql) or die (mysql_error());
$num=0;
$num = mysql_num_rows($result);
}

?>
<script type="text/javascript">
function search_prompt() {
	var retVal=""
	var valReturned;
	retVal=showModalDialog('searchpop.htm');
	valReturned=retVal;
	location.replace(valReturned);
}
function newpt() {
location.replace('?pg=42');
}
</script>
<script type="text/javascript"></script>
<script type="text/javascript">
function cdenable()
{
	if (document.getElementById('cdrequested').value != 0)
	{
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
}
function phyenable(){
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
<script type="text/javascript" src="timer/jquery-1.3.2.js"></script>
<script type="text/javascript" src="timer/jquery.min.js"></script>
<script type="text/javascript" src="timer/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () {
	$('#schdate2').timeEntry({spinnerImage: ''});
    $('#schdate22').timeEntry({spinnerImage: ''});

});
</script>
 <!-- <script type="text/javascript" src="jquery-latest.js"></script> -->
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
          if(month==01||month==03||month==05||month==07||month==08||month==10||month==12)
          mdays=31;
          if(month==04||month==06||month==09||month==11)
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
        symptoms1: {
          required: true
        },
        dob: {
          required: true,
          aDate: true,
          aDate1: true
        },
        schdate12: {
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
		History: {
          required: false
        },
        requester: {
          required: true
        },
        facility: {
          required: false
        },
        orderingphysicians: {
          required: true
        },
		medicare: {
          required: false
        }
        }
      });
    });
	function checkUserRole()
	{
		var stat = document.getElementsByName('stat')[0];
		if (stat.checked)
		{
<?php		if($_SESSION['role'] =='facilityuser') 
			{
					echo 'alert("your text here"); return false;';
			} ?>
		}
		return true;
	}
  </script>
<link href="style.css" rel="stylesheet" type="text/css" />
<form id="myform" action="" method="post" onsubmit="checkUserRole()">
<table width="1050" border="0" cellpadding="0" cellspacing="0" background="main.png">
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?if ($newpt != 1 && $num == 0 && $pid != 0 && $pid !="") {?>
      <tr>
        <td><div align="center"><span class="war"><strong>Patient doesn't exist</strong></span></div></td>
      </tr>
      <? } ?>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%"><span class="lab">Today Date</span></td>
            <td width="16%"><input name="schdate1" type="text" value="<?echo date('m-d-Y' , time());?>" id="schdate1" size="8"/></td>
            <td width="31%"><input name="schdate2" type="text" size="6" id="schdate2" value="<?echo date('g:i A' , time());?>"/></td>
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

            <td width="9%">&nbsp;</td>



            <td colspan="2"><input name="retrive" type="button" onclick="search_prompt()" value="Search" />
              <input name="new" type="submit" id="new" value="New" /></td>



            <td width="17%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
            <td width="6%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Last name</span></td>
            <td width="16%"><input name="lastname" type="text" class="myinput1" value="<?=$sql_values_fetch['fldLastName']?>" style="background-color: #FFFF99;"/></td>
            <td width="13%"><span class="lab">First name</span></td>
            <td><input name="firstname" type="text" class="myinput1" value="<?=$sql_values_fetch['fldFirstName']?>"  style="background-color: #FFFF99;"/></td>
            <td><span class="lab">Middle name</span></td>
            <td><input name="middlename" type="text" class="myinput1" value="<?=$sql_values_fetch['fldMiddleName']?>" /></td>
            <td><span class="lab">Jr, Sr, II</span></td>
            <td><input name="surname" type="text" class="myinput2" value="<?=$sql_values_fetch['fldSurName']?>" size="10" /></td>
          </tr>
          <tr>
            <td class="lab">Patient MR# </td>
            <td><input name="patientid" type="text" class="myinput2"  style="background-color: #FFFF99;" value="<?if($newpt == 1) { echo $pid; } else { echo $sql_values_fetch['fldPatientID']; }?>" size="10" /></td>
            <?
	 		function formatDateddmmyy($dDate){
	 		if (trim($dDate) == '' || substr($dDate,0,10) == '0000-00-00') {
			    return '';
}
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
            <td><input name="dob" type="text" class="myinput1" value="<?=$ddob?>" maxlength="10"  style="background-color: #FFFF99;"/></td>



            <td><span class="lab">Patient SSN</span></td>





            <td><input name="patientssn" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPatientSSN']?>" style="background-color: #FFFF99;"/></td>


            <td><span class="lab">Sex</span></td>
            <td><select name="sex"  style="background-color: #FFFF99;">
              <option value="" <? if($sql_values_fetch['fldGender'] == '') {?> selected="selected" <? } ?>>Select</option>
              <option value="female" <? if($sql_values_fetch['fldGender'] == 'female') {?> selected="selected" <? } ?>>FEMALE</option>
              <option value="male" <? if($sql_values_fetch['fldGender'] == 'male') {?> selected="selected" <? } ?>>MALE</option>
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
            <td><select name="privatestate" size="1" class="myselect2" id="privatestate">
              <option selected="selected">Select a State</option>
              <option value="ALASKA" <? if($sql_values_fetch['fldPrivateAddressState'] == " ALASKA") {?> selected="selected" <? } ?>> ALASKA</option>
			<option value="ALABAMA" <? if($sql_values_fetch['fldPrivateAddressState'] == "ALABAMA") {?> selected="selected" <? } ?>>ALABAMA</option>
			<option value="ARKANSAS" <? if($sql_values_fetch['fldPrivateAddressState'] == "ARKANSAS") {?> selected="selected" <? } ?>>ARKANSAS</option>
			<option value="ARIZONA" <? if($sql_values_fetch['fldPrivateAddressState'] == "ARIZONA") {?> selected="selected" <? } ?>>ARIZONA</option>
			<option value="CALIFORNIA" <? if($sql_values_fetch['fldPrivateAddressState'] == "CALIFORNIA") {?> selected="selected" <? } ?>>CALIFORNIA</option>
			<option value="COLORADO" <? if($sql_values_fetch['fldPrivateAddressState'] == "COLORADO") {?> selected="selected" <? } ?>>COLORADO</option>
			<option value="CONNECTICUT" <? if($sql_values_fetch['fldPrivateAddressState'] == "CONNECTICUT") {?> selected="selected" <? } ?>>CONNECTICUT</option>
			<option value="WASHINGTON D C" <? if($sql_values_fetch['fldPrivateAddressState'] == "WASHINGTON D C") {?> selected="selected" <? } ?>>WASHINGTON D C</option>
			<option value="DELAWARE" <? if($sql_values_fetch['fldPrivateAddressState'] == "DELAWARE") {?> selected="selected" <? } ?>>DELAWARE</option>
			<option value="FLORIDA" <? if($sql_values_fetch['fldPrivateAddressState'] == "FLORIDA") {?> selected="selected" <? } ?>>FLORIDA</option>
			<option value="GEORGIA" <? if($sql_values_fetch['fldPrivateAddressState'] == "GEORGIA") {?> selected="selected" <? } ?>>GEORGIA</option>
			<option value="HAWAII" <? if($sql_values_fetch['fldPrivateAddressState'] == "HAWAII") {?> selected="selected" <? } ?>>HAWAII</option>
			<option value="IOWA" <? if($sql_values_fetch['fldPrivateAddressState'] == "IOWA") {?> selected="selected" <? } ?>>IOWA</option>
			<option value="IDAHO" <? if($sql_values_fetch['fldPrivateAddressState'] == "IDAHO") {?> selected="selected" <? } ?>>IDAHO</option>
   <option value="ILLINOIS" <? if($sql_values_fetch['fldPrivateAddressState'] == "ILLINOIS") {?> selected="selected" <? } ?>>ILLINOIS</option>
   <option value="INDIANA" <? if($sql_values_fetch['fldPrivateAddressState'] == "INDIANA") {?> selected="selected" <? } ?>>INDIANA</option>
   <option value="KANSAS" <? if($sql_values_fetch['fldPrivateAddressState'] == "KANSAS") {?> selected="selected" <? } ?>>KANSAS</option>
   <option value="KENTUCKY" <? if($sql_values_fetch['fldPrivateAddressState'] == "KENTUCKY") {?> selected="selected" <? } ?>>KENTUCKY</option>
   <option value="LOUISIANA" <? if($sql_values_fetch['fldPrivateAddressState'] == "LOUISIANA") {?> selected="selected" <? } ?>>LOUISIANA</option>
   <option value="MAINE" <? if($sql_values_fetch['fldPrivateAddressState'] == "MAINE") {?> selected="selected" <? } ?>>MAINE</option>
  <option value="MARYLAND" <? if($sql_values_fetch['fldPrivateAddressState'] == "MARYLAND") {?> selected="selected" <? } ?>>MARYLAND</option>
  <option value="MASSACHUSETTS" <? if($sql_values_fetch['fldPrivateAddressState'] == "MASSACHUSETTS") {?> selected="selected" <? } ?>>MASSACHUSETTS</option>
   <option value="MICHIGAN" <? if($sql_values_fetch['fldPrivateAddressState'] == "MICHIGAN") {?> selected="selected" <? } ?>>MICHIGAN</option>
  <option value="MINNESOTA" <? if($sql_values_fetch['fldPrivateAddressState'] == "MINNESOTA") {?> selected="selected" <? } ?>>MINNESOTA</option>
  <option value="MISSISSIPPI" <? if($sql_values_fetch['fldPrivateAddressState'] == "MISSISSIPPI") {?> selected="selected" <? } ?>>MISSISSIPPI</option>
   <option value="MISSOURI" <? if($sql_values_fetch['fldPrivateAddressState'] == "MISSOURI") {?> selected="selected" <? } ?>>MISSOURI</option>
  <option value="MONTANA" <? if($sql_values_fetch['fldPrivateAddressState'] == "MONTANA") {?> selected="selected" <? } ?>>MONTANA</option>
   <option value="NEBRASKA" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEBRASKA") {?> selected="selected" <? } ?>>NEBRASKA</option>
   <option value="NEVADA" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEVADA") {?> selected="selected" <? } ?>>NEVADA</option>
   <option value="NEW HAMPSHIRE" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEW HAMPSHIRE") {?> selected="selected" <? } ?>>NEW HAMPSHIRE</option>
   <option value="NEW JERSEY" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEW JERSEY") {?> selected="selected" <? } ?>>NEW JERSEY</option>
   <option value="NEW MEXICO" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEW MEXICO") {?> selected="selected" <? } ?>>NEW MEXICO</option>
   <option value="NEW YORK" <? if($sql_values_fetch['fldPrivateAddressState'] == "NEW YORK") {?> selected="selected" <? } ?>>NEW YORK</option>
   <option value="NORTH CAROLINA" <? if($sql_values_fetch['fldPrivateAddressState'] == "NORTH CAROLINA") {?> selected="selected" <? } ?>>NORTH CAROLINA</option>
   <option value="NORTH DAKOTA" <? if($sql_values_fetch['fldPrivateAddressState'] == "NORTH DAKOTA") {?> selected="selected" <? } ?>>NORTH DAKOTA</option>
   <option value="OHIO" <? if($sql_values_fetch['fldPrivateAddressState'] == "OHIO") {?> selected="selected" <? } ?>>OHIO</option>
   <option value="OKLAHOMA" <? if($sql_values_fetch['fldPrivateAddressState'] == "OKLAHOMA") {?> selected="selected" <? } ?>>OKLAHOMA</option>
   <option value="OREGON" <? if($sql_values_fetch['fldPrivateAddressState'] == "OREGON") {?> selected="selected" <? } ?>>OREGON</option>
   <option value="PENNSYLVANIA" <? if($sql_values_fetch['fldPrivateAddressState'] == "PENNSYLVANIA") {?> selected="selected" <? } ?>>PENNSYLVANIA</option>
   <option value="PUERTO RICO" <? if($sql_values_fetch['fldPrivateAddressState'] == "PUERTO RICO") {?> selected="selected" <? } ?>>PUERTO RICO</option>
   <option value="RHODE ISLAND" <? if($sql_values_fetch['fldPrivateAddressState'] == "RHODE ISLAND") {?> selected="selected" <? } ?>>RHODE ISLAND</option>
   <option value="SOUTH CAROLINA" <? if($sql_values_fetch['fldPrivateAddressState'] == "SOUTH CAROLINA") {?> selected="selected" <? } ?>>SOUTH CAROLINA</option>
   <option value="SOUTH DAKOTA" <? if($sql_values_fetch['fldPrivateAddressState'] == "SOUTH DAKOTA") {?> selected="selected" <? } ?>>SOUTH DAKOTA</option>
   <option value="TENNESSEE" <? if($sql_values_fetch['fldPrivateAddressState'] == "TENNESSEE") {?> selected="selected" <? } ?>>TENNESSEE</option>
   <option value="TEXAS" <? if($sql_values_fetch['fldPrivateAddressState'] == "TEXAS") {?> selected="selected" <? } ?>>TEXAS</option>
   <option value="UTAH" <? if($sql_values_fetch['fldPrivateAddressState'] == "UTAH") {?> selected="selected" <? } ?>>UTAH</option>
   <option value="VERMONT" <? if($sql_values_fetch['fldPrivateAddressState'] == "VERMONT") {?> selected="selected" <? } ?>>VERMONT</option>
   <option value="VIRGINIA" <? if($sql_values_fetch['fldPrivateAddressState'] == "VIRGINIA") {?> selected="selected" <? } ?>>VIRGINIA</option>
   <option value="WASHINGTON" <? if($sql_values_fetch['fldPrivateAddressState'] == "WASHINGTON") {?> selected="selected" <? } ?>>WASHINGTON</option>
   <option value="WEST VIRGINIA" <? if($sql_values_fetch['fldPrivateAddressState'] == "WEST VIRGINIA") {?> selected="selected" <? } ?>>WEST VIRGINIA</option>
   <option value="WISCONSIN" <? if($sql_values_fetch['fldPrivateAddressState'] == "WISCONSIN") {?> selected="selected" <? } ?>>WISCONSIN</option>
   <option value="WYOMING" <? if($sql_values_fetch['fldPrivateAddressState'] == "WYOMING") {?> selected="selected" <? } ?>>WYOMING</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Zip</span></td>
            <td><input name="privatezipcode" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPrivateAddressZip']?>" /></td>
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
            <td><span class="lab">Contact</span></td>
            <td><input name="requester" type="text" class="myinput1"  value="<?=$sql_values_fetch['fldRequestedBy']?>"  style="background-color: #FFFF99;"/></td>
            <td width="9%"><span class="lab">Facility Name </span></td>
            <td colspan="3"><select name="facility" class="myselect5" onchange="showUser(this.value)"  style="background-color: #FFFF99;">
              <?
			$sql="SELECT * FROM tblfacility where 1 order by fldFacilityName";
			if($_SESSION['role'] =='facilityuser'){
				$sql="select fldFacility AS fldFacilityName from tbluserfacdetails where fldUserID = '$uid'";			
				echo $sql;
			}
			else { ?>
            <option selected="selected" value="">Select</option>
			<? }
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{?>
              <option value="<?=$row['fldFacilityName']?>" <? if($sql_values_fetch['fldFacilityName'] == $row['fldFacilityName']) {?> selected="selected" <? } ?>>
              <?=strtoupper($row['fldFacilityName'])?>
              </option>
              <? } ?>
            </select></td>
            <td width="6%" class="lab"> Phone </td>
            <td width="19%"><div id="txtHint"><input name='faccontact' type='text' class='myinput1'  value='<?=$sql_values_fetch['fldFacPhone']?>' /></div></td>
          </tr>
          <tr>
            <td width="5%"><span class="lab">Room #</span></td>
            <td width="18%"><input name="patientroom" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPatientroom']?>" /></td>
            <td><span class="lab">Urgent</span></td>
            <td width="9%"><input name="stat" type="checkbox" class="chk" value="1" <? if($sql_values_fetch['fldStat'] == 1) {?>checked="checked"<? } ?> /></td>
            <td width="9%"><span class="lab">After Hours</span></td>
            <td width="25%"><input name="afterhours" type="checkbox" class="chk" value="1" <? if($sql_values_fetch['fldAfterhours'] == 1) {?>checked="checked"<? } ?> /></td>
          </tr>
		  <tr>       
            <td><span class="lab">Stairs</span></td>
            <td width="9%"><input name="stairs" type="checkbox" class="chk" value="1" <? if($sql_values_fetch['fldStairs'] == 1) {?>checked="checked"<? } ?> /></td>
            <td width="5%"><span class="lab"># of stairs</span></td>
            <td width="10%"><input name="nstairs" type="text" class="myinput2" value="<?=$sql_values_fetch['fldNstairs']?>" /></td>
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
            <td width="33%"><span class="lab">
              <select name="procedure1" class="myselect2" style="background-color: #FFFF99;">
                <option selected="selected" value="">Select</option> 
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure1'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr1" value="LEFT" <? if($sql_values_fetch['fldplr1'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr1" value="RIGHT" <? if($sql_values_fetch['fldplr1'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr1" value="BILATERAL" <? if($sql_values_fetch['fldplr1'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td width="8%"><span class="lab">Symptom </span></td>
            <td width="48%"><span class="lab">
              <input name="symptoms1" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom1']?>" style="background-color: #FFFF99;"/>
            </span></td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #2</span></td>
            <td><span class="lab">
              <select name="procedure2" class="myselect2">
                <option selected="selected" value="">Select</option>
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure2'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr2" value="LEFT" <? if($sql_values_fetch['fldplr2'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr2" value="RIGHT" <? if($sql_values_fetch['fldplr2'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr2" value="BILATERAL" <? if($sql_values_fetch['fldplr2'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td><span class="lab">
              <input name="symptoms2" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom2']?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #3</span></td>
            <td><span class="lab">
              <select name="procedure3" class="myselect2">
                <option selected="selected" value="">Select</option>
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure3'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr3" value="LEFT" <? if($sql_values_fetch['fldplr3'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr3" value="RIGHT" <? if($sql_values_fetch['fldplr3'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr3" value="BILATERAL" <? if($sql_values_fetch['fldplr3'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td><span class="lab">
              <input name="symptoms3" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom3']?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #4</span></td>
            <td><span class="lab">
              <select name="procedure4" class="myselect2">
                <option selected="selected" value="">Select</option>
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure4'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr4" value="LEFT" <? if($sql_values_fetch['fldplr4'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr4" value="RIGHT" <? if($sql_values_fetch['fldplr4'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr4" value="BILATERAL" <? if($sql_values_fetch['fldplr4'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td><span class="lab">
              <input name="symptoms4" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom4']?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #5</span></td>
            <td><span class="lab">
              <select name="procedure5" class="myselect2">
                <option selected="selected" value="">Select</option>
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure5'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr5" value="LEFT" <? if($sql_values_fetch['fldplr5'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr5" value="RIGHT" <? if($sql_values_fetch['fldplr5'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr5" value="BILATERAL" <? if($sql_values_fetch['fldplr5'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td><span class="lab">
              <input name="symptoms5" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom5']?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="lab">Procedure #6</span></td>
            <td><span class="lab">
              <select name="procedure6" class="myselect2">
                <option selected="selected" value="">Select</option>
                <?
				$sql="SELECT * FROM tblproceduremanagment order by fldDescription";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{?>
                <option value="<?=$row['fldDescription']?>" <? if($sql_values_fetch['fldProcedure6'] == $row['fldDescription']) {?> selected="selected" <? } ?>>

                <?=strtoupper($row['fldDescription'])?>
                </option>
                <? } ?>
              </select>
              <label>
              <input type="radio" name="plr6" value="LEFT" <? if($sql_values_fetch['fldplr6'] == 'LEFT') {?> checked="checked" <? } ?> />

L</label>
              <label>
              <input type="radio" name="plr6" value="RIGHT" <? if($sql_values_fetch['fldplr6'] == 'RIGHT') {?> checked="checked" <? } ?> />

R</label>
              <label>
              <input type="radio" name="plr6" value="BILATERAL" <? if($sql_values_fetch['fldplr6'] == 'BILATERAL') {?> checked="checked" <? } ?> />

B</label>
            </span></td>
            <td><span class="lab">Symptom </span></td>
            <td><span class="lab">
              <input name="symptoms6" type="text" size="40"  value="<?=$sql_values_fetch['fldSymptom6']?>" />
            </span></td>
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
            <td><span class="lab">Additional Patient Info and Special Instrcutions</span></td>
          </tr>
          <tr>
            <td><input name="symptoms" type="text"  value="<?=$sql_values_fetch['fldSymptoms']?>" size="150" /></td>
          </tr>
          <tr>
            <td><span class="lab">History:</span></td>
          </tr>
          <tr>
            <td><input name="history" type="text"  value="<?=$sql_values_fetch['fldHistory']?>" size="150"  style="background-color: #FFFF99;"/></td>

          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%"><span class="lab">Referring Dr. </span></td>
            <td colspan="2"><select name="orderingphysicians" class="myselect1" onChange="phyenable();"  style="background-color: #FFFF99;">
              <option selected="selected" value="">Select</option>
              <?
			  if($_SESSION['role'] =='facilityuser')
    		  {
			  //$sql="Select * from tbluser where fldRole='orderingphysician' and fldID in (Select fldUserID from tbluserfacdetails where                           fldFacility in (Select fldFacility from tbluserfacdetails where fldUserID in(Select fldid from tbluser where fldUserName='$user'))) Order by FldRealName";
			  $sql="SELECT * FROM tbluser where fldRole='orderingphysician' order by fldRealName";


			  } else {
			  $sql="SELECT * FROM tbluser where fldRole='orderingphysician' order by fldRealName";
			  }
			  $result = mysql_query($sql);
			  while($row = mysql_fetch_array($result))
	     	  {?>
              <option value="<?=$row['fldRealName']?>" <? if($sql_values_fetch['fldOrderingPhysicians'] == $row['fldRealName']) {?> selected="selected" <? } ?>>

              <?=strtoupper($row['fldRealName'])?>
              </option>
              <? } ?>
              <option value="new">Not In List</option>
            </select>        <input name="phynew" id="phynew" style="display: none;"/></td>
            <td width="19%">
              <span class="lab">Date Exam needed: </span></td>
            <td width="12%"><input name="schdate12" type="text" value="<?echo date('m-d-Y' , time());?>" id="schdate12" size="8"/></td>
		</tr>
          
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
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
            <td width="7%"><span class="lab">State #</span></td>
            <td width="20%"><select name="state">
                <option value="AL" <? if($sql_values_fetch['fldState'] == "AL") {?> selected="selected" <? } ?>>AL</option>
        <option value="AK" <? if($sql_values_fetch['fldState'] == "AK") {?> selected="selected" <? } ?>>AK</option>
        <option value="AZ" <? if($sql_values_fetch['fldState'] == "AZ") {?> selected="selected" <? } ?>>AZ</option>
        <option value="AR" <? if($sql_values_fetch['fldState'] == "AR") {?> selected="selected" <? } ?>>AR</option>
        <option value="CA" <? if($sql_values_fetch['fldState'] == "CA") {?> selected="selected" <? } ?>>CA</option>
        <option value="CO" <? if($sql_values_fetch['fldState'] == "CO") {?> selected="selected" <? } ?>>CO</option>
        <option value="CT" <? if($sql_values_fetch['fldState'] == "CT") {?> selected="selected" <? } ?>>CT</option>
        <option value="DE" <? if($sql_values_fetch['fldState'] == "DE") {?> selected="selected" <? } ?>>DE</option>
        <option value="DC" <? if($sql_values_fetch['fldState'] == "DC") {?> selected="selected" <? } ?>>DC</option>
        <option value="FL" <? if($sql_values_fetch['fldState'] == "FL") {?> selected="selected" <? } ?>>FL</option>
        <option value="GA" <? if($sql_values_fetch['fldState'] == "GA") {?> selected="selected" <? } ?>>GA</option>
        <option value="HI" <? if($sql_values_fetch['fldState'] == "HI") {?> selected="selected" <? } ?>>HI</option>
        <option value="ID" <? if($sql_values_fetch['fldState'] == "ID") {?> selected="selected" <? } ?>>ID</option>
        <option value="IL" <? if($sql_values_fetch['fldState'] == "IL") {?> selected="selected" <? } ?>>IL</option>
        <option value="IN" <? if($sql_values_fetch['fldState'] == "IN") {?> selected="selected" <? } ?>>IN</option>
        <option value="IA" <? if($sql_values_fetch['fldState'] == "IA") {?> selected="selected" <? } ?>>IA</option>
        <option value="KS" <? if($sql_values_fetch['fldState'] == "KS") {?> selected="selected" <? } ?>>KS</option>
        <option value="KY" <? if($sql_values_fetch['fldState'] == "KY") {?> selected="selected" <? } ?>>KY</option>
        <option value="LA" <? if($sql_values_fetch['fldState'] == "LA") {?> selected="selected" <? } ?>>LA</option>
        <option value="ME" <? if($sql_values_fetch['fldState'] == "ME") {?> selected="selected" <? } ?>>ME</option>
        <option value="MD" <? if($sql_values_fetch['fldState'] == "MD") {?> selected="selected" <? } ?>>MD</option>
        <option value="MA" <? if($sql_values_fetch['fldState'] == "MA") {?> selected="selected" <? } ?>>MA</option>
        <option value="MI" <? if($sql_values_fetch['fldState'] == "MI") {?> selected="selected" <? } ?>>MI</option>
        <option value="MN" <? if($sql_values_fetch['fldState'] == "MN") {?> selected="selected" <? } ?>>MN</option>
        <option value="MS" <? if($sql_values_fetch['fldState'] == "MS") {?> selected="selected" <? } ?>>MS</option>
        <option value="MO" <? if($sql_values_fetch['fldState'] == "MO") {?> selected="selected" <? } ?>>MO</option>
        <option value="MT" <? if($sql_values_fetch['fldState'] == "MT") {?> selected="selected" <? } ?>>MT</option>
        <option value="NE" <? if($sql_values_fetch['fldState'] == "NE") {?> selected="selected" <? } ?>>NE</option>
        <option value="NV" <? if($sql_values_fetch['fldState'] == "NV") {?> selected="selected" <? } ?>>NV</option>
        <option value="NH" <? if($sql_values_fetch['fldState'] == "NH") {?> selected="selected" <? } ?>>NH</option>
        <option value="NJ" <? if($sql_values_fetch['fldState'] == "NJ") {?> selected="selected" <? } ?>>NJ</option>
        <option value="NM" <? if($sql_values_fetch['fldState'] == "NM") {?> selected="selected" <? } ?>>NM</option>
        <option value="NY" <? if($sql_values_fetch['fldState'] == "NY") {?> selected="selected" <? } ?>>NY</option>
        <option value="NC" <? if($sql_values_fetch['fldState'] == "NC") {?> selected="selected" <? } ?>>NC</option>
        <option value="ND" <? if($sql_values_fetch['fldState'] == "ND") {?> selected="selected" <? } ?>>ND</option>
        <option value="OH" <? if($sql_values_fetch['fldState'] == "OH") {?> selected="selected" <? } ?>>OH</option>
        <option value="OK" <? if($sql_values_fetch['fldState'] == "OK") {?> selected="selected" <? } ?>>OK</option>
        <option value="OR" <? if($sql_values_fetch['fldState'] == "OR") {?> selected="selected" <? } ?>>OR</option>
        <option value="PA" <? if($sql_values_fetch['fldState'] == "PA") {?> selected="selected" <? } ?>>PA</option>
        <option value="RI" <? if($sql_values_fetch['fldState'] == "RI") {?> selected="selected" <? } ?>>RI</option>
        <option value="SC" <? if($sql_values_fetch['fldState'] == "SC") {?> selected="selected" <? } ?>>SC</option>
        <option value="SD" <? if($sql_values_fetch['fldState'] == "SD") {?> selected="selected" <? } ?>>SD</option>
        <option value="TN" <? if($sql_values_fetch['fldState'] == "TN") {?> selected="selected" <? } ?>>TN</option>
        <option value="TX" <? if($sql_values_fetch['fldState'] == "TX") {?> selected="selected" <? } ?>>TX</option>
        <option value="UT" <? if($sql_values_fetch['fldState'] == "UT") {?> selected="selected" <? } ?>>UT</option>
        <option value="VT" <? if($sql_values_fetch['fldState'] == "VT") {?> selected="selected" <? } ?>>VT</option>
        <option value="VA" <? if($sql_values_fetch['fldState'] == "VA") {?> selected="selected" <? } ?>>VA</option>
        <option value="WA" <? if($sql_values_fetch['fldState'] == "WA") {?> selected="selected" <? } ?>>WA</option>
        <option value="WV" <? if($sql_values_fetch['fldState'] == "WV") {?> selected="selected" <? } ?>>WV</option>
        <option value="WI" <? if($sql_values_fetch['fldState'] == "WI") {?> selected="selected" <? } ?>>WI</option>
        <option value="WY" <? if($sql_values_fetch['fldState'] == "WY") {?> selected="selected" <? } ?>>WY</option>
              </select></td>
          </tr>
          <tr>
            <td><span class="lab">Insurance Company </span></td>
            <td><input name="insurancecompanyname" type="text" class="myinput3" value="<?=$sql_values_fetch['fldInsuranceCompanyName']?>" /></td>
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
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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

            <td><span class="lab">Phone #</span></td>
            <td><input name="privatephone" type="text" class="myinput1" value="<?=$sql_values_fetch['fldPrivatePhoneNumber']?>" /></td>
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
              <input type="submit" name="submit" value="Add" />
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
if($_REQUEST['submit']!='')
{

if($_REQUEST['patientid']=='')
{
$i=0;
$sql="SELECT * from tblorderdetails where 1";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$ptid=$row['fldPatientID'];
if(is_numeric($ptid))
{
$arr[$i++]=$ptid;
}
}
$pid=max($arr);
if($pid < 25001)
{
$pid=25000;
}
$pid = $pid + 1;
}
else
{
$pid=$_REQUEST['patientid'];
}


function formatdate($sDate1)
{
$sDate = split('-', $sDate1);
$sDate1 = $sDate[2].'-'.$sDate[0].'-'.$sDate[1];
return $sDate1;
}

$newdob = formatdate($_REQUEST['dob']);

function phone_number($sPhone){
    $sPhone = ereg_replace("[^0-9]",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.")".$sPrefix."-".$sNumber;
    return($sPhone);
}

$cretime=date("Y-m-d",time());

$orddate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate1']) . ' ' . $_REQUEST['schdate2']));
$schdate = date('Y-m-d H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
$cddate = formatdate($_REQUEST['cddate']);

$ordphy=$_REQUEST['orderingphysicians'];
if($ordphy == "new")
{
$ordphy=$_REQUEST['phynew'];
}

$dispatched=0;
$technologist='';
$facy=$_REQUEST['facility'];
$sql_values_fetch_fac =	mysql_fetch_array(mysql_query("select * from tblfacility where fldFacilityName='$facy'"));
$adisp=$sql_values_fetch_fac['fldAutoDispatch'];
if($adisp==1)
{
$dispatched=1;
$technologist=$sql_values_fetch_fac['fldTechnologist'];
}

$sql_insert = mysql_query("insert into tblorderdetails set
fldPatientID='".strtoupper(strip_tags(addslashes($pid)))."',
fldSchDate='".strtoupper(strip_tags(addslashes($schdate)))."',
fldPatientSSN='".strtoupper(strip_tags(addslashes($_REQUEST['patientssn'])))."',
fldFirstName='".strtoupper(strip_tags(addslashes($_REQUEST['firstname'])))."',
fldLastName='".strtoupper(strip_tags(addslashes($_REQUEST['lastname'])))."',
fldMiddleName='".strtoupper(strip_tags(addslashes($_REQUEST['middlename'])))."',
fldSurName='".strtoupper(strip_tags(addslashes($_REQUEST['surname'])))."',
fldDOB='".strtoupper(strip_tags(addslashes($newdob)))."',
fldGender='".(strip_tags(addslashes($_REQUEST['sex'])))."',
fldInsurance='".(strip_tags(addslashes($_REQUEST['insurance'])))."',
fldMedicareNumber='".strtoupper(strip_tags(addslashes($_REQUEST['medicare'])))."',
fldMedicaidNumber='".strtoupper(strip_tags(addslashes($_REQUEST['medicaid'])))."',
fldState='".(strip_tags(addslashes($_REQUEST['state'])))."',
fldInsuranceCompanyName='".strtoupper(strip_tags(addslashes($_REQUEST['insurancecompanyname'])))."',
fldHmoContract='".strtoupper(strip_tags(addslashes($_REQUEST['hmo_contract'])))."',
fldPolicy='".strtoupper(strip_tags(addslashes($_REQUEST['policy'])))."',
fldGroup='".strtoupper(strip_tags(addslashes($_REQUEST['group'])))."',
fldResponsiblePerson='".strtoupper(strip_tags(addslashes($_REQUEST['responsibleperson'])))."',
fldRelationship='".(strip_tags(addslashes($_REQUEST['relationship'])))."',
fldFacilityName='".(strip_tags(addslashes($_REQUEST['facility'])))."',
fldFacPhone='".(phone_number($_REQUEST['faccontact']))."',
fldPrivateAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress1'])))."',
fldPrivateAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['privatestreetaddress2'])))."',
fldPrivateAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['privatecity'])))."',
fldPrivateAddressState='".(strip_tags(addslashes($_REQUEST['privatestate'])))."',
fldPrivateAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['privatezipcode'])))."',
fldPrivatePhoneNumber='".strtoupper(phone_number($_REQUEST['privatephone']))."',
fldHomeAddressLine1='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress1'])))."',
fldHomeAddressLine2='".strtoupper(strip_tags(addslashes($_REQUEST['homestreetaddress2'])))."',
fldHomeAddressCity='".strtoupper(strip_tags(addslashes($_REQUEST['homecity'])))."',
fldHomeAddressState='".(strip_tags(addslashes($_REQUEST['homestate'])))."',
fldHomeAddressZip='".strtoupper(strip_tags(addslashes($_REQUEST['homezipcode'])))."',
fldHomePhoneNumber='".strtoupper(strip_tags(addslashes($_REQUEST['homephone'])))."',
fldStat='".strtoupper(strip_tags(addslashes($_REQUEST['stat'])))."',
fldOrderingPhysicians='".(strip_tags(addslashes($ordphy)))."',
fldRequestedBy='".strtoupper(strip_tags(addslashes($_REQUEST['requester'])))."',
fldProcedure1='".(strip_tags(addslashes($_REQUEST['procedure1'])))."',
fldProcedure2='".(strip_tags(addslashes($_REQUEST['procedure2'])))."',
fldProcedure3='".(strip_tags(addslashes($_REQUEST['procedure3'])))."',
fldProcedure4='".(strip_tags(addslashes($_REQUEST['procedure4'])))."',
fldProcedure5='".(strip_tags(addslashes($_REQUEST['procedure5'])))."',
fldProcedure6='".(strip_tags(addslashes($_REQUEST['procedure6'])))."',
fldplr1='".(strip_tags(addslashes($_REQUEST['plr1'])))."',
fldplr2='".(strip_tags(addslashes($_REQUEST['plr2'])))."',
fldplr3='".(strip_tags(addslashes($_REQUEST['plr3'])))."',
fldplr4='".(strip_tags(addslashes($_REQUEST['plr4'])))."',
fldplr5='".(strip_tags(addslashes($_REQUEST['plr5'])))."',
fldplr6='".(strip_tags(addslashes($_REQUEST['plr6'])))."',
fldSymptom1='".(strip_tags(addslashes($_REQUEST['symptoms1'])))."',
fldSymptom2='".(strip_tags(addslashes($_REQUEST['symptoms2'])))."',
fldSymptom3='".(strip_tags(addslashes($_REQUEST['symptoms3'])))."',
fldSymptom4='".(strip_tags(addslashes($_REQUEST['symptoms4'])))."',
fldSymptom5='".(strip_tags(addslashes($_REQUEST['symptoms5'])))."',
fldSymptom6='".(strip_tags(addslashes($_REQUEST['symptoms6'])))."',
fldPatientroom='".strtoupper(strip_tags(addslashes($_REQUEST['patientroom'])))."',
fldAfterhours='".strtoupper(strip_tags(addslashes($_REQUEST['afterhours'])))."',
fldHistory='".strtoupper(strip_tags(addslashes($_REQUEST['history'])))."',
fldCDRequested='".(strip_tags(addslashes($_REQUEST['cdrequested'])))."',
fldSymptoms='".strtoupper(strip_tags(addslashes($_REQUEST['symptoms'])))."',
fldCDAddr='".strtoupper(strip_tags(addslashes($_REQUEST['cdaddr'])))."',
fldCDDate='".strtoupper(strip_tags(addslashes($cddate)))."',
fldUserName='".strtoupper(strip_tags(addslashes($_SESSION['user'])))."',
fldDate='".strtoupper(strip_tags(addslashes($orddate)))."',
fldCreDate='".strtoupper(strip_tags(addslashes($cretime)))."',
fldDispatched='".strtoupper(strip_tags(addslashes($dispatched)))."',
fldTechnologist='".strtoupper(strip_tags(addslashes($technologist)))."',
fldpps='".strtoupper(strip_tags(addslashes($_REQUEST['pps'])))."',
created_by = '".$_SESSION['user']."',
created_date = '".date('Y-m-d H:i:s')."'
") or die (mysql_error());
$id =	mysql_insert_id();
$txtid = $id;
$id =   $txtid;

if($sql_insert)
{
$sql_insert_icd	= mysql_query("insert into tblicdcodes set
fldOrderid='".(strip_tags(addslashes($id)))."'
") or die (mysql_error());

if($sql_insert_icd)
{
include "pdf_neworder.php";
}

//////////////////////////
// Read POST request params into global vars
//$to1=$sql_values_fetch['fldEmailSendOrders1'];
//$to2=$sql_values_fetch['fldEmailSendOrders2'];

//$from = "Douglas <dpotter@mdipacs.net>";
//$to=$to1 . ";" . $to2;
//$subject = "MDI Imaging & Reffering Physician - Order";
//$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
//$text = "Hi,\r\n\r\nPlease find the attached receipt for Order Placed at MDF Imaging & Referring Physician\r\n\r\nRegards\r\nMDF Imaging & Referring Physician";
//$file = $filename; // attachment
//$crlf = "\n";
//  $mime = new Mail_mime($crlf);
//  $mime->setTXTBody($text);
//  $mime->addAttachment($file, 'text/plain');
//  $body = $mime->get();
//  $headers = $mime->headers($headers);
//  $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => false, 'username' => $username,'password' => $password));
//  $mail = $smtp->send($to, $headers, $body);

//email to facility
//$fac = $_REQUEST['facility'];
//$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblfacility where fldFacilityName = '$fac'"));
//if($sql_values_fetch['fldEmailOrder'] == 1)
//{
//$to = $sql_values_fetch['fldEmail'];
//$mail = $smtp->send($to, $headers, $body);
//}


$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblsettings"));
$txtdest=$sql_values_fetch['flddmwl'];

$stringData0 = "[RecordNum1] \r";
$stringData0 .= "Patient Name = " . $_REQUEST['lastname'] . "\t^" . $_REQUEST['firstname'] . "\r";
$stringData0 .= "Patient ID = " . $pid . "\r";

$stringData0 .= "Date of Birth = " . $newdob . "\r";
$stringData0 .= "Additional Patient History = " . $_REQUEST['history'] . "\r";
$stemp = $_REQUEST['sex'];
if ($stemp == 'male')
{
$txtsex = 'M';
}
if ($stemp == 'female')
{
$txtsex = 'F';
}
$stringData0 .= "Sex = " . $txtsex. "\r";
function formatDatez($dDate){
$dNewDate = strtotime($dDate);
return date('Ymd-His',$dNewDate);
}

$stringData1 = "Referring Physician = " . $ordphy . "\r";
$stringData1 .= "Scheduled AE Station = crvan \r";

$schdate = date('Y-m-d',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
$schtime = date('H:i',strtotime(formatdate($_REQUEST['schdate12']) . ' ' . $_REQUEST['schdate22']));
$stringData2 = "Scheduled Start Date = " . $schdate . "\r";
$stringData2 .= "Scheduled Start Time = " . $schtime . "\r";

$dob = $_REQUEST['dob'];
$sDate = split('-', $dob);
$sDate1 = $sDate[2].$sDate[0].$sDate[1];
$hi7_dob=$sDate1;


$hi7dest="hi7/";
$hi7_time=date("mdY",time());

$hi7_1="MSH|^~\&|Ig bu|MDImaging|Test|Pacific Mobile Diagnostics|";
$hi7_2 .="||ORM^O01|00000";
$hi7_2 .=$hi7_time;
$hi7_2 .="|P|2.3|||NE|NE" . "\r";
$hi7_2 .="PID|";
$hi7_2 .=$pid;
$hi7_2 .="|";
$hi7_2 .=$pid;
$hi7_2 .="|";
$hi7_2 .=$pid;
$hi7_21 =$_REQUEST['lastname'] . "^" . $_REQUEST['firstname'] . "^" . $_REQUEST['middlename'] . "^" . $_REQUEST['surname'];
$hi7_21 .="||";
$hi7_21 .=$hi7_dob;
$hi7_21 .="|";
$hi7_21 .=$txtsex;
$hi7_21 .="||U|||||U|||000-00-0000" . "\r";
$hi7_21 .="PV1|";
$hi7_21 .=$pid;
$hi7_21 .="|O|BUF^^buffalo^MDImaging||||Referring|";
$hi7_21 .=$ordphy . "\r";
$hi7_21 .="ORC|SC|";
$hi7_3 .="|S||^^^";
$hi7_3 .=$hi7_time;
$hi7_3 .="^^N||||||||||||||Pacific Mobile Diagnostics" . "\r";
$hi7_3 .="OBR|1|";

$pr1 = $_REQUEST['procedure1'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " . $_REQUEST['symptoms1'] . "\r" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r";
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr1'] . " " . $_REQUEST['procedure1'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr1'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr1'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms1'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr2 = $_REQUEST['procedure2'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms2'] . "\r" . $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr2'] . " " . $_REQUEST['procedure2'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-2||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr2'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr2'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms2'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr3 = $_REQUEST['procedure3'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms3'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr3'] . " " . $_REQUEST['procedure3'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-3||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr3'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr3'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms3'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr4 = $_REQUEST['procedure4'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms4'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr4'] . " " . $_REQUEST['procedure4'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-4||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr4'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr4'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms4'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr5 = $_REQUEST['procedure5'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms5'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr5'] . " " . $_REQUEST['procedure5'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-5||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr5'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr5'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms5'];

fwrite($fh, $hi7_txt);
fclose($fh);
}

$pr6 = $_REQUEST['procedure6'];
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

$stringData = $stringData0 . "Accession Number  = " . $acsno . "\r" . "Admitting Diagnoses Discription  = " .$_REQUEST['symptoms6'] . "\r" .  $stringData1 . "Modality = " . $sql_values_fetch_mod['fldModality'] . "\r" ;
$stringData .= $stringData2 . "Requested Procedure ID =  " . $sql_values_fetch_mod['fldCBTCode'] . "\r"  . "Requested Procedure Description = " . $_REQUEST['plr6'] . " " . $_REQUEST['procedure6'] . "\r";
$stringData = strtoupper($stringData);
fwrite($fh, $stringData);
fclose($fh);

$myFile = $hi7dest . $acsno . ".txt";
$fh = fopen($myFile, 'w') or die("can't open file");

$hi7_txt=$hi7_1 .  $acsno . $hi7_2 . "-6||" . $hi7_21 . $acsno . "||^" . $_REQUEST['plr6'] .  $hi7_3 . $acsno . "||" . $sql_values_fetch_mod['fldCBTCode'] . "^" . $_REQUEST['plr6'];
$hi7_txt .="|||||||||||||||||||||||||||" . $_REQUEST['symptoms6'];

fwrite($fh, $hi6_txt);
fclose($fh);
}

$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);

}
}
?>

