<?php
// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	// Send back the contact form HTML
	$output = "
		<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Enter your travel details</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' name='calculator' style='display:none'>
			<label for='kmsDay'>Kms/day<i>(round trip):</label>
			<input type='text' id='kmsDay' class='contact-input' name='kmsDay' value='20' />

			<label for='noOfDays'>Working Days/Month:</label>
			<input type='text' id='noOfDays' class='contact-input' name='noOfDays' value='22' />

			<label for='mileage'>Kms/Litre <i>(mileage)</i>:</label>
			<input type='text' id='mileage' class='contact-input' name='mileage' value='12' />

			<label for='fuelType'>Fuel Type:</label>
			<label>Petrol</label>
		        <input class='contact-input' id='petrol' name='fuelType' type='radio' value='petrol' checked='checked' >
		        <label>Diesel</label>
		        <input class='contact-input' id='diesel' name='fuelType' type='radio' value='diesel' ></td>
			
			<label for='fuelCost' >Cost of fuel/litre: <i>(in Rs)</i></label>
			<input type='text' id='fuelCost' class='contact-input' name='fuelCost' value='57' />

			<label for='vehichleType'>Vehicle Type:</label>
			<label>Car</label>
        	        <input class='contact-input' id='carT' name='vehichleType' type='radio' value='car' checked='checked' onclick='calculateMaintenanceCost()'>
        	        <label>Bike</label>
	                <input class='contact-input' id='bikeT'name='vehichleType' type='radio' value='bike' onclick='calculateMaintenanceCost()'>

			<label for='maintenanceCost'>Maintenance cost/km : <i>(in Rs)</i>)</label>
			<input type='text' id='maintenanceCost' class='contact-input' name='maintenanceCost' value='0.625' />

			<br/>
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' onclick='calculateExpense()' value='Calculate Cost' >Calculate</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close'>Cancel</button>
			<br/>
		</form>
			<div style='position:relative;left:50px;bottom:-2px;'>
			<b style='color:green;'>Total Cost Incurred</b><br>
	    		<b>Monthly: Rs. <span class='costM'>2365</span></b><br>
		    	<b>Yearly : Rs. <span class='costY'>28380</span> </b>
			</div>

			<div style='position:relative;bottom:64px;left:250px'><b style='color:green;'>Annual Savings pooling with</b>
    			<b><span class='savingsY'><br>1 Person : Rs.14190<br> 2 People: Rs.18920</span></b></div>	
	</div>
	<div class='contact-bottom'></div>
</div>";

	echo $output;
}
?>
