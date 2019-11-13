var pEnum = 0;
var payment = {
  box: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=payment', function(d){
	  viiBox.win('payment', d);
	});
  },
  box_two: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=payment_2', function(d){
	  viiBox.win('payment_2', d);
	  $('#cost_balance').focus();
	});
  },
  operator: function(v){
	var check = $('#'+v).length;
	if(check){
	  $('#payment_oper').html($('#'+v).html()).attr('disabled', 0);
	} else {
	  $('#payment_oper').html('<option value="0"></option>').attr('disabled', 'disabled');
	}
	$('#payment_cost').html('<option value="0"></option>').attr('disabled', 'disabled');
	$('#smsblock').hide();
  },
  cost: function(v){
    var check = $('#cost_'+v).length;
	if(check){
	  $('#payment_cost').html($('#cost_'+v).html()).attr('disabled', 0);
	} else {
	  $('#payment_cost').html('<option value="0"></option>').attr('disabled', 'disabled');
	}
	$('#smsblock').hide();
  },
  number: function(v, t){
    var v = v.split('|');
    if(v[0] != 0){
	  $('#smsblock').show();
	  $('#smsnumber').text(v[0]);
	  if(v[1]) $('#smspref').text(v[1]);
	  else $('#smspref').text('');
	} else
	  $('#smsblock').hide();
  },
  update: function(){
    var pr = parseInt($('#cost_balance').val());
	if(!isNaN(pr)) $('#cost_balance').val(parseInt($('#cost_balance').val()));
	else $('#cost_balance').val('');
	var num = $('#cost_balance').val() * $('#cost').val();
	var res = ( $('#balance').val() - num );
	$('#num').text( res );
	if(!$('#cost_balance').val()) $('#num').text( $('#balance').val() );
	else if(res < 0) $('#num').text('недостаточно');
  },
  send: function(){
    var num = $('#cost_balance').val();
	var num_2 = $('#cost_balance').val() * $('#cost').val();
	var res = $('#balance').val() - num_2;
	var rub2 = $('#balance').val() - num_2;
	if(pEnum > 10){
	  alert('Я тебе голову сломаю!');
	  pEnum = 0;
	}
	if(res <= 0) res = 999999999999;
	if(num != 0 && $('#balance').val() >= res){
	  butloading('saverate', 50, 'disabled', '');
      $.post('/index.php?go=balance&act=ok_payment', {num: num}, function(d){
	    if(d == 1){
		  addAllErr('Пополните баланс для покупки.', 3300);
		  return false;
		}
	    $('#rub2').text(rub2);
	    $('#num2').text(parseInt($('#num2').text()) + parseInt(num));
        viiBox.clos('payment_2', 1);
      });	
	} else {
	  setErrorInputMsg('cost_balance');
	  pEnum++;
	}
  },
  box_tree: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=payment_3', function(d){
	  viiBox.win('payment_3', d);
	  $('#inp').focus();
	});
  },
  update_three: function(){
    var pr = parseInt($('#inp').val());
	if(!isNaN(pr)) $('#inp').val(parseInt($('#inp').val()));
	else $('#inp').val('');
	var m = pr % 2;
	if (m == 0){
	var num = $('#inp').val() / 2;
	var res = ( $('#sp').val() - num );
	$('#balance').text( res );
	if(!$('#inp').val()) $('#balance').text( $('#sp').val() );
	else if(res < 0) $('#balance').text('недостаточно');}
	else if (m != 0)$('#balance').text('нужно больше двух');
  },
  send_three: function(){
    var num = $('#inp').val();
	var num_2 = num / 2;
	var res = $('#sp').val() - num_2;
	var golos = $('#sp').val() - num_2;
	if(pEnum > 10){
	  alert('Я тебе голову сломаю!');
	  pEnum = 0;
	}
	if(res <= 0) res = 999999999999;
	if(num != 0 && $('#sp').val() >= res){
	  butloading('saverate', 50, 'disabled', '');
      $.post('/index.php?go=balance&act=ok_payment_3', {num: num}, function(d){
	    if(d == 1){
		  addAllErr('Пополните баланс для покупки.', 3300);
		  return false;
		}
	    $('#num2').text(parseInt(res));
	    $('#rub2').text(parseInt($('#rub2').text()) + parseInt(num));
        viiBox.clos('payment_3', 1);
      });	
	} else {
	  setErrorInputMsg('inp');
	  pEnum++;
	}
  }
}