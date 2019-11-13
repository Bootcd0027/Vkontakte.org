[news]
<div class="search_form_tab">
<script type="text/javascript">
var page_cnt = 1;
$(document).ready(function(){
	music.jPlayerInc();
	$('#wall_text, .fast_form_width').autoResize();
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			news.page();
		}
	});
});
$(document).click(function(event){
	wall.event(event);
});
</script>
<style>.newcolor000{color:#000}</style>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="type" value="{type}" />
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="{buttonsprofileSec-}"><a href="/news" onClick="Page.Go(this.href); return false;"><div>Новости</div></a></div>
 <div class="{buttonsprofileSec-notifications}"><a href="/news/notifications" onClick="Page.Go(this.href); return false;"><div>Ответы</div></a></div>
 <div class="{buttonsprofileSec-photos}"><a href="/news/photos" onClick="Page.Go(this.href); return false;"><div>Фотографии</div></a></div>
<div class="{buttonsprofileSec-videos}"><a href="/news/videos" onClick="Page.Go(this.href); return false;"><div>Видеозаписи</div></a></div>
 <div class="{buttonsprofileSec-updates}"><a href="/news/updates" onClick="Page.Go(this.href); return false;"><div>Обновления</div></a></div>
</div>
</div>
<div style="margin-top:20px;"></div>[/news]
[bottom]<span id="news"></span>
[bottom]<span id="news"></span>
<div onClick="news.page()" id="wall_l_href_news" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="loading_news" style="width:675px;margin-top:20px">Показать предыдущие новости</div></div>[/bottom]