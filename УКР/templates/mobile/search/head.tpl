<script type="text/javascript">
$(document).ready(function(){
	if($('#query_full').val() == '{translate=lang_459}')
		$('#query_full').val('');
});
</script>
<input type="text" value="{query}" class="inp" id="query_full"  style="width:40%;margin:0px;color:#000;float:left;padding:3px;padding-bottom:4px" maxlength="65" />
<button class="button" onClick="gSearch.go(); return false" style="float:left;margin:0px;margin-left:10px">{translate=lang_136}</button>
<div class="clr"></div>
<div class="tmenuf2" style="margin-top:10px">
 <div class="{activetab-1}"><a href="/?{query-people}">{translate=lang_460}</a></div>
 <div class="{activetab-4}"><a href="/?go=search{query-groups}">{translate=lang_140}</a></div>
</div>
<input type="hidden" value="{type}" id="se_type_full" />
<div class="clr"></div>
[yes]<div class="search_result_title">[no-online]{translate=lang_471}[/no-online][online]{translate=lang_463}[/online] {count}</div>[/yes]