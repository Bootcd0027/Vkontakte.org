<?php include("../Common/login.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>
	<?php include("../Common/common_head.php"); ?>	
	<script type="text/javascript">
	function hide() {
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[4].style.display='None';
		}
	</script>
	<script type="text/javascript">
   		$( document ).ready( function ()
			{	
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
			}
		);								
   	</script>	
</head>
<body onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<div id="templatemo_body_wrapper">

<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>

    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>		
		<h3 class="title"> 
                Pooling Etiquette</h3> 
            <span class="pageContent"><ul>
    <li>Decide on the commute vehicle. You could opt for one of the following options-<br>
        <ul>
            <li>One member gets his/her own vehicle everyday.<br>
        <li>Each of the members get their vehicles on a rotational basis.<br>
        <li>A rental agency can be contacted for the vehicle, with or without a driver.<br><br></li></ul>
        If any of the first two options are chosen, then the fare should be arrived at based on the fuel, maintenance
        and parking costs and be shared equally amongst the participating pool members. If the third option is chosen,
        then the amount quoted by the agency can be directly used.<br>
        <br>

    </li>
    <li>Stick to the time. Once a time has been agreed upon, make it a point to keep it up. However, a flexibility of
        about 10-15 minutes can be accorded.<br><br></li>

    <li>Agree upon a route of commute that is suitable to all.<br><br></li>
    <li>Do not opt out of the pool without a week's notice. If you have to, it is a good practice to pay your share of
        the weekly fare before moving out.<br><br></li>
    <li>If you are a smoker and the others in the pool are not, avoid smoking for the
        duration of the travel or take prior permission.<br><br></li>
    <li>If all don't share the same taste in music, use personal headphones/earphones.<br><br></li>
    <li>Maintain a comfortable distance between the members, especially when you
        are pooling with members of the opposite sex.<br><br></li>
    <li>Do not use the pool to run personal errands.<br><br></li>
    <li>Last but not the least, keep the conversation light and enjoyable.<br><br></li>
    <li>All said and done have a great time and enjoy the power of pooling!<br><br></li>


</ul>

	</div>
        <div id="templatemo_sidebar">
        	<div class="sidebar_box">
			<img src="smok.png" width="250px"/>
			<img src="dist.jpg" width="250px"/>
			<img src="num.jpg" style="border: solid #222;margin-top:50px" width="250px"/>
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

</body>
</html>
