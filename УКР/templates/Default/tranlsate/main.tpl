<script type="text/javascript">
function checkLang(){
  var translateTxt1 = $('#translateTxt1').val();
  var pattern = new RegExp(/[а-яА-Я0-9]/i);
  if(pattern.test(translateTxt1)){
    $('#sl').html('<option value="1" selected>С Языка: русский / russian</option><option value="2">С Языка: английский / english</option>');
    $('#tl').html('<option value="1">На: русский / russian</option><option value="2" selected>На: английский / english</option>');
  } else {
    $('#sl').html('<option value="1">С Языка: русский / russian</option><option value="2" selected>С Языка: английский / english</option>');
	$('#tl').html('<option value="1" selected>На: русский / russian</option><option value="2">На: английский / english</option>');
  }
}
</script>
<div class="miniature_box">
 <div class="miniature_pos" style="width:600px">
  <div class="miniature_title fl_l apps_box_text">Переводчик</div><a class="cursor_pointer fl_r" style="font-size:12px" onClick="viiBox.clos('tranlsateViiBox', 1)">Закрыть</a>
<div style="border-bottom: 1px solid #DAE1E8;margin-top:20px;"></div>
  <div class="clear"></div>
   <div class="rating_text" style="color:#777;margin-bottom:10px">С помощью этого сервиса Вы можете перевести содержимое сообщения.</div>
   <select id="sl" onChange="payment.operator(this.value)" class="inpst fl_l payment_sel" style="width:228px">
    <option value="1" selected>С Языка: русский / russian</option>
    <option value="2">С Языка: английский / english</option>
   </select>
   <div class="fl_l" style="margin:10px;margin-top:-2px;font-size:21px;color:#777"><b>&#8594;</b></div>
   <select id="tl" onChange="payment.operator(this.value)" class="inpst fl_l payment_sel" style="width:228px">
    <option value="1">На: русский / russian</option>
    <option value="2" selected>На: английский / english</option>
   </select>
   <div class="button_div fl_l" style="margin-top:0px;margin-left:10px"><button onClick="tranlsate.go()" id="transalteBut" onMouseOver="checkLang()">Перевести</button></div>
   <textarea class="translateTxt1 clear" id="translateTxt1" onKeyUp="checkLang()" style="width:283px;float:left;margin-right:10px">{msg}</textarea>
   <textarea class="translateTxt1" id="translateTxt2" style="width:283px;float:left"></textarea>
   <div class="clear"></div>
  <div class="clear"></div>
 </div>
 <div class="clear" style="height:20px"></div>
</div>