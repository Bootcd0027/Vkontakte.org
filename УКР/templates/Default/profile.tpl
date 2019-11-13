<!--[owner]<div class="err_fall_ads" style="height:25px;width:700px;margin-top:-10px;margin-left:-12px;>
<img id="apps_se_load" class="fl_r no_display" style="margin-left:632px;margin-top:10px;position:absolute" src="http://onepuls.ru/templates/default/images/loading_mini.gif">
<div id="page" style="min-height: 50px;">
<div id="apps_all">
<center>
<div style="color:#fff;font-size:13px;margin-top:-5px;">
<font color="#fff"><b>Внимание! На сайте ведутся тех. работы по обновлению функционала!
Некоторые функции могут работать не стабильно!</b></font>
</b>
</div>
</center>
</div>
</div>
</div>[/owner]--!>

{url_img}
<script type="text/javascript">[after-reg]Profile.LoadPhoto();[/after-reg]
var startResizeCss = false;
var user_id = '{user-id}';
$(document).ready(function(){
	var arr = ['friends1','common-friends','friends2','albums','videos','notes'];
	var numse = 0;
	while(typeof(arr[numse]) !== 'undefined'){
		if($.cookie(arr[numse])){
			$('#'+$.cookie(arr[numse])).addClass('no_display');
			$('#'+arr[numse]).removeClass('edit_hider_on').addClass('edit_hider_off');
		}
		numse++;
	}
	
	$(window).scroll(function(){
		if($('#type_page').val() == 'profile'){
			if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
				wall.page(user_id);
			}
			if($(window).scrollTop() < $('#fortoAutoSizeStyleProfile').offset().top){
				startResizeCss = false;
				$('#addStyleClass').remove();
			}
			if($(window).scrollTop() > $('#fortoAutoSizeStyleProfile').offset().top && !startResizeCss){
				startResizeCss = true;
				$('body').append('<div id="addStyleClass"><style type="text/css" media="all">.wallrecord{width:695px;margin-left:-210px}.infowalltext_f{font-size:11px}.wall_inpst{width:613px}.public_likes_user_block{margin-left:540px}.wall_fast_opened_form{width:623px;margin-left:-150px}.wall_fast_block{width:613px;margin-top:2px;margin-left:-150px}.public_wall_all_comm{width:612px;margin-top:2px;margin-bottom:5px}.player_mini_mbar_wall{width:636px;margin-bottom:0px}#audioForSize{min-width:636px}.wall_rec_autoresize{width:635px}.wall_fast_ava img{width:50px}.wall_fast_ava{width:60px}.wall_fast_comment_text{margin-left:57px}.wall_fast_date{margin-left:57px;font-size:11px}.public_wall_all_comm{margin-left:-150px}.size10{font-size:11px}.wall_upgwi{width:825px;margin-left:-210px}.public_like_strelka {height: 9px; margin-left: 19px;margin-top: -4px;position: absolute;width: 120px}.public_likes_user_block {margin-left: 523px}</style></div>');
			}
		}
	});
	music.jPlayerInc();
	$('#wall_text, .fast_form_width').autoResize();
	[owner]if($('.profile_onefriend_happy').size() > 4) $('#happyAllLnk').show();
	ajaxUpload = new AjaxUpload('upload_cover', {
		action: '/index.php?go=editprofile&act=upload_cover',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				addAllErr(lang_bad_format, 3300);
				return false;
			}
			$("#les10_ex2").draggable('destroy');
			$('.cover_loaddef_bg').css('cursor', 'default');
			$('.cover_loading').show();
			$('.cover_newpos, .cover_descring').hide();
			$('.cover_profile_bg').css('opacity', '0.4');
		},
		onComplete: function (file, row){
			if(row == 1 || row == 2) addAllErr('Максимальны размер 7 МБ.', 3300);
			else {
				$('.cover_loading').hide();
				$('.cover_loaddef_bg, .cover_hidded_but, .cover_loaddef_bg, .cover_descring').show();
				$('#upload_cover').text('Изменить фото');
				$('.cover_profile_bg').css('opacity', '1');
				$('.cover_loaddef_bg').css('cursor', 'move');
				$('.cover_newpos').css('position', 'absolute').css('z-index', '2').css('margin-left', '197px').show();
				row = row.split('|');
				rheihht = row[1];
				postop = (parseInt(rheihht/2)-100);
				if(rheihht <= 230) postop = 0;
				$('#les10_ex2').css('height', +rheihht+'px').css('top', '-'+postop+'px');
				cover.init('/uploads/users/'+row[0], rheihht);
				$('.cover_addut_edit').attr('onClick', 'cover.startedit(\'/uploads/users/'+row[0]+'\', '+rheihht+')');
			}
		}
	});[/owner]

});
$(document).click(function(event){
	wall.event(event);
});

$(document).ready(function(){
    $("ul.tabs").jTabs({content: ".fm_tabs_content", animate: true, effect:"slide"});                       
});
</script>

