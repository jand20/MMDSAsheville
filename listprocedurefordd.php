<?php
// if session is not set redirect the user
if(empty($_SESSION['user']))
//header("Location:index.php");
include "config.php";
// get the request
$q = $_GET['q'];
              
if($q == 'XRAY'){
    $sql = "SELECT * FROM tblproceduremanagment WHERE fldModality ='CR' order by fldDescription";
}
else if ($q == 'EKG'){
    $sql = "SELECT * FROM tblproceduremanagment WHERE fldModality ='EKG' order by fldDescription";

}
else if ($q == 'ECHO'){
    $sql = "SELECT * FROM tblproceduremanagment WHERE fldModality ='ECHO' order by fldDescription";

}
else{
    $sql = "SELECT * FROM tblproceduremanagment WHERE fldModality ='US' order by fldDescription";
}
#echo $sql."<br>";
$result = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($result)) {
    $procs[$i] = $row['fldDescription'];
    $i++;
}
// print back as plain text
echo join("~",$procs);
?>
