/*
 *	1. Detect if browser is Opera and ignore animate.enhanced plugin if necesarry
 *	2. Generate the background objects
 *	3. Animate the background objects
 *	4. Align the content to the middle of the screen
 *	5. Generate the countdown
 *	6. Show the countdown
 *	7. Toggle the social icons and show the newsletter box
 */
$(document)
	.ready(function () {

	//1. Detect if browser is Opera and ignore animate.enhanced plugin if necesarry
	killOpera();
	
	//1,5. Make background slider
	if(useSlideShow == true) {
		$('#slider').css({display:'block'}).maximage();
	}
	
	//2. Generate the background objects
	repaint();

	//3. Animate the background objects
	$('.bokeh')
		.each(function () {
		animateDiv($(this));
	});

	//4. Align the content to the middle of the screen
	$('.vAlign')
		.vAlign();

	//5. Generate the countdown
	countDown();

	//6. Show the countdown
	showCountDown();

	//7. Toggle the social icons and show the newsletter box
	$.when(toggleSocialItems('up'))
		.done(function () {
		$('.social')
			.find('li')
			.hover(function () {
			$(this)
				.stop()
				.animate({
				opacity: '1'
			}, 500);
		}, function () {
			$(this)
				.stop()
				.animate({
				opacity: '0.5'
			}, 500);
		});
		$('.input')
			.animate({
			width: '240px',
			opacity: '1'
		}, function () {
			$('.send')
				.animate({
				opacity: '0.5'
			});
		});
	});

	//Override the original submit function and replace it with ajax
	$('#newsletter')
		.submit(function () {
		//check the form is not currently submitting
		if ($(this)
			.data('formstatus') !== 'submitting') {

			//setup variables
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'),
				responseMsg = $('.resPonse');

			//add status data to form
			form.data('formstatus', 'submitting');

			//show response message - waiting
			responseMsg.hide()
				.addClass('response-waiting')
				.text('Please Wait...')
				.fadeIn(200);

			//send data to server for validation
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success: function (data) {
					//setup variables
					var responseData = jQuery.parseJSON(data),
						klass = '';

					//response conditional
					switch (responseData.status) {
						case 'error':
							klass = 'response-error';
							break;
						case 'success':
							klass = 'response-success';
							break;
					}
					if (responseData.message == "OK") {
						responseMsg.fadeOut(400, function () {
							$('.input')
								.fadeOut(400, function () {
								responseMsg.css({
									marginTop: "10px"
								});
								responseMsg.removeClass('response-waiting')
									.addClass(klass)
									.text(responseMessage)
									.fadeIn(400);
							});
						});
					}
					else {
						//show reponse message
						responseMsg.fadeOut(400, function () {
							$(this)
								.removeClass('response-waiting')
								.addClass(klass)
								.text(responseData.message)
								.fadeIn(400, function () {
								//set timeout to hide response message
								setTimeout(function () {
									responseMsg.fadeOut(400, function () {
										$(this)
											.removeClass(klass);
										form.data('formstatus', 'idle');
									});
								}, 3000)
							});
						});
					}
				}
			});
		}

		return false;
	});

	//Function for animate the input box
	$('input')
		.focus(function () {
		$('.send')
			.stop()
			.animate({
			opacity: '1'
		}, 500);
	});
	$('input')
		.focusout(function () {
		$('.send')
			.stop()
			.animate({
			opacity: '0.5'
		}, 500);
	});
});

//Handle the window resize event
$(window)
	.resize(function () {
	//Realign content to middle on resize
	$('.vAlign')
		.vAlign();
	var slideArray = $('#background').find('img');
	slideArray.each(function(index, element) {
        $(this).resizeToParent();
    });
});

//Detect if browser is Opera and ignore animate.enhanced plugin if necesarry
function killOpera() {
	if ($.browser.opera) {
		console.log("Until jquery.enhanced plugin is not fixed for opera, we will ignore it :)");
	}
	else {
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = "js/jquery.animate-enhanced.min.js";
		$("body")
			.append(script);
	}
}

