<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Filelist</title>
<script src="./.sorttable.js"></script>
<link rel="stylesheet" href="./.style.css" />
</head>
<body>
<h1>Directory Contents</h1>
<div id="container">
<table class="sortable">
	<thead>
    <tr>
    	<th>Filename</th>
        <th>Type</th>
        <th>Size</th>
        <th>Date modified</th>
    </tr>
    </thead>
    <tbody>
<?php
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
$dir=".";

/*//Gets each entry
while($entryName=readdir($dir))
{
	$dirArray[]=$entryName;
}

//Closes directory
closedir($dir);*/

$dirArray=scandir($dir);

//Counts element in array
$indexCount=count($dirArray);

//Files per page
$per_page=10;

//Number of pages
$page_count=ceil($indexCount/$per_page);

//Sorts files
sort($dirArray);

//Loops through the array of files
for($index=2;$index<$indexCount;$index++)
{
	//Gets file names
	$name=$dirArray[$index];
	$namehref=$dirArray[$index];
	
	//Gets Date Modified
	$modtime=date("M j Y g:i A", filemtime($dirArray[$index]));

	$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
	$size=pretty_filesize($dirArray[$index]);
	$type=filetype($dirArray[$index]);

	
		
	//Extension definition
	switch($extn){
		case "mp3": $extn="Mp3 File"; break;
		case "html": $extn="HTML File"; break;
		case "php": $extn="PHP File"; break;}

echo "<tr class='file'>
		<td><a href='./$namehref'>$name</a></td>
		<td><a href='./$namehref'>$extn</a></td>
		<td><a href='./$namehref'>$size</a></td>
		<td><a href='./$namehref'>$modtime</a></td>
	</tr>";
}
echo $page_count;
?>
</tbody>
</table>
</div>
</body>
</html>