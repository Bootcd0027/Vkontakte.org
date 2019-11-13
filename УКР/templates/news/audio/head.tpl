<script type="text/javascript">
$(document).ready(function(){
	music.jPlayerInc();
	$(window).scroll(function(){
		if($(window).scrollTop() > 45){
			$('.player_container').css('position', 'fixed').css('margin-top', '-48px').css('width', '774px');
			$('.player_shadow').show();
		} else {
			$('.player_container').css('position', 'static').css('margin-top', '-14px').css('width', '774px');
			$('.player_shadow').hide();
		}
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2)){
			audio.page();
		}
	});
});
</script>
<div class="search_form_tab" style="margin-top:-9px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
  <div class="buttonsprofileSec"><a href="/audio{uid}" onClick="Page.Go(this.href); return false;"><div><b>Все аудиозаписи</b></div></a></div>
  [admin-add][owner]<a href="/audio{uid}" onClick="audio.addBox(); return false;"><div><b>Добавить аудиозапись</b></div></a>[/owner][/admin-add]
  <a href="/u{uid}" onClick="Page.Go(this.href); return false;"><div><b>[not-owner]К странице {name}[/not-owner][owner]К моей странице[/owner]</b></div></a>
 </div>
</div>
<div class="margin_top_10" style="margin-top:15px"></div>
<div style="height:60px">
<div id="jquery_jplayer"></div>
<div class="player_container" id="player_container">
 <div class="player_ic fl_l" onClick="music.prev()">
  <div class="player_ic_prev"></div>
 </div>
 <div class="player_ic fl_l" id="player_play" onClick="music.nullPlay()">
  <div class="player_ic_play"></div>
 </div>
 <div class="player_ic fl_l" id="player_pause" onClick="music.nullPause()">
  <div class="player_ic_pause"></div>
 </div>
 <div class="player_ic fl_l" onClick="music.next()">
  <div class="player_ic_next"></div>
 </div>
 <div class="player_track_name fl_l" id="teck_track_name">&nbsp;</div>
 <div class="player_time_text fl_l"><span id="play_time">00:00</span></div><div>&nbsp;</div>
 <div class="player_progreebar fl_l">
  <div id="player_progress_load_bar">
   <div id="player_progress_play_bar"></div>
  </div>
 </div> 
 <div class="player_del_volume fl_l cursor_pointer" onClick="music.volumeOff()" onMouseOver="myhtml.title('1', 'Отключить звук', 'volOff_', -1)" id="volOff_1"></div>
 <div class="player_progreebar fl_l cursor_pointer" style="width:50px" id="player_volume_bar" onClick="music.volume()">
  <div id="player_volume_bar_value" onClick="music.volume()"></div>
 </div>
 <div class="player_max_volume fl_l cursor_pointer" onClick="music.volumeMax()" onMouseOver="myhtml.title('1', 'Громкость на 100%', 'volMax_', -3)" id="volMax_1"></div>
 <div class="player_refresh fl_l cursor_pointer" onClick="music.refresh()" onMouseOver="myhtml.title('1', 'Повторять эту песню', 'volrefresh_', -1)" id="volrefresh_1"></div>
 <div class="player_rand fl_l cursor_pointer" onClick="music.randOn()" onMouseOver="myhtml.title('1', 'Случайный порядок', 'rand_', -1)" id="rand_1"></div>
 <div class="clear"></div>
</div>
<input type="hidden" id="teck_id" value="1" />
<input type="hidden" id="refresh" value="0" />
<input type="hidden" id="rand" value="0" />
<input type="hidden" id="page_cnt" value="1" />
<input type="hidden" id="uid" value="{uid}" />
<input type="hidden" id="teck_prefix" value="" />
</div>
<div class="public_wall_photos_shadow fixed player_shadow no_display"></div>