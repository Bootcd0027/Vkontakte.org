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
{ans}
</form>
</div>
<center><br><br>Проигранные голоса мы не возвращаем!</center>
</div>