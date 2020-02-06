<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$value=10;
?>
<form method="get">
<input type="submit" name="next" value="Next" />
<?php
if(isset($_GET['next']))
$value=$value+10;
echo $value;
?>
</body>
</html>