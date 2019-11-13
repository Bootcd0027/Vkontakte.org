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
</head>
<body style="position:relative;margin-left:-15px" onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<div id="templatemo_body_wrapper">

<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>

    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>		
		<form action="forgot2.php" method="post" >
			<span style="font-size:15px" >Enter Your E-mail Id : </span><input type="text" name="em" />
			<input type="submit" value="Submit" />
			<?php if($_GET['f']==1) echo "Wrong Email id"; ?>
		</form><br />
    
        <div style="padding: 16px 0 0 0;text-align: center;color: #AAAAAA;">

	Copyright © 2010 <a href="/Major_Project/Home/index.php" style="font-weight: normal;color: #FFFFFF;">SmartRide</a> | 
	Designed by <a style="font-weight: normal;color: #FFFFFF;" href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" style="font-weight: normal;color: #FFFFFF;" target="_parent">Tushar</a> </div>
    
	</div>      
    </div>
        
    <div class="cleaner"></div>

    
   
    </div>
</div>

</body>
</html>
