[inbox]<script type="text/javascript">
$(document).ready(function(){
	var query = $('#msg_query').val();
	if(query == 'Поиск по полученным сообщениям')
		$('#msg_query').css('color', '#c1cad0');
});
</script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="buttonsprofileSec"><a href="/messages" onClick="Page.Go(this.href); return false;"><div>Полученные</div></a></div>
 <a href="/messages/outbox" onClick="Page.Go(this.href); return false;">Отправленные</a>
</div></div>
<div class="clear"></div><div style="margin-top:0px"></div>
<div class="msg_se_bg" style="padding:0px 10px;"><input type="text" value="{query}" class="friends_se_search msg_se_inp fl_l" style="width:400px;" onBlur="if(this.value==''){this.value='Поиск по полученным сообщениям';this.style.color = '#c1cad0';}" onFocus="if(this.value=='Поиск по полученным сообщениям'){this.value='';this.style.color = '#000'}" id="msg_query" maxlength="130" onKeyPress="if(event.keyCode == 13)messages.search();" />
<div class="button_div fl_r msg_pad_top"><button onClick="messages.search(); return false">Найти</button></div>
<div class="clear"></div>
</div>
<div class="msg_speedbar">{msg-cnt} &nbsp;|&nbsp; <a href="/" style="font-weight:normal" onClick="im.settTypeMsg(); return false" id="settTypeMsg">{msg-type}</a></div>[/inbox]
[outbox]<script type="text/javascript">
$(document).ready(function(){
	var query = $('#msg_query').val();
	if(query == 'Поиск по отправленным сообщениям')
		$('#msg_query').css('color', '#c1cad0')
});
</script>
<style>.nav{margin-top:10px}</style>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/messages" onClick="Page.Go(this.href); return false;">Полученные</a>
 <div class="buttonsprofileSec"><a href="/messages/outbox" onClick="Page.Go(this.href); return false;"><div>Отправленные</div></a></div>
</div></div>
<div class="clear"></div><div style="margin-top:0px;"></div>
<div class="msg_se_bg"><input type="text" value="{query}" class="friends_se_search msg_se_inp fl_l" style="width:400px;" onblur="if(this.value==''){this.value='Поиск по отправленным сообщениям';this.style.color = '#c1cad0';}" onfocus="if(this.value=='Поиск по отправленным сообщениям'){this.value='';this.style.color = '#000'}" id="msg_query" maxlength="130" onKeyPress="if(event.keyCode == 13)messages.search(1);" />
<div class="button_div fl_r msg_pad_top"><button onClick="messages.search(1); return false">Найти</button></div>
<div class="clear"></div>
</div>
<div class="msg_speedbar">{msg-cnt}</div>[/outbox]
[review]<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/messages" onClick="Page.Go(this.href); return false;">Полученные</a>
 <a href="/messages/outbox" onClick="Page.Go(this.href); return false;">Отправленные</a>
 <div class="buttonsprofileSec"><a href="/" onClick="Page.Go('/messages/show/{mid}'); return false"><div>Просмотр сообщения</div></a></div>
</div></div>
<div class="clear"></div><div class="hralbum"></div>[/review]