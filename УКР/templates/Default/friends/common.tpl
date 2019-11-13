<div style="margin-top:27px;">
<div class="friends_onefriend width_100" id="friend_{user-id}">
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><div class="gedit_user_bigph_wrap fl_l"> 
<a style="height:15px"  class="gedit_bigph" onclick="Photo.Profile('{user-id}', '{big-ava}'); return false">
<span class="gedit_bigph_label">Увеличить</span></a> 
<a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a> </div></div></a>
 <div class="fl_l" style="width:400px">
  <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a>{user_real}<div class="friends_clr"></div>
  {country}{city}<div class="friends_clr"></div>
  {age}<div class="friends_clr"></div>
  <span class="online">{online}</span><div class="friends_clr"></div>
 </div>
 <div class="menuleft fl_r friends_m">
[viewer]<a href="/" onClick="messages.new_({user-id}); return false"><div>Написать сообщение</div></a>[/viewer]
  <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false"><div>Просмотреть друзей</div></a>
  [owner]<a onMouseDown="friends.delet({user-id}, 0); return false"><div>Убрать из друзей</div></a>[/owner]
 </div>
</div>
</div>