<?php
/* 
	Appointment: Закладки
	File: fave.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$sel = $_GET['sel'];
	$user_id = $user_info['user_id'];
	
	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 70;
	$limit_page = ($page-1)*$gcount;
	
	$metatags['title'] = $lang['fave'];
	
	switch($act){
		
		//################### Добвление юзера в закладки ###################//
		case "add":
			NoAjaxQuery();
			$fave_id = intval($_POST['fave_id']);
			$type = intval($_POST['type']);

			if($type == 1) {
				$row = $db->super_query("SELECT `user_id` FROM `".PREFIX."_users` WHERE user_id = '{$fave_id}'");
				if($row AND $user_id != $fave_id){
				
					//Проверям на факт существование этого юзера в закладках, если нету то пропускаем
					$db->query("SELECT `user_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND fave_id = '{$fave_id}'");
					if(!$db->num_rows()){
						$db->query("INSERT INTO `".PREFIX."_fave` SET user_id = '{$user_id}', fave_id = '{$fave_id}', date = NOW()");
						$db->query("UPDATE `".PREFIX."_users` SET user_fave_num = user_fave_num+1 WHERE user_id = '{$user_id}'");
					} else
						echo 'yes_user';
				} else
					echo 'no_user';
			} elseif($type == 2) {
				$row = $db->super_query("SELECT `id` FROM `".PREFIX."_clubs` WHERE id = '{$fave_id}'");
				if($row){
				
					//Проверям на факт существование этого юзера в закладках, если нету то пропускаем
					$db->query("SELECT `club_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND club_id = '{$fave_id}'");
					if(!$db->num_rows()){
						$db->query("INSERT INTO `".PREFIX."_fave` SET user_id = '{$user_id}', club_id = '{$fave_id}', date = NOW()");
						$db->query("UPDATE `".PREFIX."_users` SET user_fave_club_num = user_fave_club_num+1 WHERE user_id = '{$user_id}'");
					} else
						echo 'yes_user';
				} else
					echo 'no_user';
			} elseif($type == 3) {
				$row = $db->super_query("SELECT `id`,`owner_user_id` FROM `".PREFIX."_videos` WHERE id = '{$fave_id}'");
				if($row){
				
					//Проверям на факт существование этого юзера в закладках, если нету то пропускаем
					$db->query("SELECT `video` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND video = '{$fave_id}'");
					if(!$db->num_rows()){
						$db->query("INSERT INTO `".PREFIX."_fave` SET user_id = '{$user_id}', video = '{$fave_id}', owner_video = '{$row['owner_user_id']}', date = NOW()");
						$db->query("UPDATE `".PREFIX."_users` SET user_fave_video_num = user_fave_video_num+1 WHERE user_id = '{$user_id}'");
					} else
						echo 'yes_user';
				} else
					echo 'no_user';
			} elseif($type == 4) {
				$row = $db->super_query("SELECT `id` FROM `".PREFIX."_communities` WHERE id = '{$fave_id}'");
				if($row){
				
					//Проверям на факт существование этого юзера в закладках, если нету то пропускаем
					$db->query("SELECT `public_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND public_id = '{$fave_id}'");
					if(!$db->num_rows()){
						$db->query("INSERT INTO `".PREFIX."_fave` SET user_id = '{$user_id}', public_id = '{$fave_id}', date = NOW()");
						$db->query("UPDATE `".PREFIX."_users` SET user_fave_public_num = user_fave_public_num+1 WHERE user_id = '{$user_id}'");
					} else
						echo 'yes_user';
				} else
					echo 'no_user';
			}
			
			die();
		break;
		
		//################### Удаление юзера из закладок ###################//
		case "delet":
			NoAjaxQuery();
			$fave_id = intval($_POST['fave_id']);
			$type = intval($_POST['type']);

			if($type == 1) {
				$row = $db->super_query("SELECT `user_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND fave_id = '{$fave_id}'");
				if($row){
					$db->query("DELETE FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND fave_id = '{$fave_id}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_fave_num = user_fave_num-1 WHERE user_id = '{$user_id}'");
				} else
					echo 'yes_user';
			} elseif($type == 2) {
				$row = $db->super_query("SELECT `club_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND club_id = '{$fave_id}'");
				if($row){
					$db->query("DELETE FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND club_id = '{$fave_id}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_fave_club_num = user_fave_club_num-1 WHERE user_id = '{$user_id}'");
				} else
					echo 'yes_user';
			} elseif($type == 3) {
				$row = $db->super_query("SELECT `video` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND video = '{$fave_id}'");
				if($row){
					$db->query("DELETE FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND video = '{$fave_id}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_fave_video_num = user_fave_video_num-1 WHERE user_id = '{$user_id}'");
				} else
					echo 'yes_user';
			} elseif($type == 4) {
				$row = $db->super_query("SELECT `public_id` FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND public_id = '{$fave_id}'");
				if($row){
					$db->query("DELETE FROM `".PREFIX."_fave` WHERE user_id = '{$user_id}' AND public_id = '{$fave_id}'");
					$db->query("UPDATE `".PREFIX."_users` SET user_fave_public_num = user_fave_public_num-1 WHERE user_id = '{$user_id}'");
				} else
					echo 'yes_user';
			} 

			die();
		break;
		
		default:
		
			//################### Вывод людей которые есть в закладках ###################//
			//Выводим кол-во людей в закладках
			$user = $db->super_query("SELECT SQL_CALC_FOUND_ROWS user_fave_num,user_fave_club_num,user_fave_video_num,user_fave_public_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			//Если кто-то есть в заклаках то выводим
			if($sel=='users') {
				if($user['user_fave_num']){
					
					//Загружаем поиск на странице
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_num'].'</span> '.gram_record($user['user_fave_num'], 'fave'));
					$tpl->set('{return_users}', 'buttonsprofileSec');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', '');
					$tpl->set('[block_none]','');
					$tpl->set('[/block_none]','');
					$tpl->set('[search]','');
					$tpl->set('[/search]','');
					$tpl->set_block("'\\[block_error\\](.*?)\\[/block_error\\]'si","");
					$tpl->compile('content');
					
					//Выводи из базы
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.fave_id, tb2.user_search_pref, user_photo, user_last_visit FROM `".PREFIX."_fave` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.fave_id = tb2.user_id ORDER by `date` ASC LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('fave.tpl');
					$tpl->result['content'] .= '<table class="food_planner" id="fave_users">';
					foreach($sql_ as $row){
						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['fave_id'].'/100_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						
						$tpl->set('{name}', $row['user_search_pref']);
						$tpl->set('{user-id}', $row['fave_id']);
						$tpl->set('{link-id}', 'id'.$row['fave_id']);
						$tpl->set('{type}', '1');

						OnlineTpl($row['user_last_visit']);
						
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</table>';
					navigation($gcount, $user['user_fave_num'], $config['home_url'].'fave/page/');
				} else {
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_num'].'</span> '.gram_record($user['user_fave_num'], 'fave'));
					$tpl->set('{return_users}', 'buttonsprofileSec');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', '');
					$tpl->set_block("'\\[block_none\\](.*?)\\[/block_none\\]'si","");
					$tpl->set('[search]','');
					$tpl->set('[/search]','');
					$tpl->set('[block_error]','');
					$tpl->set('[/block_error]','');
					$tpl->compile('content');
				}
			} elseif($sel=='clubs') {
				if($user['user_fave_club_num']){
					
					//Загружаем поиск на странице
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_club_num'].'</span> '.gram_record($user['user_fave_club_num'], 'se_clubs'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', 'buttonsprofileSec');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', '');
					$tpl->set('[block_none]','');
					$tpl->set('[/block_none]','');
					$tpl->set_block("'\\[block_error\\](.*?)\\[/block_error\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->compile('content');
					
					//Выводи из базы
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.club_id, tb2.title, photo FROM `".PREFIX."_fave` tb1, `".PREFIX."_clubs` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.club_id = tb2.id LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('fave.tpl');
					$tpl->result['content'] .= '<table class="food_planner" id="fave_users">';
					foreach($sql_ as $row){
						if($row['photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/clubs/'.$row['club_id'].'/100_'.$row['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						
						$tpl->set('{name}', $row['title']);
						$tpl->set('{user-id}', $row['club_id']);
						$tpl->set('{link-id}', 'club'.$row['club_id']);
						$tpl->set('{type}', '2');
						
						OnlineTpl();
						
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</table>';
					navigation($gcount, $user['user_fave_club_num'], $config['home_url'].'fave/page/');
				} else {
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_club_num'].'</span> '.gram_record($user['user_fave_club_num'], 'se_clubs'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', 'buttonsprofileSec');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', '');
					$tpl->set_block("'\\[block_none\\](.*?)\\[/block_none\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->set('[block_error]','');
					$tpl->set('[/block_error]','');
					$tpl->compile('content');
				}
			} elseif($sel=='video') {
				if($user['user_fave_video_num']){
					
					//Загружаем поиск на странице
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_video_num'].'</span> '.gram_record($user['user_fave_video_num'], 'videos'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', 'buttonsprofileSec');
					$tpl->set('{return_public}', '');
					$tpl->set('[block_none]','');
					$tpl->set('[/block_none]','');
					$tpl->set_block("'\\[block_error\\](.*?)\\[/block_error\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->compile('content');
					
					//Выводи из базы
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.video, owner_video, tb2.title, photo FROM `".PREFIX."_fave` tb1, `".PREFIX."_videos` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.video = tb2.id AND tb1.owner_video = tb2.owner_user_id LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('fave.tpl');
					$tpl->result['content'] .= '<table class="food_planner" id="fave_users">';
					foreach($sql_ as $row){
						if($row['photo'])
							$tpl->set('{ava}', $row['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						
						$tpl->set('{name}', $row['title']);
						$tpl->set('{user-id}', $row['video']);
						$tpl->set('{link-id}', 'video'.$row['owner_video'].'_'.$row['video']);
						$tpl->set('{type}', '3');
						
						OnlineTpl();
						
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</table>';
					navigation($gcount, $user['user_fave_video_num'], $config['home_url'].'fave/page/');
				} else {
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_video_num'].'</span> '.gram_record($user['user_fave_video_num'], 'videos'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', 'buttonsprofileSec');
					$tpl->set('{return_public}', '');
					$tpl->set_block("'\\[block_none\\](.*?)\\[/block_none\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->set('[block_error]','');
					$tpl->set('[/block_error]','');
					$tpl->compile('content');
				}
			} elseif($sel=='public') {
				if($user['user_fave_public_num']){
					
					//Загружаем поиск на странице
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_public_num'].'</span> '.gram_record($user['user_fave_public_num'], 'se_groups'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', 'buttonsprofileSec');
					$tpl->set('[block_none]','');
					$tpl->set('[/block_none]','');
					$tpl->set_block("'\\[block_error\\](.*?)\\[/block_error\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->compile('content');
					
					//Выводи из базы
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.public_id, tb2.title, photo FROM `".PREFIX."_fave` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.public_id = tb2.id LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('fave.tpl');
					$tpl->result['content'] .= '<table class="food_planner" id="fave_users">';
					foreach($sql_ as $row){
						if($row['photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/groups/'.$row['public_id'].'/100_'.$row['photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						
						$tpl->set('{name}', $row['title']);
						$tpl->set('{user-id}', $row['public_id']);
						$tpl->set('{link-id}', 'public'.$row['public_id']);
						$tpl->set('{type}', '4');
						
						OnlineTpl();
						
						$tpl->compile('content');
					}
					$tpl->result['content'] .= '</table>';
					navigation($gcount, $user['user_fave_public_num'], $config['home_url'].'fave/page/');
				} else {
					$tpl->load_template('fave_search.tpl');
					$tpl->set('{count}', '<span id="fave_num">'.$user['user_fave_public_num'].'</span> '.gram_record($user['user_fave_public_num'], 'se_groups'));
					$tpl->set('{return_users}', '');
					$tpl->set('{return_clubs}', '');
					$tpl->set('{return_video}', '');
					$tpl->set('{return_public}', 'buttonsprofileSec');
					$tpl->set_block("'\\[block_none\\](.*?)\\[/block_none\\]'si","");
					$tpl->set_block("'\\[search\\](.*?)\\[/search\\]'si","");
					$tpl->set('[block_error]','');
					$tpl->set('[/block_error]','');
					$tpl->compile('content');
				}
			}
			
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>