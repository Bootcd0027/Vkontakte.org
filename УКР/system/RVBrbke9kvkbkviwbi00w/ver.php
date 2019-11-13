<?php
/* 
	Appointment: Сообщества
	File: groups.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');
echoheader();	
	if($_GET['act'] == 'edit'){
	$id = intval($_GET['id']);
	$type = intval($_GET['type']);
	$uid = intval($_GET['uid']);
    $db->query("UPDATE `".PREFIX."_verfication` SET type = '".$type."' WHERE id = '".$id."'");
	if($type==3) {$db->query("UPDATE `vii_users` SET user_real = 1 WHERE user_id = '".$uid."'");
				mozg_clear_cache_file("user_'".$uid."'/profile_'".$uid."'");
				mozg_clear_cache();
	}
    header('Location: /Gjfwokvokw4693pvkomwew30tBsjivjOEOKfek.php?mod=ver');
	}
//Выводим список людей
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT date,url,uid,id FROM `".PREFIX."_verfication`  WHERE type=1 ORDER by id LIMIT {$limit_page}, {$gcount}", 1);

//Кол-во людей считаем
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_verfication` WHERE type=1 ");



echohtmlstart('Список заявок на верификацию ('.$numRows['cnt'].')');

foreach($sql_ as $row){
	$row['title'] = stripslashes($row['title']);


		
	$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;"><a href="/id{$row['uid']}" target="_blank">Пользователь №{$row['uid']}</a></div>
<a href="{$row['url']}"><img style="width:450px;height:350px;" src="{$row['url']}"></a><br>
<a href="/Gjfwokvokw4693pvkomwew30tBsjivjOEOKfek.php?mod=ver&act=edit&type=3&uid={$row['uid']}&id={$row['id']}">Одобрить</a> | <a href="/Gjfwokvokw4693pvkomwew30tBsjivjOEOKfek.php?mod=ver&act=edit&type=2&uid={$row['uid']}&id={$row['id']}">Отклонить</a>
<div class="mgcler"></div>
HTML;
}
echo $users;
$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

htmlclear();
echohtmlend();
?>