<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Search Results</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
<?php
include_once("header.php.inc");
?>
<?php
require_once("getID3/getid3/getid3.php");
include_once("getID3/getid3/getid3.lib.php");

@$temp=$_GET['query'];
$pattern="/$temp/i";

//Opens directories
$bollywood="./bollywood";
$english="./english";
$punjabi="./punjabi";
$hindipop="./hindipop";
$djremixes="./djremixes";
$funny="./funny";
$devotional="./devotional";
$karaoke="./karaoke";

//Scans directory
$bollywoodArray=scandir($bollywood);
$englishArray=scandir($english);
$punjabiArray=scandir($punjabi);
$hindipopArray=scandir($hindipop);
$djremixesArray=scandir($djremixes);
$funnyArray=scandir($funny);
$devotionalArray=scandir($devotional);
$karaokeArray=scandir($karaoke);

//Counts element in array
$indexCountBollywood=count($bollywoodArray);
$indexCountEnglish=count($englishArray);
$indexCountPunjabi=count($punjabiArray);
$indexCountHindipop=count($hindipopArray);
$indexCountDjremixes=count($djremixesArray);
$indexCountFunny=count($djremixesArray);
$indexCountDevotional=count($devotionalArray);
$indexCountKaraoke=count($karaokeArray);

//Loops through the array of files
for($index=2;$index<$indexCountBollywood;$index++)
{
	$subject1=$bollywoodArray[$index];
	preg_match($pattern,$subject1,$matches1);
	if(array_key_exists(0,$matches1)){
	$pathArray[]="$bollywood/$subject1";
	$fileArray[]=$bollywoodArray[$index];
	}
}

for($index=2;$index<$indexCountEnglish;$index++)
{
	$subject2=$englishArray[$index];
	preg_match($pattern,$subject2,$matches2);
	if(array_key_exists(0,$matches2)){
	$pathArray[]="$english/$subject2";
	$fileArray[]=$englishArray[$index];
	}
}

for($index=2;$index<$indexCountPunjabi;$index++)
{
	$subject3=$punjabiArray[$index];
	preg_match($pattern,$subject3,$matches3);
	if(array_key_exists(0,$matches3)){
	$pathArray[]="punjabi/$subject3";
	$fileArray[]=$punjabiArray[$index];
	}
}

for($index=2;$index<$indexCountHindipop;$index++)
{
	$subject4=$hindipopArray[$index];
	preg_match($pattern,$subject4,$matches4);
	if(array_key_exists(0,$matches4)){
	$pathArray[]="$hindipop/$subject4";
	$fileArray[]=$hindipopArray[$index];
	}
}

for($index=2;$index<$indexCountDjremixes;$index++)
{
	$subject5=$djremixesArray[$index];
	preg_match($pattern,$subject5,$matches5);
	if(array_key_exists(0,$matches5)){
	$pathArray[]="$djremixes/$subject5";
	$fileArray[]=$djremixesArray[$index];
	}
}

for($index=2;$index<$indexCountFunny;$index++)
{
	$subject6=$funnyArray[$index];
	preg_match($pattern,$subject6,$matches6);
	if(array_key_exists(0,$matches6)){
	$pathArray[]="$funny/$subject6";
	$fileArray[]=$funnyArray[$index];
	}
}

for($index=2;$index<$indexCountDevotional;$index++)
{
	$subject7=$devotionalArray[$index];
	preg_match($pattern,$subject7,$matches7);
	if(array_key_exists(0,$matches7)){
	$pathArray[]="$devotional/$subject7";
	$fileArray[]=$devotionalArray[$index];
	}
}

for($index=2;$index<$indexCountKaraoke;$index++)
{
	$subject8=$karaokeArray[$index];
	preg_match($pattern,$subject8,$matches8);
	if(array_key_exists(0,$matches8)){
	$pathArray[]="$karaoke/$subject8";
	$fileArray[]=$karaokeArray[$index];
	}
}
/*echo "<pre>";
print_r($fileArray);
echo "</pre>";
echo "<pre>";
print_r($pathArray);
echo "</pre>";*/
?>
<div class="menuhead"><b>Showing results for <?php echo $temp;?></b></div>
<?php
$page=1;
if(isset($_GET['page']))
{
	$page=$_GET['page'];
}
$start=($page-1)*10;

if(@$fileArray!=NULL)
{
	
//Counts element in array
$indexCount=count($fileArray);

//Files per page
$per_page=10;

//Number of pages
$page_count=ceil($indexCount/$per_page);

//Defines offset
$offset=$start+0;

//Sorts files
//sort($dirArray);

//Gets subset of array
$selectedFiles=array_slice($fileArray,$offset,10);
$selectedPaths=array_slice($pathArray,$offset,10);
$selectedFilesCount=count($selectedFiles);

//echo "<pre>";
//print_r($selectedFiles);
//echo "</pre>";
//Loops through the array of files
for($index=0;$index<$selectedFilesCount;$index++)
{	

	//Gets file names
	$name=$selectedFiles[$index];
	$namehref=$selectedFiles[$index];
	
	$fileurl=$selectedPaths[$index];
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
echo "<a href='?query=$temp&page=$prev' class='paging'>Prev</a>";
else
echo "<font class='paging'>Prev</font>";
echo "<font class='paging'> Page ".$page." of ".@$page_count." </font>";
$next=$page+1;
if($page<@$page_count)
echo "<a href='?query=$temp&page=$next' class='paging'>Next</a>";
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
}else
echo "<br /><br /><font color='#FF0000' style='font-weight:bold'>No files found for searched string!!</font><br/><br/><br/><br/>";

include_once("footer.php.inc");
?>
</body>
</html>