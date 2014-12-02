<?php
	header("Content-type: text/html; charset=UTF-8");
	header("Cache-Control: no-cache");


	$config = array();
	include "config/config.php";
	if($config['servertrackstatus'])
	{
		date_default_timezone_set($config['timezone']);
		include "include/cache.php";
		include "include/API.php";
		$trackstatus = '<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-size: 12px">';
		if(isset($_COOKIE["trackedteams"]) && $_COOKIE["trackedteams"] != "")
		{
			$teams = explode("|",$_COOKIE["trackedteams"]);
			foreach($teams as $team)
			{
				$teamTrackStatus = "";
				$tmp = explode("=",$team);
				$bibNumber = $tmp[0];
				$cachedTrackStatus = GetCachedTrackStatus($bibNumber);
				if($cachedTrackStatus != "")
				{
					$teamTrackStatus .= $cachedTrackStatus;
				}
				else
				{
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $config['server'] . "/teamtracker/team?bibNumber=" . $bibNumber);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$data = curl_exec($ch);
					curl_close($ch);
					$xmlTeamList = simplexml_load_string($data);
					$xmlTeams = $xmlTeamList->children();
					$xmlTeam = $xmlTeams[0];
					$xmlCompetitors = $xmlTeam->children();
					$lastCompetitor = $xmlCompetitors[0];
					$xmlSplitTimes = $lastCompetitor->children();
					$lastSplitTime = $xmlSplitTimes[0];
					$lastSplitSequence = 0;
					$lastClocktime = strtotime($lastSplitTime->attributes()->clock);
					foreach($xmlTeam->children() as $xmlCompetitor) {
						foreach($xmlCompetitor->children() as $xmlSplitTime) {
							if($xmlSplitTime->getName() != "StartTime") {
								if($xmlSplitTime->attributes()->clock != "") {
									$clocktime = strtotime($xmlSplitTime->attributes()->clock);
									if($clocktime > $lastClocktime)
									{
										$lastClocktime = $clocktime;
									}
									if($xmlSplitTime->attributes()->position != "")
									{
										$currentSequence = intval($xmlSplitTime->getName() == "FinishTime" ? 1000 : $xmlSplitTime->attributes()->sequence);
																						
										if((intval($xmlCompetitor->attributes()->sequence) > intval($lastCompetitor->attributes()->sequence))
											|| (($xmlCompetitor->attributes()->sequence == $lastCompetitor->attributes()->sequence)
												&& ($currentSequence > $lastSplitSequence))) {
											$lastSplitTime = $xmlSplitTime;
											$lastCompetitor = $xmlCompetitor;
											$lastSplitSequence = $currentSequence;
										}
									}
								}
							}
						}
					}
					$teamTrackStatus .= '<tr class="bgcol1">';
					//$teamTrackStatus .= '<td><a href="index.php?bibNumber=' . $xmlTeam->attributes()->bibNumber . '">' . $xmlTeam->attributes()->bibNumber . ' - ' . $xmlTeam->attributes()->name . '</a></td>';
					$teamTrackStatus .= '<td><button type="button" onclick="reRender(' . "'?bibNumber=" . $xmlTeam->attributes()->bibNumber . "'" . ')">'. $xmlTeam->attributes()->bibNumber . ' - ' . $xmlTeam->attributes()->name . '</button></td>';
					$teamTrackStatus .= '<td align="right"><a href="javascript:UntrackTeam(' . $xmlTeam->attributes()->bibNumber . ')"><img src="images/untrack.gif" /></a></td>';
					$teamTrackStatus .= '</tr>';
					$teamTrackStatus .= '<tr class="bgcol0">';
					$teamTrackStatus .= '<td colspan="2">';
					$clock = date('H:i:s',$lastClocktime);
					$leg = $lastCompetitor->attributes()->sequence . ':' . $lastCompetitor->attributes()->order;
					$split = '';
					if($lastSplitTime->getName() == "StartTime") {
						$split = 'Start';
					} elseif($lastSplitTime->getName() == "FinishTime") {
						$split = 'Finish';
					} else {
						$split = $lastSplitTime->attributes()->name;
					}
					$position = '(' . ($lastCompetitor->attributes()->teamstatus == "NOK" ? '-' : $lastSplitTime->attributes()->position) . ')';
					$teamTrackStatus .=  $clock . ' [' . $leg . ' - ' . $split . '] ' . $position;
					
					$teamTrackStatus .= '</td>';
					
					$teamTrackStatus .= '</tr>';
					
					SaveTrackStatusCacheFile($teamTrackStatus);
				}
				$trackstatus .= $teamTrackStatus;
			}
		}
		$trackstatus .= '</table>';
		
		echo $trackstatus;
	}
?>