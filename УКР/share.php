<?php
/*
        Appointment: Поделиться
        File: share.php

*/
@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');

header('Content-type: text/html; charset=windows-1251');

include ENGINE_DIR.'/init.php';

//Проверяем, авторизован ли пользователь в соц. сети
if($user_info['user_id']){

NoAjaxQuery();
                        $user_id = intval($user_info['user_id']);


                        //Подключаем парсер
                        include ENGINE_DIR.'/classes/parse.php';
                        $parse = new parse();

                        $title = ajax_utf8(textFilter($_GET['title'], false, true));
                        $text = $parse->BBparse(ajax_utf8(textFilter($_GET['url'])));

                        if(strlen($title) > 0 && strlen($text) > 0){
							$myRow = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE text = '{$title}<br>{$text}' AND author_user_id = '{$user_id}'");
							if(!$myRow['cnt']){							
								$str_date = time();
								$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$title}<br>{$text}', add_date = '{$str_date}', fast_comm_id = '0'");
								$db_id = $db->insert_id();

								$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
                               
							   //echo $db_id;

                                //Добавляем действия в ленту новостей
								$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$title}<br>{$text}', obj_id = '{$db_id}', action_time = '{$str_date}'");
								


                                //Чистим кеш владельцу заметки и заметок на его стр
                                mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
							}header("Location: index.php");
                        }
                        header("Location: index.php");

}
else
{
                   header("Location: index.php");
}
?>
