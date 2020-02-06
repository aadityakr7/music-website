<?php
$uname=$_POST['uname'];
$message=$_POST['message'];
$db=new MySQLi('localhost','root','','mp3');
$sqlinsert="INSERT INTO request(uname,message) VALUES('$uname','$message')";
$doinsert=$db->query($sqlinsert);
header('Location: request.php');
?>