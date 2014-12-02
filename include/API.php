<?php
	//MOD BY HH
	$locale = array();
	include "locales/" . GetLocale() . ".php";

	function PrintEvent() {
		echo '<a href="index.php">';
		if($handle = opendir('images/event/')) {
			while(false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..' && $file != 'index.php' && $file != '.DS_Store') {
					echo '<img src="images/event/' . $file . '" alt="Event" />';
				}
			}
		}		
		echo '</a>';
	}
	
	function PrintSearchBox($w) {
		global $locale;
		global $config;
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $w . 'px;">';
		echo '<table>';
		echo '<tr>';
		echo '<td>';
		//echo '<td class="boxheader">';
		echo $locale['search_02'];
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td align="center">';
						
		//echo '<a href="index.php?startlist"><b>' . $locale['startlist'] . '</b></a>';
		echo '<button id="startlist">'. $locale['startlist'] .'</button>';

		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td>';
		$searchtext = (isset($_GET['searchstring'])?$_GET['searchstring']:$locale['search_02']);
		//echo '<form id="team_search" action="index.php" method="get">';
		echo '<input type="text" id="searchstring" name="searchstring"' . (isset($_GET['searchstring'])?'':' onclick="OnClickRemoveValue(this)"') . 'value="' . $searchtext . '" class="textbox" />';
		// echo '<input type="submit" value="' . $locale['search_01'] . '" />';
		echo '<button id="go">' . $locale['search_01'] . '</button>';
		echo '<input type="hidden" name="startlist" />';
		echo '</form>';
		echo '</td>';
		echo '</tr>';
		
		echo '</table>';
	}

	function PrintToplistMenu($data, $w) {
		global $locale;
		global $config;
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $w . '">';
		echo '<table>';
		echo '<tr>';
		echo '<td class="boxheader">';
		echo $locale['toplistmenu_header'];
		echo '</td>';
		echo '</tr>';
		
		$xmlEvent = simplexml_load_string($data);
		$xmlClasses = $xmlEvent->xpath("EventClass");
		foreach ($xmlClasses as $xmlClass)
		{
			$classId = $xmlClass->attributes()->classId;
			echo '<tr><td align="center">';
			$url = '?toplist&classId=' . $classId;
			//$url = 'index.php?toplist&classId=' . $classId;
			echo '<button type="button" onclick="reRender(' . "'" . $url . "'" . ')">'. $xmlClass->attributes()->name .'</button>';

//			echo '<a href="' . $url . '"><b>' . $xmlClass->attributes()->name . '</b></a>';
			echo '</td></tr>';
		}

		echo '</table>';
	}

	
	function PrintMenu($data, $w) {
		global $locale;
		global $config;
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $w . 'px;">';
		echo '<table>';
		echo '<tr>';
		echo '<td class="boxheader">';
		echo $locale['menu_header'];
		echo '</td>';
		echo '</tr>';
		
		$xmlEvent = simplexml_load_string($data);
		$xmlClasses = $xmlEvent->xpath("EventClass");
		foreach ($xmlClasses as $xmlClass)
		{
			$classId = $xmlClass->attributes()->classId;
			echo '<tr><td align="center"><b><u>';
			echo $xmlClass->attributes()->name;
			echo '</u></b></td></tr>';
			
			foreach ($xmlClass->xpath("EventLeg") as $xmlEventLeg)
			{
				$legNo = $xmlEventLeg->attributes()->legNo;
				echo '<tr><td align="center">';
				//$url = 'index.php?classId=' . $classId . '&amp;legNo=' . $legNo;
				$url = '?classId=' . $classId . '&amp;legNo=' . $legNo;
				echo '<button type="button" onclick="reRender(' . "'" . $url . "'" .')">'. $locale['leg'] . ' ' . $legNo .'</button>';
				// echo '<a href="' . $url . '"><b>' . $locale['leg'] . ' ' . $legNo . '</b></a>';
				echo '</td></tr>';

				echo '<tr><td align="center">';
				$first = true;
				foreach ($xmlEventLeg->xpath("EventSplit") as $xmlEventSplit)
				{
					if(!$first)
					{
						echo ' - ';
					}
					$splitNo = $xmlEventSplit->attributes()->splitNo;
					//$url = 'index.php?classId=' . $classId . '&amp;legNo=' . $legNo . '&amp;splitNo=' . $splitNo;
					$url = '?classId=' . $classId . '&amp;legNo=' . $legNo . '&amp;splitNo=' . $splitNo;
					//echo '<a href="' . $url . '">' . $xmlEventSplit->attributes()->name . '</a>';
					echo '<button type="button" onclick="reRender(' . "'" . $url . "'" . ')">'. $xmlEventSplit->attributes()->name .'</button>';

					$first = false;
				}
				echo '</td></tr>';
			}	
			echo '<tr><td>&nbsp;</td></tr>';
		}

		echo '</table>';
	}
	
	function PrintLocales($w) {
		global $locale;
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $w . 'px;text-align:center;">';
		echo '<table>';
		echo '<tr>';
		//echo '<tr class="boxheader">';
		echo '<td>';
		echo $locale['locales'];
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		if($handle = opendir('locales/')) {
			while(false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..') {
					$namea = explode('.', $file);
					if($namea[1] == 'php' && $namea[0] != 'index') {
						echo '<a href="javascript:OnClickSetLocale(\'' . $namea[0] . '\')"><img src="locales/' . $namea[0] . '.gif" border="0" height="16" width="32" hspace="5" /></a>';
					}
				}
			}
		}
		echo '</td>';
		echo '</tr>';
		echo '</table>';
	}
	
	function PrintTrackedTeams($width=200) {
		global $locale;
		global $config;
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $width . 'px;">';
		echo '<table>';
		echo '<tr>';
		echo '<td class="boxheader">';
		echo $locale['track_01'];
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td id="trackedteams">';

		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td>';
		echo '<a href="javascript:UntrackAllTeams()">' . $locale['untrack_all'] . '</a>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';

		echo '<script type="text/javascript">';
		echo 'var useServerForTrackStatus=' . ($config['servertrackstatus']?'true':'false') . ';';
		echo 'if(window.addEventListener){';
		echo '    window.addEventListener(\'load\',PrintTrackedTeams,false);';
		echo '}';
		echo 'else{';
		echo '    window.attachEvent(\'onload\',PrintTrackedTeams);';
		echo '}';
		echo '</script>';
	}
	
	function PrintSponsors($w) {
		global $locale;
		$i = false;
		//$files = array();
		if($handle = opendir('images/sponsors/')) {
			while(false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..' && $file != 'index.php') {
					if(!$i) {
						$files[] = $file;
					}
				}
			}
		}				
		sort($files);		

		//Print table start

                //echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:' . $w . 'px;text-align:center;">';
                echo '<table>';
                echo '<tr class="boxheader">';
                echo '<td>';
                echo $locale['sponsors'];
                echo '</td>';
                echo '</tr>';

		foreach ($files as $file){
                	echo '<tr>';
                	echo '<td align="center">';
                	echo '<img src="images/sponsors/' . $file . '" border="0" style="margin-top:5px;" />';
                	echo '</td>';
                      	echo '</tr>';
		}

		echo '</table>';
	}
	
	
	function PrintInfo() {
		global $locale;
		echo '<table>';
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:500px;">';
		echo '<tr>';
		echo '<td>';
		//echo '<td class="boxheader">';
		echo $locale['info_header'];
		echo '</td>';
		echo '</tr>';
		echo '<tr><td>';
		echo $locale['info_body'];
		echo '</td></tr>';
		echo '</table>';
	}
	
	function PrintStartList($searchstring) {
		global $locale;
		global $config;

		echo '<table>';
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:500px;">';
		echo '<tr>';
		echo '<td>';
		//echo '<td class="boxheader" colspan="3" style="font-size:20px;">';
		echo $locale['startlist'];
		if($searchstring != "") 
		{
			echo ' (' . $searchstring . ')';
		}
		echo '</td>';
		echo '</tr>';

		echo '<tr class="boxheader">';
		echo '<td align="right" width="20%">';
		echo $locale['t_02'];
		echo '</td>';
		echo '<td align="left" width="60%">';
		echo $locale['t_03'];
		echo '</td>';
		echo '<td align="center" width="20%">';
		echo '&nbsp;';
		echo '</td>';
		echo '</tr>';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $config['server'] . "/teamtracker/startlist?searchstring=" . urlencode($searchstring));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		$xmlStartList = simplexml_load_string($data);
		foreach($xmlStartList->children() as $xmlEventClasses)
		{		
			echo '<tr>';
			echo '<td class="boxheader" colspan="3" style="font-size:20px;">';
			echo $xmlEventClasses->attributes()->classname;
			echo '</td>';
			echo '</tr>';
			$row = 1;
			foreach($xmlEventClasses->children() as $xmlTeam)
			{		
					echo '<tr class="bgcol' . ($row%2) . '">';
					echo '<td align="right">';
					echo $xmlTeam->attributes()->bibNumber;
					echo '</td>';
					echo '<td>';
					echo '<button type="button" onclick="reRender(' . "'?bibNumber=" . $xmlTeam->attributes()->bibNumber . "'" . ')">'. $xmlTeam->attributes()->team . '</button>';

					//echo '<a href="index.php?bibNumber=' . $xmlTeam->attributes()->bibNumber . '">' . $xmlTeam->attributes()->team . '</a>';
					echo '</td>';
					echo '<td>';
					echo '<a href="javascript:TrackTeam(' . $xmlTeam->attributes()->bibNumber . ',\'' . $xmlTeam->attributes()->team . '\')">' . $locale['track_02'] . '</a>';
					echo '</td>';
					echo '</tr>';
				
					$row++;
			}
		}
		echo '</table>';

	}
	
	function PrintResultListOLD($classId,$legNo,$splitNo) {
		global $locale;
		global $config;

		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $config['server'] . "/teamtracker/resultlist?classId=" . $classId . "&legNo=" . $legNo . ($splitNo != "" ? "&splitNo=" . $splitNo : ""));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		$xmlResultList = simplexml_load_string($data);

		echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:500px;">';
		echo '<tr>';
		echo '<td class="boxheader" colspan="5" style="font-size:20px;">';
		echo $xmlResultList->attributes()->classname . ' - ' . $locale['leg'] . ' ' . $xmlResultList->attributes()->legNo . ' - ' . $xmlResultList->attributes()->resultname;
		echo '</td>';
		echo '</tr>';

		echo '<tr class="boxheader">';
		echo '<td>';
		echo '</td>';
		echo '<td align="left">';
		echo $locale['c_01'];
		echo '</td>';
		echo '<td align="left">';
		echo $locale['c_02'];
		echo '</td>';
		echo '<td align="center">';
		echo $locale['c_03'];
		echo '</td>';
		echo '<td align="center">';
		echo $locale['c_04'];
		echo '</td>';
		echo '</tr>';
		
		$row = 1;
		foreach ($xmlResultList->children() as $xmlResult)
		{
				$statusOK = $xmlResult->attributes()->status != "NOK" && $xmlResult->attributes()->teamstatus != "NOK";
		
				echo '<tr class="bgcol' . ($row%2) . '">';
				echo '<td><b>';
				echo $statusOK ? $xmlResult->attributes()->position : "-";
				echo '</b></td>';
				echo '<td>';
				echo $xmlResult->attributes()->name;
				echo '</td>';
				echo '<td>';
				//echo '<a href="index.php?bibNumber=' . $xmlResult->attributes()->bibNumber . '">' . $xmlResult->attributes()->team . '</td>';
				echo '<button type="button" onclick="reRender(' . "'?bibNumber="  . $xmlResult->attributes()->bibNumber  . "'" . ')">'. $xmlResult->attributes()->team .'</button>';

				echo '</td>';
				echo '<td align="center">';
				echo $xmlResult->attributes()->time;
				echo '</td>';
				echo '<td align="center">';
				echo FormatDeltaSeconds($xmlResult->attributes()->deltatime);
				echo '</td>';
				echo '</tr>';
			
				$row++;

		}
		
		echo '</table>';
		
	}
	