<input type="hidden" id="type_page" value="profile" />
<style>.newcolor000{color:#000}[owner].speedbar{text-indent:-9999px;backgorund:none}[/owner]{cover_css}</style>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
[owner]<div class="cover_loading no_display"><img src="{theme}/images/progress_gray.gif" /></div>
<div class="cover_profile_bg">
 <div class="cover_buts_pos">
  <div class="cover_newpos" {cover-param-3}>
  <div class="cover_addut cover_hidded_but" onClick="cover.cancel('{cover-pos}')">{translate=lang_834}</div>
  <div class="cover_addut cover_hidded_but" onClick="cover.del()">{translate=lang_37}</div>
  <div class="cover_addut {cover-param-2}" id="upload_cover">{translate=lang_835}</div>
  <div class="cover_addut cover_hidded_but" onClick="cover.save()">{translate=lang_92}</div>
  <div id="cover_addut_edit" class="no_display"><div class="cover_addut_edit {cover-param}" onClick="cover.startedit('{cover}', '{cover-height}')">{translate=lang_836}</div></div>
  </div>
  <div class="cover_loaddef_bg {cover-param}" {cover-param-4}>
   <div class="cover_descring {cover-param-2}">{translate=lang_837}</div>
   <div id="les10_ex2" {cover-param-5}><img src="{cover}" width="800" id="cover_img" /></div>
   <div id="cover_restart"></div>
  </div>
 </div>
</div>
[/owner]
[not-owner][cover]<div class="cover_all_user"><img src="{cover}" width="800" id="cover_img" {cover-param-5} /></div>[/cover][/not-owner]


<!--<div class="profile_hasCover">
<div class="profile__menuLink">

<ul class="tabs">  
<li class="active"><a href="#">Информация</a></li>

<li><a href="#">Посетители</a></li>

<li><a href="#">Мнения</a></li>

<li><a href="#"><span style=color:#607387;margin-left:97px;">В разработке</span></a></li>

</ul>
</div></div>--!>

<div class="ava">
    <div id="owner_photo_wrap">
   [owner] <div id="owner_photo_top_bubble_wrap">
  <div id="owner_photo_top_bubble">
    <div class="owner_photo_bubble_delete_wrap" onClick="Profile.DelPhoto(); $('.profileMenu').hide(); return false;" id="del_pho_but" {display-ava}>
      <div class="owner_photo_bubble_delete"></div>
    </div>
  </div>
</div><div class="cover_newava" {cover-param-7}>[/owner][not-owner]<div class="[cover]cover_newava[/cover]" [cover]{cover-param-7}[/cover]>[/not-owner]
<div style="margin-left: 0px;margin-top: 0px;z-index:50;position:absolute;">{user_znachok}</div>
  <div id="page_avatar"><a id="profile_photo_link"><a href="" onclick="Photo.Profile('{user-id}', '{user-ph}'); return false"><span id="ava"><img src="{ava}" alt="" title="" id="ava_{user-id}" /></span></a></div>
  [owner]
<div id="owner_photo_bubble_wrap">
    <div id="owner_photo_bubble">
<div class="owner_photo_bubble_action owner_photo_bubble_action_update" onClick="Profile.LoadPhoto(); $('.profileMenu').hide(); return false;">
  <span class="owner_photo_bubble_action_in">{translate=lang_432}</span>
</div>

<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onClick="Profile.miniature(); return false;">
 <span class="owner_photo_bubble_action_in">{translate=lang_742}</span>
</div>

<div class="owner_photo_bubble_action owner_photo_bubble_action_znak" onClick="znachok.box({user-id},1); return false">
 <span class="owner_photo_bubble_action_in">{translate=lang_839}</span></div>

<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onclick="doLoad.data(1); fon.addbox()">
 <span class="owner_photo_bubble_action_in">{translate=lang_840}</span></div>

</div>
  </div>[/owner]
  </div></div>
  
{user_rating}
  
[not-owner]
[blacklist][privacy-msg]
<div id="profile_main_actions">
<div class="button_blue button">
<button id="sending" onClick="messages.new_({user-id}); return false">{translate=lang_179}</button>

[yes-friends]
<div class="friend_status"><p onmouseover="shows_fr();" onmouseout="hides();" style="padding: 0px 0px 1px;color:#666;cursor: default;transition: all 900ms ease 0s;">{name} {translate=lang_838}</p></div>

<div id="s_friends" onmouseover="shows_fr();" onmouseout="hides_fr();" style="display: none;">
<div class="arrow_fr"></div>
<div class="friends_my">{name} доступны все Ваши материалы, предназначенные для друзей.<br><a href="/" onClick="friends.delet({user-id}, 1); return false" id="addfave_but">Убрать {name} из друзей</a></div>
</div>
[/yes-friends]

</div></div>
[/privacy-msg][/blacklist]
[/not-owner]

<div class="menuleft" style="margin-top:4px">


[not-owner]
[privacy-friend][no-friends][blacklist]
<div id="profile_main_actions">
<div class="button_friends button">
<button href="/" onClick="friends.add({user-id}); return false"><div>{translate=lang_180}</div></button>
</div></div>
[/blacklist][/no-friends][/privacy-friend]
<!--[yes-friends]<a href="/" onClick="friends.delet({user-id}, 1); return false"><div>{translate=lang_181}</div></a>[/yes-friends]--!>


<!--[blacklist]<a href="/"  onclick=" ask.add({user-id}); return false;">{translate=lang_841}</a>[/blacklist]-->
[blacklist][no-subscription]<a href="/" onClick="subscriptions.add({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">{translate=lang_182}<div class="my_menu">
<span class="profile_sub" style="margin-top: 0px;"></span>
</div></span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/no-subscription][/blacklist]
[yes-subscription]<a href="/" onClick="subscriptions.del({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">{translate=lang_183}<div class="my_menu">
<span class="profile_sub" style="margin-top: 0px;"></span>
</div></span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/yes-subscription]

