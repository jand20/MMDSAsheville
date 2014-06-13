<?php
include "config.php";

$sql = "SELECT fldFirstName, fldLastName, fldMiddleName, fldDate, fldProcedure1, fldProcedure2, fldProcedure3, fldProcedure4, fldProcedure5, fldProcedure6, fldProcedure7, fldProcedure8, fldProcedure9, fldProcedure10,fldFacilityName FROM tblorderdetails WHERE fldLastName='".$_REQUEST['lastname']."' AND fldPatientID='".$_REQUEST['patientmr']."' ORDER BY fldDate DESC";

$result = mysql_query($sql);

$row = mysql_fetch_assoc($result);
?>
<html>
<header>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.hist{border-left: 1px solid #AAAAAA;border-top: 1px solid #AAAAAA;cell-spacing:0px;cell-padding:0px}
.hist td{border-bottom: 1px solid #AAAAAA;border-right: 1px solid #AAAAAA;}
.hist th{white-space:nowrap;border-bottom: 1px solid #AAAAAA;border-right: 1px solid #AAAAAA;background-color:#CAE8EA;padding:5px;}
</style>
</header>
<body>
<table >
<tr><td colspan="2" style='text-align:center ;font-size: 16px; font-weight: bold; color: rgb(0, 0, 255); text-align: center;'><u><b>History</b></u></td></tr>
<tr><td style='width:150px'><b>First Name : </b></td><td><?=$row['fldFirstName']?></td></tr>
<tr><td><b>Middle Name :</b></td><td><?=$row['fldMiddleName']?></td></tr>
<tr><td><b>Last Name :</b></td><td><?=$row['fldLastName']?></td></tr>
<tr><td colspan="2">
<table class='hist' cellspacing=0 cellpadding=0 border=0>
<tr><th>Date</th><th>Facility</th><th>Procedure(s)</th></tr>
    <tr><td>&nbsp;<?=$row['fldDate']?></td><td>&nbsp;<?=$row['fldFacilityName']?></td><td>&nbsp;<?
    if($row['fldProcedure1']){echo "1).".$row['fldProcedure1'];}
    if($row['fldProcedure2']){echo "<br>\n2).".$row['fldProcedure2'];}
    if($row['fldProcedure3']){echo "<br>\n3).".$row['fldProcedure3'];}
    if($row['fldProcedure4']){echo "<br>\n4).".$row['fldProcedure4'];}
    if($row['fldProcedure5']){echo "<br>\n5).".$row['fldProcedure5'];}
    if($row['fldProcedure6']){echo "<br>\n6).".$row['fldProcedure6'];}
    if($row['fldProcedure7']){echo "<br>\n7).".$row['fldProcedure7'];}
    if($row['fldProcedure8']){echo "<br>\n8).".$row['fldProcedure8'];}
    if($row['fldProcedure9']){echo "<br>\n9).".$row['fldProcedure9'];}
    if($row['fldProcedure10']){echo "<br>\n10).".$row['fldProcedure10'];}
    ?></td></tr>
<?
while( $row = mysql_fetch_assoc($result)){
?><tr><td>&nbsp;<?=$row['fldDate']?></td><td>&nbsp;<?=$row['fldFacilityName']?></td><td>&nbsp;<?
    if($row['fldProcedure1']){echo "1).".$row['fldProcedure1'];}
    if($row['fldProcedure2']){echo "<br>\n2).".$row['fldProcedure2'];}
    if($row['fldProcedure3']){echo "<br>\n3).".$row['fldProcedure3'];}
    if($row['fldProcedure4']){echo "<br>\n4).".$row['fldProcedure4'];}
    if($row['fldProcedure5']){echo "<br>\n5).".$row['fldProcedure5'];}
    if($row['fldProcedure6']){echo "<br>\n6).".$row['fldProcedure6'];}
    if($row['fldProcedure7']){echo "<br>\n7).".$row['fldProcedure7'];}
    if($row['fldProcedure8']){echo "<br>\n8).".$row['fldProcedure8'];}
    if($row['fldProcedure9']){echo "<br>\n9).".$row['fldProcedure9'];}
    if($row['fldProcedure10']){echo "<br>\n10).".$row['fldProcedure10'];}
    ?></td></tr><?
}
?>
</table>
</td></tr>
</tale>
</body></html>