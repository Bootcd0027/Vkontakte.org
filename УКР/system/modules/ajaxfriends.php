<?php
/* 
	Appointment: ������ � Ajax
	Author: ExcaliburONE
	Contact: ICQ525511
	File: ajaxfriends.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($logged){
	$act = $_GET['act'];
	$metatags['title'] = $lang['friends'];

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 4;
	$limit_page = ($page-1)*$gcount;
				
	switch($act){
		
		//################### �������� ������ � ������ ###################//
		case "send_demand":
			NoAjaxQuery();
			
			$for_user_id = intval($_GET['for_user_id']);
			$from_user_id = $user_info['user_id'];
			
			//��������� �� ���� ������������� ������ ��� ������������, ���� ��� ��� ����, �� ��� ����� "yes_demand"
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$for_user_id}' AND from_user_id = '{$from_user_id}'");

			if($for_user_id AND !$check AND $for_user_id != $from_user_id){
				
				//��������� ������������� ������ � ���� � �������
				$check_demands = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$from_user_id}' AND from_user_id = '{$for_user_id}'");
				if(!$check_demands){
					
					//��������� ����� ����� ����� ��� � ������ ������
					$check_friendlist = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE friend_id = '{$for_user_id}' AND user_id = '{$from_user_id}' AND subscriptions = 0");
					if(!$check_friendlist){
						$db->query("INSERT INTO `".PREFIX."_friends_demands` (for_user_id, from_user_id, demand_date) VALUES ('{$for_user_id}', '{$from_user_id}', NOW())");
						$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands+1 WHERE user_id = '{$for_user_id}'");
						echo 'ok';
						
						//�������� ����������� �� E-mail
						if($config['news_mail_1'] == 'yes'){
							$rowUserEmail = $db->super_query("SELECT user_name, user_email FROM `".PREFIX."_users` WHERE user_id = '".$for_user_id."'");
							if($rowUserEmail['user_email']){
								include_once ENGINE_DIR.'/classes/mail.php';
								$mail = new dle_mail($config);
								$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
								$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '1'");
								$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
								$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
								$mail->send($rowUserEmail['user_email'], '����� ������ � ������', $rowEmailTpl['text']);
							}
						}
					} else
						echo 'yes_friend';
				} else
					echo 'yes_demand2';
			} else 
				echo 'yes_demand';
			
			die();
		break;
		
		//################### �������� ������ �� ������ ###################//
		case "take":
			NoAjaxQuery();
			$take_user_id = intval($_GET['take_user_id']);
			$user_id = $user_info['user_id'];
			
			//��������� �� ������������� ����� � ������� ������ � ������
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$take_user_id}'");
			
			if($check){
				
				//��������� ����� ������� ����� ������ � ������ ������
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$user_id}', friend_id = '{$take_user_id}', friends_date = NOW()");
				
				//���� ��� ��������� ������, ��������� ��� � ������ ����
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$take_user_id}', friend_id = '{$user_id}', friends_date = NOW()");
				
				//��������� ���-�� ������ � ���-������ � �����
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands-1, user_friends_num = user_friends_num+1 WHERE user_id = '{$user_id}'");
				
				//���� ��� ��������� ������, ��������� ���-������
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num+1 WHERE user_id = '{$take_user_id}'");
				
				//������� ������ �� ������� ������
				$db->query("DELETE FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$take_user_id}'");

				$generateLastTime = $server_time-10800;
				
				//��������� �������� � ����� �������� ��� ������� ������
				$rowX = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 4 AND ac_user_id = '{$take_user_id}'");
				if($rowX['ac_id'])
					if(!preg_match("/{$rowX['action_text']}/i", $user_id))
						$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$rowX['action_text']}||{$user_id}', action_time = '{$server_time}' WHERE ac_id = '{$rowX['ac_id']}'");
					else
						echo '';
				else
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$take_user_id}', action_type = 4, action_text = '{$user_id}', action_time = '{$server_time}'");
	
				//��������� �������� � ����� �������� ����
				$row = $db->super_query("SELECT ac_id, action_text FROM `".PREFIX."_news` WHERE action_time > '{$generateLastTime}' AND action_type = 4 AND ac_user_id = '{$user_id}'");
				if($row)
					if(!preg_match("/{$row['action_text']}/i", $take_user_id))
						$db->query("UPDATE `".PREFIX."_news` SET action_text = '{$row['action_text']}||{$take_user_id}', action_time = '{$server_time}' WHERE ac_id = '{$row['ac_id']}'");
					else
						echo '';
				else
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 4, action_text = '{$take_user_id}', action_time = '{$server_time}'");

				//������ ��� ��������� ��� � ���� ���� ��������� � ��.
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('user_'.$take_user_id.'/profile_'.$take_user_id);

				//���������� ������������ � ��� ���� ������
				$openMyList = mozg_cache("user_{$user_id}/friends");
				mozg_create_cache("user_{$user_id}/friends", $openMyList."id{$take_user_id}|");
				
				$openTakeList = mozg_cache("user_{$take_user_id}/friends");
				mozg_create_cache("user_{$take_user_id}/friends", $openTakeList."id{$user_id}|");
			} else
				echo 'no_request';
			
			die();
		break;
		
		//################### ���������� ������ �� ������ ###################//
		case "reject":
			NoAjaxQuery();
			$reject_user_id = $db->safesql(intval($_GET['reject_user_id']));
			$user_id = $user_info['user_id'];
			
			//��������� �� ������������� ����� � ������� ������ � ������
			$check = $db->super_query("SELECT for_user_id FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$reject_user_id}'");
			if($check){
				//��������� ���-�� ������ � �����
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = user_friends_demands-1 WHERE user_id = '{$user_id}'");
				
				//������� ������ �� ������� ������
				$db->query("DELETE FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}' AND from_user_id = '{$reject_user_id}'");
				
			} else
				echo 'no_request';
			
			die();
		break;
		
		//################### �������� ����� �� ������ ������ ###################//
		case "delete":
			NoAjaxQuery();
			$delet_user_id = $db->safesql(intval($_POST['delet_user_id']));
			$user_id = $user_info['user_id'];
			
			//��������� �� ������������� ����� � ������ ������
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$delet_user_id}' AND subscriptions = 0");
			if($check){
				//������� ����� �� ������� ������
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$delet_user_id}' AND subscriptions = 0");
				
				//������� � ����� �� �������
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$delet_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 0");
				
				//��������� ���-������ � �����
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$user_id}'");
				
				//��������� � ����� �������� ������� ���-�� ������
				$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$delet_user_id}'");
				
				//������ ��� ��������� ��� � ���� ���� ������� �� ��.
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('user_'.$delet_user_id.'/profile_'.$delet_user_id);
				
				//������� ������������ �� ��� ���� ������
				$openMyList = mozg_cache("user_{$user_id}/friends");
				mozg_create_cache("user_{$user_id}/friends", str_replace("id{$delet_user_id}|", "", $openMyList));
				
				$openTakeList = mozg_cache("user_{$delet_user_id}/friends");
				mozg_create_cache("user_{$delet_user_id}/friends", str_replace("id{$user_id}|", "", $openTakeList));
			} else
				echo 'no_friend';
			
			die();
		break;
		

		
		//################### �������� ���� ������ ������ ###################//
		case "online":
			$get_user_id = intval($_GET['user_id']);
			if(!$get_user_id)
				$get_user_id = $user_info['user_id'];
			
			//��
			$CheckBlackList = CheckBlackList($get_user_id);
			if(!$CheckBlackList){

				if($get_user_id == $user_info['user_id'])
					$sql_order = "ORDER by `views`";
				else
					$sql_order = "ORDER by `friends_date`";
							
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, user_country_city_name, user_search_pref, user_birthday, user_photo FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$get_user_id}' AND tb1.user_last_visit >= '{$online_time}' AND tb2.subscriptions = 0 {$sql_order} DESC LIMIT {$limit_page}, {$gcount}", 1);
				
				//������� ��� �����
				$friends_sql = $db->super_query("SELECT user_name, user_friends_num FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
				if($user_info['user_id'] != $get_user_id)
					$gram_name = gramatikName($friends_sql['user_name']);
				else
					$gram_name = '���';
			
				if($sql_)
					//���-�� ������ � �������
					$online_friends = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` tb1, `".PREFIX."_friends` tb2 WHERE tb1.user_id = tb2.friend_id AND tb2.user_id = '{$get_user_id}' AND tb1.user_last_visit >= '{$online_time}' AND tb2.subscriptions = 0");

				if($online_friends['cnt'])
					$user_speedbar = '� '.$gram_name.' '.$online_friends['cnt'].' '.gram_record($online_friends['cnt'], 'friends_online');
				else
					$user_speedbar = $lang['no_requests_online'];
					
				//����
				$tpl->load_template('friends/head.tpl');
				if($user_info['user_id'] != $get_user_id)
					$tpl->set('{name}', $gram_name);
				else
					$tpl->set('{name}', '');
					
				$tpl->set('{user-id}', $get_user_id);
				if($get_user_id == $user_info['user_id']){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
					$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					if($user_info['user_friends_demands'])
						$tpl->set('{demands}', '('.$user_info['user_friends_demands'].')');
					else
						$tpl->set('{demands}', '');
				} else {
					$tpl->set('[not-owner]', '');
					$tpl->set('[/not-owner]', '');
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				}
				$tpl->set('[online-friends]', '');
				$tpl->set('[/online-friends]', '');
				$tpl->set_block("'\\[request-friends\\](.*?)\\[/request-friends\\]'si","");
				$tpl->set_block("'\\[all-friends\\](.*?)\\[/all-friends\\]'si","");
				$tpl->compile('info');
					
				if($sql_){
					$tpl->load_template('friends/friend.tpl');
					foreach($sql_ as $row){
						$user_country_city_name = explode('|', $row['user_country_city_name']);
						$tpl->set('{country}', $user_country_city_name[0]);
						if($user_country_city_name[1])
							$tpl->set('{city}', ', '.$user_country_city_name[1]);
						else
							$tpl->set('{city}', '');
						$tpl->set('{user-id}', $row['user_id']);
						$tpl->set('{name}', $row['user_search_pref']);
						
						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
						
						$tpl->set('{online}', $lang['online']);

						//������� �����
						$user_birthday = explode('-', $row['user_birthday']);
						$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));

						if($get_user_id == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
						if($row['user_id'] == $user_info['user_id'])
							$tpl->set_block("'\\[viewer\\](.*?)\\[/viewer\\]'si","");
						else {
							$tpl->set('[viewer]', '');
							$tpl->set('[/viewer]', '');
						}
		
						$tpl->compile('content');
					}
					navigation($gcount, $online_friends['cnt'], $config['home_url'].'friends/online/'.$get_user_id.'/page/');
				} else
					msgbox('', $lang['no_requests_online'], 'info_2');
			} else {
				$user_speedbar = $lang['error'];
				msgbox('', $lang['no_notes'], 'info');
			}
		break;
		
		//################### �������� ������ � ���� ��� ������ �� ###################//
		case "box":
			NoAjaxQuery();

			$user_id = $user_info['user_id'];

			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 18;
			$limit_page = ($page-1)*$gcount;

			if($_POST['user_sex'] == 1)
				$sql_usSex = 2;
			elseif($_POST['user_sex'] == 2)
				$sql_usSex = 1;
			else
				$sql_usSex = false;

			//��� ������
			if($sql_usSex){
				$count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 AND tb2.user_sex = '{$sql_usSex}'");
				
				if($count['cnt']){
					$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.friend_id, tb2.user_photo, user_search_pref FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 0 AND tb2.user_sex = '{$sql_usSex}' ORDER by `views` DESC LIMIT {$limit_page}, {$gcount}", 1);
					$tpl->load_template('friends/box_friend.tpl');
					foreach($sql_ as $row){
						$tpl->set('{user-id}', $row['friend_id']);
						$tpl->set('{name}', $row['user_search_pref']);

						if($row['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/50_'.$row['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/100_no_ava.png');

						$tpl->compile('content');
					}
					box_navigation($gcount, $count['cnt'], "''", 'sp.openfriends', '');
				} else
					msgbox('', '<div class="clear" style="margin-top:140px"></div>'.$lang['no_requests'], 'info_2');
			} else
				msgbox('', '<div class="clear" style="margin-top:140px"></div>'.$lang['no_requests'], 'info_2');

			AjaxTpl();
			
			die();
		break;
		
			default:
				
		//################### �������� ������ � ������ ###################//

			$user_id = $user_info['user_id'];

			if($user_info['user_friends_demands'])
				$user_speedbar = $user_info['user_friends_demands'].' '.gram_record($user_info['user_friends_demands'], 'friends_demands');
			else
				$user_speedbar = $lang['no_requests'];
			//������� ������ � ������ ���� ��� ����
			if($user_info['user_friends_demands']){
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.from_user_id, demand_date, tb2.user_photo, user_search_pref, user_country_city_name, user_birthday FROM `".PREFIX."_friends_demands` tb1, `".PREFIX."_users` tb2 WHERE tb1.for_user_id = '{$user_id}' AND tb1.from_user_id = tb2.user_id ORDER by `demand_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			$tpl->load_template('friends/ajaxrequest.tpl');
				foreach($sql_ as $row){
					$user_country_city_name = explode('|', $row['user_country_city_name']);
					$tpl->set('{country}', $user_country_city_name[0]);
					$tpl->set('{city}', ', '.$user_country_city_name[1]);
					$tpl->set('{user-id}', $row['from_user_id']);
					$tpl->set('{name}', $row['user_search_pref']);
					
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['from_user_id'].'/100_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
					//������� �����
					$user_birthday = explode('-', $row['user_birthday']);
					$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					
					$tpl->compile('content');
				}
				navigation();
			} else
				msgbox('', $lang['no_requests'], 'info_2');
		AjaxTpl();
		die();
		break;
	}
	$db->free();
	$tpl->clear();
} else {
	$user_speedbar = '����������';
	msgbox('', $lang['not_logged'], 'info');
}
?>