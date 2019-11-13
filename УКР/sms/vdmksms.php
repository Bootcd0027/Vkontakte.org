<?php

include("configsms.php");

$lnk = mysql_connect($hostname,$username,$password);
mysql_select_db($dbname, $lnk);
mysql_query("SET NAMES utf8");

$action=htmlspecialchars(trim($_GET['action']));

if (empty($_GET['msg_trans']) or empty($_GET['num'])) {
	echo ("Произошла ошибка.");
	exit;
}

if (!preg_match('|(\d+)|', $_GET['msg_trans'], $m)) {
	echo ("Неверный формат сообщения.");
	exit;
}

$id=$m[1];
$a=mysql_fetch_array(mysql_query("SELECT * FROM vii_users WHERE user_id='$id'"));
if (!$a) {
	echo ("Неверный id пользователя.");
	exit;
}


mysql_query("UPDATE vii_users SET user_balance='$ball' WHERE user_id='$id'");
echo ("Привет, Вы успешно приобрели $ball баллов! Социальная сеть http://onepuls.ru");

?>