<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<script>
function confirm(thisform)
{
with (thisform)
  {
    alert( "Do You Want to Delete." );
  }
}
</script>
<form method="post" onsubmit="return confirm(this);">
<?
$sql_values_fetch = mysql_fetch_array(mysql_query("select * from tblorderdetails where fldID='$id'"));
if($sql_values_fetch['fldException1'] == '' && $sql_values_fetch['fldException1'] == '' && $sql_values_fetch['fldException1'] == '')
{
$sql = "delete from tblorderdetails where fldID='$id'";
$result = mysql_query($sql);
$redirecturl = "index.php?pg=20";
header("Location:".$redirecturl);
}
else
{
$redirecturl = "index.php?pg=48";
header("Location:".$redirecturl);
}

?>
</form>