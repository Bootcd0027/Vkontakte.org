<table id="mail_history_t" cellpadding="0" cellspacing="0">
<tbody><tr class="mail_incoming [new]msg_new[/new]" id="bmsg_{msg-id}">
  <td class="msg_history_name [owner]msg_history_owner_color[/owner]"><a href="/id{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a></td>
  <td class="mail_history_body"><div style="width: 335px;" class="wrapped">{text}</div></td>
  <td class="mail_history_date"><a href="/messages/show/{msg-id}" onclick="return nav.go(this, event);">{date}</a></td>
  <td class="mail_history_act" onmouseover="mail.histMessState(2, 47400); event.cancelBubble = true;">
    <div id="ma47400" style="visibility: hidden;"><a class="mail_history_link" id="del_text_{msg-id}" href="#" onClick="messages.delet('{msg-id}', '{folder}'); return false;">удалить</a></div>
  </td>
</tr>
</tbody></table>