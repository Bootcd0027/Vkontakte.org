<style>
.miniature_pos{padding: 0}
</style>
<div class="miniature_box">
	<div class="miniature_pos">
		<div class="pins_header">
			<div class="fl_l">
				<div class="fl_l"><a href="/u{uid}"><img src="{ava}" width="40" height="40"></a></div>
				<div class="fl_l" style="margin-left: 15px;margin-top: 10px"><a href="/u{uid}" style="color:#fff">{name}</a></div>
			</div>
			<a class="cursor_pointer fl_r" style="font-size:12px;color:#fff;margin-top: 10px" onClick="viiBox.clos('view', 1)">Закрыть</a>
			<div class="clear"></div>
		</div>
		<div style="margin-top: 10px">
			<center><img src="{photo}"></center>
			<div style="padding-top: 10px; margin-left:50px; font-size: 11px">{descr}</div>
			<div class="pins_descr_view">Загруженно {date} в {category}</div>
		</div>
		<div class="fl_r pins_share_but" style="margin-top: -40px; margin-right: 200px" onClick="pins.share({id})">Поделиться</div>
		<div class="fl_r" id="like_block" style="margin-top: -40px; margin-right: 40px"></div>
		<div class="clear"></div>
		<div class="pins_comment">
			{comments}
			<div id="add_comm"></div>
			{comm_butt}
		</div>
		<div class="pins_comm_block">
			<div class="fl_l"><a href="/u{my-id}" onClick="Page.Go(this.href)"><img src="{my-ava}"></a></div>
			<div class="fl_l"><textarea class="pins_comm_area" id="pins_text"></textarea></div>
			<div class="button_div fl_l" style="margin-left: 15px;margin-top: 12px"><button onClick="pins.comm_send({id})">Отправить</button></div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	likes.init({id}, 'pin', 'like_block');
});
var pins_comment_page = 1;
function show_more_comment(id){
	$.post('/index.php?go=pins&act=more_comment', {id: id, page: pins_comment_page}, function(d){
		pins_comment_page++;
		if(d) $('.pins_once_comment_block:last').after(d);
		else $('#likes_more').remove();
	});
}
</script>