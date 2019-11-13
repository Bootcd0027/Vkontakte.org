<script type="text/javascript">
$(document).ready(function(){
  $('#rate_num').focus().val('1');
  rating.update();
});
</script>
<div id="newbox_miniaturerate" class="vii_box">
<div class="miniature_box">
<div class="miniature_pos" style="width:400px;">
<div class="miniature_title fl_l apps_box_text">Рейтинг</div>
<a class="cursor_pointer fl_r" onclick="viiBox.clos('rate', 1)" style="font-size:12px">Закрыть</a>
<div style="border-bottom: 1px solid #DAE1E8;margin-top:20px;"></div>
<div class="clear"></div>
<div class="rating_text">Это рейтинг пользователя, он влияет на место в поиске. Чем выше ваш рейтинг, тем выше вы в поиске. Пополнить рейтинг можно заходя каждый день на сайт или отправляя подарки вашим друзьям. Кроме этого, вы можете купить рейтинг за классы: </div>
<div class="rating_iny">
+
<input id="rate_num" class="inpst" type="text" onkeyup="rating.update()" maxlength="3">
<div class="rating_text_balance">У Вас <span id="rt">останется</span> <b id="num">{num}</b> голосов</div>
<input type="hidden" id="balance" value="{balance}" />
</div>

<div class="button_div fl_l" style="margin-left:140px"><button onClick="rating.save('{user-id}')" id="saverate" formmethod="post">Повысить рейтинг</button></div>

<div class="clear"></div>

</div>

</div>