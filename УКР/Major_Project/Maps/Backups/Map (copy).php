<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>
	<?php include("../Common/common_head.php"); ?>
	<!--extruder -->
	<link href="inc/mbExtruder.css" media="all" rel="stylesheet" type="text/css">
	<link href="jquery-ui-1.7.2.redmond.css" media="all" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery.blockUI.js"></script>
	<script type="text/javascript" src="jquery-ui.min.js"></script>
	<script type="text/javascript" src="inc/jquery.hoverIntent.min.js"></script>
  	<script type="text/javascript" src="inc/jquery.metadata.js"></script>
  	<script type="text/javascript" src="inc/jquery.mb.flipText.js"></script>
  	<script type="text/javascript" src="inc/mbExtruder.js"></script>
	<script type="text/javascript">
	$(document).ready(function() { 
		$('#waitUi').click(function() { 
			$.blockUI({ 
		    	theme:     true, 
			draggable: true,
		    	title:     '<center style="font-size:20px">Processing you Request...</center>', 
		    	message:  '<center style="font-size:20px"><img width="300px"src="Icons/wait.gif" /><br />Sending Your Request to Map Database</center>',
		    	timeout:   10000
			});
			setTimeout(function() {
            			$.unblockUI({
                			onUnblock: function(){ placeBothMarkers() }
            			});
        		}, 0);   
	    	});    
	});
	</script>
	<script type="text/javascript">
	$(function(){
		$("#extruderLeft").buildMbExtruder({
		position:"left",
		width:600,
		extruderOpacity:.8,
		onExtOpen:function(){},
		onExtContentLoad:function(){$("#extruderLeft").openPanel();},
		onExtClose:function(){}
	      });
	});
	</script>
	<!--extruder -->
	
	<link type="text/css" href="style.css" rel="stylesheet" />

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
	<script type="text/javascript" src="gmap.js"></script> 
	<script type="text/javascript">
		function hide()
		{
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[3].style.display='None';
		}
	</script>
	<style type="text/css"> 
	    .query {
		font-variant: normal;
		color: red;
		font-size:20px;
		margin-bottom: 6px;
		margin-top: 30px;
		margin-left: 15px;
	    }
	 
	    .solution {
		font-family: arial;
		font-size: 14px;
		margin-left: 15px;
	    }
	</style> 

</head>
<body onload="hide()">
<div id="templatemo_body_wrapper">


<!--extruder-->
<div id="extruderLeft" class="{title:' Map Guide '}">
		<h1>Map Guide</h1>

		<div class="query"> 
		    How do I search for a location on the map?
		</div> 
		<div class="solution"> 
		    Enter the name of the place in the top right corner of the page and hit the search button. If the name is found the
		    map will pan to the specified location. Else 'No location will such name exists!' alert is shown/
		</div>

		<div class="query"> 
		    How do I zoom into a location on the map?
		</div> 
		<div class="solution"> 
		    There are 2 ways you can zoom in and zoom out.<br> 
		    <ul> 
			<li> 
			    You can use the zoom control provided by google on the left of the map. (+) will zoom in (-) will zoom out. You can also drag the Zoom bar Up for zooming in and drag it down to zoom out.
			</li> 
			<li> 
			    You can also use the mouse scroll to zoom in and zoom out.
			</li> 
		    </ul> 
		</div>
 		 
		<div class="query"> 
		    How do I move the map?
		</div> 		 
		<div class="solution"> 
		There are 2 ways you can move the map(pan the map).<br> 
		    <ul> 
			<li> 
			    You can use the pan control provided by google on the left of the map. The arrow keys indicate the direction of panning.
			</li> 
			<li> 
			    You can click and drag the mouse to move the map around.
			</li> 
		    </ul> 
		</div> 
		<div id="markersLegend" class="query"> 
		    What do the different marker icons signify?
		</div> 
		<div class="solution"> 
		    <img src="Icons/up64.png" alt="home"/> indicates the start point.<br />
		    <img src="Icons/down64.png" alt="to Location"/> indicates the desination.<br /><br /> 
		    You can drag any of the pointers after placing them on the map for fine tuning adjustments<br />
		</div> 
		 
		<div class="query"> 
		    How do I place the markers on the map?
		</div> 
		<div class="solution"> 
		    The markers are applied by clicking the map.<br> 
		    The first click places the start location marker.<br> 
		    The second click places the destination marker.<br> 
<!--		    The next 4 clicks place the en route markers (0 to 4 places en route can be selected ).<br> -->
		    The place names are updated automatically.
		</div> 
		 
		<div class="query"> 
		    I have placed the marker but I want to move it to a different location.How do I change the position of the markers?
		</div> 
		<div class="solution"> 
		    You can drag and drop the marker to the desired location and the coordinates are updated automatically. The place names are also updated.
		</div> 
		 
		<div class="query"> 
		    Can I delete the markers already placed on the map?
		</div> 
		<div class="solution"> 
			Click on the Reload button on the Map to get the map to the initial position.
		</div> 
		 
		<div class="query"> 
		    There is a question I have that isnt answered above..
		</div> 
		 
		<div class="solution"> 
		    Please mail us at smartride.iiit@gmail.com and we will get back to you immediately. Please add this id to your address
		    book to prevent our mail from getting into spam.
		</div>
</div>
<!--extruder-->
<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>	
    
    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>
		<center><div id="map_canvas" style="width:590px; height:400px; border:3px solid #666"></div></center>			                     
        </div>
        <div id="templatemo_sidebar">
        	<div class="sidebar_box">
            
		      	<h2>Map ToolBox</h2>
		        
			<div class="df_box">
				<button><span id="addW" >Add Waypoints</span><span id="remW" style="display:none">Remove Waypoints</span></button>
				<table>
					<tr>
						<td>Source</td>
						<td><input type="text" id="src" /></td>
					</tr>
					<script>
						$("button").click(function () {
						$("#togg1").toggle();
						$("#togg2").toggle();
						$("#togg3").toggle();		
						$("#addW").toggle();
						$("#remW").toggle();		
						});    
					</script>
					<tr id="togg1" style="display:none">
						<td>Waypoint 1</td>
						<td><input type="text" id="wp1" /></td>
					</tr>
					<tr id="togg2" style="display:none">
						<td>Waypoint 2</td>
						<td><input type="text" id="wp2" /></td>
					</tr>
					<tr id="togg3" style="display:none">
						<td>Waypoint 3</td>
						<td><input type="text" id="wp3" /></td>
					</tr>
					<tr>
						<td>Destination</td>
						<td><input type="text" id="dest" /></td>
					</tr>
				</table>				
				<p id="waitUi" class="cta-button"></p>
				<div><br /></div>
			</div>
			<div class="df_box">
				<h2>Information Panel</h2>
				<table>
					<tr style="text-align:left">
						<td>Start&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><div id="Start"></div></td>
					</tr>
				</table>
				<div id="directions_panel" style="margin:20px"></div> 
				<table>
					<tr style="text-align:left">
						<td>End</td>
						<td><div id="End"></div></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr style="text-align:left">
						<th>Distance</th>
						<th><div id="Dist"></div></th>
					</tr>
				</table>
				<br />		
			</div>
		</div>     
        </div>
        <div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
        Copyright © 2010 <a href="#">Dre@dLorDs</a> | 
        Designed by <a href="http://www.templatemo.com" target="_parent">Drow Ranger and BloodSeeker</a> 
    
    </div> <!-- end of templatemo_footer -->
    
    </div>
</div>

</body>
</html>
