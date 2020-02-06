<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
<?php
if(isset($_POST['cf_name'])){
$field_name = $_POST['cf_name'];
$field_email = $_POST['cf_email'];
$field_message = $_POST['cf_message'];

$mail_to = 'aaditya.kumar74@gmail.com';
$subject = 'Message from a site visitor '.$field_name;

$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

if ($mail_status) { ?>
	<script language="javascript" type="text/javascript">
		alert('Thank you for the message. We will contact you shortly.');
		window.location = 'index.php';
	</script>
<?php
}
else { ?>
	<script language="javascript" type="text/javascript">
		alert('Message failed. Please, send an email to gordon@template-help.com');
		window.location = 'index.php';
	</script>
<?php
}
}
else{
?>
<?php
include_once("header.php.inc");
?>
<div class="menuhead"><b>Contact us</b></div>
<br /><br />
<form method="post" style="margin-left:20px;">
Your name:<br>
<input type="text" name="cf_name" size="30" maxlength="30" required="required" /><br /><br />
Your e-mail:<br>
<input type="email" name="cf_email" size="30" maxlength="40" required="required" /><br /><br />
Message:<br>
<textarea name="cf_message" rows="7" cols="30"></textarea><br /><br />
<input type="submit" value="Submit" />
<input type="reset" value="Clear" />
</form>
<?php
include_once("footer.php.inc");
}
?>
</body>
</html>