[yes-friends]<a class="cursor_pointer" onClick="transmit.box('{user-id}')"><div>Передать голосов<div class="my_menu"><span class="profile_balance_act" style="margin-top:0px;"></span></div></div></a>[/yes-friends]

<div class="profile_top_sep"></div>

[subscr]<div class="menuleft"><a class="cursor_pointer" onClick="showUserSubcsr('{user-id}')">Подписчики {name}<div class="my_menu">{subscr-num}<span class="profile_sub" style="margin-top: 0px;"></span></div></a></div>
<div class="profile_top_sep"></div>
[/subscr]


<a href="/" onClick="gifts.box('{user-id}'); return false"><div>{translate=lang_184}<div class="my_menu"><span class="profile_gifts"></span></div></div></a>
<div style="border-bottom:5px solid #fff;"></div>
[/not-owner]
</div>

 [owner]

[subscr]<div class="menuleft"><a class="cursor_pointer" onClick="showUserSubcsr('{user-id}')">Мои подписчики<div class="my_menu">{subscr-num}<span class="profile_sub"></span></div></a></div>
[/subscr]
<div class="menuleft"><a href="/balance">Мой баланс <div class="my_menu">{ubm}<span class="profile_ubm" style="margin-top: 0px;"></span></div></a></div>
[gifts]<div class="menuleft"><a href="/gifts{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">Мои подарки <div class="my_menu">{gifts-top}<span class="profile_gifts"></span></div></a></div>
<div style="border-bottom:5px solid #fff;"></div>
[/gifts]
[all-rate]
<div style="margin-top:4px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
<tr>
<td style="border-top:0px solid #c0ccd9; background-color: #eeeeee;" height="16px" valign="middle" align="left">
<div  style="position:absolute; float:right; overflow:visible; color: #8BA1BC; width:200px; text-align:center; line-height:20px;cursor: default;margin-top:1px;">{translate=lang_843}: {rates}%</div>
<table width="{rates}%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background-color: #DEE5EB; color: #8BA1BC; font-weight:bold;" height="22px" valign="middle" align="right"></td>
</tr>
</table>
  </td>
</tr>
<tr><td height=4px></td></tr>
</table>
</div>

[all-foto]<div class="menuleft"><a href="owner_photo_bubble_action owner_photo_bubble_action_update" onClick="Profile.LoadPhoto(); $('.profileMenu').hide(); return false;" class="cursor_pointer2"><div id="rate_warning_photo" class="warning_row"></div><span style="margin-left:4px;">{translate=lang_283}</span> <div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-foto]

[all-country2]<div class="menuleft"><a href="/editmypage/contact" class="cursor_pointer2"><div id="rate_warning_card" class="warning_row"></div><span style="margin-left:4px;">{translate=lang_847}</span><div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-country2]

<!--[all-city2]<div class="menuleft"><a href="/editmypage/contact" class="cursor_pointer2">{translate=lang_845} <div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-city2]--!>

[all-interes]<div class="menuleft"><a href="/editmypage/interests" class="cursor_pointer2"><div id="rate_warning_inter" class="warning_row"></div><span style="margin-left:4px;">{translate=lang_846}</span> <div style="float:right;color: #8BA1BC;">+25%</div></a></div>[/all-interes]
<div class="clear"></div>
<div style="margin-top:4px;"></div>
[/all-rate]
[/owner]


<div class="leftcbor">


[privacy-gifts][gifts]<a href="/gifts{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="margin-top:5px"><span style="margin-left:0px;">{translate=lang_328}</span><div><span style="color: #8BA1BC;">{translate=lang_848}</span></div></div><div class="p_header_bottom">
    <span class="fl_r"></span>
    {gifts-text}
  </div><br><center>{gifts}</center><div class="clear"></div></a><br>[/gifts][/privacy-gifts]


[blacklist]

[owner]

[happy-friends]<div id="happyBLockSess"><div class="albtitle">{translate=lang_872} <span></span><div class="profile_happy_hide"><img src="{theme}/images/hide_lef.gif" onMouseOver="myhtml.title('1', '{translate=lang_873}', 'happy_block_')" id="happy_block_1" onClick="HappyFr.HideSess(); return false" /></div></div>
 <div class="newmesnobg profile_block_happy_friends" style="padding:0px;padding-top:10px;">{happy-friends}<div class="clear"></div></div>
 <div class="cursor_pointer no_display" onMouseDown="HappyFr.Show(); return false" id="happyAllLnk"><div class="public_wall_all_comm profile_block_happy_friends_lnk">{translate=lang_190}</div></div></div>
 [/happy-friends]
[/owner]

[common-friends]

<div class="module clear people_module" id="profile_friends">
  <a href="/friends/common/{user-id}" onClick="Page.Go(this.href); return false" class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_750}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {translate=lang_56}{mutual-num}
  </div>
