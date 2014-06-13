<?php
session_start();
/************ Delete the sessions****************/
unset($_SESSION['user']);
unset($_SESSION['role']);

/* Delete the cookies*******************/
setcookie("user", '', time()-60*60*24*60, "/");
setcookie("role", '', time()-60*60*24*60, "/");

/******************* After Logout set this to any redirect page you want*************/
header("Location: index.php");
?>