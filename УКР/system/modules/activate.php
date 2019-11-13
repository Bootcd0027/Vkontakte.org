<?php
/* 
	Appointment: Активация профиля
	File: activate.php
 
*/
if(!defined('MOZG'))
	die("Hacking attempt!");

if(!isset($_GET['account']))
	die("Account undefined!");

$account = intval($_GET['account']);
$db->query("UPDATE `".PREFIX."_users` SET `user_emailed`=0 WHERE `user_id`='{$account}'");
header("Location: /");
?>