</a>
<div id="common-friends" class="edit_hider_on fl_l" onclick="toggles('common-friends','common-friend')"></div>
 <div id="common-friend" class="newmesnobg" style="padding:0px;padding-top:10px;"> {mutual_friends}<div class="clear"></div>
 </div> </div><br> [/common-friends]

[friends]

<div class="module clear people_module" id="profile_friends">
 <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false" class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span class="right_link fl_r"  onmouseover="this.parentNode.parentNode.href='/news/updates'" onmouseout="this.parentNode.parentNode.href='/friends/{user-id}'"><span style="color: #8BA1BC;">{translate=lang_874}</span></span>
    <span style="margin-left:13px;">{translate=lang_875}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {translate=lang_56} {friends-num}
  </div>
</a>
<div id="friends1" class="edit_hider_on fl_l" onclick="toggles('friends1','dever')"></div>
 <div id="dever" class="newmesnobg" style="padding:0px;padding-top:10px;">{friends}<div class="clear"></div>
</div></div> [/friends]

[online-friends]

<div class="module clear people_module" id="profile_friends">
  <a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false"  class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_876}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {online-friends-num}
  </div>
</a>
<div id="friends2" class="edit_hider_on fl_l" onclick="toggles('friends2','online')"></div>
 <div id="online" class="newmesnobg" style="padding:0px;padding-top:10px;">{online-friends}<div class="clear"></div>
 </div> </div>[/online-friends]

 [privacy-group][groups]

<div class="module clear people_module" id="profile_friends">
  <a onClick="groups.all_groups_user('{user-id}')"  class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_194}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {groups-num}
  </div>
</a>
<div id="groups" class="edit_hider_on fl_l" onclick="toggles('groups','group')"></div>
 <div id="group" class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{groups}<div class="clear"></div>
 </div> </div>[/groups][/privacy-group]

[privacy-sub][subscriptions]

<div class="module clear people_module" id="profile_friends">
  <a href="/" onClick="subscriptions.all({user-id}, '', {subscriptions-num}); return false" class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_193}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {subscriptions-num}
  </div>
</a>
<div id="subscriptions" class="edit_hider_on fl_l" onclick="toggles('subscriptions','subscription')"></div>
 <div id="subscription" class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{subscriptions}<div class="clear"></div>
 </div></div>[/subscriptions][/privacy-sub]

[albums]

<div class="module clear people_module" id="profile_friends">
  <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false"  class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_209}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {translate=lang_238} {albums-num}
  </div>
</a>
<div id="albums" class="edit_hider_on fl_l" onclick="toggles('albums','album')"></div>
<div id="album">{albums}</div><div class="clear"></div></div>
 [/albums]

[videos]
<div class="module clear people_module" id="profile_friends">
  <a href="/videos/{user-id}" onClick="Page.Go(this.href); return false"  class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_877}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {translate=lang_238} {videos-num}
  </div>
</a>
<div id="videos" class="edit_hider_on fl_l" onclick="toggles('videos','video')"></div>
 <div id="video" class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{videos}<div class="clear"></div></div></div>
[/videos]


[privacy-audios][audios]<div id="jquery_jplayer"></div><input type="hidden" id="teck_id" value="1" /><a href="/audio{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="margin-top:0px">{translate=lang_413}</div></a>
<div class="p_header_bottom">
    <span class="fl_r"></span>
 {audios-num}<div class="player_progreebar fl_r cursor_pointer" style="width:60px;margin-left:10px;" id="player_volume_bar" onClick="music.volume()">
  <div id="player_volume_bar_value" onClick="music.volume()"></div>
 </div> 
  </div>{audios}<div class="clear"></div>[/audios][/privacy-audios]

[notes]
<div class="module clear people_module" id="profile_friends">
  <a href="/notes/{user-id}" onClick="Page.Go(this.href); return false"  class="module_header" style="text-decoration:none">
  <div class="header_top clear_fix">
    <span style="margin-left:13px;">{translate=lang_123}</span>
  </div>
  <div class="p_header_bottom">
    <span class="fl_r"></span>
    {translate=lang_238} {notes-num}
  </div>
</a>
<div id="notes" class="edit_hider_on fl_l" onclick="toggles('notes','note')"></div>
 <div id="note" class="newmesnobg" style="padding-right:0px;padding-left:3px">{notes}<div class="clear"></div>
 </div></div>[/notes]


[not-owner]
<div class="menuleft" style="margin-top:14px">
<div id="profile_bottom_actions">
[no-fave]<a href="/" onClick="fave.add({user-id},1); return false" id="addfave_but"><div><span id="text_add_fave">{translate=lang_185}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/no-fave]
[yes-fave]<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but"><div><span id="text_add_fave">{translate=lang_186}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/yes-fave]
[no-blacklist]<a href="/" onClick="settings.addblacklist({user-id}); return false" id="addblacklist_but"><div><span id="text_add_blacklist">{translate=lang_187} {name}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/no-blacklist]
[yes-blacklist]<a href="/" onClick="settings.delblacklist({user-id}, 1); return false" id="addblacklist_but"><div><span id="text_add_blacklist">{translate=lang_188} {name}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/yes-blacklist]
</div>
</div>
[/not-owner]

<div class="clear"></div>
<span id="fortoAutoSizeStyleProfile"></span>
</div>[/blacklist]
</div>


