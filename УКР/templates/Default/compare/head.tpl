<script>
var prevAnsweName = false;
var comFormValID = false;
var Compare = {

	choose_send: function(rid){
		butloading('fast_buts_'+rid, 56, 'disabled');
		$.post('/index.php?go=compare&act=send', {rid: rid}, function(data){
		
		$('#compareResult').html(data); //выводим сам результат
		wall.fast_form_close();
		
		//butloading('fast_buts_'+rid, 56, 'enabled', lang_box_send);
		});
		
	}
	
}
</script>
<div class="search_form_tab" style="margin-top:-9px">
<div class="buttonsprofile albumsbuttonsprofile" style="height:22px;">
 <div class="{activetab-1}"><a href="/compare" onClick="Page.Go(this.href); return false;"><div><b>Дуэли</b></div></a></div>
 <div class="{activetab-2}"><a href="/?go=compare&act=choose" onClick="Page.Go(this.href); return false;"><div><b>Мне нравится</b></div></a></div>
 <div class="{activetab-3}"><a href="/?go=compare&act=choose&out=1" onClick="Page.Go(this.href); return false;"><div><b>Я нравлюсь</b></div></a></div>
 <div class="{activetab-4}"><a href="/?go=compare&act=choose&out=2" onClick="Page.Go(this.href); return false;"><div><b>Взаимно</b></div></a></div>
</div></div>

[main]<div class="clear"></div><div style="margin-top:20px;"></div>

<div class="search_sotrt_tab border_radius_5">

   
 <b>Мне нравится (<a href="/?go=compare&act=choose" onClick="Page.Go(this.href); return false;">{cnt-1}</a>)</b>
 <div class="search_clear"></div>
	{mylikeList}
  
 <b>Я нравлюсь (<a href="/?go=compare&act=choose&out=1" onClick="Page.Go(this.href); return false;">{cnt-2}</a>)</b>
 <div class="search_clear"></div>
	{outlikeList}

 <b>Взаимно (<a href="/?go=compare&act=choose&out=2" onClick="Page.Go(this.href); return false;">{cnt-3}</a>)</b>
 <div class="search_clear"></div>
	{oklikeList}

</div>

<div class="clear"></div>


<div class="msg_speedbar margin_bottom_10" style="margin-right:297px; text-align: center">Выбирай людей, которые тебе нравятся, и узнай, нравишься ли ты им! Анкеты участников открываются друг другу только после совпадения. Чем дольше ты находишься в онлайне, тем чаще ты будешь показываться другим людям.</div>

[/main]

