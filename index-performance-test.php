<?php 
//MOD BY HH
ob_start();

$config = array();
include "config/config.php";

// header("Refresh: " . $config['refreshtime']);
//header("Cache-Control: no-cache");
header("Cache-Control: max-age=600");
date_default_timezone_set($config['timezone']);

//include "include/cache.php";
//LoadCacheIfValid();

if($config['timing']) {
	include "include/timing.php";
}

global $locale;
include "include/API.php";
$eventData = GetEvent();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $locale['title']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="layout.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/resultservice.js"></script>
		<link rel="shortcut icon" href="images/favicon.ico" />
		 <script src="js/jquery-1.10.2.js"></script>
<!-- <link rel="stylesheet" href="http://hostingshoutcast.com/stream/plate/css/plate.css">
		<script src="http://hostingshoutcast.com/stream/plate/js/jquery.js"></script>
		<script src="http://hostingshoutcast.com/stream/plate/js/jquery-ui.js"></script>
		<script src="http://hostingshoutcast.com/stream/plate/js/jquery.ui.touch-punch.min.js"></script>
		<script src="http://hostingshoutcast.com/stream/plate/js/plate.js"></script>
-->
	<script>
	// MixStream Flash Player, http://mixstreamflashplayer.net/ 
	var flashvars = {};
	flashvars.serverHost = "10.0.10.8:8000/;";
	flashvars.getStats = "0";flashvars.autoStart = "0";flashvars.textColour = "";
	flashvars.buttonColour = "";
	var params = {};params.bgcolor= "";
	params.wmode="transparent";
</script> 	
<sript type="text/javascript" src="js/player-10mila-v1.3.js"></script>
<script type="text/javascript" src="swfobject.js"></script>

	</head>
	<body>
		<?php include_once("include/analyticstracking.php") ?>
<!-- <div id="azotosolutions">Streaming solutions 10-mila<a href="http://www.hostingshoutcast.com">10-mila 2014</a></div> -->

 		<table cellspacing="3" cellpadding="0" border="0" >
		<tr valign="top">
		<td>
				<table cellspacing="0" cellpadding="2" border="0" class="boxmain" >
		<tr>
		<td class="boxheader" >
		<div>Speaker</div>
		</td>
		</tr>
		<tr>
		
		<td>
 		<div  id="mixstreamPlayer" style="width: 335px; height: 40px;"></div> 

		</td>
		</tr>
		</table>
		</td>
			<td>
			<table cellspacing="0" cellpadding="2" border="0" class="boxmain" >
		<tr>
		<td class="boxheader" >
		<div>Speaker Finnish</div> 
		</td>

		</tr>

		<tr>
		
		<td>
		<div  id="mixstreamPlayerFi"></div>
		
		</td>

		</tr>
		</table>
		</td>
		
		<td>
			<table cellspacing="0" cellpadding="2" border="0" class="boxmain" >
		<tr>
		<td class="boxheader" align="left" colspan="2">
		<div id="updateInterval">Update Interval: </div>
		</td>
		</tr>
		<td>
			
			<button type="button" onclick="reRender(showQuery)">Refresh Now</button>
	<!--		 <button type="button" onclick="reRenderTimer('1')">Refresh 10 ms</button>
			<button type="button" onclick="reRenderTimer('10')">Refresh 100 ms</button>
			<button type="button" onclick="reRenderTimer('50')">Refresh 500 ms</button>
			<button type="button" onclick="reRenderTimer('100')">Refresh 1 sec</button> 
			<button type="button" onclick="reRenderTimer('60')">Refresh 1 min</button>
			<button type="button" onclick="reRenderTimer('300')">Refresh 5 min</button> -->
		</td>
		</table>
		</td>
		</tr>
		</table>

 		<table cellspacing="3" cellpadding="0" border="0" >
		
		<tr valign="top">
		<td colspan="3" align="left" class="boxheader">
		</td>
		</tr>


		<tr valign="top">
		<td>
		<?php 
			PrintSearchBox(200);
			PrintToplistMenu($eventData,200); 
			PrintMenu($eventData,200); 
		?>
		</td>
		<td>
		<div id='results'></div>
			
		</td>
		<td>
		<?php 
			PrintLocales(200);
			PrintTrackedTeams(200); 
			PrintSponsors(200);
		?>
		</td>
		</tr>
		
		<tr>
		<td colspan="3" align="center" class="siteheader" />
		<?php
			PrintFooter();
		?>
		</td>
		</tr>
		</table>

	</body>
	<script type="text/javascript">
	//var showQuery = '?startlist';
	var showQuery = '/';
	var reRenderTimerValue = <?php echo $config['refreshtime']; ?>;
			 $( "#updateInterval" ).text('Update Interval: '+reRenderTimerValue +'s');

	console.log(reRenderTimerValue);
