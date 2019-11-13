<?php
/* 
	Appointment: Страница не активирована
	File: profile_disabled.php
 
*/
if(!defined('MOZG'))
	die("Hacking attempt!");

	$tpl->load_template('profile_disabled.tpl');
	$tpl->compile('main');
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	die();
?>