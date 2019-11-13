<?php
	$app_secret = ''; // Секретный код
	$app_id = ''; // ID приложения
	$uid = $_GET['uid'];
	$hash = $_GET['hash'];

if(!defined('MOZG'))
	die('Hacking attempt!');

	// Если пустой ид пользователя или хеш, или проверка хеша не прошла - выбрасываем ошибку

	if(empty($hash) or empty($uid) or $hash!=md5($app_id.$uid.$app_secret)) {
	    die('Ошибка авторизации!');

	} else {    // Если всё прошло хорошо - авторизуем пользователя

	    $first_name = $_GET['first_name'];
	    $last_name = $_GET['last_name'];
	    $photo = $_GET['photo'];
      	
		$user_info = $db->super_query("SELECT * FROM `".PREFIX."_users` WHERE user_vk = '".$uid."'"); // Проверяем зарегистрирован ли пользователь
        if($user_info){		// Пускаем, если зарегистрирован
			//Hash ID
				$hid = $password.md5(md5($_IP));
					
				//Обновляем хэш входа
				$db->query("UPDATE `".PREFIX."_users` SET user_hid = '".$hid."'  WHERE user_id = '".$user_info['user_id']."'");
				//Вставляем лог в бд
				$db->query("INSERT INTO `".PREFIX."_user_log` (uid, browser, ip, date) VALUES('".$check_user['user_id']."','".$_BROWSER."','".$_IP."','".$server_time."')");
			
				//Устанавливаем в сессию ИД юзера
				$_SESSION['user_id'] = intval($user_info['user_id']);
					
				//Записываем COOKIE
				set_cookie("user_id", intval($user_info['user_id']), 365);
				set_cookie("password", $hash, 365);
				set_cookie("hid", $hid, 365);

			
				header('Location: /id'.$user_info['user_id']);
		}else{ // Регистрируем и пускаем, если не зарегистрирован
			$md5_pass = $hash;
				$user_group = '5';				
			
       			//Hash ID
				$hid = $md5_pass.md5(md5($_IP));
				$db->query("INSERT INTO `".PREFIX."_users` ( user_vk, user_name, user_lastname, user_password, user_group, user_reg_date, user_lastdate, user_privacy, user_search_pref, user_balance, user_email) VALUES ('{$uid}', '{$first_name}', '{$last_name}', '{$md5_pass}', '5', '{$server_time}', '{$server_time}', 'val_msg|1||val_wall1|1||val_wall2|1||val_wall3|1||val_info|1||val_guests1|1||val_guests2|1||', '{$first_name} {$last_name}', '5', '0')");

				$id = $db->insert_id();

				//Устанавливаем в сессию ИД юзера
				$_SESSION['user_id'] = intval($id);

				//Записываем COOKIE
				set_cookie("user_id", intval($id), 365);
				set_cookie("password", md5(md5($hash)), 365);
				set_cookie("hid", $hid, 365);
				
				header('Location: /id'.$id);
		}

	}
?>