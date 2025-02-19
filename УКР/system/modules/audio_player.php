<?php
/* 
	Appointment: Плеер на всех страницах
	File: audio_player.php 
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

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];

	$metatags['title'] = $lang['audio'];
	
	switch($act){
		
//################### Трансляция в статус ###################//
		case "translate":
			
			$aid = intval($_POST['aid']);
			
			//Выводим песню
			$row = $db->super_query("SELECT artist, name FROM `".PREFIX."_audio` WHERE aid = '{$aid}'");

			if($row){
				
				//Выводим пред. статус
				$checkPrevStatus = mozg_cache("user_{$user_id}/old_status");
				$checkExp = explode('<audio', $checkPrevStatus);
				
				if(!$checkPrevStatus AND !$checkExp[1]){
				
					$myRow = $db->super_query("SELECT user_status FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
					
					//Если ест пред статус, то сохраняем его в кеш, для воостановления
					if($myRow['user_status']){

						mozg_create_cache("user_{$user_id}/old_status", $myRow['user_status']);
						
					}
				
				}
				
				$artist = $db->safesql($row['artist']);
				$name = $db->safesql($row['name']);
				
				$newStatus = '<div class="staticpl_translatl" onClick="gStatus.open()"><div class="statipl_music"></div>'.$artist.' &ndash; '.$name.'</div><audio'.$aid;
				
				//Обновляем статус
				$db->query("UPDATE `".PREFIX."_users` SET user_status = '{$newStatus}' WHERE user_id = '{$user_id}'");
				
				//Чистим кеш
				mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
			}
			
		break;
		
		//################### Выключение трансляции ###################//
		case "notranslate":
			
			//Выводим пред. статус
			$checkPrevStatus = mozg_cache("user_{$user_id}/old_status");
			$checkExp = explode('<audio', $checkPrevStatus);
			
			if(!$checkExp[1]) $newStatus = $db->safesql($checkPrevStatus);
			else $newStatus = '';
			
			//Обновляем статус
			$db->query("UPDATE `".PREFIX."_users` SET user_status = '{$newStatus}' WHERE user_id = '{$user_id}'");

			//Чистим кеш
			mozg_create_cache("user_{$user_id}/old_status", "");
			mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
		break;
		
		//################### Выключение трансляции ###################//
		case "notranslate":
			
			//Выводим пред. статус
			$checkPrevStatus = mozg_cache("user_{$user_id}/old_status");
			$checkExp = explode('<audio', $checkPrevStatus);
			
			if(!$checkExp[1]) $newStatus = $db->safesql($checkPrevStatus);
			else $newStatus = '';
			
			//Обновляем статус
			$db->query("UPDATE `".PREFIX."_users` SET user_status = '{$newStatus}' WHERE user_id = '{$user_id}'");

			//Чистим кеш
			mozg_create_cache("user_{$user_id}/old_status", "");
			mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
		break;
		
		default:
		
			//################### Вывод всех аудио ###################//
			$get_user_id = intval($_POST['get_user_id']);
			if(!$get_user_id) $get_user_id = $user_id;
			
			$query = $db->safesql(ajax_utf8(strip_data(urldecode($_POST['query']))));
			$doload = intval($_POST['doload']);
			
			//Если страница вывзана через "Показать больше аудиозаписей"
			$limit_select = 10;
			if($_POST['page_cnt'] > 0)
				$page_cnt = intval($_POST['page_cnt'])*$limit_select;
			else
				$page_cnt = 0;
				
				
			if($query != ''){
				$query = strtr($query, array(' ' => '%')); //Замеянем пробелы на проценты чтоб тоиск был точнее
				$where = "artist LIKE '%".$query."%' OR name LIKE '%".$query."%'";
			}else{
				$where = "auser_id = '".$get_user_id."'";
			
			}
			
			

			//Если страница вывзана через "Показать больше аудиозаписей"
			if($page_cnt)
				NoAjaxQuery();
			
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS aid, url, artist, name FROM `".PREFIX."_audio` WHERE {$where} ORDER by `adate` DESC LIMIT {$page_cnt}, {$limit_select}", 1);
				
				
				
				
			if($sql_){
			
				if(!$page_cnt && !$doload){
					$tpl->load_template('audio_player/head.tpl');
					if($user_id != $get_user_id)
						$user = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '".$get_user_id."'");
					$tpl->set('{name}', gramatikName($user['user_name']));
					$tpl->set('{num}', $user['user_audio'].' '.gram_record($user['user_audio'], 'audio'));
					$tpl->set('{uid}', $get_user_id);
					if($get_user_id == $user_id){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
					
					if($config['audio_mod_add'] == 'no')
						$tpl->set_block("'\\[admin-add\\](.*?)\\[/admin-add\\]'si","");
					else {
						$tpl->set('[admin-add]', '');
						$tpl->set('[/admin-add]', '');
					}
					
					$tpl->compile('content');
				}

				$tpl->load_template('audio_player/track.tpl');
				$jid = $page_cnt;
				foreach($sql_ as $row){
					$jid++;
					$tpl->set('{jid}', $jid);
					$tpl->set('{aid}', $row['aid']);
					$tpl->set('{url}', $row['url']);
					$tpl->set('{artist}', stripslashes($row['artist']));
					$tpl->set('{name}', stripslashes($row['name']));
					if($get_user_id == $user_id){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set('{uid}', $get_user_id);
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
					$tpl->compile('content');
				}
				
				if(!$page_cnt){
						$tpl->set('[not-page]', '');
						$tpl->set('[/not-page]', '');
				}else{
						$tpl->set('[page]', '');
						$tpl->set('[/page]', '');
				}
				if(!$page_cnt && !$doload){
					$tpl->load_template('audio_player/bottom.tpl');
					$tpl->set('{uid}', $get_user_id);
					$tpl->compile('content');
				}
				
			} else {
				if(!$page_cnt && !$doload){
					$tpl->load_template('audio_player/none.tpl');
					if($user_id != $get_user_id)
						$user = $db->super_query("SELECT user_name FROM `".PREFIX."_users` WHERE user_id = '".$get_user_id."'");
					$tpl->set('{name}', gramatikName($user['user_name']));
					$tpl->set('{uid}', $get_user_id);
					if($get_user_id == $user_id){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set('{uid}', $get_user_id);
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
					$tpl->compile('content');
				}
			}
			
			//Если страница вывзана через "Показать больше аудиозаписей"
			//if($page_cnt){
				AjaxTpl();
				die();
			//}
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>