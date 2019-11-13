<div class="miniature_box">
	<div class="miniature_pos" style="width: 607px;margin-top:30px;">
		<div class="miniature_title fl_l apps_box_text">Приглашение друзей</div><a class="cursor_pointer fl_r" onclick="groups.closer()">Закрыть</a>
		<div style="border-bottom: 1px solid #DAE1E8;margin-top:20px;"></div>
<div class="miniature_text clear">
Выберите друзей которых хотите пригласить в сообщество.
<div id="buttomDiv" class="button_div no_display fl_r" style="margin-top: -1px; margin-left: 10px; display: none;">
<button id="invSending" onclick="groups.inviteSend('{grid}')">Отправить приглашения</button>
</div>
<div id="usernum" class="fl_r online no_display">
Выбрано
<b id="usernum2">0</b>
</div>
</div>
<div id="inviteUsers" style="margin-right:-20px">
		{friends}	
	</div><div class="clear"></div>
	<input id="userInviteList" type="hidden">
<div id="invite_prev_ubut" class="rate_alluser cursor_pointer" onclick="groups.inviteFriendsPage('{grid}')" style="margin-top:0px">
<div id="load_invite_prev_ubut">Показать больше друзей</div>
</div>
<div class="clear"></div>
</div>