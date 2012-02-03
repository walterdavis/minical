<?php
date_default_timezone_set('America/New_York');
require_once('class.MiniCal.php');
$date = '';
$parts = array();
if(isset($_POST['month']) && $_POST['month'] > 0){
	$parts[] = (int) $_POST['month'];
}
if(isset($_POST['year']) && $_POST['year'] > 0 && strlen($_POST['year']) == 4){
	$parts[] = $_POST['year'];
}
if(isset($_POST['year']) || isset($_POST['month'])){
	$date = ' ' . implode(' ', $parts);
}
$cal = new MiniCal();
$cal->strDataPath = '../data/data.txt';
$cal->strDate = $date;
header('Content-type: text/html; charset=utf-8');
print $cal->generate_calendar();
?>
