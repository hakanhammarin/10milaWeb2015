<?php
$load_start = microtime();
$load_starta = explode(" ", $load_start);
$load_start = $load_starta[1] + $load_starta[0];

function GetLoadTime() {
	global $load_start;
	$load_end = microtime();
	$load_enda = explode(" ",$load_end);
	$load_end = $load_enda[1] + $load_enda[0];
	$load_time = $load_end - $load_start;
	$load_time = round($load_time, 5);
	return $load_time; 
}
?>