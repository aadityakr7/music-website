<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Download Song</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
</head>

<body>
<?php
include_once("header.php.inc");
?>
<?php
$filename=$_GET['filename'];
$fileurl=$_GET['fileurl'];
$temppageurl=$_GET['pageurl'];
$pageurl="http://mywebsite.com/".$temppageurl;

// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}
	
require_once("getID3/getid3/getid3.php");
include("getID3/getid3/getid3.lib.php");
$getID3=new getID3;
$ThisFileInfo=$getID3->analyze("$fileurl");
//echo "<pre>";
//print_r($ThisFileInfo['tags']['id3v2']['unsynchronised_lyric'][0]);
//echo "</pre>";
@$title=$ThisFileInfo['tags']['id3v2']['title'][0];
if($title==NULL)
$title="Unknown";
@$album=$ThisFileInfo['tags']['id3v2']['album'][0];
if($album==NULL)
$album="Unknown";
@$artist=$ThisFileInfo['tags']['id3v2']['artist'][0];
if($artist==NULL)
$artist="Unknown";
@$year=$ThisFileInfo['tags']['id3v2']['year'][0];
if($year==NULL)
$year="Unknown";
@$genre=$ThisFileInfo['tags']['id3v2']['genre'][0];
if($genre==NULL)
$genre="Unknown";
@$track_number=$ThisFileInfo['tags']['id3v2']['track_number'][0];
if($track_number==NULL)
$track_number="-/-";
@$composer=$ThisFileInfo['tags']['id3v2']['composer'][0];
if($composer==NULL)
$composer="Unknown";
@$lyricist=$ThisFileInfo['tags']['id3v2']['lyricist'][0];
if($lyricist==NULL)
$lyricist="Unknown";
if(@$ThisFileInfo['tags']['id3v2']['unsynchronised_lyric'][0]!=NULL)
$lyrics="Available";
else
$lyrics="Not available";

@$dataformat=$ThisFileInfo['audio']['dataformat'];
@$sample_rate=$ThisFileInfo['audio']['sample_rate'];
@$channelmode=$ThisFileInfo['audio']['channelmode'];
@$bitrate_mode=$ThisFileInfo['audio']['bitrate_mode'];
@$tempbitrate=$ThisFileInfo['bitrate'];
@$bitrate=floor($tempbitrate/1000);

@$playtime=$ThisFileInfo['playtime_string'];

@$modtime=date("M j Y g:i A", filemtime($fileurl));
@$size=pretty_filesize($fileurl);

