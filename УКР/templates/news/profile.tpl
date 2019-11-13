{url_img}
<script type="text/javascript">[after-reg]Profile.LoadPhoto();[/after-reg]
var startResizeCss = false;
var user_id = '{user-id}';
$(document).ready(function(){
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
				$('body').append('<div id="addStyleClass"><style type="text/css" media="all">.wallrecord{width:695px;margin-left:-210px}.infowalltext_f{font-size:11px}.wall_inpst{width:613px}.public_likes_user_block{margin-left:540px}.wall_fast_opened_form{width:623px;margin-left:-150px}.wall_fast_block{width:619px;margin-top:2px;margin-left:-150px}.public_wall_all_comm{width:617px;margin-top:2px;margin-bottom:5px}.player_mini_mbar_wall{width:636px;margin-bottom:0px}#audioForSize{min-width:636px}.wall_rec_autoresize{width:635px}.wall_fast_ava img{width:50px}.wall_fast_ava{width:60px}.wall_fast_comment_text{margin-left:57px}.wall_fast_date{margin-left:57px;font-size:11px}.public_wall_all_comm{margin-left:-150px}.size10{font-size:11px}.wall_upgwi{width:825px;margin-left:-210px}.public_like_strelka {height: 9px; margin-left: 19px;margin-top: -4px;position: absolute;width: 120px}.public_likes_user_block {margin-left: 523px}</style></div>');
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
  <div class="cover_addut cover_hidded_but" onClick="cover.cancel('{cover-pos}')">Отмена</div>
  <div class="cover_addut cover_hidded_but" onClick="cover.del()">Удалить</div>
  <div class="cover_addut {cover-param-2}" id="upload_cover">Добавить обложку</div>
  <div class="cover_addut cover_hidded_but" onClick="cover.save()">Сохранить</div>
  <div id="cover_addut_edit" class="no_display"><div class="cover_addut_edit {cover-param}" onClick="cover.startedit('{cover}', '{cover-height}')">Редактировать обложку</div></div>
  </div>
  <div class="cover_loaddef_bg {cover-param}" {cover-param-4}>
   <div class="cover_descring {cover-param-2}">Обложку можно двигать по высоте</div>
   <div id="les10_ex2" {cover-param-5}><img src="{cover}" width="800" id="cover_img" /></div>
   <div id="cover_restart"></div>
  </div>
 </div>
</div>
[/owner]
[not-owner][cover]<div class="cover_all_user"><img src="{cover}" width="800" id="cover_img" {cover-param-5} /></div>[/cover][/not-owner]


<div class="ava">
    <div id="owner_photo_wrap">
   [owner] <div id="owner_photo_top_bubble_wrap">
  <div id="owner_photo_top_bubble">
    <div class="owner_photo_bubble_delete_wrap"onClick="Profile.DelPhoto(); $('.profileMenu').hide(); return false;" id="del_pho_but" {display-ava}>
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
  <span class="owner_photo_bubble_action_in">Загрузить новую фотографию</span>
</div>

<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onClick="Profile.miniature(); return false;">
 <span class="owner_photo_bubble_action_in">Изменить миниатюру</span>
</div>
</div>
  </div>  [/owner]
  </div></div>

{rating}

[not-owner]
[blacklist][privacy-msg]
<div id="profile_main_actions">
<div class="button_blue button">
<button id="sending" onClick="messages.new_({user-id}); return false">Отправить сообщение</button>
[yes-friends]<br>
<div class="friend_status">Пользователь у вас в друзьях</div>[/yes-friends]
</div></div>
[/privacy-msg][/blacklist]
[/not-owner]


<div class="menuleft" style="margin-top:4px">
[owner]
<a href="/" onClick="znachok.box({user-id},1); return false"><div>Прикрепить значок</div></a>
<a class="fm_none_href" onclick="doLoad.data(1); fon.addbox()"><div>Облик Onepuls</div></a>

<div class="profile_top_sep"></div>
[/owner]

[not-owner]
[no-friends][blacklist]<a href="/" onClick="friends.add({user-id}); return false"><div>Добавить в друзья</div></a>[/blacklist][/no-friends]
[yes-friends]<a href="/" onClick="friends.delet({user-id}, 1); return false"><div>Убрать из друзей</div></a>[/yes-friends]
[blacklist]<a href="/"  onclick=" ask.add({user-id}); return false;">Задать вопрос</a>[/blacklist]
[blacklist][no-subscription]<a href="/" onClick="subscriptions.add({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">Подписаться на обновления</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/no-subscription][/blacklist]
[yes-subscription]<a href="/" onClick="subscriptions.del({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">Отписаться от обновлений</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/yes-subscription]
<div style="border-bottom:5px solid #fff;"></div>
[/not-owner]
</div>

 [owner]

