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
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="type" value="{type}" />
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
  <div class="{obomne}"><a href="/opinion" onClick="Page.Go(this.href); return false;"><div>Мнения о Вас</div></a></div>
 <div class="{moi}"><a href="/opinion/my" onClick="Page.Go(this.href); return false;"><div>Ваши мнения</div></a></div>

</div></div>
<div class="clear"></div><div style="margin-top:10px;"></div>