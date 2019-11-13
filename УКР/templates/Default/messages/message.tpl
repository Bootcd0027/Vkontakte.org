<div id="one_msg_{mid}" class="msg_one [new]msg_new[/new]" id="bmsg_{mid}">
 <div class="msg_pad">
  <div class="msg_ava"><a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a></div>
  <div class="msg_left_col">
   <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><span>{name}</span></a>
   <div><span>{online}</span></div>
   <div><small>{date}</small></div>
  </div>
  <a href="/messages/show/{mid}"  onclick="Page.Go(this.href); return false"><div class="msg_right_col"><div>{text}&nbsp;</div><div>{attach}</div></div></a>
  <div class="msg_del_link" style="margin-top:-9px;line-height:17px">
  <div class="mail_actions"><a href="/" onClick="messages.delet({mid}, '{folder}'); return false" id="del_text_{mid}">Удалить</a><img src="{theme}/images/loading_mini.gif" alt="" id="del_load_{mid}" class="no_display" /></div>
  </div>
  <div class="clear"></div>
 </div>
</div>