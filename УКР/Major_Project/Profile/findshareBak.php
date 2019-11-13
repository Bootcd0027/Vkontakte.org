<?php include("../Common/login.php"); ?>
<?php
	if(isset($_GET['id']))
	{
		$flag=0;
		$con = mysql_connect("localhost","root","qwe123");
		if (!$con)
		{
			$flag = 'Could not connect: ' . mysql_error();
		}
		mysql_select_db("db", $con);
		$result = mysql_query("SELECT * FROM tours where id='".$_GET['id']."'");
		while($row = mysql_fetch_array($result))
		{
			$uName = $row['userName'];
			$id = $row['id'];
			$src = $row['source'];
			$wp1 = $row['wayp1'];
			$wp2 = $row['wayp2'];
			$wp3 = $row['wayp3'];
			$dest = $row['dest'];
			$who = $row['who'];
			$pref = $row['pref'];
			$genP = $row['manualGender'];
			$ageP = $row['manualAge'];
			$secT = $row['startGlobal'];
			$givenOff = $row['offSet'];
			$startD = $row['startDate'];
			$sharer = $row['sharer'];
			$sttoken = strtok($src,' (),');
                        $tokcount=0;
                        $stlat="";
			$stlng="";
			while ($sttoken != false)
			{
                               	if($tokcount==0)
                               		$stlat=$sttoken;
                               	else
        	               		$stlng=$sttoken;
			  	$sttoken = strtok(" (),");
                               	$tokcount=$tokcount+1;
			}
                        $tokcount=0;
                        $dtlat="";
			$dtlng="";
			$dttoken = strtok($dest,' (),');
			while ($dttoken != false)
			{
                               	if($tokcount==0)
                               		$dtlat=$dttoken;
                               	else
        	               		$dtlng=$dttoken;
			  	$dttoken = strtok(" (),");
                               	$tokcount=$tokcount+1;
			}
		}
		if($sharer!=null)
			header('Location: /Major_Project/Profile/pool.php');
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
		<?php
			$result = mysql_query("SELECT * FROM tours where userName!='".$uName."' and who!='".$who."' and sharer is NULL");
			while($row = mysql_fetch_array($result))
			{
				$uNameF =$row['userName'];
				$idF = $row['id'];
				$srcF = $row['source'];
				$wp1F = $row['wayp1'];
				$wp2F = $row['wayp2'];
				$wp3F = $row['wayp3'];
				$destF = $row['dest'];
				$prefF = $row['pref'];
				$genPF = $row['manualGender'];
				$agePF = $row['manualAge'];
				$secTF = $row['startGlobal'];
				$givenOffF = $row['offSet'];
				$startDF = $row['startDate'];
				$tokenF = strtok($srcF,' (),');
                                $tokcountF=0;
                                $stlatF="";
				$stlngF="";
				while ($tokenF != false)
				{
                                	if($tokcountF==0)
                                		$stlatF=$tokenF;
                                  	else
                                     		$stlngF=$tokenF;
				  	$tokenF = strtok(" (),");
                                  	$tokcountF=$tokcountF+1;
				}
		                $tokcountF=0;
		                $dtlatF="";
				$dtlngF="";
				$dttokenF = strtok($destF,' (),');
				while ($dttokenF != false)
				{
		                       	if($tokcountF==0)
		                       		$dtlatF=$dttokenF;
		                       	else
			               		$dtlngF=$dttokenF;
				  	$dttokenF = strtok(" (),");
		                       	$tokcountF=$tokcountF+1;
				}
//				echo $stlat." ".$stlng." ".$dtlat." ".$dtlng." ".$stlatF." ".$stlngF." ".$dtlatF." ".$dtlngF."<br /><br />";
				$srcCondition = ($stlatF-$stlat)*($stlatF-$stlat) + ($stlngF-$stlng)*($stlngF-$stlng) < 0.000009;
				$destCondition = ($dtlatF-$dtlat)*($dtlatF-$dtlat) + ($dtlngF-$dtlng)*($dtlngF-$dtlng) < 0.000009;
				$timeCondition = abs(($secTF/60)-($secT/60)) < min($givenOff, $givenOffF);
				$prefCondition=true;
				$reqsex="";
				$prefsex="";
                                  
				if($prefF=='m' and $pref !='m') 
				{
					$reqsex = mysql_query("SELECT gender FROM user_table where username='".$uName."'");
					while($rows = mysql_fetch_array($reqsex))
					{
						$prefsex=$rows['gender'];
					}
					if($prefsex==$genPF)
						{
							$prefCondition = true;
						}
					else
						$prefCondition=false;
 				}
                                if($prefF=='m' and $pref =='m') 
				{
					
					if($genPF==$genP)
						{
							$prefCondition=true;
						}
					else
						$prefCondition=false;
				}
				if($prefF!='m' and $pref =='m') 
				{
					$reqsex = mysql_query("SELECT gender FROM user_table where username='".$uName."'");
					while($rows = mysql_fetch_array($reqsex))
					{
						$prefsex=$rows['gender'];
					}
					if($prefsex==$genP)
					{
						$prefCondition=true;
					}
					else
						$prefCondition=false;
				}
                                
                              
				if($srcCondition and $destCondition and $timeCondition and $prefCondition)
					echo "match found";
			}
		?>		
	</div>
        <div id="templatemo_sidebar">
        	<div class="sidebar_box">
		<div class="df_box">
			<h2>Contact Information</h2>			
		</div>			
	</div>
    </div>
        
    <div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
        Copyright © 2010 <a href="#">Dre@dLorDs</a> | 
        Designed by <a href="#" target="_parent">Drow Ranger and BloodSeeker</a> 
    
    </div> <!-- end of templatemo_footer -->
    <div id="purry" style="display:none"><?php echo $logErr; echo $sentFlag; ?></div>
    </div>
</div>

</body>
</html>