//Generate the background objects
function repaint() {

	var numberOfBokehs;
	if (autoCircleCount == true) {
		var wW = $(window)
			.width();
		if (wW > 1200) {
			numberOfBokehs = circleCount__1200;
		}
		else if (wW <= 1200 && wW > 900) {
			numberOfBokehs = circleCount_1200_900;
		}
		else if (wW <= 900 && wW > 720) {
			numberOfBokehs = circleCount_900_720;
		}
		else if (wW <= 720 && wW > 420) {
			numberOfBokehs = circleCount_720_420;
		}
		else if (wW <= 420) {
			numberOfBokehs = circleCount_420_;
		}
	}
	else {
		numberOfBokehs = num;
	}
	var bokehMinSize = minsize;
	var bokehMaxSize = maxsize;
	var orbColour = color;

	for (var i = 0; i < numberOfBokehs; i++) {

		var bokehSize = randomXToY(bokehMinSize, bokehMaxSize);

		if (useRandomColours) {
			var bokehColour = randomColour();
		}
		else {
			var bokehColour = orbColour;
		}

		var bokeh = $("<div />")
			.addClass("bokeh")
			.css({
			'left': Math.floor(Math.random() * ($(window)
				.width() - maxsize)) + 'px',
			'top': Math.floor(Math.random() * ($(window)
				.height() - maxsize)) + 'px',
			'width': bokehSize + 'px',
			'height': bokehSize + 'px',
			'-moz-border-radius': Math.floor(bokehSize) / 2 + 'px',
			'-webkit-border-radius': Math.floor(bokehSize) / 2 + 'px',
			'border-radius': Math.floor(bokehSize) / 2 + 'px',
			'border': '1px solid rgba(' + bokehColour + ',' + randomOpacity() + ')',
			'-moz-box-shadow': '1px 1px 10px 1px rgba(' + bokehColour + ',0.1)',
			'-webkit-box-shadow': '1px 1px 10px 1px rgba(' + bokehColour + ',0.1)',
			'box-shadow': '1px 1px 10px 1px rgba(' + bokehColour + ',0.1)'
		});

		if (useGradients) {
			bokeh.css({
				// Gradients for Firefox
				'background': '-moz-radial-gradient( contain, rgba(' + bokehColour + ',' + randomOpacity() + '), rgba(' + bokehColour + ',' + randomOpacity() + '))',
				// Freaking ugly workaround to make gradients work for Safari too, by applying it to the background-image
				'background-image': '-webkit-gradient(radial, center center, 0, center center, 70.5, from(rgba(' + bokehColour + ',' + randomOpacity() + ')), to(rgba(' + bokehColour + ',' + randomOpacity() + ')))'
			});
		}
		else {
			bokeh.css({
				'background': 'rgba(' + bokehColour + ',' + randomOpacity() + ')'
			});
		}

		// Append to container
		bokeh.appendTo("#background");
	}
}

function randomXToY(minVal, maxVal, floatVal) {
	var randVal = minVal + (Math.random() * (maxVal - minVal));
	return typeof floatVal == 'undefined' ? Math.round(randVal) : randVal.toFixed(floatVal);
}

//Generate random color
function randomColour() {
	var rint = Math.round(0xffffff * Math.random());
	return (rint >> 16) + ',' + (rint >> 8 & 255) + ',' + (rint & 255);
}

//Generate random opacity
function randomOpacity() {
	var opacity = Math.floor(Math.random() * 6) + 1;
	return 0 + '.' + opacity;
}

//Calculate new position
function makeNewPosition() {
	// Get viewport dimensions (remove the dimension of the div)
	var h = $(window)
		.height() - maxsize;
	var w = $(window)
		.width() - maxsize;
	var nh = Math.floor(Math.random() * h);
	var nw = Math.floor(Math.random() * w);
	return [nh, nw];
}

//Animate object
function animateDiv(object) {
	var newq = makeNewPosition();
	var oldq = object.offset();
	var speed = calcSpeed([oldq.top, oldq.left], newq);
	object.animate({
		top: newq[0],
		left: newq[1],
		opacity: randomOpacity()
	}, speed, function () {
		animateDiv(object);
	});
};

//Calculate speed
function calcSpeed(prev, next) {
	var x = Math.abs(prev[1] - next[1]);
	var y = Math.abs(prev[0] - next[0]);
	var greatest = x > y ? x : y;
	var speedModifier = 0.03;
	var speed = Math.ceil(greatest / speedModifier);
	return speed;
}

