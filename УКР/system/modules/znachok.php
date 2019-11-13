<?php
/*

*/
if(!defined('MOZG'))
die('Hacking attempt!');
if($ajax == 'yes')
NoAjaxQuery();
if($logged){
$act = $_GET['act'];
$user_id = $user_info['user_id'];
switch($act){

  //################### Страница всех значков ###################//
  case "view":
   NoAjaxQuery();
   $for_user_id = intval($_POST['user_id']);
 
   $sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, price, img FROM `".PREFIX."_znachok_list` ORDER by `id` DESC", 1);

   foreach($sql_ as $gift){
    echo "<a href=\"\" class=\"gifts_onegif\" onMouseOver=\"gifts.showgift('{$gift['img']}')\" onMouseOut=\"gifts.showhide('{$gift['img']}')\" onClick=\"znachok.send('{$gift['img']}', '{$for_user_id}'); return false\"><img src=\"/uploads/znachok/{$gift['img']}.png\" /><div class=\"gift_count\" id=\"g{$gift['img']}\">{$gift['price']} голосов</div></a>";
   }
 
   $row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
 
   echo "<style>#box_bottom_left_text{padding-top:6px;float:left}</style><script>$('#box_bottom_left_text').html('У Вас <b>{$row['user_balance']} голос/ов</b>');</script>";
 
   die();
  break;

  //################### Отправка значка в БД ###################//
  case "send":
   NoAjaxQuery();
   $gift = intval($_POST['gift']);
   $gifts = $db->super_query("SELECT price FROM `".PREFIX."_znachok_list` WHERE img = '".$gift."'");
 
   //Выводим текущий баланс свой
   $row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
    if($row['user_balance'] >= $gifts['price']){
     $db->query("UPDATE `".PREFIX."_users` SET user_znachok = {$gift} WHERE user_id = '{$user_id}'");
     $db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-{$gifts['price']} WHERE user_id = '{$user_id}'");
    mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);  
    } else
     echo '1';
 
   die();
  break;



  default:


}
$tpl->clear();
$db->free();
} else {
$user_speedbar = $lang['no_infooo'];
msgbox('', $lang['not_logged'], 'info');
}
?>