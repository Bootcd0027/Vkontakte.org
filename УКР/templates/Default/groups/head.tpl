<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
  <div class="buttonsprofileSec"><a href="/groups" onClick="Page.Go(this.href); return false;"><div>Сообщества</div></a></div>
 <a href="/groups/request"><div>Приглашения</div></a>
  <a href="/groups?act=admin" onClick="Page.Go(this.href); return false;"><div>Управление</div></a>
<div style="float:right;"><a href="/clubs" onClick="groups.created(); return false"><div><b>Создать сообщество</b></div></a></div>
 </div>
</div>

<div class="friends_search">
<div style="padding:0px 10px;"><input type="text" style="width:400px;" id="friendsearch" placeholder="Начните вводить имя или название" onkeydown="friends.search({user-id},1);" class="friends_se_search friends_s_search" value=""><div style="margin-top:5px;margin-right:8px;" class="button_div fl_r">
<a href="/balance" onClick="Page.Go(this.href); return false;"><button>Пригласить друзей</button></a>
</div>
</div>
<div class="clear"></div>
</div>

<div class="margin_top_10" style="margin-top:-10px;"></div><div class="allbar_title_grups" [yes]style="margin-bottom:0px;border-bottom:0px"[/yes]>[yes]<span style="margin-left:10px;">Вы состоите в {num}</span>[/yes][no]<span style="margin-left:10px;">Вы не состоите ни в одном сообществе.</span>[/no]</div>
[no]<div class="info_center"><br /><br />
Вы пока не состоите ни в одном сообществе. 
<br /><br />
Вы можете <a href="/groups" onClick="groups.createbox(); return false">создать сообщество</a> или воспользоваться <a href="/" onClick="gSearch.open_tab(); gSearch.select_type('4', 'по сообществам'); return false" id="se_link">поиском по сообществам</a>.<br /><br /><br />
</div>[/no]