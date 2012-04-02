<?php
// phpTypoGen v1.0
// by Mozer
// 2012-03-27
// GPL2


// generates domain in different zones
// returns 1
// fills global $typos_in_zones
function typo_zone_gen($word)
{
	global $typos_in_zones, $mislead_zones;
	
	foreach ($mislead_zones as $zone)
	{
		$typos_in_zones[$word][] = $word.".".$zone;
	}
	
	return 1;
}

// generates typos in $word with $selected_methods
// returns 1
// fills global $typos
function typo_gen($word, $selected_methods = null)
{
	global $typos;
	
	if ($selected_methods == null) 
	{
		for($i=0;$i<1000;$i++) $selected_methods[]=$i;
	}
			
	if (isset($typos[$word])) return 0;
		
	$general_replacements[100] = array(
		// mistakes
		'oo'=>'u',
		'ee'=>'i',
		'ou'=>'u',
		'ou'=>'oo',
		'ea'=>'i',
		'ck'=>'k',
		'ck'=>'c',		
		'ai'=>'a',
		'a'=>'ei',
		'a'=>'o',
		'a'=>'e',
		'e'=>'a',
		'e'=>'o',
		'o'=>'e',
		'o'=>'a',		
		'v'=>'f',		
		'f'=>'v',		
		'w'=>'v',		
		'v'=>'w',
		'g'=>'j',
		'j'=>'g',
		'c'=>'ck',
		'c'=>'k',
		'c'=>'s',
		's'=>'c',
		'ua'=>'a',				
		'ei'=>'i',
		'eu'=>'e',
		'au'=>'ou'
		);
		
	$general_replacements[101] = array(
		// forward qwerty slips
		'qw'=>'we',
		'we'=>'er',
		'we'=>'qw',
		'er'=>'rt',
		'er'=>'we',
		'rt'=>'ty',
		'rt'=>'er',
		'ty'=>'yu',
		'ty'=>'rt',
		'yu'=>'ui',
		'yu'=>'ty',
		'ui'=>'io',
		'ui'=>'yu',
		'io'=>'op',
		'io'=>'ui',
		'op'=>'io',
		'as'=>'sd',
		'sd'=>'as',
		'sd'=>'df',
		'df'=>'sd',
		'df'=>'fg',
		'fg'=>'df',
		'fg'=>'gh',
		'gh'=>'fg',
		'gh'=>'hj',
		'hj'=>'gh',
		'hj'=>'jk',
		'jk'=>'hj',
		'jk'=>'kl',
		'kl'=>'jk',
		'zx'=>'xc',
		'xc'=>'zx',
		'xc'=>'cv',
		'cv'=>'xc',
		'cv'=>'vb',
		'vb'=>'cv',
		'vb'=>'bn',
		'bn'=>'vb',
		'bn'=>'nm',
		'nm'=>'bn');
		
	$general_replacements[102] = array(
		//backward qwerty slips
		'po'=>'oi',
		'oi'=>'po',
		'oi'=>'iu',
		'iu'=>'oi',
		'iu'=>'uy',
		'uy'=>'iu',
		'uy'=>'yt',
		'yt'=>'uy',
		'yt'=>'tr',
		'tr'=>'yt',
		'tr'=>'re',
		're'=>'tr',
		're'=>'ew',
		'ew'=>'re',
		'ew'=>'wq',
		'wq'=>'ew',
		'lk'=>'kj',
		'kj'=>'jh',
		'kj'=>'lk',
		'jh'=>'kj',
		'jh'=>'hg',
		'hg'=>'jh',
		'hg'=>'gf',
		'gf'=>'hg',
		'gf'=>'fd',
		'fd'=>'gf',
		'fd'=>'ds',
		'ds'=>'fd',
		'ds'=>'sa',
		'sa'=>'ds',
		'mn'=>'nb',
		'nb'=>'mn',
		'nb'=>'bv',
		'bv'=>'nb',
		'bv'=>'vc',
		'vc'=>'bv',
		'vb'=>'cx',
		'cx'=>'vc',
		'cx'=>'xz',
		'xz'=>'cx');	
		
	$general_replacements[103] = array(
		//1 letter qwerty slips		
		'q'=>'w',
		'w'=>'q',
		'w'=>'e',
		'e'=>'w',
		'e'=>'r',
		'r'=>'e',
		'r'=>'t',
		't'=>'r',
		't'=>'y',
		'y'=>'t',
		'y'=>'u',
		'u'=>'y',
		'u'=>'i',
		'i'=>'u',
		'i'=>'o',
		'o'=>'i',
		'o'=>'p',
		'p'=>'o',
		'a'=>'s',		
		's'=>'a',
		's'=>'d',
		'd'=>'s',
		'd'=>'f',
		'f'=>'d',
		'f'=>'g',
		'g'=>'f',
		'g'=>'h',
		'h'=>'g',
		'h'=>'j',
		'j'=>'h',
		'j'=>'k',
		'k'=>'j',
		'k'=>'l',
		'l'=>'k',
		'z'=>'x',
		'x'=>'z',
		'x'=>'c',
		'c'=>'x',
		'c'=>'v',
		'v'=>'c',
		'v'=>'b',
		'b'=>'v',
		'b'=>'n',
		'n'=>'b',
		'n'=>'m',
		'm'=>'n');
		
	$general_replacements[104] = array(
		// additional letter
		'q'=>'qw',
		'q'=>'wq',
		'w'=>'wq',
		'w'=>'we',
		'w'=>'ew',
		'w'=>'qw',
		'e'=>'we',
		'e'=>'ew',
		'e'=>'er',
		'e'=>'re',
		'r'=>'er',
		'r'=>'re',
		'r'=>'rt',
		'r'=>'tr',
		't'=>'rt',
		't'=>'tr',
		't'=>'ty',
		't'=>'yt',
		'y'=>'ty',
		'y'=>'yt',
		'y'=>'yu',
		'y'=>'uy',
		'u'=>'yu',
		'u'=>'uy',
		'u'=>'ui',
		'u'=>'iu',
		'i'=>'ui',
		'i'=>'iu',
		'i'=>'io',
		'i'=>'oi',
		'o'=>'io',
		'o'=>'oi',
		'o'=>'op',
		'o'=>'po',
		'p'=>'po',
		'p'=>'op',		
		'a'=>'as',
		'a'=>'sa',
		's'=>'sa',
		's'=>'as',
		's'=>'ds',
		's'=>'sd',
		'd'=>'ds',
		'd'=>'sd',
		'd'=>'df',
		'd'=>'fd',
		'f'=>'df',
		'f'=>'fd',
		'f'=>'fg',
		'f'=>'gf',		
		'g'=>'fg',
		'g'=>'gf',
		'g'=>'gh',
		'g'=>'hg',
		'h'=>'gh',
		'h'=>'hg',
		'h'=>'hj',
		'h'=>'jh',
		'j'=>'jh',
		'j'=>'hj',
		'j'=>'jk',
		'j'=>'kj',
		'k'=>'jk',
		'k'=>'kj',
		'k'=>'kl',
		'k'=>'lk',
		'l'=>'kl',
		'l'=>'lk',		
		'z'=>'zx',		
		'z'=>'xz',
		'x'=>'zx',
		'x'=>'xz',
		'x'=>'xc',
		'x'=>'cx',
		'c'=>'xc',
		'c'=>'cx',
		'c'=>'cv',
		'c'=>'vc',
		'v'=>'vc',
		'v'=>'cv',
		'v'=>'vb',
		'v'=>'bv',
		'b'=>'bv',
		'b'=>'vb',
		'b'=>'nb',
		'b'=>'bn',
		'n'=>'nb',
		'n'=>'bn',
		'n'=>'nm',
		'n'=>'mn',
		'm'=>'nm',
		'm'=>'mn');
		
	$general_replacements[105] = array(
		// vertical qwerty slip
		'b'=>'h');
	
	
	// 1. general replacements
	foreach($general_replacements as $method=>$general_replacement)
	{
		if (in_array($method, $selected_methods))
		{
			foreach($general_replacement as $needle=>$rep)
			{
				$typo = str_replace($needle, $rep, $word, $count);	
				if ($count == 1)	$typos[$word][] = $typo;
				else if ($count > 1)
				{
					$letters = str_split($word);	
					$letter_c = 0;
					foreach($letters as $letter)
					{
						if ($letter == $needle)
						{
							$letters[$letter_c] = $rep;
							$typos[$word][] = implode('',$letters);
							$letters[$letter_c] = $needle;
						}
						$letter_c++;
					}
					$typo = str_replace($needle, $rep, $word, $count);	
				}
			}
		}
	}	
	// 2. google -> goole
	if (in_array(2, $selected_methods))
	{
		$letters = str_split($word);
		$letter_c = 0;
		foreach($letters as $letter)
		{
			$letters[$letter_c] = '';
			$typo = implode('',$letters);
			if (strlen($typo) > 3) $typos[$word][] = $typo;
			$letters[$letter_c] = $letter;		
			$letter_c++;
		}
	}
	// 3. google -> goolge
	if (in_array(3, $selected_methods))
	{
		$letters = str_split($word);
		$letter_c = 0;
		foreach($letters as $letter)
		{
			if ($letter_c > 0)
			{
				$prev_letter = $letters[$letter_c-1];
				$letters[$letter_c-1] = $letter;
				$letters[$letter_c] = $prev_letter;
				$typos[$word][] = implode('',$letters);			
				$letters[$letter_c-1] = $prev_letter;		
				$letters[$letter_c] = $letter;				
			}
			$letter_c++;
		}
	}
	// 4. abc -> cba (swap over 1 letter)
	if (in_array(4, $selected_methods))
	{
		$letters = str_split($word);
		$letter_c = 0;
		foreach($letters as $letter)
		{
			if ($letter_c > 1)
			{
				$prev_letter = $letters[$letter_c-2];
				$letters[$letter_c-2] = $letter;
				$letters[$letter_c] = $prev_letter;
				$typos[$word][] = implode('',$letters);			
				$letters[$letter_c-2] = $prev_letter;		
				$letters[$letter_c] = $letter;				
			}
			$letter_c++;
		}
	}
	// 5. google -> gooolge 
	// 6. google -> gogle
	// 7. google -> ggogle
	// 8. google -> goggle
	$letters = str_split($word);
	$letter_c = 0;
	foreach($letters as $letter)
	{
		if ($letter_c > 0)
		{
			$prev_letter = $letters[$letter_c-1];
			if ($prev_letter == $letter)
			{
				if (in_array(5, $selected_methods)) $typos[$word][] = str_replace($letter.$letter, $letter.$letter.$letter, $word); // 5
				if (in_array(6, $selected_methods)) $typos[$word][] = str_replace($letter.$letter, $letter, $word); // 6
				if (in_array(7, $selected_methods)) if ($letter_c>1) $typos[$word][] = str_replace($letters[$letter_c-2].$letter.$letter, $letters[$letter_c-2].$letters[$letter_c-2].$letter, $word); // 7
				if (in_array(8, $selected_methods)) if (isset($letters[$letter_c+1])) $typos[$word][] = str_replace($letter.$letter.$letters[$letter_c+1], $letter.$letters[$letter_c+1].$letters[$letter_c+1], $word); // 8
			}					
		}
		$letter_c++;
	}
	// 9. wwwgoogle.com
	if (in_array(9, $selected_methods)) $typos[$word][] = "www".$word;
			
	// x. oo -> ooo
	//$typo = preg_replace('/([a-z0-9])\1+/','$1$1$1',$word);
	//if ($typo != $word) $typos[$word][] = $typo;	
	
	
	
	return 1;
}

?>