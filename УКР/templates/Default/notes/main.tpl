<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<div style="width:auto;">
<head>
{header}
<noscript><meta http-equiv="refresh" content="0; URL=/badbrowser.php"></noscript>
<link media="screen" href="{theme}/style/style.css" type="text/css" rel="stylesheet" />  
{js}[not-logged]<script type="text/javascript" src="{theme}/js/reg.js"></script>[/not-logged]
</head>
<body onResize="onBodyResize()" class="no_display">
<div class="scroll_fix_bg no_display" onMouseDown="myhtml.scrollTop()"><div class="scroll_fix_page_top">Наверх</div></div>
<div class="head" [not-logged]style="height:38px"[/not-logged]>
<div id="doLoad"></div>
<div class="toplog">
 [logged]<a class="udinsMy" href="/news{news-link}" onClick="Page.Go(this.href); return false;" id="news_link"><span id="new_news">{new-news}</span><div class="logo"></div></a>[/logged]
 [not-logged]<a href="/"><div class="udinsMy"></div></a>[/not-logged]
</div>
<div class="menu">
 <div class="pg" style="width:865px">
  [not-logged]<form method="POST" action="" class="inlgpad">
   <div class="flLg">Электронный адрес</div><input type="text" name="email" id="log_email" class="inplog fl_l" maxlength="50" />
   <div class="flLg">Пароль</div><input type="password" name="password" id="log_password" class="inplog fl_l" maxlength="50" />
   <div class="button_div fl_l" style="margin-top:5px"><button name="log_in" id="login_but">Войти</button></div>
   <div style="margin-top:10px;margin-left:10px" class="fl_l"><a href="/restore" onClick="Page.Go(this.href); return false">забыли пароль?</a></div>
  </form>[/not-logged]

[logged]<div class="headmenu">
   <!--search-->
   <div id="seNewB">
    <input type="text" value="Поиск" class="fave_input search_input" 
		onBlur="if(this.value==''){this.value='Поиск';this.style.color = '#c1cad0';}" 
		onFocus="if(this.value=='Поиск'){this.value='';this.style.color = '#000'}" 
		onKeyPress="if(event.keyCode == 13) gSearch.go();"
		onKeyUp="FSE.Txt()"
		onClick="if(this.value != 0) $('.fast_search_bg').show()"
	id="query" maxlength="65" />
	<div id="search_types">
	 <input type="hidden" value="1" id="se_type" />
	 <div class="search_type" id="search_selected_text" onClick="gSearch.open_types('#sel_types'); return false">по людям</div>
	 <div class="search_alltype_sel no_display" id="sel_types">
	  <div id="1" onClick="gSearch.select_type(this.id, 'по людям'); FSE.GoSe($('#query').val()); return false" class="search_type_selected">по людям</div>
	  <div id="2" onClick="gSearch.select_type(this.id, 'по видеозаписям'); FSE.GoSe($('#query').val()); return false">по видеозаписям</div>
	  <div id="3" onClick="gSearch.select_type(this.id, 'по заметкам');  FSE.GoSe($('#query').val()); return false">по заметкам</div>
	  <div id="4" onClick="gSearch.select_type(this.id, 'по сообществам'); FSE.GoSe($('#query').val()); return false">по сообществам</div>
	  <div id="5" onClick="gSearch.select_type(this.id, 'по аудиозаписям');  FSE.GoSe($('#query').val()); return false">по аудиозаписям</div>
	 </div>
	</div>
   <div class="fast_search_bg no_display" id="fast_search_bg">
   <a href="/" style="padding:12px;background:#eef3f5" onClick="gSearch.go(); return false" onMouseOver="FSE.ClrHovered(this.id)" id="all_fast_res_clr1"><text>Искать</text> <b id="fast_search_txt"></b><div class="fl_r fast_search_ic"></div></a>
   <span id="reFastSearch"></span>
   </div>
   </div>
   <!--/search-->
