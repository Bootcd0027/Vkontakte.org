<?php
	session_start();
	if(isset($_POST['ids']))
	{
		$con = mysql_connect("localhost","root","qwe123");
			if (!$con)
		{
		$flag = 'Could not connect: ' . mysql_error();
		}
		list($id1,$id2)=split(' ',$_POST['ids']);
		list($u1,$u2)=split(' ',$_POST['uns']);
		list($emF,$phF)=split(' ',$_POST['emPh']);
		mysql_select_db("db", $con);
		$result = mysql_query("update tours set sharer='$u1' where id='$id2'");
		$result = mysql_query("update tours set sharer='$u2' where id='$id1'");

		//Mail yourself
		$sentFlag1="";
		require_once('mailer/class.phpmailer.php');
      		$mail = new PHPMailer();
      		$body = "Dear ".$u1.",<br />\t Your tour has been shared with ".$u2."(".$phF.")".". Please check the site for the details of your Ride Partner.<br />Happy Pooling :-)<br /> Regards,<br />Smart Ride Team";

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
	
	      	$mail->SetFrom("smartride.iiit@gmail.com","Smart Ride");
		$mail->AddReplyTo("smartride.iiit@gmail.com","Smart Ride");
		$mail->Subject    = "Subject : Ride Sharer Found";

	      	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer! like gmail"; // optional, comment out and test

	      	$mail->MsgHTML($body);

	      	$mail->AddAddress($_SESSION['email'],$u1);
	      	if(!$mail->Send()) 
	      	{
			$sentFlag1=1;
	      	}
	      	else 
		{
			$sentFlag1=2;
	      	}



		//Mail other person
		$sentFlag2="";
      		$mail = new PHPMailer();
      		$body = "Dear ".$u2.",<br />\t Your tour has been shared with ".$u1."(".$_SESSION['phoneNumber'].")".". Please check the site for the details of your Ride Partner.<br />Happy Pooling :-)<br /> Regards,<br />Smart Ride Team";

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
	
	      	$mail->SetFrom("smartride.iiit@gmail.com","Smart Ride");
		$mail->AddReplyTo("smartride.iiit@gmail.com","Smart Ride");
		$mail->Subject    = "Subject : Ride Sharer Found";

	      	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer! like gmail"; // optional, comment out and test

	      	$mail->MsgHTML($body);

	      	$mail->AddAddress($emF,$u2);
	      	if(!$mail->Send()) 
	      	{
			$sentFlag2=1;
	      	}
	      	else 
		{
			$sentFlag2=2;
	      	}
	}
	header('Location: /Major_Project/Profile/pool.php');
?>