<div class="menuleft"><a href="/" onClick="subscriptions.fall({user-id}); return false">Мои подписчики <div class="my_menu">{sub-num}</div></a></div>
<div style="border-bottom:0px solid #fff;"></div>

<div class="menuleft"><a href="guests">Мои посетители <div class="my_menu">{sub-num}</div></a></div>
<div style="border-bottom:0px solid #fff;"></div>

[all-rate]
<div style="margin-top:4px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
<tr>
<td style="border-top:0px solid #c0ccd9; background-color: #eeeeee;" height="16px" valign="middle" align="left">
<div  style="position:absolute; float:right; overflow:visible; color: #8BA1BC; width:200px; text-align:center; line-height:20px;cursor: default;">Профиль заполнен на: {rates}%</div>
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

[all-foto]<div class="menuleft"><a href="owner_photo_bubble_action owner_photo_bubble_action_update" onClick="Profile.LoadPhoto(); $('.profileMenu').hide(); return false;" class="cursor_pointer2">Добавить фото <div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-foto]

[all-country2]<div class="menuleft"><a href="/editmypage" class="cursor_pointer2">Добавить cтрану <div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-country2]

[all-city2]<div class="menuleft"><a href="/editmypage" class="cursor_pointer2">Добавить город <div style="float:right;color: #8BA1BC;">+20%</div></a></div>[/all-city2]

[all-contact]<div class="menuleft"><a href="/editmypage/contact" class="cursor_pointer2">Заполнить контакты <div style="float:right;color: #8BA1BC;">+15%</div></a></div>[/all-contact]

[all-interes]<div class="menuleft"><a href="/editmypage/interests" class="cursor_pointer2">Рассказать о себе <div style="float:right;color: #8BA1BC;">+25%</div></a></div>[/all-interes]
<div class="clear"></div>
<div style="margin-top:4px;"></div>
[/all-rate]
[/owner]


<div class="leftcbor">
 [owner]
[privacy-gifts][gifts]<a href="/gifts{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="margin-top:0px">{gifts-text}<div><div id="newBBlockl9" class="mono_ico_gifts" onmouseover="myhtml.title('9', 'Показать все подарки', 'newBBlockl')"></div></div></div><center>{gifts}</center><div class="clear"></div></a>[/gifts][/privacy-gifts]
 [/owner]

[not-owner]
[privacy-gifts][gifts]<a href="/" onClick="gifts.box('{user-id}', '1', '1'); return false" style="text-decoration:none"><div class="albtitle" style="margin-top:0px">{gifts-text}<div><div id="newBBlockl9" class="mono_ico_gifts" onmouseover="myhtml.title('9', 'Отправить подарок', 'newBBlockl')"></div></div></div><center>{gifts}</center><div class="clear"></div></a>[/gifts][/privacy-gifts]
[/not-owner]

[blacklist]

[owner][activate]
<div id="happyBLockSess"><div class="albtitle">Активация профиля</div>
<div class="newmesnobg" style="padding:0px;padding-top:10px;"></div>
 <div class="err_red pass_errors">{activate}</div>
 <div class="" onMouseDown="HappyFr.Show(); return false" id="happyAllLnk"></div></div>[/activate]


[happy-friends]<div id="happyBLockSess"><div class="albtitle">Дни рождения друзей <span></span><div class="profile_happy_hide"><img src="{theme}/images/hide_lef.gif" onMouseOver="myhtml.title('1', 'Скрыть', 'happy_block_')" id="happy_block_1" onClick="HappyFr.HideSess(); return false" /></div></div>
 <div class="newmesnobg profile_block_happy_friends" style="padding:0px;padding-top:10px;">{happy-friends}<div class="clear"></div></div>
 <div class="cursor_pointer no_display" onMouseDown="HappyFr.Show(); return false" id="happyAllLnk"><div class="public_wall_all_comm profile_block_happy_friends_lnk">Показать все</div></div></div>
 [/happy-friends]
