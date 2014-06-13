<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
include "config.php";
// get the request
$q = $_GET['q'];
              

$sql_contact = "SELECT fldID FROM tblfacility WHERE fldFacilityName='".$q."'";

# echo $sql_contact."<br>";

$result = mysql_query($sql_contact);
list ($fldid) = mysql_fetch_array($result);

$sql = "SELECT * FROM tblstations WHERE facId='$fldid'";

#echo $sql."<br>";
$result = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($result)) {
    $stations[$i] = $row['StationName'];
    $i++;
}
// print back as plain javascript
echo join("~",$stations);
?>
