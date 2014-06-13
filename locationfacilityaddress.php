<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
include "config.php";
// get the request
$q = $_GET['q'];
              

$sql_contact = "SELECT * FROM tblfacility WHERE fldFacilityName='".$q."'";
$result = mysql_query($sql_contact);



while($row = mysql_fetch_array($result)) {
    $sqlst = "SELECT * FROM tblstates WHERE fldst='".$row['fldAddressState']."'";
    $rslt = mysql_query($sqlst);
    $state = mysql_fetch_array($rslt);        
    $contact=$row['fldAddressLine1']."~".$row['fldAddressLine2']."~".$row['fldAddressCity']."~".$state['fldState']."~".$row['fldAddressZip']."~".$row['fldPhoneNumber']."~".$row['fldFaxNumber'];
}
// print back as plain javascript
echo "$contact";
?>
