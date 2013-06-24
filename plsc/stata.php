<?php 
define('NL_NIX', "\n"); // \n only 
define('NL_WIN', "\r\n"); // \r\n 
define('NL_MAC', "\r"); // \r only
$stataXml = new SimpleXMLElement(file_get_contents('xml/stataFormat.xml'));
//print_r($stataXml);
$keywords = array();
//(string)$stataXml->KeywordsList->Keywords[0];
$n = 0;
//foreach($stataXml->KeywordsList->Keywords as $key => $word){
	//$keywords[strtolower($stataXml->KeywordsList->Keywords[$n]->attributes()->name)] = (string)$word;	
	//$n++;
//}
//print_r($keywords);
$commentOpen = false;
$stringOpen = false;
$color = '#'.(string)$stataXml->Styles->WordsStyle[10]->attributes()->color;
$bgColor = (string)$stataXml->Styles->WordsStyle[10]->attributes()->bgColor;

function newline_type($string){
$lines = array();
if(strpos($string, NL_WIN) != false){
	$lines = explode (NL_WIN, $string);
 return $lines; }
elseif(strpos($string, NL_MAC) != false){ 
 return NL_MAC; }
elseif(strpos($string,NL_NIX) != false) {
 $lines = explode (NL_NIX, $string);
 return $lines; }

} 

function colorFormatter($string){
		global $commentOpen, $stringOpen, $keywords, $stataXml, $color, $bgColor;

		$string = preg_split('/\s/',$string);
		$colored = '';
		foreach($string as $key => $word){
				
			$n=0;
			$count = count($stataXml->KeywordsList->Keywords);
			$found = false;
				if($commentOpen == false){
					while($n < $count && $found == false){
					if(stripos((string)$stataXml->KeywordsList->Keywords[$n],$word))
					{
						$color = setColor(true,$n);
						$bgcolor = setColor(false,$n);
						$found = true;
					}$n++;
					}
					
						if($n == 1){
							
						}
						elseif($n == 5){
							if($word != '*/'){
								$commentOpen = $word;
								$string[$key] = "<span style='color: $color; background-color: $bgColor'>$word";
							}
							else{
								$string[$key] .="</span>";
								$commentOpen = false;
								$color = '#000';
								$bgColor = '#fff';
								//break;
							}
						}
						else{
							$string[$key] = "<span style='color: $color; background-color: $bgColor'>$word</span>";
							$color = setColor(true,10);
						}
					}
					elseif($word == '*/'){
						print 'hello';
						$string[$key] .="</span>";
						$commentOpen = false;
						$color = '#000';
						$bgColor = 'transparent';
					}
					if(is_numeric($word)){
						$color = setColor(true, 9);
						$string[$key] = "<span style='color: $color; background-color: $bgColor'>$word</span>";
						$color = setColor(true, 10);
					}
			
				
					
				
			//print $n;
			//}
		//else
		}
		
		//foreach($keywords as $key => $word){
			
		//}
		$string = implode(' ',$string);
		if($commentOpen != '/*'){
			$commentOpen = false;
			$string .="</span>";
			$color = '#000';
			$bgColor = 'transparent';
		}
		//$stringOpen = false;
		return $string;
}

function setColor($foreground, $n){
	global $stataXml;
	if($foreground){
		return '#'.$stataXml->Styles->WordsStyle[$n]->attributes()->color;
	}
	else return $stataXml->Styles->WordsStyle[$n]->attributes()->bgColor;
}

require_once 'inc/header.php'; ?>
<div id='LayoutDiv2'>
	<code>
	<?php 
				$data = file_get_contents('./mat/stataCommands.do',true);
				$data = newline_type($data);
				print '<pre>';
				foreach($data as $dat){
					print colorFormatter($dat);
					print '<br />';
				}
				print '</pre>';
					
	
	?>
	</code>
</div>

<?php require_once 'inc/footer.php'; 


?>