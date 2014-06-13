<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql = "select * from tblproceduremanagment order by fldID";
?>
<script type="text/javascript" src="paginate.min.js"></script>
<script type="text/javascript" src="tablesort.min.js"></script>
<script type="text/javascript" src="tablefilter.min.js"></script>
<link href="tablesort.css"       rel="stylesheet" type="text/css" />
<link href="paginate.css"   rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="paginate-ie.css"   rel="stylesheet" type="text/css" />
<![endif]-->
<link href="filter.css"   rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<link href="filter-ie6.css"   rel="stylesheet" type="text/css" />
<![endif]-->
<style>
.fdtablePaginatorWrapTop { display:none; }
</style>
<script type="text/javascript">
function show_confirm()
{
var r=confirm("Are you sure you want  to delete this Procedure");
if (r==true)
  {
  return true;
  }
else
  {
  return false;
  }
}
</script>
<form action="" method="post">
<table id="procedure" width="100%" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-3r no-arrow colstyle-alt rowstyle-alt paginate-10 max-pages-10 paginationcallback-callbackTest-calculateTotalRating sortcompletecallback-callbackTest-calculateTotalRating">
<thead>
  <tr>
    <th width="20%" class="sortable-text datatype-text">CPT Code</a></th>
    <th width="20%" class="sortable-text datatype-text">Description</a></th>
    <th width="20%" class="sortable-text datatype-text">Modality</a></th>
    <th width="20%">&nbsp;</th>
    <th colspan="2" width="40%">&nbsp;</th>
  </tr>
 </thead>
 <tbody>
  <?
  $result = mysql_query($sql);
  while($row = mysql_fetch_array($result)) { ?>
  <tr class="alt">
    <td><?=$row['fldCBTCode']?></td>
    <td><?=$row['fldDescription']?></td>
    <td class="lft"><?=$row['fldModality']?></td>
    <td><a href="index.php?pg=10&id=<?=$row['fldID']?>">Edit</a></td>
    <td colspan="2"><a href="index.php?pg=11&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a></td>
  </tr>
  <? } ?>
  </tbody>
</table>
</form>


