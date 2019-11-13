<?php
/* 
	Appointment: Просмотр страницы пользователей
	File: profile.php 
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

$user_id = $user_info['user_id'];

if($logged){
	$id = intval($_GET['id']);
	$cache_folder = 'user_'.$id;
	
	if(preg_match("/^[a-zA-Z0-9_-]+$/", $_GET['get_adres'])) $get_adres = $db->safesql($_GET['get_adres']);
	
	$sql_where = "id = '".$id."'";
	
	if($id){
		$get_adres = '';
		$sql_where = "id = '".$id."'";
	}
	if($get_adres){
		$id = '';
		$sql_where = "adres = '".$get_adres."'";
	} else
	
	echo $get_adres;

	//Читаем кеш
	$row = unserialize(mozg_cache($cache_folder.'/profile_'.$id));

	//Проверяем на наличие кеша, если нету то выводи из БД и создаём его 
	if(!$row){
		$row = $db->super_query("SELECT user_id, user_logged_mobile, user_search_pref, user_country_city_name, user_birthday, user_xfields, user_city, user_country, user_photo, user_friends_num, user_notes_num, user_subscriptions_num, user_wall_num, user_albums_num, user_last_visit, user_videos_num, user_status, user_privacy, user_sp, user_sex, user_gifts, user_public_num, user_audio, user_delet, user_ban_date, xfields, type_profile, user_cover, user_cover_pos, user_real, user_code, user_znachok, user_delete_type, user_dev, user_otcestvo, user_grandparents, user_parents, user_siblings, user_children, user_grandchildren, user_hometown, user_rai, user_metro, user_ulica, user_nazvanie, user_activity, user_interes, user_myinfo, user_music, user_kino, user_shou, user_serial, user_books, user_games, user_quote, user_shkola, user_datasr, user_klass, user_spec, user_nacalosr, user_konecsr, user_countrysr, user_citysr, user_vuz, user_fac, user_form, user_statusvi, user_datavi, user_countryvi, user_cityvi, user_mesto, user_nacaloca, user_konecca, user_dolj, user_countryca, user_cityca, user_chast, user_zvanie, user_nacalosl, user_konecsl, user_countrysl, user_citysl, user_pred, user_miro, user_jizn, user_ludi, user_kurenie, user_alkogol, user_narkotiki, user_vdox, user_country_city_namesr, user_country_city_namevi, user_country_city_nameca, user_country_city_namesl, user_guests, user_vip, user_rating FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
		if($row){
			mozg_create_folder_cache($cache_folder);
			mozg_create_cache($cache_folder.'/profile_'.$id, serialize($row));
		}
		$row_online['user_last_visit'] = $row['user_last_visit'];
		$row_online['user_logged_mobile'] = $row['user_logged_mobile'];
	} else 
		$row_online = $db->super_query("SELECT user_last_visit, user_logged_mobile, mobile FROM `".PREFIX."_users` WHERE user_id = '{$id}'");

	//Если есть такой, юзер то продолжаем выполнение скрипта
	$row_guests = $db->super_query("SELECT user_privacy FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'"); 
                $guests_privacy = xfieldsdataload($row_guests['user_privacy']);

				// Проверка настроек приватности пользователя 
				if($user_id != $id  AND $guests['val_guests2'] != 3) {

					$new_intro = $db->super_query("SELECT id FROM `".PREFIX."_guests` WHERE uid = '{$user_id}'");

					if($new_intro){

						$db->query("UPDATE `".PREFIX."_guests` SET uid = '{$user_id}', myid = '{$id}', date = '{$server_time}'  WHERE uid = '{$user_id}'");

					} else {

						$db->query("INSERT INTO `".PREFIX."_guests` (uid,myid,date) VALUES ('{$user_id}','{$id}','{$server_time}')");
						
						$db->query("UPDATE `".PREFIX."_users` SET user_guests=user_guests+1 WHERE user_id='{$id}'");
						
						$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
						$update_time = $server_time - 70;

						if($row_owner['user_last_visit'] >= $update_time){
							$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$id}', from_user_id = '{$user_info['user_id']}', type = '25', date = '{$server_time}', text = 'Посетил Вашу страницу', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/guests'");
							mozg_create_cache("user_{$id}/updates", 1);
						}

					}

                }
	
				
	if($row){
		$mobile_speedbar = $row['user_search_pref'];
		$user_speedbar = $row['user_search_pref'];
		$metatags['title'] = $row['user_search_pref'];
		
		//Если удалена
		if($row['user_delet'] or $row['user_delete_type']!=0){
			$tpl->load_template("profile_delete_all.tpl");
			$user_name_lastname_exp = explode(' ', $row['user_search_pref']);
			$tpl->set('{name}', $user_name_lastname_exp[0]);
			$tpl->set('{lastname}', $user_name_lastname_exp[1]);
			$tpl->compile('content');
		//Если заблокирована
		} elseif($row['user_ban_date'] >= $server_time OR $row['user_ban_date'] == '0'){
			$tpl->load_template("profile_baned_all.tpl");
			$user_name_lastname_exp = explode(' ', $row['user_search_pref']);
			$tpl->set('{name}', $user_name_lastname_exp[0]);
			$tpl->set('{lastname}', $user_name_lastname_exp[1]);
			$tpl->compile('content');
		//Если все хорошо, то выводим дальше
		} else {
		    $nocashe = $db->super_query("SELECT user_mobile, user_balance, ms FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
			
			$CheckBlackList = CheckBlackList($id);
			
			$user_privacy = xfieldsdataload($row['user_privacy']);

			$user_name_lastname_exp = explode(' ', $row['user_search_pref']);
			$user_country_city_name_exp = explode('|', $row['user_country_city_name']);
			$user_country_city_namesr_exp = explode('|', $row['user_country_city_namesr']);
			$user_country_city_namevi_exp = explode('|', $row['user_country_city_namevi']);
			$user_country_city_nameca_exp = explode('|', $row['user_country_city_nameca']);
			$user_country_city_namesl_exp = explode('|', $row['user_country_city_namesl']);
			
			//################### Друзья ###################//
			if($row['user_friends_num']){
				$sql_friends = $db->super_query("SELECT tb1.friend_id, tb2.user_search_pref, user_photo, alias FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$id}' AND tb1.friend_id = tb2.user_id  AND subscriptions = 0 ORDER by rand() DESC LIMIT 0, 6", 1);
				$tpl->load_template('profile_friends_2.tpl');
				foreach($sql_friends as $row_friends){
					$friend_info = explode(' ', $row_friends['user_search_pref']);
					$tpl->set('{user-id}', $row_friends['friend_id']);
					$tpl->set('{name}', $friend_info[0]);
					$tpl->set('{last-name}', $friend_info[1]);
					if($row_friends['alias'])
                        $tpl->set('{alias}', '/'.$row_friends['alias']);
                    else
                       $tpl->set('{alias}', '/u'.$row_friends['friend_id']);
					if($row_friends['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_friends['friend_id'].'/100_'.$row_friends['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					$tpl->compile('all_friends');
				}
			}
			
	//Общие друзья
   if($row['user_friends_num'] AND $id != $user_info['user_id']){
    
    $count_common = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` tb1 INNER JOIN `".PREFIX."_friends` tb2 ON tb1.friend_id = tb2.user_id WHERE tb1.user_id = '{$user_info['user_id']}' AND tb2.friend_id = '{$id}' AND tb1.subscriptions = 0 AND tb2.subscriptions = 0");
    
    if($count_common['cnt']){
    
     $sql_mutual = $db->super_query("SELECT tb1.friend_id, tb3.user_photo, user_search_pref FROM `".PREFIX."_users` tb3, `".PREFIX."_friends` tb1 INNER JOIN `".PREFIX."_friends` tb2 ON tb1.friend_id = tb2.user_id WHERE tb1.user_id = '{$user_info['user_id']}' AND tb2.friend_id = '{$id}' AND tb1.subscriptions = 0 AND tb2.subscriptions = 0 AND tb1.friend_id = tb3.user_id ORDER by rand() LIMIT 0, 3", 1);
     
     $tpl->load_template('profile_friends.tpl');
     
     foreach($sql_mutual as $row_mutual){
      
      $friend_info_mutual = explode(' ', $row_mutual['user_search_pref']);
      
      $tpl->set('{user-id}', $row_mutual['friend_id']);
      $tpl->set('{name}', $friend_info_mutual[0]);
      $tpl->set('{last-name}', $friend_info_mutual[1]);
	  if($row_friends['alias'])
                        $tpl->set('{alias}', '/'.$row_mutual['alias']);
                    else
                       $tpl->set('{alias}', '/u'.$row_mutual['friend_id']);
      
      if($row_mutual['user_photo'])
       $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_mutual['friend_id'].'/50_'.$row_mutual['user_photo']);

      else
       $tpl->set('{ava}', '{theme}/images/no_ava_50.png');

      $tpl->compile('mutual_friends');
      
     }
    
    }
    
   }
			
			//################### Друзья на сайте ###################//
			if($user_id != $id)
				//Проверка естьли запрашиваемый юзер в друзьях у юзера который смотрит стр
				$check_friend = CheckFriends($row['user_id']);
			
			//Кол-во друзей в онлайне
			if($row['user_friends_num']){
				$online_friends = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$id}' AND tb1.user_last_visit >= '{$online_time}' AND subscriptions = 0");
				
				//Если друзья на сайте есть то идем дальше
				if($online_friends['cnt']){
					$sql_friends_online = $db->super_query("SELECT tb1.user_id, user_country_city_name, user_search_pref, user_birthday, user_photo, alias FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$id}' AND tb1.user_last_visit >= '{$online_time}'  AND subscriptions = 0 ORDER by rand() DESC LIMIT 0, 6", 1);
					$tpl->load_template('profile_friends_2.tpl');
					foreach($sql_friends_online as $row_friends_online){
						$friend_info_online = explode(' ', $row_friends_online['user_search_pref']);
						$tpl->set('{user-id}', $row_friends_online['user_id']);
						$tpl->set('{name}', $friend_info_online[0]);
						$tpl->set('{last-name}', $friend_info_online[1]);
						
						if($row_friends_online['alias'])
                            $tpl->set('{alias}', '/'.$row_friends_online['alias']);
                        else 
                            $tpl->set('{alias}', '/u'.$row_friends_online['user_id']);
						if($row_friends_online['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_friends_online['user_id'].'/100_'.$row_friends_online['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						$tpl->compile('all_online_friends');
					}
				}
			}
			
			//################### Заметки ###################//
			if($row['user_notes_num']){
				$tpl->result['notes'] = mozg_cache($cache_folder.'/notes_user_'.$id);
				if(!$tpl->result['notes']){
					$sql_notes = $db->super_query("SELECT id, title, date, comm_num FROM `".PREFIX."_notes` WHERE owner_user_id = '{$id}' ORDER by `date` DESC LIMIT 0,3", 1);
					$tpl->load_template('profile_note.tpl');
					foreach($sql_notes as $row_notes){
						$tpl->set('{id}', $row_notes['id']);
						$tpl->set('{title}', stripslashes($row_notes['title']));
						$tpl->set('{comm-num}', $row_notes['comm_num'].' '.gram_record($row_notes['comm_num'], 'comments'));
						megaDate(strtotime($row_notes['date']), 'no_year');
						$tpl->compile('notes');
					}
					mozg_create_cache($cache_folder.'/notes_user_'.$id, $tpl->result['notes']);
				}
			}
			
			//################### Видеозаписи ###################//
			if($row['user_videos_num']){	
				//Настройки приватности
				if($user_id == $id)
					$sql_privacy = "";
				elseif($check_friend){
					$sql_privacy = "AND privacy regexp '[[:<:]](1|2)[[:>:]]'";
					$cache_pref_videos = "_friends";
				} else {
					$sql_privacy = "AND privacy = 1";
					$cache_pref_videos = "_all";
				}
				
				//Если страницу смотрит другой юзер, то считаем кол-во видео
				if($user_id != $id){
					$video_cnt = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos` WHERE owner_user_id = '{$id}' {$sql_privacy}", false, "user_{$id}/videos_num{$cache_pref_videos}");
					$row['user_videos_num'] = $video_cnt['cnt'];
				}
					
				$sql_videos = $db->super_query("SELECT id, title, add_date, comm_num, photo FROM `".PREFIX."_videos` WHERE owner_user_id = '{$id}' {$sql_privacy} ORDER by `add_date` DESC LIMIT 0,2", 1, "user_{$id}/page_videos_user{$cache_pref_videos}");
				
				$tpl->load_template('profile_video.tpl');
				foreach($sql_videos as $row_videos){
					$tpl->set('{photo}', $row_videos['photo']);
					$tpl->set('{id}', $row_videos['id']);
					$tpl->set('{user-id}', $id);
					$tpl->set('{title}', stripslashes($row_videos['title']));
					$tpl->set('{comm-num}', $row_videos['comm_num'].' '.gram_record($row_videos['comm_num'], 'comments'));
					megaDate(strtotime($row_videos['add_date']), '');
					$tpl->compile('videos');
				}
			}
			
			//################### Подписки ###################//
			if($row['user_subscriptions_num']){
				$tpl->result['subscriptions'] = mozg_cache('/subscr_user_'.$id);
				if(!$tpl->result['subscriptions']){
					$sql_subscriptions = $db->super_query("SELECT tb1.friend_id, tb2.user_search_pref, user_photo, user_country_city_name, user_status, alias FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$id}' AND tb1.friend_id = tb2.user_id AND  	tb1.subscriptions = 1 ORDER by `friends_date` DESC LIMIT 0,5", 1);
					$tpl->load_template('profile_subscription.tpl');
					foreach($sql_subscriptions as $row_subscr){
						$tpl->set('{user-id}', $row_subscr['friend_id']);
						$tpl->set('{name}', $row_subscr['user_search_pref']);
						$row_subscr['user_status'] = strip_tags($row_subscr['user_status']);
						if($row_subscr['user_status'])
							$tpl->set('{info}', stripslashes(substr($row_subscr['user_status'], 0, 24)));
						else {
							$country_city = explode('|', $row_subscr['user_country_city_name']);
							$tpl->set('{info}', $country_city[1]);
						}
						 if($row_subscr['alias'])
                            $tpl->set('{alias}', '/'.$row_subscr['alias']);
                        else
                            $tpl->set('{alias}', '/u'.$row_subscr['friend_id']);
						if($row_subscr['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_subscr['friend_id'].'/50_'.$row_subscr['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->compile('subscriptions');
					}
					mozg_create_cache('/subscr_user_'.$id, $tpl->result['subscriptions']);
				}
			}
				 
			//################### Музыка ###################//
			if($row['user_audio']){
				$sql_audio = $db->super_query("SELECT url, artist, name FROM `".PREFIX."_audio` WHERE auser_id = '".$id."' ORDER by `adate` DESC LIMIT 0, 3", 1, 'user_'.$id.'/audios_profile');
				$tpl->load_template('audio/profile.tpl');
				$jid = 0;
				foreach($sql_audio as $row_audio){
					$jid++;
					$tpl->set('{jid}', $jid);
					$tpl->set('{uid}', $id);
					$tpl->set('{url}', $row_audio['url']);
					$tpl->set('{artist}', stripslashes($row_audio['artist']));
					$tpl->set('{name}', stripslashes($row_audio['name']));
					$tpl->compile('audios');
				}
			}
			
			//################### Праздники друзей ###################//
			if($user_id == $id AND !$_SESSION['happy_friends_block_hide']){
				$sql_happy_friends = $db->super_query("SELECT tb1.friend_id, tb2.user_search_pref, user_photo, user_birthday, alias FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '".$id."' AND tb1.friend_id = tb2.user_id  AND subscriptions = 0 AND user_day = '".date('j', $server_time)."' AND user_month = '".date('n', $server_time)."' ORDER by `user_last_visit` DESC LIMIT 0, 50", 1);
				$tpl->load_template('profile_happy_friends.tpl');
				$cnt_happfr = 0;
				foreach($sql_happy_friends as $happy_row_friends){
					$cnt_happfr++;
					$tpl->set('{user-id}', $happy_row_friends['friend_id']);
					if($happy_row_friends['alias'])
                            $tpl->set('{alias}', '/'.$happy_row_friends['alias']);
                        else
                            $tpl->set('{alias}', '/u'.$happy_row_friends['friend_id']);
					$tpl->set('{user-name}', $happy_row_friends['user_search_pref']);
					$user_birthday = explode('-', $happy_row_friends['user_birthday']);
					$tpl->set('{user-age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					if($happy_row_friends['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$happy_row_friends['friend_id'].'/50_'.$happy_row_friends['user_photo']);
					else $tpl->set('{ava}', '{theme}/images/50_no_ava.png');	
					$tpl->compile('happy_all_friends');
				}
			}

			//################### Загрузка стены ###################//
			if($row['user_wall_num'])
				include ENGINE_DIR.'/modules/wall.php';
				
			//Заполненность профиля
        if($row['user_country'] != 0){
            $country2 = '20';
            $tpl->set_block("'\\[all-country2\\](.*?)\\[/all-country2\\]'si","");
        } else {
            $country2 = '0';
            $tpl->set('[all-country2]','');
            $tpl->set('[/all-country2]','');
        }

        if($row['user_city'] != 0) {
            $city2 = '20';
            $tpl->set_block("'\\[all-city2\\](.*?)\\[/all-city2\\]'si","");
        } else {
            $city2 = '0';
            $tpl->set('[all-city2]','');
            $tpl->set('[/all-city2]','');
        }
       
        if($row['user_xfields'] != NULL) {
            $xfields2 = '20';
            $tpl->set_block("'\\[all-contact\\](.*?)\\[/all-contact\\]'si","");
        } else {
            $xfields2 = '0';
            $tpl->set('[all-contact]','');
            $tpl->set('[/all-contact]','');
        }
   
        if($row['user_interes'] != NULL){
            $interes = '20';
            $tpl->set_block("'\\[all-interes\\](.*?)\\[/all-interes\\]'si","");
        } else {
            $interes = '0';
            $tpl->set('[all-interes]','');
            $tpl->set('[/all-interes]','');
        }
   
        if($row['user_photo']){
            $foto = '20';
            $tpl->set_block("'\\[all-foto\\](.*?)\\[/all-foto\\]'si","");
        } else {
            $foto = '0';
            $tpl->set('[all-foto]','');
            $tpl->set('[/all-foto]','');
        }
 
        $rates = $city2 + $country2 + $xfields2 + $interes + $foto;
   
        if($rates == 100){
   
            $tpl->set_block("'\\[all-rate\\](.*?)\\[/all-rate\\]'si","");
   
        } else {
            $tpl->set('{rates}', $rates);
            $tpl->set('[all-rate]','');
            $tpl->set('[/all-rate]','');
        }

			$tpl->set('{user-id}', $row['user_id']);
			$tpl->set('{user-ph}', $row['user_photo']);
		if($row_online['mobile'] == 0){
            $tpl->set_block("'\\[all-mobile\\](.*?)\\[/all-mobile\\]'si","");
        } else {
      
            $mobile ='<img src="./templates/Default/images/mobile.PNG">';
            $tpl->set('{mobile}', $mobile);
            $tpl->set('[all-mobile]','');
            $tpl->set('[/all-mobile]','');
   
        }
		
			
			//Страна и город
			$tpl->set('{country}', $user_country_city_name_exp[0]);
			$tpl->set('{country-id}', $row['user_country']);
			$tpl->set('{city}', $user_country_city_name_exp[1]);
			$tpl->set('{city-id}', $row['user_city']);
            $tpl->set('{{user_guests}}', $row['{user_guests}']);
				
				
			if($row_online['user_last_visit'] >= $online_time)
				if($nocashe['user_mobile']==1) $tpl->set('{online}', $lang['online'].'<b onclick="otherbox.mobile();" class="mob_onl friends_mob_onl"></b>'); else $tpl->set('{online}', $lang['online']);
			else {
				if(date('Y-m-d', $row_online['user_last_visit']) == date('Y-m-d', $server_time))
					$dateTell = langdate('сегодня в H:i', $row_online['user_last_visit']);
				elseif(date('Y-m-d', $row_online['user_last_visit']) == date('Y-m-d', ($server_time-84600)))
					$dateTell = langdate('вчера в H:i', $row_online['user_last_visit']);
				else
					$dateTell = langdate('j F Y в H:i', $row_online['user_last_visit']);
				if($row['user_sex'] == 2)
					if($nocashe['user_mobile']==1) $tpl->set('{online}', 'последний раз была '.$dateTell.'<b onclick="otherbox.mobile();"  class="mob_onl friends_mob_onl"></b>'); else $tpl->set('{online}', 'последний раз была '.$dateTell);
				else
					if($nocashe['user_mobile']==1) $tpl->set('{online}', 'последний раз был '.$dateTell.'<b onclick="otherbox.mobile();"  class="mob_onl friends_mob_onl"></b>'); else $tpl->set('{online}', 'последний раз был '.$dateTell);
			}
			
			//Верификация профиля
			if($row['user_real'] == 1) {
                     $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title(\'188\',\'Подтверждённая страница \', \''.'newBBlockl'.'\')" id="newBBlockl188"></div>');
            } else {
                     $tpl->set('{user_real}', '' );
            }
			
			//Вывод в инфо сколько лет человеку
			$user_birthday = explode('-', $row['user_birthday']);
			$tpl->set('{user-age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));	
			
			//Теги для закрытие и открытие блоков для неавторизованных пользователей
            if($logged){
	            $tpl->set_block("'\\[not-logged\\](.*?)\\[/not-logged\\]'si","");
	            $tpl->set('[logged]','');
	            $tpl->set('[/logged]','');
	
            } else {
	            $tpl->set_block("'\\[logged\\](.*?)\\[/logged\\]'si","");
	            $tpl->set('[not-logged]','');
	            $tpl->set('[/not-logged]','');
            }
			      
			
			if($row['user_city'] AND $row['user_country']){
				$tpl->set('[not-all-city]','');
				$tpl->set('[/not-all-city]','');
			} else 
				$tpl->set_block("'\\[not-all-city\\](.*?)\\[/not-all-city\\]'si","");
				
			if($row['user_country']){
				$tpl->set('[not-all-country]','');
				$tpl->set('[/not-all-country]','');
			} else 
				$tpl->set_block("'\\[not-all-country\\](.*?)\\[/not-all-country\\]'si","");
				
				//Ask translit
			if($user_id !== $row['user_id']){
				$tpl->set('[not-ask-send]','');
				$tpl->set('[/not-ask-send]','');
			} else
				$tpl->set_block("'\\[not-ask-send\\](.*?)\\[/not-ask-send\\]'si","");
				
				 //################### Вопросы ###################//

            $sql_ = $db->super_query("SELECT tb1.*,tb2.user_id, user_search_pref, user_photo FROM `".PREFIX."_user_ask` tb1,`".PREFIX."_users` tb2 WHERE tb1.author_user_id=tb2.user_id AND tb1.for_user_id = '{$id}' AND tb1.answer !='' ORDER BY tb1.id DESC",1);
            foreach($sql_ as $ask){
                if(date('Y-m-d', $ask['date']) == date('Y-m-d', $server_time))
                $dateTell = langdate('сегодня в H:i', $ask['date']);
                elseif(date('Y-m-d', $ask['date']) == date('Y-m-d', ($server_time-84600)))
                $dateTell = langdate('вчера в H:i', $ask['date']);
                else
                $dateTell = langdate('j F Y в H:i', $ask['date']);
                $adres = '/id'.$ask['user_id'];
    if($ask['user_photo']){
     $ava = 'uploads/users/'.$ask['user_id'].'/50_'.$ask['user_photo'];
    }else{
     $ava = 'images/no_ava_50.png';
    }

                $ask_view .='
                 <div class="fm_ask_show">
                 <div class="fm_ask_con"><div class="fm_ava_mini_ask" id="ava_rec_'.$ask['id'].'"><a href="'.$adres.'" onClick="Page.Go(this.href); return false"><img src="'.$ava.'" alt="" title="" style="width: 50px;" /></a></div></div>
                 <div class="wallauthor fm_ask_nav fl_l">Вопрос от&nbsp;<a href="'.$adres.'" onClick="Page.Go(this.href); return false">'.$ask['user_search_pref'].'</a><br /><span class="color777" style="font-size: 11px;">'.$ask['text_ask'].'</span>
                 <div class="walltext fm_ask_wtext">'.$ask['answer'].'</div>
     </div><br />
                 <div class="size10 infowalltext_f clear">
                 <div class="fl_l"> <span id="fast_comm_link_{rec-id}" class="fast_comm_link">'.$dateTell.'</span></div>
                 </div>
                 </div>';
            }

   if($row['user_id'] !== $user_id){
    $tpl->set('{ask_link}', '<a class="cursor_pointer" onClick="ask.showask()"><div>Всего ответов ('.$row['ask_answer_num'].'). Задать вопрос</a>');
   } else {
    $tpl->set('{ask_link}', '<a class="cursor_pointer" onClick="ask.showask()"><div>Всего ответов ('.$row['ask_answer_num'].')</a>');
   }

   if(!empty($row['ask_answer_num'])){
    $tpl->set('{ask_pro}', $ask_view);
   } else {
    $tpl->set('{ask_pro}', '<div style=";padding: 10px;color: #666;text-align: center;">В данный момент нету ответов на вопросы. :(</div>');
   }
			
			//Конакты
            if($row['user_city'] OR $row['user_country'] OR $row['user_rai'] OR $row['user_metro'] OR $row['user_ulica'] OR $row['user_nazvanie'] OR $row['user_xfields']){
				$tpl->set('[not-block-contact]','');
			
			$xfields = xfieldsdataload($row['user_xfields']);
			$preg_safq_name_exp = explode(', ', 'phone, vk, od, skype, fb, icq, site');
			
			if($row['user_city'] AND $row['user_country']){
				$tpl->set('[not-all-city]','');
				$tpl->set('[/not-all-city]','');
			} else 
				$tpl->set_block("'\\[not-all-city\\](.*?)\\[/not-all-city\\]'si","");
				
			if($row['user_country']){
				$tpl->set('[not-all-country]','');
				$tpl->set('[/not-all-country]','');
			} else 
				$tpl->set_block("'\\[not-all-country\\](.*?)\\[/not-all-country\\]'si","");
			
			
			$tpl->set('{rai}', $row['user_rai']);
			    if($row['user_rai']){
				$tpl->set('[rai]','');
				$tpl->set('[/rai]','');
			} else 
				$tpl->set_block("'\\[rai\\](.*?)\\[/rai\\]'si","");
				
			$tpl->set('{metro}', $row['user_metro']);
			    if($row['user_metro']){
				$tpl->set('[metro]','');
				$tpl->set('[/metro]','');
			} else 
				$tpl->set_block("'\\[metro\\](.*?)\\[/metro\\]'si","");
				
			$tpl->set('{ulica}', $row['user_ulica']);
			    if($row['user_ulica']){
				$tpl->set('[ulica]','');
				$tpl->set('[/ulica]','');
			} else 
				$tpl->set_block("'\\[ulica\\](.*?)\\[/ulica\\]'si","");
				
			$tpl->set('{nazvanie}', $row['user_nazvanie']);
			    if($row['user_nazvanie']){
				$tpl->set('[nazvanie]','');
				$tpl->set('[/nazvanie]','');
			} else 
				$tpl->set_block("'\\[nazvanie\\](.*?)\\[/nazvanie\\]'si","");
				
				foreach($preg_safq_name_exp as $preg_safq_name){
				if($xfields[$preg_safq_name]){
					$tpl->set("[not-contact-{$preg_safq_name}]", '');
					$tpl->set("[/not-contact-{$preg_safq_name}]", '');
				} else
					$tpl->set_block("'\\[not-contact-{$preg_safq_name}\\](.*?)\\[/not-contact-{$preg_safq_name}\\]'si","");
			}
				
			$tpl->set('{vk}', '<a href="'.stripslashes($xfields['vk']).'" target="_blank">'.stripslashes($xfields['vk']).'</a>');
			$tpl->set('{od}', '<a href="'.stripslashes($xfields['od']).'" target="_blank">'.stripslashes($xfields['od']).'</a>');
			$tpl->set('{fb}', '<a href="'.stripslashes($xfields['fb']).'" target="_blank">'.stripslashes($xfields['fb']).'</a>');
			$tpl->set('{skype}', stripslashes($xfields['skype']));
			$tpl->set('{icq}', stripslashes($xfields['icq']));
			$tpl->set('{phone}', stripslashes($xfields['phone']));
			
			if(preg_match('/http:\/\//i', $xfields['site']))
				if(preg_match('/\.ru|\.com|\.net|\.su|\.in\.ua|\.ua/i', $xfields['site']))
					$tpl->set('{site}', '<a href="'.stripslashes($xfields['site']).'" target="_blank">'.stripslashes($xfields['site']).'</a>');
				else
					$tpl->set('{site}', stripslashes($xfields['site']));
			else
				$tpl->set('{site}', 'http://'.stripslashes($xfields['site']));
			$tpl->set('[/not-block-contact]','');
			} else 
				$tpl->set_block("'\\[not-block-contact\\](.*?)\\[/not-block-contact\\]'si","");
			
			//Интересы
				if($row['user_activity'] OR $row['user_interes'] OR $row['user_music'] OR $row['user_kino'] OR $row['user_serial'] OR $row['user_shou'] OR $row['user_books'] OR $row['user_quote'] OR $row['user_games'] OR $row['user_myinfo']){
				$tpl->set('[interests]','');
				
				$tpl->set('{activity}', $row['user_activity']);
if($row['user_activity']){
$tpl->set('[activity]','');
$tpl->set('[/activity]','');
} else
$tpl->set_block("'\[activity\](.*?)\[/activity\]'si","");
				
				$tpl->set('{interes}', $row['user_interes']);
			    if($row['user_interes']){
				$tpl->set('[interes]','');
				$tpl->set('[/interes]','');
			} else 
				$tpl->set_block("'\\[interes\\](.*?)\\[/interes\\]'si","");
				
				$tpl->set('{music}', $row['user_music']);
			    if($row['user_music']){
				$tpl->set('[music]','');
				$tpl->set('[/music]','');
			} else 
				$tpl->set_block("'\\[music\\](.*?)\\[/music\\]'si","");
				
				$tpl->set('{kino}', $row['user_kino']);
			    if($row['user_kino']){
				$tpl->set('[kino]','');
				$tpl->set('[/kino]','');
			} else 
				$tpl->set_block("'\\[kino\\](.*?)\\[/kino\\]'si","");
				
				$tpl->set('{shou}', $row['user_shou']);
			    if($row['user_shou']){
				$tpl->set('[shou]','');
				$tpl->set('[/shou]','');
			} else 
				$tpl->set_block("'\\[shou\\](.*?)\\[/shou\\]'si","");
				
				$tpl->set('{serial}', $row['user_serial']);
			    if($row['user_serial']){
				$tpl->set('[serial]','');
				$tpl->set('[/serial]','');
			} else 
				$tpl->set_block("'\\[serial\\](.*?)\\[/serial\\]'si","");
				
				$tpl->set('{books}', $row['user_books']);
			    if($row['user_books']){
				$tpl->set('[books]','');
				$tpl->set('[/books]','');
			} else 
				$tpl->set_block("'\\[books\\](.*?)\\[/books\\]'si","");
				
				$tpl->set('{games}', $row['user_games']);
			    if($row['user_games']){
				$tpl->set('[games]','');
				$tpl->set('[/games]','');
			} else 
				$tpl->set_block("'\\[games\\](.*?)\\[/games\\]'si","");
				
				$tpl->set('{quote}', $row['user_quote']);
			    if($row['user_quote']){
				$tpl->set('[quote]','');
				$tpl->set('[/quote]','');
			} else 
				$tpl->set_block("'\\[quote\\](.*?)\\[/quote\\]'si","");
				
				$tpl->set('{myinfo}', $row['user_myinfo']);
			    if($row['user_myinfo']){
				$tpl->set('[myinfo]','');
				$tpl->set('[/myinfo]','');
			} else 
				$tpl->set_block("'\\[myinfo\\](.*?)\\[/myinfo\\]'si","");
				$tpl->set('[/interests]','');
			} else 
				$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
				
			//Среднее образование
			if($row['user_countrysr'] OR $row['user_citysr'] OR $row['user_shkola'] OR $row['user_nacalosr'] OR $row['user_konecsr'] OR $row['user_datasr'] OR $row['user_klass'] OR $row['user_spec']){
				$tpl->set('[education]','');
				
			
			$tpl->set('{countrysr}', $user_country_city_namesr_exp[0]);
			$tpl->set('{citysr}', $user_country_city_namesr_exp[1]);
			
			if($row['user_citysr'] AND $row['user_countrysr']){
				$tpl->set('[citysr]','');
				$tpl->set('[/citysr]','');
			} else 
				$tpl->set_block("'\\[citysr\\](.*?)\\[/citysr\\]'si","");
				
			if($row['user_countrysr']){
				$tpl->set('[countrysr]','');
				$tpl->set('[/countrysr]','');
			} else 
				$tpl->set_block("'\\[countrysr\\](.*?)\\[/countrysr\\]'si","");
				
				
				$tpl->set('{shkola}', $row['user_shkola']);
			    if($row['user_shkola']){
				$tpl->set('[shkola]','');
				$tpl->set('[/shkola]','');
			} else 
				$tpl->set_block("'\\[shkola\\](.*?)\\[/shkola\\]'si","");
				
				$tpl->set('{nacalosr}', $row['user_nacalosr']);
			    if($row['user_nacalosr']){
				$tpl->set('[nacalosr]','');
				$tpl->set('[/nacalosr]','');
			} else 
				$tpl->set_block("'\\[nacalosr\\](.*?)\\[/nacalosr\\]'si","");
				
				$tpl->set('{konecsr}', $row['user_konecsr']);
			    if($row['user_konecsr']){
				$tpl->set('[konecsr]','');
				$tpl->set('[/konecsr]','');
			} else 
				$tpl->set_block("'\\[konecsr\\](.*?)\\[/konecsr\\]'si","");
				
				$tpl->set('{datasr}', $row['user_datasr']);
			    if($row['user_datasr']){
				$tpl->set('[datasr]','');
				$tpl->set('[/datasr]','');
			} else 
				$tpl->set_block("'\\[datasr\\](.*?)\\[/datasr\\]'si","");
				
				$tpl->set('{datasr}', $row['user_datasr']);
			    if($row['user_datasr']){
				$tpl->set('[datasr]','');
				$tpl->set('[/datasr]','');
			} else 
				$tpl->set_block("'\\[datasr\\](.*?)\\[/datasr\\]'si","");
				
				$user_klass = explode('|',$row['user_klass']);	
				if($row['user_klass']){
			    if($user_klass[0] == 1)
				$tpl->set('{klass}', '<a href="/?go=search&klass=1" onClick="Page.Go(this.href); return false">а</a>');
			    else if($user_klass[0] == 2)
				$tpl->set('{klass}', '<a href="/?go=search&klass=2" onClick="Page.Go(this.href); return false">б</a>');
				else if($user_klass[0] == 3)
				$tpl->set('{klass}', '<a href="/?go=search&klass=3" onClick="Page.Go(this.href); return false">в</a>');
				else if($user_klass[0] == 4)
				$tpl->set('{klass}', '<a href="/?go=search&klass=4" onClick="Page.Go(this.href); return false">г</a>');
				else if($user_klass[0] == 5)
				$tpl->set('{klass}', '<a href="/?go=search&klass=5" onClick="Page.Go(this.href); return false">д</a>');
				else if($user_klass[0] == 6)
				$tpl->set('{klass}', '<a href="/?go=search&klass=6" onClick="Page.Go(this.href); return false">е</a>');
				else if($user_klass[0] == 7)
				$tpl->set('{klass}', '<a href="/?go=search&klass=7" onClick="Page.Go(this.href); return false">ж</a>');
				else if($user_klass[0] == 8)
				$tpl->set('{klass}', '<a href="/?go=search&klass=8" onClick="Page.Go(this.href); return false">з</a>');
				else if($user_klass[0] == 9)
				$tpl->set('{klass}', '<a href="/?go=search&klass=9" onClick="Page.Go(this.href); return false">и</a>');
				else if($user_klass[0] == 10)
				$tpl->set('{klass}', '<a href="/?go=search&klass=10" onClick="Page.Go(this.href); return false">к</a>');
				else if($user_klass[0] == 11)
				$tpl->set('{klass}', '<a href="/?go=search&klass=11" onClick="Page.Go(this.href); return false">л</a>');
				else if($user_klass[0] == 12)
				$tpl->set('{klass}', '<a href="/?go=search&klass=12" onClick="Page.Go(this.href); return false">м</a>');
				else if($user_klass[0] == 13)
				$tpl->set('{klass}', '<a href="/?go=search&klass=13" onClick="Page.Go(this.href); return false">н</a>');
				else if($user_klass[0] == 14)
				$tpl->set('{klass}', '<a href="/?go=search&klass=14" onClick="Page.Go(this.href); return false">о</a>');
				else if($user_klass[0] == 15)
				$tpl->set('{klass}', '<a href="/?go=search&klass=15" onClick="Page.Go(this.href); return false">п</a>');
				else if($user_klass[0] == 16)
				$tpl->set('{klass}', '<a href="/?go=search&klass=16" onClick="Page.Go(this.href); return false">р</a>');
				else if($user_klass[0] == 17)
				$tpl->set('{klass}', '<a href="/?go=search&klass=17" onClick="Page.Go(this.href); return false">с</a>');
				else if($user_klass[0] == 18)
				$tpl->set('{klass}', '<a href="/?go=search&klass=18" onClick="Page.Go(this.href); return false">т</a>');
				else if($user_klass[0] == 19)
				$tpl->set('{klass}', '<a href="/?go=search&klass=19" onClick="Page.Go(this.href); return false">у</a>');
				else if($user_klass[0] == 20)
				$tpl->set('{klass}', '<a href="/?go=search&klass=20" onClick="Page.Go(this.href); return false">ф</a>');
				else if($user_klass[0] == 21)
				$tpl->set('{klass}', '<a href="/?go=search&klass=21" onClick="Page.Go(this.href); return false">х</a>');
				else if($user_klass[0] == 22)
				$tpl->set('{klass}', '<a href="/?go=search&klass=22" onClick="Page.Go(this.href); return false">ц</a>');
				else if($user_klass[0] == 23)
				$tpl->set('{klass}', '<a href="/?go=search&klass=23" onClick="Page.Go(this.href); return false">ч</a>');
				else if($user_klass[0] == 24)
				$tpl->set('{klass}', '<a href="/?go=search&klass=24" onClick="Page.Go(this.href); return false">ш</a>');
				else if($user_klass[0] == 25)
				$tpl->set('{klass}', '<a href="/?go=search&klass=25" onClick="Page.Go(this.href); return false">щ</a>');
				else if($user_klass[0] == 26)
				$tpl->set('{klass}', '<a href="/?go=search&klass=26" onClick="Page.Go(this.href); return false">ы</a>');
				else if($user_klass[0] == 27)
				$tpl->set('{klass}', '<a href="/?go=search&klass=27" onClick="Page.Go(this.href); return false">э</a>');
				else if($user_klass[0] == 28)
				$tpl->set('{klass}', '<a href="/?go=search&klass=28" onClick="Page.Go(this.href); return false">ю</a>');
				else if($user_klass[0] == 29)
				$tpl->set('{klass}', '<a href="/?go=search&klass=29" onClick="Page.Go(this.href); return false">я</a>');
				else if($user_klass[0] == 30)
				$tpl->set('{klass}', '<a href="/?go=search&klass=30" onClick="Page.Go(this.href); return false">а2</a>');
			    else if($user_klass[0] == 31)
				$tpl->set('{klass}', '<a href="/?go=search&klass=31" onClick="Page.Go(this.href); return false">б2</a>');
				else if($user_klass[0] == 32)
				$tpl->set('{klass}', '<a href="/?go=search&klass=32" onClick="Page.Go(this.href); return false">в2</a>');
				else if($user_klass[0] == 33)
				$tpl->set('{klass}', '<a href="/?go=search&klass=33" onClick="Page.Go(this.href); return false">г2</a>');
				else if($user_klass[0] == 34)
				$tpl->set('{klass}', '<a href="/?go=search&klass=34" onClick="Page.Go(this.href); return false">д2</a>');
				else if($user_klass[0] == 35)
				$tpl->set('{klass}', '<a href="/?go=search&klass=35" onClick="Page.Go(this.href); return false">е2</a>');
				else if($user_klass[0] == 36)
				$tpl->set('{klass}', '<a href="/?go=search&klass=36" onClick="Page.Go(this.href); return false">ж2</a>');
				else if($user_klass[0] == 37)
				$tpl->set('{klass}', '<a href="/?go=search&klass=37" onClick="Page.Go(this.href); return false">з2</a>');
				else if($user_klass[0] == 38)
				$tpl->set('{klass}', '<a href="/?go=search&klass=38" onClick="Page.Go(this.href); return false">и2</a>');
				else if($user_klass[0] == 39)
				$tpl->set('{klass}', '<a href="/?go=search&klass=39" onClick="Page.Go(this.href); return false">к2</a>');
				else if($user_klass[0] == 40)
				$tpl->set('{klass}', '<a href="/?go=search&klass=40" onClick="Page.Go(this.href); return false">л2</a>');
				else if($user_klass[0] == 41)
				$tpl->set('{klass}', '<a href="/?go=search&klass=41" onClick="Page.Go(this.href); return false">м2</a>');
				else if($user_klass[0] == 42)
				$tpl->set('{klass}', '<a href="/?go=search&klass=42" onClick="Page.Go(this.href); return false">н2</a>');
				else if($user_klass[0] == 43)
				$tpl->set('{klass}', '<a href="/?go=search&klass=43" onClick="Page.Go(this.href); return false">о2</a>');
				else if($user_klass[0] == 44)
				$tpl->set('{klass}', '<a href="/?go=search&klass=44" onClick="Page.Go(this.href); return false">п2</a>');
				else if($user_klass[0] == 45)
				$tpl->set('{klass}', '<a href="/?go=search&klass=45" onClick="Page.Go(this.href); return false">р2</a>');
				else if($user_klass[0] == 46)
				$tpl->set('{klass}', '<a href="/?go=search&klass=46" onClick="Page.Go(this.href); return false">с2</a>');
				else if($user_klass[0] == 47)
				$tpl->set('{klass}', '<a href="/?go=search&klass=47" onClick="Page.Go(this.href); return false">т2</a>');
				else if($user_klass[0] == 48)
				$tpl->set('{klass}', '<a href="/?go=search&klass=48" onClick="Page.Go(this.href); return false">у2</a>');
				else if($user_klass[0] == 49)
				$tpl->set('{klass}', '<a href="/?go=search&klass=49" onClick="Page.Go(this.href); return false">ф2</a>');
				else if($user_klass[0] == 50)
				$tpl->set('{klass}', '<a href="/?go=search&klass=50" onClick="Page.Go(this.href); return false">х2</a>');
				else if($user_klass[0] == 51)
				$tpl->set('{klass}', '<a href="/?go=search&klass=51" onClick="Page.Go(this.href); return false">ц2</a>');
				else if($user_klass[0] == 52)
				$tpl->set('{klass}', '<a href="/?go=search&klass=52" onClick="Page.Go(this.href); return false">ч2</a>');
				else if($user_klass[0] == 53)
				$tpl->set('{klass}', '<a href="/?go=search&klass=53" onClick="Page.Go(this.href); return false">ш2</a>');
				else if($user_klass[0] == 54)
				$tpl->set('{klass}', '<a href="/?go=search&klass=54" onClick="Page.Go(this.href); return false">щ2</a>');
				else if($user_klass[0] == 55)
				$tpl->set('{klass}', '<a href="/?go=search&klass=55" onClick="Page.Go(this.href); return false">ы2</a>');
				else if($user_klass[0] == 56)
				$tpl->set('{klass}', '<a href="/?go=search&klass=56" onClick="Page.Go(this.href); return false">э2</a>');
				else if($user_klass[0] == 57)
				$tpl->set('{klass}', '<a href="/?go=search&klass=57" onClick="Page.Go(this.href); return false">ю2</a>');
				else if($user_klass[0] == 58)
				$tpl->set('{klass}', '<a href="/?go=search&klass=58" onClick="Page.Go(this.href); return false">я2</a>');
				else if($user_klass[0] == 59)
				$tpl->set('{klass}', '<a href="/?go=search&klass=59" onClick="Page.Go(this.href); return false">а3</a>');
			    else if($user_klass[0] == 60)
				$tpl->set('{klass}', '<a href="/?go=search&klass=60" onClick="Page.Go(this.href); return false">б3</a>');
				else if($user_klass[0] == 61)
				$tpl->set('{klass}', '<a href="/?go=search&klass=61" onClick="Page.Go(this.href); return false">в3</a>');
				else if($user_klass[0] == 62)
				$tpl->set('{klass}', '<a href="/?go=search&klass=62" onClick="Page.Go(this.href); return false">г3</a>');
				else if($user_klass[0] == 63)
				$tpl->set('{klass}', '<a href="/?go=search&klass=63" onClick="Page.Go(this.href); return false">д3</a>');
				else if($user_klass[0] == 64)
				$tpl->set('{klass}', '<a href="/?go=search&klass=64" onClick="Page.Go(this.href); return false">е3</a>');
				else if($user_klass[0] == 65)
				$tpl->set('{klass}', '<a href="/?go=search&klass=65" onClick="Page.Go(this.href); return false">ж3</a>');
				else if($user_klass[0] == 66)
				$tpl->set('{klass}', '<a href="/?go=search&klass=66" onClick="Page.Go(this.href); return false">з3</a>');
				else if($user_klass[0] == 67)
				$tpl->set('{klass}', '<a href="/?go=search&klass=67" onClick="Page.Go(this.href); return false">и3</a>');
				else if($user_klass[0] == 68)
				$tpl->set('{klass}', '<a href="/?go=search&klass=68" onClick="Page.Go(this.href); return false">к3</a>');
				else if($user_klass[0] == 69)
				$tpl->set('{klass}', '<a href="/?go=search&klass=69" onClick="Page.Go(this.href); return false">л3</a>');
				else if($user_klass[0] == 70)
				$tpl->set('{klass}', '<a href="/?go=search&klass=70" onClick="Page.Go(this.href); return false">м3</a>');
				else if($user_klass[0] == 71)
				$tpl->set('{klass}', '<a href="/?go=search&klass=71" onClick="Page.Go(this.href); return false">н3</a>');
				else if($user_klass[0] == 72)
				$tpl->set('{klass}', '<a href="/?go=search&klass=72" onClick="Page.Go(this.href); return false">о3</a>');
				else if($user_klass[0] == 73)
				$tpl->set('{klass}', '<a href="/?go=search&klass=73" onClick="Page.Go(this.href); return false">п3</a>');
				else if($user_klass[0] == 74)
				$tpl->set('{klass}', '<a href="/?go=search&klass=74" onClick="Page.Go(this.href); return false">р3</a>');
				else if($user_klass[0] == 75)
				$tpl->set('{klass}', '<a href="/?go=search&klass=75" onClick="Page.Go(this.href); return false">с3</a>');
				else if($user_klass[0] == 76)
				$tpl->set('{klass}', '<a href="/?go=search&klass=76" onClick="Page.Go(this.href); return false">т3</a>');
				else if($user_klass[0] == 77)
				$tpl->set('{klass}', '<a href="/?go=search&klass=77" onClick="Page.Go(this.href); return false">у3</a>');
				else if($user_klass[0] == 78)
				$tpl->set('{klass}', '<a href="/?go=search&klass=78" onClick="Page.Go(this.href); return false">ф3</a>');
				else if($user_klass[0] == 79)
				$tpl->set('{klass}', '<a href="/?go=search&klass=79" onClick="Page.Go(this.href); return false">х3</a>');
				else if($user_klass[0] == 80)
				$tpl->set('{klass}', '<a href="/?go=search&klass=80" onClick="Page.Go(this.href); return false">ц3</a>');
				else if($user_klass[0] == 81)
				$tpl->set('{klass}', '<a href="/?go=search&klass=81" onClick="Page.Go(this.href); return false">ч3</a>');
				else if($user_klass[0] == 82)
				$tpl->set('{klass}', '<a href="/?go=search&klass=82" onClick="Page.Go(this.href); return false">ш3</a>');
				else if($user_klass[0] == 83)
				$tpl->set('{klass}', '<a href="/?go=search&klass=83" onClick="Page.Go(this.href); return false">щ3</a>');
				else if($user_klass[0] == 84)
				$tpl->set('{klass}', '<a href="/?go=search&klass=84" onClick="Page.Go(this.href); return false">ы3</a>');
				else if($user_klass[0] == 85)
				$tpl->set('{klass}', '<a href="/?go=search&klass=85" onClick="Page.Go(this.href); return false">э3</a>');
				else if($user_klass[0] == 86)
				$tpl->set('{klass}', '<a href="/?go=search&klass=86" onClick="Page.Go(this.href); return false">ю3</a>');
				else if($user_klass[0] == 87)
				$tpl->set('{klass}', '<a href="/?go=search&klass=87" onClick="Page.Go(this.href); return false">я3</a>');
				else if($user_klass[0] == 88)
				$tpl->set('{klass}', '<a href="/?go=search&klass=88" onClick="Page.Go(this.href); return false">1</a>');
				else if($user_klass[0] == 89)
				$tpl->set('{klass}', '<a href="/?go=search&klass=89" onClick="Page.Go(this.href); return false">2</a>');
				else if($user_klass[0] == 90)
				$tpl->set('{klass}', '<a href="/?go=search&klass=90" onClick="Page.Go(this.href); return false">3</a>');
				else if($user_klass[0] == 91)
				$tpl->set('{klass}', '<a href="/?go=search&klass=91" onClick="Page.Go(this.href); return false">4</a>');
				else if($user_klass[0] == 92)
				$tpl->set('{klass}', '<a href="/?go=search&klass=92" onClick="Page.Go(this.href); return false">5</a>');
				else if($user_klass[0] == 93)
				$tpl->set('{klass}', '<a href="/?go=search&klass=93" onClick="Page.Go(this.href); return false">6</a>');
				else if($user_klass[0] == 94)
				$tpl->set('{klass}', '<a href="/?go=search&klass=94" onClick="Page.Go(this.href); return false">7</a>');
				else if($user_klass[0] == 95)
				$tpl->set('{klass}', '<a href="/?go=search&klass=95" onClick="Page.Go(this.href); return false">8</a>');
				else if($user_klass[0] == 96)
				$tpl->set('{klass}', '<a href="/?go=search&klass=96" onClick="Page.Go(this.href); return false">9</a>');
				else if($user_klass[0] == 97)
				$tpl->set('{klass}', '<a href="/?go=search&klass=97" onClick="Page.Go(this.href); return false">10</a>');
				else if($user_klass[0] == 98)
				$tpl->set('{klass}', '<a href="/?go=search&klass=98" onClick="Page.Go(this.href); return false">11</a>');
				else if($user_klass[0] == 99)
				$tpl->set('{klass}', '<a href="/?go=search&klass=99" onClick="Page.Go(this.href); return false">12</a>');
				else if($user_klass[0] == 100)
				$tpl->set('{klass}', '<a href="/?go=search&klass=100" onClick="Page.Go(this.href); return false">13</a>');
				else if($user_klass[0] == 101)
				$tpl->set('{klass}', '<a href="/?go=search&klass=101" onClick="Page.Go(this.href); return false">14</a>');
				else if($user_klass[0] == 102)
				$tpl->set('{klass}', '<a href="/?go=search&klass=102" onClick="Page.Go(this.href); return false">15</a>');
				$tpl->set('[klass]','');
				$tpl->set('[/klass]','');
				}
				else 
				$tpl->set_block("'\\[klass\\](.*?)\\[/klass\\]'si","");
				
				$tpl->set('{spec}', $row['user_spec']);
			    if($row['user_spec']){
				$tpl->set('[spec]','');
				$tpl->set('[/spec]','');
			} else 
				$tpl->set_block("'\\[spec\\](.*?)\\[/spec\\]'si","");
				
				$tpl->set('[/education]','');
			} else 
				$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
				
			
				
				//Высшее образование
			if($row['user_countryvi'] OR $row['user_cityvi'] OR $row['user_vuz'] OR $row['user_fac'] OR $row['user_form'] OR $row['user_statusvi'] OR $row['user_datavi']){
			$tpl->set('[higher_education]','');
					
			$tpl->set('{countryvi}', $user_country_city_namevi_exp[0]);
			$tpl->set('{cityvi}', $user_country_city_namevi_exp[1]);
				
			if($row['user_cityvi'] AND $row['user_countryvi']){
				$tpl->set('[cityvi]','');
				$tpl->set('[/cityvi]','');
			} else 
				$tpl->set_block("'\\[cityvi\\](.*?)\\[/cityvi\\]'si","");
				
			if($row['user_countryvi']){
				$tpl->set('[countryvi]','');
				$tpl->set('[/countryvi]','');
			} else 
				$tpl->set_block("'\\[countryvi\\](.*?)\\[/countryvi\\]'si","");
				
				$tpl->set('{vuz}', $row['user_vuz']);
			    if($row['user_vuz']){
				$tpl->set('[vuz]','');
				$tpl->set('[/vuz]','');
			} else 
				$tpl->set_block("'\\[vuz\\](.*?)\\[/vuz\\]'si","");
				
				$tpl->set('{fac}', $row['user_fac']);
			    if($row['user_fac']){
				$tpl->set('[fac]','');
				$tpl->set('[/fac]','');
			} else 
				$tpl->set_block("'\\[fac\\](.*?)\\[/fac\\]'si","");
				
				$user_form = explode('|',$row['user_form']);	
				if($row['user_form']){
			    if($user_form[0] == 1)
				$tpl->set('{form}', '<a href="/?go=search&form=1" onClick="Page.Go(this.href); return false">Дневная</a>');
			    else if($user_form[0] == 2)
				$tpl->set('{form}', '<a href="/?go=search&form=2" onClick="Page.Go(this.href); return false">Вечерняя</a>');
				else if($user_form[0] == 3)
				$tpl->set('{form}', '<a href="/?go=search&form=3" onClick="Page.Go(this.href); return false">Заочная</a>');
				$tpl->set('[form]','');
				$tpl->set('[/form]','');
				}
				else 
				$tpl->set_block("'\\[form\\](.*?)\\[/form\\]'si","");
				
				$user_statusvi = explode('|',$row['user_statusvi']);	
				if($row['user_statusvi']){
			    if($user_statusvi[0] == 1)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=1" onClick="Page.Go(this.href); return false">Абитуриент</a>');
			    else if($user_statusvi[0] == 2)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=2" onClick="Page.Go(this.href); return false">Студент(специалист)</a>');
				else if($user_statusvi[0] == 3)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=3" onClick="Page.Go(this.href); return false">Студент(бакалавр)</a>');
				else if($user_statusvi[0] == 4)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=4" onClick="Page.Go(this.href); return false">Студент(магистр)</a>');
				else if($user_statusvi[0] == 5)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=5" onClick="Page.Go(this.href); return false">Выпускник(специалист)</a>');
				else if($user_statusvi[0] == 6)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=6" onClick="Page.Go(this.href); return false">Выпускник(бакалавр)</a>');
				else if($user_statusvi[0] == 7)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=7" onClick="Page.Go(this.href); return false">Выпускник(магистр)</a>');
				else if($user_statusvi[0] == 8)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=8" onClick="Page.Go(this.href); return false">Аспирант</a>');
				else if($user_statusvi[0] == 9)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=9" onClick="Page.Go(this.href); return false">Кандидат наук</a>');
				else if($user_statusvi[0] == 10)
				$tpl->set('{statusvi}', '<a href="/?go=search&statusvi=10" onClick="Page.Go(this.href); return false">Доктор наук</a>');
				$tpl->set('[statusvi]','');
				$tpl->set('[/statusvi]','');
				}
				else 
				$tpl->set_block("'\\[statusvi\\](.*?)\\[/statusvi\\]'si","");
				
				
				
				$tpl->set('{datavi}', $row['user_datavi']);
			    if($row['user_datavi']){
				$tpl->set('[datavi]','');
				$tpl->set('[/datavi]','');
			} else 
				$tpl->set_block("'\\[datavi\\](.*?)\\[/datavi\\]'si","");
				$tpl->set('[/higher_education]','');
			} else 
				$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
				
			//Карьера
			if($row['user_countryca'] OR $row['user_cityca'] OR $row['user_mesto'] OR $row['user_nacaloca'] OR $row['user_konecca'] OR $row['user_dolj']){
			$tpl->set('[career]','');
			$tpl->set('{countryca}', $user_country_city_nameca_exp[0]);
			$tpl->set('{cityca}', $user_country_city_nameca_exp[1]);
			if($row['user_cityca'] AND $row['user_countryca']){
				$tpl->set('[cityca]','');
				$tpl->set('[/cityca]','');
			} else 
				$tpl->set_block("'\\[cityca\\](.*?)\\[/cityca\\]'si","");
				
			if($row['user_countryca']){
				$tpl->set('[countryca]','');
				$tpl->set('[/countryca]','');
			} else 
				$tpl->set_block("'\\[countryca\\](.*?)\\[/countryca\\]'si","");
				
				$tpl->set('{mesto}', $row['user_mesto']);
			    if($row['user_mesto']){
				$tpl->set('[mesto]','');
				$tpl->set('[/mesto]','');
			} else 
				$tpl->set_block("'\\[mesto\\](.*?)\\[/mesto\\]'si","");
				
				$tpl->set('{nacaloca}', $row['user_nacaloca']);
			    if($row['user_nacaloca']){
				$tpl->set('[nacaloca]','');
				$tpl->set('[/nacaloca]','');
			} else 
				$tpl->set_block("'\\[nacaloca\\](.*?)\\[/nacaloca\\]'si","");
				
				$tpl->set('{konecca}', $row['user_konecca']);
			    if($row['user_konecca']){
				$tpl->set('[konecca]','');
				$tpl->set('[/konecca]','');
			} else 
				$tpl->set_block("'\\[konecca\\](.*?)\\[/konecca\\]'si","");
				
				$tpl->set('{dolj}', $row['user_dolj']);
			    if($row['user_dolj']){
				$tpl->set('[dolj]','');
				$tpl->set('[/dolj]','');
			} else 
				$tpl->set_block("'\\[dolj\\](.*?)\\[/dolj\\]'si","");
				$tpl->set('[/career]','');
			} else 
				$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
				
			//Военная служба
			if($row['user_countrysl'] OR $row['user_citysl'] OR $row['user_chast'] OR $row['user_zvanie'] OR $row['user_nacalosl'] OR $row['user_konecsl']){
			$tpl->set('[military]','');
			$tpl->set('{countrysl}', $user_country_city_namesl_exp[0]);
			$tpl->set('{citysl}', $user_country_city_namesl_exp[1]);
			
			if($row['user_citysl'] AND $row['user_countrysl']){
				$tpl->set('[citysl]','');
				$tpl->set('[/citysl]','');
			} else 
				$tpl->set_block("'\\[citysl\\](.*?)\\[/citysl\\]'si","");
				
			if($row['user_countrysl']){
				$tpl->set('[countrysl]','');
				$tpl->set('[/countrysl]','');
			} else 
				$tpl->set_block("'\\[countrysl\\](.*?)\\[/countrysl\\]'si","");
				
				$tpl->set('{chast}', $row['user_chast']);
			    if($row['user_chast']){
				$tpl->set('[chast]','');
				$tpl->set('[/chast]','');
			} else 
				$tpl->set_block("'\\[chast\\](.*?)\\[/chast\\]'si","");
				
				$tpl->set('{zvanie}', $row['user_zvanie']);
			    if($row['user_zvanie']){
				$tpl->set('[zvanie]','');
				$tpl->set('[/zvanie]','');
			} else 
				$tpl->set_block("'\\[zvanie\\](.*?)\\[/zvanie\\]'si","");
				
				$tpl->set('{nacalosl}', $row['user_nacalosl']);
			    if($row['user_nacalosl']){
				$tpl->set('[nacalosl]','');
				$tpl->set('[/nacalosl]','');
			} else 
				$tpl->set_block("'\\[nacalosl\\](.*?)\\[/nacalosl\\]'si","");
				
				$tpl->set('{konecsl}', $row['user_konecsl']);
			    if($row['user_konecsl']){
				$tpl->set('[konecsl]','');
				$tpl->set('[/konecsl]','');
			} else 
				$tpl->set_block("'\\[konecsl\\](.*?)\\[/konecsl\\]'si","");
				$tpl->set('[/military]','');
			} else 
				$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
				
			
			//Жизненные позиции
			 if($row['user_pred'] OR $row['user_miro'] OR $row['user_jizn'] OR $row['user_ludi'] OR $row['user_kurenie'] OR $row['user_alkogol'] OR $row['user_narkotiki'] OR $row['user_vdox']){
			$tpl->set('[personal]','');
		
			    $user_pred = explode('|',$row['user_pred']);	
				if($row['user_pred']){
			    if($user_pred[0] == 1)
				$tpl->set('{pred}', '<a href="/?go=search&pred=1" onClick="Page.Go(this.href); return false">Индифферентные</a>');
			    else if($user_pred[0] == 2)
				$tpl->set('{pred}', '<a href="/?go=search&pred=2" onClick="Page.Go(this.href); return false">Коммунистические</a>');
				else if($user_pred[0] == 3)
				$tpl->set('{pred}', '<a href="/?go=search&pred=3" onClick="Page.Go(this.href); return false">Социалистические</a>');
				else if($user_pred[0] == 4)
				$tpl->set('{pred}', '<a href="/?go=search&pred=4" onClick="Page.Go(this.href); return false">Умеренные</a>');
				else if($user_pred[0] == 5)
				$tpl->set('{pred}', '<a href="/?go=search&pred=5" onClick="Page.Go(this.href); return false">Либеральные</a>');
				else if($user_pred[0] == 6)
				$tpl->set('{pred}', '<a href="/?go=search&pred=6" onClick="Page.Go(this.href); return false">Консервативные</a>');
				else if($user_pred[0] == 7)
				$tpl->set('{pred}', '<a href="/?go=search&pred=7" onClick="Page.Go(this.href); return false">Монархические</a>');
				else if($user_pred[0] == 8)
				$tpl->set('{pred}', '<a href="/?go=search&pred=8" onClick="Page.Go(this.href); return false">Ультраконсервативные</a>');
				else if($user_pred[0] == 9)
				$tpl->set('{pred}', '<a href="/?go=search&pred=9" onClick="Page.Go(this.href); return false">Либертарические</a>');
				$tpl->set('[pred]','');
				$tpl->set('[/pred]','');
				}
				else 
				$tpl->set_block("'\\[pred\\](.*?)\\[/pred\\]'si","");
				
				$tpl->set('{miro}', $row['user_miro']);
			    if($row['user_miro']){
				$tpl->set('[miro]','');
				$tpl->set('[/miro]','');
			} else 
				$tpl->set_block("'\\[miro\\](.*?)\\[/miro\\]'si","");
				
				$user_jizn = explode('|', $row['user_jizn']);	
				if($row['user_jizn']){
			    if($user_jizn[0] == 1)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=1" onClick="Page.Go(this.href); return false">Семья и дети</a>');
			    else if($user_jizn[0] == 2)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=2" onClick="Page.Go(this.href); return false">Карьера и дети</a>');
				else if($user_jizn[0] == 3)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=3" onClick="Page.Go(this.href); return false">Развлечения и отдых</a>');
				else if($user_jizn[0] == 4)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=4" onClick="Page.Go(this.href); return false">Наука и исследование</a>');
				else if($user_jizn[0] == 5)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=5" onClick="Page.Go(this.href); return false">Совершенствование мира</a>');
				else if($user_jizn[0] == 6)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=6" onClick="Page.Go(this.href); return false">Саморазвитие</a>');
				else if($user_pred[0] == 7)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=7" onClick="Page.Go(this.href); return false">Красота и искуство</a>');
				else if($user_pred[0] == 8)
				$tpl->set('{jizn}', '<a href="/?go=search&jizn=8" onClick="Page.Go(this.href); return false">Слава и влияние</a>');
			    $tpl->set('[jizn]','');
				$tpl->set('[/jizn]','');
				}
				else 
				$tpl->set_block("'\\[jizn\\](.*?)\\[/jizn\\]'si","");
				
				$user_ludi = explode('|', $row['user_ludi']);	
				if($row['user_ludi']){
			    if($user_ludi[0] == 1)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=1" onClick="Page.Go(this.href); return false">Ум и креативность</a>');
			    else if($user_ludi[0] == 2)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=2" onClick="Page.Go(this.href); return false">Доброта и честность</a>');
				else if($user_ludi[0] == 3)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=3" onClick="Page.Go(this.href); return false">Красота и здоровье</a>');
				else if($user_ludi[0] == 4)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=4" onClick="Page.Go(this.href); return false">Власть и богатство</a>');
				else if($user_ludi[0] == 5)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=5" onClick="Page.Go(this.href); return false">Смелость и упорство</a>');
				else if($user_ludi[0] == 6)
				$tpl->set('{ludi}', '<a href="/?go=search&ludi=5" onClick="Page.Go(this.href); return false">Юмор и жизнелюбие</a>');
			    $tpl->set('[ludi]','');
				$tpl->set('[/ludi]','');
				}
				else 
				$tpl->set_block("'\\[ludi\\](.*?)\\[/ludi\\]'si","");
				
				$user_kurenie = explode('|', $row['user_kurenie']);	
				if($row['user_kurenie']){
			    if($user_kurenie[0] == 1)
				$tpl->set('{kurenie}', '<a href="/?go=search&kurenie=1" onClick="Page.Go(this.href); return false">Резко негативное</a>');
			    else if($user_kurenie[0] == 2)
				$tpl->set('{kurenie}', '<a href="/?go=search&kurenie=2" onClick="Page.Go(this.href); return false">Негативное</a>');
				else if($user_kurenie[0] == 3)
				$tpl->set('{kurenie}', '<a href="/?go=search&kurenie=3" onClick="Page.Go(this.href); return false">Компромиссное</a>');
				else if($user_kurenie[0] == 4)
				$tpl->set('{kurenie}', '<a href="/?go=search&kurenie=4" onClick="Page.Go(this.href); return false">Нейтральное</a>');
				else if($user_kurenie[0] == 5)
				$tpl->set('{kurenie}', '<a href="/?go=search&kurenie=5" onClick="Page.Go(this.href); return false">Положительное</a>');
			    $tpl->set('[kurenie]','');
				$tpl->set('[/kurenie]','');
				}
				else 
				$tpl->set_block("'\\[kurenie\\](.*?)\\[/kurenie\\]'si","");
				
				$user_alkogol = explode('|', $row['user_alkogol']);	
				if($row['user_alkogol']){
			    if($user_alkogol[0] == 1)
				$tpl->set('{alkogol}', '<a href="/?go=search&alkogol=1" onClick="Page.Go(this.href); return false">Резко негативное</a>');
			    else if($user_alkogol[0] == 2)
				$tpl->set('{alkogol}', '<a href="/?go=search&alkogol=2" onClick="Page.Go(this.href); return false">Негативное</a>');
				else if($user_alkogol[0] == 3)
				$tpl->set('{alkogol}', '<a href="/?go=search&alkogol=3" onClick="Page.Go(this.href); return false">Компромиссное</a>');
				else if($user_alkogol[0] == 4)
				$tpl->set('{alkogol}', '<a href="/?go=search&alkogol=4" onClick="Page.Go(this.href); return false">Нейтральное</a>');
				else if($user_alkogol[0] == 5)
				$tpl->set('{alkogol}', '<a href="/?go=search&alkogol=5" onClick="Page.Go(this.href); return false">Положительное</a>');
			    $tpl->set('[alkogol]','');
				$tpl->set('[/alkogol]','');
				}
				else 
				$tpl->set_block("'\\[alkogol\\](.*?)\\[/alkogol\\]'si","");
				
				$user_narkotiki = explode('|', $row['user_narkotiki']);	
				if($row['user_narkotiki']){
			    if($user_narkotiki[0] == 1)
				$tpl->set('{narkotiki}', '<a href="/?go=search&narkotiki=1" onClick="Page.Go(this.href); return false">Резко негативное</a>');
			    else if($user_narkotiki[0] == 2)
				$tpl->set('{narkotiki}', '<a href="/?go=search&narkotiki=2" onClick="Page.Go(this.href); return false">Негативное</a>');
				else if($user_narkotiki[0] == 3)
				$tpl->set('{narkotiki}', '<a href="/?go=search&narkotiki=3" onClick="Page.Go(this.href); return false">Компромиссное</a>');
				else if($user_narkotiki[0] == 4)
				$tpl->set('{narkotiki}', '<a href="/?go=search&narkotiki=4" onClick="Page.Go(this.href); return false">Нейтральное</a>');
				else if($user_narkotiki[0] == 5)
				$tpl->set('{narkotiki}', '<a href="/?go=search&narkotiki=5" onClick="Page.Go(this.href); return false">Положительное</a>');
			    $tpl->set('[narkotiki]','');
				$tpl->set('[/narkotiki]','');
				}
				else 
				$tpl->set_block("'\\[narkotiki\\](.*?)\\[/narkotiki\\]'si","");
				
				$user_vdox = explode('|', $row['user_vdox']);
if($row['user_vdox']){
$tpl->set('{vdox}', '<a href="/?go=search&vdox='.$row['user_vdox'].'" onclick="Page.Go(this.href); return false">'.($row['user_vdox']).'</a>');
$tpl->set('[vdox]','');
$tpl->set('[/vdox]','');
} else
$tpl->set_block("'\[vdox\](.*?)\[/vdox\]'si","");
				$tpl->set('[/personal]','');
			} else 
				$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
				
				$tpl->set('{name}', $user_name_lastname_exp[0]);
			$tpl->set('{lastname}', $user_name_lastname_exp[1]);
			
			//День рождение
            
			    if($row['user_lastname']){
				$tpl->set('[lastname]','');
				$tpl->set('[/lastname]','');
			} else 
				$tpl->set_block("'\\[lastname\\](.*?)\\[/lastname\\]'si","");
				
				if($row['user_sex']== 2){
				$tpl->set('{dev}', $row['user_dev']);
			    if($row['user_dev']){
				$tpl->set('[dev]','');
				$tpl->set('[/dev]','');
			} else 
				$tpl->set_block("'\\[dev\\](.*?)\\[/dev\\]'si","");
				} else 
				$tpl->set_block("'\\[dev\\](.*?)\\[/dev\\]'si","");
				
			
			    if($row['user_name']){
				$tpl->set('[name]','');
				$tpl->set('[/name]','');
			} else 
				$tpl->set_block("'\\[name\\](.*?)\\[/name\\]'si","");
				
				$tpl->set('{otcestvo}', $row['user_otcestvo']);
			    if($row['user_otcestvo']){
				$tpl->set('[otcestvo]','');
				$tpl->set('[/otcestvo]','');
			} else 
				$tpl->set_block("'\\[otcestvo\\](.*?)\\[/otcestvo\\]'si","");
				
				$tpl->set('{hometown}', $row['user_hometown']);
			    if($row['user_hometown']){
				$tpl->set('[hometown]','');
				$tpl->set('[/hometown]','');
			} else 
				$tpl->set_block("'\\[hometown\\](.*?)\\[/hometown\\]'si","");
				
				$tpl->set('{grandparents}', $row['user_grandparents']);
			    if($row['user_grandparents']){
				$tpl->set('[grandparents]','');
				$tpl->set('[/grandparents]','');
			} else 
				$tpl->set_block("'\\[grandparents\\](.*?)\\[/grandparents\\]'si","");
				
				$tpl->set('{parents}', $row['user_parents']);
			    if($row['user_parents']){
				$tpl->set('[parents]','');
				$tpl->set('[/parents]','');
			} else 
				$tpl->set_block("'\\[parents\\](.*?)\\[/parents\\]'si","");
				
				$tpl->set('{siblings}', $row['user_siblings']);
			    if($row['user_siblings']){
				$tpl->set('[siblings]','');
				$tpl->set('[/siblings]','');
			} else 
				$tpl->set_block("'\\[siblings\\](.*?)\\[/siblings\\]'si","");
				
			$tpl->set('{children}', $row['user_children']);
			    if($row['user_children']){
				$tpl->set('[children]','');
				$tpl->set('[/children]','');
			} else 
				$tpl->set_block("'\\[children\\](.*?)\\[/children\\]'si","");
				
			$tpl->set('{grandchildren}', $row['user_grandchildren']);
			    if($row['user_grandchildren']){
				$tpl->set('[grandchildren]','');
				$tpl->set('[/grandchildren]','');
			} else 
				$tpl->set_block("'\\[grandchildren\\](.*?)\\[/grandchildren\\]'si","");
			
			
			$user_birthday = explode('-', $row['user_birthday']);
			$row['user_day'] = $user_birthday[2];
			$row['user_month'] = $user_birthday[1];
			$row['user_year'] = $user_birthday[0];
			
			if($row['user_day'] > 0 && $row['user_day'] <= 31 && $row['user_month'] > 0 && $row['user_month'] < 13 && $user_birthday[3]!=3){
				$tpl->set('[not-all-birthday]', '');
				$tpl->set('[/not-all-birthday]', '');
				
				if($row['user_day'] && $row['user_month'] && $row['user_year'] > 1929 && $row['user_year'] < 2012 && $user_birthday[3]!=2)
					$tpl->set('{birth-day}', '<a href="/?go=search&day='.$row['user_day'].'&month='.$row['user_month'].'&year='.$row['user_year'].'" onClick="Page.Go(this.href); return false">'.langdate('j F Y', strtotime($row['user_year'].'-'.$row['user_month'].'-'.$row['user_day'])).' г.</a>');
				else if($user_birthday[3]!=2)
					$tpl->set('{birth-day}', '<a href="/?go=search&day='.$row['user_day'].'&month='.$row['user_month'].'" onClick="Page.Go(this.href); return false">'.langdate('j F', strtotime($row['user_year'].'-'.$row['user_month'].'-'.$row['user_day'])).'</a>');
				else
					$tpl->set('{birth-day}', '<a href="/?go=search&day='.$row['user_day'].'&month='.$row['user_month'].'" onClick="Page.Go(this.href); return false">'.langdate('j F', strtotime($row['user_year'].'-'.$row['user_month'].'-'.$row['user_day'])).'</a>');
			} else {
				$tpl->set_block("'\\[not-all-birthday\\](.*?)\\[/not-all-birthday\\]'si","");
			}
			
			//Знаки зодиака
                $month = $user_birthday[1];
                $day = $user_birthday[2];
                                 function getZodiacalSign($month, $day) {
                 
                 
                 
                    $signs = array("Козерог", "Водолей", "Рыбы", "Овен", "Телец", "Близнецы", "Рак", "Лев", "Девы", "Весы", "Скорпион", "Стрелец");
                    $signsstart = array(1=>20, 2=>19, 3=>20, 4=>20, 5=>20, 6=>21, 7=>22, 8=>23, 9=>23, 10=>23, 11=>23, 12=>23);
                    return $day < $signsstart[$month] ? $signs[$month - 1] : $signs[$month % 12];
                    }
 
                    $zodiak =  getZodiacalSign($month, $day);
                    $tpl->set('{zodiak}', $zodiak);
			
			//Показ скрытых текста только для владельца страницы
			if($user_info['user_id'] == $row['user_id']){
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
				$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
			} else {
				$tpl->set('[not-owner]', '');
				$tpl->set('[/not-owner]', '');
				$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
			}
			
				// FOR MOBILE VERSION 1.0
			if($config['temp'] == 'mobile'){
									
				$avaPREFver = '50_';
				$noAvaPrf = 'no_ava_50.png';
								
			} else {
								
				$avaPREFver = '';
				$noAvaPrf = 'no_ava.gif';
								
			}
					
			//Аватарка
			if($row['user_photo']){
				$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/'.$avaPREFver.$row['user_photo']);
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava}', '/templates/Default/images/'.$noAvaPrf);
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
			
			 //################### Фотографии ################//
   $photo_cnt = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_photos` WHERE user_id = '{$id}' ", false);
   if ($photo_cnt['cnt']){
    $sql_photos_view = $db->super_query("SELECT * FROM `".PREFIX."_photos` WHERE user_id = '{$id}' ORDER BY id DESC LIMIT 4",1);
    if($sql_photos_view){
     foreach($sql_photos_view as $row_view_photos)
     {
      $photos_view_albums .= "<a onclick=\"Photo.Show(this.href); return false\" href=\"/photo{$row_view_photos['user_id']}_{$row_view_photos['id']}_{$row_view_photos['album_id']}\"><img style=\"margin-right:9px;\" src=\"/uploads/users/{$row_view_photos['user_id']}/albums/{$row_view_photos['album_id']}/c_{$row_view_photos['photo_name']}\" width=\"109\" ></a>";
     }
    } else {
     $photos_view_albums = '<br><div class="info_center">Нет загруженных фотографий.</div>';
    }
    $tpl->set('{photos_view_albums}', $photos_view_albums); 
    $tpl->set('[photos]', '');
    $tpl->set('[/photos]', '');
    $tpl->set('{photos_num}', $photo_cnt['cnt']);    
   }else
    $tpl->set_block("'\\[photos\\](.*?)\\[/photos\\]'si","");
			
			
			//Значок
   $znachok = $row['user_znachok'];
   $rowznachok = $db->super_query("SELECT id, img FROM `".PREFIX."_znachok_list` WHERE id = '{$znachok}'");
   if($row['user_znachok'] == 0){
   $tpl->set('{user_znachok}', '');
   } else {
   $tpl->set('{user_znachok}', '<img src="../uploads/znachok/'.$rowznachok['img'].'.png">');
   }
			
			//################### Альбомы ###################//
			if($user_id == $id){
				$albums_privacy = false;
				$albums_count['cnt'] = $row['user_albums_num'];
			} else if($check_friend){
				$albums_privacy = "AND SUBSTRING(privacy, 1, 1) regexp '[[:<:]](1|2)[[:>:]]'";
				$albums_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_albums` WHERE user_id = '{$id}' {$albums_privacy}", false, "user_{$id}/albums_cnt_friends");
				$cache_pref = "_friends";
			} else {
				$albums_privacy = "AND SUBSTRING(privacy, 1, 1) = 1";
				$albums_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_albums` WHERE user_id = '{$id}' {$albums_privacy}", false, "user_{$id}/albums_cnt_all");
				$cache_pref = "_all";
			}
			$sql_albums = $db->super_query("SELECT aid, name, adate, photo_num, cover FROM `".PREFIX."_albums` WHERE user_id = '{$id}' {$albums_privacy} ORDER by `position` ASC LIMIT 0, 2", 1, "user_{$id}/albums{$cache_pref}");
			if($sql_albums){
				foreach($sql_albums as $row_albums){
					$row_albums['name'] = stripslashes($row_albums['name']);
					$album_date = megaDateNoTpl(strtotime($row_albums['adate']));
					$albums_photonums = gram_record($row_albums['photo_num'], 'photos');
					if($row_albums['cover'])
						$album_cover = "/uploads/users/{$id}/albums/{$row_albums['aid']}/c_{$row_albums['cover']}";
					else
						$album_cover = '{theme}/images/no_cover.png';
					$albums .= "<a href=\"/albums/view/{$row_albums['aid']}\" onClick=\"Page.Go(this.href); return false\" style=\"text-decoration:none\"><span><div class=\"photo\" data-title=\"{$row_albums['name']} {$row_albums['photo_num']}.{$albums_photonums}\"><img src=\"{$album_cover}\" width=\"175\" height=\"115\" /></span><div class=\"clear\"></div></div></a>"; 
				}
			}
			$tpl->set('{albums}', $albums);
			$tpl->set('{albums-num}', $albums_count['cnt']);
			if($albums_count['cnt'] AND $config['album_mod'] == 'yes'){
				$tpl->set('[albums]', '');
				$tpl->set('[/albums]', '');
			} else
				$tpl->set_block("'\\[albums\\](.*?)\\[/albums\\]'si","");
				
			//Делаем проверки на существования запрашиваемого юзера у себя в друзьяз, заклаках, в подписка, делаем всё это если страницу смотрет другой человек
			if($user_id != $id){
			
				//Проверка естьли запрашиваемый юзер в друзьях у юзера который смотрит стр
				if($check_friend){
					$tpl->set('[yes-friends]', '');
					$tpl->set('[/yes-friends]', '');
					$tpl->set_block("'\\[no-friends\\](.*?)\\[/no-friends\\]'si","");
				} else {
					$tpl->set('[no-friends]', '');
					$tpl->set('[/no-friends]', '');
					$tpl->set_block("'\\[yes-friends\\](.*?)\\[/yes-friends\\]'si","");
				}
				
				//Проверка естьли запрашиваемый юзер в закладках у юзера который смотрит стр
				$check_fave = $db->super_query("SELECT user_id FROM `".PREFIX."_fave` WHERE user_id = '{$user_info['user_id']}' AND fave_id = '{$id}'");
				if($check_fave){
					$tpl->set('[yes-fave]', '');
					$tpl->set('[/yes-fave]', '');
					$tpl->set_block("'\\[no-fave\\](.*?)\\[/no-fave\\]'si","");
				} else {
					$tpl->set('[no-fave]', '');
					$tpl->set('[/no-fave]', '');
					$tpl->set_block("'\\[yes-fave\\](.*?)\\[/yes-fave\\]'si","");
				}

				//Проверка естьли запрашиваемый юзер в подписках у юзера который смотрит стр
				$check_subscr = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_info['user_id']}' AND friend_id = '{$id}' AND subscriptions = 1");
				if($check_subscr){
					$tpl->set('[yes-subscription]', '');
					$tpl->set('[/yes-subscription]', '');
					$tpl->set_block("'\\[no-subscription\\](.*?)\\[/no-subscription\\]'si","");
				} else {
					$tpl->set('[no-subscription]', '');
					$tpl->set('[/no-subscription]', '');
					$tpl->set_block("'\\[yes-subscription\\](.*?)\\[/yes-subscription\\]'si","");
				}
				
				//Проверка естьли запрашиваемый юзер в черном списке
				$MyCheckBlackList = MyCheckBlackList($id);
				if($MyCheckBlackList){
					$tpl->set('[yes-blacklist]', '');
					$tpl->set('[/yes-blacklist]', '');
					$tpl->set_block("'\\[no-blacklist\\](.*?)\\[/no-blacklist\\]'si","");
				} else {
					$tpl->set('[no-blacklist]', '');
					$tpl->set('[/no-blacklist]', '');
					$tpl->set_block("'\\[yes-blacklist\\](.*?)\\[/yes-blacklist\\]'si","");
				}
				
			}

			$author_info = explode(' ', $row['user_search_pref']);
			$tpl->set('{gram-name}', gramatikName($author_info[0]));
			
			$tpl->set('{gram-name}', gramatikName($author_info[0])); 
 
                $guests_num = count(array_unique(explode('|',$row['user_guests']))) - 1; 
            $tpl->set('{guests-num}', $guests_num);
			$tpl->set('{friends-num}', $row['user_friends_num'].' '.gram_record($row['user_friends_num'], 'friends'));
			$tpl->set('{sub_nom}', $row['subscriptions_num']);
			$tpl->set('{gifts-top}', $row['user_gifts']);
			$tpl->set('{online-friends-num}', $online_friends['cnt'].' '.gram_record($online_friends['cnt'], 'friends_online'));
			$tpl->set('{notes-num}', $row['user_notes_num'].' '.gram_record($row['user_notes_num'], 'notes'));
			$tpl->set('{subscriptions-num}', $row['user_subscriptions_num'].' '.gram_record($row['user_subscriptions_num'], 'subscriptions-num'));
			$tpl->set('{subsc-num}', $row['user_subscriptions_num']);
			$tpl->set('{videos-num}', $row['user_videos_num'].' '.gram_record($row['user_videos_num'], 'videos'));
			
			//Если есть заметки то выводим
			if($row['user_notes_num']){
				$tpl->set('[notes]', '');
				$tpl->set('[/notes]', '');
				$tpl->set('{notes}', $tpl->result['notes']);
			} else
				$tpl->set_block("'\\[notes\\](.*?)\\[/notes\\]'si","");

			//Если есть видео то выводим
			if($row['user_videos_num'] AND $config['video_mod'] == 'yes'){
				$tpl->set('[videos]', '');
				$tpl->set('[/videos]', '');
				$tpl->set('{videos}', $tpl->result['videos']);
			} else
				$tpl->set_block("'\\[videos\\](.*?)\\[/videos\\]'si","");

			//Если есть друзья, то выводим
			if($row['user_friends_num']){
				$tpl->set('[friends]', '');
				$tpl->set('[/friends]', '');
				$tpl->set('{friends}', $tpl->result['all_friends']);
			} else
				$tpl->set_block("'\\[friends\\](.*?)\\[/friends\\]'si","");
				$tpl->set('{gr-friends}', $tpl->result['gr_friends']);
				
				//Если есть гости, то выводим 
            if($guests_num){ 
                $tpl->set('[guests]', ''); 
                $tpl->set('[/guests]', ''); 
                $tpl->set('{guests}', $tpl->result['all_guests_friends']); 
            } else 
                $tpl->set_block("'\\[guests\\](.*?)\\[/guests\\]'si","");
				
			//Кол-во подписок и Если есть друзья, то выводим
			if($row['user_subscriptions_num']){
				$tpl->set('[subscriptions]', '');
				$tpl->set('[/subscriptions]', '');
				$tpl->set('{subscriptions}', $tpl->result['subscriptions']);
			} else
				$tpl->set_block("'\\[subscriptions\\](.*?)\\[/subscriptions\\]'si","");
				
			//Если есть друзья на сайте, то выводим
			if($online_friends['cnt']){
				$tpl->set('[online-friends]', '');
				$tpl->set('[/online-friends]', '');
				$tpl->set('{online-friends}', $tpl->result['all_online_friends']);
			} else
				$tpl->set_block("'\\[online-friends\\](.*?)\\[/online-friends\\]'si","");
			
			//Если человек пришел после реги, то открываем ему окно загрузи фотографии
			if(intval($_GET['after'])){
				$tpl->set('[after-reg]', '');
				$tpl->set('[/after-reg]', '');
			} else
				$tpl->set_block("'\\[after-reg\\](.*?)\\[/after-reg\\]'si","");

			//Стена
			$tpl->set('{records}', $tpl->result['wall']);

			if($user_id != $id){
				if($user_privacy['val_wall1'] == 3 OR $user_privacy['val_wall1'] == 2 AND !$check_friend){
					$cnt_rec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE for_user_id = '{$id}' AND author_user_id = '{$id}' AND fast_comm_id = 0");
					$row['user_wall_num'] = $cnt_rec['cnt'];
				}
			}
			
			if($row['user_wall_num'])
			        $tpl->set('{rec-num}', '<b id="wall_rec_num">'.$row['user_wall_num'].' </b> '.gram_record($row['user_wall_num'], 'rec'));
		    else {
			        $tpl->set('{rec-num}', 'Нет записей');
		    }
			
			$row['user_wall_num'] = $row['user_wall_num'] ? $row['user_wall_num'] : '';
			if($row['user_wall_num'] > 10){
				$tpl->set('[wall-link]', '');
				$tpl->set('[/wall-link]', '');
			} else
				$tpl->set_block("'\\[wall-link\\](.*?)\\[/wall-link\\]'si","");
			
			$tpl->set('{wall-rec-num}', $row['user_wall_num']);
			
			if($row['user_wall_num'])
				$tpl->set_block("'\\[no-records\\](.*?)\\[/no-records\\]'si","");
			else {
				$tpl->set('[no-records]', '');
				$tpl->set('[/no-records]', '');
			}
			
//Статус
			$expStatus = explode('<audio', $row['user_status']);
			
			if($expStatus[1]){
			
				$tpl->set('{status-text}', stripslashes($expStatus[0]));
				$tpl->set('{val-status-text}', strip_tags(stripslashes($expStatus[0])));
				$tpl->set('[player-link]', '');
				$tpl->set('[/player-link]', '');
				$tpl->set('{aid}', $expStatus[1]);
				
			} else {
				
				$tpl->set('{status-text}', stripslashes($row['user_status']));
				$tpl->set('{val-status-text}', strip_tags(stripslashes($row['user_status'])));
				$tpl->set_block("'\\[player-link\\](.*?)\\[/player-link\\]'si","");
				
			}
			
			if($row['user_status']){
				$tpl->set('[status]', '');
				$tpl->set('[/status]', '');
				$tpl->set_block("'\\[no-status\\](.*?)\\[/no-status\\]'si","");
			} else {
				$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si","");
				$tpl->set('[no-status]', '');
				$tpl->set('[/no-status]', '');
			}
			
			//Приватность сообщений
			if($user_privacy['val_msg'] == 1 OR $user_privacy['val_msg'] == 2 AND $check_friend){
				$tpl->set('[privacy-msg]', '');
				$tpl->set('[/privacy-msg]', '');
			} else
				$tpl->set_block("'\\[privacy-msg\\](.*?)\\[/privacy-msg\\]'si","");
				
				//Приватность добавления в друзья
   if($user_privacy['val_friend'] == 1 OR $user_privacy['val_friend'] == 2 AND $user_id == $id){
    $tpl->set('[privacy-friend]', '');
    $tpl->set('[/privacy-friend]', '');
   } else
    $tpl->set_block("'\\[privacy-friend\\](.*?)\\[/privacy-friend\\]'si","");
				
				//Приватность мнения
            if($user_privacy['val_view'] == 1 OR $user_privacy['val_view'] == 2 AND $check_friend OR $user_id == $id){ 
                $tpl->set('[privacy-view]', ''); 
                $tpl->set('[/privacy-view]', ''); 
            } else 
                $tpl->set_block("'\\[privacy-view\\](.*?)\\[/privacy-view\\]'si","");
				
			//Приватность стены
			if($user_privacy['val_wall1'] == 1 OR $user_privacy['val_wall1'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-wall]', '');
				$tpl->set('[/privacy-wall]', '');
			} else
				$tpl->set_block("'\\[privacy-wall\\](.*?)\\[/privacy-wall\\]'si","");
				
			if($user_privacy['val_wall2'] == 1 OR $user_privacy['val_wall2'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-wall]', '');
				$tpl->set('[/privacy-wall]', '');
			} else
				$tpl->set_block("'\\[privacy-wall\\](.*?)\\[/privacy-wall\\]'si","");

			//Приватность информации
			if($user_privacy['val_info'] == 1 OR $user_privacy['val_info'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-info]', '');
				$tpl->set('[/privacy-info]', '');
			} else
				$tpl->set_block("'\\[privacy-info\\](.*?)\\[/privacy-info\\]'si","");
				
				//Приватность гости 
            if($user_privacy['val_guests1'] == 1 OR $user_privacy['val_guests1'] == 2 AND $check_friend OR $user_id == $id){ 
                $tpl->set('[privacy-guests]', ''); 
                $tpl->set('[/privacy-guests]', ''); 
            } else 
                $tpl->set_block("'\\[privacy-guests\\](.*?)\\[/privacy-guests\\]'si","");
			
			//Приватность Сообществ
			if($user_privacy['val_group'] == 1 OR $user_privacy['val_group'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-group]', '');
				$tpl->set('[/privacy-group]', '');
			} else
				$tpl->set_block("'\\[privacy-group\\](.*?)\\[/privacy-group\\]'si","");
				
			//Приватность Подарков
			if($user_privacy['val_gifts'] == 1 OR $user_privacy['val_gifts'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-gifts]', '');
				$tpl->set('[/privacy-gifts]', '');
			} else
				$tpl->set_block("'\\[privacy-gifts\\](.*?)\\[/privacy-gifts\\]'si","");
				
			//Приватность Аудиозаписей
			if($user_privacy['val_audios'] == 1 OR $user_privacy['val_audios'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-audios]', '');
				$tpl->set('[/privacy-audios]', '');
			} else
				$tpl->set_block("'\\[privacy-audios\\](.*?)\\[/privacy-audios\\]'si","");
				
			//Приватность Интересных страниц
			if($user_privacy['val_sub'] == 1 OR $user_privacy['val_sub'] == 2 AND $check_friend OR $user_id == $id){
				$tpl->set('[privacy-sub]', '');
				$tpl->set('[/privacy-sub]', '');
			} else
				$tpl->set_block("'\\[privacy-sub\\](.*?)\\[/privacy-sub\\]'si","");
            			
						//Семейное положение
			$user_sp = explode('|', $row['user_sp']);
			if($user_sp[1]){
				$rowSpUserName = $db->super_query("SELECT user_search_pref, user_sp, user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_sp[1]}'");
				if($row['user_sex'] == 1) $check_sex = 2;
				if($row['user_sex'] == 2) $check_sex = 1;
				if($rowSpUserName['user_sp'] == $user_sp[0].'|'.$id OR $user_sp[0] == 5 AND $rowSpUserName['user_sex'] == $check_sex){
					$spExpName = explode(' ', $rowSpUserName['user_search_pref']);
					$spUserName = $spExpName[0].' '.$spExpName[1];
				}
			}
			if($row['user_sex'] == 1){
				$sp1 = '<a href="/?go=search&sp=1" onClick="Page.Go(this.href); return false">не женат</a>';
				$sp2 = "подруга <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp2_2 = '<a href="/?go=search&sp=2" onClick="Page.Go(this.href); return false">есть подруга</a>';
				$sp3 = "невеста <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp3_3 = '<a href="/?go=search&sp=3" onClick="Page.Go(this.href); return false">помовлен</a>';
				$sp4 = "жена <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp4_4 = '<a href="/?go=search&sp=4" onClick="Page.Go(this.href); return false">женат</a>';
				$sp5 = "любимая <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp5_5 = '<a href="/?go=search&sp=5" onClick="Page.Go(this.href); return false">влюблён</a>';
			}
			if($row['user_sex'] == 2){
				$sp1 = '<a href="/?go=search&sp=1" onClick="Page.Go(this.href); return false">не замужем</a>';
				$sp2 = "друг <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp2_2 = '<a href="/?go=search&sp=2" onClick="Page.Go(this.href); return false">есть друг</a>';
				$sp3 = "жених <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp3_3 = '<a href="/?go=search&sp=3" onClick="Page.Go(this.href); return false">помовлена</a>';
				$sp4 = "муж <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp4_4 = '<a href="/?go=search&sp=4" onClick="Page.Go(this.href); return false">замужем</a>';
				$sp5 = "любимый <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
				$sp5_5 = '<a href="/?go=search&sp=5" onClick="Page.Go(this.href); return false">влюблена</a>';
			}
			$sp6 = "партнёр <a href=\"/u{$user_sp[1]}\" onClick=\"Page.Go(this.href); return false\">{$spUserName}</a>";
			$sp6_6 = '<a href="/?go=search&sp=6" onClick="Page.Go(this.href); return false">всё сложно</a>';
			$tpl->set('[sp]', '');
			$tpl->set('[/sp]', '');
			if($user_sp[0] == 1)
				$tpl->set('{sp}', $sp1);
			else if($user_sp[0] == 2)
				if($spUserName) $tpl->set('{sp}', $sp2);
				else $tpl->set('{sp}', $sp2_2);
			else if($user_sp[0] == 3)
				if($spUserName) $tpl->set('{sp}', $sp3);
				else $tpl->set('{sp}', $sp3_3);
			else if($user_sp[0] == 4)
				if($spUserName) $tpl->set('{sp}', $sp4);
				else $tpl->set('{sp}', $sp4_4);
			else if($user_sp[0] == 5)
				if($spUserName) $tpl->set('{sp}', $sp5);
				else $tpl->set('{sp}', $sp5_5);
			else if($user_sp[0] == 6)
				if($spUserName) $tpl->set('{sp}', $sp6);
				else $tpl->set('{sp}', $sp6_6);
			else if($user_sp[0] == 7)
				$tpl->set('{sp}', '<a href="/?go=search&sp=7" onClick="Page.Go(this.href); return false">в активном поиске</a>');
			else
				$tpl->set_block("'\\[sp\\](.*?)\\[/sp\\]'si","");
			
			//ЧС
			if(!$CheckBlackList){
				$tpl->set('[blacklist]', '');
				$tpl->set('[/blacklist]', '');
				$tpl->set_block("'\\[not-blacklist\\](.*?)\\[/not-blacklist\\]'si","");
			} else {
				$tpl->set('[not-blacklist]', '');
				$tpl->set('[/not-blacklist]', '');
				$tpl->set_block("'\\[blacklist\\](.*?)\\[/blacklist\\]'si","");
			}
			
			 //############################# fon www.facemy.org ################################//
   if($user_id = $id){
    $user_img_fon = $db->super_query("SELECT user_img_fon FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
    if($user_img_fon['user_img_fon']){
      $img = $user_img_fon['user_img_fon'];
     }else{
      $img = '';
     }
     $tpl->set('{url_img}', '<style type="text/css" media="all">html, body{background: url('.$img.') no-repeat center top fixed;margin:0px;padding:0px;font-size:11px;-moz-background-size:cover;-o-background-size:100% auto;-webkit-background-size:100% auto;-khtml-background-size:cover;background-size:cover;}</style>');
   } else {
    $user_img_fon = $db->super_query("SELECT user_img_fon FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
     if($user_img_fon['user_img_fon']){
      $img = $user_img_fon['user_img_fon'];
     }else{
      $img = '';
     }
     $tpl->set('{url_img}', '<style type="text/css" media="all">html, body{background: url('.$img.') no-repeat center top fixed;margin:0px;padding:0px;font-size:11px;-moz-background-size:cover;-o-background-size:100% auto;-webkit-background-size:100% auto;-khtml-background-size:cover;background-size:cover;}</style>');
   }	
			
			//################### Подарки ###################//
			if($row['user_gifts']){
				$sql_gifts = $db->super_query("SELECT gift FROM `".PREFIX."_gifts` WHERE uid = '{$id}' ORDER by `gdate` DESC LIMIT 0, 4", 1, "user_{$id}/gifts");
				foreach($sql_gifts as $row_gift){
					$gifts .= "<img src=\"/uploads/gifts/{$row_gift['gift']}.png\" class=\"gift_onepage\" />";
				}
				$tpl->set('[gifts]', '');
				$tpl->set('[/gifts]', '');
				$tpl->set('{gifts}', $gifts);
				$tpl->set('{gifts-text}', $row['user_gifts'].' '.gram_record($row['user_gifts'], 'gifts'));
			} else
				$tpl->set_block("'\\[gifts\\](.*?)\\[/gifts\\]'si","");
				

				$owner = $db->super_query("SELECT user_banname FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				if($owner['user_banname'] == 1){

				header('Location: /index.php?go=settings&act=banname');
		
				}
				
			//################### Вывод текущего счета ###################//
			$owner = $db->super_query("SELECT user_balance, balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->set('{ubm}', $owner['user_balance']);
			$tpl->set('{rub}', $owner['balance_rub']);
			$tpl->set('{text-ubm}', declOfNum($owner['balance_rub'], array('голоса', 'голосов', 'голос')));
			$tpl->set('{text-rub}', declOfNum($owner['balance_rub'], array('рубль', 'рубля', 'рублей')));



			//################### Загрузка самого профиля ###################//
			$tpl->load_template('profile.tpl');

			if($count_common['cnt']){
   
				$tpl->set('{mutual_friends}', $tpl->result['mutual_friends']);
				$tpl->set('{mutual-num}', $count_common['cnt']);
				$tpl->set('[common-friends]', '');
				$tpl->set('[/common-friends]', '');
   
			} else
				$tpl->set_block("'\\[common-friends\\](.*?)\\[/common-friends\\]'si","");

			//################### Интересные страницы ###################//
			if($row['user_public_num']){
				$sql_groups = $db->super_query("SELECT tb1.friend_id, tb2.id, title, photo, adres, status_text FROM `".PREFIX."_friends` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$id}' AND tb1.friend_id = tb2.id AND tb1.subscriptions = 2 ORDER by `traf` DESC LIMIT 0, 5", 1, "groups/".$id);
				foreach($sql_groups as $row_groups){
					if($row_groups['adres']) $adres = $row_groups['adres'];
					else $adres = 'public'.$row_groups['id'];
					if($row_groups['photo']) $ava_groups = "/uploads/groups/{$row_groups['id']}/50_{$row_groups['photo']}";
					else $ava_groups = "{theme}/images/no_ava_50.png";	
					$row_groups['status_text'] = substr($row_groups['status_text'], 0, 24);
					$groups .= '<div class="onesubscription onesubscriptio2n cursor_pointer" onClick="Page.Go(\'/'.$adres.'\')"><a href="/'.$adres.'" onClick="Page.Go(this.href); return false"><img src="'.$ava_groups.'" /></a><div class="onesubscriptiontitle"><a href="/'.$adres.'" onClick="Page.Go(this.href); return false">'.stripslashes($row_groups['title']).'</a></div><span class="color777 size10">'.stripslashes($row_groups['status_text']).'</span></div>';
				}
				$tpl->set('[groups]', '');
				$tpl->set('[/groups]', '');
				$tpl->set('{groups}', $groups);
				$tpl->set('{groups-num}', $row['user_public_num']);
			} else
				$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
				
				//################### Интересные страницы в информации ###################//

    if($row['user_public_num']){

    $sql_infogroups = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.id, title, photo, adres FROM `".PREFIX."_friends` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$id}' AND tb1.friend_id = tb2.id AND tb1.subscriptions = 2 ORDER by `traf` DESC LIMIT 0, 999", 1, "groups/".$id);
    foreach($sql_infogroups as $row_groups_info){
    if($row_groups_info['adres']) {
    $adress = $row_groups_info['adres'];
    }
    else {$adress = 'public'.$row_groups_info['id'];
    }
    
    $groups_info_but = ' 
    
<script>function showTooltip()
{
var myDiv = document.getElementById(\'tooltip\');
if(myDiv.style.height == \'52px\')
{
myDiv.style.height = \'100%\';
} else {
myDiv.style.height = \'52px\';
}
return false;
}


</script> 
    
<a class="group_info_but"  href=\'javascript:;\' onclick=showTooltip()>Показать/скрыть список всех групп</a>

    ';
    
    $groups_info .= '<a href="/'.$adress.'" onClick="Page.Go(this.href); return false">'.stripslashes($row_groups_info['title']).'</a>&nbsp;';
    }
        
    $tpl->set('[groups]', '');
    $tpl->set('[/groups]', '');
    $tpl->set('{groups}', $groups);
    
    $tpl->set('{groups_info}', $groups_info);
    $tpl->set('{groups_info_but}', $groups_info_but);

    $tpl->set('{groups-num}', '<span id="groups_num">'.$row['user_public_num'].' </span> '.gram_record($row['user_public_num'], 'public_group'));
    } else
    $tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");

			
				
				//################### Музыка ###################//
			if($row['user_audio'] AND $config['audio_mod'] == 'yes'){
				$tpl->set('[audios]', '');
				$tpl->set('[/audios]', '');
				$tpl->set('{audios}', $tpl->result['audios']);
				$tpl->set('{audios-num}', $row['user_audio'].' '.gram_record($row['user_audio'], 'audio'));
			} else
				$tpl->set_block("'\\[audios\\](.*?)\\[/audios\\]'si","");

			//################### Праздники друзей ###################//
			if($cnt_happfr){
				$tpl->set('{happy-friends}', $tpl->result['happy_all_friends']);
				$tpl->set('[happy-friends]', '');
				$tpl->set('[/happy-friends]', '');
			} else
				$tpl->set_block("'\\[happy-friends\\](.*?)\\[/happy-friends\\]'si","");

			//################### Обработка дополнительных полей ###################//
			$xfieldsdata = xfieldsdataload($row['xfields']);
			$xfields = profileload();
				
			foreach($xfields as $value){

				$preg_safe_name = preg_quote($value[0], "'");

				if(empty($xfieldsdata[$value[0]])){

					$tpl->copy_template = preg_replace("'\\[xfgiven_{$preg_safe_name}\\](.*?)\\[/xfgiven_{$preg_safe_name}\\]'is", "", $tpl->copy_template);
					
				} else {

					$tpl->copy_template = str_replace("[xfgiven_{$preg_safe_name}]", "", $tpl->copy_template);
					$tpl->copy_template = str_replace("[/xfgiven_{$preg_safe_name}]", "", $tpl->copy_template);
					$xfields_check = true;
				}

				$tpl->copy_template = preg_replace( "'\\[xfvalue_{$preg_safe_name}\\]'i", stripslashes($xfieldsdata[$value[0]]), $tpl->copy_template);

			}
			
			if($xfields_check){
				$tpl->set('[xfields]', '');
				$tpl->set('[/xfields]', '');
			} else
				$tpl->set_block("'\\[xfields\\](.*?)\\[/xfields\\]'si","");
	
			if($id == 7) $tpl->set('{group}', '<font color="#f87d7d">Модератор</font>');
			else $tpl->set('{group}', '');

			$tpl->set('{type}', strtr($row['type_profile'], array(1 => 'Пользователь', 2 =>'Начинающий фотограф', 3 => 'Фотограф', 4 => 'Модель', 5 => 'Стилист / Визажист')));

			
                        //Обложка
			if($row['user_photo']){
			
				$avaImgIsinfo = getimagesize(ROOT_DIR."/uploads/users/{$row['user_id']}/{$row['user_photo']}");
					
				if($avaImgIsinfo[1] < 200){
					
				$rForme = 230 - $avaImgIsinfo[1];
					
				$ava_marg_top = 'style="margin-top:-'.$rForme.'px"';
					
				}
				
				$tpl->set('{cover-param-7}', $ava_marg_top);
				
			} else
				$tpl->set('{cover-param-7}', "");
			
			if($row['user_cover']){
				
				$imgIsinfo = getimagesize(ROOT_DIR."/uploads/users/{$id}/{$row['user_cover']}");
				
				$tpl->set('{cover}', "/uploads/users/{$id}/{$row['user_cover']}");
				$tpl->set('{cover-height}', $imgIsinfo[1]);
				$tpl->set('{cover-param}', '');
				$tpl->set('{cover-param-2}', 'no_display');
				$tpl->set('{cover-param-3}', 'style="position:absolute;z-index:2;display:block;margin-left:397px"');
				$tpl->set('{cover-param-4}', 'style="cursor:default"');
				$tpl->set('{cover-param-5}', 'style="top:-'.$row['user_cover_pos'].'px;position:relative"');
				$tpl->set('{cover-pos}', $row['user_cover_pos']);
				
				$tpl->set('[cover]', '');
				$tpl->set('[/cover]', '');

			} else {
				
				$tpl->set('{cover}', "");
				$tpl->set('{cover-param}', 'no_display');
				$tpl->set('{cover-param-2}', '');
				$tpl->set('{cover-param-3}', '');
				$tpl->set('{cover-param-4}', '');
				$tpl->set('{cover-param-5}', '');
				$tpl->set('{cover-pos}', '');
				$tpl->set_block("'\\[cover\\](.*?)\\[/cover\\]'si","");
				
			}
			
			//Считаем кол-во подписчиков у юзера
			$row_cnt_user_subcsr = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` WHERE friend_id = '{$id}' AND subscriptions = 1", false, "user_{$id}/subscr_num");
			$tpl->set('{subscr-num}', $row_cnt_user_subcsr['cnt']);
			
			if($row_cnt_user_subcsr['cnt']){
				
				$tpl->set('[subscr]', '');
				$tpl->set('[/subscr]', '');
				
			} else
				$tpl->set_block("'\\[subscr\\](.*?)\\[/subscr\\]'si","");
			

//Баннеры
			$sql_banners = $db->super_query("SELECT * FROM `".PREFIX."_banners`", 1);
			$myInfoFbanner = $db->super_query("SELECT user_country, user_city, user_year, user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$bannerNum = 0;
			
			foreach($sql_banners as $row_banners){
				
				//Заменяем ссылки на реф.
				$row_banners['code'] = str_replace('href="', 'href="/index.php?go=bonus&url=', $row_banners['code']);
				
				//Левый рекламный блок
				if($row_banners['id'] == 1){

					if(!$row_banners['country']) $checkBannerLeftCountry = 0; else $checkBannerLeftCountry = $myInfoFbanner['user_country'];
					if(!$row_banners['city']) $checkBannerLeftCity = 0; else $checkBannerLeftCity = $myInfoFbanner['user_city'];
					if(!$row_banners['year']) $checkBannerLeftYear = 0; else $checkBannerLeftYear = $myInfoFbanner['user_year'];
					if(!$row_banners['sex']) $checkBannerLeftSex = 0; else $checkBannerLeftSex = $myInfoFbanner['user_sex'];

					if($row_banners['country'] == $checkBannerLeftCountry AND $row_banners['city'] == $checkBannerLeftCity AND $row_banners['year'] == $checkBannerLeftYear AND $row_banners['sex'] == $checkBannerLeftSex AND $row_banners['code']){
						$tpl->set('{banner-left}', '<div id="banner1" class="bannerSite">'.stripslashes($row_banners['code']).'</div>');
						$bannerNum++;
					} else
						$tpl->set('{banner-left}', "");
					
				}

				//Правый рекламный блок
				if($row_banners['id'] == 2){
					
					if(!$row_banners['country']) $checkBannerLeftCountry2 = 0; else $checkBannerLeftCountry2 = $myInfoFbanner['user_country'];
					if(!$row_banners['city']) $checkBannerLeftCity2 = 0; else $checkBannerLeftCity2 = $myInfoFbanner['user_city'];
					if(!$row_banners['year']) $checkBannerLeftYear2 = 0; else $checkBannerLeftYear2 = $myInfoFbanner['user_year'];
					if(!$row_banners['sex']) $checkBannerLeftSex2 = 0; else $checkBannerLeftSex2 = $myInfoFbanner['user_sex'];

					if($row_banners['country'] == $checkBannerLeftCountry2 AND $row_banners['city'] == $checkBannerLeftCity2 AND $row_banners['year'] == $checkBannerLeftYear2 AND $row_banners['sex'] == $checkBannerLeftSex2 AND $row_banners['code']){
						$tpl->set('{banner-right}', '<div id="banner2" class="bannerSite no_display">'.stripslashes($row_banners['code']).'</div>');
						$bannerNum++;
					} else 
						$tpl->set('{banner-right}', "");

				}

				//Верхний рекламный блок
				if($row_banners['id'] == 3){
					
					if(!$row_banners['country']) $checkBannerLeftCountry3 = 0; else $checkBannerLeftCountry3 = $myInfoFbanner['user_country'];
					if(!$row_banners['city']) $checkBannerLeftCity3 = 0; else $checkBannerLeftCity3 = $myInfoFbanner['user_city'];
					if(!$row_banners['year']) $checkBannerLeftYear3 = 0; else $checkBannerLeftYear3 = $myInfoFbanner['user_year'];
					if(!$row_banners['sex']) $checkBannerLeftSex3 = 0; else $checkBannerLeftSex3 = $myInfoFbanner['user_sex'];

					if($row_banners['country'] == $checkBannerLeftCountry3 AND $row_banners['city'] == $checkBannerLeftCity3 AND $row_banners['year'] == $checkBannerLeftYear3 AND $row_banners['sex'] == $checkBannerLeftSex3 AND $row_banners['code']){
						$tpl->set('{banner-top}', '<div id="banner3" class="bannerSite no_display">'.stripslashes($row_banners['code']).'</div>');
						$bannerNum++;
					} else
						$tpl->set('{banner-top}', "");
					
				}

				//Нижний рекламный блок
				if($row_banners['id'] == 4){
					
					if(!$row_banners['country']) $checkBannerLeftCountry4 = 0; else $checkBannerLeftCountry4 = $myInfoFbanner['user_country'];
					if(!$row_banners['city']) $checkBannerLeftCity4 = 0; else $checkBannerLeftCity4 = $myInfoFbanner['user_city'];
					if(!$row_banners['year']) $checkBannerLeftYear4 = 0; else $checkBannerLeftYear4 = $myInfoFbanner['user_year'];
					if(!$row_banners['sex']) $checkBannerLeftSex4 = 0; else $checkBannerLeftSex4 = $myInfoFbanner['user_sex'];

					if($row_banners['country'] == $checkBannerLeftCountry4 AND $row_banners['city'] == $checkBannerLeftCity4 AND $row_banners['year'] == $checkBannerLeftYear4 AND $row_banners['sex'] == $checkBannerLeftSex4 AND $row_banners['code']){
						$tpl->set('{banner-bottom}', '<div id="banner4" class="bannerSite no_display">'.stripslashes($row_banners['code']).'</div>');
						$bannerNum++;
					} else 
						$tpl->set('{banner-bottom}', "");
				}
				
			}

			if($bannerNum == 1){
				
				$tpl->set_block("'\\[update-banner\\](.*?)\\[/update-banner\\]'si","");
				
			} else {
				
				$tpl->set('[update-banner]', '');
				$tpl->set('[/update-banner]', '');
				
			}
			
			if(!$bannerNum OR $_SESSION['banner1']){
				
				$tpl->set_block("'\\[banners\\](.*?)\\[/banners\\]'si","");
				
			} else {
				
				$tpl->set('[banners]', '');
				$tpl->set('[/banners]', '');
				
			}
			
						if($verification)
				$tpl->set('{verification}', $verification);
			else
				$tpl->set('{verification}', '');
 
//################################## Rate user #####################################//

			if($user_id == $id){
 			// читаем с базы количесво в символах.
			$rr = $db->super_query("SELECT user_rate FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
			if($rr['user_rate'] > 100){
				$proc1000 = $rr['user_rate'] * (0.2);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="46";
			} else {
				$proc1000 = $rr['user_rate'] * (2);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="23";
			}
			if($rr['user_rate'] > 1000){
				$proc1000 = $rr['user_rate'] * (0.02);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="69";
			}
			if($rr['user_rate'] > 10000){
				$proc1000 = $rr['user_rate'] * (0.002);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="92";
			}
			if($rr['user_rate'] > 100000){
				$proc1000 = $rr['user_rate'] * (0.0002);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="115";
			}
			if($rr['user_rate'] > 1000000){
				$procmax = (200);
				$procmin1000 = (0);
			}

			$tpl->set('{user_rating}', '<a onclick="doLoad.data(1); rating.addbox('.$id.')"><div class="rate_line">
				<div class="rate_text" style="color:#7985AF;">Рейтинг: <span id="profile_rate_num">'.$rr['user_rate'].'</span></div>
				<div>
				<div class="rate_left fl_l" style="width: '.$procmax.'px; background: url(/templates/Default/images/rating.png) repeat-x 0px -'.$lin1000.'px;"></div>
				<div class="rate_right fl_r" style="width: '.$procmin1000.'px;"></div>
 </div>
 </div></a>
 <div style="cursor:pointer; margin-top: -31px;position: absolute;margin-left: 185px;z-index: 10; class="cursor_pointer" onclick="doLoad.data(1); rating.view()" onmouseover="myhtml.title(\'1\', \'{translate=lang_983}\', \'rate\', 1)" id="rate1" id="rate1"><img src="/templates/Default/images/icons/rate_ic.png" ></div>
 ');
			} else {
 			// читаем с базы количесво в символах.
			$rr = $db->super_query("SELECT user_rate FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
			if($rr['user_rate'] > 100){
				$proc1000 = $rr['user_rate'] * (0.2);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="46";
			} else {
				$proc1000 = $rr['user_rate'] * (2);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="23";
			}
			if($rr['user_rate'] > 1000){
				$proc1000 = $rr['user_rate'] * (0.02);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="69";
			}
			if($rr['user_rate'] > 10000){
				$proc1000 = $rr['user_rate'] * (0.002);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="92";
			}
			if($rr['user_rate'] > 100000){
				$proc1000 = $rr['user_rate'] * (0.0002);
				$procmax = round($proc1000);
				$procmin1000 = (200) - $procmax;
				$lin1000="115";
			}
			if($rr['user_rate'] > 1000000){
				$procmax = (200);
				$procmin1000 = (0);
			}

			$tpl->set('{user_rating}', '<a onclick="doLoad.data(1); rating.addbox('.$id.')"><div class="rate_line">
				<div class="rate_text" style="color:#7985AF;">Рейтинг: <span id="profile_rate_num">'.$rr['user_rate'].'</span></div>
				<div>
				<div class="rate_left fl_l" style="width: '.$procmax.'px; background: url(/templates/Default/images/rating.png) repeat-x 0px -'.$lin1000.'px;"></div>
				<div class="rate_right fl_r" style="width: '.$procmin1000.'px;"></div>
				</div>
				</div></a>');
			}
			
			$tpl->compile('content');
			//Обновляем кол-во посещений на страницу, если юзер есть у меня в друзьях
			if($check_friend)
				$db->query("UPDATE LOW_PRIORITY `".PREFIX."_friends` SET views = views+1 WHERE user_id = '{$user_info['user_id']}' AND friend_id = '{$id}' AND subscriptions = 0");

		}
	} else {
		$user_speedbar = $lang['no_infooo'];
		msgbox('', $lang['no_upage'], 'info');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>