<?php
/* 
	Appointment: Друзья пользователя
	File: friends.php 
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

//Если страница вызвана через AJAX то включаем защиту, чтоб не могли обращаться напрямую к странице
if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$getlist = $_GET['sel'];
	$metatags['title'] = $lang['friends'];

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 20;
	$limit_page = ($page-1)*$gcount;
				
	switch($act){
		
		//################### Отправка заявки в друзья ###################//
		case "send_demand":
			NoAjaxQuery();
			AntiSpam('friends');
			
			$for_user_id = intval($_GET['for_user_id']);
			$from_user_id = $user_info['user_id'];
			$user_id = $user_info['user_id'];
			
			//Проверяем на факт сушествования заявки для пользователя, если она уже есть, то даёт ответ "yes_demand"
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$for_user_id}' AND from_user_id = '{$from_user_id}'");

			if($for_user_id AND !$check AND $for_user_id != $from_user_id){
				
				//Проверяем существования заявки у себя в заявках
				$check_demands = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$from_user_id}' AND from_user_id = '{$for_user_id}'");
				if(!$check_demands){
					
					//Проверяем нетли этого юзера уже в списке друзей
					$check_friendlist = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE friend_id = '{$for_user_id}' AND user_id = '{$from_user_id}' AND subscriptions = 0");
					if(!$check_friendlist){
						$db->query("INSERT INTO `".PREFIX."_friends_demands` (for_user_id, from_user_id, demand_date) VALUES ('{$for_user_id}', '{$from_user_id}', NOW())");
						$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands+1 WHERE user_id = '{$for_user_id}'");
						echo 'ok';

               //Вставляем событие в моментальные оповещания
						$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
						$update_time = $server_time - 70;
						
						if($row_owner['user_last_visit'] >= $update_time){
							
							$action_update_text = 'хочет добавить Вас в друзья.';
							
							$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '11', date = '{$server_time}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/friends/requests'");
						
							mozg_create_cache("user_{$for_user_id}/updates", 1);
						
						}

						
						//Отправка уведомления на E-mail
						if($config['news_mail_1'] == 'yes'){
							$rowUserEmail = $db->super_query("SELECT user_name, user_email, notify FROM `".PREFIX."_users` WHERE user_id = '".$for_user_id."'");
							$EMAIL_block_data = xfieldsdataload($rowUserEmail['notify']);
							if($rowUserEmail['user_email'] AND $EMAIL_block_data['n_friends']){
								include_once ENGINE_DIR.'/classes/mail.php';
								$mail = new dle_mail($config);
								$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
								$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '1'");
								$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
								$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
								$mail->send($rowUserEmail['user_email'], 'Новая заявка в друзья', $rowEmailTpl['text']);
							}
						}
					} else
						echo 'yes_friend';
				} else
					echo 'yes_demand2';
			} else 
				echo 'yes_demand';
			
			die();
		break;
		
		//################### Принятие заявки на дружбу ###################//
		case "take":
			NoAjaxQuery();
			$take_user_id = intval($_GET['take_user_id']);
			$user_id = $user_info['user_id'];
			
			//Проверяем на существования юзера в таблице заявок в друзья
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$take_user_id}'");
			
			if($check){
				
				//Добавляем юзера который кинул заявку в список друзей
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$user_id}', friend_id = '{$take_user_id}', friends_date = NOW()");
				
				//Тому кто предлогал дружбу, добавляем ему в друзья себя
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$take_user_id}', friend_id = '{$user_id}', friends_date = NOW()");
				
				//Обновляем кол-во заявок и кол-друзей у юзера
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands-1, user_friends_num = user_friends_num+1 WHERE user_id = '{$user_id}'");
				
				//Тому кто предлогал дружбу, обновляем кол-друзей
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num+1 WHERE user_id = '{$take_user_id}'");
				
				//Удаляем заявку из таблицы заявок
				$db->query("DELETE FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$take_user_id}'");

				$generateLastTime = $server_time-10800;
				
				//Добавляем действия в ленту новостей кто подавал заявку
				$rowX = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 4 AND ac_user_id = '{$take_user_id}'");
				if($rowX['ac_id'])
					if(!preg_match("/{$rowX['action_text']}/i", $user_id))
						$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$rowX['action_text']}||{$user_id}', action_time = '{$server_time}' WHERE ac_id = '{$rowX['ac_id']}'");
					else
						echo '';
				else
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$take_user_id}', action_type = 4, action_text = '{$user_id}', action_time = '{$server_time}'");
	
                    //Вставляем событие в моментальные оповещания
				$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$take_user_id}'");
				$update_time = $server_time - 70;
						
				if($row_owner['user_last_visit'] >= $update_time){
							
					$myRow = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
					if($myRow['user_sex'] == 2) $action_update_text = 'подтвердила Вашу заявку на дружбу.';
					else $action_update_text = 'подтвердил Вашу заявку на дружбу.';
							
					$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$take_user_id}', from_user_id = '{$user_info['user_id']}', type = '12', date = '{$server_time}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/u{$take_user_id}'");
						
					mozg_create_cache("user_{$take_user_id}/updates", 1);
						
				}

				//Добавляем действия в ленту новостей себе
				$row = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 4 AND ac_user_id = '{$user_id}'");
				if($row)
					if(!preg_match("/{$row['action_text']}/i", $take_user_id))
						$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$row['action_text']}||{$take_user_id}', action_time = '{$server_time}' WHERE ac_id = '{$row['ac_id']}'");
					else
						echo '';
				else
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 4, action_text = '{$take_user_id}', action_time = '{$server_time}'");

					//Выводим мои сообщества
				$sql_gr = $db->super_query("SELECT id FROM `".PREFIX."_communities` WHERE real_admin = '{$user_info['user_id']}'", 1);
				
				if($sql_gr){
					
					foreach($sql_gr as $row_gr){
						
						//Проверка на существования юзера в сообществе
						$row_aa = $db->super_query("SELECT ulist, del, ban FROM `".PREFIX."_communities` WHERE id = '{$row_gr['id']}'");
						if(stripos($row_aa['ulist'], "|{$take_user_id}|") === false AND $row_aa['del'] == 0 AND $row_aa['ban'] == 0){
							$ulist = $row_aa['ulist']."|{$take_user_id}|";
							$db->query("UPDATE `".PREFIX."_communities` SET traf = traf+1, ulist = '{$ulist}' WHERE id = '{$row_gr['id']}'");
							$db->query("UPDATE `".PREFIX."_users` SET user_public_num = user_public_num+1 WHERE user_id = '{$take_user_id}'");
							$db->query("INSERT INTO `".PREFIX."_friends` SET friend_id = '{$row_gr['id']}', user_id = '{$take_user_id}', friends_date = NOW(), subscriptions = 2");
							
							mozg_mass_clear_cache_file("user_{$take_user_id}/profile_{$take_user_id}|groups/{$take_user_id}");
						}
						
					}
					
				}
					
				//Чистим кеш владельцу стр и тому кого добавляем в др.
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('user_'.$take_user_id.'/profile_'.$take_user_id);

				//Записываем пользователя в кеш файл друзей
				$openMyList = mozg_cache("user_{$user_id}/friends");
				mozg_create_cache("user_{$user_id}/friends", $openMyList."u{$take_user_id}|");
				
				$openTakeList = mozg_cache("user_{$take_user_id}/friends");
				mozg_create_cache("user_{$take_user_id}/friends", $openTakeList."u{$user_id}|");
			} else
				echo 'no_request';
			
			die();
		break;
		
		//################### Отклонение заявки на дружбу ###################//
		case "reject":
			NoAjaxQuery();
			$reject_user_id = $db->safesql(intval($_GET['reject_user_id']));
			$user_id = $user_info['user_id'];
			
			//Проверяем на существования юзера в таблице заявок в друзья
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$reject_user_id}'");
			if($check){
				//Обновляем кол-во заявок у юзера
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands-1 WHERE user_id = '{$user_id}'");
				
				//Удаляем заявку из таблицы заявок
				$db->query("DELETE FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$reject_user_id}'");
				
			//Подписываем юзера на обновления
				//Проверка на существование юзера в подписках
				$check_2 = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$reject_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 1");
				
				//ЧС
				$CheckBlackList = CheckBlackList($check_2['user_id']);
				
				if(!$CheckBlackList AND !$check_2){
					
					$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$reject_user_id}', friend_id = '{$user_id}', friends_date = NOW(), subscriptions = 1");
					
					$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num+1 WHERE user_id = '{$reject_user_id}'");
					
					//Чистим кеш
					mozg_clear_cache_file('user_'.$reject_user_id.'/profile_'.$reject_user_id);
					mozg_clear_cache_file('subscr_user_'.$reject_user_id);
					mozg_clear_cache_file('user_'.$user_id.'/subscr_num');
				
				}

				
			} else
				echo 'no_request';
			
			die();
		break;
		
		//################### Удаления друга из списка друзей ###################//
		case "delete":
			NoAjaxQuery();
			$delet_user_id = $db->safesql(intval($_POST['delet_user_id']));
			$user_id = $user_info['user_id'];
			
			//Вывод информации после отправки сообщения
				if($_GET['info'] == 1)
					friends('', '<script type="text/javascript">setTimeout(\'$(".err_yellow").fadeOut()\', 1500);</script>Пользователь удален из списка Ваших друзей.', 'info');
			
			//Проверяем на существования юзера в списке друзей
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$delet_user_id}' AND subscriptions = 0");
			if($check){
				//Удаляем друга из таблицы друзей
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$delet_user_id}' AND subscriptions = 0");
				
				//Удаляем у друга из таблицы
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$delet_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 0");
				
				//Обновляем кол-друзей у юзера
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$user_id}'");
				
				//Обновляем у друга которого удаляем кол-во друзей
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$delet_user_id}'");
				
				//Чистим кеш владельцу стр и тому кого удаляем из др.
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('user_'.$delet_user_id.'/profile_'.$delet_user_id);
				
				//Удаляем пользователя из кеш файл друзей
				$openMyList = mozg_cache("user_{$user_id}/friends");
				mozg_create_cache("user_{$user_id}/friends", str_replace("u{$delet_user_id}|", "", $openMyList));
				
				$openTakeList = mozg_cache("user_{$delet_user_id}/friends");
				mozg_create_cache("user_{$delet_user_id}/friends", str_replace("u{$user_id}|", "", $openTakeList));
				
			    //Подписываем юзера на обновления
				//Проверка на существование юзера в подписках
				$check_2 = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$delet_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 1");
				
				//ЧС
				$CheckBlackList = CheckBlackList($check_2['user_id']);
				
				if(!$CheckBlackList AND !$check_2){
					
					$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$delet_user_id}', friend_id = '{$user_id}', friends_date = NOW(), subscriptions = 1");
					
					$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num+1 WHERE user_id = '{$delet_user_id}'");
					
					//Чистим кеш
					mozg_clear_cache_file('user_'.$delet_user_id.'/profile_'.$delet_user_id);
					mozg_clear_cache_file('subscr_user_'.$delet_user_id);
					mozg_clear_cache_file('user_'.$user_id.'/subscr_num');
				
				}

			} else
				echo 'no_friend';
			
			die();
		break;
		
		
		case "adduserlist":
		
			$id = intval($_POST['id']);
			$user_id = intval($_POST['user_id']);
			
			$sql = $db->super_query("SELECT ulist,user_id FROM `".PREFIX."_list` WHERE user_id = '{$user_info['user_id']}' and id = '{$id}'");
			$friend = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE subscriptions = 0 AND friend_id = '{$user_info['user_id']}'");
			
			if($friend) {
				if($sql) {
					if(stripos($sql['ulist'], "|{$user_id}|") === false) {
						if($sql['user_id'] == $user_info['user_id']) {
							$user_list = $sql['ulist'].'|'.$user_id.'|';
							$db->query("UPDATE `".PREFIX."_list` SET ulist = '{$user_list}' WHERE id = '{$id}'");
							echo "ok";
						} else echo "no_admin";
					} else echo "already";
				} else echo "no_list";
			} else echo "no_friend";
		
			die();
		break;
		
		case "removeuserlist":
		
			$id = intval($_POST['id']);
			$user_id = intval($_POST['user_id']);
			
			$sql = $db->super_query("SELECT ulist,user_id FROM `".PREFIX."_list` WHERE user_id = '{$user_info['user_id']}' and id = '{$id}'");
			
			if($sql) {
				if(stripos($sql['ulist'], "|{$user_id}|") !== false) {
					if($sql['user_id'] == $user_info['user_id']) {
						$db->query("UPDATE `".PREFIX."_list` SET ulist = REPLACE(`ulist`, '|{$user_id}|', '') WHERE id = '{$id}'");
						echo "ok";
					} else echo "no_admin";
				} else echo "already";
			} else echo "no_list";
		
			die();
		break;
		case "newlist":
			$text = textFilter($_POST['text']);
			$text = ajax_utf8($text);
			
			$bi = $db->super_query("SELECT id FROM `".PREFIX."_list` WHERE name = '{$text}' and user_id = '{$user_info['user_id']}'");
			
			if(!$bi) { $db->query("INSERT INTO `".PREFIX."_list` (name,user_id) values('{$text}','{$user_info['user_id']}')");
				$row = $db->super_query("SELECT id FROM `".PREFIX."_list` WHERE name = '{$text}' and user_id = '{$user_info['user_id']}'"); echo $row['id'];
			}
		
			die();
		break;
		
		case "dellist":
		
			$id = ajax_utf8(textFilter($_POST['id']));
			
			$row = $db->super_query("SELECT id FROM `".PREFIX."_list` WHERE id = '{$id}'");
			
			if($row) {
				$db->query("DELETE FROM `".PREFIX."_list` WHERE id = '{$id}'");
			}
		
			die();
		break;
		
		case "showlist":
		
			$id = intval($_POST['id']);
			
			$sql = $db->super_query("SELECT id,name,ulist FROM `".PREFIX."_list` WHERE user_id = '{$user_info['user_id']}'",1);
			$take = '';
			foreach($sql as $row) {
				if(stripos($row['ulist'], "|{$id}|") !== false) {
					$css = 'list_yesadd';
					$onclick = "friends.addUserList('".$row['id']."','".$id."','2')";
				} else {
					$css = 'list_noadd';
					$onclick = "friends.addUserList('".$row['id']."','".$id."','1')";
				}
				$take .= '<div class="'.$css.'" id="r_'.$row['id'].'_'.$id.'" onClick="'.$onclick.'">'.$row['name'].'</div>';
			}
			
			echo $take;
		
			die();
		break;
		
		
		//################### Страница заявок в друзья ###################//
		case "requests":
			$mobile_speedbar = 'Заявки в друзья';

			$user_id = $user_info['user_id'];

			if($user_info['user_friends_demands'])
				$user_speedbar = $user_info['user_friends_demands'].' '.gram_record($user_info['user_friends_demands'], 'friends_demands');
			else
				$user_speedbar = $lang['no_requests'];
			
			//Верх
			$tpl->load_template('friends/head.tpl');
			$tpl->set('{user-id}', $user_id);
			if($user_info['user_friends_demands'])
				$tpl->set('{demands}', '('.$user_info['user_friends_demands'].')');
			else
				$tpl->set('{demands}', '');
			$tpl->set('[request-friends]', '');
			$tpl->set('[/request-friends]', '');
			$tpl->set_block("'\\[all-friends\\](.*?)\\[/all-friends\\]'si","");
			$tpl->set_block("'\\[common-friends\\](.*?)\\[/common-friends\\]'si","");
			$tpl->set_block("'\\[online-friends\\](.*?)\\[/online-friends\\]'si","");
			$tpl->compile('info');
			
			//Выводим заявки в друзья если они есть
			if($user_info['user_friends_demands']){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.from_user_id, demand_date, tb2.user_photo, user_search_pref, user_country_city_name, user_birthday, user_last_visit, alias, user_real FROM `".PREFIX."_friends_demands` tb1, `".PREFIX."_users` tb2 WHERE tb1.for_user_id = '{$user_id}' AND tb1.from_user_id = tb2.user_id ORDER by `demand_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				$tpl->load_template('friends/request.tpl');
				foreach($sql_ as $row){
						$user_country_city_name = explode('|', $row['user_country_city_name']);
						$tpl->set('{country}', $user_country_city_name[0]);
						if($user_country_city_name[1])
							$tpl->set('{city}', ', '.$user_country_city_name[1]);
						else
							$tpl->set('{city}', '');
					$tpl->set('{user-id}', $row['from_user_id']);
					$tpl->set('{name}', $row['user_search_pref']);
				    //Верификация профиля
			        if($row['user_real'] == 1) {
                        $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['from_user_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['from_user_id'].'"></div>');
                    } else {
                        $tpl->set('{user_real}', '' );
                    }
						
					if($row['user_photo']){
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['from_user_id'].'/100_'.$row['user_photo']);
							$tpl->set('{big-ava}', $row['user_photo']);
					}else{
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					}
						
						
					if($row['user_last_visit'] >= $online_time)
						$tpl->set('{online}', $lang['online']);
					else
						$tpl->set('{online}', '');
									
					if($row['alias']) {
                        $tpl->set('{alias}', '/'.$row_friends['alias']);
                    } else {
                        $tpl->set('{alias}', '/u'.$row['from_user_id']);
                    }


					//Возраст юзера
					$user_birthday = explode('-', $row['user_birthday']);
					$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					
					$tpl->compile('content');
				}
				navigation($gcount, $user_info['user_friends_demands'], $config['home_url'].'friends/requests/page/');
				
			} else
				msgbox('', $lang['no_requests'], 'info_2');

		break;
		
		//################### Просмотр всех онлайн друзей ###################//
		case "online":
			$get_user_id = intval($_GET['user_id']);
			if(!$get_user_id)
				$get_user_id = $user_info['user_id'];
			
			//ЧС
			$CheckBlackList = CheckBlackList($get_user_id);
			if(!$CheckBlackList){

				if($get_user_id == $user_info['user_id'])
					$sql_order = "ORDER by `views`";
				else
					$sql_order = "ORDER by `friends_date`";
							
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, user_country_city_name, user_search_pref, user_birthday, user_photo, alias, ureal FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$get_user_id}' AND tb1.user_last_visit >= '{$online_time}' AND tb2.subscriptions = 0 {$sql_order} DESC LIMIT {$limit_page}, {$gcount}", 1);
				
				//Выводим имя юзера
				$friends_sql = $db->super_query("SELECT user_name, user_friends_num FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
				if($user_info['user_id'] != $get_user_id)
					$gram_name = gramatikName($friends_sql['user_name']);
				else
					$gram_name = 'Вас';
			
				if($sql_)
					//Кол-во друзей в онлайне
					$online_friends = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$get_user_id}' AND tb1.user_last_visit >= '{$online_time}' AND tb2.subscriptions = 0");

				if($online_friends['cnt'])
					$user_speedbar = 'У '.$gram_name.' '.$online_friends['cnt'].' '.gram_record($online_friends['cnt'], 'friends_online');
				else
					$user_speedbar = $lang['no_requests_online'];
					
				//Верх
				$tpl->load_template('friends/head.tpl');
				if($user_info['user_id'] != $get_user_id)
					$tpl->set('{name}', $gram_name);
				else
					$tpl->set('{name}', '');
					
				$tpl->set('{user-id}', $get_user_id);
				if($get_user_id == $user_info['user_id']){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
					$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					if($user_info['user_friends_demands'])
						$tpl->set('{demands}', '('.$user_info['user_friends_demands'].')');
					else
						$tpl->set('{demands}', '');
				} else {
					$tpl->set('[not-owner]', '');
					$tpl->set('[/not-owner]', '');
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				}
				$tpl->set('[online-friends]', '');
				$tpl->set('[/online-friends]', '');
				$tpl->set_block("'\\[request-friends\\](.*?)\\[/request-friends\\]'si","");
				$tpl->set_block("'\\[all-friends\\](.*?)\\[/all-friends\\]'si","");
				$tpl->compile('info');
					
				if($sql_){
					$tpl->load_template('friends/friend.tpl');
					foreach($sql_ as $row){
						$user_country_city_name = explode('|', $row['user_country_city_name']);
						$tpl->set('{country}', $user_country_city_name[0]);
						if($user_country_city_name[1])
							$tpl->set('{city}', ', '.$user_country_city_name[1]);
						else
							$tpl->set('{city}', '');
						$tpl->set('{user-id}', $row['user_id']);
						$tpl->set('{name}', $row['user_search_pref']);
						
						if($row['alias']) {
                        $tpl->set('{alias}', '/'.$row['alias']);
                        } else {
                            $tpl->set('{alias}', '/u'.$row['user_id']);
                        }
						
						//Верификация профиля
			            if($row['ureal'] == 1) {
                            $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['user_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['user_id'].'"></div>');
                        } else {
                            $tpl->set('{user_real}', '' );
                        }

						if($row['user_photo']){
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
							$tpl->set('{big-ava}', $row['user_photo']);
						}else{
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
							$tpl->set('{big-ava}', $row['user_photo']);
						}
						
						$tpl->set('{online}', $lang['online']);
						$tpl->set('{user-id}', $row['user_id']);

						//Возраст юзера
						$user_birthday = explode('-', $row['user_birthday']);
						$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));

						if($get_user_id == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
						if($row['user_id'] == $user_info['user_id'])
							$tpl->set_block("'\\[viewer\\](.*?)\\[/viewer\\]'si","");
						else {
							$tpl->set('[viewer]', '');
							$tpl->set('[/viewer]', '');
						}
		
						$tpl->compile('content');
					}
					navigation($gcount, $online_friends['cnt'], $config['home_url'].'friends/online/'.$get_user_id.'/page/');
				} else
					msgbox('', $lang['no_requests_online'], 'info_2');
			} else {
				$user_speedbar = $lang['error'];
				msgbox('', $lang['no_notes'], 'info');
			}
		break;
		
		case "search":

		NoAjaxQuery();	

			$names = $db->safesql(ajax_utf8(strip_data(urldecode($_POST['name']))));

			$names = strtr($names, array(' ' => '%')); 

			
				$get_user_id = intval($_POST['id']);
				if(!$get_user_id)
					$get_user_id = $user_info['user_id'];
					
					//Выводим кол-во друзей из таблицы юзеров
					$friends_sql = $db->super_query("SELECT user_name, user_friends_num FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
						
					
					//Все друзья
					if($friends_sql['user_friends_num']){
					
						if($get_user_id == $user_info['user_id'])
							$sql_order = "ORDER by `views`";
						else
							$sql_order = "ORDER by `friends_date`";
						$s_type = intval($_POST['type']);
						if($s_type == 1)
							$ss_type = "";
						else
							$ss_type = "AND tb1.user_last_visit >= '{$online_time}'";
						
						$sql_ = $db->super_query("SELECT tb1.friend_id, tb2.user_birthday, user_photo, user_mobile, user_search_pref, user_country_city_name, user_last_visit FROM `".PREFIX."_friends` tb1,`".PREFIX."_users` tb2 WHERE tb1.user_id = '{$get_user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 AND user_search_pref LIKE '%{$names}%'",1);
						
						if($sql_){
							$tpl->load_template('friends/friend.tpl');
							foreach($sql_ as $row){
								$user_country_city_name = explode('|', $row['user_country_city_name']);
								$tpl->set('{country}', $user_country_city_name[0]);
									
								if($user_country_city_name[1])
									$tpl->set('{city}', ', '.$user_country_city_name[1]);
								else
									$tpl->set('{city}', '');
										
								$tpl->set('{user-id}', $row['friend_id']);
								$tpl->set('{name}', $row['user_search_pref']);
									
								//Верификация профиля
			            if($row['ureal'] == 1) {
                            $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['user_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['user_id'].'"></div>');
                        } else {
                            $tpl->set('{user_real}', '' );
                        }
						
					if($row['user_photo']){
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/100_'.$row['user_photo']);
							$tpl->set('{big-ava}', $row['user_photo']);
						}else{
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
							$tpl->set('{big-ava}', $row['user_photo']);
						}
						
						
					if($row['user_last_visit'] >= $online_time)
													if($row['user_mobile']==1) $tpl->set('{online}', $lang['online'].'<b class="mob_onl friends_mob_onl"></b>'); else $tpl->set('{online}', $lang['online']);

								else
									$tpl->set('{online}', '');

								
								//Возраст юзера
								$user_birthday = explode('-', $row['user_birthday']);
								$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));

								if($get_user_id == $user_info['user_id']){
									$tpl->set('[owner]', '');
									$tpl->set('[/owner]', '');
								} else
									$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
									
								if($row['friend_id'] == $user_info['user_id'])
									$tpl->set_block("'\\[viewer\\](.*?)\\[/viewer\\]'si","");
								else {
									$tpl->set('[viewer]', '');
									$tpl->set('[/viewer]', '');
								}

								$tpl->compile('content');
							}
						} else
							msgbox('', $lang['no_requests'], 'info_2');
					} else
						msgbox('', $lang['no_requests'], 'info_2');
						
							
			AjaxTpl();	
		
			die();
		break;
		
		//################### Загрузка друзей в окне для выбора СП ###################//
		case "box":
			NoAjaxQuery();

			$user_id = $user_info['user_id'];

			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 18;
			$limit_page = ($page-1)*$gcount;

			if($_POST['user_sex'] == 1)
				$sql_usSex = 2;
			elseif($_POST['user_sex'] == 2)
				$sql_usSex = 1;
			else
				$sql_usSex = false;

			//Все друзья
			if($sql_usSex){
				$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 AND tb2.user_sex = '{$sql_usSex}'");
				
				if($count['cnt']){
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 AND tb2.user_sex = '{$sql_usSex}' ORDER by `views` DESC LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('friends/box_friend.tpl');
					foreach($sql_ as $row){
						$tpl->set('{user-id}', $row['friend_id']);
						$tpl->set('{name}', $row['user_search_pref']);
						

						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/50_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');

						$tpl->compile('content');
					}
					box_navigation($gcount, $count['cnt'], "''", 'sp.openfriends', '');
				} else
					msgbox('', '<div class="clear" style="margin-top:140px"></div>'.$lang['no_requests'], 'info_2');
			} else
				msgbox('', '<div class="clear" style="margin-top:140px"></div>'.$lang['no_requests'], 'info_2');

			AjaxTpl();
			
			die();
		break;
		
		case "adduserlist":
		
			$id = intval($_POST['id']);
			$user_id = intval($_POST['user_id']);
			
			$sql = $db->super_query("SELECT ulist,user_id FROM `".PREFIX."_list` WHERE user_id = '{$user_info['user_id']}' and id = '{$id}'");
			$friend = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE subscriptions = 0 AND friend_id = '{$user_info['user_id']}'");
			
			if($friend) {
				if($sql) {
					if(stripos($sql['ulist'], "|{$user_id}|") === false) {
						if($sql['user_id'] == $user_info['user_id']) {
							$user_list = $sql['ulist'].'|'.$user_id.'|';
							$db->query("UPDATE `".PREFIX."_list` SET ulist = '{$user_list}' WHERE id = '{$id}'");
							echo "ok";
						} else echo "no_admin";
					} else echo "already";
				} else echo "no_list";
			} else echo "no_friend";
		
			die();
		break;
		
		case "removeuserlist":
		
			$id = intval($_POST['id']);
			$user_id = intval($_POST['user_id']);
			
			$sql = $db->super_query("SELECT ulist,user_id FROM `".PREFIX."_list` WHERE user_id = '{$user_info['user_id']}' and id = '{$id}'");
			
			if($sql) {
				if(stripos($sql['ulist'], "|{$user_id}|") !== false) {
					if($sql['user_id'] == $user_info['user_id']) {
						$db->query("UPDATE `".PREFIX."_list` SET ulist = REPLACE(`ulist`, '|{$user_id}|', '') WHERE id = '{$id}'");
						echo "ok";
					} else echo "no_admin";
				} else echo "already";
			} else echo "no_list";
		
			die();
		break;
		
		
        //################### Общие друзья ###################//
		case "common":
			
			$metatags['title'] = 'Общие друзья';
			$user_speedbar = 'Общие друзья';
			
			$uid = intval($_GET['uid']);
			
			//Выводим информацию о человеке, у которого смотрим общих друзей
			$owner = $db->super_query("SELECT user_friends_num, user_name FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");
			
			//Если есть такой юзер и есть вообще друзья
			if($owner AND $owner['user_friends_num'] AND $uid != $user_info['user_id']){
				
				//Считаем кол-во общих дузей
				$count_common = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` tb1 INNER JOIN `".PREFIX."_friends` tb2 ON tb1.friend_id = tb2.user_id WHERE tb1.user_id = '{$user_info['user_id']}' AND tb2.friend_id = '{$uid}' AND tb1.subscriptions = 0 AND tb2.subscriptions = 0");
				
				//Верх
				$tpl->load_template('friends/head_common.tpl');
					
				$tpl->set('{name}', gramatikName($owner['user_name']));
				$tpl->set('{user-id}', $uid);
				
				if($count_common['cnt'])
				
					$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
				
				else {
					
					$tpl->set('[no]', '');
					$tpl->set('[/no]', '');
					
				}
					
				$tpl->compile('info');
					
				//Если есть на вывод
				if($count_common['cnt']){
					
					$user_speedbar = $count_common['cnt'].' '.gram_record($count_common['cnt'], 'friends_common');
					
					//SQL запрос на вывод друзей, по дате новых 20
					$sql_mutual = $db->super_query("SELECT tb1.friend_id, tb3.user_birthday, user_photo, user_search_pref, user_country_city_name, user_last_visit, user_logged_mobile FROM `".PREFIX."_users` tb3, `".PREFIX."_friends` tb1 INNER JOIN `".PREFIX."_friends` tb2 ON tb1.friend_id = tb2.user_id WHERE tb1.user_id = '{$user_info['user_id']}' AND tb2.friend_id = '{$uid}' AND tb1.subscriptions = 0 AND tb2.subscriptions = 0 AND tb1.friend_id = tb3.user_id ORDER by rand() LIMIT {$limit_page}, {$gcount}", 1);
					
					if($sql_mutual){
					
						$tpl->load_template('friends/common.tpl');
						
						foreach($sql_mutual as $row){
						
							$user_country_city_name = explode('|', $row['user_country_city_name']);
							$tpl->set('{country}', $user_country_city_name[0]);
										
							if($user_country_city_name[1])
								$tpl->set('{city}', ', '.$user_country_city_name[1]);
							else
								$tpl->set('{city}', '');
											
							$tpl->set('{user-id}', $row['friend_id']);
							$tpl->set('{name}', $row['user_search_pref']);
		
									//Верификация профиля
			        if($row['ureal'] == 1) {
                        $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['from_user_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['from_user_id'].'"></div>');
                    } else {
                        $tpl->set('{user_real}', '' );
                    }										
							if($row['user_photo']){
								$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/100_'.$row['user_photo']);
							$tpl->set('{big-ava}', $row['user_photo']);
                            }else{
								$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
								$tpl->set('{big-ava}', $row['user_photo']);
									}
							OnlineTpl($row['user_last_visit'], $row['user_logged_mobile']);

							//Возраст юзера
							$user_birthday = explode('-', $row['user_birthday']);
                            $tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));

							if($get_user_id == $user_info['user_id']){
							
								$tpl->set('[owner]', '');
								$tpl->set('[/owner]', '');
								
							} else
								$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
										
							$tpl->set('[viewer]', '');
							$tpl->set('[/viewer]', '');

							$tpl->compile('content');
									
						}
								
						navigation($gcount, $count_common['cnt'], $config['home_url'].'friends/common/'.$uid.'/page/');
					
					}
							
				}
					
			} else 
				msgbox('', 'У Вас с этим пользователем нет общих друзей.', 'info_2');
			
		break;
		
			default:
				
				//################### Просмотр всех друзей ###################//
				$get_user_id = intval($_GET['user_id']);
				if(!$get_user_id)
					$get_user_id = $user_info['user_id'];
					
				//ЧС
				$CheckBlackList = CheckBlackList($get_user_id);
				if(!$CheckBlackList){
					//Выводим кол-во друзей из таблицы юзеров
					$friends_sql = $db->super_query("SELECT user_name, user_friends_num FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
					
					if($user_info['user_id'] != $get_user_id)
						$gram_name = gramatikName($friends_sql['user_name']);
					else
						$gram_name = 'Вас';
					
					if($friends_sql['user_friends_num'])
						$user_speedbar = 'У '.$gram_name.' <span id="friend_num">'.$friends_sql['user_friends_num'].'</span> '.gram_record($friends_sql['user_friends_num'], 'friends');
					else
						$user_speedbar = $lang['no_requests'];
						
					//Верх
					$tpl->load_template('friends/head.tpl');
					
					if($user_info['user_id'] != $get_user_id)
						$tpl->set('{name}', $gram_name);
					else
						$tpl->set('{name}', '');
					
					if($getlist) {
						$tpl->set('[list]','');
						$tpl->set('[/list]','');
						$tpl->set('{list_id}', $getlist);
					} else {
						$tpl->set('{list_id}', '');
						$tpl->set_block("'\\[list\\](.*?)\\[/list\\]'si","");
					}
						
					
					$tpl->set('{user-id}', $get_user_id);
					if($get_user_id == $user_info['user_id']){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
						if($user_info['user_friends_demands'])
							$tpl->set('{demands}', '('.$user_info['user_friends_demands'].')');
						else
							$tpl->set('{demands}', '');
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
						
					$tpl->set('[all-friends]', '');
					$tpl->set('[/all-friends]', '');
					$tpl->set_block("'\\[request-friends\\](.*?)\\[/request-friends\\]'si","");
					$tpl->set_block("'\\[online-friends\\](.*?)\\[/online-friends\\]'si","");
					$tpl->compile('info');
						
					//Все друзья

					if($friends_sql['user_friends_num']){
					
						if($get_user_id == $user_info['user_id'])
							$sql_order = "ORDER by `views`";
						else
							$sql_order = "ORDER by `friends_date`";
						
						$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.user_birthday, user_photo, user_search_pref, user_country_city_name, user_last_visit, alias, user_real FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$get_user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 {$sql_order} DESC LIMIT {$limit_page}, {$gcount}", 1);
if($sql_){
							$tpl->result['content'] .= '<table id="main_panel" style="font-size: 11px;float:right;"><tbody><td id="main_panel" style="vertical-align: top;">';
							$tpl->load_template('friends/friend.tpl');
							$list_from = $db->super_query("SELECT *, COUNT(*) as cnt FROM `".PREFIX."_list` WHERE user_id = '{$get_user_id}' and id = '{$getlist}'");
							$i = 0;
							foreach($sql_ as $row){
								if($getlist and stripos($list_from['ulist'], "|{$row['friend_id']}|") !== false or !$getlist){
								$user_country_city_name = explode('|', $row['user_country_city_name']);
								$tpl->set('{country}', $user_country_city_name[0]);
									
								if($user_country_city_name[1])
									$tpl->set('{city}', ', '.$user_country_city_name[1]);
								else
									$tpl->set('{city}', '');
									
								if($row['alias']) {
                                    $tpl->set('{alias}', '/'.$row['alias']);
                                } else {
                                    $tpl->set('{alias}', '/u'.$row['friend_id']);
                                }
								 //Верификация профиля
			                    if($row['user_real'] == 1) {
                                    $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['friend_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['friend_id'].'"></div>');
                                } else {
                                    $tpl->set('{user_real}', '' );
                                }
								
						if($row['user_photo']){
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
							$tpl->set('{big-ava}', $row['user_photo']);
						}else{
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
							$tpl->set('{big-ava}', $row['user_photo']);
						}
								
								$tpl->set('{user-id}', $row['friend_id']);
								$tpl->set('{name}', $row['user_search_pref']);
									
								if($row['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/100_'.$row['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
									
								
								
								if($row['user_last_visit'] >= $online_time)
									$tpl->set('{online}', $lang['online']);
								else
									$tpl->set('{online}', '');
								
								//Возраст юзера
									$user_birthday = explode('-', $row['user_birthday']);
									$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));

									$search_list = $db->super_query("SELECT id,name FROM `vii_list` WHERE `ulist` LIKE '%|{$row['friend_id']}|%' and user_id = '{$get_user_id}'",1);
									
									if($search_list) {
										$list_h = '';
										foreach($search_list as $name) {
											$list_h .= '<a class="group2 fl_l lists" href="/friends/'.$get_user_id.'/list'.$name['id'].'" onclick="Page.Go(this.href); return false">'.$name['name'].'</a>';
										}
									}
									
									if($search_list) $tpl->set('{list_b}', $list_h);
									else $tpl->set('{list_b}', '');
									
									if($get_user_id == $user_info['user_id']){
										$tpl->set('[owner]', '');
										$tpl->set('[/owner]', '');
									} else
										$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
										
									if($row['friend_id'] == $user_info['user_id'])
										$tpl->set_block("'\\[viewer\\](.*?)\\[/viewer\\]'si","");
									else {
										$tpl->set('[viewer]', '');
										$tpl->set('[/viewer]', '');
									}
									
									$tpl->compile('content');
									
									$i++;
								}
							}
							if($i == 0) $tpl->result['content'] .= '<div class="info_center" style="width:458px;border-top: 1px solid #E4E7EB;padding-top: 18px;">Список пуст!</div>';
							if($getlist and $list_from) {
								if($i != 0) $user_speedbar = 'Найдено '.$i.' '.gram_record($i, 'friends');
								else $user_speedbar = 'Список пуст.';
							}
							$tpl->result['content'] .= '</td>';
							$tpl->result['content'] .= '<td id="side_panel" class="blog_left_tabf" style="background:#f7f7f7;vertical-align: top;border-top: 1px solid #E4E7EB;">';
							
							$tpl->load_template('friends/list.tpl');
							
							$row_list = $db->super_query("SELECT * FROM `".PREFIX."_list` WHERE user_id = '{$get_user_id}'",1);
							
							if(!$getlist) $tpl->set('{all_friends}','<div><a href="/friends/'.$get_user_id.'" class="bloglnkactive" onclick="Page.Go(this.href); return false">Все друзья</a></div>');
							else $tpl->set('{all_friends}','<a href="/friends/'.$get_user_id.'" class="bloglnkactive" onclick="Page.Go(this.href); return false">Все друзья</a>');
							
							foreach($row_list as $lrow) {
								if($getlist == $lrow['id']) $list .= '<div><a href="/friends/'.$get_user_id.'/list'.$lrow['id'].'" class="bloglnkactive" onclick="Page.Go(this.href); return false" id="flist_'.$lrow['id'].'">'.$lrow['name'].'</a></div>';
								else $list .= '<a href="/friends/'.$get_user_id.'/list'.$lrow['id'].'" class="bloglnkactive" onclick="Page.Go(this.href); return false" id="flist_'.$lrow['id'].'">'.$lrow['name'].'</a>';
							}
							
							$tpl->set('{list}',$list);
							$tpl->set('{user_id}', $get_user_id);
							
							if($user_info['user_id'] == $get_user_id) {
								$tpl->set('[owner]','');
								$tpl->set('[/owner]','');
							} else $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
							$tpl->compile('content');
							
							$tpl->result['content'] .= '</div></tbody></table>';
							$tpl->result['content'] .= '<style type="text/css" media="all">.padcont{padding-right:3px;padding-bottom: 0px;}</style>';
							
							navigation($gcount, $friends_sql['user_friends_num'], $config['home_url'].'friends/'.$get_user_id.'/page/');
						} else
							msgbox('', $lang['no_requests'], 'info_2');
					} else
						msgbox('', $lang['no_requests'], 'info_2');
				} else {
					$user_speedbar = $lang['error'];
					msgbox('', $lang['no_notes'], 'info');
				}
	}
	$db->free();
	$tpl->clear();
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>