<?php
/* 
	Appointment: Гости пользователя
	File: guests.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//Если страница вызвана через AJAX то включаем защиту, чтоб не могли обращаться напрямую к странице
if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$metatags['title'] = 'Гости';
	$user_id = $user_info['user_id'];
	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 100;
	$limit_page = ($page-1)*$gcount;
				
	switch($act){
	
	
		

		
		//################### Чистим счетчик гостей ###################//
		case "clear_history":
			$user_id = intval($user_info['user_id']);
                $sql_guests = $db->super_query("SELECT SQL_CALC_FOUND_ROWS user_guests FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($sql_guests){
				$db->query("DELETE FROM `".PREFIX."_guests`  WHERE myid = '{$user_id}'");
            }
		
		//Выводим сообщение о завершении процеса очистки истории.
			msgbox('', '<br /><br /> Очистка истории  кто был на вашей странице, успешно выполнена.. <br /><a href="/news" onclick="Page.Go(this.href); return false;">Перейти на главную?.</a>', 'info_2');

			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
			mozg_clear_cache();
			
			break;
		default:
			
//################### Удаления гостя из списка ###################//
		case "delete":
			NoAjaxQuery();
			$delet_uid = $db->safesql(intval($_POST['delet_uid']));
			$user_id = $user_info['uid'];
			
			//Проверяем на существования юзера в списке друзей
			$check = $db->super_query("SELECT uid FROM `".PREFIX."_guests` WHERE uid = '{$user_id}' AND uid = '{$delet_uid}' AND subscriptions = 0");
			if($check){
				//Удаляем друга из таблицы друзей
				$db->query("DELETE FROM `".PREFIX."_guests` WHERE uid = '{$user_id}' AND uid = '{$delet_uid}' AND subscriptions = 0");
				
				//Удаляем у друга из таблицы
				$db->query("DELETE FROM `".PREFIX."_guests` WHERE uid = '{$delet_uid}' AND uid = '{$user_id}' AND subscriptions = 0");
				
				//Обновляем кол-друзей у юзера
				$db->query("UPDATE `".PREFIX."_users` SET user_guests = user_guests-1 WHERE uid = '{$user_id}'");
				
				//Обновляем у друга которого удаляем кол-во друзей
				$db->query("UPDATE `".PREFIX."_users` SET user_guests = user_guests-1 WHERE uid = '{$delet_user_id}'");
				
				//Чистим кеш владельцу стр и тому кого удаляем из др.
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('user_'.$delet_user_id.'/profile_'.$delet_user_id);
				
				//Удаляем пользователя из кеш файл друзей
				$openMyList = mozg_cache("user_{$user_id}/friends");
				mozg_create_cache("user_{$user_id}/friends", str_replace("u{$delet_user_id}|", "", $openMyList));
				
				$openTakeList = mozg_cache("user_{$delet_user_id}/friends");
				mozg_create_cache("user_{$delet_user_id}/friends", str_replace("u{$user_id}|", "", $openTakeList));
			} else
				echo 'no_friend';
			
			die();
		break;
		
		  
     default:
				//################### Просмотр всех друзей ###################//
				$db->query("UPDATE `".PREFIX."_users` SET user_guests='0' WHERE user_id='{$user_id}'");
				$guests_num = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_guests` WHERE myid = '{$user_id}'");
				
					$rows = $db->super_query("SELECT COUNT(*) AS tmp FROM  `".PREFIX."_guests`  WHERE myid = '{$user_id}'");
                                        
                                        $tpl->load_template('guests/head.tpl');
                                      
					
					$tpl->set('{count}', $rows['tmp'].' гостей');
					$tpl->set('{user-id}', $get_user_id);
					
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					
						
					$tpl->compile('info');
						
				$sql_ = $db->super_query("SELECT tb1.uid,myid,date,tb2.user_id,user_sex, user_country_city_name, user_search_pref, user_birthday, user_photo, user_last_visit FROM  `".PREFIX."_guests`tb1, `".PREFIX."_users`tb2 WHERE tb1.myid = '{$user_id}' AND tb2.user_id=tb1.uid ORDER by date DESC LIMIT {$limit_page}, {$gcount}", 1);

						if($sql_){
							$tpl->load_template('guests/friend.tpl');
							
							foreach($sql_ as $row){
								$user_country_city_name = explode('|', $row['user_country_city_name']);
								$tpl->set('{country}', $user_country_city_name[0]);
									
								if($user_country_city_name[1])
									$tpl->set('{city}', ', '.$user_country_city_name[1]);
								else
									$tpl->set('{city}', '');
								
								if(date('Y-m-d', $row['date']) == date('Y-m-d', $server_time))
									$dateTell = langdate('сегодня в H:i', $row['date']);
								elseif(date('Y-m-d', $row['date']) == date('Y-m-d', ($server_time-84600)))
									$dateTell = langdate('вчера в H:i', $row['date']);
								else
									$dateTell = langdate('j F Y в H:i', $row['date']);
								
								if($row['user_sex'] == 1)
									$sex = 'Заходил ';
								else
									$sex = 'Заходила ';
								
								$tpl->set('{date}',$sex.$dateTell);
								$tpl->set('{user-id}', $row['user_id']);
								$tpl->set('{name}', $row['user_search_pref']);
								//Верификация профиля
			        if($row['user_real'] == 1) {
                        $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['from_user_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['from_user_id'].'"></div>');
                    } else {
                        $tpl->set('{user_real}', '' );
                    }
									
								if($row['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
								
								if($row['user_last_visit'] >= $online_time)
									$tpl->set('{online}', $lang['online']);
								else
									$tpl->set('{online}', '');
								$tpl->set('{big-ava}', $row['user_photo']);
								//Верификация профиля
			                    if($row['ureal'] == 1) {
                                    $tpl->set('{ureal}', '<div class="search_verified" onmouseover="myhtml.title('. $row['friend_id'].',\''.'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['friend_id'].'"></div>');
                                } else {
                                    $tpl->set('{ureal}', '' );
                                }
										
								$tpl->set('{user-id}', $row['user_id']);
								$tpl->set('{name}', $row['user_search_pref']);
									
								if($row['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
									$tpl->set('{big-ava}', $row['user_photo']);
								
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
							
							navigation($gcount, $guests_num['cnt'], $config['home_url'].'guests/page/');	
						}else
					         msgbox('', 'Пока никто не посещал вашу страницу.', 'info_2');
					
                    

	}
	$db->free();
	$tpl->clear();
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>
