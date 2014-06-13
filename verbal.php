<?php #MDI OOE Demo
ini_set('display_errors', 0);

if(empty($_SESSION))
	session_start();

if(empty($_SESSION['user']))// if session is not set redirect the user
	header("Location:index.php");

include_once "config.php";
include_once 'common.php';

$role	= $_SESSION['role'];
$userState = $_SESSION['userState'];

$sql_values_fetch = mysql_fetch_array(mysql_query("select *,DATE_FORMAT(tr_modified_date,'%m/%d/%Y %H:%i') AS tr_modified_date_formated from tblorderdetails where fldID='$id'"));

//die(print_r($sql_values_fetch,true));

$type = $sql_values_fetch['fldOrderType'];

$typearray = array("","Nursing Home Order","Correctional Facility","Home Bound Orders","Lab Orders");
?>

<style type="text/css">
@import "timer/jquery.timeentry.css";
</style>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#myform").validate();
	//initialization of all general date fields
	$(".datepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "mm-dd-yy",
			autoSize: true,
			yearRange: "-01:+01"
	});
	//initialization of all DOB date fields with larger date range
	$(".dobdatepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "mm-dd-yy",
			autoSize: true,
			yearRange: "1850:2050"
	});
	
	$(".timepicker").timepicker({
			timeFormat: "HH:mm",
			autoSize: true
	});

	<?//dispatch date/time
	if(!empty($sql_values_fetch['fldDispatchedDate']) && ($sql_values_fetch['fldDispatchedDate'] !== '0000-00-00 00:00:00')):
		list($y,$M,$d,$h,$m,$s) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldDispatchedDate']);?>

		var dispatchedDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>, <?=$s?>);
		$("#dispatchedDate").datepicker('setDate',dispatchedDate);
		$("#dispatchedTime").timepicker('setTime',dispatchedDate);
	<?endif;
	
	//mark completed date/time
	if(!empty($sql_values_fetch['fldMarkCompletedDate']) && $sql_values_fetch['fldMarkCompletedDate'] !== '0000-00-00 00:00:00'):
		list($y,$M,$d,$h,$m,$s) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldMarkCompletedDate']);?>

		var completedDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>, <?=$s?>);
		$("#fldMarkCompletedDate").datepicker('setDate',completedDate);
		$("#etime").timepicker('setTime',completedDate);
	<?endif;
	

	//lab/images delivered date time
	if(!empty($sql_values_fetch['fldLabDeliveredDate']) && $sql_values_fetch['fldLabDeliveredDate'] !== '0000-00-00'):
		$labDeliveredDate = date('m-d-Y', $sql_values_fetch['fldLabDeliveredDate']);
		
		list($y,$M,$d) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldLabDeliveredDate']);
		
		if(!empty($sql_values_fetch['fldLabDeliveredTime'])):
			$labDeliveredTime = date("H:i:s",$sql_values_fetch['fldLabDeliveredTime']);
		
			list($h,$m,$s) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldLabDeliveredTime']);?>

			var deliveredDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>, <?=$s?>);
			$("#fldLabDeliveredDate").datepicker('setDate',deliveredDate);
			$("#fldLabDeliveredTime").timepicker('setTime',deliveredDate);
		<?else:?>
			var deliveredDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>);
			$("#fldLabDeliveredDate").datepicker('setDate',deliveredDate);
			$("#fldLabDeliveredTime").timepicker('setTime',new Date());
		<?endif;
	endif;
	
	//report called to date time
	if($sql_values_fetch['fldReportCalledToDateTime'] && $sql_values_fetch['fldReportCalledToDateTime'] != '0000-00-00 00:00:00'):
		$rcttime=date("H:i:s",$sql_values_fetch['fldReportCalledToDateTime']);
		$rctdate=date("m-d-Y",$sql_values_fetch['fldReportCalledToDateTime']);
		
		list($y,$M,$d,$h,$m,$s) = preg_split('/[\s|\-|:]/', $sql_values_fetch['fldReportCalledToDateTime']);?>

		var reportCalledDate = new Date(<?=$y?>, <?=$M?>-1, <?=$d?>, <?=$h?>, <?=$m?>, <?=$s?>);
		$("#fldReportCalledToDateTime").datepicker('setDate',reportCalledDate);
		$("#rcttime").timepicker('setTime',reportCalledDate);
	<?endif;
	
	//CD Requested Date
	if(isset($sql_values_fetch['fldCDDate']) && $sql_values_fetch['fldCDDate'] != "0000-00-00"):
		list($y,$M,$d) = preg_split('/\-/', $sql_values_fetch['fldCDDate']);
		if(isset($sql_values_fetch['fldCDTimeRequested'])):
			list($h,$m) = preg_split('/\:/', $sql_values_fetch['fldCDTimeRequested']);
		else:
			$h = $m = 0;
		endif;?>
		
		var timeCDOrdered = new Date(<?=$y?>,<?=$M?>-1,<?=$d?>,<?=$h?>,<?=$m?>);
		$("#fldCDDate").datepicker('setDate',timeCDOrdered);
		$("#fldCDTimeRequested").timepicker('setTime',timeCDOrdered);
	<?endif;

	//CD Shipped date
	if(!empty($sql_values_fetch['fldCDShipDate']) && $sql_values_fetch['fldCDShipDate'] !== '0000-00-00'):
		list($y,$M,$d) = preg_split('/\-/', $sql_values_fetch['fldCDShipDate']);?>
		
		var cdShipDate = new Date(<?=$y?>,<?=$M?>-1,<?=$d?>);

		$("#fldCDShipDate").datepicker('setDate',cdShipDate);
	<?endif;?>

	$("#repeat1").change(function(){
		if($(this).prop("checked"))
		{
			alert("This will create a new order"); 
			$("#reorderBtn").removeAttr("disabled");
		}
		else
		{
			$("#reorderBtn").attr("disabled","disabled");
		}
	});

	$(".timepicker").mask("99:99");
	$(".timepicker").attr("size","5");
		
});
</script>
<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="jquery-ui-timepicker-addon.css" rel="stylesheet"
	type="text/css" />

