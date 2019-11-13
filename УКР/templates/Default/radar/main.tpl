<div class="allbar_title">Приложение Радар</div>
<label class="block_label" for="oldpw" style="width:400px">
<b>Радар</b> – это сервис, позволяющий самым общительным пользователям найти больше друзей на Onepuls.ru. <br /><br />
<table border=0><tr><td>
<div id="reclama">
<b>Хочу общаться</b><br></br>
<a href="/u{user_id}" onClick="Page.Go(this.href); return false;"><img src="{user_ava}"><br>{user_name}</a>
<br></br>
<a href="/radar" style="color:#999999">как сюда попасть?</a>
</div>
</td>
<td width=20> </td>
<td>
<div class="note_text">
Радар выводится и виден пользователям в зависимости от их настроек.<br />  
Сервис "Радар" является платным.<br />  
После активации сервиса "Радар" он будет действовать в течении 1 суток.<br />  Другими словами вы покупаете данную услугу на одни сутки с момента активации.<br /> <br /> 

Цена - {price} голосов.<br />

<b>{ubm}</b></label><br /><br />
<div class="button_div fl_l margin_top_10">
<button class="btn btn-mini btn-success {on}" onClick="Radar.on(); return false" id="RadarOn">Включить</button>
<button class="btn btn-mini btn-success {off}" onClick="Radar.off(); return false" id="RadarOff">Отключить</button>
</div> 
</td></tr></table><br /><br />

<label class="block_label" for="oldpw" style="width:400px">
<b>Группы</b> – в которых вы админ... <br /><br />

<select id="public_id" class="inpst"  style="margin-bottom: 10px; width:270px" onclick="Radar.infocomm(this.value); return false;">{public}</select>
	
<table border=0><tr><td>
<div id="reclama">
<b>Присоединяйтесь</b><br></br>
<a href="/public{public_id}" id="link" onClick="Page.Go(this.href); return false;"><img src="{ava}" id="lgimg"><br><span id="title">{photo}</span></a>
<br></br>
<a href="/radar" style="color:#999999">как сюда попасть?</a>
</div>
</td>
<td width=20> </td>
<td>
<div class="note_text">
Вы можете вывести рекламу своей группы в левую часть экрана.<br /> <br /> 

Цена - {comm_price} голосов за 1000 показов.<br />

<b>{comm_ubm}</b></label><br /><br />
<div id="pokaz_on"  class="{comm_on}">Количество показаов группы: <span id="col_pokaz">{pokaz}</span></div>
<div id="pokaz_off" class="{comm_off}">Группа не отображается в радаре. Вы можите пополнить количество показов группы.</div> <br />

<div class="button_div fl_l margin_top_10">
<button class="btn btn-mini btn-success" onClick="Radar.add(); return false" id="Radarcomm">Пополнить</button>
</div>

</div> 
</td></tr></table><br /><br />