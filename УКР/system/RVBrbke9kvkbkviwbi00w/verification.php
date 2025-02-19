<?php
/* 
	Appointment: Верификация
	File: verification.php
	Author: f0rt1 
	Engine: Vii Engine
	Copyright: NiceWeb Group (с) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	Данный код защищен авторскими правами
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

echoheader();

//Принятие заявки
if($_GET['act'] == 'ok' AND $_GET['id']){
	
	$user_id = intval($_GET['id']);
	
	//Проверяем есть юзер в базе или нет
	$check_user = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'");
						
	if($check_user['cnt'])
		$db->query("UPDATE `".PREFIX."_users_param` SET verification = '1' WHERE user_id = '{$user_id}'");
	else
		$db->query("INSERT INTO `".PREFIX."_users_param` SET verification = '1', user_id = '{$user_id}'");
						
	mozg_mass_clear_cache_file("user_{$user_id}/params");
	
	$db->query("UPDATE `".PREFIX."_verification` SET status = '2' WHERE user_id = '{$user_id}'");
	
	header("Location: ?mod=verification");
	
}

//Отклонение заявки
if($_GET['act'] == 'del' AND $_GET['id']){
	
	$user_id = intval($_GET['id']);
	
	$db->query("DELETE FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
	
	header("Location: ?mod=verification");
	
}

//Выводим все заявки
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

if($_GET['status'] == 2){
	$sql_status = "status = '2'";
	$lnk = '<a href="?mod=verification&status=1">Показать заявки на верификацию</a>';
} else {
	$sql_status = "status = '1'";
	$lnk = '<a href="?mod=verification&status=2">Показать верифицированых</a>';
}

$sql_ = $db->super_query("SELECT tb1.user_id, skype, doc, doc2, tb2.user_search_pref FROM `".PREFIX."_verification` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.{$sql_status} ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_verification` WHERE {$sql_status} = '1'");

foreach($sql_ as $row){
	
	$users .= <<<HTML
<div style="float:left;padding:5px;width:160px;text-align:center;border-bottom:1px dashed #ccc"><a href="/u{$row['user_id']}" target="_blank">{$row['user_search_pref']}</a></div>
<div style="float:left;padding:5px;width:150px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc"><a href="skype:{$row['skype']}">{$row['skype']}</a></div>
<div style=";float:left;padding:5px;width:100px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc"><a href="/uploads/users/{$row['user_id']}/{$row['doc']}" target="_blank">doc #1</a>, <a href="/uploads/users/{$row['user_id']}/{$row['doc2']}" target="_blank">doc #2</a></div>
<div style=";float:left;padding:5px;width:145px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">[ <a href="?mod=verification&act=ok&id={$row['user_id']}">принять</a> ] [ <a href="?mod=verification&act=del&id={$row['user_id']}">отклонить</a> ]</div>
HTML;
	
}

echo <<<HTML
<div style="margin-top:10px"></div>
<div class="clr" ></div>
<div style="background:#f0f0f0;float:left;padding:5px;width:160px;text-align:center;font-weight:bold">Пользователь</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:150px;text-align:center;font-weight:bold;margin-left:1px">Skype</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-left:1px">Документ</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:145px;text-align:center;font-weight:bold;margin-left:1px">Действия</div>
<div class="clr"></div>
{$users}<div class="clr" style="height:10px"></div>
{$lnk}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>