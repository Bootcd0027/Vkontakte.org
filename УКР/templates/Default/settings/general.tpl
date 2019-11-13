<script type="text/javascript">
$(document).ready(function(){
	var arr = ["{translate=lang_813}","{translate=lang_815}","{translate=lang_816}","{translate=lang_817}","{translate=lang_818}","{translate=lang_820}","{translate=lang_821}","{translate=lang_822}","{translate=lang_823}","{translate=lang_824}","{translate=lang_826}","{translate=lang_827}","{translate=lang_975}","{translate=lang_830}","Стикеры","{translate=lang_972}"];
	var num = 0;
	while (typeof arr[num] != 'undefined'){
		$('#settings_services').append('<div class="texta"><div id="settings_labelg'+num+'" class="fl_l no_display"  style="margin-top:7px;margin-left:10px;">Изменения сохранены</div>&nbsp;</div><div id="g'+num+'" class="html_checkbox_menu margin_top_10" onclick="lin.chekbox(\'g'+num+'\');">'+arr[num]+'</div><div class="mgclr"></div>');
		if($.cookie('g'+num)){$('#g'+num).addClass('html_checked_menu');}
		num++;
	}
	
});
var lin = {
	chekbox:function(id){
		$('#settings_label'+id).fadeIn(2000).fadeOut(2000);
		if($('#'+id).is('.html_checked_menu')){
			$('#'+id).removeClass('html_checked_menu');
			$('#i'+id).removeClass('no_display');
			$.cookie(id,null);
		}else{ 
			$('#'+id).addClass('html_checked_menu');
			$('#i'+id).addClass('no_display');
			$.cookie(id,id, {path: "/",expires:365});
		}
	}
}
</script>
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
  <div class="buttonsprofileSec"><a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a></div>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;"><div>Оповещения</div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
<a href="/balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a>
<a href="/balance?act=history" onClick="Page.Go(this.href); return false;"><div>История</div></a>
<a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div>Приглашённые друзья</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои подарки</div></a>
 </div>
 </div>
<div class="settings_general">
<div class="settings_section">
<div class="clear"></div>
<div class="err_yellow name_errors {code-1}" style="font-weight:normal;margin-top:25px">Код активации из письма с текущего почтового ящика принят. Осталось подтвердить код активации в письме, отправленном на новый почтовый ящик</div>
<div class="err_yellow name_errors {code-2}" style="font-weight:normal;margin-top:25px">Код активации из письма с нового почтового ящика принят. Осталось подтвердить код активации в письме, отправленном на текущий почтовый ящик</div>
<div class="err_yellow name_errors {code-3}" style="font-weight:normal;margin-top:25px">Адрес Вашей электронной почты был успешно изменен на новый</div>



<div class="margin_top_10"></div><div class="allbar_title">Данные страницы</div>
<div class="err_yellow no_display name_errors" id="ok" style="font-weight:normal;">Страница <b>успешно</b> подтверждена</div>
<div class="err_red no_display pass_errors" id="no_ok" style="font-weight:normal;">Вы ввели неправильный код</div>
<div class="err_yellow no_display pass_errors" id="no_text" style="font-weight:normal;">Поле нельзя оставлять пустым</div>
<div class="texta">Номер страницы:</div><div style="color:#555;margin-top:13px;margin-bottom:10px">{id}</div><div class="mgclr"></div>
<div class="texta">Рейтинг страницы:</div><div style="color:#555;margin-top:13px;margin-bottom:10px">{rate}</div><div class="mgclr"></div>

<br><br><div class="allbar_title">Дополнительные сервисы</div>
<div style="color: #666666;">Укажите ссылки, которые Вы хотели бы видеть в меню слева:</div>
<div id="settings_services"></div>
<div class="mgclr"></div>

<div class="margin_top_10"></div><div class="allbar_title">Изменить пароль</div></br>

