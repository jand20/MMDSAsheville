<?php

require_once 'config.php';

require_once 'division_config.php';

//repair modality
$query = "SELECT DISTINCT(fldModality) AS name FROM tblproceduremanagment";
$modalityCombo = array('<select id="modality" name="modality">');
$modalityCombo[] = '<option value="">All</option>';
$result = mysql_query($query);
if(mysql_num_rows($result) > 0)
{
	while($row = mysql_fetch_assoc($result))
	{
		$modalityCombo[] = "<option value='{$row['name']}'>{$row['name']}</option>";
	}
}
$modalityCombo[] = '</select>';
$modalityCombo	= implode('', $modalityCombo);

?>
<script type="text/javascript">
	 $(document).ready(function(){
		 $('#fromDate').datepicker({autoSize: true,
                            changeMonth: true,
                            changeYear: true,
                            closeText: 'Close',
                            currentText: 'Now',
                            dateFormat: 'mm/dd/yy',
                            gotoCurrent: true,
                            showButtonPanel: true,
                            showWeek: true,
                            weekHeader: 'Week'
			});

			$('#toDate').datepicker({autoSize: true,
									changeMonth: true,
									changeYear: true,
									closeText: 'Close',
									currentText: 'Now',
									dateFormat: 'mm/dd/yy',
									gotoCurrent: true,
									showButtonPanel: true,
									showWeek: true,
									weekHeader: 'Week'
			});
	 })
</script>
<form name="frmExport" id="frmExport" method="POST"	action="export_daily_report.php">
	<table width="100%" border="0" align="left" cellpadding="5" cellspacing="4" background="main.png">
		<tr>
			<th align="center">Daily Report</th>
		</tr>
		<tr>
			<td width="30%">From Date:</td>
			<td><input name="fromDate" id="fromDate" value="" />
			</td>
		</tr>
		<tr>
			<td>To Date:</td>
			<td><input name="toDate" id="toDate" value="" />
			</td>
		</tr>
		<tr>
			<td>State</td>
			<td><select id="state" name="state" class="myselect2" style="widtd: 50px;">
					<option value="">All</option>
					<option value="CO">NY</option>
					<option value="AZ">PA</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>Select division</td>
			<td><?php echo getDivisionCombo(null,'myselect2', '10', false); ?></td>
		</tr>
		<tr>
			<td>Modality</td>
			<td><?php echo $modalityCombo; ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
			<input type="submit" value="Submit" id="doReport" />
			<input type="reset" value="Clear" id="doClear" />
			</td>
		</tr>
	</table>
</form>
<?php
mysql_close();
?>