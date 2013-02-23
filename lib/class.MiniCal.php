<?php
/**
 * Generate an HTML calendar for a specified month, load links from text data file.
 * REQUIRES the Unix 'cal' program to be in your Web server's path.
 *
 * @author Walter Lee Davis
 */
class MiniCal{
	var $strDate;
	var $strDataPath;
	/**
	 * Parse a calendar line, replacing any dates that have events with links to those events.
	 *
	 * @param string $strLine String output from Unix cal program, space-delimited calendar.
	 * @return array of dates or linked dates
	 * @author Walter Lee Davis
	 */
	function parseCalendarLine($strLine){
		$out = array();
		$nums = str_split($strLine);
		while(count($nums) > 0){
			$out[] = trim(array_shift($nums) . array_shift($nums));
			@array_shift($nums);
		}
		foreach($out as $k => $v){
			if(array_key_exists($v,$this->arrLinks)){
				if(is_array($this->arrLinks[$v][0])){
					$out[$k] = '<div><a href="multiple-links" title="Multiple links, click to choose..." rel="' . rawurlencode(json_encode($this->arrLinks[$v])) . '">' . $v . '</a></div>';
				}else{
					$out[$k] = '<div><a href="' . $this->arrLinks[$v][0] . '" title="' . $this->arrLinks[$v][1] . '">' . $v . '</a></div>';
				}
			}
		}
		$out = array_pad($out,7,'<!-- -->');
		return $out;
	}
	/**
	 * Create HTML table with calendar, using Unix cal.
	 *
	 * @return string HTML table with calendar
	 * @author Walter Lee Davis
	 */
	function generate_calendar(){
		$this->miniCalLinks();
		$calendar = shell_exec('/usr/bin/env cal -h ' . $this->strDate);
		$lines = explode("\n",$calendar);
		$calendar = '<table class="cal" cellspacing="0">
			<tr><th class="previous">&lt;</th><th colspan="5">' . trim(array_shift($lines)) . '</th><th class="next">&gt;</th></tr>
';
		array_shift($lines);
		$calendar .= '	<tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>
';
		foreach($lines as $line){
			if(! preg_match('/^\s*$/',$line)){
				$nums = $this->parseCalendarLine($line);
				$calendar .= vsprintf("\t<tr>\n\t\t<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>\n\t</tr>\n", $nums);
			}
		}
		$calendar .= '</table>
';
		return $calendar;
	}
	/**
	 * Parse data file at defined path for event dates and links.
	 *
	 * @return array Sets class variable with an array of links.
	 * @author Walter Lee Davis
	 */
	function miniCalLinks(){
		$this->arrLinks = array();
		if(strlen($this->strDataPath) > 0){
			$strDate = trim($this->strDate);
			$month = (int) date('m',time());
			$year = date('Y',time());
			if($strDate && count(explode(' ',$strDate)) == 2){
				$start = explode(' ',$strDate);
				$year = $start[1];
				$month = (int) $start[0];
			}
			$data = preg_split('/\n/',trim(@file_get_contents($this->strDataPath)));
			foreach($data as $d){
				$line = preg_split('/ /',$d);
				$date_parts = array_map('intval',preg_split('/-/',array_shift($line)));
				if($year == $date_parts[0] && ($month == $date_parts[1])){
					if(array_key_exists($date_parts[2],$this->arrLinks)){
						if(is_string($this->arrLinks[$date_parts[2]][0])){
							$this->arrLinks[$date_parts[2]] = array($this->arrLinks[$date_parts[2]]);
						}
						$next = array(array_shift($line),htmlspecialchars(implode(' ',$line)));
						array_push($this->arrLinks[$date_parts[2]],$next);
					}else{
						$this->arrLinks[$date_parts[2]] = array(array_shift($line),htmlspecialchars(implode(' ',$line)));
					}
				}
			}
		}
	}
}
?>
