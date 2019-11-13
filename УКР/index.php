<?php
/* 
	Appointment: Главная страница
	File: index.php
	Author: f0rt1 
	Engine: Vii Engine
	Copyright: NiceWeb Group (с) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	Данный код защищен авторскими правами
*/
if(isset($_POST["PHPSESSID"])){
	session_id($_POST["PHPSESSID"]);
}
@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');

header('Content-type: text/html; charset=utf-8');



//AJAX
$ajax = $_POST['ajax'];

$logged = false;
$user_info = false;

include ENGINE_DIR.'/init.php';

if($_GET['act'] == 'confirm' && isset($_GET['hid'])){
		$hid = $_GET['hid'];
		$db->query("UPDATE `".PREFIX."_users` SET hides='0' WHERE podtv='{$hid}'");
		header('location:/');
	}

//Если юзер перешел по реф ссылке, то добавляем ид реферала в сессию
if($_GET['reg']) $_SESSION['ref_id'] = intval($_GET['reg']);

//Опридиления браузера
if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) $xBrowser = 'ie6';
elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) $xBrowser = 'ie7';
elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) $xBrowser = 'ie8';
if($xBrowser == 'ie6' OR $xBrowser == 'ie7' OR $xBrowser == 'ie8')
	header("Location: /badbrowser.php");

//Загружаем кол-во новых новостей
$CacheNews = mozg_cache('user_'.$user_info['user_id'].'/new_news');
if($CacheNews){
	$new_news = "<span>+{$CacheNews}</span>";
	$news_link = '/notifications';
}

//Загружаем кол-во новых подарков
$CacheGifts = mozg_cache('user_'.$user_info['user_id'].'/new_gifts');
if($CacheGifts){
	$new_gifts = "<span>+{$CacheGifts}</span>";
}

//Загружаем кол-во новых подарков
$CacheGift = mozg_cache("user_{$user_info['user_id']}/new_gift");
if($CacheGift){
	$new_ubm = "<span>+{$CacheGift}</span>";
	$gifts_link = "/gifts{$user_info['user_id']}?new=1";
} else
	$gifts_link = '/balance';
	
//Новые сообщения
$user_pm_num = $user_info['user_pm_num'];
if($user_pm_num)
	$user_pm_num = "<span>+{$user_pm_num}</span>";
else
	$user_pm_num = '';
	
//Приглашения в группы
	$num_g = $user_info['nums_g'];
if($num_g){
	$num_g = "<span>+{$num_g}</span>";
	$numh = '/request';
}else{
	$num_g = '';
	$numh = '/groups';
}
 
//Новые вопросы	
	$ask_num = $user_info['ask_num'];
	if($ask_num)
		$ask_num = "<span>+{$ask_num}</span>";
	else
		$ask_num = '';

//Новые друзья
$user_friends_demands = $user_info['user_friends_demands'];
if($user_friends_demands){
	$demands = "<span>+{$user_friends_demands}</span>";
	$requests_link = '/requests';
} else
	$demands = '';

//Гости
$user_guests = $user_info['user_guests'];
if($user_guests)
	$user_guests = "<span>+{$user_guests}</span>";
else
	$user_guests = '';	

//Мнения	
	$op_sql = $db->super_query("SELECT user_new_opinion FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");	
$user_new_opinion = $op_sql['user_new_opinion'];
if($user_new_opinion){
	$new_opinion = "<span>+{$user_new_opinion}</span>";
	$opinion_link = '/opinion/new';
} else
	$new_opinion = '';
	
//ТП
$user_support = $user_info['user_support'];
if($user_support)
	$support = "<span>+{$user_support}</span>";
else
	$support = '';
	
//Отметки на фото
if($user_info['user_new_mark_photos']){
	$new_photos_link = 'newphotos';
	$new_photos = "<span>+{$user_info['user_new_mark_photos']}</span>";
} else {
	$new_photos = '';
	$new_photos_link = $user_info['user_id'];
}

 if($user_info['diz']==1)
    $tpl->set_block("'\\[diz\\](.*?)\\[/diz\\]'si","");
   else{ 
    $tpl->set('[diz]','');
    $tpl->set('[/diz]','');
   }
if($user_info['diz']==2)
 $tpl->set_block("'\\[diz2\\](.*?)\\[/diz2\\]'si","");
 
 else 
  $tpl->set('[diz2]','');
 $tpl->set('[/diz2]','');