[/owner]

[common-friends]<a href="/friends/common/{user-id}" style="text-decoration:none" onClick="Page.Go(this.href); return false"><div class="albtitle">Общие друзья <span>{mutual-num}</span></div></a>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{mutual_friends}<div class="clear"></div>
 </div>[/common-friends]

[friends]
<div class="albtitle cursor_pointer" onClick="Page.Go('/friends/{user-id}')">{friends-num} <div class="mono_ico"onMouseOver="myhtml.title('1', 'Показать всех друзей', 'newBBlockl')" id="newBBlockl1"></div></div>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{friends}<div class="clear"></div>
 </div>[/friends]

 [online-friends]<div class="albtitle">{online-friends-num}
<a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false"><div class="mono_ico_frOnline" onmouseover="myhtml.title('2', 'Показать всех друзей на сайте', 'newBBlockl')" id="newBBlockl2"></div> </a>
</div>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{online-friends}<div class="clear"></div>
 </div>[/online-friends]
 [privacy-group][groups]<div class="albtitle cursor_pointer" onClick="groups.all_groups_user('{user-id}')">{groups-num}<div class="mono_ico_groups" onmouseover="myhtml.title('4', 'Показать все интересные страницы', 'newBBlockl')" id="newBBlockl4"></div>
</div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{groups}<div class="clear"></div>
 </div>[/groups][/privacy-group]

 [privacy-sub][subscriptions]<div class="albtitle">{subscriptions-num}<a href="/" onClick="subscriptions.all({user-id}, '', {subsc-num}); return false"><div class="mono_ico_subscr" onmouseover="myhtml.title('3', 'Показать всех интересных людей', 'newBBlockl')" id="newBBlockl3"></div></div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{subscriptions}<div class="clear"></div>
 </div>[/subscriptions][/privacy-sub]

[albums]<a href="/albums/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="margin-bottom:10px">Альбомы <span>{albums-num}</span>
<div class="mono_ico_albums" onmouseover="myhtml.title('7', 'Показать все альбомы', 'newBBlockl')" id="newBBlockl7"></div></div></a>{albums}<div class="clear"></div>[/albums]

[videos]<div class="albtitle"><span>{videos-num}</span><a href="/videos/{user-id}" onClick="Page.Go(this.href); return false"><div class="mono_ico_videos" onmouseover="myhtml.title('5', 'Показать все видеозаписи', 'newBBlockl')" id="newBBlockl5"></div></a></div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{videos}<div class="clear"></div>
 </div>[/videos]

 [notes]<div class="albtitle"><span>{notes-num}</span><a href="/notes/{user-id}" onClick="Page.Go(this.href); return false"><div class="mono_ico_notes" onmouseover="myhtml.title('6', 'Показать все заметки', 'newBBlockl')" id="newBBlockl6"></div></div>
 <div class="newmesnobg" style="padding-right:0px;padding-left:5px">{notes}<div class="clear"></div>
 </div>[/notes]

[not-owner]
<div class="menuleft" style="margin-top:14px">
<div id="profile_bottom_actions">
[no-fave]<a href="/" onClick="fave.add({user-id}); return false" id="addfave_but"><div><span id="text_add_fave">Добавить в закладки</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/no-fave]
[yes-fave]<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but"><div><span id="text_add_fave">Удалить из закладок</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/yes-fave]
[no-blacklist]<a href="/" onClick="settings.addblacklist({user-id}); return false" id="addblacklist_but"><div><span id="text_add_blacklist">Заблокировать</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/no-blacklist]
[yes-blacklist]<a href="/" onClick="settings.delblacklist({user-id}, 1); return false" id="addblacklist_but"><div><span id="text_add_blacklist">Разблокировать</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/yes-blacklist]
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
  <div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]">Введите здесь текст Вашего статуса.</span><a href="/" class="yes_status_text [no-status]no_display[/no-status]" onClick="gStatus.set(1); return false">Удалить статус</a></div>
  [status]<div class="button_div_gray fl_r status_but margin_left"><button>Отмена</button></div>[/status]
  <div class="button_div fl_r status_but"><button id="status_but" onClick="gStatus.set()">Сохранить</button></div>
 </div>[/owner]
 <div class="titleu">{name} {lastname}[dev]({dev})[/dev] {otcestvo} {user_real}<span class="online_head">{online} [all-mobile]{mobile}[/all-mobile]</span></div>
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
   <div class="html_checkbox" id="tell_friends" onClick="myhtml.checkbox(this.id); gStatus.startTell()">Рассказать друзьям</div>
  </div>[/owner]
  [owner]<a href="#" onClick="gStatus.open(); return false" id="status_link" [status]class="no_display"[/status]>Установить статус</a>[/owner]
