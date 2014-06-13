<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql = "select * from tblfacility order by fldID";
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
var r=confirm("Are you sure you want  to delete this Facility");
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
    <th width="8%" class="sortable-text datatype-text">Facility Name</a></th>
    <th width="8%" class="sortable-text datatype-text">Admin Name</a></th>
    <th width="8%" class="sortable-text datatype-text">Division Name</a></th>
    <th width="8%" class="sortable-text datatype-text">Address Line 1</a></th>
    <th width="8%" class="sortable-text datatype-text">Address Line 2</a></th>
    <th width="8%" class="sortable-text datatype-text">City</a></th>
    <th width="8%" class="sortable-text datatype-text">State</a></th>
    <th width="8%" class="sortable-text datatype-text">Zip</a></th>
    <th width="8%" class="sortable-text datatype-text">Email</a></th>
    <th width="8%" class="sortable-text datatype-text">Phone Number</a></th>
    <th width="8%" class="sortable-text datatype-text">Fax Number</a></th>
    <th width="6%" >&nbsp;</th>
    <th width="6%" >&nbsp;</th>
  </tr>
 </thead>
 <tbody>
  <?
  $result = mysql_query($sql);
  while($row = mysql_fetch_array($result)) { ?>
  <tr class="alt">
    <td><?=$row['fldFacilityName']?></td>
    <td><?=$row['fldAdminName']?></td>
    <td><?=$row['fldDivisionName']?></td>
    <td><?=$row['fldAddressLine1']?></td>
    <td><?=$row['fldAddressLine2']?></td>
    <td><?=$row['fldAddressCity']?></td>
    <td><?=$row['fldAddressState']?></td>
    <td><?=$row['fldAddressZip']?></td>
    <td><?=$row['fldEmail']?></td>
    <td><?=$row['fldPhoneNumber']?></td>
    <td class="lft"><?=$row['fldFaxNumber']?></td>
    <td><a href="index.php?pg=14&id=<?=$row['fldID']?>">Edit</a></td>
    <td><a href="index.php?pg=15&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a></td>
  </tr>
  <? } ?>
  </tbody>
</table>
</form>


