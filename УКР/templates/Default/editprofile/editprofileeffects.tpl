<div class="buttonsprofile">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">Основное</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">Контакты</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">Интересы</a>
 <a href="/editmypage/all" onClick="Page.Go(this.href); return false;">Другое</a>
 <div class="activetab"><a href="/editmypage/photo" onClick="Page.Go(this.href); return false;"><div>Фото</div></a></div>
</div>
<div class="clear"></div>
<div class="err_yellow no_display pass_errors" id="save_ok" style="font-weight:normal;">Спецэффект успешно установлен. С вашего счета списано <b>15 голосов</b>.</div>
<div class="err_red no_display pass_errors" id="no_ok" style="font-weight:normal;">Извините, но на вашем счете недостаточно голосов.</div>
<style>
/* EDIT PHOTO */
h4 {border-bottom: 1px solid #B9C4DA;font-size: 13px;margin: 0;padding: 0 0 2px;}
.editorPanel {padding: 10px 0px;background: #f7f7f7; }
.editor {margin: 3px 0px 11px 22px;width: 580px;}
.editor_panel {padding: 10px 0px;background: #f7f7f7}
.editor td {border: none;margin: 0px;padding: 5px 1px 1px;vertical-align: top;}
.editor td.label {text-align: right;padding-right: 15px;width:150px;color: #555;}
.editor td.labelHigh {text-align: right;vertical-align: top;padding: 10px 15px 0px 0px;width: 150px;color: #555;}
.editor td.labelHigh div{font-weight: normal;font-size:10px;color: #999;}
</style>
<div class="editorPanel clearFix">	
<div style="padding-left:26px; width: 80%; margin-top: 0px; padding-top: 12px;">
<h4>Спецэффекты</h4>
Выбранный спецэффект будет примёнен к Вашей фотографии в анкете. Установка или смена спецэфекта стоит <b>15 голосов</b>. При изменении картинки аватара - спецэффект <b>останется</b>.
</div>
<table class="editor" border="0" cellspacing="0"><tr>
<td >
<table>
<tr>
<td>
<a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect(13);">
<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" width="{width}px" height="{height}px"><param name="wmode" value="transparent">
<param name="movie" value="{theme}/editprofile/effects/eff_13.swf">
<param name="allowScriptAccess" value="never">
<embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_13.swf" wmode="transparent" width="{width}px" height="{height}px">
</object>
</div>
<br /><center>Сверкающие звезды</center></a>
</td>
</tr>
</table>
</td>
<td >
<table>
<tr>
<td>
<a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('2');">
<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_2.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_2.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
</div>
<br /><center>Неземная влюбленность</center></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table class="editor" border="0" cellspacing="0"><tr>
<td >
<table>
<tr>
<td>
<a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('4');">
<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_4.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_4.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
</div>
<br /><center>Звезда в шоке</center></a>
</td>
</tr>
</table>
</td>
<td>
<table>
<tr>
<td>
<a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('5');">
<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_5.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_5.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
</div>
<br /><center>Матрица</center></a>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table class="editor" border="0" cellspacing="0"><tr>
<td >
<table>
<tr>
<td>
<a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('6');">
<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_6.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_6.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
</div>
<br /><center>Воздушные поцелуи</center></a>

	 					</td>
	 					</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('1');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_1.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_1.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Вечная весна</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('14');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_14.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_14.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Падающие сердца</center></a>

	 					</td>
	 					</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('9');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_9.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_9.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Новогодний снегопад</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('10');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_10.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_10.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Праздничные огни</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('11');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_11.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_11.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Марс и Венера</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('12');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_12.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_12.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Лепестки роз</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('7');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_7.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_7.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
	 				<br /><center>Черепки</center></a>
	 					</td>
	 					</tr>
	 				</table>
                    
                		</td>
      	</tr></table>    
                    
                   	<table class="editor" border="0" cellspacing="0"><tr>
        <td > 

                    

                    <table>
        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('3');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_3.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_3.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
	 				<br /><center>Любитель интернета</center></a>
	 					</td>
	 					</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
                    <a style="cursor:pointer; text-decoration:none;" onclick="Profile.AddEffect('2');">
	 				<div style="background-image: url({ava}); width: {width}px; height: {height}px;" align="center">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{height}px" width="{width}px"><param name="wmode" value="transparent"><param name="movie" value="{theme}/editprofile/effects/eff_8.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="{theme}/editprofile/effects/eff_8.swf" wmode="transparent" height="{height}px" width="{width}px"></object>
	 				</div>
                    <br /><center>Пламя</center></a>
	 					</td>
	 					</tr>
	 				</table>
                    
                    
                    
                    
                    
				</td>
      	</tr></table>


              </table>
       </div>
     </div>