//Show the countdown
function showCountDown() {
	$('.days')
		.animate({
		opacity: '1'
	}, 700, function () {
		$('.hours')
			.animate({
			opacity: '1'
		}, 700, function () {
			$('.mins')
				.animate({
				opacity: '1'
			}, 700, function () {
				$('.secs')
					.animate({
					opacity: '1'
				}, 700);
			});
		});
	});
}

//Generate countdown
function countDown() {
	
	var goal = new Date(date);
	var now = new Date();
	var count = goal.getTime() - now.getTime();
	var count = goal.getTime() - now.getTime();
	var sign = count / Math.abs(count);
	count = Math.abs(count);
	var days = Math.floor(count / (24 * 60 * 60 * 1000));
	count -= days * 24 * 60 * 60 * 1000;
	var hours = Math.floor(count / (60 * 60 * 1000));
	count -= hours * 60 * 60 * 1000;
	var minutes = Math.floor(count / (60 * 1000));
	count -= minutes * 60 * 1000;
	var secs = Math.floor(count / 1000);
	
	if(days != $('.days').find('.vAlign').find('.title').html())
	{
		if($('.days').find('.vAlign').find('.title').html() == "00")
		{
			$('.days').find('.vAlign').find('.title').html(days);
		}
		else
		{
			$('.days').find('.vAlign').find('.title').animate({opacity:'0'}, 500, function(){
				$(this).html(days)
					.animate({opacity:'1'},200);
			});
		}
	}
	else
	{
		$('.days').find('.vAlign').find('.title').html(days);
	}
	
	if(hours != $('.hours').find('.vAlign').find('.title').html())
	{
		if($('.hours').find('.vAlign').find('.title').html() == "00")
		{
			$('.hours').find('.vAlign').find('.title').html(hours);
		}
		else
		{
			$('.hours').find('.vAlign').find('.title').animate({opacity:'0'}, 500, function(){
				$(this).html(hours)
					.animate({opacity:'1'},200);
			});
		}
	}
	else
	{
		$('.hours').find('.vAlign').find('.title').html(hours);
	}
	
	if(minutes != $('.mins').find('.vAlign').find('.title').html())
	{
		if($('.mins').find('.vAlign').find('.title').html() == "00")
		{
			$('.mins').find('.vAlign').find('.title').html(minutes);
		}
		else
		{
			$('.mins').find('.vAlign').find('.title').animate({opacity:'0'}, 500, function(){
				$(this).html(minutes)
					.animate({opacity:'1'},200);
			});
		}
	}
	else
	{
		$('.mins').find('.vAlign').find('.title').html(minutes);
	}
	
	if(secs != $('.secs').find('.vAlign').find('.title').html())
	{
		if($('.secs').find('.vAlign').find('.title').html() == "00")
		{
			$('.secs').find('.vAlign').find('.title').html(secs);
		}
		else
		{
			$('.secs').find('.vAlign').find('.title').animate({opacity:'0'}, 500, function(){
				$(this).html(secs)
					.animate({opacity:'1'},200);
			});
		}
	}
	else
	{
		$('.secs').find('.vAlign').find('.title').html(secs);
	}

	setTimeout(function () {
		countDown();
	}, 1000);
}

//Show/hide social items
function toggleSocialItems(dir) {
	return $.Deferred(

	function (dfd) {
		var totalItems = $('.social')
			.find('li')
			.length;
		$('.social')
			.find('li')
			.each(function (i) {
			var $el_title = $(this),
				bottom, opacity, easing;
			if (dir === 'up') {
				bottom = '0px';
				opacity = 0.5;
				easing = 'easeOutBack';
			}
			else if (dir === 'down') {
				bottom = '-100px';
				opacity = 0;
				easing = 'easeInBack';
			}
			$el_title.stop()
				.animate({
				bottom: bottom,
				opacity: opacity,
				avoidCSSTransitions: true
			}, 200 + i * 200, easing, function () {
				if (i === totalItems - 1) dfd.resolve();
			});
		});
	})
		.promise();
}