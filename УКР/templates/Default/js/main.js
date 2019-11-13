﻿var uagent = navigator.userAgent.toLowerCase();
var is_safari = ((uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc."));
var is_ie = ((uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv));
var is_ie4 = ((is_ie) && (uagent.indexOf("msie 4.") != -1));
var is_moz = (navigator.product == 'Gecko');
var is_ns = ((uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari));
var is_ns4 = ((is_ns) && (parseInt(navigator.appVersion) == 4));
var is_opera = (uagent.indexOf('opera') != -1);
var is_kon = (uagent.indexOf('konqueror') != -1);
var is_webtv = (uagent.indexOf('webtv') != -1);
var is_win = ((uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") != -1));
var is_mac = ((uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc."));
var is_chrome = (uagent.match(/Chrome\/\w+\.\w+/i)); if(is_chrome == 'null' || !is_chrome || is_chrome == 0) is_chrome = '';
var ua_vers = parseInt(navigator.appVersion);
var req_href = location.href;
var vii_interval = false;
var vii_interval_im = false;
var vii_interval_photos = false;
var scrollTopForFirefox = 0;
var url_next_id = 1;
	
	var num = 30;
	var b = 0;
$(document).ready(function(){
	var mw = ($('html, body').width()-800)/2;
	if($('.autowr').css('padding-left', mw+'px').css('padding-right', mw+'px')){
		$('body').show();
		history.pushState({link:location.href}, '', location.href);
	}
	$('.update_code').click(function(){
		var rndval = new Date().getTime(); 
		$('#sec_code').html('<img src="/antibot/antibot.php?rndval=' + rndval + '" alt="" title="Показать другой код" width="120" height="50" />');
		return false;
	});
	$(window).scroll(function(){
		if($(document).scrollTop() > ($(window).height()/2))
			$('.scroll_fix_bg').fadeIn(200); 
		else 
			$('.scroll_fix_bg').fadeOut(200); 
	});
	$(window).scroll(function(){
		if($(document).scrollTop() > ($(window).height()/1))
			$('.fmenu').fadeIn(0); 
		else 
			$('.fmenu').fadeOut(0); 
	});
	while(b <= num){
		if($.cookie('g'+b))
			$('#ig'+b).addClass('no_display');
		b++;
	}
});

if(CheckRequestPhoto(req_href)){
	$(document).ready(function(){
		Photo.Show(req_href);
	});
}

if(CheckRequestVideo(req_href)){
	$(document).ready(function(){
		var video_id = req_href.split('_');
		var section = req_href.split('sec=');
		var fuser = req_href.split('wall/fuser=');

		if(fuser[1])
			var close_link = '/u'+fuser[1];
		else
			var close_link = '';
		
		if(section[1]){
			var xSection = section[1].split('/');

			if(xSection[0] == 'news')
				var close_link = 'news';

			if(xSection[0] == 'msg'){
				var msg_id = xSection[1].split('id=');
				var close_link = '/messages/show/'+msg_id[1];
			}
		}
		
		videos.show(video_id[1], req_href, close_link);
	});
}

//AJAX PAGES
window.onload = function(){ 
	window.setTimeout(
		function(){ 
			window.addEventListener(
				"popstate",  
				function(e){
					e.preventDefault(); 

					if(CheckRequestPhoto(e.state.link))
						Photo.Prev(e.state.link);
					else if(CheckRequestVideo(e.state.link))
						videos.prev(e.state.link);
					else
						Page.Prev(e.state.link);
				},  
			false); 
		}, 
	1); 
}
function CheckRequestPhoto(request){
	var pattern = new RegExp(/photo[0-9]/i);
 	return pattern.test(request);
}
function CheckRequestVideo(request){
	var pattern = new RegExp(/video[0-9]/i);
 	return pattern.test(request);
}
function onBodyResize(){
	var mw = ($('html, body').width()-800)/2;
	$('.autowr').css('padding-left', mw+'px').css('padding-right', mw+'px');
}
var supdate = 0;
function up_photos(){
	vii_interval_photos = setInterval(function(){
		if(supdate == 0){
			supdate = 1;
			$.post('/index.php?go=update_photos', function(d){
				if(d){
					supdate = 0;
					var rid = Math.floor(Math.random() * (9 - 1 + 1)) + 1;
					splt = d.split('|||');
					var check = $('#albums_photo_panel_'+splt[0]).html();
					if(!check){
						$('#ma'+rid).html('<div id="aps'+rid+'" class="no_display">'+splt[1]+'</div>');
						$('#aps'+rid).fadeIn();
					}
				}
			});
		}
	}, 4000);
}
var Page = {
	Loading: function(f){
		var top_pad = $(window).height()/2-50;
		if(f == 'start'){
			$('#loading').remove();
			$('html, body').append('<div id="loading" style="margin-top:'+top_pad+'px"><div class="loadstyle"></div></div>');
			$('#loading').show();
		}
		if(f == 'stop'){
			$('#loading').remove();
		}
	},
	Go: function(h){	
		history.pushState({link:h}, null, h);
		$('.js_titleRemove').remove();
		
		clearInterval(vii_interval);
		clearInterval(vii_interval_im);
		clearInterval(vii_interval_photos);

		
		$('#page').load(h, {ajax: 'yes'}, function(data){
			
			$('html, body').scrollTop(0);
			
			
			
			
			
			//Удаляем кеш фоток, видео, модальных окон
			$('.photo_view, .box_pos, .box_info').remove();
			
			//Возвращаем scroll
			$('html, body').css('overflow-y', 'auto');
//Возвращаем дизайн плеера
			if($('.staticPlbg').length){ $('.staticPlbg').css('margin-top', '-500px'); player.reestablish(); }


		}).css('min-height', '0px');
	},
	Prev: function(h){
		clearInterval(vii_interval);
		clearInterval(vii_interval_im);
		clearInterval(vii_interval_photos);
		
		Page.Loading('start');
		$('#page').load(h, {ajax: 'yes'}, function(data){
			Page.Loading('stop');

			$('html, body').scrollTop(0);
			
			//Чистим стили AuroResizeWall
			$('#addStyleClass').remove();
			
			$('.ladybug_ant').imgAreaSelect({remove: true});
			
			//Удаляем кеш фоток, видео, модальных окон
			$('.photo_view, .box_pos, .box_info').remove();
			
			//Возвращаем scroll
			$('html, body').css('overflow-y', 'auto');
//Возвращаем дизайн плеера
			if($('.staticPlbg').length){ $('.staticPlbg').css('margin-top', '-500px'); player.reestablish(); }


		}).css('min-height', '0px');		
	}
}

//Logout
var logout = {
box: function(){
var tmp = '<div class="miniature_box" id="logout">'+
'<div class="miniature_pos" style="width:400px;background:#fff">'+
'<div class="miniature_title fl_l apps_box_text">Выход с сайта</div><a class="cursor_pointer fl_r" onClick="$(\'#logout\').hide(); $(\'html, body\').css(\'overflow-y\', \'auto\');">Закрыть</a>'+
'<div style="border-bottom: 1px solid #DAE1E8;margin-top:20px;"></div>'+
'<div class="clear"></div>'+
'<div style="margin-left: -10px;margin-bottom: 20px"><center>Как, вы уже уходите? Так быстро?<br><br><div style="margin-left:176px;" class="button_div fl_l"><button onclick="window.location = \'/?act=logout\'">Выход</button></div></center></div></div>'+
'<div class="clear"></div>'+
'</div>'+
'<div class="clear" style="height: 0px"></div>'+
'</div>';
var check = $('#logout').length;
if(!check){
if(is_moz && !is_chrome) scrollTopForFirefox = $(window).scrollTop();
$('html, body').css('overflow-y', 'hidden');
if(is_moz && !is_chrome) $(window).scrollTop(scrollTopForFirefox);
$('body').append(tmp);
} else
$('#logout').show();
}
}

//VII BOX
var viiBox = {
	start: function(){
		Page.Loading('start');
	},
	stop: function(){
		Page.Loading('stop');
	},
	win: function(i, d, o, h){
		viiBox.stop();
		if(is_moz && !is_chrome) scrollTopForFirefox = $(window).scrollTop();
		$('html, body').css('overflow-y', 'hidden');
		if(is_moz && !is_chrome) $(window).scrollTop(scrollTopForFirefox);
		$('body').append('<div class="vii_box" id="newbox_miniature'+i+'">'+d+'</div>');
		$(window).keydown(function(event){
			if(event.keyCode == 27) 
				viiBox.clos(i, o, h);
		});
	},
	clos: function(i, o, h){
		$('#newbox_miniature'+i).remove();
		if(o) $('html, body').css('overflow-y', 'auto');
		if(h) history.pushState({link:h}, null, h);
	}
}


//PROFILE FUNC
var Profile = {
webcam:function(){
		$.post('/index.php?go=editprofile&act=webcam',function(d){
			$('html, body').css({'overflow-y':'hidden','margin':'0 17px 0 0'});
			$('body').append('<div id="newbox_miniature">'+d+'</div>');
		});
	},
miniature: function(){
		Page.Loading('start');
		$.post('/index.php?go=editprofile&act=miniature', function(d){
			Page.Loading('stop');
			if(d == 1) 
				addAllErr('Вы пока что не загрузили фотографию.');
			else {
				if(is_moz && !is_chrome) scrollTopForFirefox = $(window).scrollTop();
				$('html, body').css('overflow-y', 'hidden');
				if(is_moz && !is_chrome) $(window).scrollTop(scrollTopForFirefox);
				$('body').append('<div id="newbox_miniature">'+d+'</div>');
			}
			$(window).keydown(function(event){
				if(event.keyCode == 27) Profile.miniatureClose();
			});
		});
	},
	preview: function(img, selection){
		if(!selection.width || !selection.height) return;
		var scaleX = 100 / selection.width;
		var scaleY = 100 / selection.height;
		var scaleX50 = 50 / selection.width;
		var scaleY50 = 50 / selection.height;
		$('#miniature_crop_100 img').css({
			width: Math.round(scaleX * $('#miniature_crop').width()),
			height: Math.round(scaleY * $('#miniature_crop').height()),
			marginLeft: -Math.round(scaleX * selection.x1),
			marginTop: -Math.round(scaleY * selection.y1)
		});
		$('#miniature_crop_50 img').css({
			width: Math.round(scaleX50 * $('#miniature_crop').width()),
			height: Math.round(scaleY50 * $('#miniature_crop').height()),
			marginLeft: -Math.round(scaleX50 * selection.x1),
			marginTop: -Math.round(scaleY50 * selection.y1)
		});
	},
	miniatureSave: function(){
		var i_left = $('#mi_left').val();
		var i_top = $('#mi_top').val();
		var i_width = $('#mi_width').val();
		var i_height = $('#mi_height').val();
		butloading('miniatureSave', '111', 'disabled', '');
		$.post('/index.php?go=editprofile&act=miniature_save', {i_left: i_left, i_top: i_top, i_width: i_width, i_height: i_height}, function(d){
			if(d == 'err') addAllErr('Ошибка');
			else window.location.href = '/u'+d;
			butloading('miniatureSave', '111', 'enabled', 'Сохранить изменения');
		});
	},
	miniatureClose: function(){
		$('#miniature_crop').imgAreaSelect({remove: true});
		$('#newbox_miniature').remove();
		$('html, body').css('overflow-y', 'auto');
	},
	LoadCity: function(id){
		$('#load_mini').show();
		if(id > 0){
			$('#city').slideDown();
			$('#select_city').load('/index.php?go=loadcity', {country: id});
		} else {
			$('#city').slideUp();
			$('#load_mini').hide();
		}
	},
	//MAIN PHOTOS
	LoadPhoto: function(){
		Page.Loading('start');
		$.get('/index.php?go=editprofile&act=load_photo', function(data){
			Box.Show('photo', 400, lang_title_load_photo, data, lang_box_canсel);
			Page.Loading('stop');
		});
	},
	DelPhoto: function(){
		Box.Show('del_photo', 400, lang_title_del_photo, '<div style="padding:15px;">'+lang_del_photo+'</div>', lang_box_canсel, lang_box_yes, 'Profile.StartDelPhoto(); return false;');
	},
	StartDelPhoto: function(){
		$('#box_loading').show();
		$.get('/index.php?go=editprofile&act=del_photo', function(){
			$('#ava').html('<img src="/templates/Default/images/no_ava.gif" alt="" />');
			$('#del_pho_but').hide();
			Box.Close('del_photo');
			Page.Loading('stop');
		});
	},
	AddEffect: function(id){
		$.get('/index.php?go=editprofile&act=add_effect', {id: id}, function(d){
            if(d == 1){
                $('#save_ok').show();
                $('#no_ok').hide();
			}
            else if(d == 2){
                $('#save_ok').hide();
                $('#no_ok').show();
            }
		});
	},
    DelEffect: function(){
		$.get('/index.php?go=editprofile&act=del_effect', function(d){
            if(d == 1){
                $('#delete_ok').show();
			}
		});
	},
        MoreInfo: function(){
		$('#moreInfo').show();
		$('#moreInfoText').text('Скрыть подробную информацию');
		$('#moreInfoLnk').attr('onClick', 'Profile.HideInfo()');
	},
	HideInfo: function(){
		$('#moreInfo').hide();
		$('#moreInfoText').text('Показать подробную информацию');
		$('#moreInfoLnk').attr('onClick', 'Profile.MoreInfo()');
	}
}

//MODAL BOX
var Box = {
	Page: function(url, data, name, width, title, cancel_text, func_text, func, height, overflow, bg_show, bg_show_bottom, input_focus, cache){
	
		//url - ссылка которую будем загружать
		//data - POST данные
		//name - id окна
		//width - ширина окна
		//title - заголовк окна
		//content - контент окна
		//close_text - текст закрытия
		//func_text - текст который будет выполнять функцию
		//func - функция текста "func_text"
		//height - высота окна
		//overflow - постоянный скролл
		//bg_show - тень внтури окна сверху
		//bg_show_bottom - "1" - с тенью внтури, "0" - без тени внутри
		//input_focus - ИД текстового поля на котором будет фиксация
		//cache - "1" - кешировоть, "0" - не кешировать

		if(cache)
			if(ge('box_'+name)){
				Box.Close(name, cache);
				$('#box_'+name).show();
				$('#box_content_'+name).scrollTop(0);
				if(is_moz && !is_chrome)
					scrollTopForFirefox = $(window).scrollTop();
				
				$('html').css('overflow', 'hidden');

				if(is_moz && !is_chrome)
					$(window).scrollTop(scrollTopForFirefox);
				return false;
			}
		
		Page.Loading('start');
		$.post(url, data, function(html){
			if(!CheckRequestVideo(location.href))
				Box.Close(name, cache);
			Box.Show(name, width, title, html, cancel_text, func_text, func, height, overflow, bg_show, bg_show_bottom, cache);
			Page.Loading('stop');
			if(input_focus)
				$('#'+input_focus).focus();
		});
	},
	Show: function(name, width, title, content, close_text, func_text, func, height, overflow, bg_show, bg_show_bottom, cache){
		
		//name - id окна
		//width - ширина окна
		//title - заголовк окна
		//content - контент окна
		//close_text - текст закрытия
		//func_text - текст который будет выполнять функцию
		//func - функция текста "func_text"
		//height - высота окна
		//overflow - постоянный скролл
		//bg_show - тень внтури окна сверху
		//bg_show_bottom - тень внтури внтури снизу
		//cache - "1" - кешировоть, "0" - не кешировать
		
		if(func_text)
			var func_but = '<div class="button_div fl_r" style="margin-right:10px;" id="box_but"><button onClick="'+func+'" id="box_butt_create">'+func_text+'</button></div>';
		else
			var func_but = '';
			
		var close_but = '<div class="button_div fl_r"><button onClick="Box.Close(\''+name+'\', '+cache+'); return false;">'+close_text+'</button></div>';
		
		var box_loading = '<img id="box_loading" style="display:none;padding-top:8px;padding-left:5px;" src="/templates/Default/images/loading_mini.gif" alt="" />';
		
		if(height)
			var top_pad = ($(window).height()-150-height)/2;
			if(top_pad < 0)
				top_pad = 100;
			
		if(overflow)
			var overflow = 'overflow-y:scroll;';
		else
			var overflow = '';
			
		if(bg_show)
			if(overflow)
				var bg_show = '<div class="bg_show" style="width:'+(width-19)+'px;"></div>';
			else
				var bg_show = '<div class="bg_show" style="width:'+(width-2)+'px;"></div>';
		else
			var bg_show = '';
		
		if(bg_show_bottom)
			if(overflow)
				var bg_show_bottom = '<div class="bg_show_bottom" style="width:'+(width-17)+'px;"></div>';
			else
				var bg_show_bottom = '<div class="bg_show_bottom" style="width:'+(width-2)+'px;"></div>';
		else
			var bg_show_bottom = '';
			
		if(height)
			var sheight = 'height:'+height+'px';
		else
			var sheight = '';

		$('body').append('<div id="modal_box"><div id="box_'+name+'" class="box_pos"><div class="box_bg" style="width:'+width+'px;margin-top:'+top_pad+'px;"><div class="box_title_wrap" style=""><div class="box_title" id="box_title_'+name+'">'+title+'<div class="box_close" onClick="Box.Close(\''+name+'\', '+cache+'); return false;"></div></div></div><div class="box_conetnt" id="box_content_'+name+'" style="'+sheight+';'+overflow+'">'+content+'<div class="clear"></div></div><div class="box_footer"><div id="box_bottom_left_text" class="fl_l">'+box_loading+'</div>'+close_but+func_but+'</div></div></div></div>');
		
		$('#box_'+name).show();

		if(is_moz && !is_chrome)
			scrollTopForFirefox = $(window).scrollTop();
		
		$('html').css('overflow', 'hidden');

		if(is_moz && !is_chrome)
			$(window).scrollTop(scrollTopForFirefox);
		
		$(window).keydown(function(event){
			if(event.keyCode == 27) {
				Box.Close(name, cache);
			} 
		});
	},
	Close: function(name, cache){
	
		if(!cache)
			$('.box_pos').remove();
		else
			$('.box_pos').hide();

		if(CheckRequestVideo(location.href) == false && CheckRequestPhoto(location.href) == false)
			$('html, body').css('overflow-y', 'auto');
			
		if(CheckRequestVideo(location.href))
			$('#video_object').show();
			
		if(is_moz && !is_chrome)
			$(window).scrollTop(scrollTopForFirefox);
	},
	GeneralClose: function(){
		$('#modal_box').hide();
	},
	Info: function(bid, title, content, width, tout){
		var top_pad = ($(window).height()-115)/2;
		$('body').append('<div id="'+bid+'" class="box_info"><div class="box_info_margin" style="width: '+width+'px; margin-top: '+top_pad+'px"><b><span>'+title+'</span></b><br /><br />'+content+'</div></div>');
		$(bid).show();
		
		if(!tout)
			var tout = 1400;
		
		setTimeout("Box.InfoClose()", tout);
		
		$(window).keydown(function(event){
			if(event.keyCode == 27) {
				Box.InfoClose();
			} 
		});
	},
	InfoClose: function(){
		$('.box_info').fadeOut();
	}
}
function ge(i){
	return document.getElementById(i);
}
function butloading(i, w, d, t){
	if(d == 'disabled'){
		$('#'+i).html('<div style="width:'+w+'px;text-align:center;"><img src="/templates/Default/images/loading_mini.gif" alt="" /></div>');
		ge(i).disabled = true;
	} else {
		$('#'+i).html(t);
		ge(i).disabled = false;
	}
}
function textLoad(i){
	$('#'+i).html('<img src="/templates/Default/images/loading_mini.gif" alt="" />').attr('onClick', '').attr('href', '#');
}
$(document).ready(function(){
	setInterval(function(){
	$("#ads_view").show();
	}, 10000);
	setInterval(function(){
        $.ajax({
            url: "index.php?go=ads&act=ads_view",
            cache: true,
            success: function(html){
                $("#ads_view").html(html);
            }
        });
	}, 10000);
});	function ads_close(){
		$("#ads_view").fadeOut(400);
}

$(document).ready(function(){
 setInterval(function(){
 $("#ads_view1").show();
 }, 17000);
 setInterval(function(){
        $.ajax({
            url: "index.php?go=ads&act=ads_view1",
            cache: true,
            success: function(html){
                $("#ads_view1").html(html);
            }
        });
 }, 17000);
}); function ads_close(){
  $("#ads_view1").fadeOut(400);
}

function updateNum(i, type){
	if(type)
		$(i).text(parseInt($(i).text())+1);
	else
		$(i).text($(i).text()-1);
}
function setErrorInputMsg(i){
	$("#"+i).css('background', '#ffefef');
	$("#"+i).focus();
	setTimeout("$('#"+i+"').css('background', '#fff').focus()", 700);
}
function addAllErr(text, tim){
	if(!tim)
		var tim = 2500;
		
	$('.privacy_err').remove();
	$('body').append('<div class="privacy_err no_display">'+text+'</div>');
	$('.privacy_err').fadeIn('fast');
	setTimeout("$('.privacy_err').fadeOut('fast')", tim);
}
function langNumric(id, num, text1, text2, text3, text4, text5){
	strlen_num = num.length;
	
	if(num <= 21){
		numres = num;
	} else if(strlen_num == 2){
		parsnum = num.substring(1,2);
		numres = parsnum.replace('0','10');
	} else if(strlen_num == 3){
		parsnum = num.substring(2,3);
		numres = parsnum.replace('0','10');
	} else if(strlen_num == 4){
		parsnum = num.substring(3,4);
		numres = parsnum.replace('0','10');
	} else if(strlen_num == 5){
		parsnum = num.substring(4,5);
		numres = parsnum.replace('0','10');
	}
	
	if(numres <= 0)
		var gram_num_record = text5;
	else if(numres == 1)
		var gram_num_record = text1;
	else if(numres < 5)
		var gram_num_record = text2;
	else if(numres < 21)
		var gram_num_record = text3;
	else if(numres == 21)
		var gram_num_record = text4;
	else
		var gram_num_record = '';
	
	$('#'+id).html(gram_num_record);
}

function bannerHide(i){
  $('#Xbanner'+i).hide();
  $.post('/index.php?go=banners', {id: i});
}

function recForBannerStat(i){
  $.post('/index.php?go=mybanners&act=log', {id: i});
}

function showUserSubcsr(i, page_num){
  if(page_num)
    page = '&page='+page_num;
  else {
    page = '';
    page_num = 1;
  }
  Box.Page('/index.php?go=subscriptions&act=all_user_subscr', 'uid='+i+page, 'all_subscr_users_'+i+page_num, 525, 'Подписчики', lang_msg_close, 0, 0, 345, 1, 1, 1, 0, 1);
}

//LANG
template_dir					= '/templates/Default';
uploads_dir						= '/uploads';
uploads_smile_dir				= '/uploads/smiles';
lang_empty						= 'Поля не должны быть пустыми';
lang_nosymbol					= 'Специальные символы и пробелы запрещены';
lang_pass_none					= 'Пароли не совпадают';
lang_code_none					= 'Код безопасности не соответствует отображённому';
lang_please_code				= 'Введите код с картинки';
lang_bad_email					= 'Неправильный адрес';
lang_none_sex					= 'Укажите Ваш пол';
lang_no_vk						= 'Указанная Вами ссылка не является сайтом в контакте';
lang_no_od						= 'Указанная Вами ссылка не является сайтом однаклассники';
lang_no_fb						= 'Указанная Вами ссылка не является сайтом facebook';
lang_no_icq						= 'Номер ICQ должен состоять только из цифр';
lang_infosave					= '<b>Изменения сохранены.</b><br><br>Новые данные будут отражены на Вашей странице.';
lang_bad_format					= 'Неверный формат файла';
lang_bad_size					= 'Файл не должен превышать 5 Mб';
lang_bad_aaa					= 'Неизвестная ошибка';
lang_del_photo					= 'Вы уверены, что хотите удалить фотографию?';
lang_del_album					= 'Вы уверены, что хотите удалить альбом?';
lang_title_del_photo			= 'Предупреждениe';
lang_box_canсel					= 'Отмена';
lang_box_yes					= 'Да';
lang_box_send					= 'Отправить';
lang_box_save					= 'Сохранить';
lang_box_insert					= 'Вставить';
lang_title_load_photo			= 'Загрузка главной фотографии';
lang_title_new_album			= 'Создание нового альбома';
lang_album_create				= 'Готово';
lang_nooo_er					= 'Код ошибки: 1';
lang_del_comm					= 'Комментарий успешно удален';
lang_edit_albums				= 'Редактирование альбома';
lang_edit_cover_album			= 'Выберите фотографию на обложку';
lang_demand_ok					= 'Заявка отправлена';
lang_demand_no					= 'Повторно заявка отправлена не будет';
lang_demand_sending				= 'Заявка отправляеться';
lang_demand_sending_t			= 'В данный момент заявка на дружбу отправляеться';
lang_demand_s_ok				= ' получил уведомление и подтвердит, что Вы его друг';
lang_take_ok					= 'Заявка принята.';
lang_take_no					= 'Заявка отклонена.';
lang_dd2f_no					= 'Информация';
lang_dd2f22_no					= 'Этот пользователь есть у Вас в заявках';
lang_22dd2f22_no				= 'Этот пользователь уже есть у Вас в друзьях';
lang_no_user_fave				= 'Такого пользователя не существует';
lang_yes_user_fave				= 'Этот пользователя уже есть у Вас в закладках';
lang_del_fave					= 'Удалить из закладок';
lang_add_fave					= 'Добавить в закладки';
lang_fave_info					= 'Вы уверены, что хотите удалить этого пользователя из закладок?';
lang_fave_no_users				= '<div class="info_center">Вы можете добавлять сюда страницы интересных Вам людей.<br />Из этого раздела у Вас всегда будет быстрый доступ к ним</div>';
lang_new_msg					= 'Новое сообщение';
lang_new_msg_send				= 'Отправить';
lang_msg_box					= 'Сообщения';
lang_msg_max_strlen				= 'Ваше сообщение слишком длинное';
lang_msg_ok_title				= 'Сообщение успешно отправлено';
lang_msg_ok_text				= 'Ваше сообщение успешно отправлено';
lang_msg_close					= 'Закрыть';
lang_photo_info_text			= 'Фотография удалена либо еще не загружена';
lang_photo_info_delok			= '<br /><span class="online">Фотография удалена</span>';
lang_albums_add_photo			= 'Описание фотографии';
lang_albums_set_cover			= 'Сделать обложкой альбома';
lang_albums_del_photo			= 'Удалить фотографию';
lang_albums_save_descr			= 'Сохранить описание';
lang_notes_no_title				= 'Введите заголовок заметки';
lang_notes_no_text				= 'Введите текст заметки';
lang_del_note					= 'Вы действительно хотите удалить эту заметку?';
lang_del_process				= 'Заметка удаляется...';
lang_notes_comm_max				= 'Ваш комментарий превышает слишком длииный';
lang_notes_setting_addphoto		= 'Настройки фотографии';
lang_notes_setting_addvdeio		= 'Настройки видеозаписи';
lang_notes_preview				= 'Как это будет после публикации';
lang_wysiwyg_title				= 'Настройки ссылки';
lang_unsubscribe				= 'Отписаться от обновлений';
lang_subscription				= 'Подписаться на обновления';
lang_subscription_box_title		= 'Подписки';
lang_max_albums					= 'Привышен лимит альбомов.';
lang_video_new					= 'Добавление нового видео';
lang_videos_no_url				= 'Введите ссылку на видеоролик';
lang_videos_no_url				= 'Напишите название для видеоролика';
lang_videos_sending				= 'В данный момент видео обрабатывается';
lang_videos_del_text			= 'Вы действительно хотите удалить эту видеозапись?';
lang_videos_deletes				= 'Видеозапись удаляется...';
lang_videos_delok				= '<div class="videos_delok">Видеозапись успешно удалена</div>';
lang_videos_delok_2				= '<div class="online" style="margin-top:10px">Видеозапись удалена</div>';
lang_video_edit					= 'Редактирование видеозаписи';
lang_video_info_text			= 'Видеозапись удалена либо еще не добавлена';
lang_scroll_loading				= '<span id="scroll_loading"><center><img src="/templates/Default/images/loading_mini.gif" alt="" /></center><br /></span>';
lang_se_go						= 'Найти';
lang_bad_format					= 'Загружать разрешено только фотографии в формате JPG, PNG, GIF.';
lang_max_imgs					= 'Привышен лимит фотографий в одном альбоме';
lang_max_size					= 'Привышен максимальный размер изображения';
lang_news_prev					= 'Показать предыдущие новости &#8595;';
lang_editprof_text_1			= 'Укажите Вашу подругу';
lang_editprof_text_2			= 'Укажите Вашу невесту';
lang_editprof_text_3			= 'Укажите Вашу жену';
lang_editprof_text_4			= 'Укажите Вашу любимую';
lang_editprof_text_5			= 'Укажите Вашего партнёра';
lang_editprof_atext_1			= 'Укажите Вашего друга';
lang_editprof_atext_2			= 'Укажите Вашего жениха';
lang_editprof_atext_3			= 'Укажите Вашего мужа';
lang_editprof_atext_4			= 'Укажите Вашего любимого';
lang_editprof_atext_5			= 'Укажите Вашего партнёра';
lang_editprof_sptext_1			= 'Подруга:';
lang_editprof_sptext_2			= 'Невеста:';
lang_editprof_sptext_3			= 'Жена:';
lang_editprof_sptext_4			= 'Любимая:';
lang_editprof_sptext_5			= 'Партнёр:';
lang_editprof_asptext_1			= 'Друг:';
lang_editprof_asptext_2			= 'Жених:';
lang_editprof_asptext_3			= 'Муж:';
lang_editprof_asptext_4			= 'Любимый:';
lang_editprof_asptext_5			= 'Партнёр:';
lang_pr_no_title				= 'Ошибка доступа';
lang_pr_no_msg					= 'Вы не можете отправить сообщение данному пользователю, так как он ограничивает круг лиц, которые могут присылать ему сообщения';
lang_support_text				= 'Вы действительно хотите удалить вопрос? Это действие нельзя будет отменить';
lang_support_ltitle				= 'Лимит';
lang_support_ltext				= 'Следующий вопрос Вы сможете задать через час';
lang_news_text					= 'Вы действительно хотите удалить новость? Это действие нельзя будет отменить';
lang_gifts_title				= 'Выберите подарок';
lang_gifts_tnoubm				= 'У Вас недостаточно голосов для отправки этого подарка';
lang_gifts_oktitle				= 'Подарок отправлен';
lang_gifts_oktext				= 'Ваш подарок был успешно отправлен';
lang_groups_new					= 'Создание нового сообщества';
lang_groups_cretate				= 'Создать сообщество';
lang_audio_add					= 'Добавление новой песни';
lang_audio_err					= 'Формат не поддерживается либо ссылка является неправильной';
lang_audio_wall_attatch			= 'Выберите аудиозапись';
lang_wall_tell_tes				= 'Эта запись уже есть на стене';
lang_wall_text					= 'Что у Вас нового?';
lang_wall_del_ok				= '<div class="color777">Запись успешно удалена</div>';
lang_wall_del_com_ok			= '<div class="online" style="margin-bottom:10px">Комментарий успешно удален</div>';
lang_wall_all_lnk				= 'к предыдущим записям';
lang_wall_hide_comm				= 'Скрыть комментарии';
lang_wall_atttach_addsmile		= 'Выберите смайлик для отправки';
lang_wall_attatch_photos		= 'Выберите фотографию';
lang_wall_attatch_videos		= 'Выберите видеозапись';
lang_wall_no_atttach			= 'Не прикреплять';
lang_wall_max_smiles			= 'Максимально можно прикреплять 3 смайлика';
lang_wall_liked_users			= 'Люди, которым это понравилось';
lang_znachok_title              = 'Выберите значок';
lang_znachok_oktitle            = 'Значок прикреплен';
lang_znachok_oktext             = 'Значок успешно прикреплен.';
lang_ask_title                  = 'Задайте вопрос';
lang_ask_oktitle                = 'Вопрос задан';
lang_ask_oktext                 = 'Вопрос успешно отправлен';
lang_invite_title               = 'Приглашение друзей';
lang_invite_titleok             = 'Приглашение отправлено';
lang_invite_textok              = 'Приглашение успешно отправлено';
lang_friends_del_text			= 'Пользователь удален из списка Ваших друзей';
lang_friends_del_title			= 'Пользователь удален';
lang_obshenie_text              = 'У вас недостаточно голосов на балансе!';
lang_obshenie_title             = 'Ошибка';
lang_obshenie_yes_text          = 'Вы уже находитесь в этом блоке!';
lang_wall_attach_smiles			= '<img src="'+uploads_smile_dir+'/1.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/2.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/3.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/4.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/5.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/6.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/7.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/8.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/9.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/10.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/11.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/12.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/13.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/14.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/15.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/16.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/29.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/17.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/18.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/19.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/20.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/21.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/22.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/23.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/24.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/25.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/26.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/27.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/30.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/31.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/32.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/33.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/34.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/35.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/36.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/37.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/38.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/39.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/40.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/41.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/42.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/43.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/44.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/45.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/46.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" /><img src="'+uploads_smile_dir+'/47.png" class="wall_attach_smile" onClick="wall.attach_insert(\'smile\', this.src)" />';

//LANG
var trsn = {
  box: function(){
    $('.js_titleRemove').remove();
    viiBox.start();
	$.post('/index.php?go=lang', function(d){
	  viiBox.win('vii_lang_box', d);
	});
  }
}

function AntiSpam(act){
  
  Page.Loading('stop');
  
  var max_friends = 40;
  var max_msg = 40;
  var max_wall = 500;
  var max_comm = 2000;
  
  if(act == 'friends'){
    Box.Info('antispam_'+act, 'Информация', 'В день Вы можете отправить не более '+max_friends+' заявок в друзья.', 300, 4000);
  } else if(act == 'messages'){
    Box.Info('antispam_'+act, 'Информация', 'В день Вы можете отправить не более '+max_msg+' сообщений. Если Вы хотите продолжить общение с этим пользователем, то добавьте его в список своих друзей.', 350, 5000);
  } else if(act == 'wall'){
    Box.Info('antispam_'+act, 'Информация', 'В день Вы можете отправить не более '+max_wall+' записей на стену.', 350, 4000);
  } else if(act == 'comm'){
    Box.Info('antispam_'+act, 'Информация', 'В день Вы можете отправить не более '+max_comm+' комментариев.', 350, 4000);
  }
   else if(act == 'groups'){
    Box.Info('antispam_'+act, 'Информация', 'В день Вы можете создать не более <b>5</b> сообществ.', 350, 3000);
  }
  
}
function toggles(d,f){
  if($('#'+d).is('.edit_hider_on')){
   $('#'+d).removeClass('edit_hider_on').addClass('edit_hider_off');
   $.cookie(d,f, {path: "/",expires:365});
 } else{
   $('#'+d).removeClass('edit_hider_off').addClass('edit_hider_on');
 
  $.cookie(d,null);
  }
   $('#'+f).animate({"height": "toggle", "opacity": "toggle"}, "slow");
}

function delMyPage(){
  Box.Show('del_page', 400, 'Удаление страницы', '<div style="padding:15px;">Вы уверены, что хотите удалить свою страницу ?</div>', lang_box_canсel, 'Да, удалить страницу', 'startDelpage()');
}

function startDelpage(){
  $('#box_loading').fadeIn('fast');
  $('.box_footer .button_div, .box_footer .button_div_gray').fadeOut('fast');
  $.post('/index.php?go=del_my_page', function(){
    window.location.href = '/';
  });
}

