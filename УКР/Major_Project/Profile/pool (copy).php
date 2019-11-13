<?php include("../Common/login.php"); ?>
<?php if(!isset($_SESSION['user'])) header('Location: /Major_Project/Home/index.php?f=5'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart Ride</title>
	<?php include("../Common/common_head.php"); ?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
	<script src="jquery.paginate.js" type="text/javascript"></script>
	<script src="maps.js" type="text/javascript"></script>	
	<script type="text/javascript">
	$(document).ready(function() {
		var purrFlag = $('#purry').html()
		if(purrFlag!="")
		{
			var notice='';
			if(purrFlag=="1")
			{
				notice = '<div class="notice">'
						  + '<div class="notice-body">' 
							  + '<img src="/Major_Project/Common/purr/info.png" alt="" />'
							  + '<h3>Tour Added</h3>'
							  + '<p>Your Tour has been Registered Successfully</p>'
						  + '</div>'
						  + '<div class="notice-bottom">'
						  + '</div>'
					  + '</div>';
			}
			$( notice ).purr({usingTransparentPNG: true});
			return false;
		}
	});
		$(function() {		
			var cnt = $('#junktemp').html();			
			$("#demo5").paginate({
				count			: cnt,
				start			: cnt,
				display			: 10,
				border			: false,
				text_color  		: '#345',
				background_color	: '#D4D0CF',	
				text_hover_color	: '#000',
				background_hover_color	: '#CFCFCF', 
				onChange: function(page){
							$('._current','#paginationdemo').removeClass('_current').hide();
							$('#p'+page).addClass('_current').show();
							calcRoute($('#s'+page).html(),$('#w1'+page).html(),$('#w2'+page).html(),$('#w3'+page).html(),$('#d'+page).html());
				}
			});
		});
	</script>
	<script type="text/javascript">
	function hide() 
	{
		document.getElementById('templatemo_body_wrapper').parentNode.childNodes[4].style.display='None';
		var i=0;
		var cnt = $('#junktemp').html();
		for(i=1;i<=cnt;i++)
		{
			var offset = document.getElementById('changeJava'+i).innerHTML.substr(-2);
			var textinp = document.getElementById('changeJava'+i).innerHTML.substr(0,document.getElementById('changeJava'+i).innerHTML.length-2)+"000";
			var datum = new Date(textinp*1);
			document.getElementById('changeJava'+i).innerHTML = datum.toLocaleString().substr(0,datum.toLocaleString().length-15)+" +/- "+offset+" Mins";
		}
		calcRoute($('#s'+cnt).html(),$('#w1'+cnt).html(),$('#w2'+cnt).html(),$('#w3'+cnt).html(),$('#d'+cnt).html());
	}	
	</script>	
</head>
<body onload="hide()"><!--The Style if for screen not to move  due to unknown reason -->
<?php	
	$con = mysql_connect("localhost","root","qwe123");
	if (!$con)
	{
		$flag = 'Could not connect: ' . mysql_error();
	}
	mysql_select_db("db", $con);
	
	
	$result = mysql_query("SELECT * FROM tours where userName='".$_SESSION['user']."'");
	$rowCheck = mysql_num_rows($result); 
	mysql_close($con);
?>
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
	<?php include("../Common/common_body.php"); ?>
	
    <div id="templatmeo_main">
    	<div id="templatemo_content"><span class="bottom"></span>		
		<h2>Pool Information</h2>
		<hr style="border:solid 5px #310902" /><br />
		<div id="paginationdemo" class="demo">
		<?php
			echo "<div id='junktemp' style='display:none' >".$rowCheck."</div>";
			$count=1;
			if($rowCheck==0)
				echo "<div style=\"text-align:center;font-size:15px;color:green\" ><b>No Tours Have been Added!!</b></div>"; 
			else
			{
				$temp="_current";
				$st="";
				while($row = mysql_fetch_array($result))
				{
					$role="";
					$pref="";
					$prefm="";
					if($row['who']=="g")
						$role="Ride Giver";
					else
						$role="Ride Seeker";
					if($row['pref']=="a")
						$pref="Site Decides";
					else
					{
						$pref="Given Below";
						$gen="";
						if($row['manualGender']=="n")
						{
							$gen="Not Particular";
						}
						else if($row['manualGender']=="f")
						{
							$gen="Female";
						}
						else
						{
							$gen="Male";
						}
						$prefm="<tr><td>&nbsp;</td></tr>
							<tr>
								<td>Prefered Gender</td>
								<td>".$gen."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>Prefered Age</td>
								<td>".substr($row['manualAge'],0,2)." To ".substr($row['manualAge'],3)."</td>
						  	</tr>
							";
					}
					echo "<div id='p".$count."' class='pagedemo ".$temp."' style='font-size:15px;".$st."' >
<div style='display:none' id='s".$count."'>".$row['sourceN']."</div>
<div style='display:none' id='w1".$count."'>".$row['wap1N']."</div>
<div style='display:none' id='w2".$count."'>".$row['wap2N']."</div>
<div style='display:none' id='w3".$count."'>".$row['wap3N']."</div>
<div style='display:none' id='d".$count."'>".$row['destN']."</div>
						<center><table width=70%>
							<tr>
								<td width='25%'>Date</td>
								<td id='changeJava".$count."'>".$row['startGlobal'].$row['offSet']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>	
						  	<tr>
								<td>Role</td>
								<td>".$role."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>	
						  	<tr>
								<td>Source</td>
								<td>".$row['sourceN']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>WayPoint 1</td>
								<td>".$row['wap1N']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>WayPoint 2</td>
								<td>".$row['wap2N']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>WayPoint 3</td>
								<td>".$row['wap3N']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>Destination</td>
								<td>".$row['destN']."</td>
						  	</tr>
							<tr><td>&nbsp;</td></tr>	
						  	<tr>
								<td>Preferences</td>
								<td>".$pref."</td>
						  	</tr>".$prefm."<tr><td>&nbsp;</td></tr>
						</table><a id='fs".$count."' href='findshare.php?id=".$row['id']."'>Find Route Sharers =></a></center>						
					</div>";	
					$count=$count+1;
					$temp='';
					$st="display:none;";
				}
			}
		?>
		</div><br />
		<hr style="border:solid 5px #310902" />
		<?php if($rowCheck!=0) echo "<br /><div style='margin-left:125px' id='demo5'></div>"; ?>
	</div>
        <div id="templatemo_sidebar">        	
		<br /><br />
		<?php if($rowCheck!=0) echo "<h2 style='border-bottom:none'>Your Tour</h2>		
		<div style='border:solid #5177E8 3px;width:450px; height:400px;' id='map_canvas'></div>"; ?>
    	</div>
        
    <div class="cleaner"></div>
    </div>
    
    <div id="templatemo_footer">
    
        Copyright © 2010 <a href="#">Dre@dLorDs</a> | 
        Designed by <a href="#" target="_parent">Drow Ranger and BloodSeeker</a> 
    
    </div> <!-- end of templatemo_footer -->
    <div id="purry" style="display:none"><?php if(isset($_GET['f'])) echo $_GET['f'];?></div>
    </div>
</div>

</body>
</html>
