
<div class="im_chatmail im_msg {new}" id="imMsg{msg-id}" {read-js-func}>

<div class="im_chatformava"><a href="/u{user-id}" onClick="Page.Go(this.href); return false">

<img src="{ava}" style="border-radius:3px;" width="32" /></a>

</div><div class="wallauthor support_anser_nam im_msg_name" style="padding-left:0px">

<a href="/u{user-id}" onClick="Page.Go(this.href); return false">{name}</a><div class="fl_r im_msg_date"><div class="fl_l">{date}</div><img src="templates/Default/images/close_a.png" onMouseOver="myhtml.title('{msg-id}', 'Удалить сообщение', 'del_text_')" onClick="im.delet('{msg-id}', '{folder}'); return false" id="del_text_{msg-id}" class="msg_histry_del cursor_pointer im_msg_delf fl_r" /></div></div><div class="im_chatMail_text">	{text}</div><div class="clear"></div></div>