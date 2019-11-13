<?php
//check that the user is calling the page from the login form and not accessing it directly 
//and redirect back to the login form if necessary
$logErr = "";
session_start();
if(!isset($_SESSION['user']))
{
	$loginusername = $_POST['loginusername']; 
	$loginpassword = $_POST['loginpassword'];
	//If username and password are sent for login
	if (isset($loginusername) && isset($loginpassword) && !empty($loginusername) && !empty($loginpassword))
	{ 
		//convert the field values to simple variables 
		//add slashes to the username and md5() the password 
		$loginuser = addslashes($loginusername); 
		$loginpass = md5($loginpassword); 


		//set the database connection variables 
		$dbHost = "localhost"; 
		$dbUser = "0032"; 
		$dbPass = "0032"; 
		$dbDatabase = "0032"; 

		//connet to the database 
		$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die ("Error connecting to database."); 

		mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database."); 

		$result=mysql_query("select * from user_table where username='$loginuser' AND password='$loginpass'", $db); 

		//check that at least one row was returned 
		$rowCheck = mysql_num_rows($result); 
		if($rowCheck > 0)
		{ 
			while($row = mysql_fetch_array($result))
			{

			//start the session and register a variable 
		  	$_SESSION['user']=$loginusername;
			$_SESSION['name']=$row['fullName'];
			$_SESSION['email']=$row['email'];
			$_SESSION['phoneNumber']=$row['phNum'];

		  	//we will redirect the user to another page where we will make sure they're logged in 
			header('Location: /Major_Project/Profile/profile.php?f=1');
			} 
		} 
		else 
		{ 
			//if nothing is returned by the query, unsuccessful login code goes here... 
			$logErr = 3;
		}
	}
}
  ?> 