<div class="newHling">
    <a href="/?act=logout">выйти</a>
    <a href="/audio" onclick="doLoad.js(0); player.open(); return false;" id="fplayer_pos">музыка</a>
    <a href="/?go=search&type=2" onClick="Page.Go(this.href); return false">видео</a>
    <a href="/apps" onclick="Page.Go(this.href); return false">игры</a>
    <a href="/?go=search&type=4" onClick="Page.Go(this.href); return false">сообщества</a>
    <a href="/?go=search&online=1" onClick="Page.Go(this.href); return false">люди</a>
   </div></div>[/logged]
 </div>
</div>
<div class="clear"></div>
<div class="pg" style="margin-top:0px">

<div style="float:left;width:100%">
 <div style="margin-left:150px" class="wra">
<div id="audioPlayer"></div>  
<div id="page">{info}{content}{main-photos}</div>
  <div class="clear"></div>
 </div>
</div>


[logged]
<div style="float:left;margin-left:-99%">
<div style="margin-top:10px" class="vkMenu">
<a href="{my-page-link}" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Моя Страница</span></a>
<a href="/friends{requests-link}" onClick="Page.Go(this.href); return false;" id="requests_link"><span class="left_label inl_bl">Мои Друзья</span> <span id="new_requests">{demands}</span></a>
<a href="/albums/{my-id}" onClick="Page.Go(this.href); return false;" id="requests_link_new_photos"><span class="left_label inl_bl">Мои Фотографии</span> <span id="new_photos">{new_photos}</span></a>
<a href="/videos" onclick="Page.Go(this.href); return false"><span class="left_label inl_bl">Мои Видеозаписи</span></a>
<a href="/audio" onClick="Page.Go(this.href); return false"><span class="left_label inl_bl">Мои Аудиозаписи</span></a>
<a href="/messages" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Мои Сообщения</span> <span id="new_msg">{msg}</span></a>
<a href="/groups" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Мои Группы</span></a>
<a href="/notes" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Мои Заметки</span></a>
<a href="/news{news-link}" onClick="Page.Go(this.href); return false;" id="news_link"><span class="left_label inl_bl">Мои Новости</span> <span id="new_news">{new-news}</span></a>
<a href="/fave" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Мои Закладки</span></a>
<a href="{ubm-link}" onClick="Page.Go(this.href); return false;" id="ubm_link"><span class="left_label inl_bl">Мой Баланс </span><span id="new_ubm">{new-ubm}</span></a>
<a href="/settings" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Мои Настройки</span></a>

<div class="more_div"></div>
<a href="/apps" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Приложения</span></a>
<a href="/docs" onClick="Page.Go(this.href); return false;"><span class="left_label inl_bl">Документы</span></a>
</div>
</div>
[/logged]

<div class="clear"></div>



  <div class="footer">
<a href="/live" onClick="Page.Go(this.href); return false"><b>о сайте</b></a>
   <a href="/?go=search&online=1" onClick="Page.Go(this.href); return false"><b>люди</b></a>
   <a href="/?go=search&type=4" onClick="Page.Go(this.href); return false"><b>сообщества</b></a>
   <a href="/?go=search&type=5" onClick="Page.Go(this.href); return false"><b>музыка</b></a>
   <a href="/?go=search&type=2" onClick="Page.Go(this.href); return false"><b>видео</b></a>
   <a href="/developers" onClick="Page.Go(this.href); return false"><b>разработчикам</b></a>
   <a href="/support" onClick="Page.Go(this.href); return false;"><b>помощь</b><span id="new_support"></span></a>
  </div>
 </div>
</div>
<div class="clear"></div>
<div class="pg foot">
 NetLife.su &copy; 2012<!-- Rating@Mail.ru counter -->
