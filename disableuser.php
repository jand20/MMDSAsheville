<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
if($_REQUEST['action'] =='enable'){
    $sql = "UPDATE tbluser SET fldStatus ='Enabled' WHERE fldID = '".$_REQUEST['userid']."'";
    $result = mysql_query($sql);
    if($result){
        echo "Enabled the user successfully.";
    }
    else{
        echo "Error while Enabling the user";
    }
}
else{
    $sql = "UPDATE tbluser SET fldStatus ='Disabled' WHERE fldID = '".$_REQUEST['userid']."'";
    $result = mysql_query($sql);
    if($result){
        echo "Disbled the user successfully";
    }
    else{
        echo "Error while Disabling the user";
    }
}

?>
