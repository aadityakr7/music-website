<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>English Songs</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

</head>

<body>
<?php
include_once("header.php.inc");
?>
<div class="menuhead"><b>English Songs</b></div>
<?php
require_once("getID3/getid3/getid3.php");
include_once("getID3/getid3/getid3.lib.php");

$page=1;
if(isset($_GET['page']))
{
	$page=$_GET['page'];
}
$start=($page-1)*10;

// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

//Opens directory
$dir="./english";

/*//Gets each entry
while($entryName=readdir($dir))
{
	$dirArray[]=$entryName;
}

//Closes directory
closedir($dir);*/
if(file_exists($dir))
$dirArray=scandir($dir);
else
echo "No files in this directory";

//Counts element in array
$indexCount=count($dirArray);

//Files per page
$per_page=10;

//Number of pages
$page_count=ceil($indexCount/$per_page);

//Defines offset
$offset=$start+2;

//Sorts files
//sort($dirArray);

//Gets subset of array
$selectedFiles=array_slice($dirArray,$offset,10);
$selectedFilesCount=count($selectedFiles);

/*echo "<pre>";
print_r($selectedFiles);
echo "</pre>";*/
//Loops through the array of files
for($index=0;$index<$selectedFilesCount;$index++)
{	

	//Gets file names
	$name=$selectedFiles[$index];
	$namehref=$selectedFiles[$index];
	
	$size=pretty_filesize("$dir/$namehref");
	$fileurl="$dir/$namehref";
	$pageurl=substr($fileurl,2);

$getID3=new getID3;
$ThisFileInfo=$getID3->analyze("$fileurl");
//echo "<pre>";
//print_r($ThisFileInfo['tags']['id3v2']['unsynchronised_lyric'][0]);
//echo "</pre>";
@$title=$ThisFileInfo['tags']['id3v2']['title'][0];
if($title==NULL)
$title="Unknown";
@$artist=$ThisFileInfo['tags']['id3v2']['artist'][0];
if($artist==NULL)
$artist="Unknown";
?>
	<table class='filelist' width='100%' cellspacing='8px' onclick="location.href='./mp3download.php?filename=<?php echo $name;?>&fileurl=<?php echo $fileurl;?>&pageurl=<?php echo $pageurl;?>';">

			<tr><td><a href='./mp3download.php?filename=<?php echo $name;?>&fileurl=<?php echo $fileurl;?>&pageurl=<?php echo $pageurl;?>'><?php echo $title;?></a></td></tr>
			<tr><td><?php echo $artist;?></td></tr>
		</table>

<?php
}
?>
<br /><br />
<center>
<?php
$prev=$page-1;
if($prev!=0)
echo "<a href='?page=$prev' class='paging'>Prev</a>";
else
echo "<font class='paging'>Prev</font>";
echo "<font class='paging'> Page ".$page." of ".$page_count." </font>";
$next=$page+1;
if($page<$page_count)
echo "<a href='?page=$next' class='paging'>Next</a>";
else
echo "<font class='paging'>Next</font>";
?>
<br /><br />
<form method="get">
<font class="paging">Jump Page: </font><input type="text" name="page" size="2" class="paging" required="required" />
<input type="submit" value="Go" style="border-radius:8px; margin:2px; padding:4px; border:solid 2px #FFF; background:rgba(0,204,0,1); color:#FFF; font-weight:bold; cursor:pointer;" />
</form>
</center>
<?php
include_once("footer.php.inc");
?>
</body>
</html>