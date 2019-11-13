<div class="search_form_tab" style="background:#FFFFFF;">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
  <a href="/support" onClick="Page.Go(this.href); return false;"><div>[group=4]Вопросы от пользователей[/group][not-group=4]Мои вопросы[/not-group]</div></a>
  <div class="buttonsprofileSec"><a href="/support?act=show&qid={qid}" onClick="Page.Go(this.href); return false;"><div>Просмотр вопроса</div></a></div>
 </div>
</div>
<div class="note_full_title">
 <span><a href="/support?act=show&qid={qid}" onClick="Page.Go(this.href); return false">{title}</a></span><br />
 <div id="status">{status}</div>
</div>
<div class="note_text" style="padding-left:0px">
<div class="ava_mini" style="float:width:50px"><a href="/u{uid}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" title="" /></a></div>
<div class="wallauthor" style="padding-left:0px;margin-left:10px;float:left"><a href="/u{uid}" onClick="Page.Go(this.href); return false">{name}</a></div>
<div style="float:left;width:616px;margin-bottom:10px;margin-left:10px">
<div class="walltext">
 <div style="padding-left:2px">
  {question}
  <br /><span class="color777">{date} &nbsp;|&nbsp;</span> <a href="/" onClick="support.delquest('{qid}'); return false">Удалить вопрос</a>
 </div>
</div>
</div>
</div>
<div class="clear"></div>
<div id="answers">{answers}</div>
<div class="note_add_bg clear support_addform">
<div class="ava_mini">
 [group=4]<img src="{theme}/images/support.png" alt="" />[/group]
 [not-group=4]<a href="/u{uid}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a>[/not-group]
</div>
<textarea 
	class="videos_input wysiwyg_inpt fl_l" 
	id="answer" 
	style="width:615px;height:38px;color:#c1cad0"
	onblur="if(this.value==''){this.value='Комментировать..';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='Комментировать..'){this.value='';this.style.color = '#000'}"
>Комментировать..</textarea>
<div class="clear"></div>
<div class="button_div fl_l" style="margin-left:60px"><button onClick="support.answer('{qid}', '{uid}'); return false" id="send">Отправить</button></div>
[group=4]<div class="button_div_nostl fl_r" id="close_but"><button onClick="support.close('{qid}'); return false" id="close">Закрыть вопрос</button></div>[/group]
<div class="clear"></div>
</div>