<script type="text/javascript">//<![CDATA[
(function(w,n,d,r,s){(new Image).src='http://dc.ce.b2.a2.top.mail.ru/counter?id=2288799;js=13'+
((r=d.referrer)?';r='+escape(r):'')+((s=w.screen)?';s='+s.width+'*'+s.height:'')+';_='+Math.random();})(window,navigator,document);//]]>
</script><noscript><div style="position:absolute;left:-10000px;"><img src="http://dc.ce.b2.a2.top.mail.ru/counter?id=2288799;js=na"
style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" /></div></noscript>
<!-- //Rating@Mail.ru counter -->
</div>
<script type="text/javascript">
function upClose(xnid){
	$('#event'+xnid).remove();
	$('#updates').css('height', $('.update_box').size()*123+'px');
}
function GoPage(event, p){
	var oi = (event.target) ? event.target.id: ((event.srcElement) ? event.srcElement.id : null);
	if(oi == 'no_ev' || oi == 'update_close' || oi == 'update_close2') return false;
	else {
		pattern = new RegExp(/photo[0-9]/i);
		pattern2 = new RegExp(/video[0-9]/i);
		if(pattern.test(p))
			Photo.Show(p);
		else if(pattern2.test(p)){
			vid = p.replace('/video', '');
			vid = vid.split('_');
			videos.show(vid[1], p, location.href);
		} else
			Page.Go(p);
	}
}
$(document).ready(function(){
	setInterval(function(){
		$.post('/index.php?go=updates', function(d){
			row = d.split('|');
			if(d && row[1]){
				if(row[0] == 1) uTitle = 'У Вас новый ответ на стене';
				else if(row[0] == 2) uTitle = 'У Вас новый комментарий к фотографии';
				else if(row[0] == 3) uTitle = 'У Вас новый комментарий к видеозаписи';
				else if(row[0] == 4) uTitle = 'У Вас новый комментарий к блогу';
				else if(row[0] == 5) uTitle = 'У Вас новый ответ на Ваш комментарий';
				else if(row[0] == 6) uTitle = 'У Вас новый ответ в теме';
				else if(row[0] == 7) uTitle = 'У Вас новый подарок';
				else if(row[0] == 8) uTitle = 'У Вас новое сообщение';
				else if(row[0] == 9) uTitle = 'У Вас новая оценка';
                                else if(row[0] == 10) uTitle = 'Ваша запись понравилась';
                                else if(row[0] == 11) uTitle = 'У Вас новая заявка';
				else if(row[0] == 12) uTitle = 'Ваша заявка принята';
				else uTitle = 'Событие';
				if(row[0] == 8){
					sli = row[6].split('/');
					tURL = (location.href).replace('http://'+location.host, '').replace('/', '').split('#');
					if(!sli[2] && tURL[0] == 'messages') return false;
					if($('#new_msg').text()) msg_num = parseInt($('#new_msg').text().replace(')', '').replace('(', ''))+1;
					else msg_num = 1;
					$('#new_msg').html("<span>+"+msg_num+"</span>");
				}
				temp = '<div class="update_box cursor_pointer" id="event'+row[4]+'" onClick="GoPage(event, \''+row[6]+'\'); upClose('+row[4]+')"><div class="update_box_margin"><div style="height:19px"><span>'+uTitle+'</span><div class="update_close fl_r no_display" id="update_close" onMouseDown="upClose('+row[4]+')"><div class="update_close_ic" id="update_close2"></div></div></div><div class="clear"></div><div class="update_inpad"><a href="/u'+row[2]+'" onClick="Page.Go(this.href); return false"><div class="update_box_marginimg"><img src="'+row[5]+'" id="no_ev" /></div></a><div class="update_data"><a id="no_ev" href="/u'+row[2]+'" onClick="Page.Go(this.href); return false">'+row[1]+'</a>&nbsp;&nbsp;'+row[3]+'</div></div><div class="clear"></div></div></div>';
				$('#updates').html($('#updates').html()+temp);
				var beepThree = $("#beep-three")[0];
				beepThree.play();
				if($('.update_box').size() <= 5) $('#updates').animate({'height': (123*$('.update_box').size())+'px'});
				if($('.update_box').size() > 5){
					evFirst = $('.update_box:first').attr('id');
					$('#'+evFirst).animate({'margin-top': '-123px'}, 400, function(){
						$('#'+evFirst).fadeOut('fast', function(){
							$('#'+evFirst).remove();
						});
					});
				}
			}
		});
	}, 4000);
});
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33282651-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<div class="no_display"><audio id="beep-three" controls preload="auto"><source src="/templates/152_2750ff2585d4.ogg"></source></audio></div>
<div id="updates"></div>
<div class="clear"></div>
</div>
</body>
</html>