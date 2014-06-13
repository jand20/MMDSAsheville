<?php
	//send to this email
	define('EMAIL_RECEIVED',	'admin@dmxok.com');
	define('SUBJECT',			'Email request for access');

	$message = '';
	if(isset($_POST['submit']))
	{
		//get params;
		$body = '
					<table border="0" cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td colspan="2">Form send at '.date('m-d-Y H:i').'
						</tr>
						<tr>
							<td>Name</td>
							<td>'.$_POST['name'].'</td>
						</tr>
						  <tr>
							<td>Facility</td>
							<td>'.$_POST['facility'].'</td>
						  </tr>
						<tr>
							<td>Contact Number</td>
							<td>'.$_POST['contact_number'].'</td>
						</tr>
						<tr>
							<td>Contact Email</td>
							<td>'.$_POST['contact_email'].'</td>
						</tr>
						<tr>
							<td>UN requested</td>
							<td>'.$_POST['un_requested'].'</td>
						</tr>
						<tr>
							<td>PW requested</td>
							<td>'.$_POST['pw_requested'].'</td>
						</tr>
					</table>';
					

		$headers	= "From: admin@dmxok.com\r\n";
		$headers	.= "Content-type: text/html; charset=utf-8\r\n";
		try
		{
			if(mail(EMAIL_RECEIVED, SUBJECT, $body, $headers))
			{
				header('Location: index.php');//the login page of your site is index.php, not login.php
				return;
			}
			else
			{
				$message = 'Can not send inquiry form';
			}
		}
		catch (Exception $e)
		{
			$message = 'Can not send inquiry form. Error : '.$e->getMessage();
		}
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<link href="style.css" rel="stylesheet" type="text/css" />
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
	<script src="https://jquery-joshbush.googlecode.com/files/jquery.maskedinput-1.2.2.min.js" type="text/javascript"></script>
  </head>
  <body>
	  <center>
		<?php
			if($message != '')
			{
				echo '<p style="color:#FF0000">'.$message.'</p>';
			}
		?>
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" background="main.png"  class="loginform">
		<form name="frmReset" id="frmReset" action="forgotpassword.php" method="post">
			<tr>
			    <td width="30%">&nbsp;</td>
				<td width="8%" class="lab">Name</td>
				<td><input name="name" id="name" /></td>
			</tr>
			  <tr>
				<td width="30%">&nbsp;</td>
				<td class="lab">Facility</td>
				<td><input name="facility" id="facility" /></td>
			  </tr>
			<tr>
				<td width="30%">&nbsp;</td>
				<td class="lab">Contact Number</td>
				<td><input name="contact_number" id="contact_number" /></td>
			</tr>
			<tr>
				<td width="30%">&nbsp;</td>
				<td class="lab">Contact Email</td>
				<td><input name="contact_email" id="contact_email" /></td>
			</tr>
			<tr>
				<td width="30%">&nbsp;</td>
				<td class="lab">User Name</td>
				<td><input name="un_requested" id="un_requested" /></td>
			</tr>
			<tr>
				<td width="30%">&nbsp;</td>
				<td class="lab">Password</td>
				<td><input name="pw_requested" id="pw_requested" /></td>
			</tr>
			<tr>
				<td></td>
				<td width="10%">&nbsp;</td>
				<td><input type="submit" value="Send" name="submit" /></td>
			</tr>
		</table>
		</form>
	  </center>
  </body>
</html>
<script language="javascript">
	function checkEmail(emailValue) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailValue)){
			return true;
		}
		return false;
	}

	$(document).ready(function(){
	
		$('#contact_number').mask('999-999-9999');

		$('#frmReset').submit(function(){
			if($('#name').val() == '')
			{
				alert('Please enter Name!');
				$('#name').focus();
				return false;
			}

			if($('#facility').val() == '')
			{
				alert('Please enter Facility!');
				$('#facility').focus();
				return false;
			}

			if($('#contact_number').val() == '')
			{
				alert('Please enter Contact Number!');
				$('#contact_number').focus();
				return false;
			}

			if($('#contact_email').val() == '')
			{
				alert('Please enter Contact Email!');
				$('#contact_email').focus();
				return false;
			}
			
			if(!checkEmail($('#contact_email').val()))
			{
				alert('Please enter correct Contact Email!');
				$('#contact_email').focus();
				return false;
			}

			if($('#un_requested').val() == '')
			{
				alert('Please enter UN requested!');
				$('#un_requested').focus();
				return false;
			}

			if($('#pw_requested').val() == '')
			{
				alert('Please enter PW requested!');
				$('#pw_requested').focus();
				return false;
			}

			return true;
		});

	});
</script>
