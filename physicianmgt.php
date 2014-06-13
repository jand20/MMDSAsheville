<link href="style.css" rel="stylesheet" type="text/css" />
<style type='text/css'>
    th {background-color:#E9E9E9;height:120%;white-space:nowrap;padding:5px;border:1px solid black;}
    .rowone td{background-color:#FFFFFF;height:120%;white-space:nowrap;padding:5px;}
    .rowtwo td{background-color:#E9E9E9;height:120%;white-space:nowrap;padding:5px;}
</style>
<?php 

session_start();
//if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php?pg=74");

include "config.php";include "common.php";

$user = $_SESSION['user'];

if(isset($_REQUEST['action']))
{
    $sql = "UPDATE tblorderdetails SET fldOPNotinDB = 0 WHERE fldID='".$_REQUEST['fldid']."'";
    mysql_query($sql);
    if($_REQUEST['action'] == 'Add')
    {
    	header("Location: index.php?pg=1&md=".$_REQUEST['md']);
    }
    else
    {
    	header("Location: index.php?pg=74");
    }
    die;
}


$sql = "SELECT fldID,fldSchDate,created_by,fldOrderingphysicians from tblorderdetails WHERE fldOPNotinDB = '1'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
#echo $sql;
echo "<table style='border:1px solid #000000;' cellspacing='0' cellpadding='0'><tr><th>Date</th><th>Created By</th><th>Entered Name</th><th>Marked Corrected</th></tr>";

$rowclr = 'rowone';
if($count > 0 )
{
    while( $row = mysql_fetch_array($result))
    {
    	echo "<tr class='$rowclr'><td>".$row['fldSchDate']."</td><td>".$row['created_by']."</td><td>".$row['fldOrderingphysicians']."</td><td><form action='index.php'><input type='hidden' name='fldid' value='".$row['fldID']."'><input type='hidden' name='pg' value='74'><input type='hidden' name='md' value='".$row['fldOrderingphysicians']."'><input type='submit' name='action' value='Add'><input type='submit' name='action' value='Ignore'></form></td>";
        $rowclr = ($rowclr == 'rowone'?'rowtwo':'rowone');
    }
}
else
{
    echo "<tr><td colspan='4'>No data found</td></tr>";
}
echo "</table>";
?>