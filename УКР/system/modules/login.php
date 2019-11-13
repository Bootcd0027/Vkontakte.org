<?php
/* 
	Appointment: Авторизация пользователей
	File: login.php 
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
	
$_IP = $db->safesql($_SERVER['REMOTE_ADDR']);
$_BROWSER = $db->safesql($_SERVER['HTTP_USER_AGENT']);

$check_refere = clean_url($_SERVER['HTTP_REFERER']);
$new_conurl = clean_url($config['home_url']);

//Если делаем выход
if(isset($_GET['act']) AND $_GET['act'] == 'logout'){
	set_cookie("user_id", "", 0);
	set_cookie("password", "", 0);
	set_cookie("hid", "", 0);
	unset($_SESSION['user_id']);
	@session_destroy();
	@session_unset();
	$logged = false;
	$user_info = array();
	header('Location: /');
	die();
}

//Если есть данные сесии
if(isset($_SESSION['user_id']) > 0){
	$logged = true;
	$logged_user_id = intval($_SESSION['user_id']);
	$user_info = $db->super_query("SELECT user_id, groups_num, user_email, user_group, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref, user_status, diz, alias, user_balance, balance_rub, user_privacy, user_delete_type, ask_num, podtv, hides, user_guests , user_last_visit, user_sms, user_audio_off, banner_cat FROM `".PREFIX."_users` WHERE user_id = '".$logged_user_id."'");

	//Если есть данные о сесии, но нет инфы о юзере, то выкидываем его
	if(!$user_info['user_id'])
		header('Location: /index.php?act=logout');

	//Если юзер нажимает "Главная" и он зашел не с моб версии. то скидываем на его стр.
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site AND $config['temp'] != 'mobile') {
		if ($user_info['short_link'] != null && $user_info['short_link'] != 'empty') {
			$link = '/' . $user_info['short_link'];
		} else {
			$link = '/news' . $news_link['news'];
		}
		header('Location: '.$link);
	}

//Если есть данные о COOKIE то проверяем
} elseif(isset($_COOKIE['user_id']) > 0 AND $_COOKIE['password'] AND $_COOKIE['hid']){
	$cookie_user_id = intval($_COOKIE['user_id']);
	$user_info = $db->super_query("SELECT user_id, groups_num, user_email, user_group, user_password, user_hid, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref, user_status, alias, ask_num, user_delete_type, podtv, hides, user_last_visit, user_guests, user_sms FROM `".PREFIX."_users` WHERE user_id = '".$cookie_user_id."'");
	
	//Если пароль и HID совпадает то пропускаем
	if($user_info['user_password'] == $_COOKIE['password'] AND $user_info['user_hid'] == $_COOKIE['password'].md5(md5($_IP))){
		$_SESSION['user_id'] = $user_info['user_id'];
		
		//Вставляем лог в бд
		$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$user_info['user_id']."'");
		
		//Удаляем все рание события
		$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$user_info['user_id']}'");
				
		$logged = true;
	} else {
		$user_info = array();
		$logged = false;
	}
	
	//Если юзер нажимает "Главная" и он зашел не с моб версии. то скидываем на его стр.
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site AND $config['temp'] != 'mobile')
		header('Location: /u'.$user_info['user_id']);
	
} else {
	$user_info = array();
	$logged = false;
}

//Если данные поступили через пост и пользователь не авторизован
if(isset($_POST['log_in']) AND !$logged){

	//Приготавливаем данные
	
		$email = $_POST['email'];
	
	if(preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email)) {
	$vxod = 'user_email';
	} else {
	$vxod = 'user_phone';
	}
	
	

	$password = md5(md5(GetVar($_POST['password'])));
	
	
		//Считаем кол-во символов в пароле и email
		if($email){
			$check_user = $db->super_query("SELECT user_id FROM `".PREFIX."_users` WHERE ".$vxod." = '".$email."' AND user_password = '".$password."'");
				
			//Если есть юзер то пропускаем
			if($check_user){
				//Hash ID
				$hid = $password.md5(md5($_IP));
					
				//Обновляем хэш входа
				$db->query("UPDATE `".PREFIX."_users` SET user_hid = '".$hid."' WHERE user_id = '".$check_user['user_id']."'");
					
				//Удаляем все рание события
				$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$check_user['user_id']}'");
	
				//Устанавливаем в сессию ИД юзера
				$_SESSION['user_id'] = intval($check_user['user_id']);
					
				//Записываем COOKIE
				set_cookie("user_id", intval($check_user['user_id']), 365);
				set_cookie("password", $password, 365);
				set_cookie("hid", $hid, 365);

				//Вставляем лог в бд
				$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$check_user['user_id']."'");
				
				header('Location: /u'.$check_user['user_id']);
			} else {
				msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore" onClick="Page.Go(this.href); return false">Забыли пароль?</a>', 'info_red');
				}
		} else {
			msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore" onClick="Page.Go(this.href); return false">Забыли пароль?</a>', 'info_red');
		}
}
?>