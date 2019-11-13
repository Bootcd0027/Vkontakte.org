<?php
	session_start();
	$con = mysql_connect("localhost","root","qwe123");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("db", $con);
	if(isset($_POST['startPoint']))
	{
		$uname=$_SESSION['user'];

                $src = $_POST['startPoint'];
		$wayp1 = $_POST['wayPoint1'];
		$wayp2 = $_POST['wayPoint2'];
		$wayp3 = $_POST['wayPoint3'];
		$dest = $_POST['endPoint'];

                $srcN = $_POST['startPointN'];
		$wayp1N = $_POST['wayPoint1N'];
		$wayp2N = $_POST['wayPoint2N'];
		$wayp3N = $_POST['wayPoint3N'];
		$destN = $_POST['endPointN'];

                $bdate=$_POST['beginDate'];
                $bmonth=$_POST['beginMonth'];
                $byear=$_POST['beginYear'];
                $bh=$_POST['beginTimeHours'];
                $bm=$_POST['beginTimeMins'];
                $bap=$_POST['beginTimeAmPm'];
		if($bap=="PM")
			$bh = $bh+12;
		$bo=$_POST['offsetBegin'];
		$finalD = $byear."-".$bmonth."-".$bdate;
		$startGlobal = mktime($bh,$bm,0,$bmonth,$bdate,$byear);
                $rtflag=$_POST['ret'];
                $who=$_POST['mode'];
                $share_preference=$_POST['pref'];
               	$sex=$_POST['genpref'];
               	$age=$_POST['minage'] . " " . $_POST['maxage'];
		if($share_preference=='a')
		{
			$age = null;
			$sex = null;			
		}		
mysql_query("insert into tours values('$uname','$src','$wayp1','$wayp2','$wayp3','$dest','$who','$share_preference','$sex','$age','$startGlobal','$bo','$finalD','$srcN','$wayp1N','$wayp2N','$wayp3N','$destN','',NULL)");
                if($rtflag=="True")
                {
			$rh=$_POST['returnTimeHours'];
		        $rm=$_POST['returnTimeMins'];
		        $rap=$_POST['returnTimeAmPm'];
			if($rap=="PM")
				$rh = $rh+12;
			$ro=$_POST['offsetReturn'];
			$rtdate=$_POST['returnDate'];
	                $rtmonth=$_POST['returnMonth'];
	                $rtyear=$_POST['returnYear'];
			$finalrD = $rtyear."-".$rtmonth."-".$rtdate;
			$retGlobal = mktime($rh,$rm,0,$rtmonth,$rtdate,$rtyear);	
mysql_query("insert into tours values('$uname','$dest','$wayp3','$wayp2','$wayp1','$src','$who','$share_preference','$sex','$age','$retGlobal','$ro','$finalrD','$destN','$wayp3N','$wayp2N','$wayp1N','$srcN','',NULL)");
                }

	}
	header("Location: /Major_Project/Profile/pool.php?f=1");
?>
