<script type="text/javascript">
$(document).ready(function(){
	music.jPlayerInc();
	$(window).unbind('scroll');
	[search-tab]$(window).scroll(function(){
		if($(window).scrollTop() > 138)
			$('.search_sotrt_tab').css('position', 'fixed').css('margin-top', '-180px');
		else
			$('.search_sotrt_tab').css('position', 'absolute').css('margin-top', '-48px');
	});[/search-tab]
	myhtml.checked(['{checked-online}', '{checked-user-photo}']);	
	var query = $('#query_full').val();
	if(query == 'Начните вводить любое слово или имя')
		$('#query_full').css('color', '#c1cad0');

	[search_js]window.search_loading = false;
	window.search_page = 1;
	var search_handler = function(){
		if (!search_loading && $(document).height() - ($(window).scrollTop() + $(window).height()) < 500) {
			search_loading = true;
			$('.search_loading').show();
			var query = decodeURI((RegExp('query=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
			var type = decodeURI((RegExp('type=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
			if (query == 'null') {
				query = '';
			}
			if (type == 'null') {
				type = 1;
			}
			if (type == 1) {
				var sex = decodeURI((RegExp('sex=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var day = decodeURI((RegExp('day=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var month = decodeURI((RegExp('month=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var year = decodeURI((RegExp('year=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var city = decodeURI((RegExp('city=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var country = decodeURI((RegExp('country=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var online = decodeURI((RegExp('online=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var user_photo = decodeURI((RegExp('user_photo=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var params_list = ['sex', 'day', 'month', 'year', 'city', 'country', 'online', 'user_photo'];
				var ad_params = '';
				$.each(params_list, function(i, v){
					if (eval(v) != 'null') {
						ad_params = ad_params +  '&' + v + '=' + eval(v);
					}
				});
			}
			$.post('/index.php?go=search&type=' + type + '&query=' + query + '&page=' + ++search_page + ad_params, {"ajax": "yes"}, function(d){
				if (d == 'last_page') {
					$(window).unbind('scroll', search_handler);
					return;
				}
				$('{block_id}:last').after(d);
				search_loading = false;
				$('.search_loading').hide();
			});
		}
	};
	$(window).scroll(search_handler);[/search_js]
});
</script>
<div class="search_form_tab_search">
<input type="text" value="{query}" class="fave_input" id="query_full" 
	onBlur="if(this.value==''){this.value='Начните вводить любое слово или имя';this.style.color = '#777777';}" 
	onFocus="if(this.value=='Начните вводить любое слово или имя'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();" 
	style="width:595px;margin:0px;color:#777777" 
maxlength="65" />
<div class="button_div fl_r"><button onClick="gSearch.go(); return false">Поиск</button></div>
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSeconds" style="margin-top:10px;height:22px">
 <div class="{activetab-1}"><a href="/?{query-people}" onClick="Page.Go(this.href); return false;"><div><b>Люди</b></div></a></div>
 <div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>Сообщества</b></div></a></div>
 <div class="{activetab-5}"><a href="/?go=search{query-audios}" onClick="Page.Go(this.href); return false;"><div><b>Аудиозаписи</b></div></a></div>
 <div class="{activetab-2}"><a href="/?go=search{query-videos}" onClick="Page.Go(this.href); return false;"><div><b>Видеозаписи</b></div></a></div>
 <div class="{activetab-3}"><a href="/?go=search{query-notes}" onClick="Page.Go(this.href); return false;"><div><b>Заметки</b></div></a></div>
 <div class="{activetab-6}"><a href="/?go=search{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Обсуждения</b></div></a></div>
</div>
[discussion]<div style="background:#ddd;border-top:1px solid #fff;height:1px;margin-top:10px;margin-left:-10px;margin-right:-10px"></div>
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSeconds" style="margin-top:10px;height:22px">
 <div class="{discussion-activetab-1}"><a href="/?go=search&discussion_type=1&{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Новые темы</b></div></a></div>
 <div class="{discussion-activetab-2}"><a href="/?go=search&discussion_type=2&{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Новые комментарии</b></div></a></div>
 <div class="{discussion-activetab-3}"><a href="/?go=search&discussion_type=3&{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Обсуждаемые</b></div></a></div>
 <div class="{discussion-activetab-4}"><a href="/?go=search&discussion_type=4&{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Мои темы</b></div></a></div>
 <div class="{discussion-activetab-6}"><a href="/?go=search&discussion_type=6&{query-discussion}" onClick="Page.Go(this.href); return false;"><div><b>Мои комментарии</b></div></a></div>
</div>[/discussion]
<input type="hidden" value="{type}" id="se_type_full" />
</div>

[search-tab]<div class="search_sotrt_tab" style="margin-left:534px;margin-top:38px;border-radius: 0px 0px 5px 0px;min-height:386px">
   
 <b>Основное</b>
 <div class="search_clear"></div>
   
 <div class="padstylej"><select name="country" id="country" class="inpst search_sel" onChange="Profile.LoadCity(this.value); gSearch.go();"><option value="0">Любая страна</option>{country}</select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
 <div class="search_clear"></div>

 <div class="padstylej"><select name="city" id="select_city" class="inpst search_sel" onChange="gSearch.go();"><option value="0">Любой город</option>{city}</select></div>
 <div class="search_clear"></div>
 
 <div class="html_checkbox" id="online" onClick="myhtml.checkbox(this.id); gSearch.go();">сейчас на сайте</div>
 <div class="html_checkbox" id="user_photo" onClick="myhtml.checkbox(this.id); gSearch.go();" style="margin-top:9px">с фотографией</div>
 <div class="search_clear" style="margin-top:60px"></div>
 
 <b>Пол</b>
 <div class="search_clear"></div>
  
 <div class="padstylej"><select name="sex" id="sex" class="inpst search_sel" onChange="gSearch.go();"><option value="0">Любой</option>{sex}</select></div>
 <div class="search_clear"></div>
 
 <b>Семейное положение</b>
<div class="search_clear"></div>

<div class="padstylej"><select name="sp" id="sp" class="inpst search_sel" onChange="gSearch.go();"><option value="0">Все</option>{sp}</select></div>
<div class="search_clear"></div> 

 <b>День рождения</b>
 <div class="search_clear"></div>
 
 <div class="padstylej"><select name="day" class="inpst search_sel" id="day" onChange="gSearch.go();"><option value="0">Любой день</option>{day}</select>
 <div class="search_clear"></div>
  
 <select name="month" class="inpst search_sel" id="month" onChange="gSearch.go();"><option value="0">Любой месяц</option>{month}</select>
 <div class="search_clear"></div>
  
 <select name="year" class="inpst search_sel" id="year" onChange="gSearch.go();"><option value="0">Любой год</option>{year}</select></div>

</div>[/search-tab]

<div class="clear"></div>
[yes]<div class="margin_top_10"></div><div class="search_result_title">Найдено {count}</div>[/yes]
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="0" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="teck_prefix" value="" />