<script type="text/javascript">
$(document).ready(function(){
	videos.scroll();
});
</script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="buttonsprofileSec"><a href="/videos/{user-id}" onClick="Page.Go(this.href); return false;"><div>[owner]Все видеозаписи[/owner][not-owner]К видеозаписям {name}[/not-owner]</div></a></div>
<a href="/?go=search&type=2&query=" onClick="Page.Go(this.href); return false;"><div>Смотреть другие</div></a>
 <div style="float:right;">[admin-video-add][owner]<a href="/" onClick="videos.add(); return false;"><b>Добавить видеоролик</b></a>[/owner][/admin-video-add]</div>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
</div></div>
<div style="margin-top:0px;"></div>
<div class="friends_search">
<div style="padding:0px 10px;">
<input type="text" style="width:400px;" id="videosearch" placeholder="Начните вводить имя видеозаписи" onkeydown="video.search({user-id},1);" class="friends_se_search friends_s_search" value=""><div style="margin-top:5px;margin-right:23px;" class="button_div fl_r">
<a href="/?go=search&type=2&query=" onClick="Page.Go(this.href); return false;"><button>Смотреть все</button></a>
</div>
</div>
<div class="clear"></div>
</div>
<div id="searchbody" style="display:none;"></div>

<input type="hidden" value="{user-id}" id="user_id" />
<input type="hidden" id="set_last_id" />
<input type="hidden" id="videos_num" value="{videos_num}" />