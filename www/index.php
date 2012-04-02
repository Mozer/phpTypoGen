<?php

// phpTypoGen - Domain typo generator
// v1.0 by Mozer / 2012 
// GPL2

// config
// work just with these domain zones
$avail_zones = array('ru', 'com', 'net', 'org', 'biz', 'name', 'info', 'su', 'es', 'de', 'co.uk', 'pl', 'ch', 'com.ua', 'in', 'md', 'ac', 'tc', 'be');
// use these zones with mislead zones method (0)
$mislead_zones = array('ru', 'net', 'org', 'es', 'de', 'co.uk', 'pl', 'ch', 'com.ua', 'in', 'ac', 'be');
//config

// main
global $typos, $typos_in_zones;

$time_start = microtime(1);
$typos = array();
$typos_in_zones = array();

$all_methods = array(
	0=>'mislead zones (.com -> .us)',
	1=>'general replacements (100-105)',
	2=>'missed letter (google -> goole)',
	3=>'letter swap (google -> goolge)',
	4=>'swap over 1 letter (abc -> cba)',
	5=>'double to triple (google -> gooogle)',
	6=>'double to single (google -> gogle)',
	7=>'double before (google -> ggogle)',
	8=>'double after (google -> goggle)',
	9=>'dot missed after www (www.google.com -> wwwgoogle.com)',
	100=>'general mistakes (100)',
	101=>'forward qwerty slips (101)',
	102=>'backward qwerty slips (102)',
	103=>'1 letter qwerty slips (103)',
	104=>'additional letter (104)',
	105=>'vertical qwerty slip (105)'
);


$domains_in_plain = '';
$domains_in_plain = @$_POST['input_domains'];
$split_lines = @intval($_POST['split']);
$selected_methods_plain = @$_POST['methods'];

include_once('typogen.php');

// select somthing
if ($selected_methods_plain)
{
	foreach ($selected_methods_plain as $sel) $selected_methods[] = intval($sel);
}
else
{
	$selected_methods = array(
		0, // zones
		1,2,3,4,5,6,7,8,9, // cool stuff
		100,101,102,103,104,105 // general stuff
	);
}


echo "<h1>phpTypoGen - Domain typo generator</h1>";
echo ($split_lines ? 'with split of '.$split_lines.' lines' : '')."<br/>";
echo "Paste domain list here or into domains.txt. One per line.";

echo "<form method='POST'>";
	echo "<textarea name='input_domains' style='width: 200px; height: 70px;'>";
		echo $domains_in_plain;
	echo "</textarea><br/>";
	echo "split: <input type='text' name='split' value='500'/><br /><br />";
	echo "Methods:<br/>";
	foreach($all_methods as $method_id=>$method_name)
	{
		echo '<input type="checkbox" name="methods[]" value="'.$method_id.'" '.(in_array($method_id, $selected_methods) ? ' checked="checked"' : '').'>'.$method_name.'<br>';		
	}
	echo "<br/>";
	echo "<input type='submit' />";
echo "</form>";

echo"<hr/>Output:<br/>";





$domains_in = array();
// no POST input
if (!$domains_in_plain)
{
	$handle = fopen("domains.txt", "r");
	while (!feof($handle)) {
	    $domains_in[] = trim(fgets($handle, 4096));
	}
	fclose($handle);
}
else
{
	foreach(explode("\r\n", $domains_in_plain) as $one_domain)
	{
		 $domains_in[] = trim($one_domain);
	}
}

$out = '';
$countr = 0;
foreach($domains_in as $domain)
{
	$parts = explode('.',$domain);
	$word = array_shift($parts);
	$exts = implode('.',$parts);
	
	if (in_array($exts, $avail_zones) === TRUE) typo_gen($word, $selected_methods);
	else continue;
	
	if (in_array(0, $selected_methods))
	{
		if (!in_array($word, $typos_in_zones) === TRUE) typo_zone_gen($word);	
	}
		
	if (isset($typos[$word]))
	{			
		$typos[$word] = array_unique($typos[$word]);
		foreach($typos[$word] as $typo)
		{
			if (strlen($typo) > 3)
			{
				$out .= $typo.".".$exts."\r\n";
				if ($split_lines && $countr && ($countr % $split_lines == 0)) $out .= "</textarea><br/><textarea style='width: 200px; height: 70px;'>";
				$countr++;
			}
		}
	}
	if (isset($typos_in_zones[$word]))
	{			
		foreach($typos_in_zones[$word] as $typo)
		{
			$out .= $typo."\r\n";
			if ($split_lines && $countr && ($countr % $split_lines == 0)) $out .= "</textarea><br/><textarea style='width: 200px; height: 70px;'>";
			$countr++;		
		}
	}
}
$time_end = microtime(1);

echo "<textarea style='width: 200px; height: 70px;'>";
echo $out;
echo "</textarea>";
echo "<hr/>";
echo "input: ".count($domains_in)."<br/>";
echo "good: ".count($typos) . "<br/>";
echo "typos: ".$countr."<br/>";
echo "time: ".(round($time_end - $time_start, 3))." s<br/>";
echo "<br/>v1.0 by Mozer / 2012 / GPL2 ";

?>