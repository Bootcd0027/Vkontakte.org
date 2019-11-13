<div class="friends_onefriend">
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><div class="gedit_user_bigph_wrap fl_l"><a style="height:15px"  class="gedit_bigph" onclick="Photo.Profile('{user-id}', '{big-ava}'); return false"><span class="gedit_bigph_label">Увеличить</span></a> 
<a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a> </div></div></a>
<a href="/u{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a>{user_real}<div class="friends_clr"></div>
 {country}{city}<div class="friends_clr"></div>
 {age}<div class="friends_clr"></div>
 <div class="friends_clr" style="margin-top:10px"></div>
 <div id="action_{user-id}">
  <div class="button_div fl_l"><button onMouseDown="friends.take({user-id}); return false">Дружить</button></div>
  <div class="button_div_gray fl_l margin_left"><button onMouseDown="friends.reject({user-id}); return false">Отклонить</button></div>
 </div>
</div>