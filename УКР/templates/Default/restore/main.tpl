<style type="text/css" media="all">
html,body{background: url("/templates/Default/Eojvi/css/13652123_muy_schastlivuy.jpg") no-repeat;-moz-background-size: 100%;background-size: 100%;}
.pg1{width:500px;border:1px solid #eee;margin:auto;padding:20px;background:#fff;box-shadow:0px 2px 8px 1px #ccc;-moz-box-shadow:0px 2px 8px 1px #ccc;-webkit-box-shadow:0px 2px 8px 1px #ccc;line-height:18px;text-align:center;margin-top:100px;font-family:Tahoma;font-size:12px;color:#000}
.title{color:#21578b;font-weight:bold;border-bottom:1px solid #F1F4F7;padding-bottom:5px;text-align:left;margin-bottom:10px}
.pg1 span{color:#21578b;}
.inp{font-size:11px;font-family:Tahoma;padding:5px;border:1px solid #ddd;width:150px}
.button{border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;font-size:11px;color:#fff;width:150px;text-align:center;background:#4b80b5;font-family:Tahoma;border:1px solid #2a5f94;text-shadow:0px 1px 0px #2a5f94;margin-top:15px;padding-top:3px;padding-bottom:3px;cursor:pointer}
.err_yellow{padding:10px;background:#fbf9ee;border:1px solid #d4bc4c;margin-bottom:10px;text-align:left;font-size:11px;display:none}
.err_red{padding:10px;background:#fbf9ee;border:1px solid #d4bc4c;margin-bottom:10px;line-height:17px;text-align:left;font-size:11px;display:none}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#phone').val('+7').focus();
});
function sendCode(){
	var number = $('#phone').val();
	
	$.post('/?go=smsactivate&act=newpass', {number: number}, function(d){
		if(d == 1){
			$('.err_yellow').show();
			$('.err_red').hide();
			
		} else if(d == 2) {
			$('.err_red').html('<b>Мобильный номер не зарегестрирован.</b><br />Номер <b>'+number+'</b> не используется пользователем сайта.').show();
			
		} else if(d == 5) {
			$('.err_red').html('<b>Лимит.</b><br />У Вас исчерпан лимит на получение подтверждающего кода.').show();
			
		} else {
			$('.err_red').html('<b>Некорректный мобильный номер.</b><br />Необходимо корректно ввести номер в международном формате, например +79210000000.').show();
			
		}
		$('#loading').hide();
	});
}
</script>

<div class="search_form_tab_restore">
 <div class="buttonsprofile albumsbuttonsprofile" style="height:14px">
</div>
</div>
<div style="margin-top:9px"></div>

<div style="background:none repeat scroll 0 0 rgba(0, 0, 0, 0.3);width: 500px;margin: 90px auto;border: 0px solid #e4e7eb;border-radius:3px 3px 3px 3px;" class="note_add_bg support_bg" id="step1">
<a style="margin-top:-5px; float:right" href="/"><span style="color:#ffffff">Закрыть</span></a>
<div><h1>Восстановление доступа к странице</h1></div>

 <div class="err_red"></div>
 <div class="err_yellow"><b>Новый пароль отправлен.</b><br />На Ваш телефон в течение нескольких секунд придет <b>новый пароль</b>.<br /><br /><a href="/index.php">Введите полученный пароль здесь >>></a></div>
<h1 style="font-size:12px; border:none;color:#DDDDDD">Пожалуйста, выберите способ восстановления пароля.</h1>
 
 <div style="width:300px;">
<h1 style="border:none">Быстрое восстановление пароля</h1></b>
 <div style="margin-top:5px">
 <span style="color:#DDDDDD;">Телефон:</span> <input type="text" class="inp" id="phone" style="width:152px;border-radius: 3px 3px 3px 3px;" value="" />
 </div>
<div class="button_div_restore" style="margin-top:10px;"><button style="margin-left:0px;width:164px" onclick="sendCode();">Восстановить доступ</button></div>
  <div style="margin-top:10px" class="nomob"><a float:right" href="/index.php"><span style="color: gray;">Я не привязывал страницу к телефону</span></a></div>
 </div> 
<h1 style="border:none">Восстановление пароля по e-mail</h1>
<div class="err_red no_display name_errors" id="err" style="font-weight:normal;width:370px"></div>
<div style="margin-top:10px" class="mail"><span style="color:#dddddd;">Укажите <b>e-mail</b>, который Вы использовали для входа на сайт.</span></div> 
<input type="text" 
	class="videos_input fl_l" 
	style="width:300px;margin-top:10px;color:#c1cad0" 
	maxlength="65" 
	id="email"
	onblur="if(this.value==''){this.value='Ваш электронный адрес';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='Ваш электронный адрес'){this.value='';this.style.color = '#000'}"
	value="Ваш электронный адрес"/>
<div class="button_div fl_l margin_left" style="margin-top:11px"><button onClick="restore.next(); return false" id="send">Далее</button></div>
<div class="clear"></div>

<div class="" style="width:315px"></div>
</div>
<div style="width: 500px;margin: 50px auto;border: 0px solid #e4e7eb;border-radius: 7px 7px 7px 7px;background: none repeat scroll 0 0 rgba(0, 0, 0, 0.3);" class="note_add_bg support_bg no_display" id="step2">
<span style="color:#ffffff;">Это та страница, к которой необходимо восстановить доступ?</span>
<div class="clear"></div>
<img src="" alt="" style="margin-top:11px;margin-right:10px" align="left" id="c_src" />
<div style="margin-top:11px;font-size:13px;color:#dddddd" id="c_name"></div>
<div class="clear"></div>
<div class="button_div fl_l" style="margin-top:11px"><button onClick="restore.send(); return false" id="send2">Да, это нужная страница</button></div>
<div class="clear"></div>
</div>
<div style="width: 500px;margin: 50px auto;border: 0px solid #e4e7eb;border-radius: 3px 3px 3px 3px;background: none repeat scroll 0 0 rgba(0, 0, 0, 0.3);" class="note_add_bg support_bg no_display"  id="step3"><span style="color:#ffffff;">На ваш электронный ящик были высланы инструкции по восстановлению пароля.</span>
<br/><br/>
<center><a href="http://onepuls.ru"><span style="color:#dddddd;">На главную страницу</span></a></center>
</div>
<br><br>