</div>

 <div style="min-height:50px">
 [blacklist][not-all-birthday]<div class="flpodtext">День рождения:</div> <div class="flpodinfo">{birth-day}</div>[/not-all-birthday]
 [blacklist][not-all-birthday]<div class="flpodtext">Знак зодиака:</div> <div class="flpodinfo">{zodiak}</div>[/not-all-birthday]
 [privacy-info][sp]<div class="flpodtext">Семейное положение:</div> <div class="flpodinfo">{sp}</div>[/sp]
[/privacy-info]
</div>
 <div class="cursor_pointer" onClick="Profile.MoreInfo(); return false" id="moreInfoLnk"><div class="public_wall_all_comm profile_hide_opne" id="moreInfoText" style="width:467px">Показать подробную информацию</div></div>
 <div id="moreInfo" class="no_display">
 [privacy-info][not-block-contact]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Контактная информация [owner]<span><a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div>
 [not-all-country]<div class="flpodtext">Страна:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}" onClick="Page.Go(this.href); return false">{country}</a></div>[/not-all-country]
 [not-all-city]<div class="flpodtext">Город:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}&city={city-id}" onClick="Page.Go(this.href); return false">{city}</a></div>[/not-all-city]
 [rai]<div class="flpodtext">Район:</div> <div class="flpodinfo"><a href="/?go=search&rai={rai}" onClick="Page.Go(this.href); return false">{rai}</a></div>[/rai]
 [metro]<div class="flpodtext">Станция метро:</div> <div class="flpodinfo"><a href="/?go=search&metro={metro}" onClick="Page.Go(this.href); return false">{metro}</a></div>[/metro]
 [ulica]<div class="flpodtext">Улица:</div> <div class="flpodinfo"><a href="/?go=search&ulica={ulica}" onClick="Page.Go(this.href); return false">{ulica}</a></div>[/ulica]
 [nazvanie]<div class="flpodtext">Номер дома:</div> <div class="flpodinfo"><a href="/?go=search&nazvanie={nazvanie}" onClick="Page.Go(this.href); return false">{nazvanie}</a></div>[/nazvanie]
 [not-contact-phone]<div class="flpodtext">Моб. телефон:</div> <div class="flpodinfo">{phone}</div>[/not-contact-phone]
 [not-contact-vk]<div class="flpodtext">В контакте:</div> <div class="flpodinfo">{vk}</div>[/not-contact-vk]
 [not-contact-od]<div class="flpodtext">Одноклассники:</div> <div class="flpodinfo">{od}</div>[/not-contact-od]
 [not-contact-fb]<div class="flpodtext">FaceBook:</div> <div class="flpodinfo">{fb}</div>[/not-contact-fb]
 [not-contact-skype]<div class="flpodtext">Skype:</div> <div class="flpodinfo"><a href="skype:{skype}">{skype}</a></div>[/not-contact-skype]
 [not-contact-icq]<div class="flpodtext">ICQ:</div> <div class="flpodinfo">{icq}</div>[/not-contact-icq]
 [not-contact-site]<div class="flpodtext">Веб-сайт:</div> <div class="flpodinfo">{site}</div>[/not-contact-site][/not-block-contact]
 
 [interests]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Личная информация [owner]<span><a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div>
 [activity]<div class="flpodtext">Деятельность:</div> <div class="flpodinfo">{activity}</div>[/activity]
 [interes]<div class="flpodtext">Интересы:</div> <div class="flpodinfo"><a href="/?go=search&interes={interes}" onClick="Page.Go(this.href); return false">{interes}</a></div>[/interes]
 [music]<div class="flpodtext">Любимая музыка:</div> <div class="flpodinfo"><a href="/?go=search&music={music}" onClick="Page.Go(this.href); return false">{music}</a></div>[/music]
 [kino]<div class="flpodtext">Любимые фильмы:</div><div class="flpodinfo"><a href="/?go=search&kino={kino}" onClick="Page.Go(this.href); return false">{kino}</a></div>[/kino]
 [shou]<div class="flpodtext">Любимые телешоу:</div> <div class="flpodinfo"><a href="/?go=search&shou={shou}" onClick="Page.Go(this.href); return false">{shou}</a></div>[/shou]
 [serial]<div class="flpodtext">Любимые сериалы:</div> <div class="flpodinfo"><a href="/?go=search&serial={serial}" onClick="Page.Go(this.href); return false">{serial}</a></div>[/serial]
 [books]<div class="flpodtext">Любимые книги:</div> <div class="flpodinfo"><a href="/?go=search&books={books}" onClick="Page.Go(this.href); return false">{books}</a></div>[/books]
 [games]<div class="flpodtext">Любимые игры:</div> <div class="flpodinfo"><a href="/?go=search&games={games}" onClick="Page.Go(this.href); return false">{games}</a></div>[/games]
 [quote]<div class="flpodtext">Любимые цитаты:</div> <div class="flpodinfo">{quote}</div>[/quote]
 [myinfo]<div class="flpodtext">О себе:</div> <div class="flpodinfo"><a href="/?go=search&myinfo={myinfo}" onClick="Page.Go(this.href); return false">{myinfo}</a></div>[/myinfo]
 [/interests]

 [privacy-group][groups]
