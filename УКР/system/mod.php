<?php
/* 
	Appointment: Подключение модулей
	File: mod.php 
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

if(isset($_GET['go']))
	$go = htmlspecialchars(strip_tags(stripslashes(trim(urldecode(mysql_escape_string($_GET['go']))))));
else
	$go = "main";

$mozg_module = $go;

check_xss();

//FOR MOBILE VERSION 1.0
if($config['temp'] == 'mobile')
	$lang['online'] = '<img src="{theme}/images/monline.gif" />';
	
switch($go){

     //Каталог игр
	case "webtomat":
		include ENGINE_DIR.'/modules/webtomat/index.php';
	break;
	
	//Регистрация
	case "register":
		include ENGINE_DIR.'/modules/register.php';
	break;
	
	// СМС подтверждение Регистрация
	case "smsactivate":
		include ENGINE_DIR.'/modules/smsactivate.php';
	break;
	
	//chat
	case "chat":
		include ENGINE_DIR.'/modules/chat.php';
	break;
	
	//Профиль пользователя
	case "profile":
		$spBar = true;
		include ENGINE_DIR.'/modules/profile.php';
	break;
	
	//Редактирование моей страницы
	case "editprofile":
		$spBar = true;
		include ENGINE_DIR.'/modules/editprofile.php';
	break;
 
 //developers
 case "developers":
  
  include ENGINE_DIR.'/modules/developers.php';
 break;
 
 //Пины
 case "pins":
  include ENGINE_DIR . '/modules/pins.php';
 break;
 
 
 //restorepass
 case "restorepass":
  
  include ENGINE_DIR.'/modules/restorepass.php';
 break;
 
 //Последние загруженные фото на аяксе
 case "other":
  
  include ENGINE_DIR.'/modules/other.php';
 break;
 
 //native
 case "native":
  
  include ENGINE_DIR.'/modules/native.php';
 break;
 
 //met
 case "met":
  
  include ENGINE_DIR.'/modules/met.php';
 break;
 
 //ADS
 case "ads":
  include ENGINE_DIR.'/modules/ads.php';
 break;
 
 //Мисс сайта
	case "miss":
	$spBar = true;
		include ENGINE_DIR.'/modules/miss.php';
	break;
 
 //sites
 case "sites":
  
  include ENGINE_DIR.'/modules/sites.php';
 break;
 
 //opinion
 case "opinion":
  
  include ENGINE_DIR.'/modules/opinion.php';
 break;
 
 //standalone
 case "standalone":
  
  include ENGINE_DIR.'/modules/standalone.php';
 break;
 
 //jobs
 case "jobs":
  
  include ENGINE_DIR.'/modules/jobs.php';
 break;
 
 //pod
 case "pod":
  
  include ENGINE_DIR.'/modules/pod.php';
 break;
 
 //web
 case "web":
  
  include ENGINE_DIR.'/modules/web.php';
 break;
 
 //Заявки в аяксе
	case "ajaxfriends":
		$spBar = true;
		include ENGINE_DIR.'/modules/ajaxfriends.php';
	break;
	
	//Чат
case "im_chat":
include ENGINE_DIR.'/modules/im_chat.php';
break;

    //Фон
   case "fon":
   include ENGINE_DIR.'/modules/fon.php';
   break;
   
   //Battles
    case "compare": 
        include ENGINE_DIR.'/modules/compare.php'; 
        break;
 
 //Авторы
 case "help":
  
  include ENGINE_DIR.'/modules/help.php';
 break;
 
 //Авторы
 case "adv":
  
  include ENGINE_DIR.'/modules/adv.php';
 break;
 
 //Правила
 case "terms":
  
  include ENGINE_DIR.'/modules/terms.php';
 break;
	
	//Загрузка городов
	case "loadcity":
		include ENGINE_DIR.'/modules/loadcity.php';
	break;
	
	//Альбомы
	case "albums":
		$spBar = true;
		if($config['album_mod'] == 'yes')
			include ENGINE_DIR.'/modules/albums.php';
		else {
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
	
	//Просмотр фотографии
	case "photo":
		include ENGINE_DIR.'/modules/photo.php';
	break;
	
	//Друзья
	case "friends":
		$spBar = true;
		include ENGINE_DIR.'/modules/friends.php';
	break;
	
	// Гости
    case "guests" : 
        include ENGINE_DIR . '/modules/guests.php'; 
        break;
	
	//Закладки
	case "fave":
		$spBar = true;
		include ENGINE_DIR.'/modules/fave.php';
	break;
	
	//Сообщения
	case "messages":
		$spBar = true;
		include ENGINE_DIR.'/modules/messages.php';
	break;
	
	//Диалоги
	case "im":
		include ENGINE_DIR.'/modules/im.php';
	break;

	//Заметки
	case "notes":
		$spBar = true;
		include ENGINE_DIR.'/modules/notes.php';
	break;
	
	//Подписки
	case "subscriptions":
		include ENGINE_DIR.'/modules/subscriptions.php';
	break;
	
	//Видео
	case "videos":
		$spBar = true;
		if($config['video_mod'] == 'yes')
			include ENGINE_DIR.'/modules/videos.php';
		else {
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
	
	//Поиск
	case "search":
		include ENGINE_DIR.'/modules/search.php';
	break;
	
	//Стена
	case "wall":
		$spBar = true;
		include ENGINE_DIR.'/modules/wall.php';
	break;
	
	//Статус
	case "status":
		include ENGINE_DIR.'/modules/status.php';
	break;
	
	//Новости
	case "news":
		$spBar = true;
		include ENGINE_DIR.'/modules/news.php';
	break;
	
	//Настройки
	case "settings":
		include ENGINE_DIR.'/modules/settings.php';
	break;
	
	//Помощь
	case "support":
		include ENGINE_DIR.'/modules/support.php';
	break;
	
	//Воостановление доступа
	case "restore":
		include ENGINE_DIR.'/modules/restore.php';
	break;
	
	//Загрузка картинок при прикриплении файлов со стены, заметок, или сообщений
	case "attach":
		include ENGINE_DIR.'/modules/attach.php';
	break;
	
	//Блог сайта
	case "blog":
		$spBar = true;
		include ENGINE_DIR.'/modules/blog.php';
	break;

	//Баланс
	case "balance":
		include ENGINE_DIR.'/modules/balance.php';
	break;
	
	//Подарки
	case "gifts":
		include ENGINE_DIR.'/modules/gifts.php';
	break;

	//Сообщества
	case "groups":
		include ENGINE_DIR.'/modules/groups.php';
	break;
	
	//Сообщества
	case "clubs":
		include ENGINE_DIR.'/modules/clubs.php';
	break;
	
	//Сообщества -> Публичные страницы
	case "public":
		$spBar = true;
		include ENGINE_DIR.'/modules/public.php';
	break;
	
	//Сообщества -> Группы
	case "club":
		$spBar = true;
		include ENGINE_DIR.'/modules/club.php';
	break;
	
	//Сообщества -> Загрузка фото
	case "attach_groups":
		include ENGINE_DIR.'/modules/attach_groups.php';
	break;

	//Музыка
	case "audio":
		if($config['audio_mod'] == 'yes')
			include ENGINE_DIR.'/modules/audio.php';
		else {
			$spBar = true;
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;

	//Статические страницы
	case "static":
		include ENGINE_DIR.'/modules/static.php';
	break;

	//Выделить человека на фото
	case "distinguish":
		include ENGINE_DIR.'/modules/distinguish.php';
	break;

	//Скрываем блок Дни рожденья друзей
	case "happy_friends_block_hide":
		$_SESSION['happy_friends_block_hide'] = 1;
		die();
	break;

	//Скрываем блок Дни рожденья друзей
	case "fast_search":
		include ENGINE_DIR.'/modules/fast_search.php';
	break;

	//Жалобы
	case "report":
		include ENGINE_DIR.'/modules/report.php';
	break;
	
	// Алиасы
	case "alias":
	$spBar = true;
    $alias = $db->safesql($_GET['url']);
	if($alias){
	$alias_club = $db->super_query("SELECT id,title FROM `".PREFIX."_clubs` WHERE adres = '".$alias."' "); //Проверяем адреса у групп
 	$alias_public = $db->super_query("SELECT id,title FROM `".PREFIX."_communities` WHERE adres = '".$alias."' "); //Проверяем адреса у публичных страниц
	$alias_user = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE alias = '".$alias."'"); // Проверяем адреса у пользователей
    if($alias_user){   			
	    $_GET['id']= $alias_user['user_id'];
	    include ENGINE_DIR.'/modules/profile.php';
		}elseif($alias_public){   		
		$_GET['pid']= $alias_public['id'];
		include ENGINE_DIR.'/modules/public.php';
		}elseif($alias_club){   		
		$_GET['gid']= $alias_club['id'];
		include ENGINE_DIR.'/modules/club.php';
	}else{
	$spBar = true;
			$user_speedbar = 'Информация';
			msgbox('', 'Доменное имя <b>'.$alias.'</b> свободно для регистрации.', '<body style="background: #3f5d81 url(http://vk.me/images/error404.png) no-repeat 50% 50%; width: 100%; height: 100%; overflow: hidden;">
<a href="http://vk.com/" style="position: absolute; left: 50%; top: 50%; margin: -265px -345px 0px; height: 530px; width: 690px;"></a>
</body>');
	}
	}
    break;
	
	//Радар
	case "radar":
		include ENGINE_DIR.'/modules/radar.php';
	break;
	
	//Значок
        case "znachok":
                include ENGINE_DIR.'/modules/znachok.php';
        break;

	//Отправка записи в сообщество или другу
	case "repost":
		include ENGINE_DIR.'/modules/repost.php';
	break;

	//Моментальные оповещания
	case "updates":
		include ENGINE_DIR.'/modules/updates.php';
	break;
	
	//Реклама
	case "mybanners":
		include ENGINE_DIR.'/modules/mybanners.php';
	break;
	
	//Переводчик
	case "tranlsate":
		include ENGINE_DIR.'/modules/tranlsate.php';
	break;
	
	//Начисление mix За переход по рекламе
	case "bonus":
		
		if($logged){
		
			$user_id = $user_info['user_id'];
			
			$url = $_GET['url'];
			
			$url = str_replace('>', '', $url);
			$url = str_replace('<', '', $url);
			$url = str_replace(';', '', $url);
			$url = str_replace('"', '', $url);
			$url = str_replace("'", '', $url);
			$url = str_replace("(", '', $url);
			$url = str_replace(")", '', $url);
			
			//Выводим все баннеры
			$sql_banners = $db->super_query("SELECT code FROM `".PREFIX."_banners`", 1);
			
			foreach($sql_banners as $row){
				
				//Проверка
				if(stripos($row['code'], '<a href="'.$url.'"') !== false){
					
					$cost .= 1;
					
				} else {
					
					$cost .= '';
					
				}
				
			}
			
			//Если пользователь реально клацнул на рекламу, то начисляем
			if($cost){
				
				$last_conver = mozg_cache("user_{$user_id}/banners") + 86400;
				
				if($last_conver < $server_time){
					
					//Начисляем
					$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['banners_mix']}' WHERE user_id = '{$user_id}'");
					
					mozg_create_cache("user_{$user_id}/banners", $server_time);

				}
				
			}
			
			header("Location: {$url}");
		
		}
		
	break;

	//Обновление баланс 5 сек.
	case "up_balance":
	
		NoAjaxQuery();
		
		echo '<b>'.deColNums($user_info['balance_rub']).' руб.</b><br /><b>'.deColNums($user_info['user_balance']).' голосов</b>';
		
		exit();
		
	break;

	//Документы
	case "doc":
		include ENGINE_DIR.'/modules/doc.php';
	break;
	
	case "update_all" :
        include ENGINE_DIR.'/modules/update_all.php';
    break;
	
	//Граффити
	case "graffiti":
		include ENGINE_DIR.'/modules/graffiti.php';
	break;

	//Опросы
	case "votes":
		include ENGINE_DIR.'/modules/votes.php';
	break;
	
	//Сообщества -> Публичные страницы -> Аудиозаписи
	case "public_audio":
		include ENGINE_DIR.'/modules/public_audio.php';
	break;
	
	//Сообщества -> Публичные страницы -> Обсуждения
	case "groups_forum":
		include ENGINE_DIR.'/modules/groups_forum.php';
	break;
	
	//Сообщества -> Группы -> Аудиозаписи
	case "club_audio":
		include ENGINE_DIR.'/modules/club_audio.php';
	break;
	
	//Комментарии к прикприпленным фото
	case "attach_comm":
		include ENGINE_DIR.'/modules/attach_comm.php';
	break;
	
	//Выбор языка
	case "lang":
		include ENGINE_DIR.'/modules/lang.php';
	break;

	//Фоторедактор
	case "photo_editor":
		include ENGINE_DIR.'/modules/photo_editor.php';
	break;
	
	//Автообновление новых фоток на главной
	case "update_photos":
		
		//Выводим новые фото
		$temp_date = date( 'Y-m-d H:i', $server_time - (3596 * 24) );
		$row_photos = $db->super_query("SELECT tb1.id, album_id, photo_name, date, tb1.user_id, tb2.user_search_pref, user_country_city_name FROM `".PREFIX."_photos` tb1, `".PREFIX."_users` tb2, `".PREFIX."_albums` tb3 WHERE tb1.user_id = tb2.user_id AND tb1.album_id = tb3.aid AND tb3.privacy = '1|1' AND date >= '{$temp_date}' AND date <= '{$temp_date}' + INTERVAL 24 HOUR ORDER by rand()");
		
		if($row_photos){
		
			$tpl->load_template('main/photo.tpl');
			
			$shjxdate = str_replace(array('-', ':', ' '), '', $row_photos['date']);
						
			if($shjxdate > '20120908120000')
				$tpl->set('{photo}', '/uploads/users/'.$row_photos['user_id'].'/albums/'.$row_photos['album_id'].'/x_'.$row_photos['photo_name']);
			else
				$tpl->set('{photo}', '/uploads/users/'.$row_photos['user_id'].'/albums/'.$row_photos['album_id'].'/c_'.$row_photos['photo_name']);
					
			$tpl->set('{id}', $row_photos['id']);
			$tpl->set('{aid}', $row_photos['album_id']);
			$tpl->set('{uid}', $row_photos['user_id']);
			$tpl->set('{name}', $row_photos['user_search_pref']);
			$tpl->set('{user-id}', $row_photos['user_id']);
			$user_country_city_name = explode('|', $row_photos['user_country_city_name']);
			if($user_country_city_name[1]) $tpl->set('{city}', '<br />'.$user_country_city_name[1]);
			else $tpl->set('{city}', '');
				
			$tpl->compile('content');

			$tpl->result['content'] = str_replace('<div id="ma{ix}">', $row_photos['id'].'|||', $tpl->result['content']);
			$tpl->result['content'] = str_replace('</a></div></div>', '', $tpl->result['content']);
			
			AjaxTpl();
		
		}
		
		exit;
		
	break;
	
	
	//Плеер
	case "audio_player":
		include ENGINE_DIR.'/modules/audio_player.php';
	break;

	//Игры
	case "apps":
		include ENGINE_DIR.'/modules/apps.php';
	break;
	
	//Редактирование
case "editapp":
		$css_loading = 'apps_edit';
		include ENGINE_DIR.'/modules/editapp.php';
	break;

	//Рейтинг
	case "rating":
		include ENGINE_DIR.'/modules/rating.php';
	break;
	
	//Сообщества -> Публичные страницы -> Видеозаписи
	case "public_videos":
		include ENGINE_DIR.'/modules/public_videos.php';
	break;

	
	//Удаление страницы
	case "del_my_page":
		
		NoAjaxQuery();
		
		if($logged){
			
			$user_id = $user_info['user_id'];
			
			$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/';
			
			$row = $db->super_query("SELECT user_photo, user_wall_id FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
			
			if($row['user_photo']){
			
				$check_wall_rec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE id = '".$row['user_wall_id']."'");
			
				if($check_wall_rec['cnt']){
			
					$update_wall = ", user_wall_num = user_wall_num-1";
					
					$db->query("DELETE FROM `".PREFIX."_wall` WHERE id = '".$row['user_wall_id']."'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '".$row['user_wall_id']."'");
								
				}
							
				$db->query("UPDATE `".PREFIX."_users` SET user_delet = 1, user_photo = '', user_wall_id = '' ".$update_wall." WHERE user_id = '".$user_id."'");

				@unlink($uploaddir.$row['user_photo']);
				@unlink($uploaddir.'50_'.$row['user_photo']);
				@unlink($uploaddir.'100_'.$row['user_photo']);
				@unlink($uploaddir.'o_'.$row['user_photo']);
				@unlink($uploaddir.'130_'.$row['user_photo']);
							
			} else
				$db->query("UPDATE `".PREFIX."_users` SET user_delet = 1, user_photo = '' WHERE user_id = '".$user_id."'");
							
			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
			
		}
		
		die();
		
	break;
	
		default:
			$spBar = true;
			
			if($config['temp'] != 'mobile'){
			
				

				//Выводим новых пользователей
				$sql_people = $db->super_query("SELECT user_id, user_search_pref, user_country_city_name, user_photo FROM `".PREFIX."_users` WHERE user_photo != '' ORDER by `user_reg_date` DESC LIMIT 0, 6", 1);
				
				$tpl->load_template('main/people.tpl');
				foreach($sql_people as $row_people){
				
					$tpl->set('{photo}', '/uploads/users/'.$row_people['user_id'].'/100_'.$row_people['user_photo']);
					
					$tpl->set('{name}', $row_people['user_search_pref']);
					$tpl->set('{user-id}', $row_people['user_id']);
					$user_country_city_name = explode('|', $row_people['user_country_city_name']);
					$tpl->set('{city}', $user_country_city_name[1]);
					
					$tpl->compile('content');
					
				}

				//Выводим новые фото
				$sql_photos = $db->super_query("SELECT tb1.id, album_id, photo_name, date, tb1.user_id, tb2.user_search_pref, user_country_city_name FROM `".PREFIX."_photos` tb1, `".PREFIX."_users` tb2, `".PREFIX."_albums` tb3 WHERE tb1.user_id = tb2.user_id AND tb1.album_id = tb3.aid AND tb3.privacy = '1|1' ORDER by `date` DESC LIMIT 0, 8", 1);
				
				$tpl->result['main_photos'] .= '<div id="update_photos">';
				
				$tpl->load_template('main/photo.tpl');
				$ix = 0;
				foreach($sql_photos as $row_photos){
					$ix++;
					$shjxdate = str_replace(array('-', ':', ' '), '', $row_photos['date']);
					
					if($shjxdate > '20120908120000')
						$tpl->set('{photo}', '/uploads/users/'.$row_photos['user_id'].'/albums/'.$row_photos['album_id'].'/x_'.$row_photos['photo_name']);
					else
						$tpl->set('{photo}', '/uploads/users/'.$row_photos['user_id'].'/albums/'.$row_photos['album_id'].'/c_'.$row_photos['photo_name']);
					
					$tpl->set('{id}', $row_photos['id']);
					$tpl->set('{aid}', $row_photos['album_id']);
					$tpl->set('{uid}', $row_photos['user_id']);
					$tpl->set('{name}', $row_photos['user_search_pref']);
					$tpl->set('{user-id}', $row_photos['user_id']);
					$user_country_city_name = explode('|', $row_photos['user_country_city_name']);
					if($user_country_city_name[1]) $tpl->set('{city}', '<br />'.$user_country_city_name[1]);
					else $tpl->set('{city}', '');
					
					$tpl->set('{ix}', $ix);
					
					$tpl->compile('main_photos');
					
				}

				$tpl->result['main_photos'] .= '</div><script>up_photos()</script>';
			
			}
			
			if($go != 'main')
					msgbox('', $lang['no_str_bar'], 'info');
}

if(!$metatags['title'])
	$metatags['title'] = $config['home'];
	
if($user_speedbar) 
	$speedbar = $user_speedbar;
else 
	$speedbar = $lang['welcome'];

$headers = '<title>'.$metatags['title'].'</title>
<meta name="generator" content="Onepuls" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
?>