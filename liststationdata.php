<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
include "config.php";
// get the request
$q = $_GET['q'];
$fac = $_REQUEST['facname'];

$sql_contact = "SELECT fldID FROM tblfacility WHERE fldFacilityName='".$fac."'";

$result = mysql_query($sql_contact);
list ($fldid) = mysql_fetch_array($result);

$sql = "SELECT * FROM tblstations WHERE facId='$fldid' AND StationName='$q'";
$result = mysql_query($sql);
$i = 0;
$row = mysql_fetch_array($result);

// print back as plain javascript
echo $row['StationPhone']."~".$row['StationFax'];
?>
