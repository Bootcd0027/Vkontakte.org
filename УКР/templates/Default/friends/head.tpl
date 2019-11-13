[all-friends]
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="buttonsprofileSec"><a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;"><div>Все друзья</div></a></div>
 <a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;">Друзья на сайте</a>
 [owner]<a href="/friends/requests" onClick="Page.Go(this.href); return false;">Заявки в друзья {demands}</a>[/owner]
 [not-owner]<a href="/u{uid}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
 <div style="float:right;"><a href="/?go=search&query=&type=1&rai=undefined&metro=undefined&ulica=undefined&nazvanie=undefined&activity=undefined&interes=undefined&myinfo=undefined&music=undefined&kino=undefined&shou=undefined&serial=undefined&books=undefined&games=undefined&shkola=undefined&klass=undefined&spec=undefined&vuz=undefined&fac=undefined&form=undefined&statusvi=undefined&mesto=undefined&dolj=undefined&chast=undefined&zvanie=undefined&pred=undefined&miro=undefined&jizn=undefined&ludi=undefined&kurenie=undefined&alkogol=undefined&narkotiki=undefined&vdox=undefined" onClick="Page.Go(this.href); return false;"><b>Поиск друзей</b></a></div>
[list][owner]<a href="/" onClick="friends.delList('{list_id}'); return false" style="float:right">Удалить список</a>[/owner][/list]
 </div>
</div>
<div class="friends_search">
<div style="padding:0px 10px;"><input type="text" style="width:400px;" id="friendsearch" placeholder="Начните вводить имя друга" onkeydown="friends.search({user-id},1);" class="friends_se_search friends_s_search" value=""><div style="margin-top:5px;margin-right:8px;" class="button_div fl_r">
<a href="/balance" onClick="Page.Go(this.href); return false;"><button>Пригласить друзей</button></a>
</div></div>
<div class="clear"></div>
</div>

<div class="clear"></div><div style="margin-top:0px;"></div>
<div id="searchbody" style="display:none;"></div>
[/all-friends]

[request-friends]
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;">Все друзья</a>
 <a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;">Друзья на сайте</a>
 <div class="buttonsprofileSec"><a href="/friends/requests" onClick="Page.Go(this.href); return false;"><div>Заявки в друзья {demands}</div></a></div>
  <div style="float:right;"><a href="/?go=search&query=&type=1&rai=undefined&metro=undefined&ulica=undefined&nazvanie=undefined&activity=undefined&interes=undefined&myinfo=undefined&music=undefined&kino=undefined&shou=undefined&serial=undefined&books=undefined&games=undefined&shkola=undefined&klass=undefined&spec=undefined&vuz=undefined&fac=undefined&form=undefined&statusvi=undefined&mesto=undefined&dolj=undefined&chast=undefined&zvanie=undefined&pred=undefined&miro=undefined&jizn=undefined&ludi=undefined&kurenie=undefined&alkogol=undefined&narkotiki=undefined&vdox=undefined" onClick="Page.Go(this.href); return false;"><b>Поиск друзей</b></a></div>
 </div>
</div>
<div class="clear"></div><div style="margin-top:20px;"></div>
[/request-friends]

[online-friends]
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;">Все друзья</a>
 <div class="buttonsprofileSec"><a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;"><div>Друзья на сайте</div></a></div>
 [owner]<a href="/friends/requests" onClick="Page.Go(this.href); return false;">Заявки в друзья {demands}</a>[/owner]
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
 <div style="float:right;"><a href="/?go=search&query=&type=1&rai=undefined&metro=undefined&ulica=undefined&nazvanie=undefined&activity=undefined&interes=undefined&myinfo=undefined&music=undefined&kino=undefined&shou=undefined&serial=undefined&books=undefined&games=undefined&shkola=undefined&klass=undefined&spec=undefined&vuz=undefined&fac=undefined&form=undefined&statusvi=undefined&mesto=undefined&dolj=undefined&chast=undefined&zvanie=undefined&pred=undefined&miro=undefined&jizn=undefined&ludi=undefined&kurenie=undefined&alkogol=undefined&narkotiki=undefined&vdox=undefined" onClick="Page.Go(this.href); return false;"><b>Поиск друзей</b></a></div>
 </div>
</div>
<div style="margin-top:0px;"></div>
<div class="friends_search">
<div style="padding:0px 10px;"><input type="text" style="width:400px;" id="friendsearch" placeholder="Начните вводить имя друга" onkeydown="friends.search({user-id},1);" class="friends_se_search friends_s_search" value=""><div style="margin-top:5px;margin-right:8px;" class="button_div fl_r">
<a href="/balance" onClick="Page.Go(this.href); return false;"><button>Пригласить друзей</button></a>
</div></div>
<div class="clear"></div>
</div>
<div id="searchbody" style="display:none;"></div>
[/online-friends]