<script type='text/javascript'>
function getCurrentDateTime(){
	var d = new Date();
	var hrs = d.getHours();
	var min = d.getMinutes();
	if(hrs < 10){
		hrs = '0'+hrs;
	}
	if(min < 10){
		min = '0'+min;
	}	
	return hrs+":"+min;
//	return parseInt(d.getTime()/1000));
}
function updateTechName(obj,idn){
	
	if(obj.checked == true ){
//		document.getElementById('dispatchtech'+idn).value='<?=$_SESSION['user']?>';
		document.getElementById('dispatchtech'+idn).value='<?=($sql_values_fetch['fldTechnologist'])?$sql_values_fetch['fldTechnologist']:$_SESSION['user'];?>';
		document.getElementById('fldTechComplete'+idn).value='<?=($sql_values_fetch['fldtechComplete'])?$sql_values_fetch['fldtechComplete']:'0';?>';
		document.getElementById('fldLabDeliveredDate'+idn).value='<?=($sql_values_fetch['fldLabDeliveredDate'])?$sql_values_fetch['fldLabDeliveredDate']:'';?>';
		document.getElementById('fldLabDeliveredTime'+idn).value='<?=($sql_values_fetch['fldLabDeliveredTime'])?$sql_values_fetch['fldLabDeliveredTime']:'';?>';
		document.getElementById('fldRepeatReason'+idn).style.backgroundColor ="#FFFF99";
	}
	else{
		document.getElementById('fldRepeatReason'+idn).style.backgroundColor ="#FFFFFF";
		document.getElementById('dispatchtech'+idn).value='';
		document.getElementById('fldTechComplete'+idn).value='';
		document.getElementById('fldLabDeliveredDate'+idn).value='';
		document.getElementById('fldLabDeliveredTime'+idn).value='';
	}
};

function repeatOrder()
{
	//get order id
	var oid = <?=$id?>;
	var proNumber = {};
	$('[name^="repeatprocedure"]:checked').each(function(key,value){
		var field = $(this).attr("id").replace("repeatprocedure", "fldProcedure");
		var index = 'procedure'+(key+1);
		proNumber[index] = field;
		//alert(key+", "+value);
	});

	proNumber.pg		= "21";
	proNumber.id		= oid;
	proNumber.reorder	= "1";
	
	var urlStr	= JSON.stringify(proNumber);

	urlStr = 'index.php?'+$.param(proNumber);
	
	window.open(urlStr);
}

</script>
<link href="style.css" rel="stylesheet" type="text/css">
<form action="" method="post" id="myform">
	<input type='hidden' name='histtime' id='histtime'>
	<script type='text/javascript'>

var d2 = new Date(); 
var fy = d2.getFullYear();

var fm = d2.getMonth()+1;
if(fm < 10){
	fm = '0'+fm;
}
var dt = d2.getDate();
if(dt < 10){
	dt = '0'+dt;
}
var se = d2.getSeconds();
if(se < 10){
	se = '0'+se;
}
document.getElementById('histtime').value = fy+"-"+fm+"-"+dt+" "+getCurrentDateTime()+":"+se;
//alert(document.getElementById('histtime').value);