<div class="err_red no_display pass_errors" id="err_pass_1" style="font-weight:normal;">Пароль не изменён, так как прежний пароль введён неправильно</div>
<div class="err_red no_display pass_errors" id="err_pass_2" style="font-weight:normal;">Пароль не изменён, так как новый пароль повторен неправильно</div>
<div class="err_yellow no_display pass_errors" id="ok_pass" style="font-weight:normal;">Пароль <b>успешно</b> изменён</div>
<div class="texta">Старый пароль:</div><input type="password" id="old_pass" class="inpst" maxlength="100" style="width:150px;" /><span id="validOldpass"></span><div class="mgclr"></div>
<div class="texta">Новый пароль:</div><input type="password" id="new_pass" class="inpst" maxlength="100" style="width:150px;" onMouseOver="myhtml.title('', 'Пароль должен быть не менее 6 символов в длину', 'new_pass')" /><span id="validNewpass"></span><div class="mgclr"></div>
<div class="texta">Повторите пароль:</div><input type="password" id="new_pass2" class="inpst" maxlength="100" style="width:150px;" onMouseOver="myhtml.title('', 'Введите еще раз новый пароль', 'new_pass2')" /><span id="validNewpass2"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button onClick="settings.saveNewPwd(); return false" id="saveNewPwd">Изменить пароль</button></div><div class="mgclr"></div>

<div class="allbar_title">Безопасность Вашей страницы</div>
<div class="texta">Последняя активность:</div>
<div style="margin:3px 0" class="fl_l" id="acts" onmouseover="myhtml.title('', 'IP последнего посещения {ip}', 'acts')">{log-user}</div>
<div class="mgclr"></div>
<div class="margin_top_10"></div>
<div class="margin_top_10"></div>
<div class="mgclr"></div>
<div class="texta">&nbsp;</div>
<div class="button_div fl_l">
<button onClick="settings.logs(); return false">Посмотреть историю активности</button>
</div>
<div class="mgclr"></div>

<div class="margin_top_10"></div><div class="allbar_title">Изменить имя или фамилию</div>
<div class="err_red no_display name_errors" id="err_name_1" style="font-weight:normal;">Специальные символы и пробелы запрещены</div>
<div class="err_yellow no_display name_errors" id="ok_name" style="font-weight:normal;">Изменения успешно сохранены</div>
<div class="texta">Ваше имя:</div><input type="text" id="name" class="inpst" maxlength="100"  style="width:150px;" value="{name}" /><span id="validName"></span><div class="mgclr"></div>
<div class="texta">Ваша фамилия:</div><input type="text" id="lastname" class="inpst" maxlength="100"  style="width:150px;" value="{lastname}" /><span id="validLastname"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button onClick="settings.saveNewName(); return false" id="saveNewName">Изменить имя</button></div><div class="mgclr"></div>
<div class="margin_top_10"></div><div class="allbar_title">Адрес Вашей электронной почты</div>
<div class="err_yellow name_errors no_display" id="ok_email" style="font-weight:normal;">На <b>оба</b> почтовых ящика придут письма с подтверждением</div>
<div class="err_red no_display name_errors" id="err_email" style="font-weight:normal;">Неправильный email адрес</div>
<div class="texta">Текущий адрес:</div><div style="color:#555;margin-top:13px;margin-bottom:10px">{email}</div><div class="mgclr"></div>
<div class="texta">Новый адрес:</div><input type="text" id="email" class="inpst" maxlength="100" style="width:150px;" /><span id="validName"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button onClick="settings.savenewmail(); return false" id="saveNewEmail">Сохранить адрес</button></div><div class="mgclr"></div>

