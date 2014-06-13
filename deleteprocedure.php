<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql = "delete from tblproceduremanagment where fldID='$id'";
$result = mysql_query($sql);
$redirecturl = "index.php?pg=9";
header("Location:".$redirecturl);
?>