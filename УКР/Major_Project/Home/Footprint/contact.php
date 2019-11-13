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

			<br/>
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' onclick='calculateExpense()' value='Calculate Cost' >Calculate</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close'>Cancel</button>
			<br/>
		</form>
			<div style='position:relative;left:50px;bottom:-2px;'>
				<b style='color:green;'>Effect on environment</b><br>
	    			<b>Amount of green house gases released/month: <span class='costM'>84 Kgs</span></b><br>
		    		<b>Amount of green house gases released/year: <span class='costY'>1.008 Tonnes</span> </b>
				<div style='margin-top:10px;'><b style='color:green;'>Reduction in emissions with pooling</b></div>
				<div>On an average a regular carpool reduces carbon emissions by<br />about 3 tonnes annually!!</div>
			</div>			
	</div>
	<div class='contact-bottom'></div>
</div>";

	echo $output;
}
?>
