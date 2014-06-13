<?php 
session_start();
include "config.php";
?>

<form id="form1" name="form1" method="post" action="" onsubmit="return checkData();">
  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" background="main.png">
    <tr>
		<td width="37%" colspan="2" class="lab">
			<div align="center">Enter the Details for Facility Orders Tracking Report </div>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="right"><span class="lab">Select Divisions:</span></td>
        <td>
		  <select name="division" class="myselect2">
			  <option value="-1">All</option>
			<?php
					//add by SonIT
					include 'division_config.php';
					foreach($divisionArray as $key => $value)
					{
						echo "<option value='$key'>$key</option>";
					}

			  ?>
		  </select>
       </td>
     </tr>
	 <tr>
		 <td>&nbsp;</td>
	 </tr>
	 <tr>
       <td align="right"><span class="lab">Has not ordered in (# of days):</span></td>
	   <td><input name="xday" id="xday" class="myselect4" /></td>
     </tr>
     <tr>
       <td height="10" colspan="5">&nbsp;</td>
     </tr>
    <tr>
      <td colspan="5" align="center"><input type="submit" name="submit"  value="Display" /></td>
    </tr>
    <tr>
      <td height="102" colspan="5">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['submit']))
{
    $division   = $_POST['division'];
    $xday		= $_POST['xday'];
    
    $redirecturl = "FTR.php?division=$division&xday=$xday";
    header("Location: ".$redirecturl);
}
?>
<script language="javascript">
	function checkData()
	{
		if(document.getElementById('xday').value == '' || 
			isNaN(document.getElementById('xday').value) ||
			parseInt(document.getElementById('xday').value) <= 0)
		{
			alert('Please enter only number >= 1 for \'Has not ordered in\' field');
			return false;
		}

		return true;
	}
</script>