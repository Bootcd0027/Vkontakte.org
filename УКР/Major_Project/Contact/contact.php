<?php include("../Common/login.php"); ?>
<?php
	if(isset($_POST['subject']))
	{
		$sentFlag="";
		require_once('mailer/class.phpmailer.php');
      		$mail = new PHPMailer();
      		$body = $_POST['message'];

	      $mail->IsSMTP(); // telling the class to use SMTP
	      $mail->Host       = "mail.google.com"; // SMTP server
	      $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	      // 1 = errors and messages
	      // 2 = messages only
	      $mail->SMTPAuth   = true;                  // enable SMTP authentication
	      $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	      $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	      $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	      $mail->Username   = "smartride.iiit@gmail.com";  // GMAIL username
	      $mail->Password   = "iiit1234";            // GMAIL password

	      $mail->SetFrom($_POST['email'], $_POST['userName']);

	      $mail->AddReplyTo($_POST['email'], $_POST['userName']);

	      $mail->Subject    = "Subject : ".$_POST['subject'];

	      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer! like gmail"; // optional, comment out and test

	      $mail->MsgHTML($body);

	      $mail->AddAddress("smartride.iiit@gmail.com","Smart Ride");
		//Send the mail
	      if(!$mail->Send()) 
	      {
			$sentFlag=1;
	      }
	      else {
			$sentFlag=2;
	      }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>
	<?php include("../Common/common_head.php"); ?>	
	<link rel="stylesheet" href="Map_Show/general.css" type="text/css" media="screen" />
	<script type="text/javascript" src="Map_Show/popup.js" ></script>
	<script type="text/javascript">
	//This is for hiding a problem with menu
	function hide() {
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[4].style.display='None';
		}
	</script>
	<script type="text/javascript">
   		$( document ).ready( function ()
			{
				//Getting the purr flag to decide what to display
				var purrFlag = $('#purry').html()
				if(purrFlag!="")
				{
					//The building of notification
					var notice='';
					if(purrFlag=="1")
					{
						notice = '<div class="notice">'
								  + '<div class="notice-body">' 
									  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
									  + '<h3>Message Sending Failed</h3>'
									  + '<p>Mail server Not Responding</p>'
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
									  + '<h3>Message Sent Succesfully</h3>'
									  + '<p>We will address Your mail ASAP</p>'
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
					$( notice ).purr({usingTransparentPNG: true});
					return false;
				}
			}
		);								
   	</script>
</head>
<body style="position:relative;margin-left:-15px" onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<div id="templatemo_body_wrapper">

<div id="templatemo_wrapper">
	<!-- Start of menu and Login dialog-->
	<?php include("../Common/common_body.php"); ?>
	<!-- End of Menu and Login dialog -->
    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>
		<!-- Start of Contact form -->
		<form name="contactUs" action="contact.php" method="post" >
		    <table>
			<tr>
			    <td style="width:170px;color:grey">Name
				<div style="color:red;display:inline;"> *</div>
			    </td>
			    <td><input type="text"
				       style="width:60%"
				       name="userName" value="<?php echo $_SESSION['name']; ?>" />
			    </td>
			</tr>
			<tr>
			    <td></td>
			</tr>
			<tr>
			    <td style="color:grey">Your Email Address
				<div style="color:red;display:inline;"> *</div>
			    </td>
			    <td><input type="text"
				       style="width:60%"
				       name="email" value="<?php echo $_SESSION['email']; ?>" /></td>
			</tr>
			<tr>
			    <td></td>
			</tr>
			<tr>
			    <td style="color:grey">Nature of Enquiry/Feedback
				<div style="color:red;display:inline;"> *</div>
			    </td>
			    <td><input type="text" style="width:60%" name="subject" /></td>
			</tr>
			<tr>
			    <td></td>
			</tr>
			<tr>
			    <td style="color:grey">Enquiries/Suggestions
				<div style="color:red;display:inline;"> *</div>
			    </td>
			    <td><textarea name="message"
				          rows="8"
				          cols="27"></textarea>
			    </td>
			</tr>
			<tr>
			    <td></td>
			</tr>
			<tr>
			    <td></td>
			    <td>
				<input type="submit" value="Submit">
			    </td>
			</tr>
		    </table>
		</form>
		<!-- End of Contact form -->
	</div>
        <div id="templatemo_sidebar">
        	<div class="sidebar_box">
		<div class="df_box">
			<h2>Contact Information</h2>
			<table >
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Name&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>Konduri Praneeth</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Email-Id&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>konduri.praneeth@gmail.com</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Contact No.&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>9618126701</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Address&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>IIIT Hyderabad</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>		
		<div class="df_box">
			<table>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Name&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>Tushar Chandra</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Email-Id&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>ntca92@gmail.com</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Contact No.&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>8121431310</td>
				</tr>
				<tr style="text-align:left;font-size:15px">
					<td style="padding-bottom:8px" >Address&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>IIIT Hyderabad</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<!-- The popup box for Showing our location -->
		<div id="button" style="position:relative;margin-top:-405px" ><input type="submit" value="Our Location"/></div>
		<div id="popupContact">
			<a id="popupContactClose">x</a>
			<h1>Our Location</h1>
			<iframe style="position:relative;margin-left:-10px" src="simple.html" width="433px" height="350px" frameborder="0" >
			</iframe>

		</div>
		<div id="backgroundPopup"></div>
	</div>
    </div>
        
    <div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
		Copyright © 2010 <a href="/Major_Project/Home/index.php">SmartRide</a> | 
		Designed by <a href="/Major_Project/Contact/contact.php" target="_parent">Praneeth</a> and <a href="/Major_Project/Contact/contact.php" target="_parent">Tushar</a> 
    
    </div> <!-- end of templatemo_footer -->
    <div id="purry" style="display:none"><?php echo $logErr; echo $sentFlag; ?></div>
    </div>
</div>

</body>
</html>
