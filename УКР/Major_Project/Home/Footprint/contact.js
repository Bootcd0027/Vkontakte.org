/*
 * SimpleModal Contact Form
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: contact.js 243 2010-03-15 14:23:14Z emartin24 $
 *
 */
jQuery(function ($) {
	var contact = {
		message: null,
		init: function () {
			$('#contact-form input.contact2, #contact-form a.contact2').click(function (e) {
				e.preventDefault();

				// load the contact form using ajax
				$.get("Footprint/contact.php", function(data){
					// create a modal dialog with the data
					$(data).modal({
						closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
						position: ["15%",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onShow: contact.show,
						onClose: contact.close
					});
				});
			});
		},
		open: function (dialog) {
			// add padding to the buttons in firefox/mozilla
			if ($.browser.mozilla) {
				$('#contact-container .contact-button').css({
					'padding-bottom': '2px'
				});
			}
			// input field font size
			if ($.browser.safari) {
				$('#contact-container .contact-input').css({
					'font-size': '.9em'
				});
			}

			// dynamically determine height
			var h = 370;			
			var title = $('#contact-container .contact-title').html();
			$('#contact-container .contact-title').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container .contact-content').animate({
							height: h
						}, function () {
							$('#contact-container .contact-title').html(title);
							$('#contact-container form').fadeIn(200, function () {
								$('#contact-container #kmsDay').focus();

					/*	for overlay close	$('#contact-container .contact-cc').click(function () {
									var cc = $('#contact-container #contact-cc');
									cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
								});*/

								// fix png's for IE 6
								if ($.browser.msie && $.browser.version < 7) {
									$('#contact-container .contact-button').each(function () {
										if ($(this).css('backgroundImage').match(/^url[("']+(.*\.png)[)"']+$/i)) {
											var src = RegExp.$1;
											$(this).css({
												backgroundImage: 'none',
												filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +  src + '", sizingMethod="crop")'
											});
										}
									});
								}
							});
						});
					});
				});
			});
		},				
		show: function (dialog) {			
			$('#contact-container .contact-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
			 		function isPetrol() {
						if ($("input[name='fuelType']:checked").val()=='petrol') {
							return true;
						}
						return false;
					}
					function calculateExpense() {
						var maintenanceCost = $('#contact-container #maintenanceCost').val();	
						var mileage = $('#contact-container #mileage').val();
						var noOfDays = $('#contact-container #noOfDays').val();
						var kmsDay = $('#contact-container #kmsDay').val();
						var noOfLitres = (kmsDay / mileage) * noOfDays;
						var carbon = noOfLitres * (isPetrol() ? 2.3 : 2.7);
						carbon = Math.round(carbon);
						$('#contact-container .costM').html(carbon+' Kgs');
						$('#contact-container .costY').html(carbon * 12 * .001 + ' Tonnes');
						if (isCar()) 
						{
						}
					}
					calculateExpense();
				}
				else 
				{
					$('#contact-container .contact-message').animate({
					height: '30px'
					}, contact.showError);										
				}
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html('Goodbye...');
			$('#contact-container form').fadeOut(200);
			$('#contact-container .contact-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		validate: function () {
			var flag=0;
			contact.message = '';
			if (!$('#contact-container #kmsDay').val()) {
				flag=1;
				contact.message += 'Km/Day. ';
			}
			if (!$('#contact-container #noOfDays').val()) {
				flag=1;
				contact.message += 'Working Days/Month. ';
			}
			if (!$('#contact-container #mileage').val()) {
				flag=1;
				contact.message += 'Milege. ';
			}				
			if (flag == 1){
				contact.message =  'Please Enter ' + contact.message;
			}
				
			if (contact.message.length > 0) {
				return false;
			}
			else {
				return true;
			}			
		},		
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(200);
		}
	};

	contact.init();

});
