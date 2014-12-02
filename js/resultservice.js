function OnClickRemoveValue(input) {
	input.value = "";
}

function SetCookie(c_name,value,days) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + days);
	var c_value=escape(value) + ((days==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function SetLocale(locale) {
	SetCookie("locale",locale,31);
}

function OnClickSetLocale(locale) {
	SetLocale(locale);
	window.location.reload(true);
}

function TrackTeam(bibNumber,teamName) {
	if(!IsTeamTracked(bibNumber)) {
		var newCookie = AddTrackedTeam(bibNumber,teamName);
		SetCookie('trackedteams', newCookie, 31);
		PrintTrackedTeams();
	}
}

function AddTrackedTeam(bibNumber, teamName) {
	var trackedTeams = GetTrackedTeams();
	var i, bN, tmp;
	var newCookie = "";
	var inserted = false;
	for(i=0; i < trackedTeams.length;i++)
	{
		bN=trackedTeams[i].substr(0,trackedTeams[i].indexOf("="));
		if(inserted)
		{
			newCookie = newCookie + "|" + trackedTeams[i];
		}
		else
		{
			if(bN == bibNumber)
			{
				newCookie = newCookie + (i==0?"":"|") + bibNumber + "=" + teamName;
				inserted = true;
			}
			else if(bN < bibNumber)
			{
				newCookie = newCookie + (i==0?"":"|") + trackedTeams[i];
			}
			else
			{
				newCookie = newCookie + (i==0?"":"|") + bibNumber + "=" + teamName + "|" + trackedTeams[i];
				inserted = true;
			}
		}
	}
	if(!inserted)
	{
		newCookie = newCookie + (newCookie==""?"":"|") + bibNumber + "=" + teamName;
	}
	return newCookie;
}

function UntrackTeam(bibNumber) {
	var trackedTeams = GetTrackedTeams();
	var newCookie = "";
	for(i=0; i < trackedTeams.length;i++)
	{
		bN=trackedTeams[i].substr(0,trackedTeams[i].indexOf("="));
		if(bN != bibNumber)
		{
			if(newCookie == "")
			{
				newCookie = trackedTeams[i];
			}
			else
			{
				newCookie = newCookie + "|" + trackedTeams[i];
			}
		}
	}
	SetCookie('trackedteams', newCookie, 31);
	PrintTrackedTeams();
}

function UntrackAllTeams() {
	SetCookie('trackedteams','',null);
	PrintTrackedTeams();
}

function IsTeamTracked(bibNumber) {
	var trackedTeams = GetTrackedTeams();
	var i, bN;
	for(i=0; i < trackedTeams.length;i++)
	{
		bN=trackedTeams[i].substr(0,trackedTeams[i].indexOf("="));
		if(bN == bibNumber)
		{
			return true;
		}
	}
	return false;
}

function PrintTrackedTeamsFromServer(domObj) {
	if(GetTrackedTeamsCookie == "") {
		return;
	}
	var innerHTML = '<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-size: 12px">';
	var trackedTeams = GetTrackedTeams();
	for(i=0; i < trackedTeams.length;i++)
	{
		bN=trackedTeams[i].substr(0,trackedTeams[i].indexOf("="));
		tN=trackedTeams[i].substr(trackedTeams[i].indexOf("=")+1);
		//innerHTML = innerHTML + '<tr class="bgcol1"><td><a href="index.php?bibNumber=' + bN + '">' + bN + ' - ' + tN + '</a></td><td align="right"><a href="javascript:UntrackTeam(' + bN + ')"><img src="images/untrack.gif" /></a></td></tr>';
		//echo '<td><button type="button" onclick="reRender(' . "'?bibNumber='  . $classId . '&legNo=' . $legNo .  "'" . ')">' . $locale['leg'] . ' ' . $legNo . ':' . $xmlCompetitor->attributes()->order . ' - ' . ($xmlCompetitor->attributes()->courselength/1000) . '</button></td>';
		innerHTML = innerHTML + '<tr class="bgcol1"><td><button type="button" onclick="reRender("?bibNumber=' + bN + '">' + bN + ' - ' + tN + '</button></td><td align="right"><a href="javascript:UntrackTeam(' + bN + ')"><img src="images/untrack.gif" /></a></td></tr>';
		innerHTML = innerHTML + '<tr class="bgcol0"><td colspan="2">&nbsp;</td></tr>';
	}
	innerHTML = innerHTML + '</table>';
	domObj.innerHTML = innerHTML;
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4 && xmlhttp.status==200) {
			innerHTML = xmlhttp.responseText;
			innerHTML = innerHTML.substr(innerHTML.indexOf('<'));
			domObj.innerHTML = innerHTML;
			if(innerHTML == "")
			{
				PrintTrackedTeamsFromCookie(domObj);
			}
		}
	}
	
	xmlhttp.open("GET","trackstatus.php",true);
	xmlhttp.setRequestHeader("If-Modified-Since", new Date().toUTCString());
	xmlhttp.send();
}

function PrintTrackedTeamsFromCookie(domObj) {
	var innerHTML = "";
	var innerHTML = '<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-size: 12px;">';
	var i, bN, tN;
	var trackedTeams = GetTrackedTeams();
	for(i=0; i < trackedTeams.length;i++)
	{
		bN=trackedTeams[i].substr(0,trackedTeams[i].indexOf("="));
		tN=trackedTeams[i].substr(trackedTeams[i].indexOf("=")+1);
		innerHTML = innerHTML + '<tr class="bgcol' + ((i + 1)%2) + '"><td><button type="button" onclick="reRender("?bibNumber=' + bN + '">' + bN + ' - ' + tN + '</button></td><td align="right"><a href="javascript:UntrackTeam(' + bN + ')"><img src="images/untrack.gif" /></a></td></tr>';
		//innerHTML = innerHTML + '<tr class="bgcol' + ((i + 1)%2) + '"><td><a href="index.php?bibNumber=' + bN + '">' + bN + ' - ' + tN + '</a></td><td align="right"><a href="javascript:UntrackTeam(' + bN + ')"><img src="images/untrack.gif" /></a></td></tr>';
	}
	innerHTML = innerHTML + "</table>";
	domObj.innerHTML = innerHTML;
}

function PrintTrackedTeams() {
	var ttTable = document.getElementById("trackedteams");
	
	if((typeof(useServerForTrackStatus) != "undefined") && useServerForTrackStatus)
	{
		PrintTrackedTeamsFromServer(ttTable);
	}
	else
	{
		PrintTrackedTeamsFromCookie(ttTable);
	}
}

function GetTrackedTeams() {
	var cookie = GetTrackedTeamsCookie();
	return cookie == "" ? {} : GetTrackedTeamsCookie().split("|");
}

function GetTrackedTeamsCookie() {
	return GetCookie('trackedteams');
}

function GetCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	  }
	  return "";
}
