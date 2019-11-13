<?php
 
if(!defined('MOZG'))
	die('You ю..');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = 'Радар';
	$price = 10; // Устанавливаем цену  на радар пользователя
	$comm_price = 20; // Устанавливаем цену на рекламу групп

		       
	switch($act){
		
		//################### Добавляемся ###################//
		case "add":
			if($user_info['user_balance'] < $price){					
				echo "На вашем счете недостаточно голосов, пожалуйста, пополните баланс!)";
			}else{
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-{$price} , user_comm = {$server_time} WHERE user_id = '{$user_id}'");
				echo "ok";
			}
			die;
        break;
		//################### Удаляемся ###################//
		case "del":
			$db->query("UPDATE `".PREFIX."_users` SET  user_comm = 0 WHERE user_id = '{$user_id}'");
			echo "ok";
			
			die;
        break;		

		//################### получаем инфо по группе###################//
		case "infocomm":
			$id=intval($_POST['u']);
			$sql = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if((stripos($sql['admin'], "u{$user_id}|") !== false)){
				$row = $db->super_query("SELECT photo, title,id,pokaz FROM `".PREFIX."_communities` WHERE id = '{$id}'");
				if($row) echo $row['pokaz']."|".$row['photo']."|".$row['u']."|".$row['title'];
				
			}
			die;
        break;	

		//################### Добавляемся ###################//
		case "addcomm":
			$id=intval($_POST['u']);
			$sql = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$id}'");
			if((stripos($sql['admin'], "u{$user_id}|") !== false)){
				if($user_info['user_balance'] < $comm_price){					
					echo "На вашем счете недостаточно голосов, пожалуйста, пополните баланс!)";
				}else{
					$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-{$comm_price} WHERE user_id = '{$user_id}'");
					$db->query("UPDATE `".PREFIX."_communities` SET pokaz = pokaz+1000 WHERE id = '{$id}'");
					echo "ok";
				}
			}
			die;
        break;		
		
			
		default:		
			//################### Страница "Радар" ###################//

			$tpl->load_template('radar/main.tpl');

            if($user_info['user_balance'] >= $price){
				$tpl->set('{ubm}', 'У Вас <span id=num>'.$user_info['user_balance'].'</span> голосов');
			}else{
				$tpl->set('{ubm}', 'У Вас недостаточно <a href="balance?act=invite">голосов</a>');
            }
            
			if($user_info['user_comm'] >=($server_time-24*60*60)){
				$tpl->set('{on}', 'no_display');
			}else{
				$tpl->set('{off}', 'no_display');
            }			
			
			
			$tpl->set('{user_id}', $user_info['user_id']);	
			$tpl->set('{user_name}', $user_info['user_search_pref']);	
			//Аватарка
			if($user_info['user_photo']){
				$tpl->set('{user_ava}', $config['home_url'].'uploads/users/'.$user_info['user_id'].'/100_'.$user_info['user_photo']);
			} else {
				$tpl->set('{user_ava}', '/templates/Default/images/100_no_ava.png');
			}	
	
            $tpl->set('{price}', $price);
			
			

			$sql_sort =$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, title, photo,pokaz FROM `".PREFIX."_communities` WHERE admin regexp '[[:<:]](id{$user_info['user_id']})[[:>:]]' ORDER by `traf` DESC", 1);;
			$spis_public='';
			$s=' selected ';
			foreach ($sql_sort as $public){
				$spis_public.='<option value="'.$public['id'].'">'.stripslashes($public['title']).'</option>';
				if ($s){
					$tpl->set('{public_id}', $public['id']);	
					$tpl->set('{title}', $public['title']);	
					//Аватарка
					$tpl->set('{group_id}', $row['id']);
					$tpl->set('{user_id}', $row['user_id']);
					$tpl->set('{title}', $row['title']);
					$tpl->set('{name}', $row['user_search_pref']);
					if($row['photo'] != '')
						$tpl->set('{photo}', '/uploads/groups/'.$row['id'].'/100_'.$row['photo']);
					else
					$tpl->set('{photo}', '/templates/Default/images/no_ava_groups_100.gif');
					if($public['pokaz'] >0){
						$tpl->set('{comm_off}', 'no_display');
					}else{
						$tpl->set('{comm_on}', 'no_display');
					}	
					$tpl->set('{pokaz}', $public['pokaz']);

				}
				$s='';
			}			
			$tpl->set('{public}', $spis_public);
            if($user_info['user_balance'] >= $comm_price){
				$tpl->set('{comm_ubm}', 'У Вас <span id=comm_num>'.$user_info['user_balance'].'</span> голосов');
			}else{
				$tpl->set('{comm_ubm}', 'У Вас недостаточно <a href="balance?act=invite">голосов</a>');
            }
			
			
            $tpl->set('{comm_price}', $comm_price);
			$tpl->compile('content');

	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
