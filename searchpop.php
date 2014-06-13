<?php
$orderType = $_GET['order_type'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Search</title>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
	window.resizeTo(400, 275);
	window.status.enable = 0;
</script>
<script type="text/javascript">
	function return_back(search)
	{
		if(search == false)
		{
			window.returnValue = '?pg=21&order_type='+<?=$orderType?>;
			self.close();
		}
		else
		{
			window.returnValue = '?pg=32&order_type=<?=$orderType?>&srch=' + $("#field").val() +"&keyword="+ $("#keyword").val();
			self.close();
		}
	};
	
	$('#document').load(function(){
		$('#search').validate();
	});
</script>
</head>
<body background="main.png">
	<form id='search'>
		Please Enter the Keyword to Search<br/>
		<br/>
		<input type="text" name="field" id="field">
		<select name="keyword" id="keyword">
			<option value="fldPatientID">Patient ID</option>
			<option value="fldPatientSSN">Patient SSN</option>
			<option value="fldLastName">Last Name</option>
			<option value="fldFirstName">First Name</option>
			<option value="fldDate">Order Date</option>
			<option value="fldSchDate">Exam Date</option>
			<option value="fldFacilityName">Facility</option>
		</select>
		<input type="button" onclick="return_back(true);" value="Search"><br />
		<br />
	</form>
	<form>
	<input type="button" value="Close" onClick="return_back(false);window.close()">
	</form>
	<p>Wild cards '*' can be used when searching text fields</p>
</body>
</html>
<??>
