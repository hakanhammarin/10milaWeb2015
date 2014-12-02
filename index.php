<?php 
//MOD BY HH
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
$eventData = GetEvent();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $locale['title']; ?></title>
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
<!--		<link href="layout.css" type="text/css" rel="stylesheet" /> -->
		<script type="text/javascript" src="js/resultservice.js"></script>
		<link rel="shortcut icon" href="images/favicon.ico" />
		 <script src="js/jquery-1.10.2.js"></script>
		 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		 
	</head>
	<body>
	  <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">10MILA 2015</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#results">Resultat</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li class="active"><a href="./">Static top <span class="sr-only">(current)</span></a></li>
            <li><a href="../navbar-fixed-top/">Fixed top</a></li>
          </ul> -->
        </div><!--/.nav-collapse -->
      </div>
    </nav>

  </div>
</header>

<!--	<?php 
			include_once("include/analyticstracking.php") 
		?> 
		-->
		

     <div class="container">

<div class="row">
        <div class="col-sm-3" style="background-color:lavender;">
        <?php 
			PrintSearchBox(200);
			PrintToplistMenu($eventData,200); 
			PrintMenu($eventData,200); 
		?>
        </div>
        <div class="col-sm-6" style="background-color:lavenderblush;">
        <div id='results'></div>
        </div>
        <div class="col-sm-3" style="background-color:lavender;">
         <?php 
			PrintLocales(200);
			PrintTrackedTeams(200); 
			PrintSponsors(200);
		  ?>
        </div>
      </div>

		<table cellspacing="3" cellpadding="0" border="0">
		<tr valign="top">
		<td colspan="3" align="center" class="siteheader">
<!-- 		<?php
			PrintEvent();
		?>
 -->		</td>
		</tr>
		<tr valign="top">
		<td>
		
		</td>
		<td>
		
			
		</td>
		<td>
		
		
		</td>
		</tr>
		
		<tr>
		</div><!-- /.container -->

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
//	var showQuery = '?startlist';
	function reRender(qString){
			 console.log( "reRender "+qString );
			showQuery = qString;
			$( "#results" ).load('/results.php'+qString);
			$( "#trackedteams" ).load('/trackstatusjquery.php');
			//window.location.hash = '#results';
			document.getElementById('results').scrollIntoView();
	};

	$( document ).ready(function() {
	$( "#results" ).load('/results.php'+showQuery);
	 console.log( "ready!" );

	});
	setInterval(function(){
		var dummy = reRender(showQuery);
	},<?php echo $config['refreshtime'] . "000"; ?>);
	//},6000);
	
	

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
				showQuery='?startlist'	

	 var dummy = reRender(showQuery);
	 console.log( "click!" );
	 console.log( showQuery );

    
};
	</script>
	
</html>
<?php
	SaveCacheFile();
?>