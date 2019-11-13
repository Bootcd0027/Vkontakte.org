<link media="screen" href="{theme}/loto/loto.css" type="text/css" rel="stylesheet" />
<img src="{theme}/loto/loto.jpg" style="position:absolute;z-index:1;margin-left:25px;margin-top:20px;border-radius:10px;">
<img src="{theme}/loto/loto-fon.jpg" style="position:absolute">  
<div id="maindiv" style="width: 400px;height: 280px;background-color: #ced7df;border-radius: 20px;color: #ffffff;padding: 25px;opacity: 0.8;margin-left:180px;margin-top:200px;">
<div style="background-color: #000000;padding: 25px;border-radius: 20px;">
Ваш баланс <b>{balance}</b> голосов.<br><br>
Система загадывает цифру от <b>1</b> до <b>3</b>.<br>Если Вы отгадали, ставка - возвращается в удвоенном размере.
<br><br><br>

<center>
      <form method="POST" action="/?go=loto&act=go">
<div style="font-size:20px;"><b>Число</b>
<select id="num" name="num" class=" " style="width:80px;height:35px;font-size:30px;">
  <option> </option>
  <option value="1">1</option><option value="2">2</option><option value="3">3</option>
 </select>
<select id="golos" name="golos" class=" " style="width:80px;height:35px;font-size:30px;">
  <option> </option>
  <option value="1">1</option><option value="10">10</option><option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
 </select> <b>Ставка</b></div></center>
<br><br><br>
<div class="button_div fl_r" style="margin-right:152px"><button type="submit">Го-го</button></div><br>
</form>
</div>
<center><br><br>Проигранные голоса мы не возвращаем!</center>
</div>