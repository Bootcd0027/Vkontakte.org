<?php include("../Common/login.php"); ?>
<?php if(!isset($_SESSION['user'])) header('Location: /Major_Project/Home/index.php?f=5'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>
	<?php include("../Common/common_head.php"); ?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<link rel="stylesheet" href="Map_Show/general.css" type="text/css" media="screen" />
	<script type="text/javascript" src="Map_Show/popup.js" ></script>
	<script type="text/javascript">
		var india = new google.maps.LatLng(17.466929481348622,78.5242490234375);
		var editable= 1;
    		var map;
		var marker;
		function RefreshControl(refreshControlDiv, map) {

			  // Set CSS styles for the DIV containing the control
			  // Setting padding to 5 px will offset the control
			  // from the edge of the map
			  refreshControlDiv.style.padding = '5px';

			  // Set CSS for the control border
			  var refreshControlUI = document.createElement('DIV');
			  refreshControlUI.style.backgroundColor = '#9CED98';
			  refreshControlUI.style.borderStyle = 'solid';
			  refreshControlUI.style.borderWidth = '2px';
			  refreshControlUI.style.cursor = 'pointer';
			  refreshControlUI.style.color = 'black';
			  refreshControlUI.style.textAlign = 'center';
			  refreshControlUI.title = 'Click to reload the map';
			  refreshControlDiv.appendChild(refreshControlUI);

			  // Set CSS for the control interior
			  var refreshControlText = document.createElement('DIV');
			  refreshControlText.style.fontFamily = 'Arial,sans-serif';
			  refreshControlText.style.fontSize = '12px';
			  refreshControlText.style.paddingLeft = '4px';
			  refreshControlText.style.paddingRight = '4px';
			  refreshControlText.innerHTML = '<b ">Reload</b>';
			  refreshControlUI.appendChild(refreshControlText);

			  // Setup the click event listeners: simply set the map to Chicago
			  google.maps.event.addDomListener(refreshControlUI, 'click', function() {
					  editable = 1;
					  initialize();
					  });
		  }
		function FinalControl(finalControlDiv, map) {

		  // Set CSS styles for the DIV containing the control
		  // Setting padding to 5 px will offset the control
		  // from the edge of the map
		  finalControlDiv.style.padding = '5px';

		  // Set CSS for the control border
		  var finalControlUI = document.createElement('DIV');
		  finalControlUI.style.backgroundColor = 'pink';
		  finalControlUI.style.borderStyle = 'solid';
		  finalControlUI.style.borderWidth = '2px';
		  finalControlUI.style.color = 'black';
		  finalControlUI.style.cursor = 'pointer';
		  finalControlUI.style.textAlign = 'center';
		  finalControlUI.title = 'Click to Set As Home';
		  finalControlDiv.appendChild(finalControlUI);

		  // Set CSS for the control interior
		  var finalControlText = document.createElement('DIV');
		  finalControlText.style.fontFamily = 'Arial,sans-serif';
		  finalControlText.style.fontSize = '12px';
		  finalControlText.style.paddingLeft = '4px';
		  finalControlText.style.paddingRight = '4px';
		  finalControlText.innerHTML = '<b>Set Home</b>';
		  finalControlUI.appendChild(finalControlText);

		  // Setup the click event listeners: simply set the map to Chicago
		  google.maps.event.addDomListener(finalControlUI, 'click', function() {
				marker.setDraggable(false);
				document.getElementById('newloc').value = marker.getPosition();
				document.latform.submit();
				  });
	  	}
		var contentString='<div style="padding:5px;color:black" >Plese select your Home location</div>';
		  var infowindow = new google.maps.InfoWindow({
			content: contentString,
			position: india
			});
		function initialize() {	    		
	    		var myOptions = {
	      			zoom: 4,
	      			center: india,
	      			mapTypeId: google.maps.MapTypeId.ROADMAP
	    		};
	    		map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
			infowindow.open(map);
		 	var finalControlDiv = document.createElement('DIV');
    			var finalControl = new FinalControl(finalControlDiv, map);
    			finalControlDiv.index = 1;
	    		map.controls[google.maps.ControlPosition.RIGHT].push(finalControlDiv);

			var refreshControlDiv = document.createElement('DIV');
		    	var refreshControl = new RefreshControl(refreshControlDiv, map);

		    	refreshControlDiv.index = 2;
		    	map.controls[google.maps.ControlPosition.RIGHT].push(refreshControlDiv);

			google.maps.event.addListener(map, 'click', function(event) {	
				addMarker(event.latLng);
		    	});
	  	}
		function addMarker(location) {
			if(editable)
			{
				infowindow.close();
		    		marker = new google.maps.Marker({
		      		position: location,
		      		map: map,
				draggable: true,
				title: 'Home',
		    		});
				editable=0;
			}
		};
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	<script type="text/javascript">
		function submitemailform()
		{
			document.emailedit.submit();
		}
		function submitcontactform()
		{
			document.contactedit.submit();
		}
		function submitaddform()
		{
			document.addedit.submit();
		}
		function submitcountryform()
		{
			document.countryedit.submit();
		}
	</script> 
	<script type="text/javascript">
	function hide() 
	{
		document.getElementById('templatemo_body_wrapper').parentNode.childNodes[4].style.display='None';
	}
	$(document).ready(function() {
		$('#e1').click(function() {
			$('#em').html("<form name='emailedit' action='profile.php' method='post' ><input type='text' value='" + $('#em').html() + "' name='newem' id='newem'/></form>");
			$('#e1').toggle();
			$('#e2').toggle();
		});
		$('#c1').click(function() {
			$('#c').html("<form name='contactedit' action='profile.php' method='post' ><input type='text' value='" + $('#c').html() + "' name='newc' id='newc'/></form>");
			$('#c1').toggle();
			$('#c2').toggle();
		});
		$('#a1').click(function() {
			$('#ad').html("<form name='addedit' action='profile.php' method='post' ><input type='text' value='" + $('#ad').html() + "' name='newad' id='newad'/></form>");
			$('#a1').toggle();
			$('#a2').toggle();
		});
		$('#co1').click(function() {
			$('#co').html("<form name='countryedit' action='profile.php' method='post' ><input type='text' value='" + $('#co').html() + "' name='newco' id='newco'/></form>");
			$('#co1').toggle();
			$('#co2').toggle();
		});
		var purrFlag = $('#purry').html()
		if(purrFlag!="")
		{
			var notice='';
			if(purrFlag=="1")
			{
				notice = '<div class="notice">'
						  + '<div class="notice-body">' 
							  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
							  + '<h3>Login Completed</h3>'
							  + '<p>You have successfully Logged in</p>'
						  + '</div>'
						  + '<div class="notice-bottom">'
						  + '</div>'
					  + '</div>';
			}
			$( notice ).purr({usingTransparentPNG: true});
			return false;
		}
	});
	</script>	
</head>
<body  onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<?php
	
	$con = mysql_connect("localhost","root","qwe123");
	if (!$con)
	{
		$flag = 'Could not connect: ' . mysql_error();
	}
	mysql_select_db("db", $con);
	// For updating
	if(isset($_POST['newloc']))
	{
		mysql_query("update user_table set latlng='".$_POST['newloc']."' where username='".$_SESSION['user']."'");
	}
	if(isset($_POST['newem']))
	{
		mysql_query("update user_table set email='".$_POST['newem']."' where username='".$_SESSION['user']."'");
		$_SESSION['email'] = $_POST['newem'];
	}
	if(isset($_POST['newc']))
	{
		mysql_query("update user_table set phNum='".$_POST['newc']."' where username='".$_SESSION['user']."'");
		$_SESSION['phoneNumber'] = $_POST['newc'];
	}
	if(isset($_POST['newad']))
	{
		mysql_query("update user_table set address='".$_POST['newad']."' where username='".$_SESSION['user']."'");
	}
	if(isset($_POST['newco']))
	{
		mysql_query("update user_table set country='".$_POST['newco']."' where username='".$_SESSION['user']."'");
	}
	$result = mysql_query("SELECT * FROM user_table where username='".$_SESSION['user']."'");
	while($row = mysql_fetch_array($result))
	{
		$id = $row['id'];
		$gen = $row['gender'];
		$dob = $row['dob'];
		$addr = $row['address'];
		$coun = $row['country'];
		$latH = $row['latlng'];
		$secq = $row['sq'];
		$seca = $row['sa'];
		$orgz = $row['organization'];		
	}	
	mysql_close($con);
?>
<div id="templatemo_body_wrapper">

<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>
	
    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>
		<form action="profile.php" name="latform" method="post" ><input id="newloc" type="text" name="newloc" style="display:none"/></form>
		<h2>Profile Information</h2>
		<hr style="border:solid 5px #310902" /><br />
		<center><table width="75%" >
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" width="40%">Full Name&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $_SESSION['name']; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Username&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $_SESSION['user']; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Email-Id&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td id="em" ><?php echo $_SESSION['email']; ?></td>
				<td><a id="e1" href="#" >Edit</a><a href="javascript: submitemailform()" id="e2" style="display:none">Submit</a></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Contact No.&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td id="c" ><?php echo $_SESSION['phoneNumber']; ?></td>
				<td><a href="#" id="c1" >Edit</a><a href="javascript: submitcontactform()" id="c2" style="display:none">Submit</a></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Gender&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $gen; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Date of Birth&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $dob; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Address&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td id="ad" ><?php echo $addr; ?></td>
				<td><a href="#" id="a1" >Edit</a><a href="javascript: submitaddform()" id="a2" style="display:none">Submit</a></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Country&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td id="co" ><?php echo $coun; ?></td>
				<td><a href="#" id="co1" >Edit</a><a href="javascript: submitcountryform()" id="co2" style="display:none" >Submit</a></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Home Latlng&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td ><?php echo $latH; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Password&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><a id="button" >Change Password</a>
					<div id="popupContact">
					<a id="popupContactClose">x</a>
					<h1>Change Password</h1>
		<iframe style="position:relative;margin-left:15px" src="simple.php" width="433px" height="200px" frameborder="0" ></iframe>
				</div>
				<div id="backgroundPopup"></div>
				</td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Secret Question&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $secq; ?></td>
				<td></td>
			</tr>
			<tr style="text-align:left;font-size:15px">
				<td style="padding-bottom:8px" >Secret Answer&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $seca; ?></td>
				<td></td>
			</tr>
		</table></center><br />
		<hr style="border:solid 5px #310902" />			
	</div>
        <div id="templatemo_sidebar">        	
		<br /><br />
		<h2 style="border-bottom:none">Change Home Location</h2>
		<div id="map_canvas" style="border:solid #5177E8 3px;width:450px; height:400px"></div>		
    	</div>
        
    <div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
		Copyright © 2010 <a href="/Major_Project/Home/index.php">SmartRide</a> | 
		Designed by <a href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" target="_parent">Tushar</a> 
    
    </div> <!-- end of templatemo_footer -->
    <div id="purry" style="display:none"><?php if(isset($_GET['f'])) echo $_GET['f'];?></div>
    </div>
</div>

</body>
</html>