<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=settings&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
		if (!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
			Box.Info('load_photo_er', lang_dd2f_no, lang_bad_format, 400);
				return false;
			}
			butloading('upload', '113', 'disabled', '');
		},
		onComplete: function (file, response) {
			if(response == 'bad_format')
				$('.err_red').show().text(lang_bad_format);
			else if(response == 'big_size')
				$('.err_red').show().html(lang_bad_size);
			else if(response == 'bad')
				$('.err_red').show().text(lang_bad_aaa);
			else {
				Box.Close('photo');
				$('#photo_ver').html('<img width="210px" height="120px" src="'+response+'" alt="" />');
				$('body, html').animate({scrollTop: 0}, 250);
				$('.load_photo_but').hide();
				$('#ok_ver').show();
			}
		}
	});
});
</script>

<div class="margin_top_10"></div><div class="allbar_title">Номер Вашего телефона</div>
<div class="err_yellow no_display name_errors" id="ok_sms" style="font-weight:normal;">Номер телефона был успешно изменен.</div>
<div class="texta">Текущий номер:</div><div style="color:#555;margin-top:13px;margin-bottom:10px">{phone}</div><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button onClick="settings.sms(); return false">Изменить номер телефона</button></div><div class="mgclr"></div>


<div class="margin_top_10"></div><div class="allbar_title">Верификация страницы</div>
<div class="err_yellow name_errors no_display" id="ok_ver" style="font-weight:normal;">Заявка была <b>успешно</b> отправлена.</div>
<div style="color:#555;margin-bottom:10px">{verification-type}</div><div class="mgclr"></div>
{verification-button}
<div id="photo_ver"></div>

<div class="margin_top_10"></div><div class="allbar_title">Адрес Вашей страницы</div>
<div class="err_yellow no_display name_errors" id="ok_alias" style="font-weight:normal;">Адрес персональной страницы был <b>успешно</b> установлен.</div>
<div class="err_red no_display name_errors" id="err_alias_str" style="font-weight:normal;">Неправильный адрес.</div>
<div class="err_red no_display name_errors" id="err_alias_name" style="font-weight:normal;">Адрес уже занят.</div>
<div style="color:#555;margin-bottom:10px"><div class="item_info">Вы можете установить удобный для вас адрес персональной страницы. Адрес должен быть не менее 5 символов,<br> свободен и состоять из букв латинского алфавита.</div></div>
<div class="texta">Личный адрес: onepuls.ru/</div></font><input type="text" id="alias" class="inpst" maxlength="10"  style="width:150px;" value=" {alias}" /><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button onClick="settings.savealias(); return false" id="saveAlias">Сохранить</button></div><div class="mgclr"></div>


<div class="allbar_title">Перерасчет данных</div>

<div style="margin-bottom: 8px;color: #666666;text-align: centr;"><div class="item_info">Если количество ваших подписчиков, друзей или количество заявок отображается неверно, либо не отображается вообще, то используйте данную функцию.</div></div>
<div class="err_yellow no_display name_errors" id="ok_recheck" style="font-weight:normal;">Показатели <b>успешно</b> пересчитаны</div>
<div class="err_red no_display pass_errors" id="no_ok_recheck" style="font-weight:normal;">Ошибка в пересчете</div>
<div class="texta">&nbsp;</div>
<div class="button_div fl_l"><button onClick="settings.recheck(); return false" id="saverecheck">Пересчитать показатели</button></div>
<div class="mgclr"></div>

<div class="allbar_diz">Настройки внешнего вида</div>
<div class="texta_diz">
<a  href="/editmypage/def"><span class="des cer select"></span></a>
<a href="/editmypage/green"><span class="des green select"></span></a>
</div>
</div>
<div class="mgclr"></div>


<div class="allbar_title">Советуем подписаться</div>

{pages}
<div class="mgclr"></div>
</div>

<div class="allbar_title_delet"></div>
<div class="settings_view_as_text clear_fix" align="center">
Социальные сети - это полезный инструмент, но бывает случается так, что они отнимают больше времени, чем Вы можете себе позволить. В этом случае выход один
<a class="cursor_pointer" onClick="delMyPage()">удалить свою страницу</a>.
</div>