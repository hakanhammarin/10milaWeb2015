<?php
$cachefile = "";

function LoadCacheIfValid() {
	global $config;
	global $cachefile;

	if($config['cache']) {
		$bN = (isset($_GET['bibNumber'])?"bN" . $_GET['bibNumber']:"");
		$cI = (isset($_GET['classId'])?"cI" . $_GET['classId']:"");
		$lN = (isset($_GET['legNo'])?"lN" . $_GET['legNo']:"");
		$sN = (isset($_GET['splitNo'])?"sN" . $_GET['splitNo']:"");
		$sl = (isset($_GET['startlist'])?"sl":"");
		$tl = (isset($_GET['toplist'])?"tl":"");
		$ss = isset($_GET['searchstring']);
		$locale	= (isset($_COOKIE['locale'])?$_COOKIE['locale']:"swedish");

		if(!$ss)
		{
			$cachefile = $config['cachefolder'] . "index" . $bN . $cI . $lN . $sN . $sl . $tl . $locale . ".html";

			if(file_exists($cachefile) && (time() - $config['cachetime'] < filemtime($cachefile))) {
				include($cachefile);
				echo "<!-- Generated from cache -->";
				exit;
			}
		}
		else
		{
			$cachefile = "";
		}
	}
}

function GetCachedTrackStatus($bibNumber) {
	global $config;
	global $cachefile;

	if($config['cachetrackstatus']) {
		$cachefile = $config['cachefolder'] . "trackstatus" . $bibNumber . ".html";
		if(file_exists($cachefile) && (time() - $config['cachetrackstatustime'] < filemtime($cachefile))) {
			return file_get_contents($cachefile);
		}
	}
	return "";
}

function SaveCacheFile() {
	global $config;
	global $cachefile;
	if($config['cache'] && $cachefile != "") {
		$fp = fopen($cachefile,'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
	}
}

function SaveTrackStatusCacheFile($trackstatus) {
	global $config;
	global $cachefile;
	if($config['cachetrackstatus'] && $cachefile != "") {
		$fp = fopen($cachefile,'w');
		fwrite($fp, $trackstatus);
		fclose($fp);
	}
}
?>