<div class="profiewr" style="width:485px;">
 [owner]<div class="set_status_bg no_display" id="set_status_bg">
  <input type="text" id="status_text" class="status_inp" value="{val-status-text}" style="width:462px;" maxlength="255" onKeyPress="if(event.keyCode == 13)gStatus.set()" />
  <div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]">{translate=lang_197}</span><a href="/" class="yes_status_text [no-status]no_display[/no-status]" onClick="gStatus.set(1); return false">{translate=lang_417}</a></div>
  [status]<div class="button_div_gray fl_r status_but margin_left"><button>{translate=lang_199}</button></div>[/status]
  <div class="button_div fl_r status_but"><button id="status_but" onClick="gStatus.set()">{translate=lang_92}</button></div>
 </div>[/owner]
<div class="up_profile"[owner]style="margin-top: 0px;"[/owner]">{name} {lastname}[dev]({dev})[/dev] <!--{otcestvo}--!> {user_real} <span style="float:right;">{online} [all-mobile]{mobile}[/all-mobile]</span></div>
 <div class="status" style="width:485px;">
  <div>
   [player-link]<a class="cursor_pointer" onClick="doLoad.js(0); $('#audioPlayer').html(''); player.open(0, 0, {aid});">[/player-link]
   [owner]<a href="/" id="new_status" onClick="gStatus.open(); return false">[/owner]
   [blacklist]{status-text}[/blacklist]
   [owner]</a>[/owner]
   [player-link]</a>[/player-link]
  </div>

   [owner]<span id="tellBlockPos"></span>
  <div class="status_tell_friends no_display">
   <div class="status_str"></div>
   <div class="html_checkbox" id="tell_friends" onClick="myhtml.checkbox(this.id); gStatus.startTell()">{translate=lang_201}</div>
  </div>[/owner]
  [owner]<a href="#" onClick="gStatus.open(); return false" id="status_link" [status]class="no_display"[/status]>{translate=lang_878}</a>[/owner]
</div>

 <div style="min-height:0px">
 [blacklist][not-all-birthday]<div class="flpodtext">{translate=lang_11}:</div> <div class="flpodinfo">{birth-day}</div>[/not-all-birthday]
 [blacklist][not-all-birthday]<div class="flpodtext">{translate=lang_879}:</div> <div class="flpodinfo">{zodiak}</div>[/not-all-birthday]
 [privacy-info][hometown]<div class="flpodtext">{translate=lang_982}:</div><div class="flpodinfo"><a href="/?go=search&hometown={hometown}" onClick="Page.Go(this.href); return false">{hometown}</a></div>[/hometown]
 [privacy-info][sp]<div class="flpodtext">{translate=lang_73}:</div> <div class="flpodinfo">{sp}</div>[/sp]
[grandparents]<div class="flpodtext">{translate=lang_977}:</div> <div class="flpodinfo">{grandparents}</div>[/grandparents]
[parents]<div class="flpodtext">{translate=lang_978}:</div> <div class="flpodinfo">{parents}</div>[/parents]
[siblings]<div class="flpodtext">{translate=lang_979}:</div> <div class="flpodinfo">{siblings}</div>[/siblings]
[children]<div class="flpodtext">{translate=lang_980}:</div> <div class="flpodinfo">{children}</div>[/children]
[grandchildren]<div class="flpodtext">{translate=lang_981}:</div> <div class="flpodinfo">{grandchildren}</div>[/grandchildren]

