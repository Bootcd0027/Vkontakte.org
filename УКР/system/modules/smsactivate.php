<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();


	$act = $_GET['act'];
	
	$apikey = 'PV541657ETO71UB1E59OU63706V8G23932649V6VCEXXRMO502O1885CD622SZ11';
	
	
	
	
	switch($act){
	
	
	
		 case "window": 	
	$tpl->load_template('sms/window.tpl');
	$tpl->compile('content');
	AjaxTpl();
		die();
		$tpl->clear();
		$db->free();
  break;
  
  
  case "resms":
			NoAjaxQuery();
		
			
			include ENGINE_DIR.'/classes/smspilot.class.php';

// Отправки SMS и заодно проверка баланса
$phone_test = $db->super_query("SELECT user_phone FROM `".PREFIX."_users` WHERE user_phone = '".$_POST['number']."'");
$count = strlen($_POST['number']);
if($count > 6) {
if(!$phone_test) {
	
	
	$sms = new SMSPilot( $apikey );
	
	$sms->from = $_POST['from'];
	
	$mains = rand(10000, 99999);
	
	$db->query("UPDATE `".PREFIX."_users` SET user_sms_hash = '{$mains}' WHERE user_id = '{$user_info['user_id']}'");
	
	$sms->send($_POST['number'], $mains);
	
	echo "1";	
} else {
	echo "2";	
}	
}		

			die();
		break;
		
		
		
  

		
		
		
		case "recheck":
			NoAjaxQuery();
		
			
			$phone = $_POST['number'];		

// Отправки SMS и заодно проверка баланса
$test = $db->super_query("SELECT user_sms_hash FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."' AND user_sms_hash = '".$_POST['code']."'");

if($test) {
	
	$db->query("UPDATE `".PREFIX."_users` SET user_phone = '{$phone}', user_sms = '1' WHERE user_id = '{$user_info['user_id']}'");
	
	mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
	mozg_clear_cache();
			
	echo "/setting";	
} else 
	echo "0";	
			

			die();
		break;
	
	
		case "send":
			NoAjaxQuery();
		
			
			include ENGINE_DIR.'/classes/smspilot.class.php';

// Отправки SMS и заодно проверка баланса
$phone_test = $db->super_query("SELECT user_phone FROM `".PREFIX."_users` WHERE user_phone = '".$_POST['number']."'");
$count = strlen($_POST['number']);
if($count > 6) {
if(!$phone_test) {
	
	
	$sms = new SMSPilot( $apikey );
	
	$sms->from = $_POST['from'];
	
	$mains = rand(10000, 99999);
	
	$db->query("UPDATE `".PREFIX."_users` SET user_sms_hash = '{$mains}' WHERE user_id = '{$user_info['user_id']}'");
	
	$sms->send($_POST['number'], $mains);
	
	echo "1";	
} else {
	echo "2";	
}
}			

			die();
		break;
		
		
		case "check":
			NoAjaxQuery();
		
		$phone = $_POST['number'];	
			

// Отправки SMS и заодно проверка баланса
$test = $db->super_query("SELECT user_sms_hash FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."' AND user_sms_hash = '".$_POST['code']."'");

if($test) {
	
	$db->query("UPDATE `".PREFIX."_users` SET user_phone = '{$phone}', user_sms = '1' WHERE user_id = '{$user_info['user_id']}'");
	
	mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
	mozg_clear_cache();
			
	echo "/u".$user_info['user_id']."";	
} else 
	echo "0";	
			

			die();
		break;
		
		
		
	

  case "newpass":
			NoAjaxQuery();
		
			
			include ENGINE_DIR.'/classes/smspilot.class.php';

// Отправки SMS и заодно проверка баланса
$phone_test = $db->super_query("SELECT user_id FROM `".PREFIX."_users` WHERE user_phone = '".$_POST['number']."'");

$count = strlen($_POST['number']);
if($count > 6) {
if($phone_test) {
	
	
	$sms = new SMSPilot( $apikey );
	
	$sms->from = $_POST['from'];
	
	$mains = rand(10000, 99999);
	
	
	$md5_pass = md5(md5($mains));
	
	$db->query("UPDATE `".PREFIX."_users` SET user_password = '{$md5_pass}' WHERE user_phone = '{$_POST['number']}'");
	
	$password = 'Это новый пароль от Вашей страницы Onepuls:'.$mains;
	$sms->send($_POST['number'], $password);
	
	
	echo "1";	
} else {
	echo "2";	
}
}	
		

			die();
		break;


	default:
			
			
	}
?>