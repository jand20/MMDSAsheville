<?php session_start();
// if session is not set redirect the user
if(empty($_SESSION['user']))
header("Location:index.php");
include "config.php";
$sql = "select * from tbluser order by fldRealName ASC";
?>
<script type="text/javascript" src="paginate.min.js"></script>
<script type="text/javascript" src="tablesort.min.js"></script>
<script type="text/javascript" src="tablefilter.min.js"></script>
<link href="tablesort.css" rel="stylesheet" type="text/css" />
<link href="paginate.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="paginate-ie.css"	 rel="stylesheet" type="text/css" />
<![endif]-->
<link href="filter.css"	 rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<link href="filter-ie6.css"	 rel="stylesheet" type="text/css" />
<![endif]-->
<style>
.fdtablePaginatorWrapTop { display:none; }
</style>
<script type="text/javascript">
function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	alert ("Browser does not support HTTP Request");
	return null;
}

function toggleUser(userid,action)
{
	var xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null){return;}
	var url="disableuser.php";
	url=url+"?userid="+encodeURIComponent(userid)+"&action="+encodeURIComponent(action);
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4)
		{
			alert (xmlhttp.responseText);
		}
	};

	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function show_confirm()
{
	var r=confirm("Are you sure you want to delete this User");
	
	if (r==true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function show_disable_confirm(chkbox)
{
	if(chkbox.checked == true)
	{
		var r=confirm("Are you sure you want to disable this User");
		if (r==true)
		{
			toggleUser(chkbox.value,'disable');
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		var r=confirm("Are you sure you want to enable this User");
		if (r==true)
		{
			toggleUser(chkbox.value,'enable');
			return true;
		}
		else
		{
			return false;
		}
	}
}
</script>
<form action="" method="post">
<table id="users" width="100%" cellpadding="0" cellspacing="0" border="0" class="sortable-onload-0 no-arrow colstyle-alt rowstyle-alt paginate-10 max-pages-10 paginationcallback-callbackTest-calculateTotalRating sortcompletecallback-callbackTest-calculateTotalRating">
<thead>
	<tr>
		<th class="sortable-text datatype-text forwardSort">Real Name</th>
		<th class="sortable-text datatype-text">User Name</th>
		<th class="sortable-text datatype-text">E-mail</th>
		<th class="sortable-text datatype-text">Role</th>
		<th class="sortable-text datatype-text">Facility</th>
		<th class="sortable-text datatype-text">Location</th>
		<th>Disabled</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
 </thead>
 <tbody>
		<?
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)):?>
		<tr	class="alt">
		<td><?=$row['fldRealName']?></td>
		<td><?=$row['fldUserName']?></td>
		<td><?=$row['fldEmail']?></td>
		<td><?=$row['fldRole']?></td>
		<?
			$i1=$row['fldID'];
			$sql1 = "select * from tbluserfacdetails where fldUserID='$i1'";
			$result1 = mysql_query($sql1);
			$faclist="";
			while($row1 = mysql_fetch_array($result1))
			{
				if($faclist === "")
				{
					$faclist = $row1['fldFacility'];
				}
				else
				{
					$faclist .= "<br/>" . $row1['fldFacility'];
				}
			}
		?>
		<td><?=$faclist?></td>
		<td><?=$row['fldMainState']?></td>
		<td><form name='disable_form'><input type='checkbox' name='disabled' value='<?=$row['fldID']?>' onclick="return show_disable_confirm(this)" <?=($row['fldStatus']==='Disabled'?'Checked':'');?>></form></td>
		<td><a href="index.php?pg=3&id=<?=$row['fldID']?>">Edit</a></td>
		<td><a href="index.php?pg=4&id=<?=$row['fldID']?>" onclick="return show_confirm()" value="Delete Confirmation">Delete</a></td>
	</tr>
	<?endwhile;?>
	</tbody>
</table>
</form>


