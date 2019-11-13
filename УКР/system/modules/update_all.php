<?php
/* 
	Appointment: Обновление разных событий в реалном времени
	File: update_all.php 
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

NoAjaxQuery();

if($logged){
	
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
	
		//################### Обновление комментариев у записей на стенах юзеров ###################//
		case "wall_comm":
			
			$rec_id = intval($_POST['rec_id']);
			$last_comm_id = intval($_POST['last_comm_id']);

			$sql_ = $db->super_query("SELECT tb1.id, author_user_id, for_user_id, text, add_date, tb2.user_photo, user_search_pref, user_last_visit FROM `".PREFIX."_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.author_user_id = tb2.user_id AND tb1.fast_comm_id = '{$rec_id}' AND id > '{$last_comm_id}' ORDER by `add_date`", 1);
				
			//Если есть новые комменты
			if($sql_){
				
				$tpl->load_template('wall/record.tpl');
					
				foreach($sql_ as $row_comments){
					
					$tpl->set('{name}', $row_comments['user_search_pref']);
					if($row_comments['user_photo'])
						$tpl->set('{ava}', '/uploads/users/'.$row_comments['author_user_id'].'/50_'.$row_comments['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');

					$tpl->set('{rec-id}', $rec_id);
					$tpl->set('{comm-id}', $row_comments['id']);
					$tpl->set('{user-id}', $row_comments['author_user_id']);
						
					$expBR2 = explode('<br />', $row_comments['text']);
					$textLength2 = count($expBR2);
					$strTXT2 = strlen($row_comments['text']);
					if($textLength2 > 6 OR $strTXT2 > 470)
					$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">Показать полностью..</div>';
								
					//Обрабатываем ссылки
					$row_comments['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_comments['text']);
			
					$tpl->set('{text}', stripslashes($row_comments['text']));
						
					megaDate($row_comments['add_date']);
						
					if($user_id == $row_comments['author_user_id'] OR $user_id == $row_comments['for_user_id']){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
					} else
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
					if($user_id == $row_comments['author_user_id'])
						
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
							
					else {

						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						
					}
						
					$tpl->set('[comment]', '');
					$tpl->set('[/comment]', '');
					$tpl->set('[wall-func]', '');
					$tpl->set('[/wall-func]', '');
					$tpl->set_block("'\\[groups\\](.*?)\\[/groups\\]'si","");
					$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
					$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
					$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						
					$tpl->set('{style-new}', 'style="background:#f5f6fa"');
						
					$tpl->compile('content');

				}
				
				AjaxTpl();

			}
	
		break;
		
		//################### Добавление комментария к записи ###################//
		case "wall_comm_groups":

			$rec_id = intval($_POST['rec_id']);
			$last_comm_id = intval($_POST['last_comm_id']);
	
			//Проверка на админа и проверяем включены ли комменты
			$row = $db->super_query("SELECT tb1.public_id, tb2.admin, comments FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = tb2.id AND tb1.id = '{$rec_id}'");

			if($row['comments'] OR stripos($row['admin'], "u{$user_id}|")){

				$sql_comments = $db->super_query("SELECT tb1.id, public_id, text, add_date, tb2.user_photo, user_search_pref FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.public_id = tb2.user_id AND tb1.fast_comm_id = '{$rec_id}' AND id > '{$last_comm_id}' ORDER by `add_date` ASC", 1);
				
				if($sql_comments){

					$tpl->load_template('groups/record.tpl');
				
					//Сообственно выводим комменты
					foreach($sql_comments as $row_comments){
					
						$tpl->set('{public-id}', $row['public_id']);
						$tpl->set('{name}', $row_comments['user_search_pref']);
						
						if($row_comments['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['public_id'].'/50_'.$row_comments['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
							
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row_comments['public_id']);
						$tpl->set('{rec-id}', $rec_id);
						
						$expBR2 = explode('<br />', $row_comments['text']);
						$textLength2 = count($expBR2);
						$strTXT2 = strlen($row_comments['text']);
						if($textLength2 > 6 OR $strTXT2 > 470)
							$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">Показать полностью..</div>';
								
						//Обрабатываем ссылки
						$row_comments['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_comments['text']);
						
						$tpl->set('{text}', stripslashes($row_comments['text']));
						
						megaDate($row_comments['add_date']);
						
						if(stripos($row['admin'], "u{$user_id}|") !== false OR $user_id == $row_comments['public_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						
						if($user_id == $row_comments['public_id'])
							
							$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
								
						else {

							$tpl->set('[not-owner]', '');
							$tpl->set('[/not-owner]', '');
							
						}
						
						$tpl->set('{style-new}', 'style="background:#f5f6fa"');
						
						$tpl->set('[comment]', '');
						$tpl->set('[/comment]', '');
						$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
						$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						$tpl->compile('content');
					}
					
					AjaxTpl();
				
				}
				
			}

		break;
		
		//################### Обновление новых сообщений в обсуждении ###################//
		case "forum":
		
			$rec_id = intval($_POST['rec_id']);
			$last_comm_id = intval($_POST['last_comm_id']);
			$public_id = intval($_POST['public_id']);
			
			//Выводим данные о сообществе
			$row2 = $db->super_query("SELECT admin, discussion FROM `".PREFIX."_communities` WHERE id = '{$public_id}'");
			
			$sql_ = $db->super_query("SELECT tb1.mid, muser_id, msg, mdate, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_communities_forum_msg` tb1, `".PREFIX."_users` tb2 WHERE tb1.muser_id = tb2.user_id AND tb1.fid = '{$rec_id}' AND mid > '{$last_comm_id}' ORDER by `mdate` ASC", 1);
			
			if($row2 AND $sql_ AND $row2['discussion']){
				
				if(stripos($row2['admin'], "u{$user_id}|") !== false)
					$public_admin = true;
				else
					$public_admin = false;
					
				$tpl->load_template('forum/msg.tpl');
				$i = 0;
				foreach($sql_ as $row_comm){
					
					$i++;
					
					$tpl->set('{name}', $row_comm['user_search_pref']);
						
					$row_comm['msg'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_comm['msg']);
						
					$tpl->set('{text}', stripslashes($row_comm['msg']));
					$tpl->set('{mid}', $row_comm['mid']);
					$tpl->set('{user-id}', $row_comm['muser_id']);
					megaDate($row_comm['mdate']);
					OnlineTpl($row_comm['user_last_visit']);
						
					if($row_comm['user_photo'])
						$tpl->set('{ava}', "/uploads/users/{$row_comm['muser_id']}/50_{$row_comm['user_photo']}");
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
							
					//ADMIN 2
					if($user_info['user_group'] == 1 OR $public_admin OR $row_comm['muser_id'] == $user_id){
						
						$tpl->set('[admin-2]', '');
						$tpl->set('[/admin-2]', '');
						
					} else
						$tpl->set_block("'\\[admin-2\\](.*?)\\[/admin-2\\]'si","");
					
					if($row_comm['muser_id'] == $user_id){
						
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
							
					} else {
							
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
							
					}
						
					$tpl->set('{style-new}', 'style="background:#f5f6fa"');
					
					$tpl->compile('content');
						
				}

				AjaxTpl();
				
			}
			
		break;
		
			default:
				
				//false
		
	}

}

exit();
?>