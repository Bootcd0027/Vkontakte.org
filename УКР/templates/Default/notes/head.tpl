[all]
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="buttonsprofileSec"><a href="/notes/{user-id}" onClick="Page.Go(this.href); return false;"><div>[owner]Мой блог[/owner][not-owner]Блог пользователя {name}[/not-owner]</div></a></div>
 [owner]<div style="float:right;"><a href="/notes/add" onClick="Page.Go(this.href); return false;"><b>Добавить запись</b></a></div>
</div>
[/owner]
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
</div><div style="margin-top:0px;"></div>

<div class="friends_search">
<div style="padding:0px 10px;">
<input type="text" style="width:400px;" id="friendsearch" placeholder="Начите вводить имя заметки" onkeydown="friends.search({user-id},1);" class="friends_se_search friends_s_search" value=""><div style="margin-top:5px;margin-right:8px;" class="button_div fl_r">
<a href="/balance" onClick="Page.Go(this.href); return false;"><button>Пригласить друзей</button></a>
</div>
</div>
<div class="clear"></div>
</div>
<div id="searchbody" style="display:none;"></div>

[/all]
[add]<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:10px">
 <a href="/notes" onClick="Page.Go(this.href); return false;">Мой блог</a>
 <div class="buttonsprofileSec"><a href="/notes/add" onClick="Page.Go(this.href); return false;"><div>Добавить запись</div></a></div>
</div>
<div class="clear"></div><div class="hralbum" style="margin-top:10px;"></div>
[/add]
[edit]<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:10px">
 <a href="/notes" onClick="Page.Go(this.href); return false;">Мой блог</a>
 <div class="buttonsprofileSec"><a href="/notes/edit/{note-id}" onClick="Page.Go(this.href); return false;"><div>Редактирование блога</div></a></div>
 <a href="/notes/add" onClick="Page.Go(this.href); return false;">Добавить запись</a>
</div>
<div class="clear"></div><div class="hralbum" style="margin-top:10px;"></div>
[/edit]
[view]<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:10px">
 <a href="/notes/{user-id}" onClick="Page.Go(this.href); return false;">[owner]Мой блог[/owner][not-owner]Блог{name}[/not-owner]</a>
 <div class="buttonsprofileSec"><a href="/notes/view/{note-id}" onClick="Page.Go(this.href); return false;"><div>Просмотр блога</div></a></div>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
 [owner]<a href="/notes/add" onClick="Page.Go(this.href); return false;">Добавить запись</a>[/owner]
</div>
<div class="clear"></div>
[/view]