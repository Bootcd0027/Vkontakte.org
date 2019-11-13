<?php include("../Common/login.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>	
	<?php include("../Common/common_head.php"); ?>
	<!-- THE CALCULATORS -->
	<link type='text/css' href='Calculator/contact.css' rel='stylesheet' media='screen' />
	<script type='text/javascript' src='Calculator/jquery.simplemodal.js'></script>
	<script type='text/javascript' src='Calculator/contact.js'></script>
	<script type='text/javascript' src='Footprint/contact.js'></script>
	<!-- THE CALCULATORS -->

	<!--Nivo slider-->
	<link rel="stylesheet" href="/Major_Project/Home/ImageSlider/nivo-slider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/Major_Project/Home/ImageSlider/nivo-slider1.css" type="text/css" media="screen" />
	<script src="/Major_Project/Home/ImageSlider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$('#slider').nivoSlider();
		});
	</script>
	<!--End of nivo slider -->
	<script type="text/javascript">
   		$( document ).ready( function ()
			{	
				var purrFlag = $('#purry').html()
				if(purrFlag!="")
				{
					var notice='';
					if(purrFlag=="1")
					{
						notice = '<div class="notice">'
								  + '<div class="notice-body">' 
									  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
									  + '<h3>Registration Successful</h3>'
									  + '<p>Please Login with your Details</p>'
								  + '</div>'
								  + '<div class="notice-bottom">'
								  + '</div>'
							  + '</div>';
					}
					else if(purrFlag=="2")
					{
						notice = '<div class="notice">'
								  + '<div class="notice-body">' 
									  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
									  + '<h3>Logout Completed</h3>'
									  + '<p>You have succesfully Logged out</p>'
								  + '</div>'
								  + '<div class="notice-bottom">'
								  + '</div>'
							  + '</div>';
					}
					else if(purrFlag=="3")
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
					else if(purrFlag=="5")
					{
						notice = '<div class="notice">'
								  + '<div class="notice-body">' 
									  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
									  + '<h3>Session Expired</h3>'
									  + '<p>You have been Logged Out!!</p>'
								  + '</div>'
								  + '<div class="notice-bottom">'
								  + '</div>'
							  + '</div>';
					}
					$( notice ).purr({usingTransparentPNG: true});
					return false;
				}
			}
		);								
   	</script>

	<script type="text/javascript">
		//Hide apycom free menu
		function hide()
		{
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[3].style.display='None';
		}
	</script>
</head>
<body onload="hide()">
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>
    
    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>
        	<div class="content_box">
                <h1>Welcome to Smart Ride</h1>
		<!--Start of slider -->
			<div id="slider" style="border: solid #5F90D4">	
				<img  src="/Major_Project/Home/ImageSlider/Images/0.png" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/1.jpg" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/2.jpg" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/3.jpg" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/4.jpg" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/5.png" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/6.gif" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/8.gif" alt="" />
				<img  src="/Major_Project/Home/ImageSlider/Images/9.jpg" alt="" />
			</div>
		<!--End of slider -->
		<p>Carpooling reduces the costs involved in car travel by sharing journey expenses such as fuel, tolls, and car rental between the people travelling. Carpooling is also seen as a more environmentally friendly and sustainable way to travel as sharing journeys reduces carbon emissions, traffic on the roads, and the need for parking spaces.</p>
		<p>Want to green your commute? Ridesharing is 2-6 people in a carpool or 7-15 people in a vanpool. It’s a green travel alternative because you help reduce the total number of cars on the road. You save time and money and the earth gets a breath of fresh air.</p>
		<p><b >Spare the Air Everyday</b><br />
		Learn how to travel smart to improve air quality and save gas. Find easy ways to Spare the Air Everyday or sign up for our RSS feeds, folllow us on twitter, or like our page on facebook to be notified in advance of Spare the Air Days.</p>
		</div>


        <div class="content_box last">
          	<div class="cl_box">               		
			<div id='contact-form'>
				<a href="#" class="contact"><img src="mSaving.jpg" alt="Image 2"/></a>				
				<input type='button' name='contact' value='Cost Calculator' style="font-size:19px" class='contact'/>
			</div>
                </div>
		<div class="cl_box"> 
			<img style="border:0;margin-top:20px"src="f.png" alt="Front Arrow"/>
			<img style="border:0" src="b.png" alt="Back Arrow"/>
		</div>
                <div class="cl_box">
			<div id='contact-form'>
	                    	<a href="#" class="contact2"><img style="border:0" src="cFoot.png" alt="Image 3" /></a>
				<input type='button' name='contact' value='Carbon Footprint' style="font-size:19px;margin-top:10px" class='contact2'/>
			</div>
                </div>
                
                <div class="cleaner"></div>
			</div>
        </div>
        <div id="templatemo_sidebar">
            	<div class="sidebar_box">
            		<h2>Car Pooling</h2>
			<p>
				Carpooling (also known as car-sharing, ride-sharing, lift-sharing and covoiturage), is
			 	the shared use of a car  by the driver and one or more passengers, usually for commuting.
			</p> 
			<br /> 
			<p> 
				SmartRide.in helps you offer or request:
			</p> 
			<p> 
			 	<ul> 
					<li><b>Regular car pools</b> (on a daily or weekly basis) for commuters who live nearby and have a common work destination. These carpools are on a repeated schedule.</li> 
					<br />
					<li><b>Casual car pools</b> (carpools at specific  date) for week-ends, exceptional trips, vacations...These carpools are on an as-needed basis.</li> 
				</ul> 
			</p> 
			<br /> 
			<p> 
				These days, there are more advantages to carpooling than ever before.<br /><br />
				You have the opportunity to save money on gas, help the environment and enjoy the company of others at the same time.
			</p> 
			<br />
			<p>
				If you have a car, split costs by offering carpools. If you don't have a car, use the system to find a carpool. 
			</p>
            	</div>
                
            	
       		<div class="sidebar_box">
       			<h2 >We strive to . . . . . . . .</h2>
        		<img src="pin.png" alt="Image" height="359px" width="300px" />
		</div>
        </div>
        
        <div class="cleaner"></div>
    </div>
    
    	<div id="templatemo_footer">    
		Copyright © 2010 <a href="/Major_Project/Home/index.php">SmartRide</a> | 
		Designed by <a href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" target="_parent">Tushar</a> 
    
    	</div> <!-- end of templatemo_footer -->
	<div id="purry" style="display:none"><?php echo $logErr; if(isset($_GET['f'])) echo $_GET['f'];?></div>
    </div>
</div>
</body>
</html>
