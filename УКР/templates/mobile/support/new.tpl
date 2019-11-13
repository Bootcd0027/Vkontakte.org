<div id="data">
<div class="tmenuf">
 <a href="/support">[group=4]{translate=lang_496}[/group][not-group=4]{translate=lang_497}[/not-group]</a>
 [not-group=4]<div><a href="/support?act=new">{translate=lang_498}</a></div>[/not-group]
</div>
<div class="clr"></div>
[not-group=4]
<div class="support_bg">
<input type="text" 
	class="inp" 
	style="width:99%;margin-bottom:10px" 
	maxlength="65" 
	id="title"
	placeholder="{translate=lang_500}" 
/>
<textarea 
	class="inp" 
	id="question" 
	style="width:99%;height:100px;margin-bottom:10px;"
	placeholder="{translate=lang_501}"
></textarea>
<div class="clear"></div>
<button onClick="support.send(); return false" id="send" class="button">{translate=lang_32}</button>
<div class="clear"></div>
</div>
[/not-group]
[group=4]<div class="info_center"><br /><br /><br />{translate=lang_503}<br /><br /><br /></div>[/group]
</div>