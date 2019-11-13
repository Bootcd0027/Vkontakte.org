<?php
/* 
	Appointment: Поиск
	File: search.php 
	Author: f0rt1 
	Engine: Vii Engine
	Copyright: NiceWeb Group (с) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	Данный код защищен авторскими правами
*/
if(!defined('MOZG')){
	die('Hacking attempt!');
}
if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$metatags['title'] = $lang['search'];

	$mobile_speedbar = 'Поиск';
	
	$_SERVER['QUERY_STRING'] = strip_tags($_SERVER['QUERY_STRING']);

	$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
	$user_id = $user_info['user_id'];

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 5000;
	$limit_page =($page-1)*$gcount;

	$query = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $query = $db->safesql(strip_data(urldecode($_GET['query'])));
	$query = strtr($query, array(' ' => '%')); //Замеянем пробелы на проценты чтоб тоиск был точнее
	
	$discussion_type = intval($_GET['discussion_type']) ? intval($_GET['discussion_type']) : 2;
	$type = intval($_GET['type']) ? intval($_GET['type']) : 1;
	$sex = intval($_GET['sex']);
	$rai = intval($_GET['rai']);
	$metro = intval($_GET['metro']);
	$ulica = intval($_GET['ulica']);
	$nazvanie = intval($_GET['nazvanie']);
	$activity = intval($_GET['activity']);
	$interes = intval($_GET['interes']);
	$music = intval($_GET['music']);
	$kino = intval($_GET['kino']);
	$shou = intval($_GET['shou']);
	$serial = intval($_GET['serial']);
	$books = intval($_GET['books']);
	$games = intval($_GET['games']);
	$shkola = intval($_GET['shkola']);
	$klass = intval($_GET['klass']);
	$rai = intval($_GET['rai']);
	$metro = intval($_GET['metro']);
	$ulica = intval($_GET['ulica']);
	$nazvanie = intval($_GET['nazvanie']);
	$activity = intval($_GET['activity']);
	$interes = intval($_GET['interes']);
	$music = intval($_GET['music']);
	$kino = intval($_GET['kino']);
	$shou = intval($_GET['shou']);
	$serial = intval($_GET['serial']);
	$books = intval($_GET['books']);
	$games = intval($_GET['games']);
	$shkola = intval($_GET['shkola']);
	$klass = intval($_GET['klass']);
	$spec = intval($_GET['spec']);
	$hometown = intval($_GET['hometown']);
	$vuz = intval($_GET['vuz']);
	$fac = intval($_GET['fac']);
	$form = intval($_GET['form']);
	$statusvi = intval($_GET['statusvi']);
	$mesto = intval($_GET['mesto']);
	$dolj = intval($_GET['dolj']);
	$chast = intval($_GET['chast']);
	$zvanie = intval($_GET['zvanie']);
	$pred = intval($_GET['pred']);
	$miro = intval($_GET['miro']);
	$jizn = intval($_GET['jizn']);
	$ludi = intval($_GET['ludi']);
	$kurenie = intval($_GET['kurenie']);
	$alkogol = intval($_GET['alkogol']);
	$narkotiki = intval($_GET['narkotiki']);
	$vdox = intval($_GET['vdox']);
	$day = intval($_GET['day']);
	$month = intval($_GET['month']);
	$year = intval($_GET['year']);
	$country = intval($_GET['country']);
	$city = intval($_GET['city']);
	$online = intval($_GET['online']);
	$user_photo = intval($_GET['user_photo']);
	$sp = intval($_GET['sp']);
	
	$type_profile = intval($_GET['type_profile']);
	if($type_profile < 0 OR $type_profile > 5) $type_profile = 1;

				
	//Задаём параметры сортировки
	if($filecontents) $sql_sort .= $for_new_sql_updates;
	if($type_profile) $sql_sort .= "AND type_profile = '{$type_profile}'";
	if($sex) $sql_sort .= "AND user_sex = '{$sex}'";
	if($rai) $sql_sort .= "AND user_rai = '{$rai}'";
	if($metro) $sql_sort .= "AND user_metro = '{$metro}'";
	if($ulica) $sql_sort .= "AND user_ulica = '{$ulica}'";
	if($nazvanie) $sql_sort .= "AND user_nazvanie = '{$nazvanie}'";
	if($activity) $sql_sort .= "AND user_activity = '{$activity}'";
	if($interes) $sql_sort .= "AND user_interes = '{$interes}'";
	if($myinfo) $sql_sort .= "AND user_myinfo = '{$myinfo}'";
	if($music) $sql_sort .= "AND user_music = '{$music}'";
	if($kino) $sql_sort .= "AND user_kino = '{$kino}'";
	if($shou) $sql_sort .= "AND user_shou = '{$shou}'";
	if($serial) $sql_sort .= "AND user_serial = '{$serial}'";
	if($books) $sql_sort .= "AND user_books = '{$books}'";
	if($games) $sql_sort .= "AND user_games = '{$games}'";
	if($shkola) $sql_sort .= "AND user_shkola = '{$shkola}'";
    if($klass) $sql_sort .= "AND user_klass = '{$klass}'";
	if($spec) $sql_sort .= "AND user_spec = '{$spec}'";
	if($hometown) $sql_sort .= "AND user_hometown = '{$hometown}'";
	if($vuz) $sql_sort .= "AND user_vuz = '{$vuz}'";
	if($fac) $sql_sort .= "AND user_fac = '{$fac}'";
	if($form) $sql_sort .= "AND user_form = '{$form}'";
	if($statusvi) $sql_sort .= "AND user_statusvi = '{$statusvi}'";
	if($mesto) $sql_sort .= "AND user_mesto = '{$mesto}'";
	if($dolj) $sql_sort .= "AND user_dolj = '{$dolj}'";
	if($chast) $sql_sort .= "AND user_chast = '{$chast}'";
	if($zvanie) $sql_sort .= "AND user_zvanie = '{$zvanie}'";
	if($pred) $sql_sort .= "AND user_pred = '{$pred}'";
	if($miro) $sql_sort .= "AND user_miro = '{$miro}'";
	if($jizn) $sql_sort .= "AND user_jizn = '{$jizn}'";
	if($ludi) $sql_sort .= "AND user_ludi = '{$ludi}'";
	if($kurenie) $sql_sort .= "AND user_kurenie = '{$kurenie}'";
	if($alkogol) $sql_sort .= "AND user_alkogol = '{$alkogol}'";
	if($narkotiki) $sql_sort .= "AND user_narkotiki = '{$narkotiki}'";
	if($vdox) $sql_sort .= "user_vdox = '{$vdox}'";
	if($day) $sql_sort .= "AND user_day = '{$day}'";
	if($month) $sql_sort .= "AND user_month = '{$month}'";
	if($year) $sql_sort .= "AND user_year = '{$year}'";
	if($country) $sql_sort .= "AND user_country = '{$country}'";
	if($city) $sql_sort .= "AND user_city = '{$city}'";
	if($online) $sql_sort .= "AND user_last_visit >= '{$online_time}'";
	if($user_photo) $sql_sort .= "AND user_photo != ''";
	if($sp) $sql_sort .= "AND SUBSTRING(user_sp, 1, 1) regexp '[[:<:]]({$sp})[[:>:]]'";

	//Делаем SQL Запрос в БД на вывод данных
	if($type == 1){ //Если критерий поиск "по людям"
		$sql_query = "SELECT user_id, user_search_pref, user_photo, user_rai, user_metro, user_ulica, user_nazvanie, user_activity, user_interes, user_myinfo, user_music, user_kino, user_shou, user_serial, user_books, user_games, user_shkola, user_klass, user_spec,  user_vuz, user_fac, user_form, user_statusvi, user_dolj, user_chast, user_zvanie, user_pred, user_miro, user_jizn, user_ludi, user_kurenie, user_alkogol, user_narkotiki, user_vdox, user_mesto, user_birthday, user_hometown, user_country_city_name, user_last_visit, user_logged_mobile, user_real, alias FROM `".PREFIX."_users` WHERE user_search_pref LIKE '%{$query}%' AND user_ban != 1 AND user_delet != 1 {$sql_sort} ORDER by `user_rate` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_search_pref LIKE '%{$query}%' {$sql_sort}";
	} elseif($type == 2 AND $config['video_mod'] == 'yes' AND $config['video_mod_search'] == 'yes'){ //Если критерий поиск "по видеозаписям"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS id, photo, title, add_date, comm_num, owner_user_id, original FROM `".PREFIX."_videos` WHERE original=1 and title LIKE '%{$query}%' AND privacy = 1 ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos` WHERE title LIKE '%{$query}%' AND privacy = 1 AND original=1";
	} elseif($type == 3){ //Если критерий поиск "по заметкам"
		$sql_query = "SELECT ".PREFIX."_notes.id, title, full_text, owner_user_id, date, comm_num, ".PREFIX."_users.user_photo, user_search_pref FROM ".PREFIX."_notes LEFT JOIN ".PREFIX."_users ON ".PREFIX."_notes.owner_user_id = ".PREFIX."_users.user_id WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes` WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%'";
	} elseif($type == 4){ //Если критерий поиск "по сообщества"
		$sql_query = "SELECT id, title, photo, traf, adres, preal FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%' ORDER by `traf` DESC, `photo` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%'";
	} elseif($type == 5 AND $config['audio_mod'] == 'yes' AND $config['audio_mod_search'] == 'yes'){ //Если критерий поиск "по аудиозаписи"
		$sql_query = "SELECT SQL_CALC_FOUND_ROWS aid, auser_id, name, url, artist,".PREFIX."_users.user_search_pref FROM ".PREFIX."_audio LEFT JOIN ".PREFIX."_users ON ".PREFIX."_audio.auser_id = ".PREFIX."_users.user_id WHERE `original`='1' AND name LIKE '%{$query}%' ORDER by `adate` and `original` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio` WHERE original=1 AND artist LIKE '%{$query}%'";
		} elseif($type == 6){ //Если критерий поиск "Обсуждения"
		
		if($discussion_type == 1) $sql_order_discussion = "`fdate` DESC";
		elseif($discussion_type == 2) $sql_order_discussion = "`lastdate` DESC";
		elseif($discussion_type == 3) $sql_order_discussion = "`msg_num` DESC";
		else $sql_order_discussion = "`lastdate` DESC";
		
		if($discussion_type == 4){
			$sql_where_discussion .= "AND tb1.fuser_id = '{$user_info['user_id']}'";
			$sql_where_discussion_cnt .= "WHERE fuser_id = '{$user_info['user_id']}'";
		}
		
		if(isset($query) AND !empty($query)){
		
			$sql_where_discussion .= "AND tb1.title LIKE '%{$query}%'";
			
			if($discussion_type != 4) $sql_where_discussion_cnt .= "WHERE title LIKE '%{$query}%'";
			else $sql_where_discussion_cnt .= "AND title LIKE '%{$query}%'";
			
		}
		
		if($discussion_type == 6){
			
			$sql_where_discussion = str_replace('tb1', 'tb2', $sql_where_discussion);
			$sql_where_discussion_cnt = str_replace('title', 'tb2.title', $sql_where_discussion_cnt);
			$sql_where_discussion_cnt = str_replace('WHERE', 'AND', $sql_where_discussion_cnt);
			
			$sql_query = "SELECT tb2.fid, tb2.title, lastuser_id, lastdate, msg_num, public_id, tb3.title AS pub_title, photo FROM `".PREFIX."_communities_forum_msg` tb1, `".PREFIX."_communities_forum` tb2, `".PREFIX."_communities` tb3 WHERE tb1.muser_id = '{$user_info['user_id']}' AND  tb1.fid = tb2.fid AND tb2.public_id = tb3.id AND tb3.del = '0' AND tb3.ban = '0' {$sql_where_discussion} LIMIT {$limit_page}, {$gcount}";
			$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_forum_msg` tb1, `".PREFIX."_communities_forum` tb2, `".PREFIX."_communities` tb3  WHERE tb1.muser_id = '{$user_info['user_id']}' AND tb1.fid = tb2.fid AND tb2.public_id = tb3.id AND tb3.del = '0' AND tb3.ban = '0' {$sql_where_discussion_cnt}";
			
		} else {
		
			$sql_query = "SELECT tb1.fid, tb1.title, lastuser_id, lastdate, msg_num, public_id, tb2.title AS pub_title, photo FROM `".PREFIX."_communities_forum` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = tb2.id AND tb2.del = '0' AND tb2.ban = '0' {$sql_where_discussion} ORDER by {$sql_order_discussion} LIMIT {$limit_page}, {$gcount}";
			$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_forum` {$sql_where_discussion_cnt}";
		
		}
		
	} else {
		$sql_query = false;
		$sql_count = false;
	}
	
	if($sql_query)
		$sql_ = $db->super_query($sql_query, 1);
	
	//Считаем кол-во ответов из БД
	if($sql_count AND $sql_)
		$count = $db->super_query($sql_count);

	//Head поиска
	$tpl->load_template('search/head.tpl');
	if($query)
		$tpl->set('{query}', stripslashes(stripslashes(strtr($query, array('%' => ' ')))));
	else
		$tpl->set('{query}', 'Начните вводить любое слово или имя');

	//Выводим доп поля
	$tpl->copy_template = str_replace("[ainstSelect-type-{$type_profile}]", 'selected', $tpl->copy_template);
	$tpl->set_block("'\\[ainstSelect-(.*?)\\]'si","");

	$xfieldsdata = xfieldsdataload($filecontents);
			
	if($type_profile == 2 OR $type_profile == 3)
		$fieldsoklist = array('zhanr_semki', 'usloviya_raboty', 'opyt_raboty', 'cena_za_chas_ot', 'cena_fotu_ot', 'cena_celyy_den_ot');
	else if($type_profile == 4)
		$fieldsoklist = array('_ost', 'ves', 'bedra', 'grud', 'taliya', 'cvet_glaz', 'tip_lica', 'cvet_kozhi', 'dlina_volos', 'struktura_volos', '_azmer_odezhdy', '_azmer_obuvi', 'zhanr_semki_2', 'opyt_raboty', 'cena_za_chas_ot', 'cena_fotu_ot', 'cena_celyy_den_ot');
	else if($type_profile == 5)
		$fieldsoklist = array('opyt_raboty', 'kosmetika', 'cena_obraz_ot', 'cena_za_chas_ot');
	else
		$fieldsoklist = array();
			
	foreach($xfields as $name => $value){
				
		if(in_array($value[0], $fieldsoklist)){
				
			$fieldvalue = $xfieldsdata[$value[0]];
			$fieldvalue = stripslashes($fieldvalue);
					
			$output .= "<div style=\"float:left;margin-right:10px\">";
			$output .= "<div style=\"padding-bottom:5px;color:#555;margin-top:10px\"><b>{$value[1]}:</b></div>";
				
			$for_js_list .= "'xfields[{$value[0]}]': $('#{$value[0]}').val(), ";
						
			if($value[2] == "textarea"){  
						
				$output .= '<textarea id="'.$value[0].'" class="inpst" style="width:300px;height:50px;">'.myBrRn($fieldvalue).'</textarea>';
							
			} elseif($value[2] == "text"){  
						
				$output .= '<input type="text" id="'.$value[0].'" class="inpst" maxlength="100" value="'.$fieldvalue.'" style="width:300px;" />';
							
			} elseif($value[2] == "select"){  
						
				$output .= '<select class="inpst" id="'.$value[0].'" style="width:312px">';
				$output .= '<option value="">- Не выбрано -</option>';
						
				foreach(explode("\r\n", $value[3]) AS $index => $value){

					$value = str_replace("'", "&#039;", $value);
					$output .= "<option value=\"$index\"" . ($fieldvalue == $value ? " selected" : "") . ">$value</option>\r\n";
							
				}
						
				$output .= '</select>';
		
			} elseif($value[2] == "checkbox"){  
						
				$output .= '<div style="float:left;border:1px solid #f0f0f0;padding:5px;background:#fff;width:300px">';

				$fidoav = $value[0];
				$forlist = '';
						
				foreach(explode("\r\n", $value[3]) AS $index => $value){

					$value = str_replace("'", "&#039;", $value);
							
					if(stripos($fieldvalue, $value) !== false){
						$checked_boxis = 'checked';
						$forlist .= "|{$index}|";
						$forvalue = 1;
					} else {
						$checked_boxis = '';
						$forlist .= '';
						$forvalue = 0;
					}
							
					$output .= "<div><input type=\"checkbox\" value=\"{$forvalue}\" " . $checked_boxis . " onClick=\"forcheck('{$fidoav}', '{$index}')\" id=\"{$fidoav}val{$index}\" /> $value</div>\r\n";
							
				}
						
				$output .= '<input type="hidden" value="'.$forlist.'" id="'.$fidoav.'" size="100" /></div>';
						
			}
						
			$output .= '</div>';
			
			//$output .= '<div class="mgclr"></div>';
				
		}
				
	}
			
	$tpl->set('{xfields}', $output);

	$_GET['query'] = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $_GET['query'] = $db->safesql(strip_data(urldecode($_GET['query'])));
	$_GET['query'] = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $_GET['query'] = $db->safesql(strip_data(urldecode($_GET['query'])));
	$tpl->set('{query-people}', str_replace(array('&type=2', '&type=3', '&type=4', '&type=5', '&type=6'), '&type=1', $_SERVER['QUERY_STRING']));
	$tpl->set('{query-videos}', '&type=2&query='.$_GET['query']);
	$tpl->set('{query-notes}', '&type=3&query='.$_GET['query']);
	$tpl->set('{query-groups}', '&type=4&query='.$_GET['query']);
	$tpl->set('{query-audios}', '&type=5&query='.$_GET['query']);
	$tpl->set('{query-discussion}', '&type=6&query='.$_GET['query']);
	
	if($online) $tpl->set('{checked-online}', 'online');
	else $tpl->set('{checked-online}', '0');
		
	if($user_photo) $tpl->set('{checked-user-photo}', 'user_photo');
	else $tpl->set('{checked-user-photo}', '0');
	
	$tpl->set("{discussion-activetab-{$discussion_type}}", 'buttonsprofileSec');
	
	$tpl->set("{activetab-{$type}}", 'buttonsprofileSec');
	$tpl->set("{type}", $type);
	
	$tpl->set("{shkola}", $shkola);
	$tpl->set('{klass}', installationSelected($klass, 
	'<option value="1">а</option><option value="2">б</option><option value="3">в</option><option value="4">г</option><option value="5">д</option><option value="6">е</option><option value="7">ж</option><option value="8">з</option><option value="9">и</option><option value="10">к</option><option value="11">л</option><option value="12">м</option><option value="13">н</option><option value="14">о</option><option value="15">п</option><option value="16">р</option><option value="17">с</option><option value="18">т</option><option value="19">у</option><option value="20">ф</option><option value="21">х</option><option value="22">ц</option><option value="23">ч</option><option value="24">ш</option><option value="25">щ</option><option value="26">ы</option><option value="27">э</option><option value="28">ю</option><option value="29">я</option><option value="30">а2</option><option value="31">б2</option><option value="32">в2</option><option value="33">г2</option><option value="34">д2</option><option value="35">е2</option><option value="36">ж2</option><option value="37">з2</option><option value="38">и2</option><option value="39">к2</option><option value="40">л2</option><option value="41">м2</option><option value="42">н2</option><option value="43">о2</option><option value="44">п2</option><option value="45">р2</option><option value="46">с2</option><option value="47">т2</option><option value="48">у2</option><option value="49">ф2</option><option value="50">х2</option><option value="51">ц2</option><option value="52">ч2</option><option value="53">ш2</option><option value="54">щ2</option><option value="55">ы2</option><option value="56">э2</option><option value="57">ю2</option><option value="58">я2</option><option value="59">а3</option><option value="60">б3</option><option value="61">в3</option><option value="62">г3</option><option value="63">д3</option><option value="64">е3</option><option value="65">ж3</option><option value="66">з3</option><option value="67">и3</option><option value="68">к3</option><option value="69">л3</option><option value="70">м3</option><option value="71">н3</option><option value="72">о3</option><option value="73">п3</option><option value="74">р3</option><option value="75">с3</option><option value="76">т3</option><option value="77">у3</option><option value="78">ф3</option><option value="79">х3</option><option value="80">ц3</option><option value="81">ч3</option><option value="82">ш3</option><option value="83">щ3</option><option value="84">ы3</option><option value="85">э3</option><option value="86">ю3</option><option value="87">я3</option><option value="88">1</option><option value="89">2</option><option value="90">3</option><option value="91">4</option><option value="92">5</option><option value="93">6</option><option value="94">7</option><option value="95">8</option><option value="96">9</option><option value="97">10</option><option value="98">11</option><option value="99">12</option><option value="100">13</option><option value="101">14</option><option value="102">15</option>'));
	
	$tpl->set("{spec}", $spec);
	$tpl->set("{vuz}", $vuz);
	$tpl->set("{fac}", $fac);
	
	$tpl->set('{form}', installationSelected($form, 
	'<option value="1">Дневная</option>
	 <option value="2">Вечерняя</option>
	 <option value="3">Заочная</option>'));
	 
	$tpl->set('{statusvi}', installationSelected($statusvi, 
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
	 
	$tpl->set("{mesto}", $mesto);
	$tpl->set("{dolj}", $dolj);
	$tpl->set("{chast}", $chast);
	$tpl->set("{zvanie}", $zvanie);
	
	$tpl->set('{pred}', installationSelected($pred, 
	'<option value="1">Индифферентные</option>
	 <option value="2">Коммунистические</option>
	 <option value="3">Социалистические</option>
	 <option value="4">Умеренные</option>
	 <option value="5">Либеральные</option>
	 <option value="6">Консервативные</option>
	 <option value="7">Монархические</option>
	 <option value="8">Ультраконсервативные</option>
	 <option value="9">Либертарические</option>'));
	 
	 
	 $tpl->set('{jizn}', installationSelected($pred, 
	'<option value="1">Семья и дети</option>
	 <option value="2">Карьера и дети</option>
	 <option value="3">Развлечения и отдых</option>
	 <option value="4">Наука и исследование</option>
	 <option value="5">Совершенствование мира</option>
	 <option value="6">Саморазвитие</option>
	 <option value="7">Красота и искуство</option>
	 <option value="8">Слава и влияние</option>'));
	 
	 $tpl->set('{ludi}', installationSelected($pred, 
	'<option value="1">Ум и креативность</option>
	 <option value="2">Доброта и честность</option>
	 <option value="3">Красота и здоровье</option>
	 <option value="4">Власть и богатство</option>
	 <option value="5">Смелость и упорство</option>
	 <option value="6">Юмор и жизнелюбие</option>'));
	 
	 $tpl->set('{kurenie}', installationSelected($pred, 
	'<option value="1">Резко негативное</option>
	 <option value="2">Негативное</option>
	 <option value="3">Компромиссное</option>
	 <option value="4">Нейтральное</option>
	 <option value="5">Положительное</option>'));
	 
	 $tpl->set('{alkogol}', installationSelected($pred, 
	'<option value="1">Резко негативное</option>
	 <option value="2">Негативное</option>
	 <option value="3">Компромиссное</option>
	 <option value="4">Нейтральное</option>
	 <option value="5">Положительное</option>'));
	 
	 $tpl->set('{narkotiki}', installationSelected($pred, 
	'<option value="1">Резко негативное</option>
	 <option value="2">Негативное</option>
	 <option value="3">Компромиссное</option>
	 <option value="4">Нейтральное</option>
	 <option value="5">Положительное</option>'));
	
	$tpl->set('{sex}', installationSelected($sex, '<option value="1">Мужской</option><option value="2">Женский</option>'));
	$tpl->set('{day}', installationSelected($day, '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'));
	$tpl->set('{month}', installationSelected($month, '<option value="1">Января</option><option value="2">Февраля</option><option value="3">Марта</option><option value="4">Апреля</option><option value="5">Мая</option><option value="6">Июня</option><option value="7">Июля</option><option value="8">Августа</option><option value="9">Сентября</option><option value="10">Октября</option><option value="11">Ноября</option><option value="12">Декабря</option>'));
	$tpl->set('{year}', installationSelected($year, '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>'));
$myRow = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
if($myRow['user_sex'] == 1)
$tpl->set('{sp}', installationSelected($sp, '<option value="1">Не женат</option><option value="2">Есть подруга</option><option value="3">Помолвлен</option><option value="4">Женат</option><option value="5">Влюблен</option><option value="6">Все сложно</option><option value="7">В активном поиске</option>'));
if($myRow['user_sex'] == 2) $tpl->set('{sp}', installationSelected($sp, '<option value="1">Не замужем</option><option value="2">Есть друг</option><option value="3">Помолвлена</option><option value="4">Замужем</option><option value="5">Влюблена</option><option value="6">Все сложно</option><option value="7">В активном поиске</option>'));
	if($count['cnt']){
		$tpl->set('[yes]', '');
		$tpl->set('[/yes]', '');

		// FOR MOBILE VERSION 1.0
		if($online == 1){
		
			$tpl->set_block("'\\[no-online\\](.*?)\\[/no-online\\]'si","");
			$tpl->set('[online]', '');
			$tpl->set('[/online]', '');
		
		} else {
			
			$tpl->set_block("'\\[online\\](.*?)\\[/online\\]'si","");
			$tpl->set('[no-online]', '');
			$tpl->set('[/no-online]', '');
			
		}
		
		if($type == 1) //Если критерий поиск "по людям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'fave'));
		elseif($type == 2 AND $config['video_mod'] == 'yes') //Если критерий поиск "по видеозаписям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'videos'));
		elseif($type == 3) //Если критерий поиск "по заметкам"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'notes'));
		elseif($type == 4) //Если критерий поиск "по сообществам"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'se_groups'));
		elseif($type == 5) //Если критерий поиск "по аудиозаписям"
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'audio'));
		elseif($type == 6) //Если критерий поиск "обсуждения"
			$tpl->set('{count}', $count['cnt']);
	} else 
		$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");

	if($type == 1){
		$tpl->set('[search-tab]', '');
		$tpl->set('[/search-tab]', '');
		$tpl->set_block("'\\[discussion\\](.*?)\\[/discussion\\]'si","");
	} elseif($type == 6){
		$tpl->set('[discussion]', '');
		$tpl->set('[/discussion]', '');
		$tpl->set_block("'\\[search-tab\\](.*?)\\[/search-tab\\]'si","");
	} else {
		$tpl->set_block("'\\[search-tab\\](.*?)\\[/search-tab\\]'si","");
		$tpl->set_block("'\\[discussion\\](.*?)\\[/discussion\\]'si","");
	}
	
	//################## Загружаем Страны ##################//
	$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
	foreach($sql_country as $row_country)
		$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
			
	$tpl->set('{country}', installationSelected($country, $all_country));
	
	//################## Загружаем Города ##################//
	if($type == 1){
		$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$country}' ORDER by `name` ASC", true, "country_city_".$country, true);
		foreach($sql_city as $row2) 
			$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

		$tpl->set('{city}', installationSelected($city, $all_city));
	}
	
	$tpl->compile('info');
	
	//Загружаем шаблон на вывод если он есть одного юзера и выводим
	if($sql_){
	
		//Если критерий поиск "по людям"
		if($type == 1){
			$tpl->load_template('search/result_people.tpl');
			foreach($sql_ as $row){
			
			//Верификация профиля
			if($row['user_real'] == 1) {
                     $tpl->set('{user_real}', '<div class="search_verified" onmouseover="myhtml.title('. $row['user_id'].',\''.'Подтверждённая страница '.'\', \''.'newBBlockl'.'\')" id="newBBlockl'. $row['user_id'].'"></div>');
            } else {
                     $tpl->set('{user_real}', '' );
            }
				if($row['alias']) $tpl->set('{alias}', $row['alias']);
				else $tpl->set('{alias}', 'u'.$row['user_id']);
				$tpl->set('{name}', $row['user_search_pref']);
				$tpl->set('{user-id}', $row['user_id']);
				if($row['user_photo']){
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
					$tpl->set('{big-ava}', $row['user_photo']);
				}else {
					$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					$tpl->set('{big-ava}', $row['user_photo']);
				}
		
				//Возраст юзера
				$user_birthday = explode('-', $row['user_birthday']);
				$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
				
				$user_country_city_name = explode('|', $row['user_country_city_name']);
				$tpl->set('{country}', $user_country_city_name[0]);
				if($user_country_city_name[1])
					$tpl->set('{city}', ', '.$user_country_city_name[1]);
				else
					$tpl->set('{city}', '');

				if($row['user_id'] != $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				} else
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					OnlineTpl($row['user_last_visit'], $row['user_logged_mobile']);

				if($row['user_id'] == 7) $tpl->set('{group}', '<font color="#f87d7d">Модератор</font>');
				else $tpl->set('{group}', '');

				$tpl->compile('content');
			}
			
		//Если критерий поиск "по видеозаписям"
		} elseif($type == 2){
			$tpl->load_template('search/result_video.tpl');
			foreach($sql_ as $row){
				$tpl->set('{photo}', $row['photo']);
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{id}', $row['id']);
				$tpl->set('{close-link}', '/index.php?'.$query_string.'&page='.$page);
				$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				megaDate(strtotime($row['add_date']), 1, 1);
				$tpl->compile('content');
			}
			
		//Если критерий поиск "по заметкам"
		} elseif($type == 3){
			$tpl->load_template('search/result_note.tpl');
			foreach($sql_ as $row){
				if($row['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['owner_user_id'].'/50_'.$row['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				if($row['alias']) 
					$tpl->set('{alias}', $row['alias']);
				else 
					$tpl->set('{alias}', 'u'.$row['owner_user_id']);
					
				$tpl->set('{short-text}', stripslashes(strip_tags(iconv_substr($row['full_text'], 0, 200, 'utf-8'))).'...');
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{name}', $row['user_search_pref']);
				$tpl->set('{note-id}', $row['id']);
				megaDate(strtotime($row['date']), 1, 1);
				if($row['comm_num'])
					$tpl->set('{comm-num}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				else
					$tpl->set('{comm-num}', $lang['note_no_comments']);
				$tpl->compile('content');
			}

		//Если критерий поиск "по сообещствам"
		} elseif($type == 4){
			$tpl->load_template('search/result_groups.tpl');
			foreach($sql_ as $row){
				//Верификация профиля
			    if($row['preal'] == 1) {
                    $tpl->set('{preal}', '<div class="search_verified" onmouseover="myhtml.title('.$row['id'].',\''.'Подтверждённое сообщество'.'\', \''.'newBBlockl'.'\')" id="newBBlockl'.$row['id'].'"></div>');
                } else {
                    $tpl->set('{preal}', '' );
                }
				if($row['photo'])
					$tpl->set('{ava}', '/uploads/groups/'.$row['id'].'/100_'.$row['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_groups_100.gif');
				
				$tpl->set('{public-id}', $row['id']);
				$tpl->set('{name}', stripslashes($row['title']));
				$tpl->set('{note-id}', $row['id']);
				$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
				if($row['adres']) $tpl->set('{adres}', $row['adres']);
				else $tpl->set('{adres}', 'public'.$row['id']);
				$tpl->compile('content');
			}

		//Если критерий поиск "по аудизаписям"
		} elseif($type == 5){
			$tpl->load_template('search/result_audio.tpl');
			$jid = 0;
			foreach($sql_ as $row){
				$jid++;
				$tpl->set('{jid}', $jid);
				$tpl->set('{aid}', $row['aid']);
				$tpl->set('{url}', $row['url']);
				$tpl->set('{artist}', stripslashes($row['artist']));
				$tpl->set('{name}', stripslashes($row['name']));
				$tpl->set('{author-n}', iconv_substr($row['user_search_pref'], 0, 1, 'utf-8'));
				$expName = explode(' ', $row['user_search_pref']);
				$tpl->set('{author-f}', $expName[1]);
				$tpl->set('{author-id}', $row['auser_id']);
				$tpl->compile('content');
			}
			
		//Если критерий поиск "обсуждения"
		} elseif($type == 6){
		
			$tpl->load_template('search/result_forum.tpl');
			foreach($sql_ as $row){
				
				$row_last_user = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$row['lastuser_id']}'");
				$last_userX = explode(' ', $row_last_user['user_search_pref']);
				$row_last_user['user_search_pref'] = gramatikName($last_userX[0]).' '.gramatikName($last_userX[1]);
						
				$tpl->set('{name}', $row_last_user['user_search_pref']);
				$tpl->set('{msg-num}', '<b>'.$row['msg_num'].'</b> '.gram_record($row['msg_num'], 'msg'));	
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{ptitle}', stripslashes($row['pub_title']));
				$tpl->set('{fid}', $row['fid']);
				$tpl->set('{user-id}', $row['lastuser_id']);
				$tpl->set('{pid}', $row['public_id']);
				megaDate($row['lastdate']);
				
				if($row['photo']) $tpl->set('{ava}', '/uploads/groups/'.$row['public_id'].'/50_'.$row['photo']);
				else $tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
								$tpl->compile('content');
			}
		} else
			msgbox('', $lang['search_none'], 'info_2');

	} else {
		if ($_POST['ajax'] == 'yes' && $page != 1) {
			echo 'last_page';
		}

		msgbox('', '', 'info_search');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>