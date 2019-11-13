<script type="text/javascript">
$(document).ready(function(){
	var query = $('#query_full').val();
	if(query == 'Начните вводить любое слово')
		$('#query_full').css('color', '#c1cad0');
		
	var search_loading = false;
	var search_page = 1;
	var pins_search_status = true;
	if (!search_loading && $(document).height() - ($(window).scrollTop() + $(window).height()) < 500) {
		search_loading = true;
		if(query == 'Начните вводить любое слово') var query_post = '';
		else var query_post = query;
		$.post('/index.php?go=pins', {page_cnt: search_page, query: query_post, doload: 1}, function(d){
			search_page++;
			$('.pin_block:last').after(d);
		});
		search_loading = false;
	}

});
var pins_category = 0;
var pins_my_active = false;
function pinsSearch(){
	var text = $('#query_full').val();
	if(text == 'Начните вводить любое слово') text = '';
	if(text) var doload = 0;
	else var doload = 1;
	$.post('/index.php?go=pins', {query: text, doload: doload, cat: pins_category}, function(d){
		$('#search_block').html(d);
	});
}
function myPins(){
	$.post('/index.php?go=pins', {my: 1, cat: pins_category}, function(d){
		pins_my_active = true;
		$('#search_block').html(d);
		$('#all_pins').removeClass('buttonsprofileSec');
		$('#my_pins').addClass('buttonsprofileSec');
	});
}
function ChangePinsCategories(val){
	pins_category = val;
	var text = $('#query_full').val();
	if(text == 'Начните вводить любое слово') text = '';
	if(text) var doload = 0;
	else var doload = 1;
	$.post('/index.php?go=pins', {cat: pins_category, c_change: 1, query: text, my: pins_my_active}, function(d){
		$('#search_block').html(d);
	});
}
</script>
<style>/* PINS */
.pin_block {float: left; box-shadow: 0 0 5px 0 rgba(0,0,0,0.2); margin-left: 45px;margin-top: 10px; width: 200px}
.pin_block:hover {box-shadow: 0 0 8px 0 rgba(0,0,0,0.4);}
.pin_block_descr {background: #F2F2F2}
.pin_once{cursor: pointer}
.pin_once:hover {opacity: 0.6}
.pins_header {padding: 10px; background: #597BA5}
.pins_descr_view {padding: 20px; color: #777; font-size: 11px;margin-left: 30px}
.pins_comm_block{background: #F2F2F2;padding: 10px;border-top: 1px solid #DAE1E8;}
.pins_comm_area {height: 43px;margin-left: 15px; width: 420px}
.pins_comment{padding: 10px}
.pins_once_comment_block {padding: 5px; border-top: 1px solid #F2F2F2}
.pins_comm_user {margin-left: 15px;}
.pins_comm_text {margin-left: 20px;}
.pins_share_but {padding: 5px;background: #F7F7F7; color: #2B587A;cursor: pointer;border-radius: 3px}
.pins_share_but:hover {background: #D5DDE5}</style>
<div class="clear"></div>

<div class="search_form_tab">
	<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
		<div class="{activetab-1}" id="all_pins"><a href="/pins" onClick="Page.Go(this.href); return false"><div><b>Все стикеры</b></div></a></div>
		<div id="my_pins"><a href="/" onClick="myPins(); return false"><div><b>Мои стикеры</b></div></a></div>
		<a href="/" onClick="pins.add_box(); return false"><div><b>Добавить стикер</b></div></a>
	</div>
</div>

<div class="friends_search">
<div style="padding:0px 10px;"><input type="text" value="{query}" class="friends_se_search friends_s_search" id="query_full" 
	onBlur="if(this.value==''){this.value='Начните вводить любое слово';this.style.color = '#c1cad0';}" 
	onFocus="if(this.value=='Начните вводить любое слово'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13) pinsSearch();" style="width:400px" 
	maxlength="40" /><div style="margin-top:10px;margin-right:8px;" class="fl_r">
<select style="height: 20px;border: 1px solid #C6D4DC;width: 200px;margin-left: 10px" onChange="ChangePinsCategories(this.value)">{category}</select>
</div></div>
<div class="clear"></div>
</div>

<div class="clear"></div><div style="margin-top:0px;"></div>
<div id="searchbody" style="display:none;"></div>

<div style="margin-top: 30px" id="search_block">
	{pins}
</div>