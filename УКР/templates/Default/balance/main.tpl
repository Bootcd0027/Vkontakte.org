<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a>
<a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a>
 <a href="/settings/notify" onClick="Page.Go(this.href); return false;"><div>Оповещения</div></a>
<a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
  <div class="buttonsprofileSec"><a href="/balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a></div>
<a href="/balance?act=history" onClick="Page.Go(this.href); return false;"><div>История</div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div>Приглашённые друзья</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои подарки</div></a>
 </div>
</div>
<div class="settings_balance">
<div class="setbal_section">
<div class="margin_top_10"></div><div class="allbar_title">Состояние личного счёта</div>
<div class="ubm_descr">
<div class="item_info">
<b>Голоса</b> – это универсальная валюта для всех приложений на нашем сайте.Обратите внимание, что услуга считается оказанной в момент зачисления голосов, возврат невозможен. Кроме этого за каждого приглашённого друга по вашей ссылке, Вы будете получать по <b>10 голосов</b>, также каждый день на ваш счёт будет начисляться по <b>1 голосу</b>, если вы заходили в течении дня на сайт.
</div>
<br />
<br />
<center><span class="color777">На Вашем счёте:</span>&nbsp;&nbsp; <b><span id="num2">{ubm}</span> голос/ов</b> и <b><span id="rub2">{rub}</span> {text-rub}</b></center>
<div style="margin-left:-60px;"><div class="button_div fl_l" style="line-height:15px;margin-left:172px;margin-top:15px"><button onClick="doLoad.data(2); payment.box_two();" style="width:161px">Купить голоса</button></div>
<div class="button_div_gray fl_l" style="line-height:15px;margin-left:172px;margin-top:15px"><button onClick="doLoad.data(2); payment.box()" style="width:161px">Пополнить баланс</button></div>
<div class="button_div_gray fl_l" style="line-height:15px;margin-left:172px;margin-top:15px"><button onClick="alert('{msg}')" style="width:161px">Вывести деньги</button></div>
<div class="button_div fl_l" style="line-height:15px;margin-left:172px;margin-top:15px"><button onClick="doLoad.data(2); payment.box_tree();" style="width:161px">Обменять голоса на руб.</button></div></div>
<div class="clear"></div>
<div style="margin-top:30px;">
<div class="margin_top_10"></div><div class="allbar_title">Инструкция по приглашению друга</div>
<div class="ubm_descr">
<center>
Для приглашения друга отправьте ему ссылку на регистрацию,
</br>которая указана ниже.<br /><br />
<span class="color777">Ваша ссылка для приглашения:</span>&nbsp;&nbsp; 
<input type="text" 
	class="videos_input" 
	style="width:200px"
	onClick="this.select()"
	value="http://onepuls.ru/reg{uid}"/>


</div></div>
</div></div>


<div class="settings_view_as_text clear_fix" style="line-height: 140%;padding: 10px;text-align: center;background: none repeat scroll 0 0 #FFFFFF;border-top: 1px solid #DAE1E8; width:700px;margin-left:-32px;border-radius: 0 0 5px 5px;" align="center">
<div>
Если у Вас возникли проблемы, обратитесь в
<a onclick="Page.Go(this.href); return false;" href="/support?act=new">платёжную поддержку</a>
.
</div>
</div>