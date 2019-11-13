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
			$tokcount=0;
			$maxage="";
			$minage="";
			$prefagetoken = strtok($ageP,' ');
			while ($prefagetoken != false)
			{
		               if($tokcount==0)
		                    	$minage=$prefagetoken;
		               else
			              	$maxage=$prefagetoken;
			       $prefagetoken = strtok(" ");
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
	<script src="jquery1.paginate.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
	<script type="text/javascript">
		$(function() {		
			var cnt = $('#junktemp').html();		
			$("#demo5").paginate({
				count			: cnt,
				start			: 1,
				display			: 5,
				border			: false,
				text_color  		: '#345',
				background_color	: '#D4D0CF',	
				text_hover_color	: '#000',
				background_hover_color	: '#CFCFCF', 
				onChange: function(page){
					$('._current','#paginationdemo').removeClass('_current').hide();
					$('#p'+page).addClass('_current').show();				
				}
			});
		});
	</script>
	<script type="text/javascript">
	function hide() {
			document.getElementById('templatemo_body_wrapper').parentNode.childNodes[4].style.display='None';
			var cnt = document.getElementById('junktemp').innerHTML;
			var i=1;
			for(i=1;i<=cnt;i++)
			{
				var offset = document.getElementById('chTime'+i).innerHTML.substr(-2);
				var textinp = document.getElementById('chTime'+i).innerHTML.substr(0,document.getElementById('chTime'+i).innerHTML.length-2)+"000";
				var datum = new Date(textinp*1);
				document.getElementById('chTime'+i).innerHTML = datum.toLocaleString().substr(0,datum.toLocaleString().length-15)+" +/- "+offset+" Mins";
			}
		}
	</script>	
</head>
<body style="position:relative;margin-left:-15px" onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<div id="templatemo_body_wrapper">

<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>

    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>
		<div id="paginationdemo" class="demo">
		<?php
			$i=1;
			$found=0;
			$result = mysql_query("SELECT * FROM tours where userName!='".$uName."' and who!='".$who."' and sharer is NULL");
			$temp="_current";
			$st="";
			while($row = mysql_fetch_array($result))
			{
				$uNameF =$row['userName'];
				$idF = $row['id'];
				$srcF = $row['source'];
				$wp1F = $row['wayp1'];
				$wp2F = $row['wayp2'];
				$wp3F = $row['wayp3'];
				$destF = $row['dest'];

				$srcNF = $row['sourceN'];
				$wp1NF = $row['wap1N'];
				$wp2NF = $row['wap2N'];
				$wp3NF = $row['wap3N'];
				$destNF = $row['destN'];

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
				$tokcountF=0;
				$maxageF="";
				$minageF="";
				$prefagetokenF = strtok($agePF,' ');
				while ($prefagetokenF != false)
				{
		                       	if($tokcountF==0)
		                       		$minageF=$prefagetokenF;
		                       	else
			               		$maxageF=$prefagetokenF;
				  	$prefagetokenF = strtok(" ");
		                       	$tokcountF=$tokcountF+1;
				}
				
//				echo $stlat." ".$stlng." ".$dtlat." ".$dtlng." ".$stlatF." ".$stlngF." ".$dtlatF." ".$dtlngF."<br /><br />";
				$srcCondition = ($stlatF-$stlat)*($stlatF-$stlat) + ($stlngF-$stlng)*($stlngF-$stlng) < 0.000009;
				$destCondition = ($dtlatF-$dtlat)*($dtlatF-$dtlat) + ($dtlngF-$dtlng)*($dtlngF-$dtlng) < 0.000009;
				$timeCondition = abs(($secTF/60)-($secT/60)) < min($givenOff, $givenOffF);
				$prefCondition=true;
				$Yresult=mysql_query("SELECT * FROM user_table where username='".$uName."'");
				while($rows = mysql_fetch_array($Yresult))
				{
					$year = substr($rows['dob'],6,4);
					$sex=$rows['gender'];
				}
				$YresultF=mysql_query("SELECT * FROM user_table where username='".$uNameF."'");
				while($rows = mysql_fetch_array($YresultF))
				{
					$yearF = substr($rows['dob'],6,4);
					$sexF=$rows['gender'];
					$phF=$rows['phNum'];
					$emailF=$rows['email'];
				}
				$curYear = date('Y');
				$age=$curYear-$year;
				$ageF=$curYear-$yearF;
				if($prefF=='m' and $pref!='m') 
				{
					if($sex==$genPF )
					{
						if($minageF < $age and $age < $maxageF)
 							$prefCondition = true;
					}
					else
						$prefCondition=false;
 				}
                                if($prefF=='m' and $pref =='m') 
				{
					if($genPF==$sex and $sexF=$genP)
					{
						if(($minageF < $age and $age < $maxageF) and ($minage < $ageF and $ageF < $maxage))
							$prefCondition=true;
					}
					else
						$prefCondition=false;
				}
				if($prefF!='m' and $pref =='m') 
				{
					if($sexF==$genP)
					{
						if($minage < $ageF and $ageF < $maxage)
							$prefCondition=true;
					}
					else
						$prefCondition=false;
				}                                                              
				if($srcCondition and $destCondition and $timeCondition and $prefCondition)
				{
					echo "<div id='p".$i."' class='pagedemo ".$temp."' style='font-size:15px;".$st."' >
					<span style='font-size:15px;color:orange'>Option ".$i."</span>
					<center><table width='70%'>
						<tr>
							<td width='25%'>User Name</td>
							<td>".$uNameF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>	
					  	<tr>
							<td>Gender</td>
							<td>".$sexF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>	
					  	<tr>
							<td>Age</td>
							<td>".$ageF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Phone Number</td>
							<td>".$phF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>E-mail iD</td>
							<td>".$emailF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Start Time</td>
							<td id='chTime".$i."'>".$secTF.$givenOffF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Source</td>
							<td >".$srcNF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Waypoint 1</td>
							<td >".$wp1NF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Waypoint 2</td>
							<td >".$wp2NF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Waypoint 3</td>
							<td >".$wp3NF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Destination</td>
							<td >".$destNF."</td>
					  	</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<form action='finalize.php' method='POST'>
						<input style='display:none' type='text' name='ids' value='".$id." ".$idF."' />
						<input style='display:none' type='text' name='uns' value='".$uName." ".$uNameF."' />
						<input style='display:none' type='text' name='emPh' value='".$emailF." ".$phF."' />
						<input type='submit' value='Share with this Person' />
					</form><hr style='border:solid 5px #310902' /></center></div>
					\n";
					$found=1;
					$i = $i + 1;
					$temp="";
					$st="display:none;";
				}

			}
			if($found!=1) echo "<div style='text-align:center;color:red;font-size:20px'>Sorry!! No Results Found</div>";
			else echo "<div style='margin-left:200px' id='demo5'></div>";
		?>
		<?php echo "<div id='junktemp' style='display:none' >".($i-1)."</div>\n"; ?>
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