</script>
	<table style="border: 0; background: url('main.png'); padding: 10px;">
		<tr>
			<td colspan='8'
				style='text-align: right; font-weight: bold; font-size: 1.2em; text-decoration: underline;'>
				<font face='arial' size='2em'><?=strtoupper($typearray[$type])?></font>
			</td>
		</tr>
		<tr>
			<td colspan='8'><span class="lab">Order Placed Date/Time: </span>
			<span class="dis" style="text-align: left;"> <?=date("m/d/Y H:i:s", strtotime($sql_values_fetch['fldDate']));?></span>
			</td>
		</tr>
		<tr>
			<td colspan='8'>
				<span class="lab">Scheduled Exam Date/Time: </span>
				<span class="dis" style="text-align: left;"> <?=date("m/d/Y H:i:s", strtotime($sql_values_fetch['fldSchDate'].' '.$sql_values_fetch['fldSchTime']));?></span>
			</td>
		</tr>
		<tr>
			<td><br/></td>
		</tr>
		<tr>
			<td><span class="lab"> Last Updated by: <?=$sql_values_fetch['tr_modified_by'];?></span></td>
			<td><span class="lab">at: <?=$sql_values_fetch['tr_modified_date_formated'];?></span></td>
		</tr>
		<tr>
			<td><br /></td>
		</tr>
		<tr>
			<td><span class="lab">Priority</span></td>
			<td><span class="dis">
			<?=($sql_values_fetch['fldStat'] == 0)?'Routine':'Stat';
			
			if($sql_values_fetch['fldTestPriority'] == 1) echo "&nbsp;Weekend";
			
			if($sql_values_fetch['fldUnscheduled'] == 1) echo "&nbsp;Unscheduled";?>
				</span>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='8'><br />
			<hr /></td>
		</tr>
		<!-- patient demographics -->
		<tr>
			<td colspan="2"><strong>Patient Information</strong></td>
		</tr>
		<tr>
			<td><span class="lab">Last Name</span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch['fldLastName'])?></span></td>
			<td><span class="lab">First Name</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldFirstName'])?></span></td>
			<td><nobr><span class="lab">Middle Name</span></nobr></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldMiddleName'])?></span>
			</td>
		</tr>
		<tr>
			<td><span class="lab"><?=($type == 2)?"Inmate # ":"Patient MR# ";?></span>
			</td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch['fldPatientID'])?></span>
			</td>
			<td><span class="lab">DOB</span></td>
			<td><span class="dis"><?=date("m-d-Y",strtotime($sql_values_fetch['fldDOB']));?></span>
			</td>
			<td><span class="lab">Patient SSN</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPatientSSN'])?></span>
			</td>
			<td><span class="lab">Sex&nbsp;</span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch['fldGender'])?></span>
			</td>
		</tr>
		<tr>
			<td colspan='8'>&nbsp;
				<hr />
			</td>
		</tr>
		<!-- facility information -->
		<tr>
			<td colspan="2"><strong>Facility Information</strong></td>
		</tr>
	<?if($type >= 3):?>
		<tr>
			<td><nobr>
					<span class="lab">Location Facility</span>
				</nobr></td>
			<td><nobr>
					<span class="dis"><a
						href="index.php?pg=73&facility=<?=strtoupper($sql_values_fetch['fldLocFacName'])?>"><?=strtoupper($sql_values_fetch['fldLocFacName'])?></a></span>
				</nobr></td>
			<td></td>
			<td class="lab">Location Phone:</td>
			<td><span class="dis"><?=phoneFormatter($sql_values_fetch['fldPrivatePhoneNumber']);?></span></td>
		</tr>
		<tr>
			<td><span class="lab">Room #</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPatientroom'])?>&nbsp;</span></td>
		</tr>
		<tr>
			<td><span class="lab">Address #1</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateAddressLine1'])?></span></td>
		</tr>
		<tr>
			<td><span class="lab">Address #2</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateAddressLine2'])?></span></td>
		</tr>
		<tr>
			<td><span class="lab">City</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateAddressCity'])?></span></td>
		</tr>
		<tr>
			<td><span class="lab">State</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateAddressState'])?></span></td>
		</tr>
		<tr>
			<td><span class="lab">Zip</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateAddressZip'])?></span></td>
		</tr>
	<?endif;?>
		<tr>
			<td><br /></td>
		</tr>
		<tr>
			<td><nobr>
					<span class="lab">Ordering Facility Name:&nbsp;</span>
				</nobr></td>
			<td><span class="dis"> <nobr>
						<a
							href="index.php?pg=73&facility=<?=strtoupper($sql_values_fetch['fldFacilityName'])?>"><?=strtoupper($sql_values_fetch['fldFacilityName'])?></a>&nbsp;
					</nobr>
			</span></td>
			<td class="lab"><nobr>Facility Phone:</nobr></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch['fldFacPhone'])?></span>
			</td>
		</tr>
		<tr>
			<td><br /></td>
		</tr>
	<?if(!empty($sql_values_fetch['fldStation']) && $sql_values_fetch['fldStation'] !== 'NA'):
		$stationSql = "select * from tblstations where facId = (select fldID from tblfacility where fldFacilityName = '{$sql_values_fetch['fldFacilityName']}') and StationName = '{$sql_values_fetch['fldStation']}'";
		//echo $stationSql;
		$stationInfo = mysql_query($stationSql) or die(mysql_error());
		
		if($stationInfo):
			$stationInfo = mysql_fetch_assoc($stationInfo);
			$stationPhone = $stationInfo['StationPhone'];
			$stationFax = $stationInfo['StationFax'];
		endif;?>
		<tr>
			<td><nobr>
					<span class="lab">Station:</span>
				</nobr></td>
			<td colspan="2"><span class="dis"><?=strtoupper($sql_values_fetch['fldStation']);?></span>
			</td>
			<td class="lab"><nobr>Station Phone:</nobr></td>
			<td colspan="2"><span class="dis"> <?=$stationPhone?phoneFormatter($stationPhone):'';?></span>
			</td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td class="lab"><nobr>Station Fax:</nobr></td>
			<td colspan="2"><span class="dis"> <?=$stationPhone?phoneFormatter($stationFax):'';?></span>
			</td>
		</tr>
		<?endif;?>
	<?if($type < 3):?>
		<tr>
			<td><span class="lab">Room #</span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPatientroom'])?>&nbsp;</span>
			</td>
			<td>&nbsp;</td>
		</tr>
	<?if($type==2)://correctional institution?>
		<tr>
			<td><nobr>
					<span class="lab">Housing Unit #</span>
				</nobr></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldPrivateHousingNo'])?></span>
			</td>
		</tr>
	<?endif;
	endif;?>
		<tr>
			<td><span class="lab">Ordering Physician: </span></td>
			<td><span class="dis"><?=strtoupper($sql_values_fetch['fldOrderingPhysicians'])?></span>
			</td>
		</tr>
		<tr>
			<td colspan="10"><hr /></td>
		</tr>
		<!-- study/procedure/test information -->
		<tr>
			<td colspan="2"><nobr>
					<strong>Procedure Information</strong>
				</nobr></td>
		</tr>
