<?php include("../Common/login.php"); ?>
<?php
	$flag=-2;
	$uname=$_POST['username'];
	if($uname!='')
	{
		$email=$_POST['email'];
		$pass=md5($_POST['password']);
		$fname=$_POST['name'];
		$sex=$_POST['gender'];
		$dob=$_POST['dob'];
		$phno=$_POST['phone'];
		$address=$_POST['addr'];
		$country=$_POST['country'];
		$homecd=$_POST['latlngH'];
		$sq=$_POST['sq'];
		$sa=$_POST['sa'];
		$org=$_POST['org'];
		$con = mysql_connect("localhost","0032","0032");
		if (!$con)
	  	{
			$flag = 'Could not connect: ' . mysql_error();
	  	}
		mysql_select_db("0032", $con);
	$sqlq = "insert into user_table	values('','$fname','$sex','$dob','$phno','$uname','$email','$pass','$address','$country','$homecd','$sq','$sa','$org')";
		if (mysql_query($sqlq,$con))
	  	{
	  		$flag = 0;
			header( 'Location: /Major_Project/Home/index.php?f=1' ) ;
	  	}
		else
	  	{
			$flag = "Error Inserting database: " . mysql_error();
	  	}
		mysql_close($con);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>	
	<?php include("../Common/common_head.php"); ?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.sexy-captcha-0.1.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="css/sexy-captcha/styles.css" />
        <link rel="stylesheet" href="FancySlidingForm/css/style.css" type="text/css" media="screen"/>
        <script type="text/javascript" src="FancySlidingForm/sliding.form.js"></script>
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
					  document.getElementById('latlngH').value ='';
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
				document.getElementById('latlngH').value = marker.getPosition();
				  });
	  	}
		var contentString='<div style="padding-left:5px;color:black" >Plese select your Home location</div>';
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
	<script>
		$(document).ready(function() {
			var purrFlag = $('#purry').html()
			if(purrFlag!="")
			{
				var notice='';
				if(purrFlag=="3")
				{
					notice = '<div class="notice">'
							  + '<div class="notice-body">' 
								  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
								  + '<h3>Login Failed</h3>'
								  + '<p>Incorrect Username or Password</p>'
							  + '</div>'
							  + '<div class="notice-bottom">'
							  + '</div>'
						  + '</div>';
				}
				$( notice ).purr({usingTransparentPNG: true});
				return false;
			}
			$('.myCaptcha').sexyCaptcha('captcha.process.php');
		});		
	</script>
	<script type="text/javascript">
		function hide()
		{
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[3].style.display='None';
		}
	</script>
	<style>
        span.reference{
            position:fixed;
            left:5px;
            top:5px;
            font-size:10px;
            text-shadow:1px 1px 1px #fff;
        }
        span.reference a{
            color:#555;
            text-decoration:none;
			text-transform:uppercase;
        }
        span.reference a:hover{
            color:#000;
            
        }
        h1{
            color:#ccc;
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
    </style>
</head>
<body onload="hide()">
<div id="templatemo_body_wrapper">
	<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>
		<div id="templatmeo_main" style="width:1180px">
		    	<div id="templatemo_content"><span class="bottom"></span>
				<div style="position:absolute;display:none" class="resultCap"></div>
				<div id="content">
				    <div id="wrapper">
					<div id="steps">
					    <form id="formElem" name="formElem" action="register.php" method="post">
						<fieldset class="step">
						    <legend>Account</legend>
						    <p>
							<label for="username">User name</label>
							<input id="username" name="username" value="[Minimum 6 Characters]"/>
						    </p>
						    <p>
							<label for="password">Password</label>
							<input id="password" name="password" type="password" placeholder="Minimum 6 Characters" />
						    </p>
						    <p>
							<label for="email">Email</label>
							<input id="email" name="email" placeholder="E.g x@y.com" type="email" AUTOCOMPLETE=OFF />
						    </p>
						    <p>
							<label for="sq">Secret Question</label>
							<input id="sq" name="sq" placeholder="For retrieving password" type="text" AUTOCOMPLETE=OFF />
						    </p>
						    <p>
							<label for="sa">Secret Answer</label>
							<input id="sa" name="sa" placeholder="Remeber this answer!!" type="text" AUTOCOMPLETE=OFF />
						    </p>
						</fieldset>
						<fieldset class="step">
						    <legend>Personal Details</legend>
						    <p>
							<label for="name">Full Name</label>
							<input id="name" name="name" type="text" AUTOCOMPLETE=OFF />
						    </p>
						    <p>
							<label for="gender">Gender</label>
							<span style="float:left;color:#666;text-shadow:1px 1px 1px #fff;;margin-left:15px" ><b>Male</b></span><input style="float:left;" id="male" value="M" name="gender" checked='checked' type="radio" />
							<span style="color:#666;text-shadow:1px 1px 1px #fff" ><b>Female</b></span><input id="female" name="gender" value="F" type="radio" />
						    </p>
						    <p>
							<label for="name">Date Of Birth</label>
							<input id="dob" name="dob" type="text" placeholder="DD-MM-YYYY"AUTOCOMPLETE=OFF />
						    </p>
						    <p>
							<label for="org">Organization / College</label>
							<input id="org" name="org" type="text" AUTOCOMPLETE=OFF />
						    </p>						    
						    <p>
							<label for="phone">Phone &nbsp;&nbsp;&nbsp;&nbsp;+91</label>
							<input id="phone" name="phone" placeholder="E.g 9908825023" type="text" AUTOCOMPLETE=OFF />
						    </p>						    
						</fieldset>						
						<fieldset class="step">
						    <legend>Location</legend>
						    <p>
							<label for="address">Address</label>							
							<textarea rows="2" cols="20" name="addr" ></textarea>
						    </p>
						    <p>
							<label for="country">Country</label>
							<input id="country" name="country" type="text" AUTOCOMPLETE=OFF />
						    </p>
						    <p>
							<label for="latlngH">Home Latitue Longitude</label>
							<input placeholder="Select from the Map" id="latlngH" name="latlngH" readonly="readonly" type="text" AUTOCOMPLETE=OFF />
						    </p>
						</fieldset>
						<fieldset class="step">
						    <legend>Terms Of Use</legend>
							<div style="color:grey;text-align:justify; margin:10px">The user explicitly agrees that the use of the website is at his/her sole risk. The service being offered is on "AS IS WHERE IS BASIS" Our main aim in starting this service is to help people share their Ride and experience a hassle free, stress free Ride. SmartRide.com provides a virtual meeting place for people seeking out potential car pooling partners. Since we are donning the role of being facilitators only, we do not claim any responsibility for the suitability of the individuals and/or the car rental agencies as the case may be, contacted through this service and disclaim any liability in this connection. SmartRide.com and/or its respective suppliers may make improvements and/or changes in this web site at any time.This web site may be temporarily unavailable from time to time due to required maintenance, telecommunications interruptions, or other disruptions. Should SmartRide.com exercise its right to modify or discontinue any or all of the contents, information, software, products, features and services published on this website. Dreadlords do not provide any guarantee with respect to the uptime of its website. However, we will endeavor to provide services to the best of our ability. Dreadlords and/or its respective associated entities make no representations about the suitability of the contents, information, software, products, features and services contained on this web site for any purpose.	</div>
							<input style="float:left;margin-left:-70px;margin-top:10px" id="dump" value="ticked" name="agree" type="checkbox" /><span style="float:left;color:black;text-shadow:1px 1px 1px #fff;margin-left:45px;margin-top:-15px" ><b>I accept to the Terms of Service above and both the Program Policy and the Privacy Policy.</b></span>
						</fieldset>
						<fieldset class="step">
						    <legend>Confirm</legend>							
							<div style="margin-left:80px;margin-top:100px" class="myCaptcha"></div>
						    <p style="margin-left:250px" class="submit">
							<button id="registerButton" type="submit">Register</button>
						    </p>
						</fieldset>
					    </form>
					</div>
					<div id="navigation" style="display:none;">
					    <ul>
						<li class="selected">
						    <a href="#">Account</a>
						</li>
						<li>
						    <a href="#">Personal Details</a>
						</li>						
						<li>
						    <a href="#">Location</a>
						</li>
						<li>
						    <a href="#">Verification</a>
						</li>
						<li>
						    <a href="#">Confirm</a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			</div>
			<div id="templatemo_sidebar" style="width:470px">
			    	<div class="sidebar_box">
			    		<h2 style="border-bottom: 8px solid #501004">Your Location</h2>
					<div id="map_canvas" style="left:15px;border:solid #5177E8 3px;width:450px; height:400px"></div>
			    	</div>
			</div>
			<div class="cleaner"></div>
    		</div>
		<div id="templatemo_footer">    
		Copyright © 2010 <a href="/Major_Project/Home/index.php">SmartRide</a> | 
		Designed by <a href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" target="_parent">Tushar</a> 
    		</div> <!-- end of templatemo_footer -->
		<div id="purry" style="display:none"><?php echo $logErr; ?></div>
    	</div>
</div>