//	var showQuery = '?startlist';


function reRenderTracker(qString){
			 console.log( "reRender "+qString );
			 console.log( "reRenderTimerValue "+reRenderTimerValue );
			showQuery = qString;
			//$( "#results" ).load('/results.php'+qString);
			$( "#trackedteams" ).load('/trackstatusjquery.php');
	};

		


	function reRender(qString,action){
			 console.log( "reRender "+qString );
			 console.log( "reRenderTimerValue "+reRenderTimerValue );
			showQuery = qString;
			if (action=='click'){
			$( "#results" ).load('/results.php'+qString);
			};
			if (action!='click' & showQuery!='?startlist' & showQuery!='/'){
			$( "#results" ).load('/results.php'+qString);
			};

			var trackedteams=getCookie("trackedteams");
			if (trackedteams!="")
  			{
  			console.log("Tracked Teams: " + trackedteams);
			$( "#trackedteams" ).load('/trackstatusjquery.php');

  			};





	};

	$( document ).ready(function() {
	$( "#results" ).load('/results.php'+showQuery);
	 console.log( "ready!" );

	});



	function reRenderTimer (newTimer) {
		 console.log( "reRenderTimer "+newTimer );
		 reRenderTimerValue = newTimer;
		 $( "#updateInterval" ).text('Update Internval: '+reRenderTimerValue +'s');

	};

var i=1;
//var reRenderTimerValue=60; // << control this variable

var refreshId = setInterval(function() {
  if(!(i%reRenderTimerValue)) {
    console.log('run!');
    reRender(showQuery);
  }
  else {
   //do nothing
  }
  i++;
}, 1000);


/*
	(function repeat() {
   	var dummy = reRender(showQuery);
    timer = setTimeout(repeat, reRenderTimerValue);
	})();
*/

	/*setInterval(function(){
		var dummy = reRender(showQuery);
	},reRenderTimerValue);
	*///},6000);
	
	

	document.getElementById('go').onclick = function () {

		//showQuery='?searchstring=haka&startlist='	
		//showQuery=document.getElementById('searchstring');
		showQuery= '?searchstring=' + $('#searchstring').val() + '&startlist=';
		//'?searchstring=haka&startlist='	
	 var dummy = reRender(showQuery);
	 console.log( "click!" );
	 console.log( showQuery );

    
};
	document.getElementById('startlist').onclick = function () {

				showQuery='?startlist'	;
			//	reRenderTimer('60000');

	 reRender(showQuery,'click');
	 console.log( "click!" );
	 console.log( showQuery );

    
};

function getCookie(cname)
{
var name = cname + "=";
var ca = document.cookie.split(';');
for(var i=0; i<ca.length; i++) 
  {
  var c = ca[i].trim();
  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
return "";
};


</script>
 <script type="text/javascript">
 var s1 = new SWFObject('http://online.10mila.se/player.swf',
 'player',"335","50","13","#FFFFFF");
 s1.addParam("allowfullscreen","false");
 s1.addParam("allowscriptaccess","always");
 s1.addParam("flashvars","skin=http://www.shouthost.com/freeflashplayer/skins/schoon.swf&title=Live Stream&type=sound&file=http://10.0.10.8:10000/;&13202692901&duration=99999&id=scplayer&autostart=false");
 s1.write("mixstreamPlayerFi");
</script>

</html>
#<?php
#	SaveCacheFile();
#?>
