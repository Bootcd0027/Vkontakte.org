<script type="text/javascript">
doLoad.data(5);
$(document).ready(function(){
  Xajax = new AjaxUpload('upload', {
    action: '/index.php?go=mybanners&act=upload',
    name: 'uploadfile',
    onSubmit: function(file, ext){
      if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))){
        addAllErr(lang_bad_format, 2000);
        return false;
      }
      Page.Loading('start');
    },
    onComplete: function (file, response){
      Page.Loading('stop');
      if(response == 1) addAllErr('Максимальны размер 1 МБ.', 2000);
      else if(response == 2) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
      else $('#docver').html('<div class="texta" style="width:180px">&nbsp;</div><div id="src" data="'+response+'" style="color:green;margin-top:10px;margin-bottom:-10px">Изображение загружено!</div>');
    }
  });
});
</script>
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
<div class="buttonsprofileSec"><a href="/ads&act=ads_view_my" onClick="Page.Go(this.href); return false;"><div>Покупка рекламы</div></a></div>

<a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;">Таргетинг</a>

<div class="clear"></div>

</div>
</div>
<div class="clear"></div>
<div class="margin_top_10" style="margin-top:1px;"></div>
<div class="allbar_title_black" style="margin-bottom:10px;">
<span style="margin-left:10px;">Настройки рекламы</span>
</div>
<div class="page_bg border_radius_5 margin_top_10 margin_bottom_10">
<div class="err_yellow_2 no_display" style="font-weight:normal">Сохранено.</div>
<div class="texta" style="width:180px">Тематика показываемой рекламы:</div>
 <select id="cat_v" class="inpst" style="width:250px">
  <option value="0">Любая</option>
  {cat-2}
 </select>
<div class="mgclr"></div>
<div class="texta"  style="width:180px">&nbsp;</div>
 <div class="button_div fl_l"><button onClick="mybanners.save_sett()" id="sending_2">Сохранить</button></div>
<div class="mgclr"></div>
</div>
<div class="allbar_title">Покупка рекламы</div>
<div class="page_bg border_radius_5 margin_top_10">
<div class="err_red no_display" style="font-weight:normal">У Вас недостаточно рублей на счету. <a class="cursor_pointer" onClick="doLoad.data(2); payment.box()">Пополнить баланс</a></div>
<div class="err_yellow no_display" style="font-weight:normal">Заявка на рекламу успешно отправлена.</div>
<div class="texta" style="width:180px">Тематика:</div>
 <select id="cat" class="inpst" style="width:250px">
  <option value="0">Любая</option>
  {cat}
 </select>
<div class="mgclr"></div>
<div class="texta" style="width:180px">Расположение рекламы:</div>
 <select id="pos" class="inpst" style="width:250px" onChange="mybanners.update();if(this.value == 5){$('#b').show()}else{$('#b').hide()}">
  <option value="3">Слева №1 (65x90)</option>
  <option value="4">Слева №2 (65x90)</option>
  <option value="5">Слева №3 (65x90)</option>
 </select>
<div class="mgclr"></div>
<div class="texta" style="width:180px">Ссылка:</div>
 <input type="text" id="link" class="inpst" style="width:239px" />
<div class="mgclr"></div>
<div class="texta" style="width:180px">Заголовок:</div>
 <input type="text" id="title" class="inpst" style="width:239px" />
<div class="mgclr"></div>
<div class="texta" style="width:180px">Описание:</div>
 <textarea type="text" id="descr" class="inpst" style="width:239px;height:40px"></textarea>
<div class="mgclr"></div>
<div class="texta" style="padding-top:12px;width:180px">Изображение:</div>
 <div class="button_div_gray fl_l" style="margin-top:5px"><button id="upload">Загрузить изображение</button></div>
<div class="mgclr"></div>
<div id="docver"></div>
<div class="clear margin_top_10" style="margin-top:15px"></div>
<div class="texta" style="width:180px">Сколько переходов:</div>
 <input type="text" class="inpst" id="transitions" style="width:40px" onKeyUp="mybanners.update()" maxlength="6" /><br />
 <div style="margin-left:185px"><small>К оплате <b><span id="cost_num">0</span> руб.</b></small></div>
<div class="mgclr"></div>
<span id="b" class="no_display"><div class="texta" style="width:180px">Ваша цена выкупа за переход:</div>
 <input type="text" class="inpst" id="redemption" style="width:40px" /><br />
<div class="mgclr"></div></span>
<div class="texta" style="width:180px">&nbsp;</div>
 <div class="button_div fl_l"><button onClick="mybanners.send()" id="sending">Оплатить</button></div>
<div class="mgclr"></div>
</div>
<input type="hidden" id="cost_banner_top" value="{cost_banner_top}" />
<input type="hidden" id="cost_banner_bottom" value="{cost_banner_bottom}" />
<input type="hidden" id="cost_banner_right_1" value="{cost_banner_right_1}" />
<input type="hidden" id="cost_banner_right_2" value="{cost_banner_right_2}" />
<input type="hidden" id="cost_banner_right_3" value="{cost_banner_right_3}" />
<div class="allbar_title">Купленная реклама</div>
{banners}