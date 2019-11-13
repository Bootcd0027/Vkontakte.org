<?php include("../Common/login.php"); ?>
<?php if(!isset($_SESSION['user'])) header('Location: /Major_Project/Home/index.php?f=5'); ?>
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
	<script type="text/javascript" src="inc/jquery.hoverIntent.min.js"></script>
  	<script type="text/javascript" src="inc/jquery.metadata.js"></script>
  	<script type="text/javascript" src="inc/jquery.mb.flipText.js"></script>
  	<script type="text/javascript" src="inc/mbExtruder.js"></script>
	<script type="text/javascript">	
	$(document).ready(function() {

		//Initializing the invisible boxes to null
		$("#startPoint").val('');
		$("#endPoint").val('');
		$("#wayPoint1").val('');
		$("#wayPoint2").val('');
		$("#wayPoint3").val('');
		$("#startPointN").val('');
		$("#endPointN").val('');
		$("#wayPoint1N").val('');
		$("#wayPoint2N").val('');
		$("#wayPoint3N").val('');

		//Selecting todays date in the form
		var d = new Date();
		var dt = d.getDate();
		if(dt<10)
			dt = "0" + dt;
		var m = d.getMonth() + 1;
		if(m<10)
			m = "0" + m;
		var y = d.getFullYear();
		$('#returnDate').val(dt);
		$('#returnMonth').val(m);
		$('#returnYear').val(y);
		$('#beginDate').val(dt);
		$('#beginMonth').val(m);
		$('#beginYear').val(y);

		$('#waitUi').click(function() { 
			$.blockUI({ 
		    	theme:     true, 
			draggable: true,
			onBlock: function(){ placeBothMarkers() },
		    	title:     '<center style="font-size:20px">Processing you Request...</center>', 
		    	message:  '<center style="font-size:20px"><img width="300px"src="Icons/wait.gif" /><br />Sending Your Request to Map Database</center>',
		    	timeout:   3000
			});
			  
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
	$(function(){
		$("#auto").click( function() {
			$("#man0").hide();
			$("#man1").hide();
			$("#man2").hide();
			$("#man3").hide();
		});
		$("#man").click( function() {
			$("#man0").show();
			$("#man1").show();
			$("#man2").show();
			$("#man3").show();
		});
		$("#ret").click( function() {
			$("#ret0").toggle();
			$("#ret1").toggle();
                        $("#rety0").toggle();
			$("#rety1").toggle();
                
		});
		$("#addButton").bind('click',function(){
			if(done!=1)
			{				
				return false;
			}
			$("#startPoint").val(markersArray[0].getPosition());
			$("#endPoint").val(markersArray[1].getPosition());
			$("#wayPoint1").val(wayMarkers[0].getPosition());
			$("#wayPoint2").val(wayMarkers[1].getPosition());
			$("#wayPoint3").val(wayMarkers[2].getPosition());
			
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
		    <img src="Icons/way64.png" alt="to Location"/> indicates a waypoint between Source And Destination.<br /><br /> 
		    You can drag any of the pointers after placing them on the map for fine tuning adjustments<br />
		</div> 
		 
		<div class="query"> 
		    How do I place the markers on the map?
		</div> 
		<div class="solution"> 
		    The markers are applied by clicking the map.<br> 
		    The first click places the start location marker.<br> 
		    The second click places the destination marker.<br> 
		    The next 3 clicks place the en route markers (0 to 3 places en route can be selected ).<br> 
		    The place names and Routes are updated automatically.
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
		<center><div id="map_canvas" style="width:590px; height:400px; border:3px solid #666"></div></center><br/>
		<fieldset><center>
		<form action="added.php" method="post" >
		<table style="font-size:15px">
			<tr>
				<th colspan=2 style="text-align:center;color:green;font-size:25px">Tour Details</th>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>Start Date</td>
				<td>
					<select name='beginDate' size='1' id='beginDate'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09'>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
                                                <option value='13'>13
						<option value='14'>14
						<option value='15'>15
						<option value='16'>16
						<option value='17'>17
						<option value='18'>18
						<option value='19'>19
						<option value='20'>20
						<option value='21'>21
						<option value='22'>22
						<option value='23'>23
						<option value='24'>24
                                                <option value='25'>25
						<option value='26'>26
						<option value='27'>27
						<option value='28'>28
						<option value='29'>29
						<option value='30'>30
						<option value='31'>31
						
					</select> 
					<select name='beginMonth' size='1' id='beginMonth'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09'>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
					</select> 
					<select name='beginYear' size='1' id='beginYear'> 
						<option value='2010'>2010
                                                <option value='2011'>2011
                                                <option value='2012'>2012
                                                <option value='2013'>2013
                                                <option value='2014'>2014
                                                <option value='2015'>2015
                                                <option value='2016'>2016
                                                <option value='2017'>2017
					</select>					
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>Start time</td>
				<td>
					<select name='beginTimeHours' size='1' id='beginTimeHours_ID'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09' selected>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
					</select> 
					<select name='beginTimeMins' size='1' id='beginTimeMins_ID'> 
						<option value='00'>00
						<option value='15'>15
						<option value='30'>30
						<option value='45'>45
					</select> 
					<select name='beginTimeAmPm' size='1' id='beginTimeAmPm_ID'> 
						<option value='AM' selected>AM
						<option value='PM'>PM
					</select>
					+/-
					<select name='offsetBegin' size='1' id='offsetBegin_ID'> 
						<option value='15'>15
						<option value='30'>30
						<option value='45'>45
					</select>
					mins
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>Return Journey</td>
				<td>
					<input id="ret" type="checkbox" name="ret" value="True" checked="checked" />Mark Same Route for return
				</td>
			</tr>
			<tr id ="rety0"><td>&nbsp;</td></tr>
                        <tr id ="rety1">
				<td>Return Date</td>
				<td>
					<select name='returnDate' size='1' id='returnDate'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09'>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
                                                <option value='13'>13
						<option value='14'>14
						<option value='15'>15
						<option value='16'>16
						<option value='17'>17
						<option value='18'>18
						<option value='19'>19
						<option value='20'>20
						<option value='21'>21
						<option value='22'>22
						<option value='23'>23
						<option value='24'>24
                                                <option value='25'>25
						<option value='26'>26
						<option value='27'>27
						<option value='28'>28
						<option value='29'>29
						<option value='30'>30
						<option value='31'>31
						
					</select> 
					<select name='returnMonth' size='1' id='returnMonth'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09'>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
					</select> 
					<select name='returnYear' size='1' id='returnYear'> 
						<option value='2010'>2010
                                                <option value='2011'>2011
                                                <option value='2012'>2012
                                                <option value='2013'>2013
                                                <option value='2014'>2014
                                                <option value='2015'>2015
                                                <option value='2016'>2016
                                                <option value='2017'>2017
					</select>					
				</td>
			</tr>		
			<tr id="ret0"><td>&nbsp;</td></tr>
			<tr id="ret1">
				<td>Return time</td>
				<td>
					<select name='returnTimeHours' size='1' id='returnTimeHours_ID'> 
						<option value='01'>01
						<option value='02'>02
						<option value='03'>03
						<option value='04'>04
						<option value='05'>05
						<option value='06'>06
						<option value='07'>07
						<option value='08'>08
						<option value='09' selected>09
						<option value='10'>10
						<option value='11'>11
						<option value='12'>12
					</select> 
					<select name='returnTimeMins' size='1' id='returnTimeMins_ID'> 
						<option value='00'>00
						<option value='15'>15
						<option value='30'>30
						<option value='45'>45
					</select> 
					<select name='returnTimeAmPm' size='1' id='returnTimeAmPm_ID'> 
						<option value='AM' selected>AM
						<option value='PM'>PM
					</select>
					+/-
					<select name='offsetReturn' size='1' id='offsetReturn_ID'> 
						<option value='15'>15
						<option value='30'>30
						<option value='45'>45
					</select>
					mins
				</td>
			</tr>			
                        <tr><td>&nbsp;</td></tr>
			<tr>
				<td>Who are You</td>
				<td>
					<input checked="checked" type="radio" name="mode" value="g" />Ride Giver
					<input type="radio" name="mode" value="s" />Ride Seeker
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td valign="top">Sharing Preferences </td>
				<td>
					<input id="auto" type="radio" value="a" name="pref" /> Allow us to do that for you based on your profile.<br />
					<input id="man" type="radio" value="m" name="pref" checked="checked" /> I will specify the criteria myself. Thank you!
				</td>
			</tr>
			<tr id="man0"><td>&nbsp;</td></tr>
			<tr id="man1">
				<td style="text-align:right">Gender</td>
				<td>
					<input type="radio" value="m" name="genpref" />Male
					<input type="radio" value="f" name="genpref" />Female
					<input type="radio" value="np" name="genpref" checked="checked"/>Not Particular<br/>
				</td>
			</tr>
			<tr id="man2"><td>&nbsp;</td></tr>
			<tr id="man3">
				<td style="text-align:right">Age</td>
				<td>&nbsp;&nbsp;&nbsp;
					<select name="minage" size="1" id="minage">
						<option value="18" selected>18
						<option value="19">19
						<option value="20">20
						<option value="21">21
						<option value="22">22
						<option value="23">23
						<option value="24">24
						<option value="25">25
						<option value="26">26
						<option value="27">27
						<option value="28">28
						<option value="29">29
						<option value="30">30
						<option value="31">31
						<option value="32">32
						<option value="33">33
						<option value="34">34
						<option value="35">35
						<option value="36">36
						<option value="37">37
						<option value="38">38
						<option value="39">39
						<option value="40">40
						<option value="41">41
						<option value="42">42
						<option value="43">43
						<option value="44">44
						<option value="45">45
						<option value="46">46
						<option value="47">47
						<option value="48">48
						<option value="49">49
						<option value="50">50
						<option value="51">51
						<option value="52">52
						<option value="53">53
						<option value="54">54
						<option value="55">55
						<option value="56">56
						<option value="57">57
						<option value="58">58
						<option value="59">59
						<option value="60">60
					</select>
					&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;
					<select name="maxage" size="1" id="maxage">
						<option value="18">18
						<option value="19">19
						<option value="20">20
						<option value="21">21
						<option value="22">22
						<option value="23">23
						<option value="24">24
						<option value="25">25
						<option value="26">26
						<option value="27">27
						<option value="28">28
						<option value="29">29
						<option value="30">30
						<option value="31">31
						<option value="32">32
						<option value="33">33
						<option value="34">34
						<option value="35">35
						<option value="36">36
						<option value="37">37
						<option value="38">38
						<option value="39">39
						<option value="40">40
						<option value="41">41
						<option value="42">42
						<option value="43">43
						<option value="44">44
						<option value="45">45
						<option value="46">46
						<option value="47">47
						<option value="48">48
						<option value="49">49
						<option value="50">50
						<option value="51">51
						<option value="52">52
						<option value="53">53
						<option value="54">54
						<option value="55">55
						<option value="56">56
						<option value="57">57
						<option value="58">58
						<option value="59">59
						<option value="60" selected>60
					</select> 
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td></td><td><button  style="margin-left:30px" id="addButton" type="submit">Add Tour</button></td></tr>
		</table>
		<input type="text" id="startPoint" name="startPoint" style="display:none"/>
		<input type="text" id="wayPoint1" name="wayPoint1" style="display:none"/>
		<input type="text" id="wayPoint2" name="wayPoint2" style="display:none"/>
		<input type="text" id="wayPoint3" name="wayPoint3" style="display:none"/>
		<input type="text" id="endPoint" name="endPoint" style="display:none"/>
		<input type="text" id="startPointN" name="startPointN" style="display:none"/>
		<input type="text" id="wayPoint1N" name="wayPoint1N" style="display:none"/>
		<input type="text" id="wayPoint2N" name="wayPoint2N" style="display:none"/>
		<input type="text" id="wayPoint3N" name="wayPoint3N" style="display:none"/>
		<input type="text" id="endPointN" name="endPointN" style="display:none"/>
		</form>
		</center>
		</fieldset>
        </div>
        <div id="templatemo_sidebar">
        	<div class="sidebar_box">
            
		      	<h2>Map ToolBox</h2>
		        
			<div class="df_box">
				<button id="buttan" ><span id="addW" >Add Waypoints</span><span id="remW" style="display:none">Remove Waypoints</span></button>
				<table>
					<tr>
						<td>Source</td>
						<td><input type="text" id="src" /></td>
					</tr>
					<script>
						$("#buttan").click(function () {
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
				<p id="waitUi" class="cta-button"><a></a></p>
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
    
		Copyright © 2010 <a href="/Major_Project/Home/index.php">SmartRide</a> | 
		Designed by <a href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" target="_parent">Tushar</a> 
    
    </div> <!-- end of templatemo_footer -->
    
    </div>
</div>

</body>
</html>