</div>[/privacy-info]
 [privacy-info]<div class="cursor_pointer" onClick="Profile.MoreInfo(); return false" id="moreInfoLnk"><div class="public_wall_all_comm profile_hide_opne" id="moreInfoText" style="width:467px">{translate=lang_203}</div></div>
 <div id="moreInfo" class="no_display">[/privacy-info]
 [privacy-info][not-block-contact]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_204} [owner]<span><a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div>
 [not-all-country]<div class="flpodtext">{translate=lang_90}:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}" onClick="Page.Go(this.href); return false">{country}</a></div>[/not-all-country]
 [not-all-city]<div class="flpodtext">{translate=lang_91}:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}&city={city-id}" onClick="Page.Go(this.href); return false">{city}</a></div>[/not-all-city]
 [rai]<div class="flpodtext">{translate=lang_880}:</div> <div class="flpodinfo"><a href="/?go=search&rai={rai}" onClick="Page.Go(this.href); return false">{rai}</a></div>[/rai]
 [metro]<div class="flpodtext">{translate=lang_881}:</div> <div class="flpodinfo"><a href="/?go=search&metro={metro}" onClick="Page.Go(this.href); return false">{metro}</a></div>[/metro]
 [ulica]<div class="flpodtext">{translate=lang_882}:</div> <div class="flpodinfo"><a href="/?go=search&ulica={ulica}" onClick="Page.Go(this.href); return false">{ulica}</a></div>[/ulica]
 [nazvanie]<div class="flpodtext">{translate=lang_883}:</div> <div class="flpodinfo"><a href="/?go=search&nazvanie={nazvanie}" onClick="Page.Go(this.href); return false">{nazvanie}</a></div>[/nazvanie]
 [not-contact-phone]<div class="flpodtext">{translate=lang_206}:</div> <div class="flpodinfo">{phone}</div>[/not-contact-phone]
 [not-contact-vk]<div class="flpodtext">{translate=lang_97}:</div> <div class="flpodinfo">{vk}</div>[/not-contact-vk]
 [not-contact-od]<div class="flpodtext">{translate=lang_98}:</div> <div class="flpodinfo">{od}</div>[/not-contact-od]
 [not-contact-fb]<div class="flpodtext">Facebook:</div> <div class="flpodinfo">{fb}</div>[/not-contact-fb]
 [not-contact-skype]<div class="flpodtext">Skype:</div> <div class="flpodinfo"><a href="skype:{skype}">{skype}</a></div>[/not-contact-skype]
 [not-contact-icq]<div class="flpodtext">ICQ:</div> <div class="flpodinfo">{icq}</div>[/not-contact-icq]
 [not-contact-site]<div class="flpodtext">{translate=lang_207}:</div> <div class="flpodinfo">{site}</div>[/not-contact-site][/not-block-contact]
 
 [interests]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_208} [owner]<span><a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div>
 [activity]<div class="flpodtext">{translate=lang_100}:</div> <div class="flpodinfo">{activity}</div>[/activity]
 [interes]<div class="flpodtext">{translate=lang_69}:</div> <div class="flpodinfo"><a href="/?go=search&interes={interes}" onClick="Page.Go(this.href); return false">{interes}</a></div>[/interes]
 [music]<div class="flpodtext">{translate=lang_101}:</div> <div class="flpodinfo"><a href="/?go=search&music={music}" onClick="Page.Go(this.href); return false">{music}</a></div>[/music]
 [kino]<div class="flpodtext">{translate=lang_102}:</div><div class="flpodinfo"><a href="/?go=search&kino={kino}" onClick="Page.Go(this.href); return false">{kino}</a></div>[/kino]
 [shou]<div class="flpodtext">{translate=lang_884}:</div> <div class="flpodinfo"><a href="/?go=search&shou={shou}" onClick="Page.Go(this.href); return false">{shou}</a></div>[/shou]
 [serial]<div class="flpodtext">{translate=lang_885}:</div> <div class="flpodinfo"><a href="/?go=search&serial={serial}" onClick="Page.Go(this.href); return false">{serial}</a></div>[/serial]
 [books]<div class="flpodtext">{translate=lang_103}:</div> <div class="flpodinfo"><a href="/?go=search&books={books}" onClick="Page.Go(this.href); return false">{books}</a></div>[/books]
 [games]<div class="flpodtext">{translate=lang_104}:</div> <div class="flpodinfo"><a href="/?go=search&games={games}" onClick="Page.Go(this.href); return false">{games}</a></div>[/games]
 [quote]<div class="flpodtext">{translate=lang_105}:</div> <div class="flpodinfo">{quote}</div>[/quote]
 [myinfo]<div class="flpodtext">{translate=lang_106}:</div> <div class="flpodinfo"><a href="/?go=search&myinfo={myinfo}" onClick="Page.Go(this.href); return false">{myinfo}</a></div>[/myinfo]
 [/interests]

 [privacy-group][groups]
<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_886} </div></div>

<div class="group_in_info">

<div class="flpodtext">{translate=lang_121}:</div> <div class="flpodinfo">{groups_info}</div>
</div>
[/groups][/privacy-group]
 
 [education]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_887} [owner]<span><a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div> 
   [countrysr]<div class="flpodtext">{translate=lang_90}:</div> <div class="flpodinfo">{countrysr}</div>[/countrysr]
   [citysr]<div class="flpodtext">{translate=lang_91}:</div> <div class="flpodinfo">{citysr}</div>[/citysr]
   [shkola]<div class="flpodtext">{translate=lang_888}:</div> <div class="flpodinfo"><a href="/?go=search&shkola={shkola}" onClick="Page.Go(this.href); return false">{shkola}</a></div>[/shkola]
   [nacalosr]<div class="flpodtext">{translate=lang_889}:</div> <div class="flpodinfo">{nacalosr}</div>[/nacalosr]
   [konecsr]<div class="flpodtext">{translate=lang_890}:</div> <div class="flpodinfo">{konecsr}</div>[/konecsr]
   [datasr]<div class="flpodtext">{translate=lang_891}:</div> <div class="flpodinfo">{datasr}</div>[/datasr]
   [klass]<div class="flpodtext">{translate=lang_892}:</div> <div class="flpodinfo">{klass}</div>[/klass]
   [spec]<div class="flpodtext">{translate=lang_893}:</div> <div class="flpodinfo"><a href="/?go=search&spec={spec}" onClick="Page.Go(this.href); return false">{spec}</a></div>[/spec]
 [/education]
