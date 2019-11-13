<?php include("../Common/login.php"); ?>
<?php
	$con = mysql_connect("localhost","root","qwe123");
	if (!$con)
	{
		$flag = 'Could not connect: ' . mysql_error();
	}
	mysql_select_db("db", $con);
	$email="";
	if(isset($_POST['em']))
		$email = $_POST['em'];
	if(isset($_GET['email']))
		$email = $_GET['email'];
	$result = mysql_query("select sq from user_table where email='".$email."'");
	if(mysql_num_rows($result)==0 && !isset($_GET['email']))
		header("Location: /Major_Project/Profile/forgot1.php?f=1");
	$question = "";
	while($row = mysql_fetch_array($result))
	{
		$question = $row['sq'];
	}
?>
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
		<form action="forgot3.php" method="post" >
			<input style="display:none" type="text" name="email" id="email" value="<?php echo $email; ?>" />
			<table>
				<tr>
					<td><div style="font-size:15px" >Question</div></td>
					<td><div style="font-size:15px" ><?php echo $question; ?></div></td>
				</tr>
				<tr>
					<td><span style="font-size:15px" >Enter the Answer</span></td>
					<td><input type="text" name="ans" id="ans" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Restore" /></td>
				</tr>
			</table>					
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
