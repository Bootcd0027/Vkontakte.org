<?php
/* 
	
 
*/
if(!defined('MOZG'))
	die('Morkovka68');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = 'Мнения';
	
	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 20;
	$limit_page = ($page-1)*$gcount;
		       
	switch($act){
		
	
				
case "send":
			NoAjaxQuery();
			$text = ajax_utf8(textFilter($_POST['msg']));
			$uid = intval($_POST['id']);
			$type = intval($_POST['type']);
				
				
			//Обновляем данные в теме
			
				$row = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_opinion` WHERE user_id = '{$user_id}' ORDER by `id` DESC");	
				$tm = time()-60;
				$total_msg = count($db->super_query("SELECT id FROM `".PREFIX."_opinion` WHERE user_id='".$user_id."' AND date > '".$tm."' AND date < '".time()."'",1));
					
				if($row['text'] == $text || $total_msg > 1) {
				$tpl->result['content'] .= 'Вы можете оставлять не больше двух мнений в минуту.';
				$tpl->compile('content');
				} else {
				$db->query("INSERT INTO `".PREFIX."_opinion` SET user_id = '{$user_id}', for_user_id = '{$uid}', text = '{$text}', type = '{$type}', date = '{$server_time}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_opinion = user_opinion+1 WHERE user_id = '{$uid}'");
				$db->query("UPDATE `".PREFIX."_users` SET user_new_opinion = user_new_opinion+1 WHERE user_id = '{$uid}'");
				if($type == 0) {
				$id = $user_info['user_id'];
				$ava = $user_info['user_photo'];
				$name = $user_info['user_search_pref'];
				} else {
				$id = '0';
				$ava = 'ava.png';
				$name = 'Анонимное мнение';
				}
				$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$uid}', from_user_id = '{$id}', type = '20', date = '{$server_time}', text = '{$text}', user_photo = '{$ava}', user_search_pref = '{$name}', lnk = '/opinion'");
				mozg_create_cache("user_{$uid}/updates", 1);
				
				
				$tpl->result['content'] .= 'Мнение успешно отправлено.';
				$tpl->compile('content');
				}
				AjaxTpl();
			
			exit();
		break;
		
		case "del":
			NoAjaxQuery();
			$cid = intval($_POST['cid']);
		$op_sql = $db->super_query("SELECT for_user_id FROM `".PREFIX."_opinion` WHERE id = '{$cid}'");
			$db->query("DELETE FROM `".PREFIX."_opinion` WHERE id = '{$cid}'");
			$db->query("UPDATE `".PREFIX."_users` SET user_opinion = user_opinion-1 WHERE user_id = '{$op_sql['for_user_id']}'");
			
			die();
		break;
		
		
			case "my":
		
			
			
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_opinion` WHERE user_id = '{$user_id}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				
			
				
						
						$op_sql = $db->super_query("SELECT user_name, user_opinion FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
						
						$db->query("UPDATE `".PREFIX."_users` SET user_new_opinion = '0' WHERE user_id = '{$user_id}'");
						
						$tpl->load_template('opinion/head.tpl');
						
						$tpl->set('{moi}',  'buttonsprofileSec');
						
							$tpl->compile('info');
						if($sql_){	
							$tpl->load_template('opinion/one.tpl');
							
							foreach($sql_ as $row){
							$tpl->set('{op-id}',  $row['id']);
							$tpl->set('{text}',  $row['text']);
									
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
					
								if(date('Y-m-d', $row['date']) == date('Y-m-d', $server_time))
								$tpl->set('{date}', langdate('сегодня в H:i', $row['date']));
							elseif(date('Y-m-d', $row['date']) == date('Y-m-d', ($server_time-84600)))
								$tpl->set('{date}', langdate('вчера в H:i', $row['date']));
							else
								$tpl->set('{date}', langdate('j F Y в H:i', $row['date']));
							
							$sql_us = $db->super_query("SELECT user_id, user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row['user_id']}'");
				
					
					
					if($sql_us['user_photo'])
					$tpl->set('{user-ava}', '/uploads/users/'.$sql_us['user_id'].'/50_'.$sql_us['user_photo'].'');
				else
					$tpl->set('{user-ava}', '/templates/Default/images/no_ava_50.png');
					
					$tpl->set('{user-name}', $sql_us['user_search_pref']);
					
					$tpl->set('{user-link}', 'href=\'/u'.$sql_us['user_id'].'\'');
					
					
					
														
								
						
							$tpl->compile('content');
							}
							navigation($gcount, $op_sql['user_opinion'], $config['home_url'].'opinion/'.$user_id.'/page/');
						} else
							msgbox('', 'Вы еще не оставляли мнений!', 'info_2');
			
		
		break;
		
				
		default:	

		
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_opinion` WHERE for_user_id = '{$user_id}' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
				
			
				
						
						$op_sql = $db->super_query("SELECT user_name, user_opinion FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
						
						$db->query("UPDATE `".PREFIX."_users` SET user_new_opinion = '0' WHERE user_id = '{$user_id}'");
						
						$tpl->load_template('opinion/head.tpl');
						$tpl->set('{num}',  'О вас оставлено '.$op_sql['user_opinion'].' мнений.');
						$tpl->set('{obomne}',  'buttonsprofileSec');	
							$tpl->compile('info');
						if($sql_){	
							$tpl->load_template('opinion/one.tpl');
							
							foreach($sql_ as $row){
							$tpl->set('{op-id}',  $row['id']);
							$tpl->set('{text}',  $row['text']);
							
							
							
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
							
								if(date('Y-m-d', $row['date']) == date('Y-m-d', $server_time))
								$tpl->set('{date}', langdate('сегодня в H:i', $row['date']));
							elseif(date('Y-m-d', $row['date']) == date('Y-m-d', ($server_time-84600)))
								$tpl->set('{date}', langdate('вчера в H:i', $row['date']));
							else
								$tpl->set('{date}', langdate('j F Y в H:i', $row['date']));
							
							$sql_us = $db->super_query("SELECT user_id, user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row['user_id']}'");
				
					if($row['type'] == 0) {
					
					if($sql_us['user_photo'])
					$tpl->set('{user-ava}', '/uploads/users/'.$sql_us['user_id'].'/50_'.$sql_us['user_photo'].'');
				else
					$tpl->set('{user-ava}', 'templates/Default/images/no_ava_50.png');
					
					$tpl->set('{user-name}', $sql_us['user_search_pref']);
					$tpl->set('{user-id}', $sql_us['user_id']);
					$tpl->set('{user-link}', 'href=\'/u'.$sql_us['user_id'].'\'');
					
					} else {

					$tpl->set('{user-ava}', 'templates/Default/images/no_ava_50.png');
					
					$tpl->set('{user-name}', 'Анонимное мнение');
					$tpl->set('{user-id}', $sql_us['user_id']);
					$tpl->set('{user-link}', '');
					}
				
					
					
														
								
						
							$tpl->compile('content');
							}
							navigation($gcount, $op_sql['user_opinion'], $config['home_url'].'opinion/'.$user_id.'/page/');
						} else
							msgbox('', 'Пока что никто не оставил о Вас мнений!', 'info_2');
		
		

	}   
					
					
					
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