function PrintResultList($classId,$legNo,$splitNo) {
		global $locale;
		global $config;

		$url = $config['server'] . "/teamtracker/resultlist?classId=" . $classId . "&legNo=" . $legNo . ($splitNo != "" ? "&splitNo=" . $splitNo : "");
		PrintList($url);
	}
		
	function PrintTopList($classId) {
		global $locale;
		global $config;

		$url = $config['server'] . "/teamtracker/toplist?classId=" . $classId;
		PrintList($url);
	}

	function PrintList($url) {
		global $locale;
		global $config;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		$xmlResultList = simplexml_load_string($data);

		echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:500px;">';
		echo '<tr>';
		echo '<td class="boxheader" colspan="5" style="font-size:20px;">';
		echo $xmlResultList->attributes()->classname . ' - ' . $locale['leg'] . ' ' . $xmlResultList->attributes()->legNo . ' - ' . $xmlResultList->attributes()->resultname;
		echo '</td>';
		echo '</tr>';

		echo '<tr class="boxheader">';
		echo '<td>';
		echo '</td>';
		echo '<td align="left">';
		echo $locale['c_01'];
		echo '</td>';
		echo '<td align="left">';
		echo $locale['c_02'];
		echo '</td>';
		echo '<td align="center">';
		echo $locale['c_03'];
		echo '</td>';
		echo '<td align="center">';
		echo $locale['c_04'];
		echo '</td>';
		echo '</tr>';
		
		$row = 1;
		foreach ($xmlResultList->children() as $xmlResult)
		{
				$statusOK = $xmlResult->attributes()->status != "NOK" && $xmlResult->attributes()->teamstatus != "NOK";
		
				echo '<tr class="bgcol' . ($row%2) . '">';
				echo '<td><b>';
				echo $statusOK ? $xmlResult->attributes()->position : "-";
				echo '</b></td>';
				echo '<td>';
				echo $xmlResult->attributes()->name;
				echo '</td>';
				echo '<td>';
//				echo '<a href="index.php?bibNumber=' . $xmlResult->attributes()->bibNumber . '">' . $xmlResult->attributes()->team . '</td>';
				echo '<button type="button" onclick="reRender(' . "'?bibNumber="  . $xmlResult->attributes()->bibNumber  . "'" . ')">'. $xmlResult->attributes()->team .'</button>';

				echo '</td>';
				echo '<td align="center">';
				echo $xmlResult->attributes()->time;
				echo '</td>';
				echo '<td align="center">';
				echo FormatDeltaSeconds($xmlResult->attributes()->deltatime);
				echo '</td>';
				echo '</tr>';
			
				$row++;

		}
		
		echo '</table>';
		
	}


	function PrintTeamResult($bibNumber) {
		global $locale;
		global $config;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $config['server'] . "/teamtracker/team?bibNumber=" . $bibNumber);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		$xmlTeamList = simplexml_load_string($data);
		$xmlTeams = $xmlTeamList->children();
		$xmlTeam = $xmlTeams[0];
		$classId = $xmlTeam->attributes()->classId;
		$className = $xmlTeam->attributes()->classname;

		echo '<table>';
		//echo '<table cellspacing="0" cellpadding="2" border="0" class="boxmain" style="width:500px;">';
		echo '<tr>';
		echo '<td>';
		//echo '<td class="boxheader" style="font-size: 20px;" colspan="6">';
		echo $xmlTeam->attributes()->bibNumber . " - " . $xmlTeam->attributes()->name . " (" . $className . ")";
		echo ' [<a href="javascript:TrackTeam(' . $xmlTeam->attributes()->bibNumber . ',\'' . $xmlTeam->attributes()->name . '\')">' . $locale['track_02'] . '</a>]';
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		//echo '<tr class="boxheader">';
		echo '<td>' . $locale['t_11'] . '</td>';
		echo '<td align="left">' . $locale['t_12']  . '</td>';
		echo '<td align="center">' . $locale['t_13']  . '</td>';
		echo '<td align="right">' . $locale['t_14']  . '</td>';
		echo '<td align="right">' . $locale['t_15']  . '</td>';
		echo '<td align="right">' . $locale['t_16']  . '</td>';
		echo '</tr>';

		$teamseconds = 0;
		$lastLegNo = 0;
		$legSeconds = 0;
		
		foreach($xmlTeam->children() as $xmlCompetitor) {
			$runnerseconds = 0;
			$legStartTime = strtotime($xmlCompetitor->children()->StartTime->attributes()->clock);
			$legNo = $xmlCompetitor->attributes()->sequence;
			if(intval($legNo) != intval($lastLegNo))
			{
				$teamseconds = $teamseconds + $legSeconds;
				$legSeconds = 0;
				$lastLegNo = $legNo;
			}
			echo '<tr class="bgcol0">';
			echo '<td><button type="button" onclick="reRender(' . "'?classId="  . $classId . '&legNo=' . $legNo .  "'" . ')">' . $locale['leg'] . ' ' . $legNo . ':' . $xmlCompetitor->attributes()->order . ' - ' . ($xmlCompetitor->attributes()->courselength/1000) . '</button></td>';
			//echo '<td><a href="index.php?classId=' . $classId . '&legNo=' . $legNo . '"><b>' . $locale['leg'] . ' ' . $legNo . ':' . $xmlCompetitor->attributes()->order . ' - ' . ($xmlCompetitor->attributes()->courselength/1000) . ' km</b></a></td>';
			echo '<td colspan="2">' . $xmlCompetitor->attributes()->givenname . ' ' . $xmlCompetitor->attributes()->familyname . '</td>';
			echo '<td align="right">' . $xmlCompetitor->attributes()->teamstatus . '</td>';
			echo '<td>&nbsp;</td>';
			echo '<td align="right">' . $xmlCompetitor->attributes()->status . '</td>';
			echo '</tr>';
			
			$xmlFinishSplitTime;
			foreach($xmlCompetitor->children() as $xmlSplitTime) {
				$runnerseconds = GetLegSeconds($legStartTime,$xmlSplitTime->attributes()->clock);
				echo '<tr>';
				$splitfield = "";
				if($xmlSplitTime->getName() == "StartTime") {
					$splitfield = 'Start';
				} elseif($xmlSplitTime->getName() == "FinishTime") {
					//$splitfield = '<a href="index.php?classId=' . $classId . '&legNo=' . $legNo . '">Finish</a>';
					$splitfield = '<button type="button" onclick="reRender(' . "'?classId="   . $classId . '&legNo=' . $legNo . "'" . ')">Finish</button>';

				} else {
					$splitNo = $xmlSplitTime->attributes()->sequence;
//					$splitfield = '<a href="index.php?classId=' . $classId . '&legNo=' . $legNo . '&splitNo=' . $splitNo . '">' . $xmlSplitTime->attributes()->name . '</a>';
					$splitfield = '<button type="button" onclick="reRender(' . "'?classId="   . $classId . '&legNo=' . $legNo . '&splitNo=' . $splitNo . "'" . ')">'. $xmlSplitTime->attributes()->name .'</button>';
				}
				echo '<td>' . $splitfield . '</td>';
				echo '<td>' . FormatClock($xmlSplitTime->attributes()->clock) . '</td>';
				echo '<td align="center">' . ($xmlCompetitor->attributes()->teamstatus == "NOK" ? '' : $xmlSplitTime->attributes()->position) . '</td>';
				echo '<td align="right">' . ($xmlSplitTime->attributes()->clock != "" ? FormatDeltaSeconds($teamseconds + $runnerseconds) : "&nbsp;") . '</td>';
				echo '<td align="right">' . FormatDeltaSeconds($xmlSplitTime->attributes()->deltatime) . '</td>';
				echo '<td align="right">' . FormatDeltaSeconds($runnerseconds) . '</td>';
				echo '</tr>';
				$xmlFinishSplitTime = $xmlSplitTime;
			}
			if($xmlFinishSplitTime->attributes()->position != "")
			{
				$legSeconds = $runnerseconds;
			}
		}

		echo '</table>';

	}

	function PrintFooter() {
		global $config;
		global $locale;
		
		echo '<table cellspacing="0" cellpadding="0" border="0" class="brodtext11">';
		echo '<tr>';
		echo '<td align="center">Copyright &copy; 2012 Samuel Henriksson, Skarpnäcks OL</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td align="center">';
		PrintOrganizers();
		echo '</td>';
		echo '</tr>';
		if($config['timing']) {
			echo '<tr>';
			echo '<td align="center">';
			echo $locale['loaded_in1'] . GetLoadTime() . $locale['loaded_in2'];
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	
	function PrintOrganizers() {
		if($handle = opendir('images/organizers/')) {
			while(false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..' && $file != 'index.php') {
					echo '<img src="images/organizers/' . $file . '" border="0" />';
				}
			}
		}		
	}
	
	function GetEvent() {
		global $config;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $config['server'] . "/teamtracker/event");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function GetLegSeconds($legStartTime, $splitTimeClock) {
		return $splitTimeClock == "" ? "" : strtotime($splitTimeClock) - $legStartTime;
	}
	
	function GetLocale() {
		if(isset($_COOKIE['locale'])) {
			return $_COOKIE['locale'];
		} else {
			return "swedish";
		}
	}
	
	function GetTrackedTeams($typeofreturn) {
		if(!IsEmpty($_COOKIE["tracked"])) {
			if($typeofreturn == "array") {
				$teams = explode(".",$_COOKIE["tracked"]);
				return $teams;
			} else {
				return $_COOKIE["tracked"];
			}
		} else {
			if($typeofreturn == "array") {
				return array();
			} else {
				return "noteams";
			}
		}
	}
	
	function FormatSeconds($seconds) {
		$neg = false;
		if($seconds < 0) {
			$neg = true;
			$seconds = abs($seconds);
		}
		$seconds = $seconds/100;
		$hours = (int)($seconds / 3600);
		$seconds = (int)($seconds % 3600);
		$minutes = (int)($seconds / 60);
		$seconds = (int)($seconds % 60);
		$string = ($neg ? "-" : " ") . str_pad($hours, 2, "0",STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0",STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0",STR_PAD_LEFT);
		
		return $string;
	}
	
	function FormatDeltaSeconds($seconds) {
		if($seconds=="") return "";
		$neg = false;
		if($seconds < 0) {
			$neg = true;
			$seconds = abs($seconds);
		}
		$minutes = (int)($seconds / 60);
		$seconds = (int)($seconds % 60);
		$string = ($neg ? "-" : " ") . str_pad($minutes, 1, "0",STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0",STR_PAD_LEFT);
		
		return $string;
	}

	function FormatClock($datetime) {
		//return date("H:i:s",strtotime($datetime));
		return substr($datetime,-8);
	}
	
	function FormatToSeconds($string) {
		$string = explode(":",$string);
		$hours = (int)$string[0];
		$minutes = (int)$string[1];
		$seconds = (int)$string[2];
		$sec = $hours*3600 + $minutes*60 + $seconds;
		return $sec * 100;
	}
	
	function FormatMeter($m) {
		return round($m/1000, 1);
	}
	
?>
