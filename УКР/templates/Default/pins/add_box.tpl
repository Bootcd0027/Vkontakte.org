<script type="text/javascript" src="/system/RVBrbke9kvkbkviwbi00w/js/upload.photo.js"></script>
<script type="text/javascript">
var loading_photo_pins = false;
var loaded_pins_name = null;
$(document).ready(function(){
	aj1 = new AjaxUpload('upload', {
		action: '/index.php?go=pins&act=load_pins',
		name: 'uploadfile',
		data: {
			add_act: 'upload'
		},
		accept: 'image/*',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				Box.Info('err', 'Ошибка', 'Неверный формат файла');
				return false;
			}
			$('#upload').hide();
			$('#prog_poster').show();
		},
		onComplete: function (file, row){
			var exp = row.split('|');
			if(exp[0] == 'size'){
				Box.Info('err', 'Ошибка', 'Файл привышает 5 МБ');
			} else {
				$('#r_poster').attr('src', '/uploads/pins/'+exp[0]+'/'+exp[1]).show();
			}
			$('#upload').show();
			$('#prog_poster, #size_small, #upload_butt').hide();
			loading_photo_pins = true;
			loaded_pins_name = exp[1];
		}
	});
});
function createNewPin(){
	var category = $('#category').val();
	var descr = $('#descr').val();
	if(loading_photo_pins){
		$.post('/index.php?go=pins&act=create', {category: category, descr: descr, file: loaded_pins_name}, function(d){
			Box.Info('inf', 'Информация', 'Новый стикер успешно добавлен!');
			viiBox.clos('add_box', 1);
			setTimeout("location.href = '/pins'", 1500);
		});
	}else Box.Info('err', 'Ошибка', 'Вы не загрузили фотографию');
}
</script>
<div class="miniature_box">
	<div class="miniature_pos">
		<div class="miniature_title fl_l apps_box_text">Добавить стикер</div><a class="cursor_pointer fl_r" style="font-size:12px" onClick="viiBox.clos('add_box', 1)">Закрыть</a>
<div style="border-bottom: 1px solid #DAE1E8;margin-top:20px;"></div>
		<div class="clear"></div>
		<div class="miniature_descr">Вы можете добавить любой стикер и поделиться с ним друзьями!</div>
		<div class="fl_l" style="padding: 15px">
			<img src="{photo}" width="200" height="350"/>
		</div>
		<div class="fl_l" style="padding: 15px">
			<div class="fl_l" style="margin-top: 3px; color: #999;padding-right: 15px">Выберите изображение:</div> 
			<div class="fl_l">
				<div class="button_div fl_l" id="upload_butt"><button type="submit" class="inp" id="upload">Выбрать файл</button></div><div class="clear"></div><br />
				<div id="prog_poster" style="display: none;margin-top:-11px;background:url('/system/inc/images/progress_grad.gif');width:94px;height:18px;border:1px solid #006699; float:left"></div><div class="clear"></div>
				 <div id="size_small" style="margin-left:-160px"><div class="load_photo_quote" style="width: 363px;">Файл не должен превышать 5 Mб. Если у Вас возникают проблемы с загрузкой, попробуйте использовать фотографию меньшего размера.</div></div>
				 <img src="" id="r_poster" style="display:none;margin-top: -25px" width="100" height="100" />
				<div class="mgclr"></div>
			</div>
			<div class="clear"></div>
			<br/><div style="color: #999;padding-bottom: 5px">Выберите категорию:</div>
			<select id="category" style="width: 385px">{category}</select>
			<br/><div style="color: #999;padding-bottom: 5px">Описание: </div>
			<textarea id="descr" style="height: 70px;width: 379px;margin-bottom:5px;"></textarea>
			<div><div class="button_div fl_l"><button onClick="createNewPin()">Добавить стикер</button></div></div>
		</div>
		<div class="clear"></div>
 </div>
 <div class="clear" style="height:100px"></div>
</div>