//Если включен AJAX то загружаем стр.
if($ajax == 'yes'){

	//Если есть POST Запрос и значение AJAX, а $ajax не равняется "yes" то не пропускаем
	if($_SERVER['REQUEST_METHOD'] == 'POST' AND $ajax != 'yes')
		die('Неизвестная ошибка');

	if($spBar)
		$ajaxSpBar = "$('#speedbar').show().html('{$speedbar}')";
	else
		$ajaxSpBar = "$('#speedbar').hide()";



	$result_ajax = <<<HTML
<script type="text/javascript">
document.title = '{$metatags['title']}';
{$ajaxSpBar};
document.getElementById('new_msg').innerHTML = '{$user_pm_num}';
document.getElementById('user_guests').innerHTML = '{$user_guests}';
document.getElementById('ask_num').innerHTML = '{$ask_num}';
document.getElementById('new_news').innerHTML = '{$new_news}';
document.getElementById('new_ubm').innerHTML = '{$new_ubm}';
document.getElementById('ubm_link').setAttribute('href', '{$gifts_link}');
document.getElementById('new_support').innerHTML = '{$support}';
document.getElementById('news_link').setAttribute('href', '/news{$news_link}');
document.getElementById('new_requests').innerHTML = '{$demands}';
document.getElementById('new_photos').innerHTML = '{$new_photos}';
document.getElementById('requests_link_new_photos').setAttribute('href', '/albums/{$new_photos_link}');
document.getElementById('requests_link').setAttribute('href', '/friends{$requests_link}');
document.getElementById('new_groups').innerHTML = '{$new_groups}';
document.getElementById('gr_link').setAttribute('href', '/groups{$numh}');
document.getElementById('gr_link').setAttribute('href', '/groups/request{$numh}');
document.getElementById('g_requests').innerHTML = '{$num_g}';
document.getElementById('new_gifts').innerHTML = '{$new_gifts}';

</script>
{$tpl->result['info']}{$tpl->result['content']}
HTML;
	echo str_replace('{theme}', '/templates/'.$config['temp'], $result_ajax);

	$tpl->global_clear();
	$db->close();

	if($config['gzip'] == 'yes')
		GzipOut();
		
	die();
} 

//Если обращение к модулю регистрации или главной и юзер не авторизован то показываем регистрацию
if($go == 'register' OR $go == 'main' AND !$logged)
	include ENGINE_DIR.'/modules/register_main.php';
if(!$logged){
$tpl->load_template('main.tpl');
}else{
if($user_info['user_sms'] == 1){
		$tpl->load_template('sms_activate.tpl');
	} else {
		$tpl->load_template('main.tpl');
	}
}

/*
|---------------------------------------------------------------
| user_photo — Загружаем мини изображения пользователя в header.
|---------------------------------------------------------------
*/

if($logged){

	if($user_info['user_photo'])

		$ava = $config['home_url'].'uploads/users/'.$user_info['user_id'].'/100_'.$user_info['user_photo'];

	else 

		$ava = '/templates/Default/images/no_ava_50.png';

	$myphoto_header.='<img src="'.$ava.'" width="31" />'."\n";

	$tpl->set('{myphoto_header}', $myphoto_header);

}

//Если юзер залогинен
if($logged){
	$tpl->set_block("'\\[not-logged\\](.*?)\\[/not-logged\\]'si","");
	$tpl->set('[logged]','');
	$tpl->set('[/logged]','');
	$tpl->set('{my-page-link}', '/u'.$user_info['user_id']);
	$tpl->set('{my-id}', $user_info['user_id']);
	
	if(!empty($user_info['alias'])){
        $tpl->set('{alias}', '/'.$user_info['alias']);
    } else {
        $tpl->set('{alias}', '/u'.$user_info['user_id']);
    }
	
	//Заявки в друзья
	$user_friends_demands = $user_info['user_friends_demands'];
	if($user_friends_demands){
		$tpl->set('{demands}', $demands);
		$tpl->set('{requests-link}', $requests_link);
	} else {
		$tpl->set('{demands}', '');
		$tpl->set('{requests-link}', '');
	}
	
	
//Новые друзья	
	$user_new_opinion = $op_sql['user_new_opinion'];
	if($user_new_opinion){
		$tpl->set('{new_opinion}', $new_opinion);
		$tpl->set('{opinion_link}', $opinion_link);
	} else {
		$tpl->set('{new_opinion}', '');
		$tpl->set('{opinion_link}', '');
	}
	
	//Новости
	if($CacheNews){
		$tpl->set('{new-news}', $new_news);
		$tpl->set('{news-link}', $news_link);
	} else {
		$tpl->set('{new-news}', '');
		$tpl->set('{news-link}', '');
	}
	
	//Сообщения
	if($user_pm_num)
		$tpl->set('{msg}', $user_pm_num);
	else 
		$tpl->set('{msg}', '');

	//Сообщения
	if($user_guests)
		$tpl->set('{user_guests}', $user_guests);
	else 
		$tpl->set('{user_guests}', '');	
		
	//Вопросы
	if($ask_num)
		$tpl->set('{ask_num}', $ask_num);
	else 
		$tpl->set('{ask_num}', '');

	//Поддержка
	if($user_support)
		$tpl->set('{new-support}', $support);
	else 
		$tpl->set('{new-support}', '');
	
	//Отметки на фото
	if($user_info['user_new_mark_photos']){
		$tpl->set('{my-id}', 'newphotos');
		$tpl->set('{new_photos}', $new_photos);
	} else 
		$tpl->set('{new_photos}', '');

	//UBM
	if($CacheGift){
		$tpl->set('{new-ubm}', $new_ubm);
		$tpl->set('{ubm-link}', $gifts_link);
	} else {
		$tpl->set('{new-ubm}', '');
		$tpl->set('{ubm-link}', $gifts_link);
	}
	
	//ПОдарки
	if($CacheGifts)
		$tpl->set('{new-gifts}', $new_gifts);
	else
		$tpl->set('{new-gifts}', '');
	
	//Приглашения в группы
if($num_g){
		$tpl->set('{gr}', $num_g);
		$tpl->set('{gr-link}', '/groups/request');
	} else {
		$tpl->set('{gr}', '');
		$tpl->set('{gr-link}', '');
	}

} else {
	$tpl->set_block("'\\[logged\\](.*?)\\[/logged\\]'si","");
	$tpl->set('[not-logged]','');
	$tpl->set('[/not-logged]','');
	$tpl->set('{my-page-link}', '');
}


