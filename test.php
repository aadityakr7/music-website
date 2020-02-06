<?php
$mystring="abca hh (hi hello)";
$findme="hi";
$tmp=explode(" ",$mystring);
$count=count($tmp);
for($i=0;$i<$count;$i++){
	if($findme==$tmp[$i]){
		echo $tmp[$i];}
}
$subject="Aaj Phir (Remix) - Arijit Singh, Samira Koppikar";
$pattern="/hih/";
preg_match($pattern,$subject,$matches);

if(array_key_exists(0,$matches))
echo "Match found";
else
echo "No match found";

$path="./bollywood/Aaja Mahi.mp3";
$new=substr($path,1);
echo $new;
/*for($j=0;$j<10;$j++){
	$numbers[]=$j;
}
print_r($numbers);
?>*/