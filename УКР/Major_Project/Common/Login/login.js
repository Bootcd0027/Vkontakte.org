$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight,"opacity": "0.7"});
		
		//transition effect		
		$('#mask').fadeIn("slow");	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(1000);
	
	});
	
	//if mask is clicked
	$('#mask').click(function () {
		$('.window').fadeOut("slow");
		$(this).fadeOut("slow");		
	});
	//Login
	$('.d-login').click(function () {
		if($('#ip1').val()!='' && $('#ip2').val()!='')
		{
			$('.window').fadeOut("slow");
			$('#mask').fadeOut("slow");
			setTimeout("document.loginform.submit();",800);
		}
	});			
	
});