<?if($type !=4)://IMAGING
	for ($i = 1; $i < 11; $i++):
		if(!empty($sql_values_fetch["fldProcedure$i"])):?>
		<tr>
			<td><span class="lab">Procedure #<?=$i?></span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch["fldProcedure$i"])?></span></td>
			<td><span class="lab">L/R</span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch["fldplr$i"])?></span></td>
			<td><span class="lab">Symptom </span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch["fldSymptom$i"])?></span></td>
			<td><span class="lab">Pos/Neg</span></td>
			<td><select name="sign<?=$i?>">
					<option value=""
						<?=($sql_values_fetch["fldSign$i"] === '')?'selected="selected"':''?>>Select</option>
					<option value="1"
						<?=($sql_values_fetch["fldSign$i"] === '1')?'selected="selected"':''?>>Positive</option>
					<option value="0"
						<?=($sql_values_fetch["fldSign$i"] === '0')?'selected="selected"':''?>>Negative</option>
			</select></td>
		</tr>
	<?else: break;
	endif;
endfor;?>
<?else://LAB
	for ($i = 1; $i < 11; $i++):
		if(!empty($sql_values_fetch["fldProcedure$i"])):?>
		<tr>
			<td><span class="lab">Test #<?=$i?></span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch["fldProcedure$i"])?></span></td>
			<td><span class="dis"><?=$sql_values_fetch["fldLabDraw$i"]?> </span></td>
			<td><span class="dis"> <?=strtoupper($sql_values_fetch["fldplr$i"])?></span></td>
			<?php
			$sql = "SELECT fldValue FROM tbllists WHERE fldListName ='Draw Loc' AND fldValue !='' order by fldValue ASC";
			$result = mysql_query($sql);
			$opt1 = "<option value=''>Select</option>\n";
			while($row = mysql_fetch_array($result)):
				$val = strtoupper($row['fldValue']);

				$opt1 .= ($val === $sql_values_fetch['drawLocation'])? "<option value='$val' SELECTED>$val</option>\n":"<option value='$val'>$val</option>\n";
			endwhile;
			?>
			<!-- <td><span class="lab">Draw Location</span></td>
			<td><select onChange="document.getElementById('drawlocation').value=this.options[this.selectedIndex].value;if(document.getElementById('drawlocation').value == ''){document.getElementById('drawlocation').value=document.getElementById('dldummy').value;document.getElementById('dldummy').style.display='';}else{document.getElementById('dldummy').style.display='none';}"><?=$opt1?></select><input type='text' name='dldummy' id='dldummy'value='<?=$sql_values_fetch['drawLocation']?>' onchange="document.getElementById('drawlocation').value=this.value;"><input type='hidden' id='drawlocation' name='drawlocation' value='<?=$sql_values_fetch['drawLocation']?>'></td>
			</tr>-->
		</tr>
	<?else: break;
		endif;
	endfor;
