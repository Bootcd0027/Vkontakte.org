<?php
/* 
	Appointment: Настройки
	File: settings.php 
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
    $user_id = $user_info['user_id'];
	$act = $_GET['act'];
	$metatags['title'] = $lang['settings'];

	switch($act){
	
	//Загрузка фотографии
		case "upload":
			NoAjaxQuery();
			
			//Подключаем класс для фотографий
			include ENGINE_DIR.'/classes/images.php';
			
			$user_id = $user_info['user_id'];
			$uploaddir = ROOT_DIR.'/uploads/doc_v';
			

			
			//Разришенные форматы
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
			
			//Получаем данные о фотографии
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			$image_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // имя фотографии
			$image_size = $_FILES['uploadfile']['size']; // размер файла
			$type = end(explode(".", $image_name)); // формат файла
			
			//Проверям если, формат верный то пропускаем
			if(in_array($type, $allowed_files)){
				if($image_size < 5000000){
					$res_type = '.'.$type;
					$uploaddir = ROOT_DIR.'/uploads/doc_v/'; // Директория куда загружать
					if(move_uploaded_file($image_tmp, $uploaddir.$image_rename.$res_type)) {

						//Создание оригинала
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto(770);
						$tmb->jpeg_quality(95);
						$tmb->save($uploaddir.'photo'.$image_rename.$res_type);

						$image_rename = $db->safesql($image_rename);
						$res_type = $db->safesql($res_type);

						//Добавляем в базу данных
						$db->query("INSERT INTO `".PREFIX."_verfication` SET url='uploads/doc_v/".$image_rename.$res_type."',uid = '{$user_id}', type='1', date = '{$server_time}'");
						
					
						echo $config['home_url'].'uploads/doc_v/'.$image_rename.$res_type;

					} else
						echo 'bad';
				} else
					echo 'big_size';
			} else
				echo 'bad_format';

			die();
		break;
		
case "audio_off":
                        
                                $db->query("UPDATE `".PREFIX."_users` SET user_audio_off = 0 WHERE user_id = '{$user_id}'");
                        
						
                break;

				case "audio_on":
                        
                                $db->query("UPDATE `".PREFIX."_users` SET user_audio_off = 1 WHERE user_id = '{$user_id}'");
                        
						
                break;
	
	//################### Установка алиаса ###################//
		case "alias":
			NoAjaxQuery();		
            $alias = ajax_utf8(strtolower(textFilter($_POST['alias'], false, true)));
           
 		    if(!preg_match("/^[a-zA-Z0-9_-]+$/", $alias)) $alias_ok = false;
			else $alias_ok = true;
			
			

		  if(preg_match("/^u/", $alias)) $alias_s_ok = false;
			else $alias_s_ok = true;
		  	
		
	
            if($alias_ok AND $alias_s_ok AND strlen($alias) > 4 or strlen($alias) == 0){
			
			$check_public = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE adres = '".$alias."' "); //Проверяем адреса у публичных страниц
			$chek_user = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE alias = '".$alias."' AND  user_id != '".$user_id."'"); // Проверяем адреса у пользователей
			
			if(!$check_public['cnt'] AND !$chek_user['cnt'] OR $alias == ''){
		    $db->query("UPDATE `".PREFIX."_users` SET alias = '".$alias."'  WHERE user_id = '".$user_id."'");
            echo 'ok_alias';
			}else {echo 'err_alias_name';}
			
			}else echo 'err_alias_str';

	
   		    mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
			mozg_clear_cache();
			die();
		break;
	
	    //################### Активация страницы ###################//
		case "activate":
            $activate = intval($_POST['activate']);
			if(!empty($activate))
            {
                $row = $db->super_query("SELECT user_code FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
                if($row['user_code'] == $activate)
                {
                    $row = $db->super_query("UPDATE `".PREFIX."_users` SET user_code='1' WHERE user_id = '{$user_id}'");
					mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					mozg_clear_cache();
                    echo '1';
                } else {
                    echo '2'; 
                }
            } else {
                echo '3';
            }   			
			die();
		break;
		
		//################### Изменение пароля ###################//
		case "newpass":
			NoAjaxQuery();
			
			$_POST['old_pass'] = ajax_utf8($_POST['old_pass']);
			$_POST['new_pass'] = ajax_utf8($_POST['new_pass']);
			$_POST['new_pass2'] = ajax_utf8($_POST['new_pass2']);
			
			$old_pass = md5(md5(GetVar($_POST['old_pass'])));
			$new_pass = md5(md5(GetVar($_POST['new_pass'])));
			$new_pass2 = md5(md5(GetVar($_POST['new_pass2'])));
			
			//Выводим текущий пароль
			$row = $db->super_query("SELECT user_password FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($row['user_password'] == $old_pass){
				if($new_pass == $new_pass2)
					$db->query("UPDATE `".PREFIX."_users` SET user_password = '{$new_pass2}' WHERE user_id = '{$user_id}'");
				else
					echo '2';
			} else
				echo '1';
			
			die();
		break;
		
		//################### Изменение имени ###################//
		case "newname":
			NoAjaxQuery();
			$user_name = ajax_utf8(textFilter($_POST['name']));
			$user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname'])));

			//Проверка имени
			if(isset($user_name)){
				if(strlen($user_name) >= 2){
					if(!preg_match("/^[a-zA-Zа-яА-Я-0-9]$/", $user_name))
						$errors = 3;
				} else
					$errors = 2;
			} else
				$errors = 1;
				
			//Проверка фамилии
			if(isset($user_lastname)){
				if(strlen($user_lastname) >= 2){
					if(!preg_match("/^[a-zA-Zа-я-А-Я-0-9]+$/", $user_lastname))
						$errors_lastname = 3;
				} else
					$errors_lastname = 2;
			} else
				$errors_lastname = 1;
			
			if(!$errors){
				if(!$errors_lastname){
					$user_name = ucfirst($user_name);
					$user_lastname = ucfirst($user_lastname);
					
					$db->query("UPDATE `".PREFIX."_users` SET user_name = '{$user_name}', user_lastname = '{$user_lastname}', user_search_pref = '{$user_name} {$user_lastname}', user_banname = '0' WHERE user_id = '{$user_id}'");
					
					mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					mozg_clear_cache();
				} else
					echo $errors;
			} else
				echo $errors;
			
			die();
		break;
		
		//################### Сохранение настроек приватности ###################//
		case "saveprivacy":
			NoAjaxQuery();
			
			$val_msg = intval($_POST['val_msg']);
			$val_friend = intval($_POST['val_friend']);
			$val_wall1 = intval($_POST['val_wall1']);
			$val_wall2 = intval($_POST['val_wall2']);
			$val_wall3 = intval($_POST['val_wall3']);
			$val_info = intval($_POST['val_info']);
			$val_group = intval($_POST['val_group']);
			$val_gifts = intval($_POST['val_gifts']);
			$val_audios = intval($_POST['val_audios']);
			$val_sub = intval($_POST['val_sub']);
			$val_guests1 = intval($_POST['val_guests1']);
            $val_guests2 = intval($_POST['val_guests2']);	
			$val_view = intval($_POST['val_view']);
			
			if($val_msg <= 0 OR $val_msg > 3) $val_msg = 1;
			if($val_friend <= 0 OR $val_friend > 3) $val_friend = 1;
			if($val_wall1 <= 0 OR $val_wall1 > 3) $val_wall1 = 1;
			if($val_wall2 <= 0 OR $val_wall2 > 3) $val_wall2 = 1;
			if($val_wall3 <= 0 OR $val_wall3 > 3) $val_wall3 = 1;
			if($val_info <= 0 OR $val_info > 3) $val_info = 1;
			if($val_group <= 0 OR $val_group > 3) $val_group = 1;
			if($val_gifts <= 0 OR $val_gifts > 3) $val_gifts = 1;
			if($val_audios <= 0 OR $val_audios > 3) $val_audios = 1;
			if($val_sub <= 0 OR $val_sub > 3) $val_sub = 1;
			if($val_guests1 <= 0 OR $val_guests1 > 3) $val_guests1 = 1;
            if($val_guests2 <= 0 OR $val_guests2 > 3) $val_guests2 = 1;
			if($val_view <= 0 OR $val_view > 3) $val_view = 1;
			
			
			$user_privacy = "val_msg|{$val_msg}||val_friend|{$val_friend}||val_wall1|{$val_wall1}||val_wall2|{$val_wall2}||val_wall3|{$val_wall3}||val_info|{$val_info}||val_group|{$val_group}||val_gifts|{$val_gifts}||val_audios|{$val_audios}||val_sub|{$val_sub}||val_guests1|{$val_guests1}||val_guests2|{$val_guests2}||val_view|{$val_view}||";
			
			$db->query("UPDATE `".PREFIX."_users` SET user_privacy = '{$user_privacy}' WHERE user_id = '{$user_id}'");
			
			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
			
			die();
		break;
		
		//################### Приватность настройки ###################//
		case "privacy":
			$sql_ = $db->super_query("SELECT user_privacy FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$row = xfieldsdataload($sql_['user_privacy']);
			$tpl->load_template('settings/privacy.tpl');
			$tpl->set('{val_msg}', $row['val_msg']);
			$tpl->set('{val_msg_text}', strtr($row['val_msg'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Никто')));
			$tpl->set('{val_friend}', $row['val_friend']);
			$tpl->set('{val_friend_text}', strtr($row['val_friend'], array('1' => 'От всех пользователей', '2' => 'От друзей друзей', '3' => 'Ни от кого')));
			$tpl->set('{val_wall1}', $row['val_wall1']);
			$tpl->set('{val_wall1_text}', strtr($row['val_wall1'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_wall2}', $row['val_wall2']);
			$tpl->set('{val_wall2_text}', strtr($row['val_wall2'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_wall3}', $row['val_wall3']);
			$tpl->set('{val_wall3_text}', strtr($row['val_wall3'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_info}', $row['val_info']);
			$tpl->set('{val_info_text}', strtr($row['val_info'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_group}', $row['val_group']);
			$tpl->set('{val_group_text}', strtr($row['val_group'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_gifts}', $row['val_gifts']);
			$tpl->set('{val_gifts_text}', strtr($row['val_gifts'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_audios}', $row['val_audios']);
			$tpl->set('{val_audios_text}', strtr($row['val_audios'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_sub}', $row['val_sub']);
			$tpl->set('{val_sub_text}', strtr($row['val_sub'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_guests1}', $row['val_guests1']);
			$tpl->set('{val_guests1_text}', strtr($row['val_guests1'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
            $tpl->set('{val_guests2}', $row['val_guests2']);
			$tpl->set('{val_guests2_text}', strtr($row['val_guests2'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_view}', $row['val_view']);
			$tpl->set('{val_view_text}', strtr($row['val_view'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->compile('info');
		break;
		
		//################### Добавление в черный список ###################//
		case "addblacklist":
			NoAjaxQuery();
			$bad_user_id = intval($_POST['bad_user_id']);
			
			//Проверяем на существование юзера
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$bad_user_id}'");

			//Выводим свой блеклист для проверка
			$myRow = $db->super_query("SELECT user_blacklist FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$array_blacklist = explode('|', $myRow['user_blacklist']);

			if($row['cnt'] AND !in_array($bad_user_id, $array_blacklist) AND $user_id != $bad_user_id){
				$db->query("UPDATE `".PREFIX."_users` SET user_blacklist_num = user_blacklist_num+1, user_blacklist = '{$myRow['user_blacklist']}|{$bad_user_id}|' WHERE user_id = '{$user_id}'");
				
				//Если юзер есть в др.
				if(CheckFriends($bad_user_id)){
					//Удаляем друга из таблицы друзей
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$bad_user_id}' AND subscriptions = 0");
					
					//Удаляем у друга из таблицы
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$bad_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 0");
					
					//Обновляем кол-друзей у юзера
					$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$user_id}'");
					
					//Обновляем у друга которого удаляем кол-во друзей
					$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$bad_user_id}'");
					
					//Чистим кеш владельцу стр и тому кого удаляем из др.
					mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					mozg_clear_cache_file('user_'.$bad_user_id.'/profile_'.$bad_user_id);
					
					//Удаляем пользователя из кеш файл друзей
					$openMyList = mozg_cache("user_{$user_id}/friends");
					mozg_create_cache("user_{$user_id}/friends", str_replace("u{$bad_user_id}|", "", $openMyList));
					
					$openTakeList = mozg_cache("user_{$bad_user_id}/friends");
					mozg_create_cache("user_{$bad_user_id}/friends", str_replace("u{$user_id}|", "", $openTakeList));
				}
				
				$openMyList = mozg_cache("user_{$user_id}/blacklist");
				mozg_create_cache("user_{$user_id}/blacklist", $openMyList."|{$bad_user_id}|");
			}
			
			die();
		break;
		
		//################### Удаление из черного списка ###################//
		case "delblacklist":
			NoAjaxQuery();
			$bad_user_id = intval($_POST['bad_user_id']);
			
			//Проверяем на существование юзера
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$bad_user_id}'");

			//Выводим свой блеклист для проверка
			$myRow = $db->super_query("SELECT user_blacklist FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$array_blacklist = explode('|', $myRow['user_blacklist']);

			if($row['cnt'] AND in_array($bad_user_id, $array_blacklist) AND $user_id != $bad_user_id){
				$myRow['user_blacklist'] = str_replace("|{$bad_user_id}|", "", $myRow['user_blacklist']);
				$db->query("UPDATE `".PREFIX."_users` SET user_blacklist_num = user_blacklist_num-1, user_blacklist = '{$myRow['user_blacklist']}' WHERE user_id = '{$user_id}'");
				
				$openMyList = mozg_cache("user_{$user_id}/blacklist");
				mozg_create_cache("user_{$user_id}/blacklist", str_replace("|{$bad_user_id}|", "", $openMyList));
			}
			
			die();
		break;
		
		//################### Черный список ###################//
		case "blacklist":
			$row = $db->super_query("SELECT user_blacklist, user_blacklist_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('settings/blacklist.tpl');
			$tpl->set('{cnt}', '<span id="badlistnum">'.$row['user_blacklist_num'].'</span> '.gram_record($row['user_blacklist_num'], 'fave'));
			if($row['user_blacklist_num']){
				$tpl->set('[yes-users]', '');
				$tpl->set('[/yes-users]', '');
			} else
				$tpl->set_block("'\\[yes-users\\](.*?)\\[/yes-users\\]'si","");
			$tpl->compile('info');
			
			if($row['user_blacklist_num'] AND $row['user_blacklist_num'] <= 100){
				$tpl->load_template('settings/baduser.tpl');
				$array_blacklist = explode('|', $row['user_blacklist']);
				foreach($array_blacklist as $user){
					if($user){
						$infoUser = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user}'");
						
						if($infoUser['user_photo'])
							$tpl->set('{ava}', '/uploads/users/'.$user.'/50_'.$infoUser['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						
						$tpl->set('{name}', $infoUser['user_search_pref']);
						$tpl->set('{user-id}', $user);
						
						$tpl->compile('content');
					}
				}
			} else
				msgbox('', $lang['settings_nobaduser'], 'info_2');
		break;
		
		//################### Бан до смены имени ###################//
		case "banname":
			$row = $db->super_query("SELECT user_name, user_lastname, user_banname FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('settings/banname.tpl');
		if($row['user_banname'] == 1){
$tpl->set('{name}', $row['user_name']);
			$tpl->set('{lastname}', $row['user_lastname']);
			$tpl->set('{id}', $user_id);
			$tpl->set('[banname]', '');
			$tpl->set('[/banname]', '');
		} else {
			$tpl->set_block("'\\[banname\\](.*?)\\[/bannames\\]'si","");
			header('Location: /messages');
		}
			
$tpl->compile('info');
		break;


		//################### Удаление пользователя ###################//
		//case "delete"://
		//$sql_delete = $db->super_query("UPDATE `".PREFIX."_users` SET user_delet = user_delet+1 WHERE user_id = '{$user_id}'");//
		//Download tpl
		//$tpl->load_template('settings/delete.tpl');//
		
		//$tpl->compile('info');//
		
		//break;//

		//################### Смена e-mail ###################//
		case "change_mail":
		
			//Отправляем письмо на обе почты
			include_once ENGINE_DIR.'/classes/mail.php';
			$mail = new dle_mail($config);
			
			$email = textFilter($_POST['email'], false, true);
			
			//Проверка E-mail
			if(preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $email)) $ok_email = true;
			else $ok_email = false;
				
			$row = $db->super_query("SELECT user_email FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$check_email = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_email = '{$email}'");
			
			if($row['user_email'] AND $ok_email AND !$check_email['cnt']){
				
				//Удаляем все пред. заявки
				$db->query("DELETE FROM `".PREFIX."_restore` WHERE email = '{$email}'");
				
				$salt = "abchefghjkmnpqrstuvwxyz0123456789";
				for($i = 0; $i < 15; $i++){
					$rand_lost .= $salt{rand(0, 33)};
				}
				$hash = md5($server_time.$row['user_email'].rand(0, 100000).$rand_lost);
						
				$message = <<<HTML
Вы получили это письмо, так как зарегистрированы на сайте
{$config['home_url']} и хотите изменить основной почтовый адрес.
Вы желаете изменить почтовый адрес с текущего ({$row['user_email']}) на {$email}
Для того чтобы Ваш основной e-mail на сайте {$config['home_url']} был
изменен, Вам необходимо пройти по ссылке:
{$config['home_url']}index.php?go=settings&code2={$hash}

Внимание: не забудьте, что после изменения почтового адреса при входе
на сайт Вам нужно будет указывать новый адрес электронной почты.

Если Вы не посылали запрос на изменение почтового адреса,
проигнорируйте это письмо.С уважением,
Администрация {$config['home_url']}
HTML;
				$mail->send($email, 'Изменение почтового адреса', $message);
				
				//Вставляем в БД код 2
				$db->query("INSERT INTO `".PREFIX."_restore` SET email = '{$email}', hash = '{$hash}', ip = '{$_IP}'");
			
			} else
				echo '1';
			
			exit;
			
		break;
		
//################### Окошко с историей заходов ###################//		
		case"userlogs":
		
			$sql_ = $db->super_query("SELECT uid, browser, ip, date FROM `".PREFIX."_user_log` WHERE uid='{$user_id}' ORDER BY date DESC LIMIT 10",1);		
			foreach($sql_ as $sqls){
				if(date('Y-m-d', $sqls['date']) == date('Y-m-d', $server_time))
					$dateTell = langdate('сегодня в H:i', $sqls['date']);
				elseif(date('Y-m-d', $sqls['date']) == date('Y-m-d', ($server_time-84600)))
					$dateTell = langdate('вчера в H:i',$sqls['date']);
				else
	$dateTell = langdate('j F Y в H:i', $sqls['date']);
if(stripos($sqls['browser'], 'Chrome') !== false){
	$browser = explode('Chrom', $sqls['browser']);
	$browser2 = explode(' ', 'Chrom'.str_replace('/', ' ', $browser[1]));
	$browser[0] = $browser2[0].' '.$browser2[1];
} elseif(stripos($sqls['browser'], 'Opera') !== false){
	$browser2 = explode('/', $sqls['browser']);
	$browser3 = end(explode('/', $sqls['browser']));
	$browser[0] = $browser2[0].' '.$browser3;
} elseif(stripos($sqls['browser'], 'Firefox') !== false){
	$browser3 = end(explode('/', $sqls['browser']));
	$browser[0] = 'Firefox '.$browser3;
} elseif(stripos($sqls['browser'], 'Safari') !== false){
	$browser3 = end(explode('Version/', $sqls['browser']));
	$browser4 = explode(' ', $browser3);
	$browser[0] = 'Safari '.$browser4[0];
	}

	$ip =  $sqls['ip'];
	$pageip=file_get_contents('http://ip-whois.net/ip_geo.php?ip='.$ip);
	preg_match_all("/Страна: (.*)<br>/i", $pageip, $matches);
	unset($pageip);
					
		
	$logs .=  '<tr class=""><td><span class="browser_info">Браузер '.$browser[0].'</span></td><td>'.$dateTell.'</td><td>'.$matches[1][1].'('.$sqls['ip'].')</td></tr>';

			}
			
			echo '
			<div class="err_yellow  pass_errors" style="font-size:11px;padding: 8px;">
			<b>История активности</b>
показывает информацию о том, в какое время
и с каких устройств производилась авторизация на Ваш профиль. 
			</div>
			<table id="activityHistory" class="history" width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th>Тип доступа</th>
			<th>Время</th>
			<th>IP-адрес</th>
			</tr>
			'.$logs.'
			</table>
			';
		exit;
		break;

		
		//################### Удаление страницы ###################//
		case "deactive":
			
			$spBar = true;
			$user_speedbar = 'Удаление страницы';
			
			$tpl->load_template('settings/deactive.tpl');
			
			$tpl->compile('info');
			
		break;
		
		//################### Оповещения ###################//
		case "notify":
		
			$row = $db->super_query("SELECT notify FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");

			$tpl->load_template('settings/notify.tpl');
						
			$block_data = xfieldsdataload($row['notify']);
			
			$arrlist = array('n_friends', 'n_wall', 'n_comm', 'n_comm_ph', 'n_comm_note', 'n_gifts', 'n_rec', 'n_im');
			
			foreach($arrlist as $p){
				
				if($block_data[$p]) $tpl->set("{{$p}}", $p);
				else $tpl->set("{{$p}}", "0");
				
			}
			
				if($user_info['user_audio_off'] == 1){
$tpl->set('{user_audio_off_button}', '<div class="mgclr"></div>
<div class="button_div fl_l"><button onClick="settings.audio_off(); return false">Выключить звуковые оповещения</button></div><div class="mgclr"></div>');
} else {
$tpl->set('{user_audio_off_button}', '<div class="mgclr"></div>
<div class="button_div fl_l"><button onClick="settings.audio_on(); return false">Включить звуковые оповещения</button></div><div class="mgclr"></div>');
}	
			
			$tpl->compile('info');
			
		break;
		
		//################### Сохранение настроек оповещений ###################//
		case "save_notify":
			
			NoAjaxQuery();

			$arrlist = array('n_friends', 'n_wall', 'n_comm', 'n_comm_ph', 'n_comm_note', 'n_gifts', 'n_rec', 'n_im');
			
			foreach($arrlist as $p){
				
				$rCache .= "{$p}|".intval($_POST[$p])."||";
				
			}
			
			$rCache = $db->safesql($rCache);
			
			$db->query("UPDATE `".PREFIX."_users` SET notify = '{$rCache}' WHERE user_id = '{$user_id}'");
			
			exit();
			
		break;
		
		//################### Удаление страницы ###################//
		case "deactivego":
			NoAjaxQuery();
			
			$reason = ajax_utf8(textFilter($_POST['reason']));
			$type = intval($_POST['type']);
			$nfriends = intval($_POST['nfriends']);
			
			$row = $db->super_query("SELECT user_delete_type,user_ban,user_delet FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if($row and $row['user_delete_type'] == 0) {
				if($row['user_ban'] == 0 and $row['user_delet'] == 0) {
					$db->query("UPDATE `".PREFIX."_users` SET user_delete_type = '{$type}', user_delete_reason = '{$reason}', user_delete_date = '{$server_time}' WHERE user_id = '{$user_id}'");
					if($nfriends != 0) {
						$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = 'Я удалил свою страницу, поздравьте меня!<br>{$reason}', add_date = '{$server_time}', fast_comm_id = '0'");
						$dbid = $db->insert_id();
						$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = 'Я удалил свою страницу, поздравьте меня!<br>{$reason}', obj_id = '{$dbid}', action_time = '{$server_time}'");
					}
					echo "ok";
				} else echo "already_delete";
			} else echo "already_delete";
			
			die();
		break;
		
		case "function":
			
			$row = $db->super_query("SELECT user_vip FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$obshenie = $db->super_query("SELECT id FROM `".PREFIX."_obshenie` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('settings/function.tpl');
			
			if($row['user_vip']==1) $tpl->set('{vip_offline}','button_div_gray');
			else $tpl->set('{vip_offline}','');
			
			if($obshenie) $tpl->set('{obshenie_offline}','button_div_gray');
			else $tpl->set('{obshenie_offline}','');
			
			$tpl->compile('info');
			
			
		break;
		
		case "addvip":
			
			$row = $db->super_query("SELECT user_vip,user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if($row['user_vip']!=1 and $row['user_balance']>=10) {
				$db->query("UPDATE `".PREFIX."_users` SET user_vip = 1, user_balance = user_balance-10 WHERE user_id = '{$user_id}'");
			} elseif($row['user_balance']<10) echo "n_money";
			else echo "now_vip";
			
		break;
		
		case "addobshenie":
			
			$text = ajax_utf8(textFilter($_POST['text']));
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$obshenie = $db->super_query("SELECT id FROM `".PREFIX."_obshenie` WHERE user_id = '{$user_id}'");
			
			if(!$obshenie and $row['user_balance']>=10) {
				$db->query("INSERT INTO `".PREFIX."_obshenie` (user_id,text,date) values('".$user_id."','".$text."','".$server_time."')");
			} elseif($row['user_balance']<10) echo "n_money";
			else echo "now_vip";
			
		break;
		
		
				default:
				
			  //################### Общие настройки ###################//
			  $mobile_speedbar = 'Общие настройки';
			$row = $db->super_query("SELECT user_name, user_rate, alias, user_lastname, user_email, user_banname, user_phone FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$ver = $db->super_query("SELECT type, uid, date FROM `".PREFIX."_verfication` WHERE uid = '{$user_id}'");
			$sqls = $db->super_query("SELECT uid, browser, ip, date FROM `".PREFIX."_user_log` WHERE uid='{$user_id}' ORDER BY date DESC LIMIT 1");
			
			if(date('Y-m-d', $sqls['date']) == date('Y-m-d', $server_time))
$dateTell = langdate('сегодня в H:i', $sqls['date']);
elseif(date('Y-m-d', $sqls['date']) == date('Y-m-d', ($server_time-84600)))
$dateTell = langdate('вчера в H:i',$sqls['date']);
else
$dateTell = langdate('j F Y в H:i', $sqls['date']);
if(stripos($sqls['browser'], 'Chrome') !== false){
$browser = explode('Chrom', $sqls['browser']);
$browser2 = explode(' ', 'Chrom'.str_replace('/', ' ', $browser[1]));
$browser[0] = $browser2[0].' '.$browser2[1];
} elseif(stripos($sqls['browser'], 'Opera') !== false){
$browser2 = explode('/', $sqls['browser']);
$browser3 = end(explode('/', $sqls['browser']));
$browser[0] = $browser2[0].' '.$browser3;
} elseif(stripos($sqls['browser'], 'Firefox') !== false){
$browser3 = end(explode('/', $sqls['browser']));
$browser[0] = 'Firefox '.$browser3;
} elseif(stripos($sqls['browser'], 'Safari') !== false){
$browser3 = end(explode('Version/', $sqls['browser']));
$browser4 = explode(' ', $browser3);
$browser[0] = 'Safari '.$browser4[0];
}	
$tpl->set('{ip}', $sqls['ip']);
$tpl->set('{log-user}', $dateTell.' Браузер ('.$browser[0].')');


//Привязка страницы VK
		if($row['user_vk']){
			$tpl->set('{statusvk}', 'Привязана');
			$tpl->set('{linkvk}', $row['user_vk']);
			$tpl->set('[yes-vk]', '');
			$tpl->set('[/yes-vk]', '');
			$tpl->set_block("'\\[no-vk\\](.*?)\\[/no-vk\\]'si","");
		} else {
			$tpl->set('{statusvk}', 'Не привязана');
			$tpl->set('{linkvk}', '');
			$tpl->set('[no-vk]', '');
			$tpl->set('[/no-vk]', '');		
			$tpl->set_block("'\\[yes-vk\\](.*?)\\[/yes-vk\\]'si","");
		}

			//Загружаем вверх
			$tpl->load_template('settings/general.tpl');
			if($ver){
			if($ver['type']==1){$tpl->set('{verification-type}', '<div class="item_err">Ваша заявка находится на рассмотрении.</div>');$tpl->set('{verification-button}', '');}
			if($ver['type']==2){$tpl->set('{verification-type}', '<div class="item_err">Ваша заявка была отклонена. Измените данные вашей страницы и напишите в поддержку, с запросом на повторную заявку.</div>');$tpl->set('{verification-button}', '');}
			if($ver['type']==3){$tpl->set('{verification-type}', '<div class="item_err">Ваша заявка была одобрена, страница подтверждена.</div>');$tpl->set('{verification-button}', '');}					
			}else{
			$tpl->set('{verification-type}', '<div class="item_info">Вы можете отправить заявку на верификацию вашей страницы. Но внимательно прочтите эти правила: На вашей странице должна быть указана дата вашего рождения, место проживания, реальное имя, реальное фото. Если все соблюдено, то вы можете отправить нам заявку. Загрузите в форму ниже ваше фото на фоне страницы Onepuls, либо фото последней страницы паспорта.</div>');
			$tpl->set('{verification-button}', '<div class="load_photo_but"><div class="button_div fl_l"><button id="upload">Выбрать фотографию</button></div></div>');			
			}
			$tpl->set('{name}', $row['user_name']);
			$tpl->set('{lastname}', $row['user_lastname']);
			$tpl->set('{id}', $user_id);
			$tpl->set('{rate}', $row['user_rate']);
			$tpl->set('{phone}', $row['user_phone']);
			if($row['alias'])$tpl->set('{alias}',$row['alias']); else $tpl->set('{alias}','u'.$user_id);
			
								//Советуем подписаться
			$gr_list = $config['gr_list'];
			
			$sql_gr = $db->super_query("SELECT id, photo, title, ulist, traf, adres FROM `".PREFIX."_communities` WHERE id IN({$gr_list})", 1);
			
			foreach($sql_gr as $row_gr){
				
				$row_gr['title'] = stripslashes($row_gr['title']);
				$row_gr['traf'] = $row_gr['traf'].' '.gram_record($row_gr['traf'], 'groups_users');
				
				if($row_gr['photo']) $row_gr['photo'] = "/uploads/groups/{$row_gr['id']}/100_{$row_gr['photo']}";
				else $row_gr['photo'] = "{theme}/images/no_ava_groups_100.gif";
				
				if($row_gr['adres']) $row_gr['adres'] = $row_gr['adres'];
				else $row_gr['adres'] = 'public'.$row_gr['id'];
				
				if(stripos($row_gr['ulist'], "|{$user_id}|") === false) $grlink = '<a href="/groups" onClick="fastLOGIN('.$row_gr['id'].'); return false" id="gr'.$row_gr['id'].'"><div>Подписаться</div></a>';
				else $grlink = '<div class="button_div fl_l"><button href="/groups" onClick="fastEXIT('.$row_gr['id'].'); return false" id="gr'.$row_gr['id'].'">Отписаться</button></div>';
						
				$pages .= <<<HTML
<div class="friends_gr_link width_100">
 <a href="/{$row_gr['adres']}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><img src="{$row_gr['photo']}" /></div></a>
 <div class="fl_l" style="width:500px">
  <a href="/{$row_gr['adres']}" onClick="Page.Go(this.href); return false"><b>{$row_gr['title']}</b></a><div class="friends_clr"></div>
  <span class="color777">{$row_gr['traf']}</span><div class="friends_clr"></div>
 </div>
 <div class="menuleft_gr_link fl_r friends_m">
  <div id="exitlink{id}">{$grlink}</div>
 </div>
</div> 
HTML;
				
			}
			
			$tpl->set('{pages}', $pages);

            //Завершении смены E-mail
			$tpl->set('{code-1}', 'no_display');
			$tpl->set('{code-2}', 'no_display');
			$tpl->set('{code-3}', 'no_display');
			
			$code1 = strip_data($_GET['code1']);
			$code2 = strip_data($_GET['code2']);
			
			if(strlen($code1) == 32){
				
				$code2 = '';
				
				$check_code1 = $db->super_query("SELECT email FROM `".PREFIX."_restore` WHERE hash = '{$code1}' AND ip = '{$_IP}'");

				if($check_code1['email']){
					
					$check_code2 = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_restore` WHERE hash != '{$code1}' AND email = '{$check_code1['email']}' AND ip = '{$_IP}'");
					
					if($check_code2['cnt'])
						$tpl->set('{code-1}', '');
					else {
						$tpl->set('{code-1}', 'no_display');
						$tpl->set('{code-3}', '');
						
						//Меняем
						$db->query("UPDATE `".PREFIX."_users` SET user_email = '{$check_code1['email']}' WHERE user_id = '{$user_id}'");
							
						$row['user_email'] = $check_code1['email'];
							
					}
					
					$db->query("DELETE FROM `".PREFIX."_restore` WHERE hash = '{$code1}' AND ip = '{$_IP}'");
					
				}
			
			}
			
			if(strlen($code2) == 32){
$check_code2 = $db->super_query("SELECT email FROM `".PREFIX."_restore` WHERE hash = '{$code2}' AND ip = '{$_IP}'");

				if($check_code2['email']){
				
					$check_code1 = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_restore` WHERE hash != '{$code2}' AND email = '{$check_code2['email']}' AND ip = '{$_IP}'");
					
					if($check_code1['cnt'])
						$tpl->set('{code-2}', '');
					else {
						$tpl->set('{code-2}', 'no_display');
						$tpl->set('{code-3}', '');
						
						//Меняем
						$db->query("UPDATE `".PREFIX."_users` SET user_email = '{$check_code1['email']}' WHERE user_id = '{$user_id}'");
						
						$row['user_email'] = $check_code2['email'];
						
					}
					
					$db->query("DELETE FROM `".PREFIX."_restore` WHERE hash = '{$code2}' AND ip = '{$_IP}'");
					
				}
			
			}
			
			if($user_info['diz']==1)
    $tpl->set_block("'\\[diz\\](.*?)\\[/diz\\]'si","");
   else{ 
    $tpl->set('[diz]','');
    $tpl->set('[/diz]','');
   }
if($user_info['diz']==2)
 $tpl->set_block("'\\[diz2\\](.*?)\\[/diz2\\]'si","");
 
 else 
  $tpl->set('[diz2]','');
 $tpl->set('[/diz2]','');
			
			//Email
			$substre = substr($row['user_email'], 0, 1);
			$epx1 = explode('@', $row['user_email']);
			$tpl->set('{email}', $substre.'*******@'.$epx1[1]);
	
			$tpl->compile('info');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}

?>