<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Мне это интересно </div></div>

<div class="group_in_info">

<div class="flpodtext">Группы:</div> <div class="flpodinfo">{groups_info}</div>
</div>
[/groups][/privacy-group]
 
 [education]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Среднее образование [owner]<span><a href="/editmypage/education" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div> 
   [countrysr]<div class="flpodtext">Страна:</div> <div class="flpodinfo">{countrysr}</div>[/countrysr]
   [citysr]<div class="flpodtext">Город:</div> <div class="flpodinfo">{citysr}</div>[/citysr]
   [shkola]<div class="flpodtext">Школа:</div> <div class="flpodinfo"><a href="/?go=search&shkola={shkola}" onClick="Page.Go(this.href); return false">{shkola}</a></div>[/shkola]
   [nacalosr]<div class="flpodtext">Начало обучения:</div> <div class="flpodinfo">{nacalosr}</div>[/nacalosr]
   [konecsr]<div class="flpodtext">Окончания обучения:</div> <div class="flpodinfo">{konecsr}</div>[/konecsr]
   [datasr]<div class="flpodtext">Дата выпуска:</div> <div class="flpodinfo">{datasr}</div>[/datasr]
   [klass]<div class="flpodtext">Класс:</div> <div class="flpodinfo">{klass}</div>[/klass]
   [spec]<div class="flpodtext">Специализация:</div> <div class="flpodinfo"><a href="/?go=search&spec={spec}" onClick="Page.Go(this.href); return false">{spec}</a></div>[/spec]
 [/education]
