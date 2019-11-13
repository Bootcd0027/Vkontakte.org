<script type="text/javascript">
$(document).ready(function(){
	music.jPlayerInc();
	$('.fast_form_width').autoResize();
});
$(document).click(function(event){
	wall.event(event);
});
</script>
<style>.newcolor000{color:#000}</style>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="{buttonsprofileSec-}"><a href="/wall{uid}" onClick="Page.Go(this.href); return false;"><div>Все записи</div></a></div>
 <div class="{buttonsprofileSec-own}"><a href="/wall{uid}_sec=own" onClick="Page.Go(this.href); return false;"><div>Записи {name}</div></a></div>
 [record-tab]<div class="{buttonsprofileSec-record}"><a href="/wall{uid}_{rec-id}" onClick="Page.Go(this.href); return false;"><div>Запись на стене</div></a></div>[/record-tab]
 <a href="{alias}" onClick="Page.Go(this.href); return false;"><div>К странице {name}</div></a>
</div></div>
<div class="clear"></div><div style="margin-top:10px;"></div>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />