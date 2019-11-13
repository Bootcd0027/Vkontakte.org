<?php
/* 
	Appointment: Редактирование страницы
	File: editprofile.php 
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

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	
	$metatags['title'] = $lang['editmyprofile'];
	
	switch($act){
		
		//Загрузка фотографии
		case "upload":
			NoAjaxQuery();
			
			//Подключаем класс для фотографий
			include ENGINE_DIR.'/classes/images.php';
			
			$user_id = $user_info['user_id'];
			$uploaddir = ROOT_DIR.'/uploads/users/';
			
			//Если нет папок юзера, то создаём её
			if(!is_dir($uploaddir.$user_id)){ 
				@mkdir($uploaddir.$user_id, 0777 );
				@chmod($uploaddir.$user_id, 0777 );
				@mkdir($uploaddir.$user_id.'/albums', 0777 );
				@chmod($uploaddir.$user_id.'/albums', 0777 );
			}
			
			//Разришенные форматы
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
			
			//Получаем данные о фотографии
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			$image_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // имя фотографии
			$image_size = $_FILES['uploadfile']['size']; // размер файла
			$type = end(explode(".", $image_name)); // формат файла
			
			//Проверям если, формат верный то пропускаем
			if(in_array($type, $allowed_files)){
				if($image_size < 5000000){
					$res_type = '.'.$type;
					$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/'; // Директория куда загружать
					if(move_uploaded_file($image_tmp, $uploaddir.$image_rename.$res_type)) {

						//Создание оригинала
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto(770);
						$tmb->jpeg_quality(95);
						$tmb->save($uploaddir.'o_'.$image_rename.$res_type);
						
						//Создание главной фотографии
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto(200, 1);
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.$image_rename.$res_type);
						
						//Создание уменьшеной копии 50х50
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto('50x50');
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.'50_'.$image_rename.$res_type);
						
						//Создание уменьшеной копии 100х100
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto('100x100');
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.'100_'.$image_rename.$res_type);

						$image_rename = $db->safesql($image_rename);
						$res_type = $db->safesql($res_type);

						//Добавляем на стену
						$row = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
						if($row['user_sex'] == 2)
							$sex_text = 'обновила';
						else
							$sex_text = 'обновил';
						
						$wall_text = "<div class=\"profile_update_photo\"><a href=\"\" onClick=\"Photo.Profile(\'{$user_id}\', \'{$image_rename}{$res_type}\'); return false\"><img src=\"/uploads/users/{$user_id}/o_{$image_rename}{$res_type}\" style=\"margin-top:3px\"></a></div>";
						
						$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', type = '{$sex_text} фотографию на странице:'");
						$dbid = $db->insert_id();
						
						$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
						
						//Добавляем в ленту новостей
						$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");

						//Обновляем имя фотки в бд
                        $path = $config['home_url'].'uploads/users/'.$user_id.'/'.$image_rename.$res_type;
                        $imsize = getimagesize($path);
						$db->query("UPDATE `".PREFIX."_users` SET user_photo = '{$image_rename}{$res_type}', user_wall_id = '{$dbid}', user_photo_style = '$imsize[0]|$imsize[1]' WHERE user_id = '{$user_id}'");
						
						echo $config['home_url'].'uploads/users/'.$user_id.'/'.$image_rename.$res_type;

						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
						mozg_clear_cache();
					} else
						echo 'bad';
				} else
					echo 'big_size';
			} else
				echo 'bad_format';

			die();
		break;
		
		//Добавление спецэффекта
		case "add_effect":
        $user_id = $user_info['user_id'];
        $row_balance = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
        if($row_balance['user_balance'] >= 15)
        {
            $id = $_GET['id'];
			$row = $db->super_query("UPDATE `".PREFIX."_users` SET user_photo_effect='$id', user_balance=user_balance-15 WHERE user_id = '{$user_id}'");
            echo 1;
        } else {
            echo 2;
        }
			die();
		break;
        
        //Удаление спецэффекта
		case "del_effect":
			$user_id = $user_info['user_id'];
			$row = $db->super_query("UPDATE `".PREFIX."_users` SET user_photo_effect='0' WHERE user_id = '{$user_id}'");
            echo 1;
			die();
		break;
		
		//Удаление фотографии
		case "del_photo":
			NoAjaxQuery();
			$user_id = $user_info['user_id'];
			$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/';
			$row = $db->super_query("SELECT user_photo, user_wall_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($row['user_photo']){
				$check_wall_rec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE id = '{$row['user_wall_id']}'");
				if($check_wall_rec['cnt']){
					$update_wall = ", user_wall_num = user_wall_num-1";
					$db->query("DELETE FROM `".PREFIX."_wall` WHERE id = '{$row['user_wall_id']}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$row['user_wall_id']}'");
				}
				
				$db->query("UPDATE `".PREFIX."_users` SET user_photo = '', user_wall_id = '' {$update_wall} WHERE user_id = '{$user_id}'");

				@unlink($uploaddir.$row['user_photo']);
				@unlink($uploaddir.'50_'.$row['user_photo']);
				@unlink($uploaddir.'100_'.$row['user_photo']);
				@unlink($uploaddir.'o_'.$row['user_photo']);
				@unlink($uploaddir.'130_'.$row['user_photo']);
				
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache();
			}
			die();
		break;
		
		//Страница загрузки главной фотографии
		case "load_photo":
			NoAjaxQuery();
			$tpl->load_template('load_photo.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		//Сохранение основых данных
		case "save_general":
			NoAjaxQuery();
		
			$post_user_sex = intval($_POST['sex']);
			if($post_user_sex == 1 OR $post_user_sex == 2)
				$user_sex = $post_user_sex;
			else
				$user_sex = false;
	        
			$user_name = ajax_utf8(textFilter($_POST['name']));
			$user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname'])));
			$user_dev = ajax_utf8(textFilter(ucfirst($_POST['dev'])));
			$user_otcestvo = ajax_utf8(textFilter(ucfirst($_POST['otcestvo'])));
			$user_hometown = ajax_utf8(textFilter(ucfirst($_POST['hometown'])));
			$user_grandparents = ajax_utf8(textFilter(ucfirst($_POST['grandparents'])));
			$user_parents = ajax_utf8(textFilter(ucfirst($_POST['parents'])));
			$user_siblings = ajax_utf8(textFilter(ucfirst($_POST['siblings'])));
			$user_children = ajax_utf8(textFilter(ucfirst($_POST['children'])));
			$user_grandchildren = ajax_utf8(textFilter(ucfirst($_POST['grandchildren'])));
			$user_day = intval($_POST['day']);
			$user_month = intval($_POST['month']);
			$user_year = intval($_POST['year']);
			$user_dprivacy = intval($_POST['dprivacy']);
			$user_birthday = $user_year.'-'.$user_month.'-'.$user_day.'-'.$user_dprivacy;
			
			$type_profile = intval($_POST['type_profile']);
			if($type_profile < 0 OR $type_profile > 5) $type_profile = 1;
		
			if($user_sex){
				$post_sp = intval($_POST['sp']);
				if($post_sp >= 1 AND $post_sp <= 7)
					$sp = $post_sp;
				else
					$sp = false;
				
				if($sp){
					$sp_val = intval($_POST['sp_val']);
					$user_sp = $sp.'|'.$sp_val;
				}
			}
			
				
			$db->query("UPDATE `".PREFIX."_users` SET user_sex = '{$user_sex}', user_dev = '{$user_dev}', user_otcestvo = '{$user_otcestvo}', user_grandparents = '{$user_grandparents}', user_parents = '{$user_parents}', user_siblings = '{$user_siblings}', user_children = '{$user_children}', user_grandchildren = '{$user_grandchildren}', user_hometown = '{$user_hometown}', user_day = '{$user_day}', user_month = '{$user_month}', user_year = '{$user_year}', user_birthday = '{$user_birthday}', user_sp = '{$user_sp}', type_profile = '{$type_profile}', user_name = '{$user_name}', user_lastname = '{$user_lastname}', user_search_pref = '{$user_name} {$user_lastname}' WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Смена диза
  case "green":
   $user_id = intval($user_info['user_id']);
    $db->query("UPDATE `".PREFIX."_users` SET diz = '2' WHERE user_id = '$user_id'");
   header("location:/settings");
   //die();
  break;
  case "def":
   $user_id = intval($user_info['user_id']);
   $db->query("UPDATE `".PREFIX."_users` SET diz = '1' WHERE user_id = '$user_id'");
   header("location:/settings");
   //die();
  break;
		
		//Сохранение контактов
		case "save_contact":
			NoAjaxQuery();
            
			$user_rai = ajax_utf8(textFilter($_POST['rai']));
			$user_metro = ajax_utf8(textFilter(ucfirst($_POST['metro'])));
			$user_ulica = ajax_utf8(textFilter(ucfirst($_POST['ulica'])));
			$user_nazvanie = ajax_utf8(textFilter(ucfirst($_POST['nazvanie'])));
			$user_country = intval($_POST['country']);
			$user_city = intval($_POST['city']);
			$xfields = array();
			$xfields['vk'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['vk'], 0, 200))));
			$xfields['od'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['od'], 0, 200))));
			$xfields['phone'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['phone'], 0, 200))));
			$xfields['skype'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['skype'], 0, 200))));
			$xfields['fb'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['fb'], 0, 200))));
			$xfields['icq'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['icq'], 0, 200))));
			$xfields['site'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['site'], 0, 200))));
			
			if($user_country > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_country."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_city."'");
					
				$user_country_city_name = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_city = 0;
				$user_country = 0;
				$user_country_city_name = '';
			}	
			
			foreach($xfields as $name => $value){
				$value = str_replace("|", "&#124;", $value);
				if(strlen($value) > 0)
					$xfieldsdata .= $name.'|'.$value.'||';
			}
			
			$db->query("UPDATE `".PREFIX."_users` SET user_xfields = '{$xfieldsdata}', user_country = '{$user_country}', user_city = '{$user_city}', user_country_city_name = '{$user_country_city_name}', user_rai = '{$user_rai}', user_metro = '{$user_metro}', user_ulica = '{$user_ulica}', user_nazvanie = '{$user_nazvanie}'  WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			
			echo 'ok';
			
			die();
		break;
		
        //Сохранение интересов
		case "save_interests":
			NoAjaxQuery();
			
           $user_activity = ajax_utf8(textFilter(ucfirst($_POST['activity'])));
		   $user_interes = ajax_utf8(textFilter(ucfirst($_POST['interes'])));
		   $user_myinfo = ajax_utf8(textFilter(ucfirst($_POST['myinfo'])));
		   $user_music = ajax_utf8(textFilter(ucfirst($_POST['music'])));
		   $user_kino = ajax_utf8(textFilter(ucfirst($_POST['kino'])));
		   $user_shou = ajax_utf8(textFilter(ucfirst($_POST['shou'])));
		   $user_serial = ajax_utf8(textFilter(ucfirst($_POST['serial'])));
		   $user_books = ajax_utf8(textFilter(ucfirst($_POST['books'])));
		   $user_games = ajax_utf8(textFilter(ucfirst($_POST['games'])));
		   $user_quote = ajax_utf8(textFilter(ucfirst($_POST['quote'])));
		   
		   $db->query("UPDATE `".PREFIX."_users` SET user_activity = '{$user_activity}', user_interes = '{$user_interes}', user_myinfo = '{$user_myinfo}', user_music = '{$user_music}', user_kino = '{$user_kino}', user_shou = '{$user_shou}', user_serial = '{$user_serial}', user_books = '{$user_books}', user_games = '{$user_games}', user_quote = '{$user_quote}'  WHERE user_id = '{$user_info['user_id']}'");
		   
		   mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
		   mozg_clear_cache();
		    
			echo 'ok';

			die();	
			
		break;
		
		//Сохранение среднего образования
		case "save_education":
			NoAjaxQuery();
			
			
		   $user_countrysr = intval($_POST['country']);
		   $user_citysr = intval($_POST['city']);
		   $user_shkola = ajax_utf8(textFilter($_POST['shkola']));
		   $user_datasr = intval($_POST['datasr']);
		   $user_nacalosr = intval($_POST['nacalosr']);
		   $user_konecsr = intval($_POST['konecsr']);
		   $user_klass = intval($_POST['klass']);
		   $user_spec = ajax_utf8(textFilter($_POST['spec']));
		  
		   if($user_countrysr > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countrysr."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_citysr."'");
					
				$user_country_city_namesr = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_citysr = 0;
				$user_countrysr = 0;
				$user_country_city_namesr = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countrysr = '{$user_countrysr}', user_citysr = '{$user_citysr}', user_shkola = '{$user_shkola}', user_datasr = '{$user_datasr}', user_nacalosr = '{$user_nacalosr}', user_konecsr = '{$user_konecsr}', user_country_city_namesr = '{$user_country_city_namesr}', user_spec = '{$user_spec}', user_klass = '{$user_klass}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Сохранение высшего образования
		case "save_higher_education":
			NoAjaxQuery();
			
			
		   $user_countryvi = intval($_POST['country']);
		   $user_cityvi = intval($_POST['city']);
		   $user_vuz = ajax_utf8(textFilter($_POST['vuz']));
		   $user_fac = ajax_utf8(textFilter($_POST['fac']));
		   $user_form = intval($_POST['form']);
		   $user_statusvi = intval($_POST['statusvi']);
		   $user_datavi = intval($_POST['datavi']);
		   
		  
		   if($user_countryvi > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countryvi."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_cityvi."'");
					
				$user_country_city_namevi = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_cityvi = 0;
				$user_countryvi = 0;
				$user_country_city_namevi = '';
			}	
	
            $db->query("UPDATE `".PREFIX."_users` SET user_countryvi = '{$user_countryvi}', user_cityvi = '{$user_cityvi}', user_vuz = '{$user_vuz}', user_fac = '{$user_fac}', user_form = '{$user_form}', user_statusvi = '{$user_statusvi}', user_country_city_namevi = '{$user_country_city_namevi}', user_datavi = '{$user_datavi}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Сохранение карьеры
		case "save_career":
			NoAjaxQuery();
			
			
		   $user_countryca = intval($_POST['country']);
		   $user_cityca = intval($_POST['city']);
		   $user_mesto = ajax_utf8(textFilter($_POST['mesto']));
		   $user_nacaloca = intval($_POST['nacaloca']);
		   $user_konecca = intval($_POST['konecca']);
		   $user_dolj = ajax_utf8(textFilter($_POST['dolj']));
		  
		   if($user_countryca > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countryca."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_cityca."'");
					
				$user_country_city_nameca = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_cityca = 0;
				$user_countryca = 0;
				$user_country_city_nameca = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countryca = '{$user_countryca}', user_cityca = '{$user_cityca}', user_mesto = '{$user_mesto}', user_dolj = '{$user_dolj}', user_nacaloca = '{$user_nacaloca}', user_konecca = '{$user_konecca}', user_country_city_nameca = '{$user_country_city_nameca}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Сохранение военной службы
		case "save_military":
			NoAjaxQuery();
			
			
		   $user_countrysl = intval($_POST['country']);
		   $user_citysl = intval($_POST['city']);
		   $user_chast = ajax_utf8(textFilter($_POST['chast']));
           $user_zvanie = ajax_utf8(textFilter($_POST['zvanie']));
		   $user_nacalosl = intval($_POST['nacalosl']);
		   $user_konecsl = intval($_POST['konecsl']);
		  
		   if($user_countrysl > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countrysl."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_citysl."'");
					
				$user_country_city_namesl = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_citysl = 0;
				$user_countrysl = 0;
				$user_country_city_namesl = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countrysl = '{$user_countrysl}', user_citysl = '{$user_citysl}', user_chast = '{$user_chast}', user_zvanie = '{$user_zvanie}', user_nacalosl = '{$user_nacalosl}', user_konecsl = '{$user_konecsl}', user_country_city_namesl = '{$user_country_city_namesl}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Сохранение жизненной позиции
		case "save_personal":
			NoAjaxQuery();
		   
		   $user_pred = intval($_POST['pred']);
		   $user_miro = ajax_utf8(textFilter($_POST['miro']));
		   $user_jizn = intval($_POST['jizn']);
		   $user_ludi = intval($_POST['ludi']);
		   $user_kurenie = intval($_POST['kurenie']);
		   $user_alkogol = intval($_POST['alkogol']);
		   $user_narkotiki = intval($_POST['narkotiki']);
		   $user_vdox = ajax_utf8(textFilter($_POST['vdox']));
           
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_pred = '{$user_pred}', user_miro = '{$user_miro}', user_jizn = '{$user_jizn}', user_ludi = '{$user_ludi}', user_kurenie = '{$user_kurenie}', user_alkogol = '{$user_alkogol}', user_narkotiki = '{$user_narkotiki}', user_vdox = '{$user_vdox}' WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//Страница Редактирование контактов
		case "contact":
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_contact'];
			$tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_xfields, user_rai, user_metro, user_ulica, user_nazvanie, user_country, user_city FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			//################## Загружаем Страны ##################//
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_country'], $all_country));
			
			//################## Загружаем Города ##################//
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_country']}' ORDER by `name` ASC", true, "country_city_".$row['user_country'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

			$tpl->set('{city}', installationSelected($row['user_city'], $all_city));
			
			$tpl->set('{rai}', $row['user_rai']);
			$tpl->set('{metro}', $row['user_metro']);
			$tpl->set('{ulica}', $row['user_ulica']);
			$tpl->set('{nazvanie}', $row['user_nazvanie']);
			$xfields = xfieldsdataload($row['user_xfields']);
			$tpl->set('{vk}', stripslashes($xfields['vk']));
			$tpl->set('{od}', stripslashes($xfields['od']));
			$tpl->set('{fb}', stripslashes($xfields['fb']));
			$tpl->set('{skype}', stripslashes($xfields['skype']));
			$tpl->set('{icq}', stripslashes($xfields['icq']));
			$tpl->set('{phone}', stripslashes($xfields['phone']));
			$tpl->set('{site}', stripslashes($xfields['site']));
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[contact]', '');
			$tpl->set('[/contact]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//Страница Редактирование интересов
		case "interests":
		$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_interests'];
            $tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_activity, user_interes, user_myinfo, user_music, user_kino, user_shou, user_serial, user_books, user_games, user_quote FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$tpl->set('{activity}', $row['user_activity']);
			$tpl->set('{interes}', $row['user_interes']);
			$tpl->set('{myinfo}', $row['user_myinfo']);
			$tpl->set('{music}', $row['user_music']);
			$tpl->set('{kino}', $row['user_kino']);
			$tpl->set('{shou}', $row['user_shou']);
			$tpl->set('{serial}', $row['user_serial']);
			$tpl->set('{books}', $row['user_books']);
			$tpl->set('{games}', $row['user_games']);
			$tpl->set('{quote}', $row['user_quote']);
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[interests]', '');
			$tpl->set('[/interests]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		  //Страница Редактирование среднего образования
		case "education":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_education'];
            $tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_shkola, user_datasr, user_klass, user_spec, user_nacalosr, user_konecsr, user_countrysr, user_citysr  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countrysr'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countrysr']}' ORDER by `name` ASC", true, "country_city_".$row['user_countrysr'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

			$tpl->set('{city}', installationSelected($row['user_citysr'], $all_city));
			
			$tpl->set('{shkola}', $row['user_shkola']);
			
			$tpl->set('{nacalosr}', installationSelected($row['user_nacalosr'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set('{konecsr}', installationSelected($row['user_konecsr'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{datasr}', installationSelected($row['user_datasr'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set('{klass}', installationSelected($row['user_klass'], 
			'<option value="1">а</option><option value="2">б</option><option value="3">в</option><option value="4">г</option><option value="5">д</option><option value="6">е</option><option value="7">ж</option><option value="8">з</option><option value="9">и</option><option value="10">к</option><option value="11">л</option><option value="12">м</option><option value="13">н</option><option value="14">о</option><option value="15">п</option><option value="16">р</option><option value="17">с</option><option value="18">т</option><option value="19">у</option><option value="20">ф</option><option value="21">х</option><option value="22">ц</option><option value="23">ч</option><option value="24">ш</option><option value="25">щ</option><option value="26">ы</option><option value="27">э</option><option value="28">ю</option><option value="29">я</option><option value="30">а2</option><option value="31">б2</option><option value="32">в2</option><option value="33">г2</option><option value="34">д2</option><option value="35">е2</option><option value="36">ж2</option><option value="37">з2</option><option value="38">и2</option><option value="39">к2</option><option value="40">л2</option><option value="41">м2</option><option value="42">н2</option><option value="43">о2</option><option value="44">п2</option><option value="45">р2</option><option value="46">с2</option><option value="47">т2</option><option value="48">у2</option><option value="49">ф2</option><option value="50">х2</option><option value="51">ц2</option><option value="52">ч2</option><option value="53">ш2</option><option value="54">щ2</option><option value="55">ы2</option><option value="56">э2</option><option value="57">ю2</option><option value="58">я2</option><option value="59">а3</option><option value="60">б3</option><option value="61">в3</option><option value="62">г3</option><option value="63">д3</option><option value="64">е3</option><option value="65">ж3</option><option value="66">з3</option><option value="67">и3</option><option value="68">к3</option><option value="69">л3</option><option value="70">м3</option><option value="71">н3</option><option value="72">о3</option><option value="73">п3</option><option value="74">р3</option><option value="75">с3</option><option value="76">т3</option><option value="77">у3</option><option value="78">ф3</option><option value="79">х3</option><option value="80">ц3</option><option value="81">ч3</option><option value="82">ш3</option><option value="83">щ3</option><option value="84">ы3</option><option value="85">э3</option><option value="86">ю3</option><option value="87">я3</option><option value="88">1</option><option value="89">2</option><option value="90">3</option><option value="91">4</option><option value="92">5</option><option value="93">6</option><option value="94">7</option><option value="95">8</option><option value="96">9</option><option value="97">10</option><option value="98">11</option><option value="99">12</option><option value="100">13</option><option value="101">14</option><option value="102">15</option>'));
			$tpl->set('{spec}', $row['user_spec']);
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[education]', '');
			$tpl->set('[/education]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//Страница Редактирование высшего образования
		case "higher_education":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_higher_education'];
            $tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_vuz, user_fac, user_form, user_statusvi, user_datavi, user_countryvi, user_cityvi  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countryvi'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countryvi']}' ORDER by `name` ASC", true, "country_city_".$row['user_countryvi'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

		   $tpl->set('{city}', installationSelected($row['user_cityvi'], $all_city));
		   $tpl->set('{vuz}', $row['user_vuz']);
		   $tpl->set('{fac}', $row['user_fac']);			
		   $tpl->set('{form}', installationSelected($row['user_form'], 
			'<option value="1">Дневная</option>
			 <option value="2">Вечерняя</option>
			 <option value="3">Заочная</option>'));
		   $tpl->set('{statusvi}', installationSelected($row['user_statusvi'], 
			'<option value="1">Абитуриент</option>
			 <option value="2">Студент(специалист)</option>
			 <option value="3">Студент(бакалавр)</option>
			 <option value="4">Студент(магистр)</option>
			 <option value="5">Выпускник(специалист)</option>
			 <option value="6">Выпускник(бакалавр)</option>
			 <option value="7">Выпускник(магистр)</option>			 
			 <option value="8">Аспирант</option>
			 <option value="9">Кандидат наук</option>
			 <option value="10">Доктор наук</option>'));
			$tpl->set('{datavi}', installationSelected($row['user_datavi'],
			 '<option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[higher_education]', '');
			$tpl->set('[/higher_education]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;    
		
		//Страница Редактирование карьеры
		case "career":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_career'];
            $tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_mesto, user_nacaloca, user_konecca, user_dolj, user_countryca, user_cityca  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
		    
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countryca'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countryca']}' ORDER by `name` ASC", true, "country_city_".$row['user_countryca'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';
				
			$tpl->set('{mesto}', $row['user_mesto']);
			$tpl->set('{nacaloca}', installationSelected($row['user_nacaloca'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{konecca}', installationSelected($row['user_konecca'],
			 '<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>')); 
			$tpl->set('{dolj}', $row['user_dolj']);
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[career]', '');
			$tpl->set('[/career]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		    
			//Страница Редактирование службы
		case "military":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_military'];
            $tpl->load_template('editprofile.tpl');
		    $row = $db->super_query("SELECT user_chast, user_zvanie, user_nacalosl, user_konecsl, user_countrysl, user_citysl  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countrysl'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countrysl']}' ORDER by `name` ASC", true, "country_city_".$row['user_countrysl'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';
				
			$tpl->set('{chast}', $row['user_chast']);
			$tpl->set('{zvanie}', $row['user_zvanie']);	
			$tpl->set('{nacalosl}', installationSelected($row['user_nacalosl'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{konecsl}', installationSelected($row['user_konecsl'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[military]', '');
			$tpl->set('[/military]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
			
			
			
			//Страница Редактирование жизненная позиция
			case "personal":
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_personal'];
            $tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_pred, user_miro, user_jizn, user_ludi, user_kurenie, user_alkogol, user_narkotiki, user_vdox FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
		
		    $tpl->set('{pred}', installationSelected($row['user_pred'], 
			'<option value="1">Индифферентные</option>
			 <option value="2">Коммунистические</option>
			 <option value="3">Социалистические</option>
			 <option value="4">Умеренные</option>
			 <option value="5">Либеральные</option>
			 <option value="6">Консервативные</option>
			 <option value="7">Монархические</option>			 
			 <option value="8">Ультраконсервативные</option>
			 <option value="9">Либертарические</option>'));
			$tpl->set('{miro}', $row['user_miro']);
			$tpl->set('{jizn}', installationSelected($row['user_jizn'], 
			'<option value="1">Семья и дети</option>
			 <option value="2">Карьера и дети</option>
			 <option value="3">Развлечения и отдых</option>
			 <option value="4">Наука и исследование</option>
			 <option value="5">Совершенствование мира</option>
			 <option value="6">Саморазвитие</option>
			 <option value="7">Красота и искуство</option>			 
			 <option value="8">Слава и влияние</option>'));
		    $tpl->set('{ludi}', installationSelected($row['user_ludi'], 
			'<option value="1">Ум и креативность</option>
			 <option value="2">Доброта и честность</option>
			 <option value="3">Красота и здоровье</option>
			 <option value="4">Власть и богатство</option>
			 <option value="5">Смелость и упорство</option>
			 <option value="6">Юмор и жизнелюбие</option>'));
			$tpl->set('{kurenie}', installationSelected($row['user_kurenie'], 
			'<option value="1">Резко негативное</option>
			 <option value="2">Негативное</option>
			 <option value="3">Компромиссное</option>
			 <option value="4">Нейтральное</option>
			 <option value="5">Положительное</option>'));
			$tpl->set('{alkogol}', installationSelected($row['user_alkogol'], 
			'<option value="1">Резко негативное</option>
			 <option value="2">Негативное</option>
			 <option value="3">Компромиссное</option>
			 <option value="4">Нейтральное</option>
			 <option value="5">Положительное</option>'));
			$tpl->set('{narkotiki}', installationSelected($row['user_narkotiki'], 
			'<option value="1">Резко негативное</option>
			 <option value="2">Негативное</option>
			 <option value="3">Компромиссное</option>
			 <option value="4">Нейтральное</option>
			 <option value="5">Положительное</option>'));
			$tpl->set('{vdox}', $row['user_vdox']);
            $tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set('[personal]', '');
			$tpl->set('[/personal]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		
		
		//Страница Редактирование фотографии
		case "photo":
			$user_speedbar = $lang['editmyprofile'].' &raquo; Фото';
			$tpl->load_template('/editprofile/editprofilephoto.tpl');
            //################### Спецэффект на фото ###################//
            $row_photo = $db->super_query("SELECT user_photo, user_photo_style, user_photo_effect FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
           	if($row_photo['user_photo']){
                $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$id.'/'.$row_photo['user_photo']);
			} else {
                $tpl->set('{ava}', '{theme}/images/no_ava.gif');
			}
            if($row_photo['user_photo_effect'] == 0){
                $tpl->set('[effects]', '');
                $tpl->set('[/effects]', '');
            } else {
                $tpl->set_block("'\\[effects\\](.*?)\\[/effects\\]'si","");
            }
            if($row_photo['user_photo_effect'] != 0){
                $tpl->set('[effects-yes]', '');
                $tpl->set('[/effects-yes]', '');
            } else {
                $tpl->set_block("'\\[effects-yes\\](.*?)\\[/effects-yes\\]'si","");
            }
            $user_photo_style = explode('|', $row_photo['user_photo_style']);
            if($user_photo_style[0] == 0 || $user_photo_style[1] == 0)
            { 
                $tpl->set('{width}', '206');
                $tpl->set('{height}', '212');
            } else {
                $tpl->set('{width}', $user_photo_style[0]);
                $tpl->set('{height}', $user_photo_style[1]);
            }
            $tpl->set('{effect}', $row_photo['user_photo_effect']);
			$tpl->compile('content');
			$tpl->clear();
		break;
        
        //Страница Добавление флешэффекта
		case "effect":
			$user_speedbar = $lang['editmyprofile'].' &raquo; Фото';
			$tpl->load_template('/editprofile/editprofileeffects.tpl');
            //################### Спецэффект на фото ###################//
            $row_photo = $db->super_query("SELECT user_photo, user_photo_style, user_photo_effect FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
           	if($row_photo['user_photo']){
                $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$id.'/'.$row_photo['user_photo']);
			} else {
                $tpl->set('{ava}', '{theme}/images/no_ava.gif');
			}
            if($row_photo['user_photo_effect'] == 0){
                $tpl->set('[effects]', '');
                $tpl->set('[/effects]', '');
            } else {
                $tpl->set_block("'\\[effects\\](.*?)\\[/effects\\]'si","");
            }
            if($row_photo['user_photo_effect'] != 0){
                $tpl->set('[effects-yes]', '');
                $tpl->set('[/effects-yes]', '');
            } else {
                $tpl->set_block("'\\[effects-yes\\](.*?)\\[/effects-yes\\]'si","");
            }
            $user_photo_style = explode('|', $row_photo['user_photo_style']);
            if($user_photo_style[0] == 0 || $user_photo_style[1] == 0)
            { 
                $tpl->set('{width}', '206');
                $tpl->set('{height}', '212');
            } else {
                $tpl->set('{width}', $user_photo_style[0]);
                $tpl->set('{height}', $user_photo_style[1]);
            }
            $tpl->set('{effect}', $row_photo['user_photo_effect']);
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//Страница миниатюры
		case "miniature":
			
			$row = $db->super_query("SELECT user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			if($row['user_photo']){
			
				$tpl->load_template('miniature/main.tpl');
				$tpl->set('{user-id}', $user_info['user_id']);
				$tpl->set('{ava}', $row['user_photo']);
				$tpl->compile('content');
				
				AjaxTpl();
			
			} else
				echo '1';
			
			exit();
			
		break;
		
		//Сохранение миниатюры
		case "miniature_save":
			
			$row = $db->super_query("SELECT user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");

			$i_left = intval($_POST['i_left']);
			$i_top = intval($_POST['i_top']);
			$i_width = intval($_POST['i_width']);
			$i_height = intval($_POST['i_height']);

			if($row['user_photo'] AND $i_width >= 100 AND $i_height >= 100 AND $i_left >= 0 AND $i_height >= 0){

				include_once ENGINE_DIR.'/classes/images.php';

				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/{$row['user_photo']}");
				$tmb->size_auto($i_width."x".$i_height, 0, "{$i_left}|{$i_top}");
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				$tmb->size_auto("100x100", 1);
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				$tmb->size_auto("50x50");
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/50_{$row['user_photo']}");
				
				echo $user_info['user_id'];
			
			} else
				echo 'err';
			
			exit();
			
		break;

		default:
//################### Загрузка обложки ###################//
		case "upload_cover":
		
			NoAjaxQuery();
			
			//Получаем данные о файле
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			$image_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20); // имя файла
			$image_size = $_FILES['uploadfile']['size']; // размер файла
			$type = end(explode(".", $image_name)); // формат файла
			
			$max_size = 1024 * 7000;

			//Проверка размера
			if($image_size <= $max_size){
				
				//Разришенные форматы
				$allowed_files = explode(', ', 'jpg, jpeg, jpe, png, gif');
				
				//Проверям если, формат верный то пропускаем
				if(in_array(strtolower($type), $allowed_files)){
					
					$res_type = strtolower('.'.$type);
					
					$upDir = ROOT_DIR."/uploads/users/{$user_info['user_id']}/";
					
					$rImg = $upDir.$image_rename.$res_type;
					
					if(move_uploaded_file($image_tmp, $rImg)){
						
						//Подключаем класс для фотографий
						include_once ENGINE_DIR.'/classes/images.php';
						
						//Создание маленькой копии
						$tmb = new thumbnail($rImg);
						$tmb->size_auto('870', 1);
						$tmb->jpeg_quality('100');
						$tmb->save($rImg);
						
						//Выводим и удаляем пред. обложку
						$row = $db->super_query("SELECT user_cover FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
						if($row){
							
							@unlink($upDir.$row['user_cover']);
							
						}

						$imgData = getimagesize($rImg);
						$rImgsData = round($imgData[1] / ($imgData[0] / 870));

						//Обновдяем обложку в базе
						$pos = round(($rImgsData / 2) - 100);
						
						if($rImgsData <= 230){
							$rImgsData = 230;
							$pos = 0;
						}
						
						$db->query("UPDATE `".PREFIX."_users` SET user_cover = '{$image_rename}{$res_type}', user_cover_pos = '{$pos}' WHERE user_id = '{$user_info['user_id']}'");
						
						echo $user_info['user_id'].'/'.$image_rename.$res_type.'|'.$rImgsData;
						
						//Чистим кеш
						mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
						
					}
					
				} else
					echo 2;
			
			} else
				echo 1;
		
			exit();
			
		break;
		
		//################### Сохранение новой позиции обложки ###################//
		case "savecoverpos":
			
			NoAjaxQuery();
						
			$pos = intval($_POST['pos']);
			if($pos < 0) $pos = 0;
			
			$db->query("UPDATE `".PREFIX."_users` SET user_cover_pos = '{$pos}' WHERE user_id = '{$user_info['user_id']}'");
			
			//Чистим кеш
			mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
						
			exit();
			
		break;
		
		//################### Удаление обложки ###################//
		case "delcover":
		
			NoAjaxQuery();

			//Выводим и удаляем пред. обложку
			$row = $db->super_query("SELECT user_cover FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			if($row){
				
				$upDir = ROOT_DIR."/uploads/users/{$user_info['user_id']}/";				
				@unlink($upDir.$row['user_cover']);
							
			}
						
			$db->query("UPDATE `".PREFIX."_users` SET user_cover_pos = '', user_cover = '' WHERE user_id = '{$user_info['user_id']}'");
			
			//Чистим кеш
			mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
						
			exit();
			
		break;
		        default:
			//Страница Редактирование основное
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_genereal'];
			
			$tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_name, user_lastname, user_dev, user_otcestvo, user_grandparents, user_parents, user_siblings, user_children, user_grandchildren, user_hometown, user_sex, user_day, user_month, user_year, user_sp, type_profile, user_birthday FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$tpl->set('{name}', $row['user_name']);
			$tpl->set('{lastname}', $row['user_lastname']);
			
			
			$pbdate = explode("-", $row['user_birthday']);
	
			    if($row['user_sex']== 2){
				$tpl->set('{dev}', $row['user_dev']);
				$tpl->set('[dev]','');
				$tpl->set('[/dev]','');
			} else 
				$tpl->set_block("'\\[dev\\](.*?)\\[/dev\\]'si","");
			
			
			$tpl->set('{otcestvo}', $row['user_otcestvo']);
			$tpl->set('{hometown}', $row['user_hometown']);
			$tpl->set('{grandparents}', $row['user_grandparents']);
			$tpl->set('{parents}', $row['user_parents']);
			$tpl->set('{siblings}', $row['user_siblings']);
			$tpl->set('{children}', $row['user_children']);
			$tpl->set('{grandchildren}', $row['user_grandchildren']);
		
		
			
			$tpl->set('{sex}', installationSelected($row['user_sex'], '<option value="1">мужской</option><option value="2">женский</option>'));
			
			$tpl->set('{user-day}', installationSelected($row['user_day'], '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'));
			
			$tpl->set('{user-month}', installationSelected($row['user_month'], '<option value="1">Января</option><option value="2">Февраля</option><option value="3">Марта</option><option value="4">Апреля</option><option value="5">Мая</option><option value="6">Июня</option><option value="7">Июля</option><option value="8">Августа</option><option value="9">Сентября</option><option value="10">Октября</option><option value="11">Ноября</option><option value="12">Декабря</option>'));
			
			$tpl->set('{user-year}', installationSelected($row['user_year'], '<option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			
			$tpl->set('{data-profiles}', installationSelected($pbdate['3'], '<option value="1">Показывать дату рождения</option><option value="2">Показывать только месяц и день</option><option value="3">Не показывать дату рождения</option>'));
		
			
			$user_sp = explode('|', $row['user_sp']);
			if($user_sp[1]){
				$rowSp = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_sp[1]}'");
				$tpl->set('{sp-name}', $rowSp['user_search_pref']);
				$tpl->set_block("'\\[sp\\](.*?)\\[/sp\\]'si","");
				
				if($row['user_sex'] == 1){
					if($user_sp[0] == 2)
						$tpl->set('{sp-text}', 'Подруга:');
					elseif($user_sp[0] == 3)
						$tpl->set('{sp-text}', 'Невеста:');
					else if($user_sp[0] == 4)
						$tpl->set('{sp-text}', 'Жена:');
					else if($user_sp[0] == 5)
						$tpl->set('{sp-text}', 'Любимая:');
					else
						$tpl->set('{sp-text}', 'Партнёр:');
				} else {
					if($user_sp[0] == 2)
						$tpl->set('{sp-text}', 'Друг:');
					elseif($user_sp[0] == 3)
						$tpl->set('{sp-text}', 'Жених:');
					else if($user_sp[0] == 4)
						$tpl->set('{sp-text}', 'Муж:');
					else if($user_sp[0] == 5)
						$tpl->set('{sp-text}', 'Любимый:');
					else
						$tpl->set('{sp-text}', 'Партнёр:');
				}
			} else {
				$tpl->set('[sp]', '');
				$tpl->set('[/sp]', '');
			}
			
			if($row['user_sex'] == 2){
				$tpl->set('[user-m]', '');
				$tpl->set('[/user-m]', '');
				$tpl->set_block("'\\[user-w\\](.*?)\\[/user-w\\]'si","");
			} elseif($row['user_sex'] == 1){
				$tpl->set('[user-w]', '');
				$tpl->set('[/user-w]', '');
				$tpl->set_block("'\\[user-m\\](.*?)\\[/user-m\\]'si","");
			} else {
				$tpl->set('[sp-all]', '');
				$tpl->set('[/sp-all]', '');
				$tpl->set('[user-m]', '');
				$tpl->set('[/user-m]', '');
				$tpl->set('[user-w]', '');
				$tpl->set('[/user-w]', '');
			}
			
			$tpl->copy_template = str_replace("[instSelect-sp-{$user_sp[0]}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-(.*?)\\]'si","");
			
			$tpl->copy_template = str_replace("[ainstSelect-type-{$row['type_profile']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[ainstSelect-(.*?)\\]'si","");
			
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[general]', '');
			$tpl->set('[/general]', '');
			$tpl->compile('content');
			$tpl->clear();
	}
	
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>
