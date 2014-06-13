<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
include "config.php";
// get the request
$q = $_GET['q'];
$sql_contact = "select * from tblfacility where fldFacilityName = '".$q."'";
$result = mysql_query($sql_contact);
$row = mysql_fetch_array($result);

$contact = $row['fldPhoneNumber'].'~'.$row['fldFaxNumber'];

//while($row = mysql_fetch_array($result)) {
//    $contact=$row['fldPhoneNumber']+' '+$row['fldFaxNumber']+' '+$row['fldFacilityName'];
//}
// print back as plain javascript

echo $contact;
# echo "<input name='faccontact' type='text' class='myinput1'  value='$contact' />";
?>