[higher_education]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Высшее образование [owner]<span><a href="/editmypage/higher_education" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div> 
[countryvi]<div class="flpodtext">Страна:</div> <div class="flpodinfo">{countryvi}</div>[/countryvi]
   [cityvi]<div class="flpodtext">Город:</div> <div class="flpodinfo">{cityvi}</div>[/cityvi]
   [vuz]<div class="flpodtext">ВУЗ:</div> <div class="flpodinfo"><a href="/?go=search&vuz={vuz}" onClick="Page.Go(this.href); return false">{vuz}</a></div>[/vuz]
   [fac]<div class="flpodtext">Факультет:</div> <div class="flpodinfo"><a href="/?go=search&fac={fac}" onClick="Page.Go(this.href); return false">{fac}</a></div>[/fac]
   [form]<div class="flpodtext">Форма обучения:</div> <div class="flpodinfo">{form}</div>[/form]
   [statusvi]<div class="flpodtext">Статус:</div> <div class="flpodinfo">{statusvi}</div>[/statusvi]
   [datavi]<div class="flpodtext">Дата выпуска:</div> <div class="flpodinfo">{datavi}</div>[/datavi]
 [/higher_education]
  
 [career]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Карьера [owner]<span><a href="/editmypage/career" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div> 
   [countryca]<div class="flpodtext">Страна:</div> <div class="flpodinfo">{countryca}</div>[/countryca]
   [cityca]<div class="flpodtext">Город:</div> <div class="flpodinfo">{cityca}</div>[/cityca]
   [mesto]<div class="flpodtext">Место работы:</div> <div class="flpodinfo"><a href="/?go=search&mesto={mesto}" onClick="Page.Go(this.href); return false">{mesto}</a></div>[/mesto]
   [nacaloca]<div class="flpodtext">Начало работы:</div> <div class="flpodinfo">{nacaloca}</div>[/nacaloca]
   [konecca]<div class="flpodtext">Окончания работы:</div> <div class="flpodinfo">{konecca}</div>[/konecca]
   [dolj]<div class="flpodtext">Должность:</div> <div class="flpodinfo"><a href="/?go=search&dolj={dolj}" onClick="Page.Go(this.href); return false">{dolj}</a></div>[/dolj][/career]
 
 [military]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Военная служба [owner]<span><a href="/editmypage/military" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div> 
   [countrysl]<div class="flpodtext">Страна:</div> <div class="flpodinfo">{countrysl}</div>[/countrysl]
   [citysl]<div class="flpodtext">Город:</div> <div class="flpodinfo">{citysl}</div>[/citysl]
   [chast]<div class="flpodtext">Воисковая часть:</div> <div class="flpodinfo"><a href="/?go=search&chast={chast}" onClick="Page.Go(this.href); return false">{chast}</a></div>[/chast]
   [zvanie]<div class="flpodtext">Воинское звание:</div> <div class="flpodinfo"><a href="/?go=search&zvanie={zvanie}" onClick="Page.Go(this.href); return false">{zvanie}</a></div>[/zvanie]
   [nacalosl]<div class="flpodtext">Начало службы:</div> <div class="flpodinfo">{nacalosl}</div>[/nacalosl]
   [konecsl]<div class="flpodtext">Окончания службы:</div> <div class="flpodinfo">{konecsl}</div>[/konecsl][/military]
 
  [personal]<div class="fieldset"><div class="w2_b" [owner]style="width:470px;margin-left:5px;"[/owner]>Жизненная позиция [owner]<span><a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">Редактировать</a></span>[/owner]</div></div> 
   [pred]<div class="flpodtext">Полит. предпочтения:</div> <div class="flpodinfo">{pred}</div>[/pred]
   [miro]<div class="flpodtext">Мировозрение:</div> <div class="flpodinfo"><a href="/?go=search&miro={miro}" onClick="Page.Go(this.href); return false">{miro}</a></div>[/miro]
   [jizn]<div class="flpodtext">Главное в жизни:</div> <div class="flpodinfo">{jizn}</div>[/jizn]
   [ludi]<div class="flpodtext">Главное в людях:</div> <div class="flpodinfo">{ludi}</div>[/ludi]
   [kurenie]<div class="flpodtext">Отн. к курению:</div> <div class="flpodinfo">{kurenie}</div>[/kurenie]
   [alkogol]<div class="flpodtext">Отн. к алкоголю:</div> <div class="flpodinfo">{alkogol}</div>[/alkogol]
   [narkotiki]<div class="flpodtext">Отн. к наркотикам:</div> <div class="flpodinfo">{narkotiki}</div>[/narkotiki]
   [vdox]<div class="flpodtext">Вдохновляют:</div> <div class="flpodinfo">{vdox}</div>[/vdox]
 [/personal]
 
[/privacy-info]
</div>

<div class="clear" style="height:7px"></div>
 [photos]
