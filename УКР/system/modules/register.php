<?php
/* 
	Appointment: Завершение регистрации
	File: register.php 
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

//Проверяем была ли нажата кнопка, если нет, то делаем редирект на главную
if(!$logged){
	NoAjaxQuery();
	
	//Код безопасности
	$session_sec_code = $_SESSION['sec_code'];
	$sec_code = $_POST['sec_code'];

	//Если код введные юзером совпадает, то пропускаем, иначе выводим ошибку
	if($sec_code == $session_sec_code){
		//Входные POST Данные
		$user_name = ajax_utf8(textFilter(ucfirst($_POST['name']), false, true)); 
        $user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname']), false, true));
		$user_email = ajax_utf8(textFilter($_POST['email'], false, true));
		
		$user_name = ucfirst($user_name);
		$user_lastname = ucfirst($user_lastname);
		
		$user_sex = intval($_POST['sex']);
		if($user_sex < 0 OR $user_sex > 2) $user_sex = 0;
		
		$user_day = intval($_POST['day']);
		if($user_day < 0 OR $user_day > 31) $user_day = 0;
		
		$user_month = intval($_POST['month']);
		if($user_month < 0 OR $user_month > 12) $user_month = 0;
		
		$user_year = intval($_POST['year']);
		if($user_year < 1930 OR $user_year > 2007) $user_year = 0;
		
		$user_country = intval($_POST['country']);
		if($user_country < 0 OR $user_country > 10) $user_country = 0;
		
		$user_city = intval($_POST['city']);
		if($user_city < 0 OR $user_city > 1587) $user_city = 0;

		$type_profile = intval($_POST['type_profile']);
		if($type_profile < 0 OR $type_profile > 5) $user_city = 1;
		
		$_POST['password_first'] = ajax_utf8($_POST['password_first']);
		$_POST['password_second'] = ajax_utf8($_POST['password_second']);
		
		$password_first = GetVar($_POST['password_first']);
		$password_second = GetVar($_POST['password_second']);
		$user_birthday = $user_year.'-'.$user_month.'-'.$user_day;

		$errors = array();
		
		//Проверка имени
if(preg_match('#^[a-zа-яё0-9]+$#ui', $user_name) AND strlen($user_name) >= 2) $errors[] = 0;

//Проверка фамилии
if(preg_match('#^[a-zа-яё0-9]+$#ui', $user_lastname) AND strlen($user_lastname) >= 2) $errors[] = 0; 

		//Проверка E-mail
		if(preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $user_email)) $errors[] = 0;

		//Проверка Паролей
		if(strlen($password_first) >= 6 AND $password_first == $password_second) $errors[] = 0;

		$allEr = count($errors);

		//Если нет ошибок то пропускаем и добавляем в базу
		if($allEr == 4){
			$check_email = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_email = '{$user_email}'");
			if(!$check_email['cnt']){
				$md5_pass = md5(md5($password_first));
				$user_group = '5';
				
				if($user_country > 0 or $user_city > 0){
					$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_country."'");
					$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_city."'");
					
					$user_country_city_name = $country_info['name'].'|'.$city_info['name'];
				}
				
				$user_search_pref = $user_name.' '.$user_lastname;
				
				$mains = rand(10000,99999);
					
					$podtv = md5(md5($mains));
					
					$to  = $user_email;

					$subject = "Подтверждение аккаунта";

					$message = '
					<html>
						<head>
							<title>Подтверждение аккаунта</title>
						</head>
						<body>
						<table cellspacing="0" cellpadding="0" border="0" style="width: 674px;height: 226px;font-size: 12px;color: #6d6d6d;font-family: Arial;">
<tbody>
<tr>
<td style="height: 51px;background: #5989BA;font-size: 23px;padding: 5px 0 0 20px;color:#ffffff;font-weight:700;">onepuls.ru</td>
</tr>
<tr>
<td style="height: 5px;background: #ffffff;"/>
</tr>
<tr>
<td style="padding: 7px 18px 12px 20px;vertical-align: top;height: 100%;background: #f4f4f4;">
<span style="font-weight: 700;font-size: 16px;color:#2b2b2b;">Регистрация onepuls.ru</span>
<br/>
<span style="float: left;padding: 2px 0 0 2px;"/>
<span style="padding-top: 12px;float: left;font-size: 12px;clear:both;">
Здравствуйте. 
<br/>
 Вы, или кто-то другой заполнил регистрационую форму на сайте 
<a href="http://onepuls.ru" target="_blank">onepuls.ru</a>
, указав при этом Ваш e-mail.
<br/>
<br/>
 
<a href="http://onepuls.ru/?act=confirm&hid='.$podtv.'" target="_blank">
. 
<br/>
<br/>
 Для подтверждения регистрации нажмите тут. 
<br/>
</span>
</td>
</tr>
<tr>
<td height="6px" style="background: #ffffff;"/>
</tr>
<tr>
<td height="60px" style="background: #f4f4f4;padding: 1px 18px 0px 20px;font-size: 11px;">
В ином случае - проигнорируйте это сообщение.
<br/>
<br/>
Социальная сеть	
<a href="http://onepuls.ru" target="_blank">onepuls.ru</a>
</td>
</tr>
<tr>
<td style="height: 1px;background: #ffffff;"/>
</tr>
</tbody>
</table>
						</body>
					</html>';

					$headers  = "Content-type: text/html; charset= utf-8 \r\n";
					$headers .= "From: wellcome@onepuls.ru\r\n";
					$headers .= "Bcc: onepuls\r\n";

					mail($to, $subject, $message, $headers);
					
				
				//Hash ID
				$hid = $md5_pass.md5(md5($_IP));
				
				// Генерация секретного кода
                $rand = rand(1111, 9999);

				$db->query("INSERT INTO `".PREFIX."_users` (user_email, user_password, user_name, user_lastname, user_sex, user_day, user_month, user_year, user_country, user_city, user_reg_date, user_lastdate, user_group, user_hid, user_country_city_name, user_search_pref, user_birthday, user_privacy,podtv,hides) VALUES ('{$user_email}', '{$md5_pass}', '{$user_name}', '{$user_lastname}', '{$user_sex}', '{$user_day}', '{$user_month}', '{$user_year}', '{$user_country}', '{$user_city}', '{$server_time}', '{$server_time}', '{$user_group}', '{$hid}', '{$user_country_city_name}', '{$user_search_pref}', '{$user_birthday}', 'val_msg|1||val_friend|1||val_wall1|1||val_wall2|1||val_wall3|1||val_info|1||val_group|1||val_gifts|1||val_audios|1||val_sub|1||val_guests1|1||val_guests2|1||val_view|1||','{$podtv}','1')");
				$id = $db->insert_id();
				
				//Устанавливаем в сессию ИД юзера
				$_SESSION['user_id'] = intval($id);

				//Записываем COOKIE
				set_cookie("user_id", intval($id), 365);
				set_cookie("password", md5(md5($password_first)), 365);
				set_cookie("hid", $hid, 365);
				
				//Создаём папку юзера в кеше
				mozg_create_folder_cache("user_{$id}");
				
				//Директория юзеров
				$uploaddir = ROOT_DIR.'/uploads/users/';
	
				@mkdir($uploaddir.$id, 0777);
				@chmod($uploaddir.$id, 0777);
				@mkdir($uploaddir.$id.'/albums', 0777);
				@chmod($uploaddir.$id.'/albums', 0777);
				
				$to  = 'restore.onepuls@gmail.com';
$subject = "Зарегестрирован новый пользователь";
                    
$title_site = "Onepuls.ru";
$message = '
<html>
<head>
<title>Зарегестрирован новый пользователь</title>
</head>
<body>                        
<h1>'.$title_site.'</h1><br>
Имя: '.$user_name.' <br>
Фамилия: '.$user_lastname.' <br>
E-mail: '.$user_email.' <br>
Ссылка: http://onepuls.ru/u'.$id.' <br>
                        </body>
                    </html>';

                    $headers  = "Content-type: text/html; charset=utf8 \r\n";
                    $headers .= "support@onepuls.ru";                
                    mail($to, $subject, $message, $headers);

				//Отправляем письмо активации
				mail($user_email, "Добро пожаловать на {$_SERVER['HTTP_HOST']}", "Здравствуйте, {$user_name}!\nРады Вас видеть на {$_SERVER['HTTP_HOST']}.\n\n Для активации аккаунта перейдите по ссылке http://{$_SERVER['HTTP_HOST']}/?act=activate&account={$id} \n\n\nС уважением, Администрация {$_SERVER['HTTP_HOST']}", "From: admin@{$_SERVER['HTTP_HOST']}");
				
				//Если юзер регался по реф ссылки, то начисляем рефералу 10 убм
				if($_SESSION['ref_id']){
					//Проверям на накрутку убм, что юзер не сам регистрирует анкеты
					$check_ref = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_log` WHERE ip = '{$_IP}'");
					if(!$check_ref['cnt']){
						$ref_id = intval($_SESSION['ref_id']);
						
						//Даём рефералу +10 убм
						$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance+10 WHERE user_id = '{$ref_id}'");
						$db->query("INSERT INTO `".PREFIX."_history` SET user_id = '{$ref_id}', type = '2', price='10', status = '+', date = '{$server_time}'");
						$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_rate+10 WHERE user_id = '{$ref_id}'");
						//Записываем +1 в счетчик приглашеных
						$db->query("UPDATE `".PREFIX."_users` SET user_invites_num = user_invites_num+1 WHERE user_id = '{$ref_id}'");
						
						//Вставялем рефералу ид регистратора
						$db->query("INSERT INTO `".PREFIX."_invites` SET uid = '{$ref_id}', ruid = '{$id}'");
					}
				}

				//Вставляем лог в бд
				$db->query("INSERT INTO `".PREFIX."_log` SET uid = '{$id}', browser = '{$_BROWSER}', ip = '{$_IP}'");

				

				echo 'ok|'.$id;
			} else
				echo 'err_mail|';
		} else
			echo 'no_val';
	}
	die();
}
?>