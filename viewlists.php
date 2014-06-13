<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql = "select * from tbllists order by fldListName";
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
var r=confirm("Are you sure you want  to delete this List");
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
<table id="facility" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-3r no-arrow colstyle-alt rowstyle-alt paginate-10 max-pages-10 paginationcallback-callbackTest-calculateTotalRating sortcompletecallback-callbackTest-calculateTotalRating">
<thead>
  <tr>
    <th width="8%" class="sortable-text datatype-text">List Name</a></th>
    <th width="8%" class="sortable-text datatype-text">Value</a></th>
    <th width="8%" >&nbsp;</th>
    <th width="12%" >&nbsp;</th>
  </tr>
 </thead>
 <tbody>
  <?
  $result = mysql_query($sql);
  while($row = mysql_fetch_array($result)) { ?>
  <tr class="alt">
    <td><?=$row['fldListName']?></td>
    <td class="lft"><?=$row['fldValue']?></td>
    <td><a href="index.php?pg=18&id=<?=$row['fldID']?>">Edit</a></td>
    <td><a href="index.php?pg=19&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a></td>
  </tr>
  <? } ?>
  </tbody>
</table>
</form>

