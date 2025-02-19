<?php

define ( 'WEBTOMAT_DIR', 'system/modules/webtomat' );
define ( 'WEBTOMAT_PREF', PREFIX.'_' );
if ( $config['charset'] == "windows-1251" ) {
	define ( 'WEBTOMAT_DECODE', "windows-1251" );
} else {
	define ( 'WEBTOMAT_DECODE', "UTF-8" );
}

require_once 'webtomat.lng';
if ( WEBTOMAT_DECODE == "windows-1251" ) {
    foreach($wt_lang as $key => $val){
        $wt_lang[$key] = $val;//iconv('UTF-8','windows-1251//IGNORE',$val);

    }
}
$wt_opt_array = array (
    'name' => $wt_lang['opt_wtmodule'],
    'url' => "$PHP_SELF?mod=wtopt",
    'descr' => $wt_lang['opt_wtmodulec'],
    'image' => "logo_webtomat.png",
    'access' => "admin"
);

class WebTomat_Data {

    static public $lang = array();
    static public $wt_query = '';
    static public $wt_result = array();

    function __construct(){
        global $wt_lang;
        self::$lang = $wt_lang;
    }

    static public function wt_mysql($query) // метод запросов к базе
    {
        global $db;

        if (!empty($query))
            self::$wt_query = $db->query($query);

        return self::$wt_query;
    }

    static public function wt_getrow($z = 0) // метод получения массива из результата запроса
    {
        global $db;

        $id = (isset($z) and !empty($z)) ? $z : self::$wt_query;
        return $db->get_array($id);
    }

    static public function wt_numrow($z = 0) // метод получения количества строк из результата запроса
    {
        global $db;

        $id = (isset($z) and !empty($z)) ? $z : self::$wt_query;
        return $db->num_rows($id);
    }

    static public function wt_safesql($z) // метод обработки переменных перед подстановкой в запрос
    {
        global $db;
        return $db->safesql($z);
    }

}
$data = new WebTomat_Data();

/* проверка существования таблиц в БД, при отсутствии - создание */

//таблица с настройками модуля
$data->wt_mysql("CREATE TABLE IF NOT
	 EXISTS " . WEBTOMAT_PREF . "wtmodule (
		`params` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`val` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`params`)
		)
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		;");

//таблица со списком игр
$data->wt_mysql("CREATE TABLE IF NOT EXISTS " . WEBTOMAT_PREF . "wtgames (
		`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
		`wtg_id` int(6) unsigned NOT NULL,
		`wtg_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_desc` text(0) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_height` int(4) unsigned NOT NULL,
		`wtg_width` int(4) unsigned NOT NULL,
		`wtg_tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_genres` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_apppath` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_popular` float(7,2) unsigned NOT NULL,
		`wtg_votes` int(6) NOT NULL DEFAULT 1,
		`wtg_new` int(4) unsigned NOT NULL,
		`wtg_created` int(15) unsigned NOT NULL,
		`wtg_img16` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_img50` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_img75` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_img100` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_img120` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`wtg_img200` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`id`)
		)
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		;");

//таблица с именами тегов и жанров
$data->wt_mysql("CREATE TABLE IF NOT EXISTS " . WEBTOMAT_PREF . "wtnames (
		`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
		`en_name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		`rus_name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		`type`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `in_count` int(6),
		PRIMARY KEY (`id`)
		)
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		;");

//таблица с привязанными к ID пользователей списками игр ( за которые голосовал пользователь )
$data->wt_mysql("CREATE TABLE IF NOT EXISTS " . WEBTOMAT_PREF . "wtusrate (
		`id`  int(6) NOT NULL AUTO_INCREMENT ,
		`user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		`games_id`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		PRIMARY KEY (`id`)
		)
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		;");

$wt_conf = $data->wt_mysql( "SELECT * FROM " . WEBTOMAT_PREF . "wtmodule" );
while ( $row = $data->wt_getrow() ) {
	$$row['params'] = $row['val'];
}
define ( 'WT_THEME', $wt_theme );


?>