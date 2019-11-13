var tranlsate = {
  box: function(msg_id){
    viiBox.start();
	$.post('/index.php?go=tranlsate', {msg_id: msg_id}, function(d){
	  viiBox.win('tranlsateViiBox', d);
	});
  },
  go: function(){
    var txt = $('#translateTxt1').val();
    var sl = $('#sl').val();
    var tl = $('#tl').val();
	butloading('transalteBut', '68', 'disabled');
	$('#translateTxt1, #translateTxt2').attr('disabled', 1);
	$.post('/index.php?go=tranlsate&act=go', {txt: txt, sl: sl, tl: tl}, function(d){
	  $('#translateTxt2').val(d);
	  $('#translateTxt1, #translateTxt2').attr('disabled', 0);
	  butloading('transalteBut', '68', 'enabled', 'Перевести');
	});
  },
  fast: function(msg_id){
	Page.Loading('start');
  	$.post('/index.php?go=tranlsate&act=go', {msg_id: msg_id}, function(d){
	  $('#translate_'+msg_id).html(d).show();
	  Page.Loading('stop');
	});
  }
}