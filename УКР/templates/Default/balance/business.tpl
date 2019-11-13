<script type="text/javascript">
$(document).ready(function(){
	aj1 = new AjaxUpload('upload', {
		action: '/index.php?go=balance&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|jpeg|jpe)$/.test(ext))){
				addAllErr('Загружать разрешено только фотографии в формате JPG.', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			Page.Loading('stop');
			if(response == 1) addAllErr('Загружать разрешено только фотографии в формате JPG.', 3300);
			else if(response == 2) addAllErr('Максимальны размер 5 МБ.', 3300);
			else if(response == 3) addAllErr('Картинка объязательно должна быть разрешения 256х256.', 3300);
			else if(response == 4) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
			else {
				$('#file1').html('<div class="texta" style="width:300px">&nbsp;</div><img id="img1" src="/uploads/gifts/'+response+'" style="margin-top:10px" />').show();
			}
		}
	});	
	aj2 = new AjaxUpload('upload_2', {
		action: '/index.php?go=balance&act=upload_2',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(png)$/.test(ext))){
				addAllErr('Загружать разрешено только фотографии в формате PNG.', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			Page.Loading('stop');
			if(response == 1) addAllErr('Загружать разрешено только фотографии в формате PNG.', 3300);
			else if(response == 2) addAllErr('Максимальны размер 5 МБ.', 3300);
			else if(response == 3) addAllErr('Картинка объязательно должна быть разрешения 96х96.', 3300);
			else if(response == 4) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
			else {
				$('#file2').html('<div class="texta" style="width:300px">&nbsp;</div><img id="img2" src="/uploads/gifts/'+response+'" style="margin-top:10px" />').show();
			}
		}
	});
});
</script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
<a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a>
<a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a>
<a href="/settings/notify" onClick="Page.Go(this.href); return false;"><div>Оповещения</div></a>
<a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
<a href="/balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a>
  <a href="/balance?act=history" onClick="Page.Go(this.href); return false;"><div>История</div></a>
 <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;">Приглашённые друзья</a>
 <div class="buttonsprofileSec"><a href="/balance?act=business" onClick="Page.Go(this.href); return false;">Мои подарки</a></div>
</div></div>
<div class="margin_top_10" style="margin-top:12px;"></div>
<div class="allbar_title_black" style="margin-bottom:10px;">
<span style="margin-left:10px;">Добавление нового подарка</span>
</div>
<div class="page_bg margin_top_10 border_radius_5">
<div class="err_yellow name_errors no_display" id="ok" style="font-weight:normal;margin-top:5px">Ваш подарок отправлен на проверку.</div>
 <div class="texta" style="width:300px">Цена:</div><input type="text" id="price" class="inpst" maxlength="5"  style="width:50px;" /><div class="mgclr"></div>
 <div class="texta" style="width:300px">Категория:</div><select class="inpst" id="cat"><option value="0"></option>{cats}</select><div class="mgclr"></div>
 <div class="texta" style="width:300px;padding-top:6px">Оригинал <b>.JPG</b>, 256x256:</div><div class="button_div_gray fl_l"><button id="upload">Выбрать файл</button></div><div class="mgclr"></div>
 <div id="file1" class="no_display"><div class="texta">&nbsp;</div><img src="" id="img1" /></div>
 <div class="mgclr" style="height:5px"></div>
 <div class="texta" style="width:300px;padding-top:16px">Уменьшеная копия <b>.PNG</b>(прозрачный фон), 96x96:</div><div class="button_div_gray fl_l" style="margin-top:10px"><button id="upload_2">Выбрать файл</button></div><div class="mgclr"></div>
 <div id="file2" class="no_display"><div class="texta">&nbsp;</div><img src="" id="img2" /></div>
 <div class="mgclr"></div>
 <div class="texta" style="width:300px">&nbsp;</div><div class="button_div fl_l" style="margin-top:10px"><button onClick="balance.sendgift()" id="sending">Отправить</button></div><div class="mgclr"></div>
 [ver]<div class="texta" style="width:300px">&nbsp;</div><div class="button_div_gray fl_l" style="margin-top:10px"><button onClick="balance.box('{business_rating}')">Увеличить лимит подарков на +1</button></div><div class="mgclr"></div>[/ver]
</div>
[gifts]<div class="allbar_title">Статистика Ваших подарков<div class="fl_r online_bus">Всего заработано: <b>{num}</b> голосов</div></div>
<div class="page_bg margin_top_10 border_radius_5">{my-gifts}<div class="clear"></div></div>[/gifts]