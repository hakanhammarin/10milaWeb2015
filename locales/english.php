<?php
	$locale['title'] = "10MILA Result Service";

	$locale['leg'] = "Leg";

	$locale['search_01'] = "Search";
	$locale['search_02'] = "Search Team";
	$locale['startlist'] = "Start List";

	$locale['e_01'] = "Error";
	$locale['e_02'] = "No team found!";
	
	$locale['t_01'] = "Teams";
	$locale['t_02'] = "Startnumber";
	$locale['t_03'] = "Teamname";
	$locale['t_11'] = "";
	$locale['t_12'] = "Clock";
	$locale['t_13'] = "Total Position";
	$locale['t_14'] = "Total Time";
	$locale['t_15'] = "Time After";
	$locale['t_16'] = "Race Time";

	$locale['track_01'] = "Tracked Teams";
	$locale['track_02'] = "Track";
	$locale['untrack_all'] = "Remove All Tracked Teams";
	
	$locale['control_header'] = "Control info: ";
	$locale['control_first'] = "First";
	$locale['control_previous'] = "Previous";
	$locale['control_next'] = "Next";
	$locale['control_last'] = "Last";
	$locale['control_all'] = "All";
	
	$locale['toplistmenu_header'] = "Top list";
	$locale['menu_header'] = "Split Controls";
	
	$locale['loaded_in1'] = "Page loaded in ";
	$locale['loaded_in2'] = " seconds.";
	
	$locale['class_header'] = "Class Info";
	
	$locale['locales'] = "Languages";
	
	$locale['sponsors'] = "Sponsors";
	
	$locale['c_01'] = "Name";
	$locale['c_02'] = "Team";
	$locale['c_03'] = "Total Time";
	$locale['c_04'] = "Time After";
	$locale['c_05'] = "Search Runner";
	
	$locale['s_01'] = "Name";
	$locale['s_02'] = "Team";
	$locale['s_03'] = "Total Time";
	$locale['s_04'] = "Time After";
	$locale['s_05'] = "Search Runner";
	
	$locale['info_header'] = "Web Info";
	$locale['info_body'] = "<center><u>Welcome to the 10MILA result service!</u></center> <br/>
							<br/>
							On your left side of the screen, you will find a search field to search for teams, you can search for both bibnumber and the team's name. Teams matching the search criteria are listed in a start list.
							There is also a link to a complete start list. From the start list thera are clickable links for each team.
							<br/>
							<br/>
							Below the search field you may see the entire list of classes and split controls.
							To view the positions of the runners at a certain point, just click the name of the control or class.
							<br/>
							<br/>
							The service will reload itself every " . $config['refreshtime'] . " seconds.
							<br/>
							<br/>
							<center><b>Team Overview</b></center><br/>
							Here you can see information about the the team's split times.
							Beside the team's name, you will see a link called " . $locale['track_02'] . ". Clicking this will make a box appear to the right, called " . $locale['track_01'] . ".
							Inside this box you will notice the team's name as a link. Clicking it will lead directly to the team. 
							<br/>
							<br/>
							<center><b>Control and Class Overview</b></center><br/>
							Here you can se the current standings at each split control.
							<br/>
							<br/>
							<center><b>Tracked Teams</b></center><br/>
							From the startlist or team overview you can click on 'Track' to add a team to the right part of the browser. You get direct links to these teams and information about their last known online result. 
							<br/>
							<br/>
							<center><b>Browser Requirements</b></center><br/>
							The result service uses Cookies and JavaScript. The service will work except for tracking and locale language without Cookies and JavaScript enabled.
							<br/>
							<br/>
							<center><b>About</b></center><br/>
							10MILA result service was developed for 10MILA 2011. The goal was to present all split times for a team and result lists for all split controls and legs. The development was done by Tobias Hultqvist, Tullinge SK. For 2012 the service has been updated mainly with concerns on response time when there is high load on the service. Development has been done by Samuel Henriksson, Skarpnäcks OL.
							<br/>
							<br/>
							<center>10MILA</center>
							
							";
?>