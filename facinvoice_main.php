<?php session_start();
ob_start();
include "config.php";
?>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="main.png">
    <tr>
      <td width="37%" colspan="5" class="lab"><div align="center">Enter the Details to Produce Facility Invoice Report </div></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
     <tr>
      <td height="10" colspan="5"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="15%"><span class="lab">Select Year</span></td>
          <td width="30%"><span class="lab">
          <select name="year" id="year" class="myselect1">
          <option value="2010">2010</option>
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          </select>
          </td>
          <td width="15%"><span class="lab">Select Month</span></td>
          <td width="10%"><span class="lab">
          <select name="month" id="year" class="myselect1">
          <option value="01">Jan</option>
          <option value="02">Feb</option>
          <option value="03">Mar</option>
          <option value="04">Apr</option>
          <option value="05">May</option>
          <option value="06">Jun</option>
          <option value="07">Jul</option>
          <option value="08">Aug</option>
          <option value="09">Sep</option>
          <option value="10">Oct</option>
          <option value="11">Nov</option>
          <option value="12">Dec</option>
          </select>
          </td>
          <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="1"><span class="lab">Select Facilities</span></td>
        <td colspan="3">
      <select name="facility" class="myselect1">
	  <option selected="selected" value=''>Select</option>
	  <?
	  $sql="SELECT * FROM tblfacility where 1  order by fldFacilityName";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result))
	   {?>
	  <option value="<?=$row['fldFacilityName']?>"><?=$row['fldFacilityName']?></option>
	  <? } ?>
	  </select>
       </td>
       </tr>
      </table></td>
    </tr>
     <tr>
       <td height="10" colspan="5">&nbsp;</td>
     </tr>
    <tr>
      <td colspan="5" align="center"><input type="submit" name="submit" value="Display" /></td>
    </tr>
    <tr>
      <td height="102" colspan="5">&nbsp;</td>
    </tr>
  </table>
<?
if($_REQUEST['submit']!='')
{
$fac=$_REQUEST['facility'];
$y=$_REQUEST['year'];
$m=$_REQUEST['month'];
$redirecturl = "?pg=59&dt1=$y&dt2=$m&d=$fac";
header("location:".$redirecturl);
}
?>