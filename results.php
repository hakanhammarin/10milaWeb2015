<?php 
ob_start();

$config = array();
include "config/config.php";

// header("Refresh: " . $config['refreshtime']);
date_default_timezone_set($config['timezone']);

include "include/cache.php";
LoadCacheIfValid();

if($config['timing']) {
	include "include/timing.php";
}

global $locale;
include "include/API.php";
 ?>
<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<body>
 -->		<?php 
		if(isset($_GET['bibNumber']))
		{
			PrintTeamResult($_GET['bibNumber']);
		} 
		elseif(isset($_GET['classId']))
		{
			PrintResultList($_GET['classId'],$_GET['legNo'],(isset($_GET['splitNo'])?$_GET['splitNo']:""));
		}
		elseif(isset($_GET['startlist']))
		{
			PrintStartList((isset($_GET['searchstring'])?$_GET['searchstring']:""));
		}
		else {
			PrintInfo();
		}
		?>
	<!-- </body>
	
</html> -->
<?php
	SaveCacheFile();
?>