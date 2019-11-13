$(function() {
	/*
	number of fieldsets
	*/
	var fieldsetCount = $('#formElem').children().length;
	
	/*
	current position of fieldset / navigation link
	*/
	var current 	= 1;
    
	/*
	sum and save the widths of each one of the fieldsets
	set the final sum as the total width of the steps element
	*/
	var stepsWidth	= 0;
    var widths 		= new Array();
	$('#steps .step').each(function(i){
        var $step 		= $(this);
		widths[i]  		= stepsWidth;
        stepsWidth	 	+= $step.width();
    });
	$('#steps').width(stepsWidth);
	
	/*
	to avoid problems in IE, focus the first input of the form
	*/
	$('#formElem').children(':first').find(':input:first').focus();	
	
	/*
	show the navigation bar
	*/
	$('#navigation').show();
	
	/*
	when clicking on a navigation link 
	the form slides to the corresponding fieldset
	*/
    $('#navigation a').bind('click',function(e){
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('selected');
        $this.parent().addClass('selected');
		/*
		we store the position of the link
		in the current variable	
		*/
		current = $this.parent().index() + 1;
		/*
		animate / slide to the next or to the corresponding
		fieldset. The order of the links in the navigation
		is the order of the fieldsets.
		Also, after sliding, we trigger the focus on the first 
		input element of the new fieldset
		If we clicked on the last link (confirmation), then we validate
		all the fieldsets, otherwise we validate the previous one
		before the form slided
		*/
        $('#steps').stop().animate({
            marginLeft: '-' + widths[current-1] + 'px'
        },500,function(){
			if(current == fieldsetCount)
				validateSteps();
			else
				validateStep(prev);
			$('#formElem').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
		});
        e.preventDefault();
    });
	
	/*
	clicking on the tab (on the last input of each fieldset), makes the form
	slide to the next step
	*/
	$('#formElem > fieldset').each(function(){
		var $fieldset = $(this);
		$fieldset.children(':last').find(':input').keydown(function(e){
			if (e.which == 9){
				$('#navigation li:nth-child(' + (parseInt(current)+1) + ') a').click();
				/* force the blur for validation */
				$(this).blur();
				e.preventDefault();
			}
		});
	});
	
	/*
	validates errors on all the fieldsets
	records if the Form has errors in $('#formElem').data()
	*/
	function validateSteps(){
		var FormErrors = false;
		for(var i = 1; i < fieldsetCount; ++i){
			var error = validateStep(i);
			if(error == -1)
				FormErrors = true;
		}
		$('#formElem').data('errors',FormErrors);	
	}
	
	/*
	validates one fieldset
	and returns -1 if errors found, or 1 if not
	*/
	function validateStep(step){
		if(step == fieldsetCount) return;
		var error = 1;
		var hasError = false;		
		var ii=0;
		$('#formElem').children(':nth-child('+ parseInt(step) +')').find(':input:not(button)').each(function(){
			var $this 		= $(this);
			var flag=0;
			if(step==1)
			{
				ii+=1;
				if(ii==1)
				{
					var str=$this.val();	
					var lstr=str.length
					if(lstr<6)
						flag=1;
				}
				else if(ii==3)
				{
					var str=$this.val();
					var at="@"
					var dot="."
					var lat=str.indexOf(at)
					var lstr=str.length
					var ldot=str.indexOf(dot)
					if (str.indexOf(at)==-1){			   
					   flag=1;
					}
					if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){			   
					   flag=1;
					}

					if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr-1){			    
					    flag=1;
					}

					 if (str.indexOf(at,(lat+1))!=-1){			    
					    flag=1;
					 }

					 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){			    
					    flag=1;
					 }

					 if (str.indexOf(dot,(lat+2))==-1){			    
					    flag=1;
					 }
		
					 if (str.indexOf(" ")!=-1){			    
					    flag=1;
					 }
				}			
				else if(ii==3)
				{
					var str=$this.val();	
					var lstr=str.length
					if(lstr<6)
						flag=1;
					ii=0;
				}
			}
			else if(step==2)
			{
				ii+=1;
				if(ii==4)
				{	var nowY = new Date().getFullYear();
					var str=$this.val();
					var dat=Number(str.substring(0,2));					
					var mon=Number(str.substring(3,5));
					var yer=Number(str.substring(6,10));
					if(dat>31 || mon>12 || yer>nowY)
					{
						flag=1;
					}
					if(dat.toString()=='NaN' || mon.toString()=='NaN' || yer.toString()=='NaN' )
						flag=1;
					if(str.substring(0,2).length!=2 || str.substring(3,5).length!=2 || str.substring(6,10).length!=4)
						flag=1;
					if(str.charAt(2)!='-' || str.charAt(5)!='-')
						flag=1;
				}
				else if(ii==6)
				{
					var str=$this.val();
					var lstr=str.length;
					if(lstr!=10)
						flag=1;
					ii=0;
				}
			}
			else if(step==4)
			{
				if($('input:checkbox').is(':checked')==false)
					flag=1;
			}
			var valueLength = jQuery.trim($this.val()).length;	
			if(valueLength == '' || flag == 1)
			{
				hasError = true;
				$this.css('background-color','#FFEDEF');
			}
			else
				$this.css('background-color','#FFFFFF');
		});
		var $link = $('#navigation li:nth-child(' + parseInt(step) + ') a');
		$link.parent().find('.error,.checked').remove();
		
		var valclass = 'checked';
		if(hasError){
			error = -1;
			valclass = 'error';
		}
		$('<span class="'+valclass+'"></span>').insertAfter($link);
		
		return error;
	}
	
	/*
	if there are errors don't allow the user to submit
	*/
	$('#registerButton').bind('click',function(){
		if($('#formElem').data('errors') || $('.resultCap').html()!=1){
			var errorCustom='';
			if($('#formElem').data('errors'))
				errorCustom= 'Please correct the errors in the Form'
			if($('.resultCap').html()!=1)
				errorCustom +=' Re-Check Captcha';
			alert(errorCustom);
			return false;
		}
	});
});