<a style="text-decoration: none;" href="/albums/{user-id}" onclick="Page.Go(this.href); return false"><div class="albtitle5" style="margin-top: -7px;">Фотографии <span>{photos_num}</span></div></a>
<div class="" style="margin-top:5px;margin-left:7px;"><center>{photos_view_albums}</center></div><br />[/photos]

<div style=margin-bottom:-8px;"></div>

[privacy-audios][audios]<div id="jquery_jplayer"></div><input type="hidden" id="teck_id" value="1" /><a href="/audio{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="margin-top:5px">{audios-num}<div  class="mono_ico_audios" onmouseover="myhtml.title('8', 'Показать все аудиозаписи', 'newBBlockl')" id="newBBlockl8"></div></div></a>{audios}<div class="clear"></div>[/audios][/privacy-audios]

 <a href="/wall{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle">{rec-num}<div class="mono_ico_wall" onmouseover="myhtml.title('187','Показать все записи ', 'newBBlockl')" id="newBBlockl187"></div></div></a>
 [privacy-wall]<div class="newmes" id="wall_tab" style="border-bottom: 0px;
border: 7px solid #ddd;
background-color: #eee;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
border-radius: 5px;
-moz-border-radius-topleft: 0;
-webkit-border-top-left-radius: 0;
border-radius-topleft: 0;
-moz-border-radius-topright: 0;
-webkit-border-top-right-radius: 0;
border-radius-topright: 0;
margin-bottom: 0;">
  <input type="hidden" value="[owner]Что у Вас нового?[/owner][not-owner]Написать сообщение...[/not-owner]" id="wall_input_text" />
  <input type="text" class="wall_inpst" value="[owner]Что у Вас нового?[/owner][not-owner]Написать сообщение...[/not-owner]" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px;width:445px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_inpst wall_fast_opened_texta" style="width:445px"
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
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
   <input type="hidden" id="attach_lnk_stared" />
   <input type="hidden" id="teck_link_attach" />
   <span id="urlParseImgs" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <div id="attach_block_vote" class="no_display">
   <div class="attach_link_bg">
	<div class="texta">Тема опроса:</div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" 
		onKeyUp="$('#attatch_vote_title').text(this.value)"
	/><div class="mgclr"></div>
	<div class="texta">Варианты ответа:<br /><small><span id="addNewAnswer"><a class="cursor_pointer" onClick="Votes.AddInp()">добавить</a></span> | <span id="addDelAnswer">удалить</span></small></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
	<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
	<div id="addAnswerInp"></div>
	<div class="clear"></div>
   </div>
   <div class="attach_toolip_but"></div>
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Опрос: <a id="attatch_vote_title" style="text-decoration:none;cursor:default"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_vote_')" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div>
   <input type="hidden" id="answerNum" value="2" />
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files" type="hidden" />
   <input id="fid" value="{user-id}" type="hidden" />
   <div class="clear"></div>
   <div class="button_div fl_l margin_top_10"><button onClick="wall.send(); return false" id="wall_send">Отправить</button></div>
   <div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach">Прикрепить</div>
   <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu" style="margin-left:368px">
    <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="wall.attach_addsmile()">Смайлик</div>
    <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addphoto()">Фотографию</div>
    <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo()">Видеозапись</div>
    <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addaudio()">Аудиозапись</div>
    <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addgraffiti('{user-id}')">Граффити</div>
    <div class="wall_attach_icon_doc" id="wall_attach_link" onClick="wall.attach_addDoc()">Документ</div>
    <div class="wall_attach_icon_vote" id="wall_attach_link" onClick="$('#attach_block_vote').slideDown('fast');wall.attach_menu('close', 'wall_attach', 'wall_attach_menu');$('#vote_title').focus();$('#vaLattach_files').val($('#vaLattach_files').val()+'vote|start||')">Опрос</div>
   </div>
  </div>
  <div class="clear"></div>
 </div>[/privacy-wall]
 <div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>На стене пока нет ни одной записи.</div>[/no-records]</div>
 [wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">к предыдущим записям</div></div>[/wall-link][/blacklist]
 [not-blacklist]<div class="err_yellow" style="font-weight:normal;margin-top:5px">{name} ограничила доступ к своей странице.</div>[/not-blacklist]
</div>
<div class="clear"></div>