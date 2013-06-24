<?php 

class SchoolWeeks{
	
		function __construct($date){
			$this->getWeek($date);
		}
		
		function getWeek($begin, $end){
			$date = explode('-',$date);
			$day = $date[1];
			$week = 1;
			if($date[0] == 1){
				if($day > 6 && $day < 12) $week = 1;
				elseif($day > 13 && $day < 19) $week = 1;
				elseif($day > 20 && $day < 26) $week = 2;
				elseif($day > 27 && $day < 31) $week = 3;
				elseif($day > 6 && $day < 12) $week = 1;
				elseif($day > 6 && $day < 12) $week = 1;
			}
		13-19  = week2
		}
		
}

?>