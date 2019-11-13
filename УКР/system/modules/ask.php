<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = $lang['home_desc'].'Вопросы';
	switch($act){

		//################### Delete to ask ###################//
		case "del_ask":
			$id = intval($_POST['id']);
			$check_del = $db->super_query("SELECT id, for_user_id, author_user_id, text_ask FROM `".PREFIX."_user_ask` WHERE id = '{$id}'");
			if($check_del){
				$db->query("DELETE FROM `".PREFIX."_user_ask` WHERE for_user_id='{$user_id}' AND id='{$id}'");
				$db->query("UPDATE `".PREFIX."_users` SET ask_num = ask_num-1 WHERE user_id = '$user_id'");
				$db->query("UPDATE `".PREFIX."_users` SET ask_answer_num = ask_answer_num-1 WHERE user_id = '$user_id'");

				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache();
			}
		break;

		//################### Open js ####################//
		case "add":
        echo '<div style="margin-left:10px;width: 599px; float: left; height: auto; background-color: #FFF; border: 1px solid #a9b5cf; padding: 15px 20px;">
        <textarea style="width: 574px; box-shadow: inset 0px 0px 3px 1px #999; padding: 10px; outline: none; max-height: 30px; height: 20px; font-weight: bold; overflow: auto; resize: none;" type="text" name="wall_text_ask" id="wall_text_ask"  placeholder="Какой вопрос желаете задать?" /></textarea>
		<div class="button_div fl_l margin_top_10">
         <button class="button_div" onClick="wall.send_ask(); return false" id="wall_send_ask">Спросить</button> 
		 </div>
        </div>';
        AjaxTPL();
        die();
        break;
		
		//################### Send to ask ####################//
	    case "send_ask":
 			NoAjaxQuery();
			$wall_text_ask = ajax_utf8(textFilter($_POST['wall_text_ask']));
			$for_user_id = intval($_POST['for_user_id']);
            if(!empty($wall_text_ask) AND $for_user_id AND $user_id){
                $str_date = time();
                $db->query("INSERT INTO `".PREFIX."_user_ask` SET for_user_id = '$for_user_id', author_user_id = '$user_id', text_ask = '$wall_text_ask', date = '$str_date'");
				$db->query("UPDATE `".PREFIX."_users` SET ask_num = ask_num+1 WHERE user_id = '$for_user_id'");

				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache();
			}

			//Вставляем событие в моментальные оповещания
			$row_owner = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
			$update_time = $server_time - 70;
			if($row_owner['user_last_visit'] >= $update_time){
				$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '14', date = '{$server_time}', text = '{$wall_text_ask}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/ask'");
				mozg_create_cache("user_{$for_user_id}/updates", 1);
			}
			
        break;

		//################### Answer to ask ##################//
        case "answer_ask":
 			NoAjaxQuery();
            $id = intval($_POST['id']);
			$for_user_id = intval($_POST['for_user_id']);
			$answer = htmlspecialchars(ajax_utf8(textFilter($_POST['answer'])));
            if(!empty($answer) AND $id AND $user_id){
                $db->query("UPDATE `".PREFIX."_user_ask` SET answer='$answer' WHERE id='$id' AND for_user_id='$user_id'");
				$db->query("UPDATE `".PREFIX."_users` SET ask_answer_num = ask_answer_num+1 WHERE user_id = '$user_id'");

				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache();
			}
        break;


		//################# View to ask list #################//
		default:
		
            $sql_ = $db->super_query("SELECT tb1.*,tb2.user_id, user_search_pref, user_photo, alias FROM `".PREFIX."_user_ask` tb1,`".PREFIX."_users` tb2 WHERE tb1.author_user_id=tb2.user_id AND tb1.for_user_id = '$user_id' ORDER BY tb1.id DESC",1);
			$tpl->load_template('ask/ask.tpl');
			foreach($sql_ as $ask){
                if(date('Y-m-d', $ask['date']) == date('Y-m-d', $server_time))
                $dateTell = langdate('сегодня в H:i', $ask['date']);
                elseif(date('Y-m-d', $ask['date']) == date('Y-m-d', ($server_time-84600)))
                $dateTell = langdate('вчера в H:i', $ask['date']);
                else
                $dateTell = langdate('j F Y в H:i', $ask['date']);
                if(!empty($ask['alias'])){
                    $adres = '/'.$ask['alias'].'';
                } else { $adres = '/u'.$ask['user_id'].''; }
                if(!empty($ask['answer'])){
                    $otvet = '';
                    $answer=$ask['answer'];
                }
                elseif(empty($ask['answer'])){
                    $otvet = ' <div class="button_div fl_l margin_top_10"><button onClick="ask.openFormSend('.$ask['id'].');" id="showFormSend'.$ask['id'].'" class="fl_r cursor_pointer" style="margin-right:0px;">Ответить</button></div>';
                    $answer='';
                }
				
				
				if($ask['user_photo']){
					$ava = 'uploads/users/'.$ask['user_id'].'/100_'.$ask['user_photo'];
				}else{
					$ava = 'images/100_no_ava.png';
				}
				
                $delete = '<div class="button_div_gray fl_r margin_left"><button onClick="ask.del_ask('.$ask['id'].');" class="fl_r cursor_pointer" style="margin-right:0px;">Удалить</button></div>';
                $ask_view .='
				<div id="info_answer_'.$ask['id'].'"></div>
				<div class="clear"></div>
                <div id="ask_del_'.$ask['id'].'" style="border-top: 1px solid #F1F4F7;min-height: 100px;margin-bottom: 10px;overflow: hidden;padding-top: 10px;padding-top:10px;margin-top:20px;">
				<div class="friends_ava fl_l "><img src="'.$ava.'" /></div><div style="line-height: 18px;margin-left: 120px;"><div>Вопрос от <a href="{alias}" onClick="Page.Go(this.href); return false"><b>'.$ask['user_search_pref'].'</b></a>, '.$dateTell.'.&nbsp;&nbsp;&nbsp;&nbsp;<br /></div></div>
				<div style="border-top: 1px solid #F1F4F7;width:396px;margin-left:115px;margin-bottom: 10px;margin-top:2px;"></div>
                <div style="">
                <div style="line-height: 18px;margin-left: 120px;">'.$ask['text_ask'].'
                <div>Ответ: <span id="answer'.$ask['id'].'" class="forum_title">'.$answer.'</span>'.$delete.''.$otvet.'</div>
                <div style="border:1px solid gainsboro;background: #F7F7F7;width: 419px;margin-left:50px;margin-top:-10px;" class="no_display" id="fast_form_'.$ask['id'].'">
                <div id="fast_textarea_'.$ask['id'].'">
                <textarea class="wall_ask fast_form_width wall_fast_text" style="color:#000; margin-top: 0px; width: 389px; margin: 10px 10px 0px 10px;" id="fast_text_'.$ask['id'].'" onKeyPress="if(event.keyCode == 13)ask.sendAnswer('.$ask['id'].')"></textarea>
                <div class="cursor_pointer" style="margin-bottom:4px;font-size:11px;color: #8B2521;margin-left:369px;" onClick="ask.hideSendForm('.$ask['id'].');">Скрыть</div>
                </div>
                </div></div>
				<div class="clear"></div>
                </div></div>';

            }
			
			
			
			$tpl->set('{asks}', $ask_view);
            $tpl->compile('content');
			
			if($ask['id'] == NULL){
				msgbox('', '<div style=margin-top:50px;">Пока вам еще ни кто, не задавал вопрос..</div>', 'info_2');
			}
			
        break;
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>