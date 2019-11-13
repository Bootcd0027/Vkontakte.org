<script type="text/javascript">
$(document).click(function(event){
	settings.event(event);
});
</script>
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
<a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a>
    <div class="buttonsprofileSec"><a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a></div>
	<a href="/settings/notify" onClick="Page.Go(this.href); return false;"><div>Оповещения</div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
<a href="/balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a>
<a href="/balance?act=history" onClick="Page.Go(this.href); return false;"><div>История</div></a>
<a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div>Приглашённые друзья</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои подарки</div></a>
 </div>
</div>
<div class="settings_privacy">
<div class="clear" style="margin-top:0px"></div>

<div class="err_yellow no_display" id="ok_update" style="font-weight:normal;"><b>Настройки сохранены.</b>
<br>

Новые настройки приватности вступили в силу.</div>

<div class="texta color_000" style="width:300px">Кто может писать мне личные <b>сообщения</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('msg')" id="privacy_lnk_msg">{val_msg_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_msg">
  <div id="selected_p_privacy_lnk_msg" class="sett_selected" onClick="settings.privacyClose('msg')">{val_msg_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Все пользователи', '1', 'privacy_lnk_msg')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Только друзья', '2', 'privacy_lnk_msg')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Никто', '3', 'privacy_lnk_msg')">Никто</div>
 </div>
 <input type="hidden" id="val_msg" value="{val_msg}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">О каких заявках в друзья приходят <b>оповещения</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('friend')" id="privacy_lnk_friend">{val_friend_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_friend">
  <div id="selected_p_privacy_lnk_friend" class="sett_selected" onClick="settings.privacyClose('friend')">{val_friend_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_friend', 'От всех пользователей', '1', 'privacy_lnk_friend')">От всех пользователей</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_friend', 'От друзей друзей', '2', 'privacy_lnk_friend')">От друзей друзей</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_friend', 'Ни от кого', '3', 'privacy_lnk_friend')">Ни от кого</div>
 </div>
 <input type="hidden" id="val_friend" value="{val_friend}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто видит чужие записи на моей <b>стене</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall1')" id="privacy_lnk_wall1">{val_wall1_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall1" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall1" class="sett_selected" onClick="settings.privacyClose('wall1')">{val_wall1_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Все пользователи', '1', 'privacy_lnk_wall1')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Только друзья', '2', 'privacy_lnk_wall1')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Только я', '3', 'privacy_lnk_wall1')">Только я</div>
 </div>
 <input type="hidden" id="val_wall1" value="{val_wall1}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может оставлять сообщения на моей <b>стене</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall2')" id="privacy_lnk_wall2">{val_wall2_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall2" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall2" class="sett_selected" onClick="settings.privacyClose('wall2')">{val_wall2_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Все пользователи', '1', 'privacy_lnk_wall2')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Только друзья', '2', 'privacy_lnk_wall2')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Только я', '3', 'privacy_lnk_wall2')">Только я</div>
 </div>
 <input type="hidden" id="val_wall2" value="{val_wall2}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может комментировать мои <b>записи</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall3')" id="privacy_lnk_wall3">{val_wall3_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall3" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall3" class="sett_selected" onClick="settings.privacyClose('wall3')">{val_wall3_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Все пользователи', '1', 'privacy_lnk_wall3')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Только друзья', '2', 'privacy_lnk_wall3')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Только я', '3', 'privacy_lnk_wall3')">Только я</div>
 </div>
 <input type="hidden" id="val_wall3" value="{val_wall3}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто видит основную информацию моей <b>страницы</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('info')" id="privacy_lnk_info">{val_info_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_info" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_info" class="sett_selected" onClick="settings.privacyClose('info')">{val_info_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Все пользователи', '1', 'privacy_lnk_info')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Только друзья', '2', 'privacy_lnk_info')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Только я', '3', 'privacy_lnk_info')">Только я</div>
 </div>
 <input type="hidden" id="val_info" value="{val_info}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может видеть список моих <b>сообществ</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('group')" id="privacy_lnk_group">{val_group_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_group" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_group" class="sett_selected" onClick="settings.privacyClose('group')">{val_group_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_group', 'Все пользователи', '1', 'privacy_lnk_group')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_group', 'Только друзья', '2', 'privacy_lnk_group')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_group', 'Только я', '3', 'privacy_lnk_group')">Только я</div>
 </div>
 <input type="hidden" id="val_group" value="{val_group}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может просматривать список моих <b>подарков</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('gifts')" id="privacy_lnk_gifts">{val_gifts_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_gifts" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_gifts" class="sett_selected" onClick="settings.privacyClose('gifts')">{val_gifts_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_gifts', 'Все пользователи', '1', 'privacy_lnk_gifts')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_gifts', 'Только друзья', '2', 'privacy_lnk_gifts')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_gifts', 'Только я', '3', 'privacy_lnk_gifts')">Только я</div>
 </div>
 <input type="hidden" id="val_gifts" value="{val_gifts}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может видеть список <b>моих аудиозаписей</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('audios')" id="privacy_lnk_audios">{val_audios_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_audios" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_audios" class="sett_selected" onClick="settings.privacyClose('audios')">{val_audios_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_audios', 'Все пользователи', '1', 'privacy_lnk_audios')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_audios', 'Только друзья', '2', 'privacy_lnk_audios')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_audios', 'Только я', '3', 'privacy_lnk_audios')">Только я</div>
 </div>
 <input type="hidden" id="val_audios" value="{val_audios}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может видеть список <b>моих интересных страниц</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('sub')" id="privacy_lnk_sub">{val_sub_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_sub" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_sub" class="sett_selected" onClick="settings.privacyClose('sub')">{val_sub_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_sub', 'Все пользователи', '1', 'privacy_lnk_sub')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_sub', 'Только друзья', '2', 'privacy_lnk_sub')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_sub', 'Только я', '3', 'privacy_lnk_sub')">Только я</div>
 </div>
 <input type="hidden" id="val_sub" value="{val_sub}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может просматривать список моих <b>гостей</b></div>

 <div class="sett_privacy" onClick="settings.privacyOpen('guests1')" id="privacy_lnk_guests1">{val_guests1_text}</div>

 <div class="sett_openmenu no_display" id="privacyMenu_guests1" style="margin-top:-1px">

  <div id="selected_p_privacy_lnk_guests1" class="sett_selected" onClick="settings.privacyClose('guests1')">{val_guests1_text}</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Все пользователи', '1', 'privacy_lnk_guests1')">Все пользователи</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Только друзья', '2', 'privacy_lnk_guests1')">Только друзья</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Только я', '3', 'privacy_lnk_guests1')">Только я</div>

 </div>

 <input type="hidden" id="val_guests1" value="{val_guests1}" />

<div class="mgclr"></div>



<div class="texta color_000" style="width:300px">Кто может видеть в гостях <b>меня</b></div>

 <div class="sett_privacy" onClick="settings.privacyOpen('guests2')" id="privacy_lnk_guests2">{val_guests2_text}</div>

 <div class="sett_openmenu no_display" id="privacyMenu_guests2" style="margin-top:-1px">

  <div id="selected_p_privacy_lnk_guests2" class="sett_selected" onClick="settings.privacyClose('guests2')">{val_guests1_text}</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests2', 'Все пользователи', '1', 'privacy_lnk_guests2')">Все пользователи</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests2', 'Только друзья', '2', 'privacy_lnk_guests2')">Только друзья</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests2', 'Только я', '3', 'privacy_lnk_guests2')">Только я</div>

 </div>

 <input type="hidden" id="val_guests2" value="{val_guests2}" />

<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может писать <b>мнения обо мне</b></div>
 <div class="sett_privacy" onClick="settings.privacyOpen('view')" id="privacy_lnk_view">{val_view_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_view" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_view" class="sett_selected" onClick="settings.privacyClose('view')">{val_view_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_view', 'Все пользователи', '1', 'privacy_lnk_view')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_view', 'Только друзья', '2', 'privacy_lnk_view')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_view', 'Только я', '3', 'privacy_lnk_view')">Только я</div>
 </div>
 <input type="hidden" id="val_view" value="{val_view}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px;">&nbsp;</div>
 <div class="button_div fl_l" style="margin-top:10px;margin-left:4px;"><button onClick="settings.savePrivacy(); return false" id="savePrivacy">Сохранить</button></div>
<div class="mgclr"></div>
</div>