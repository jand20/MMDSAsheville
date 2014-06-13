<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
?>
<?
$sql_insert	= mysql_query("update tblorderdetails set fldDispatched=0, fldTechnologist = '' where fldID='".$id."'");
if($sql_insert)
{
$redirecturl = "index.php?pg=20";
header("location:".$redirecturl);
}
?>