$tpl->set('{header}', $headers);
$tpl->set('{speedbar}', $speedbar);
$tpl->set('{mobile-speedbar}', $mobile_speedbar);
$tpl->set('{info}', $tpl->result['info']);

if($user_info['user_audio_off'] == 1){
$tpl->set('{user_audio_off}', '<div class="no_display"><audio id="beep-three" controls preload="auto"><source src="/templates/152_2750ff2585d4.ogg"></source></audio></div>');
} else {
$tpl->set('{user_audio_off}', '');
}

// FOR MOBILE VERSION 1.0
if($config['temp'] == 'mobile'){

	$tpl->result['content'] = str_replace('onClick="Page.Go(this.href); return false"', '', $tpl->result['content']);
	
	if($user_info['user_status'])
		$tpl->set('{status-mobile}', '<span style="font-size:11px;color:#000">'.$user_info['user_status'].'</span>');
	else
		$tpl->set('{status-mobile}', '<span style="font-size:11px;color:#999">установить статус</span>');
	
	$new_actions = $user_friends_demands+$user_support+$CacheNews+$CacheGift+$user_info['user_pm_num'];

	if($new_actions)
		$tpl->set('{new-actions}', "<div class=\"headm_newac\" style=\"margin-top:5px;margin-left:30px\">+{$new_actions}</div>");
	else
		$tpl->set('{new-actions}', "");
	
}

$tpl->set('{content}', $tpl->result['content']);

if($spBar)
	$tpl->set_block("'\\[speedbar\\](.*?)\\[/speedbar\\]'si","");
else {
	$tpl->set('[speedbar]','');
	$tpl->set('[/speedbar]','');
}



//BUILD JS
if($config['gzip_js'] == 'yes')
	if($logged)
		$tpl->set('{js}', '<script type="text/javascript" src="/min/index.php?charset=windows-1251&amp;g=general&amp;6"></script>');
	else
		$tpl->set('{js}', '<script type="text/javascript" src="/min/index.php?charset=windows-1251&amp;g=no_general&amp;6"></script>');
else
	if($logged)
		$tpl->set('{js}', '<script type="text/javascript" src="{theme}/js/new.lib.js"></script><script type="text/javascript" src="{theme}/js/'.$checkLang.'/lang.js"></script><script type="text/javascript" src="{theme}/js/main.js"></script><script type="text/javascript" src="{theme}/js/profile.js"></script><script type="text/javascript" src="{theme}/js/profile_edit.js"></script><script type="text/javascript" src="{theme}/js/audio_player.js"></script>');
	else
		$tpl->set('{js}', '<script type="text/javascript" src="{theme}/js/new.lib.js"></script><script type="text/javascript" src="{theme}/js/'.$checkLang.'/lang.js"></script><script type="text/javascript" src="{theme}/js/main.js"></script>');

