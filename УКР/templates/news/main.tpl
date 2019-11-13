<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
{header}
<noscript><meta http-equiv="refresh" content="0; URL=/badbrowser.php"></noscript>
[logged]
<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" /> 
<link media="screen" href="{theme}/style/style.css" type="text/css" rel="stylesheet" /> 
<link media="screen" href="{theme}/im_chat/im_chat.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{theme}/js/chat.js"></script>
<script type="text/javascript" src="{theme}/js/fon.js"></script>
[/logged]
{js}[not-logged]<script type="text/javascript" src="{theme}/js/reg.js"></script>
<link media="screen" href="http://onepuls.ru/templates/Default/reg/css/style_reg.css" type="text/css" rel="stylesheet" />
<style>
/* ERRORS */
.err_yellow{padding:10px;background:#f4f7fa;border:1px solid #bfd2e4;margin-bottom:10px}
.err_red{padding:10px;background:#faebeb;border:1px solid #d68383;margin-bottom:10px;line-height:17px}
.listing {list-style: square;color: #d20000;margin:0px;padding-left:10px}
ul.listing li {padding: 1px 0px}
ul.listing li span {color: #000}
.privacy_err{background:#ffb4a3;position:fixed;left:0px;top:0px;padding:7px;border-bottom-right-radius:7px;-moz-border-bottom-right-radius:7px;-webkit-border-bottom-right-radius:7px;margin-top:35px;z-index:100}
</style>
[/not-logged]
</head>
<body onResize="onBodyResize()" class="no_display">
[logged]<div class="scroll_fix_bg no_display" onMouseDown="myhtml.scrollTop()"><div class="scroll_fix_page_top">Наверх</div></div>
<div id="doLoad"></div>
<div class="head">
<div class="menu3">
[logged]
[diz2]<a  href="/index.php?go=editprofile&act=def"><span class="des cer select" title="Сменить цвета" /></span></a>[/diz2]
[diz]<a href="/index.php?go=editprofile&act=blue"><span class="des blue select" title="Сменить цвета" /></span></a>[/diz]
[diz]<link rel="stylesheet" type="text/css" href="{theme}/diz/diz.css" media="screen">[/diz][/logged]
</div>
<div class="autowrs">
[logged]<a class="udinsMy" href="/news{news-link}" onClick="Page.Go(this.href); return false;" id="news_link"><span id="new_news">{new-news}</span></a>
</div>
[/logged]
[logged]
<div class="headmenu">
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
<a class="cursor_pointer headm_ic_logout" onClick="logout.box()">выйти</a>


<div style="position:absolute;width:82px;text-align:center;margin-top:2px;margin-left:50px;">
<a onclick="doLoad.js(0); player.open(); return false;" id="fplayer_pos">
<div class="staticpl_prev" onClick="player.prev()"></div>
  <div class="staticpl_play" onClick="player.onePlay()"></div>
  <div class="staticpl_pause" onClick="player.pause()"></div>
  <div class="staticpl_next" onClick="player.next()"></div>
 <div class="play1" onClick="player.open()"></div></br>
</a></div>
</div>
</div>
</div>
</div>
<div id="globalContainer">
<div id="content">
[logged]

<div id="side_bar" class="fl_l">

<div ><!--style="margin-top:9px;margin-left:-7px;"-->

<ol>
<li><table id="myprofile_table" cellspacing="0" cellpadding="0"><tbody><tr><td id="myprofile_wrap"><a href="{alias}" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">Моя Страница</span></a></td><!-- <td id="myprofile_edit_wrap"><a href="/editmypage" onClick="Page.Go(this.href); $('.profileMenu').hide(); return false;" id="myprofile_edit" class="left_row"><span class="left_label inl_bl">ред.</span></a></td>--></tr></tbody></table></li>

<li >
   <a href="/friends{requests-link}" onClick="Page.Go(this.href); return false" id="requests_link" class="left_row"><span class="left_label inl_bl">Мои Друзья</span></a></li>

<li><a href="/albums/{my-id}" onClick="Page.Go(this.href); return false" id="requests_link_new_photos" class="left_row"><span class="left_count_pad"><span class="left_count_wrap fl_r"><span class="inl_bl left_count" id="new_photos">{new_photos}</span></span> <span class="left_label inl_bl">Мои Фотографии<span></span></a></li>

<li><a href="/videos" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">Мои Видеозаписи</span></a></li>

<li><a href="/audio" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">Мои Аудиозаписи</span></a></li>

<li><a href="/messages" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad left_count_persist"><span class="left_count_wrap fl_r"><span class="inl_bl" id="new_msg">{msg}</span></span></span><span class="left_label inl_bl">Мои Сообщения</span></a></li>

<li><a href="/ask" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad left_count_persist"> <span class="left_count_wrap fl_r"><span class="inl_bl left_count" id="ask_num">{ask_num}</span></span> </span><span class="left_label inl_bl">Мои Вопросы</span></a></li>

<li><a class="left_row"><span class="left_count_pad left_count_persist"> <span class="left_count_wrap fl_r"><span class="inl_bl left_count" onClick="Page.Go(this.href='/groups?act=requests'); return false" style="cursor:pointer;" id="new_groups">{new_groups}</span></span> </span><span onClick="Page.Go(this.href='/groups'); return false" class="left_label inl_bl" style="cursor:pointer;">Мои Группы</span></a></li>

<li><a href="/notes" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">Мои Заметки<span></span></a></li>

<li><a href="/news{news-link}" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad left_count_persist"> <span class="left_count_wrap fl_r"><span class="inl_bl left_count" id="new_news">{new-news}</span></span> </span><span class="left_label inl_bl">Мои Новости</span></a></li>

<li><a href="/fave" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad"></span><span class="left_label inl_bl">Мои Закладки</span></a></li>

<li><a href="/settings" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">Мои Настройки</span></a></li>

<div class="more_div"></div>

<li><a href="apps" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad"></span><span class="left_label inl_bl">Приложения</span></a></li>

<li><a id="ims" style="cursor: pointer;" onclick="im_chat.chatOpen(); clear_style(); return false" class="left_row"><span class="left_count_pad"></span><span class="left_label inl_bl">Чатка</span></a></li>

<li><a href="/docs" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad"></span><span class="left_label inl_bl">Документы</span></a></li>

<li><a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad"></span><span class="left_label inl_bl">Реклама</span></a></li>
</ol>

</div>

<div style="margin-left:-6px;margin-bottom:10px;text-align: center;">

<div class="more_div"></div>

</div>



<div class="clear"></div>


<div id="ads_view" style="display:none;"></div>

<div class="clear"></div>

<div style=margin-left:3px;">
<div id="ads_view1" style="display:none;"></div>
</div>
</div>

[/logged]

[not-logged]

<div id="blueBarHolder">

<div id="blueBar">

<div class="loggedout_menubar_container">
<div class="clearfix loggedout_menubar">
<a href="http://onepuls.ru" class="lfloat">
<br>
<img alt="Onepuls - социальная сеть" src="http://onepuls.ru/templates/Default/images/logo_head_black.png">
</a>
<div class="menu_login_container rfloat">
 <form method="POST" action="">
<input type="hidden" autocomplete="off" value="AVqeFhsS" name="lsd">
<table cellspacing="0"><tbody><tr>
<td class="html7magic">
<label for="email">Адрес эл. почты</label></td>
<td class="html7magic"><label for="pass">Пароль</label></td></tr>
<tr><td>
<input type="text" tabindex="1" id="log_email" name="email" class="inputtext"></td>
<td><input type="password" tabindex="2" id="log_password" name="password" class="inputtext"></td>

<td><label id="loginbutton" class="uiButton uiButtonConfirm" for="urfj49u4">
<div class="button_div"><button name="log_in" id="login_but" style="width:50px">Войти</button></div></label>
</td>
</tr>

<td class="login_form_label_field"><div><div class="uiInputLabel clearfix">
<br></div></td><td class="login_form_label_field"><a href="/restore" rel="nofollow">Забыли пароль?</a></td></tr></tbody></table>
</form></div></div></div></div>

</div>

</div>

[/not-logged]

<div class="pg wra" style="[not-logged]margin-top:20px;[/not-logged][logged]margin-top:80px;[/logged]">

<div id="audioPlayer"></div>
<div id="page">{info}{content}</div>
<div class="clear"></div>
</div>
</div>

[logged]

<div class="clear"></div>

<div class="footer">

<a href="/onepuls" onClick="Page.Go(this.href); return false">о сайте</a>

<a href="/developers" onClick="Page.Go(this.href); return false">разработчикам</a>

<a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;">реклама</a>

<a href="/jobs" onClick="Page.Go(this.href); return false;">вакансии</a>

<a href="/terms" onClick="Page.Go(this.href); return false;">правила</a>

<div style="margin-top: 5px;">Onepuls.ru  © 2013</div>
</div>
<div>
<div style="margin-left:462px;float:centr;"><small><a href="/u1" onClick="Page.Go(this.href); return false">Иван Николаевич</a></div></small>
</div>
[/logged]

<div class="clear"></div>

</div>
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
                else if(row[0] == 11) uTitle = 'У Вас новая заявка в друзья';
                else if(row[0] == 12) uTitle = 'Ваша заявка принята';
		else if(row[0] == 13) uTitle = 'У Вас новый подписчик';
                else if(row[0] == 14) uTitle = 'Вам задали вопрос';
                else if (row[0] == 15) uTitle = 'Приглашение в сообщество';
                else if (row[0] == 16) uTitle = 'У Вас новые просмотры';
                else uTitle = 'Событие';
				if(row[0] == 8){
					sli = row[6].split('/');
					tURL = (location.href).replace('http://'+location.host, '').replace('/', '').split('#');
					if(!sli[2] && tURL[0] == 'messages') return false;
					if($('#new_msg').text()) msg_num = parseInt($('#new_msg').text().replace(')', '').replace('(', ''))+1;
					else msg_num = 1;
					$('#new_msg').html("<span class=\"left_count_wrap\"><span class=\" left_count\">+"+msg_num+"</span></span>");
				}
				if(row[0] == 11){
					sli = row[6].split('/');
					tURL = (location.href).replace('http://'+location.host, '').replace('/', '').split('#');
					if(!sli[2] && tURL[0] == 'friends') return false;
					if($('#new_requests').text()) friends_demands = parseInt($('#new_requests').text().replace(')', '').replace('(', ''))+1;
					else friends_demands = 1;
					$('#new_requests').html("<div class=\"headm_newac\" >+"+friends_demands+"</div>");
				}
setTimeout('upClose('+row[4]+');', 100000); 
				temp = '<div class="update_box cursor_pointer" id="event'+row[4]+'" onClick="GoPage(event, \''+row[6]+'\'); upClose('+row[4]+')"><div class="update_box_margin"><div style="height:19px"><span>'+uTitle+'</span><div class="update_close fl_r no_display" id="update_close" onMouseDown="upClose('+row[4]+')"><div class="update_close_ic" id="update_close2"></div></div></div><div class="clear"></div><div class="update_inpad"><a href="/id'+row[2]+'" onClick="Page.Go(this.href); return false"><div class="update_box_marginimg"><img src="'+row[5]+'" id="no_ev" /></div></a><div class="update_data"><a id="no_ev" href="/id'+row[2]+'" onClick="Page.Go(this.href); return false">'+row[1]+'</a>&nbsp;&nbsp;'+row[3]+'</div></div><div class="clear"></div></div></div>';
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
<div class="no_display"><audio id="beep-three" controls preload="auto"><source src="/templates/152_2750ff2585d4.ogg"></source></audio></div>
<div id="updates"></div>
<div class="clear"></div>
</div>
<div id="ajax-next-page" style="display: none;">[next-link][/next-link]</div>
<script type="text/javascript">
function nextPage() {
var nextPage = $('#ajax-next-page a').attr('href');
ShowLoading("");
if (nextPage !== undefined) {
$.ajax({
url: nextPage,
success: function(data) {
$('#ajax-next-page').remove();
$('#next-page').remove();
HideLoading("");
$('#dle-content').append($('#dle-content', data).html());
}
})
}
};
</script>
</body>
</html>