endif;/*?>
		<tr><td colspan="10"><hr/></td></tr>
		<!-- REPEAT SECTION -->
		<?for($i=1;$i<11;$i++):
			$isDisabled = 'disabled';
			$checked = ($sql_values_fetch["repeat1procedure$i"] == 1)?"checked='checked'":'';
			$onclick = "onclick='$(\"#dummyrepeatprocedure$i\").val($(this).val());'";
				
			if(!empty($sql_values_fetch["fldProcedure$i"]))
				$isDisabled = "";

			$chk .= "<label>$i<input type='checkbox' name='repeatprocedure$i' id='repeatprocedure$i' value='1' $checked $isDisabled /></label>";
			//<input type='hidden' name='repeatprocedure$i' id='dummyrepeatprocedure$i' $checked/>";
			//$chkt .= "<span style='margin-right:6px;margin-left:6px;'>$i</span>";
		endfor;?>
		<tr>
			<td><span class="lab">Repeat Procedure</span></td>
			<td><span class="lab">Tech Name</span></td>
			<td><nobr><span class="lab">Reason to repeat</span></nobr></td>
			<td colspan='2' style="text-align: right"><span class="lab">Exam # to repeat</span> </td>
		</tr>
		<tr>
			<td>
				<nobr>
					<input type='checkbox' name='repeat1' id='repeat1' value='yes' <?=($sql_values_fetch['fldDispatchTech1'])?'checked readonly':''?> onclick='updateTechName(this, 1)' />
				</nobr>
			</td>
			<td>
				<nobr>
					<input type='text' name='dispatchtech1' id='dispatchtech1' value='<?=$sql_values_fetch['fldDispatchTech1']?>' <?=($sql_values_fetch['fldDispatchTech1'])?'readonly="readonly"':''?> />
				</nobr>
			</td>
			<td colspan='2'>
				<input type='text' name='fldRepeatReason1' id='fldRepeatReason1' value='<?=$sql_values_fetch['fldRepeatReason1']?>' <?=($sql_values_fetch['fldDispatchTech1'])?'readonly="readonly"':''?> />
			</td>
			<td colspan="2"><nobr><?=$chk?></nobr></td>
		</tr>
		<tr>
			<td>
				<input type="button" id="reorderBtn" value="Create Repeat Order" onclick="repeatOrder();" disabled />
			</td>
		</tr>
		<tr>
			<td>
				<input type='hidden' name='fldTechComplete1' id='fldTechComplete1'>
				<input type='hidden' name='fldLabDeliveredDate1' id='fldLabDeliveredDate1'>
				<input type='hidden' name='fldLabDeliveredTime1' id='fldLabDeliveredTime1'>
				<input type='hidden' name='fldTechComplete2' id='fldTechComplete2'>
				<input type='hidden' name='fldLabDeliveredDate2' id='fldLabDeliveredDate2'>
				<input type='hidden' name='fldLabDeliveredTime2' id='fldLabDeliveredTime2'>
				<input type='hidden' name='fldTechComplete3' id='fldTechComplete3'>
				<input type='hidden' name='fldLabDeliveredDate3' id='fldLabDeliveredDate3'>
				<input type='hidden' name='fldLabDeliveredTime3' id='fldLabDeliveredTime3'>
			</td>
		</tr>
		<tr><td colspan="10"><hr/></td></tr><?*/?>
		<!-- PATIENT NOTES SECTION -->
		<tr>
			<td><span class="lab">Additional Patient Info:</span></td>
		</tr>
		<tr>
			<td colspan="8"><span class="dis"><?=strtoupper($sql_values_fetch['fldSymptoms'])?></span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><span class="lab">History:</span></td>
		</tr>
		<tr>
			<td colspan="8"><span class="dis"> <?=strtoupper($sql_values_fetch['fldHistory'])?></span></td>
		</tr>
		<tr>
			<td colspan="10"><hr /></td>
		</tr>
		<tr>
			<td colspan="2"><strong>Workflow Information</strong></td>
		</tr>
		<!-- Workflow -->
		<!-- Dispatched Info -->
		<tr>
			<td><span class="lab">Dispatched to:</span></td>
			<td colspan="2"><span class="dis"> <select name='dispatchedTo'
					id='dispatchedTo'>
						<option value=''>SELECT</option>
					<?$statecheck = ($userState !== '')?"and fldMainState = '$userState'":'';
					$sql = "SELECT * FROM tbluser WHERE fldRole = 'technologist' $statecheck and fldStatus <> 'Disabled' order by fldrealname asc";
					//die(print_r($sql,1));
					$rs = mysql_query($sql);

					while($data = mysql_fetch_array($rs)):?>
						<option value=<?=strtoupper($data['fldUserName'])?>
							<?=(strtoupper($data['fldUserName']) === strtoupper($sql_values_fetch['fldTechnologist'])?'selected="selected"':'')?>>
							<?=strtoupper($data['fldRealName'])?>
						</option>
					<?endwhile;?>
				</select>
			</span></td>
		</tr>
		<tr>
			<td><span class="lab">Dispatched Date &amp; Time:</span></td>
			<td colspan="2"><nobr>
					<span class="dis"> <input id="dispatchedDate" name="dispatchedDate"
						type="text" value="" class="datepicker" /> <input
						id='dispatchedTime' name="dispatchedTime" type="text" value=""
						class="timepicker" /> <input type='button' value='Now'
						onClick="$('#dispatchedTime').datepicker('setTime', new Date()); $('#dispatchedDate').datepicker('setDate', new Date());" />
					</span>&nbsp;24-Hour format ex. 4:30 PM is 16:30
				</nobr></td>
		</tr>
		<!-- <tr>
			<td><span class="lab">Tech Received:</span></td>
			<td colspan="2" align='left'>
				<select name="pps">
					<option value="" <?=($sql_values_fetch['fldpps'] === '')?'selected="selected"':''?>>Select</option>
					<option value="yes" <?=($sql_values_fetch['fldpps'] == 'yes')?'selected="selected"':''?>>Yes</option>
					<option value="no" <?=($sql_values_fetch['fldpps'] == 'no')?'selected="selected"':''?>>No</option>
				</select>
			</td>
		</tr>-->
		<tr>
			<td><br /></td>
		</tr>
		<!-- Tech complete info -->
		<tr>
			<td><span class="lab">Tech Completed Date &amp; Time:</span></td>
			<td style='text-align: left;' colspan="3"><nobr>
					<input type='hidden' name='fldMarkCompletedDatePrev' value=''> <input
						name="fldMarkCompletedDate" type="text" value=""
						id="fldMarkCompletedDate" class="datepicker" /> <input
						name="etime" type="text" value="" id="etime" class="timepicker" />
					<input type='button' value='Now'
						onClick="$('#etime').datepicker('setTime', new Date()); $('#fldMarkCompletedDate').datepicker('setDate', new Date());" />
					24-Hour format ex. 4:30 PM is 16:30
				</nobr></td>
		</tr>
		<tr>
			<td><br /></td>
		</tr>
	<?if($type == 4 )://LAB
		//draw location
		$sql = "SELECT fldValue FROM tbllists WHERE fldListName ='Draw Loc' AND fldValue !='' order by fldValue ASC";
		$result = mysql_query($sql);
		$opt1 = "<option value=''>Select</option>\n";
		while($row = mysql_fetch_array($result)):
			$val = strtoupper($row['fldValue']);
			
			$opt1 .= ($val == $sql_values_fetch['drawLocation'])?"<option value='$val' SELECTED>$val</option>\n":"<option value='$val'>$val</option>\n";
		endwhile;?>
	<!-- Lab Draw Location -->
		<tr>
			<td><span class="lab">Draw Location</span></td>
			<td colspan='2'><nobr>
					<select
						onChange="document.getElementById('drawlocation').value=this.options[this.selectedIndex].value;if(document.getElementById('drawlocation').value == ''){document.getElementById('drawlocation').value=document.getElementById('dldummy').value;document.getElementById('dldummy').style.display='';}else{document.getElementById('dldummy').style.display='none';document.getElementById('labSentTo').focus();}"><?=$opt1?></select>
					<input type='text' name='dldummy' id='dldummy'
						value='<?=$sql_values_fetch['drawLocation']?>'
						onchange="document.getElementById('drawlocation').value=this.value;" />
					<input type='hidden' id='drawlocation' name='drawlocation'
						value='<?=$sql_values_fetch['drawLocation']?>' />
				</nobr></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	<?endif;?>
		<!-- LAB/IMAGES Sent to -->
		<tr>
			<td><span class="lab"><?=($type == 4)?"Lab":"Images"?> Sent to:</span></td>
			<td colspan="2"><span class="dis"> <select name='labSentTo'
					id='labSentTo'>
						<option value=''>SELECT</option>
					<?
					$labOrXray =($type == 4)?"= 'Lab'":"= 'radiologist' AND fldValue !=''";
					$sql = "SELECT tbllists.fldValue FROM tbllists WHERE tbllists.fldListName $labOrXray order by fldValue";
					$rs = mysql_query($sql);
					while($data = mysql_fetch_array($rs)):?>
						<option value='<?=strtoupper($data['fldValue'])?>'
							<?=(strtoupper($data['fldValue']) === strtoupper($sql_values_fetch['labSentTo']))?"selected='selected'":''?>><?=strtoupper($data['fldValue'])?></option>
					<?endwhile;?>
					</select>
			</span> <input type='hidden' name='fldLabDeliveredDatePrev'
				value='<?=$sql_values_fetch['fldLabDeliveredDate']?>'></td>
		</tr>
		<!-- Delivered DATE/TIME -->
		<tr>
			<td><span class="lab"><?=($type == 4)?"Lab":"Images"?> Delivered Date &amp; Time:</span></td>
			<td colspan="3"><nobr>
					<span class="dis"> <input name="fldLabDeliveredDate" type="text"
						id="fldLabDeliveredDate" value="<?=$labDeliveredDate?>"
						class="datepicker" />
					</span> <span class="dis"> <input ID='fldLabDeliveredTime'
						name="fldLabDeliveredTime" type="text"
						value="<?=$labDeliveredTime?>" class="timepicker" /> <input
						type='button' value='Now'
						onClick="$('#fldLabDeliveredTime').datepicker('setTime', new Date()); $('#fldLabDeliveredDate').datepicker('setDate', new Date());">
					</span> 24-Hour format ex. 4:30 PM is 16:30
				</nobr></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<!-- Report called to -->
			<td><span class="lab">Report Called to: </span></td>
			<td><input name="ReportCalledTo" type="text" id="ReportCalledTo"
				value="<?=$sql_values_fetch['fldReportCalledTo']?>" /></td>
		</tr>
		<tr>
		
		
		<tr>
			<td><span class="lab">Report Called to Date/Time: </span></td>
			<td style='text-align: left;' colspan="3"><nobr>
					<input type=hidden name='fldReportCalledToDateTimePrev'
						value='<?=$sql_values_fetch['fldReportCalledToDateTime']?>'> <input
						name="fldReportCalledToDateTime" type="text"
						id="fldReportCalledToDateTime" value="<?=$rctdate?>"
						class="datepicker" /> <input name="rcttime" type="text"
						value="<?=$rcttime?>" id="rcttime" class="timepicker" /> <input
						type='button' value='Now'
						onClick="$('#rcttime').datepicker('setTime', new Date()); $('#fldReportCalledToDateTime').datepicker('setDate', new Date()); <?=($type == 4)?"$('#ReportCalledTo').val('NCR');":''?>">
					24-Hour format ex. 4:30 PM is 16:30
				</nobr></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<!-- TECH NOTES -->
		<tr>
			<td><span class="lab">Tech Notes: </span></td>
		</tr>
		<tr>
			<td colspan="8"><textarea name="ReportDetails" cols="100" rows="3"><?=strtoupper($sql_values_fetch['fldReportDetails'])?></textarea>
				<input type='hidden' name="ReportDetailsPrev"
				value='<?=strtoupper($sql_values_fetch['fldReportDetails'])?>'></td>
		</tr>
		<tr>
			<td colspan='8'>&nbsp;
				<hr />
			</td>
		</tr>
		<!-- BACKUP DISC REQUEST -->
		<tr>
			<td><span class="lab">Film/CD Requested:</span></td>
			<td style='text-align: left;'><select name='fldCDRequested'>
					<option value='0'>Select</option>
					<option value='1'
						<?=($sql_values_fetch['fldCDRequested'] == 1 )?"selected='selected'":'';?>>Film</option>
					<option value='2'
						<?=($sql_values_fetch['fldCDRequested'] == 2 )?"selected='selected'":'';?>>CD</option>
			</select></td>
		</tr>
		<tr>
			<td><span class="lab">Date Needed:</span></td>
			<td style='text-align: left;'><input type="text" class="datepicker"
				id="fldCDDate" name="fldCDDate" /></td>
	<?if( $type==4):?>
			<td><span class="lab">Time Needed:</span></td>
			<td style='text-align: left;'><input type='text'
				id='fldCDTimeRequested' name='fldCDTimeRequested' class="timepicker" />
				<input type='button' value='Now'
				onClick="var rightnow = new Date(); $('#fldCDTimeRequested').timepicker('setTime',rightnow);" />
			</td>
	<?endif;?>
		</tr>
		<tr>
			<td><span class="lab">Date Shipped: </span></td>
			<td style='text-align: left;'><input type="text" class="datepicker"
				id="fldCDShipDate" name="cdshipdate" /></td>
		</tr>
		<tr>
			<td colspan='8'>&nbsp;
				<hr />
			</td>
		</tr>
		<!-- ACTION/SUBMIT BUTTONS -->
		<tr>
			<td colspan="10">
				<div align="center" style="margin: 10px;">
					<nobr>
						<input type="submit" name="submit" value="Update" /> <input
							type="button" name="cancel" value="Cancel"
							onClick="window.location.href='manageorders.php'" />
					</nobr>
				</div>
			</td>
		</tr>
	</table>
