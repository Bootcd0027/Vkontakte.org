<?php
if(isset($_POST['oldp']) && isset($_POST['newp']) && isset($_POST['verp']))
{
	$flag=0;
	$old=$_POST['oldp'];
	$new=$_POST['newp'];
	$ver=$_POST['verp'];
	if($ver != $new)
	{
		$flag=-2;
	}
	else if($ver == $new and strlen($ver)<6)
	{
		$flag=2;
	}
	else
	{
		session_start();
		$con = mysql_connect("localhost","root","qwe123");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("db", $con);
		$result=mysql_query("select password from user_table where username='".$_SESSION['user']."'");
		while($row = mysql_fetch_array($result))
		{
			$pass = $row['password'];
		}
		if(isset($old))
		{
			if(md5($old)==$pass)
			{
				$flag=1;
				mysql_query("update user_table set password='".md5($new)."' where username='".$_SESSION['user']."'");
			}
			else
			{
				$flag=-1;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<body>
	<center><?php 
		if($flag==1)
			echo "<span style='color:green;font-size:15px'>Password Changed</span>"; 
		else if($flag==2)
			echo "<span style='color:red;font-size:15px'>Password too Short</span>"; 
		else if($flag==-1)
			echo "<span style='color:red;font-size:15px'>Incorrect Old Password</span>";
		else if($flag==-2)
			echo "<span style='color:red;font-size:15px'>New Passwords Did not match!</span>";
	?></center>
	<form action="simple.php" method="post">
		<table>
			<tr>
				<td>Old Password</td>
				<td><input name="oldp" type="password" /></td>
			</tr>
			<tr>
				<td>New Password</td>
				<td><input name="newp" type="password" /></td>
			</tr>
			<tr>
				<td>Re-Type New Password</td>
				<td><input name="verp" type="password" /></td>
			</tr>
		</table>
		<center><input type="submit" value="Change" /></center>
	</form>
</body>
</html>