[higher_education]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_923} [owner]<span><a href="/editmypage/higher_education" onClick="Page.Go(this.href); return false;"><i class="icon-pencil-1"></i>{translate=lang_34}</a></span>[/owner]</div></div> 
[countryvi]<div class="flpodtext">{translate=lang_90}:</div> <div class="flpodinfo">{countryvi}</div>[/countryvi]
   [cityvi]<div class="flpodtext">{translate=lang_91}:</div> <div class="flpodinfo">{cityvi}</div>[/cityvi]
   [vuz]<div class="flpodtext">{translate=lang_894}:</div> <div class="flpodinfo"><a href="/?go=search&vuz={vuz}" onClick="Page.Go(this.href); return false">{vuz}</a></div>[/vuz]
   [fac]<div class="flpodtext">{translate=lang_895}:</div> <div class="flpodinfo"><a href="/?go=search&fac={fac}" onClick="Page.Go(this.href); return false">{fac}</a></div>[/fac]
   [form]<div class="flpodtext">{translate=lang_896}:</div> <div class="flpodinfo">{form}</div>[/form]
   [statusvi]<div class="flpodtext">{translate=lang_897}:</div> <div class="flpodinfo">{statusvi}</div>[/statusvi]
   [datavi]<div class="flpodtext">{translate=lang_891}:</div> <div class="flpodinfo">{datavi}</div>[/datavi]
 [/higher_education]
  
 [career]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_898} [owner]<span><a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div> 
   [countryca]<div class="flpodtext">{translate=lang_90}:</div> <div class="flpodinfo">{countryca}</div>[/countryca]
   [cityca]<div class="flpodtext">{translate=lang_91}:</div> <div class="flpodinfo">{cityca}</div>[/cityca]
   [mesto]<div class="flpodtext">{translate=lang_899}:</div> <div class="flpodinfo"><a href="/?go=search&mesto={mesto}" onClick="Page.Go(this.href); return false">{mesto}</a></div>[/mesto]
   [nacaloca]<div class="flpodtext">{translate=lang_900}:</div> <div class="flpodinfo">{nacaloca}</div>[/nacaloca]
   [konecca]<div class="flpodtext">{translate=lang_901}:</div> <div class="flpodinfo">{konecca}</div>[/konecca]
   [dolj]<div class="flpodtext">{translate=lang_902}:</div> <div class="flpodinfo"><a href="/?go=search&dolj={dolj}" onClick="Page.Go(this.href); return false">{dolj}</a></div>[/dolj][/career]
 
 [military]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_903} [owner]<span><a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div> 
   [countrysl]<div class="flpodtext">{translate=lang_90}:</div> <div class="flpodinfo">{countrysl}</div>[/countrysl]
   [citysl]<div class="flpodtext">{translate=lang_91}:</div> <div class="flpodinfo">{citysl}</div>[/citysl]
   [chast]<div class="flpodtext">{translate=lang_904}:</div> <div class="flpodinfo"><a href="/?go=search&chast={chast}" onClick="Page.Go(this.href); return false">{chast}</a></div>[/chast]
   [zvanie]<div class="flpodtext">{translate=lang_905}:</div> <div class="flpodinfo"><a href="/?go=search&zvanie={zvanie}" onClick="Page.Go(this.href); return false">{zvanie}</a></div>[/zvanie]
   [nacalosl]<div class="flpodtext">{translate=lang_906}:</div> <div class="flpodinfo">{nacalosl}</div>[/nacalosl]
   [konecsl]<div class="flpodtext">{translate=lang_907}:</div> <div class="flpodinfo">{konecsl}</div>[/konecsl][/military]
 
  [personal]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>{translate=lang_908} [owner]<span><a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_34}</a></span>[/owner]</div></div> 
   [pred]<div class="flpodtext">{translate=lang_909}:</div> <div class="flpodinfo">{pred}</div>[/pred]
   [miro]<div class="flpodtext">{translate=lang_910}:</div> <div class="flpodinfo"><a href="/?go=search&miro={miro}" onClick="Page.Go(this.href); return false">{miro}</a></div>[/miro]
   [jizn]<div class="flpodtext">{translate=lang_911}:</div> <div class="flpodinfo">{jizn}</div>[/jizn]
   [ludi]<div class="flpodtext">{translate=lang_912}:</div> <div class="flpodinfo">{ludi}</div>[/ludi]
   [kurenie]<div class="flpodtext">{translate=lang_913}:</div> <div class="flpodinfo">{kurenie}</div>[/kurenie]
   [alkogol]<div class="flpodtext">{translate=lang_914}:</div> <div class="flpodinfo">{alkogol}</div>[/alkogol]
   [narkotiki]<div class="flpodtext">{translate=lang_915}:</div> <div class="flpodinfo">{narkotiki}</div>[/narkotiki]
   [vdox]<div class="flpodtext">{translate=lang_916}:</div> <div class="flpodinfo">{vdox}</div>[/vdox]
 [/personal]
 
[/privacy-info]
</div>


 [photos]
 <div class="module clear people_module" id="profile_friends">
 <a style="text-decoration: none;" href="/albums/{user-id}" onclick="Page.Go(this.href); return false"><div class="albtitle_wall" style="margin-top:5px"><span style="color: #45688E;"><span style="margin-left:0px;">{translate=lang_384}</span></span></a><a href="" onClick="otherbox.awayphoto(); $('.profileMenu').hide(); return false;" style="color: #8BA1BC;float:right;text-decoration:none;">{translate=lang_917}</a></div>
<div class="p_header_bottom">
    <span class="fl_r"></span>
<span style="color: #666666;text-decoration:none;"> {translate=lang_56} {photos_num}</span>
<div id="my_photos" onclick="toggles('my_photos','my_photo')"></div>
  </div><div id="my_photo" class="" style="margin-top:5px;margin-left:7px;"><center>{photos_view_albums}</center></div><div class="clear"></div></div>[/photos]

<div style=margin-bottom:8px;"></div>