// FOR MOBILE VERSION 1.0
if($user_info['user_photo']) $tpl->set('{my-ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
else $tpl->set('{my-ava}', "{theme}/images/no_ava_50.png");
$tpl->set('{my-name}', $user_info['user_search_pref']);

if($check_smartphone) $tpl->set('{mobile-link}', '<a href="/index.php?act=change_mobile">мобильная версия</a>');
else $tpl->set('{mobile-link}', '');

//Баннеры
$tpl->set('{banner-top}', '');
$tpl->set('{banner-bottom}', '');
$tpl->set('{banner-right-1}', '');
$tpl->set('{banner-right-2}', '');
$tpl->set('{banner-right-3}', '');
		
if($logged){

if($user_info['banner_cat']){
	
	$banner_cat = "AND cat = '{$user_info['banner_cat']}'";
	
}

$sql_banners = $db->super_query("SELECT id, user_id, pos, img, title, descr, link FROM `".PREFIX."_users_banners` WHERE approve = '0' {$banner_cat}", 1);

foreach($sql_banners as $rowB){

	$rowB['title'] = stripslashes($rowB['title']);
	$rowB['descr'] = stripslashes($rowB['descr']);
	
	if($rowB['pos'] == 1){
		
		$tpl->set('{banner-top}', '<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" width="880" height="150" title="'.$rowB['title'].' - '.$rowB['descr'].'" /></a>');
		
	} elseif($rowB['pos'] == 2){
		
		$tpl->set('{banner-bottom}', '<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" width="880" height="150" style="margin-left:18px" title="'.$rowB['title'].' - '.$rowB['descr'].'" /></a>');
		
	} elseif($rowB['pos'] == 3 AND !$_SESSION['banner13']){
		
		$tpl->set('{banner-right-1}', '<div id="Xbanner13"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')" style="text-decoration:none">
		<div style="background:#fff;padding:10px" class="border_radius_5 margin_bottom_10">
		<b>'.$rowB['title'].'</b><br />
		<img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" width="65" height="90" style="margin-top:5px;margin-bottom:5px" /><br />
		<span style="color:#000;font-size:10px">'.$rowB['descr'].'</span><br />
		<a class="cursor_pointer" onClick="bannerHide(13)" style="color:#777;font-size:10px">Скрыть</a>
		</div>
		</a></div>');
		
	} elseif($rowB['pos'] == 4 AND !$_SESSION['banner14']){
		
		$tpl->set('{banner-right-2}', '<div id="Xbanner14"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')" style="text-decoration:none">
		<div style="background:#fff;padding:10px" class="border_radius_5 margin_bottom_10">
		<b>'.$rowB['title'].'</b><br />
		<img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" width="65" height="90" style="margin-top:5px;margin-bottom:5px" /><br />
		<span style="color:#000;font-size:10px">'.$rowB['descr'].'</span><br />
		<a class="cursor_pointer" onClick="bannerHide(14)" style="color:#777;font-size:10px">Скрыть</a>
		</div>
		</a>
		</div>');
		
	} elseif($rowB['pos'] == 5 AND !$_SESSION['banner15']){
		
		$tpl->set('{banner-right-3}', '<div id="Xbanner15"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')" style="text-decoration:none">
		<div style="background:#fff;padding:10px" class="border_radius_5 margin_bottom_10">
		<b>'.$rowB['title'].'</b><br />
		<img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" width="65" height="90" style="margin-top:5px;margin-bottom:5px" /><br />
		<span style="color:#000;font-size:10px">'.$rowB['descr'].'</span><br />
		<a class="cursor_pointer" onClick="bannerHide(15)" style="color:#777;font-size:10px">Скрыть</a>
		</div>
		</a>
		</div>');
		
	}
	
}

}

$tpl->set('{lang}', $rMyLang);

$countAllUser = $db->super_query("SELECT COUNT(*) as cnt FROM `".PREFIX."_users`");
$countAllUser_stln = strlen($countAllUser['cnt']);
$arrayAllUser = $countAllUser['cnt'];
$resultAllUser = '';
for($i = 0; $i < $countAllUser_stln; $i++){
	$resultAllUser .= '<li>'.$arrayAllUser{$i}.'</li>';
}
$tpl->set('{all_user_num}', $resultAllUser);

if($go == 'main') $tpl->set('{main-photos}', '<div class="clear"></div><div class="allbar_title">Новые фотографии</div>'.$tpl->result['main_photos']);
else $tpl->set('{main-photos}', '');

$tpl->compile('main');




if($_GET['a'] == 'b'){

	$a = $db->super_query("SELECT user_id, xfields FROM vii_users WHERE xfields != ''", 1);
	
	$p = file_get_contents(ROOT_DIR.'/system/data/xfields.txt');
	
	foreach($a as $b){

		$e = explode('||', $b['xfields']);
		
		$x = '';
		
		foreach($e as $c){
		
			$d = explode('|', $c);
			
			if(stripos($p, $d[0]) !== false)
			
				$o[] = $d[0].' = \''.$d[1].'\'';

			
		}
		
		$x = implode(', ', $o);
		
		$db->query("UPDATE vii_users SET {$x} WHERE user_id = '{$b['user_id']}'");
		
	}
	
}

echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);

$tpl->global_clear();
$db->close();

if($config['gzip'] == 'yes')
	GzipOut();
	
?>