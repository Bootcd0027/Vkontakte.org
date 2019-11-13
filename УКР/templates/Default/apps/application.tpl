<script type="text/javascript">

// SHOWS MINIMAL FACEMY

$(document).ready(function(){

	$('.fm-menu').hide();

	$('.fm-index_format').css('width', {width});

	$('.fm-footer').css('width', {width});

});

</script>

<div id="apps_view_wrape">

<div class="fl_l">

<img width="30" height="30" style="float:left;margin-right:10px" src="{ava}">

</div>

<div class="fl_l">

<div>{title}</div>

<div class="apps_start_traf">{nums}</div>

</div>

<div style="margin-top:3px;margin-right: 3px;">

<div class="button_div fl_r margin_left"><button onClick="Page.Go(this.href='/apps'); clear_style();">Все приложения</button></div>

<div class="button_div fl_r margin_left"><button onclick="apps.sendWall('{id}');">Рассказать друзьям</button></div>

[install][/install]

[not-install]<div class="button_div fl_r margin_left"><button onclick="apps.loadSettings('{id}','{hash}');">Настройки</button></div>[/not-install]

[edit]<div id="apps_rdel_txt"><div class="button_div_gray fl_r margin_left"><button onClick="Page.Go('/editapp/info_{id}'); clear_style();">Редактировать</button></div></div>

[/edit]

<div class="clear"></div>

</div>

<div class="clear"></div>

</div>

<div class="clear"></div>

<div class="apps_faslh_pos">

[iframe]

<iframe name="fXD6c7b8" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" frameborder="0" src="{url}?api_url={site}api.php&amp;api_id={id}&amp;viewer_id={viewer_id}&amp;access_token=5e5c0a3dc3d5f9331b0d832ade9630260a0dd6965fd05a4df45cd9318c80e5574a1d8c37e2335fdae54b4&amp;user_id={viewer_id}&amp;auth_key={auth_key}&amp;hash=" scrolling="no" style="width: {width}px; height: {height}px;"></iframe>

[/iframe]

[flash]

<object width="{width}" height="{height}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">

	<param value="sameDomain" name="allowScriptAccess">

	<param value="/uploads/apps/{id}/{flash}" name="movie">

	<param value="high" name="quality">

	<embed width="{width}" height="{height}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowscriptaccess="sameDomain" quality="high" src="/uploads/apps/{id}/{flash}">

	</object>

[/flash]

</div>

<div class="clear"></div>
