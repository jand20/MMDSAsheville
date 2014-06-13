<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
	include "config.php";
// get the request
$q = $_GET['q'];

$contact = '';

$sql_contact = "SELECT
		fldPhone,
		fldFax
		FROM tbluser
		WHERE
		fldRole='orderingphysician'
		AND fldRealName='".$q."'";

if($result = mysql_query($sql_contact))
{
	while($row = mysql_fetch_array($result)) 
	{
		$contact=$row['fldPhone']."~".$row['fldFax'];
	}
}
// print back as plain javascript
echo "$contact";
?>
