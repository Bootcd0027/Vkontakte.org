<!--Start Menu -->
<img src="/Major_Project/Common/Menu/images/border-left.png" style="position:relative;left:-15px"/>
<img src="/Major_Project/Common/Menu/images/border-right.png" style="float:right;position:relative;left:15px"/>
<div id="menu" style="position:relative;top:-41px">
	<ul class="menu">
		<li><a href="/Major_Project/Home/index.php" class="parent" style="font-size:15px"><span>Home</span></a></li>
		<?php
		if(!isset($_SESSION['user']))
			echo "<li><a href=\"#dialog1\" name=\"modal\" style=\"font-size:15px\"><span>Login</span></a></li><li><a href=\"/Major_Project/Register/register.php\" style=\"font-size:15px\"><span>Register</span></a></li><li><a href=\"/Major_Project/Profile/forgot1.php\" style=\"font-size:15px\"><span>Forgot Password</span></a></li>";
		else
			echo "<li><a href=\"/Major_Project/Profile/profile.php\" style=\"font-size:15px\"><span>Profile page</span></a></li><li><a href=\"/Major_Project/Maps/Map.php\" style=\"font-size:15px\"><span>Add Tour</span></a></li><li><a href=\"/Major_Project/Profile/pool.php\" style=\"font-size:15px\"><span>View Tours</span></a></li><li><a href=\"/Major_Project/Common/logout.php\" style=\"font-size:15px\"><span>Logout</span></a></li>"?>
		<li><a href="/Major_Project/Rules/etiquette.php" style="font-size:15px"><span>Etiqutte</span></a></li>
		<li><a href="/Major_Project/Contact/contact.php" style="font-size:15px"><span>Contact Us</span></a></li>
		<li><a href="#" style="font-size:15px"><span><img src="/Major_Project/Common/images/templatemo_rss.png" alt="RSS" /></span></a></li>
		<li><a href="http://www.facebook.com/pages/Smart-Ride/160923020607796" target="blank">
			<span><img src="/Major_Project/Common/images/fb_logo3.png" alt="Facebook" /></span>
		</a></li>
       		<li  class="last" style="font-size:15px"><a href="http://twitter.com/#!/smart_ride" target="blank">
			<span><img src="/Major_Project/Common/images/templatemo_twitter.png" alt="Twitter" /></span>
		</a></li>		
	</ul>
		<?php
			if(isset($_SESSION['user']))
				echo '<b style="color:silver;font-size:15px;position:relative;top:10px">Welcome, '.$_SESSION['user'].'</b>';
		?>
</div>
<!--End Menu -->

<!-- Start of site_title -->    
<div id="templatemo_header">
       	<div id="site_title">
       		<h1><a href="/Major_Project/Home/index.php" target="_parent">Smart Ride</a></h1>
       	</div> 
</div>
<!-- end of site_title -->
    
<div id="boxes">
	<!-- Start of Login Dialog -->  
	<div id="dialog1" class="window">
		<form name="loginform" method="post" >
		<div class="d-header">
	    		<input id="ip1" name="loginusername" type="text" placeholder="Username" onclick="this.value=''"/><br/>
	    		<input id="ip2" name="loginpassword" type="password" placeholder="Password" onclick="this.value=''"/>    
	  	</div>
	  	<div class="d-blank"></div>
	  	<div class="d-login"><a href="#"><img alt="Login" title="Login" src="/Major_Project/Common/Login/images/login-button.png"/></a></div>
		</form>
	<script>
		document.loginform.action = window.location.pathname;
	</script>	
	</div>
	<!-- End of Login Dialog -->  
<div id="mask"></div>
</div>

