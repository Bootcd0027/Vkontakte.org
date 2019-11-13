<div class="friends_onefriend width_100" style="border-top:1px solid #e0eaef;margin-top:20px;">
 <a href="/{adres}" onClick="Page.Go(this.href); return false">
 <div class="friends_ava"><img src="{photo}" /></div></a>
 <div class="fl_l" style="width:580px">
  <a href="/{adres}" onClick="Page.Go(this.href); return false"><b>{title}</b></a><div class="friends_clr"></div>
  <span class="color777">{traf}</span>
  <div style="">
<div class="texta" style="padding-top:10px;margin-left:-58px;">Вас приглашает:</div>
<div class="fl_l" style="width:200px">
<a href="/u{user_id}" onclick="Page.Go(this.href);">
<img width="32" height="32" align="left" src="{ava}">
<div style="margin-left:40px" class="margin_top_10">
<b>{name}</b>
</div>
</a>
</div>
<div class="mgclr"></div>
</div>
  <div id="lods{group_id}" class="margin_top_10">
  <div class="texta" style="padding-top:0px;margin-left:-13px;">
  <div class="button_div" style="padding-top:-40px;" onclick="groups.logins('{group_id}'); return false">
    <button>Вступить в группу</button>
  </div></div>
  <div class="button_div_gray  fl_l margin_left" onclick="groups.unlogin('{group_id}');">
  <button>Отказаться</button>
  </div>
  </div>
  <div class="friends_clr"></div>
 </div>
 <div class="menuleft fl_r friends_m">
 </div>
</div>