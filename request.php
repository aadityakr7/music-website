<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Request</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
<?php
include_once("header.php.inc");
?>
<div class="menuhead"><b>Request a song</b></div>
<br /><br />
<form method="post" action="requestsent.php">
<table cellspacing="4px" cellpadding="4px">
<tr><td>Name: </td><td><input type="text" name="uname" maxlength="20" size="30" required="required" /></td></tr>
<tr><td>Type Request: </td><td><textarea name="message" rows="10" cols="30" maxlength="300"></textarea></td></tr>
<tr><td align="right" colspan="2"><input type="submit" value="Submit" /></td></tr>
</table>
</form>
<br /><br /><br /><br />
<?php
//Establishing database connection
$db=new MySQLi('localhost','root','','mp3');


//Display all database info
$sql="SELECT * from request";
$res=$db->query($sql);
$row_cnt=mysqli_num_rows($res);

for($i=0;$i<$row_cnt;$i++){
	$det=$res->fetch_assoc();
	$uname=$det['uname'];
	$message=$det['message'];
	echo "<div class='formhead'>".$uname."</div>";
	echo "<div class='formmessage'>".$message."</div><br/>";
}
?>
<?php
include_once("footer.php.inc");
?>
</body>
</html>