</form>
<?
if($_REQUEST['submit'] !== '' && isset($_REQUEST['submit']))
{
	//die(var_dump($_REQUEST));
	//$orderStatus = $sql_values_fetch['fldStatus'];

	/*get base status ie 410 = completed repeat stat
	$tempStatus = $orderStatus%100;//430 -> 30

	if(!empty($_REQUEST['dispatchedDate']) && !empty($_REQUEST['dispatchedTime']))//if dispatched 30 -> 230
	{
		$orderStatus = $tempStatus + 200;
		
		if(!empty($_REQUEST['fldMarkCompletedDate']))//if completed 30 -> 430
		{
			$orderStatus = $tempStatus + 400;
	
			if(!empty($_REQUEST['labSentTo']))//if sent to be read 30 -> 530
			{
				$orderStatus = $tempStatus + 500;
					
				if (!empty($_REQUEST['ReportCalledTo']))//if report called in all types set to 830
				{
					$orderStatus = 830;
				}
			}
		}
	}

	updateOrderStatus($id, $orderStatus);

	if($orderStatus > 499 && $orderStatus < 600)
		updateOrderStatus($id, $orderStatus+100);

	//die(print_r($orderStatus,true));//*/

	function formatDate2($dDate)
	{
		$dNewDate = strtotime($dDate);
		return date('Y-m-d',$dNewDate);
	}

	if($_REQUEST['schdate1'])
	{
		$time1=$_REQUEST['schdate1'];
		$rptime=formatdate2($time1);
		$sDate1 = $time1;
		$sDate2 = split('-', $sDate1);
		$shdate = $sDate2[2].'-'.$sDate2[0].'-'.$sDate2[1];
		$rptime =$shdate . " " . $_REQUEST['schdate2'];
	}
	
	$dispatchedDate = '';
	if(!empty($_REQUEST['dispatchedDate']) && !empty($_REQUEST['dispatchedTime']))
	{
		$dispatched = ",fldDispatched='1'";
		list($M,$d,$y,$h,$m,$s) = preg_split('/[\s|\-|:]/', $_REQUEST['dispatchedDate'].' '.$_REQUEST['dispatchedTime']);
		$dispatchedDate = date("Y-m-d H:i:s",mktime($h,$m,0,$M,$d,$y));
	}
	
	if($type == 4 && !empty($_REQUEST['labSentTo']))
	{
		$confirmed = ", fldTechComplete='1'";
	}
	
	$batch = '';
	//die(print_r($_REQUEST['ReportCalledTo'],true));
	if($_REQUEST['ReportCalledTo']!="")
	{
		$verbal = "1";
		$batch	= ",isLabBatch = '0'";
	}
	
	$reportCalledDT = '';
	if(!empty($_REQUEST['fldReportCalledToDateTime']))
	{
		list($m,$d,$y) = split('-', $_REQUEST['fldReportCalledToDateTime']);
		list($h,$i) = split(":", $_REQUEST['rcttime']);
		$reportCalledDT	= date("Y-m-d H:i", mktime($h,$i,0,$m,$d,$y));
	}
	
	$markedCompleteDT = '';
	if(!empty($_REQUEST['fldMarkCompletedDate']))
	{
		list($m,$d,$y) = split('-', $_REQUEST['fldMarkCompletedDate']);
		list($h,$i) = split(":", $_REQUEST['etime']);
		$markedCompleteDT	= date("Y-m-d H:i", mktime($h,$i,0,$m,$d,$y));
	}
	
	$cdDate	= '';
	$cdTime = '';
	if(!empty($_REQUEST['fldCDDate']))
	{
		list($m,$d,$y) = split('-', $_REQUEST['fldCDDate']);
		list($h,$i) = split(":", $_REQUEST['fldCDTimeRequested']);
		$cdDate	= date("Y-m-d", mktime(0,0,0,$m,$d,$y));
		$cdTime = date("H:i", mktime($h,$i));
	}
	
	$cdShipDate = '';
	if(!empty($_REQUEST['cdshipdate']))
	{
		list($m,$d,$y) = split('-', $_REQUEST['cdshipdate']);
		$cdShipDate	= date("Y-m-d", mktime(0,0,0,$m,$d,$y));
	}
	
	$labDeliveredDate	= '';
	$labDeliveredTime	= '';
	if(!empty($_REQUEST['fldLabDeliveredDate']))
	{
		list($m,$d,$y) = split('-', $_REQUEST['fldLabDeliveredDate']);
		list($h,$i) = split(":", $_REQUEST['fldLabDeliveredTime']);
		$labDeliveredDate	= date("Y-m-d", mktime(0,0,0,$m,$d,$y));
		$labDeliveredTime	= date("H:i", mktime($h,$i));
	}
	
	$sql = "update tblorderdetails set ";
	
	for($i = 1; $i < 11; $i++)
	{
		$sql .= "fldSign$i = '".$_REQUEST["sign$i"]."', ";
	}
	
	$sql .= "fldVerbal='$verbal',
				fldReportDate='$rptime',
				fldReportCalledToDateTime='$reportCalledDT',
				fldReportCalledTo='".$_REQUEST['ReportCalledTo']."',
				fldReportDetails='".$_REQUEST['ReportDetails']."',
				fldRadiologist='".$_REQUEST['radiologist']."',
				fldExamDate='".$_REQUEST['etime']."',
				fldCDShipDate='$cdShipDate',
				fldCDTimeRequested='$cdTime',
				tr_modified_by = '".$_SESSION['user']."',
				fldCDRequested = '".$_REQUEST['fldCDRequested']."',
				fldCDDate = '$cdDate',
				fldMarkCompletedDate = '$markedCompleteDT',
				labSentTo = '". $_REQUEST['labSentTo']."',
				fldLabDeliveredDate = '$labDeliveredDate',
				fldLabDeliveredTime = '$labDeliveredTime',
				fldTechnologist = '{$_REQUEST['dispatchedTo']}',
				fldDispatchedDate = '$dispatchedDate',
				tr_modified_date = '$currentDateTime'
				$dispatched
				$confirmed
				where fldID='".$id."'";//TODO add in lab draw location...
	
	/*
	die(print_r($sql,true));//*/
	
	$sql_insert = mysql_query($sql) or die("ERROR updating order: ".mysql_error());
	
	
	//echo $_REQUEST['repeat1'],$_REQUEST['repeat2'],$_REQUEST['repeat3']. "<br/>";
	
	//die(print_r($_REQUEST,true));
	
	#print $query;
	#print $sql;
	#exit(0);
	
	
	#print $sql;
	# fldLabDelivered = '". $_REQUEST['fldLabDelivered']."',
	#exit(0);
	
	#echo "<pre>$_REQUEST[fldMarkCompletedDate]:00 != $_REQUEST[fldMarkCompletedDatePrev]</pre>";
	
	
	preg_replace('/\:\d\d$/i',':00',$_REQUEST['fldMarkCompletedDatePrev']);
	
	
	if($_REQUEST['fldMarkCompletedDate'] && $_REQUEST['fldMarkCompletedDate'].":00" != $_REQUEST['fldMarkCompletedDatePrev'])
	{
	
	#echo "<pre>$_REQUEST[fldMarkCompletedDate]:00 != $_REQUEST[fldMarkCompletedDatePrev]</pre>";
	
	
	
		$query = "UPDATE tblorderdetails
					SET fldtechComplete = 1,
					fldMarkCompletedBy = '".$_SESSION['user']."'
					WHERE fldID ='$id'";
			
		if(mysql_query($query)){
			if($_REQUEST['fldMarkCompletedDatePrev'] && $_REQUEST['fldMarkCompletedDatePrev'] != '0000-00-00 00:00:00' ){
				$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Mark completed updated', '$currentDateTime')";
			}
			else{
				$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Mark Completed', '$currentDateTime')";
			}
			mysql_query($query);
		}
	
	}
	
	#echo "<pre> LAB DLIVERED ~$_REQUEST[fldLabDeliveredDate]~ != ~$_REQUEST[fldLabDeliveredDatePrev]~</pre>";

	if($_REQUEST['fldLabDeliveredDate'] && $_REQUEST['fldLabDeliveredDate'] !== $_REQUEST['fldLabDeliveredDatePrev'])
	{
		$query = "UPDATE tblorderdetails
		SET fldLabDelivered = 1
		WHERE fldID ='$id'";
		
		if(mysql_query($query))
		{
			if($type == 4 )
			{
				if($_REQUEST['fldLabDeliveredDatePrev'] && $_REQUEST['fldLabDeliveredDatePrev'] != '0000-00-00')
				{
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Lab delivered to updated', '$currentDateTime')";
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Confirmation updated', '$currentDateTime')";
				}
				else
				{
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Lab delivered to', '$currentDateTime')";
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Order confirmed', '$currentDateTime')";
				}
			}
			else
			{
				if($_REQUEST['fldLabDeliveredDatePrev'] && $_REQUEST['fldLabDeliveredDatePrev'] != '0000-00-00')
				{
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Images delivered to updated', '$currentDateTime')";
				}
				else
				{
					$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Images delivered to', '$currentDateTime')";
				}
			}
			mysql_query($query);
		}
	
	}

	if($_REQUEST['fldReportCalledToDateTime'] && $_REQUEST['fldReportCalledToDateTime'] != $_REQUEST['fldReportCalledToDateTimePrev'])
	{
		/* $query = "UPDATE tblorderdetails
			SET fldstat = 2
		WHERE fldID ='$id' AND fldStat = 1";
		mysql_query($query); */
	
		if($_REQUEST['fldReportCalledToDateTimePrev'] && $_REQUEST['fldReportCalledToDateTimePrev'] != '0000-00-00' )
		{
			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Confirmation updated', '$currentDateTime')";
		}
		else
		{
			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Order confirmed', '$currentDateTime')";
		}
		mysql_query($query);
	}
	
	if($_REQUEST['ReportDetails'] != $_REQUEST['ReportDetailsPrev'])
	{
	
		if($_REQUEST['ReportDetailsPrev'] && $_REQUEST['ReportDetailsPrev'] != '0000-00-00' )
		{
			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '".$_SESSION['user']."', 'Tech notes updated', '$currentDateTime')";
		}
		else
		{
			$query = " INSERT INTO tblhistory(fldID, flduser, fldEventType, fldEventDateTime) VALUES ('$id', '". $_SESSION ['user'] . "', 'Tech notes added', '$currentDateTime')";
		}
		
		mysql_query($query);
	}
	//exit(0);
		
	if ($sql_insert)
	{
		include 'pdf_neworder.php';
		
		$redirecturl = "index.php?pg=20";
		header("location:".$redirecturl);
	}
}
?>