if(isset($ThisFileInfo['comments']['picture'][0])){
	$cover='data:'.$ThisFileInfo['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($ThisFileInfo['comments']['picture'][0]['data']);
}
else{
	$cover="./image/default_album.png";
}

echo '<div class="menuhead"><b>Download  '.$filename.'</b></div>';
?>
<?php
$db=new MySQLi('localhost','root','','mp3');
if($db->connect_errno>0)
	echo 'Unable to connect to database'.$db->connect_error;
else{
	$sql="SELECT hits FROM downloads WHERE filename='$filename'";
	$result=$db->query($sql);
	if(!$result){
		echo "Error in Query".$db->error;
	}
	else{
	$res=$result->fetch_assoc();
	$hitnumber=$res['hits'];
	}
}
?>
<?php
if(!empty($_POST)){
$sql1="SELECT filename FROM downloads WHERE filename='$filename'";
$result1=$db->query($sql1);
$res1=$result1->fetch_assoc();
if(empty($res1)){
	$sqlinsert="INSERT into downloads(filename,hits) VALUES('$filename',1)";
	$insertqry=$db->query($sqlinsert);
}
else{
	$sqloldhits="SELECT hits FROM downloads WHERE filename='$filename'";
	$oldhitsqry=$db->query($sqloldhits);
	$oldhits=$oldhitsqry->fetch_assoc();
	$oldhitsvalue=$oldhits['hits'];
	$newhitsvalue=$oldhitsvalue+1; 
	$sqlupdate="UPDATE downloads SET hits=$newhitsvalue WHERE filename='$filename'";
	$upadateqry=$db->query($sqlupdate);
}
header('Location: '.$fileurl.'');
}
?>
<br /><br />
<table cellspacing="40px" align="center">
	<tr>
    	<td align="right"><img id="filename" src="<?php echo @$cover;?>" alt="mp3" width="150px" height="150" /></td>
		<td>
        	<table cellspacing="7px" style="color:rgba(51,51,51,.7);">
            	<tr><td><b>Title: </b><?php echo "<font color='#CC0000'>".$title."</font>";?></td></tr>
				<tr><td><b>Album: </b><?php echo "<font color='#CC0000'>".$album."</font>";?></td></tr>
				<tr><td><b>Artist: </b><?php echo "<font color='#CC0000'>".$artist."</font>";?></td></tr>
                <tr><td><b>Duration: </b><?php echo "<font color='#009900'>".$playtime."</font>";?></td></tr>
                <tr><td><b>Downloads: </b><?php echo "<font color='#CC0000'>".$hitnumber." times"."</font>";?></td></tr>
             </table>
         </td>
    </tr> 
</table>
<br /><br />
<div class="additional">Additional Song Info</div>
<div class="dloaddetails"><b>Size: </b><?php echo $size;?></div>
<div class="dloaddetails"><b>Composer: </b><?php echo $composer;?></div>
<div class="dloaddetails"><b>Lyricist: </b><?php echo $lyricist;?></div>
<div class="dloaddetails"><b>Year: </b><?php echo $year;?></div>
<div class="dloaddetails"><b>Bitrate: </b><?php echo $bitrate." kbps";?></div>
<div class="dloaddetails"><b>Audio Summary: </b><?php echo $dataformat.", ".$sample_rate." Hz, ".$channelmode.", ".$bitrate_mode;?></div>
<div class="dloaddetails"><b>Lyrics: </b><?php echo $lyrics;?></div>
<br /><br />
<center>

<form method="post" action="">
<input type="submit" style="background-color:rgb(0,204,204); color:#FFF; border-radius:7px; padding:4px; border-width:1px; cursor:pointer; font-weight:bold;" name="download" value="  Download  " />
</form>
</center>
<br /><br />
<div class="additional">Share Song</div>
<table cellpadding="4px" cellspacing="4px">
<tr><td><a href="http://facebook.com?share.php?u=<?php echo $pageurl;?>"><img src="image/facebook_logo.png" alt="fb" width="30px" height="30px" /></a></td>
<td><a href="https://plus.google.com/app/basic/share?url=<?php echo $pageurl;?>"><img src="image/gplus_logo.png" alt="gplus" width="30px" height="30px" /></a></td>
<td><a href="http://twitter.com/home?status=Hi check out this cool song <?php echo $pageurl;?>"><img src="image/twitter_logo.png" alt="tweet" width="30px" height="30px" /></a></td>
<td><a href="whatsapp://send?text=Hi check out this cool song <?php echo $pageurl;?>"data-action="share/whatsapp/share"><img src="image/whatsapp_logo.png" alt="whatsapp" width="30px" height="30px" /></a></td>
</tr>
</table>
<br /><br />
<?php
echo "<br /><div class='tags'>
		<b style='color:#F00;'>Tags: </b>$artist - $title mp3 Song Download, $artist - $title mp3 Full Song Download, $artist- $title mp3 Song Free Download, $artist $title mp3 Music Download, Show $artist $title lyrics, $artist $title mp3 Track, $artist $title Listen Online, $artist $title mp3 Song in 320kbps & 128kbps, 190kbps & 256kbps format, $artist - $title mp3 Play Online, Download full album $album of $artist $title mp3 Orignal CD rip, iTunes rip, Amazon rip Free Downloads, Download CD rip of $artist $title mp3 Song, $artist - $title mp3 High Quality Song Download</div>";
?>
<?php
include_once("footer.php.inc");
?>
</body>
</html>