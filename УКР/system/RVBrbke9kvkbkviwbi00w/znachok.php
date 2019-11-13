<?php
/*
        Appointment: Значок
        File: znachok.php

*/
if(!defined('MOZG'))
        die('Hacking attempt!');

//Если нажали "Добавить"
if(isset($_POST['save'])){
        $price = intval($_POST['price']);
        
        //Разришенные форматы
        $allowed_files = array('png', 'png');
        
        //Получаем данные о фотографии КОПИЯ
        $image_tmp_2 = $_FILES['thumbnail']['tmp_name'];
        $image_name_2 = totranslit($_FILES['thumbnail']['name']); // название значка
        $image_size_2 = $_FILES['thumbnail']['size']; // размер файла
        $type_2 = end(explode(".", $image_name_2)); // формат файла
        $name_znachok = str_replace(".png", " ", $image_name_2);

$id = intval($_GET['id']);

        //Проверям если, формат верный то пропускаем
        if($price){
                if(in_array(strtolower($type_2), $allowed_files)){
                        if($image_size < 200000){
                                if($image_size_2 < 100000){
                                        $rand_name = rand(0, 1000);
                                        move_uploaded_file($image_tmp, ROOT_DIR.'/uploads/znachok/'.$name_znachok.'.'.$type);
                                        move_uploaded_file($image_tmp_2, ROOT_DIR.'/uploads/znachok/'.$name_znachok.'.'.$type_2);
                                        $db->query("INSERT INTO `".PREFIX."_znachok_list` SET img = '".$name_znachok."', price = '".$price."'");
                                        msgbox('Информация', 'Значок успешно добавлен', '?mod=znachok');
                                } else
                                        msgbox('Ошибка', 'Уменьшеная копия привышает допустимый размер 100 кб', 'javascript:history.go(-1)');
                        } else
                                msgbox('Ошибка', 'Оригинал привышает допустимый размер 200 кб', 'javascript:history.go(-1)');
                } else
                        msgbox('Ошибка', 'Неправильный формат', 'javascript:history.go(-1)');
        } else
                msgbox('Ошибка', 'Укажите цену значка', 'javascript:history.go(-1)');
        
        die();
}

//Удаление
if($_GET['act'] == 'del'){
        $id = intval($_GET['id']);
        $row = $db->super_query("SELECT img FROM `".PREFIX."_znachok_list` WHERE id = '".$id."'");
        if($row){
                $db->query("DELETE FROM `".PREFIX."_znachok_list` WHERE id = '".$id."'");
                @unlink(ROOT_DIR."/uploads/znachok/".$row['img'].'.png');
                header('Location: ?mod=znachok');
        }
}

//Сохраняем
if($_GET['act'] == 'edit'){
        $id = intval($_GET['id']);
        $price = intval($_GET['price']);
        if($price <= 0) $price = 1;
        $db->query("UPDATE`".PREFIX."_znachok_list` SET price = '".$price."' WHERE id = '".$id."'");
        header('Location: ?mod=znachok');
}

echoheader();

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_znachok_list`");

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_znachok_list` ORDER by `id` DESC", 1);
foreach($sql_ as $row){
        $gifts .= <<<HTML
<div style="float:left;width: 150px;height:150px;text-align:center;margin-bottom:15px;margin-top:10px">
<center><img src="/uploads/znachok/{$row['img']}.png" style="margin-bottom:15px" /></center>
Цена: <input type="text" id="price{$row['id']}" class="inpu" value="{$row['price']}" /><br />
[ <a href="?mod=znachok" onClick="window.location.href='?mod=znachok&act=edit&id={$row['id']}&price='+document.getElementById('price{$row['id']}').value; return false">сохранить</a> ] [ <a href="?mod=znachok&act=del&id={$row['id']}">удалить</a> ]
</div>
HTML;
}

echohtmlstart('Добавление значка');
                        
echo <<<HTML
<style type="text/css" media="all">
.inpu{width:50px;}
textarea{width:450px;height:400px;}
</style>

<form action="" enctype="multipart/form-data" method="POST">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall" style="width:180px">Цена:</div>
<input type="text" name="price" class="inpu" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Значок .PNG:</div>
<input type="file" name="thumbnail" class="inpu" style="width:300px" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">&nbsp;</div>
<input type="submit" value="Добавить" class="inp" name="save" style="margin-top:0px" />
</form>
HTML;

echohtmlstart('Список значков ('.$numRows['cnt'].')');

echo <<<HTML
{$gifts}
<div class="clr"></div>
HTML;

echohtmlend();
?>