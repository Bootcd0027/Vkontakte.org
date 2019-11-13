<?php
	//Start the session
	session_start();
	
	//Check if session already exists
	if(isset($_SESSION['user']))
	{
		//Unset all session variables;
		session_unset();
		//Destroy the session so that a new session can start
		session_destroy(); 
		//Rdirect to home page with Flag=2 for purr
		header( 'Location: /Major_Project/Home/index.php?f=2' ) ;
	}
	//If already logged out i.e. session expired
	else
		header( 'Location: /Major_Project/Home/index.php' ) ;
?>