[privacy-view][not-owner]
<div class="albtitle_wall" style="border-bottom:0px">{translate=lang_918}</div>


<div class="newmes" id="opblock" style="border-bottom:0px;margin-bottom:5px">

<input type="text" class="wall_opition" value="{translate=lang_919}" onmousedown="opinion.form_open(); return false" id="opinput" style="margin: 0px;">
<div id="opniz" style="display:none;">
   <textarea class="wall_opition wall_fast_opened_texta" onkeypress="if(event.keyCode == 10 || (event.keyCode == 13)) opinion.send('{user-id}')" style="width:459px;resize:none;" id="opmsg" onblur="opinion.form_close()">{translate=lang_919}</textarea>
<div class="button_div fl_l" style="margin:10px;margin-left: 0px;"><button onclick="opinion.send('{user-id}'); return false" id="opbtn">{translate=lang_32}</button></div>
<div class="html_checkbox" style="margin-top:15px;" id="optype" onclick="myhtml.checkbox(this.id)" style="margin-bottom:8px;">{translate=lang_920}</div>
</div> 
  <div class="clear"></div>
 </div>
[/not-owner][/privacy-view]
<a href="/wall{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle_wall">{rec-num}<span style="float:right;color: #8BA1BC;">{translate=lang_921}</span></div></a>
 [privacy-wall]<div class="newmes" id="wall_tab" style="border-bottom:0px;margin-bottom:-5px">

  <input type="hidden" value="[owner]{translate=lang_210}[/owner][not-owner]{translate=lang_211}[/not-owner]" id="wall_input_text" />
  <input type="text" class="wall_inpst" value="[owner]{translate=lang_210}[/owner][not-owner]{translate=lang_211}[/not-owner]" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px;width:459px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_inpst wall_fast_opened_texta" style="width:459px"
    onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) wall.send();')"
	onKeyUp="wall.CheckLinkText(this.value)"
	onBlur="wall.CheckLinkText(this.value, 1)"
   >
   </textarea>
   <div id="attach_files" class="margin_top_10 no_display"></div>
   <div id="attach_block_lnk" class="no_display clear">
   <div class="attach_link_bg">
    <div align="center" id="loading_att_lnk"><img src="{theme}/images/loading_mini.gif" style="margin-bottom:-2px" /></div>
    <img src="" align="left" id="attatch_link_img" class="no_display cursor_pointer" onClick="wall.UrlNextImg()" />
	<div id="attatch_link_title"></div>
	<div id="attatch_link_descr"></div>
	<div class="clear"></div>
   </div>
   <div class="attach_toolip_but"></div>
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', '{translate=lang_213}', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
   <input type="hidden" id="attach_lnk_stared" />
   <input type="hidden" id="teck_link_attach" />
   <span id="urlParseImgs" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <div id="attach_block_vote" class="no_display">
   <div class="attach_link_bg">
	<div class="texta">{translate=lang_214}:</div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" 
		onKeyUp="$('#attatch_vote_title').text(this.value)"
	/><div class="mgclr"></div>
	<div class="texta">{translate=lang_215}:<br /><small><span id="addNewAnswer"><a class="cursor_pointer" onClick="Votes.AddInp()">{translate=lang_216}</a></span> | <span id="addDelAnswer">{translate=lang_217}</span></small></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
	<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
	<div id="addAnswerInp"></div>
	<div class="clear"></div>
   </div>
   <div class="attach_toolip_but"></div>
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">{translate=lang_218}: <a id="attatch_vote_title" style="text-decoration:none;cursor:default"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', '{translate=lang_213}', 'attach_vote_')" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div>
   <input type="hidden" id="answerNum" value="2" />
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files" type="hidden" />
   <input id="fid" value="{user-id}" type="hidden" />
   <div class="clear"></div>
   <div class="button_div fl_l margin_top_10"><button onClick="wall.send(); return false" id="wall_send">{translate=lang_502}</button></div>
   <div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach">{translate=lang_219}</div>
   <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu" style="margin-left:368px">
    <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addphoto()">{translate=lang_221}</div>
    <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo()">{translate=lang_222}</div>
    <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addaudio()">{translate=lang_223}</div>
    <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addgraffiti('{user-id}')">{translate=lang_922}</div>
    <div class="wall_attach_icon_doc" id="wall_attach_link" onClick="wall.attach_addDoc()">{translate=lang_224}</div>
    <div class="wall_attach_icon_vote" id="wall_attach_link" onClick="$('#attach_block_vote').slideDown('fast');wall.attach_menu('close', 'wall_attach', 'wall_attach_menu');$('#vote_title').focus();$('#vaLattach_files').val($('#vaLattach_files').val()+'vote|start||')">{translate=lang_218}</div>
   </div>
  </div>
  <div class="clear"></div>
 </div>[/privacy-wall]
 <div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>{translate=wall_no_rec}</div>[/no-records]</div>
 [wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">{translate=lang_226}</div></div>[/wall-link][/blacklist]
 [not-blacklist]<div class="err_yellow" style="font-weight:normal;margin-top:5px">{name} {translate=lang_227}</div>[/not-blacklist]
</div>
<div class="clear"></div>
[owner]<div id="myLink">Ссылка на мою страницу:<a>Onepuls.ru/u{user-id}</a></div>[/owner]