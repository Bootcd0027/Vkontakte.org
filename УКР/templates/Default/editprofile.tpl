<script type="text/javascript" src="{theme}/js/profile_edit.js"></script>
[general]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <div class="buttonsprofileSec"><a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>{translate=lang_67}</div></a></div>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_68}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_69}</a>
 <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>

<div class="settings_edit_profile">
<div class="settings_section">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>

<div class="texta">{translate=lang_928}:</div><input type="text" id="lastname" class="inpst" maxlength="100" value="{lastname}" style="width:212px;" />
<div class="mgclr"></div>

[dev]<div class="texta">{translate=lang_929}:</div><input type="text" id="dev" class="inpst" maxlength="100" value="{dev}" style="width:212px;" />
<div class="mgclr"></div>[/dev]

<div class="texta">{translate=lang_930}:</div><input type="text" id="name" class="inpst" maxlength="100" value="{name}" style="width:212px;" />
<div class="mgclr"></div>

<!--<div class="texta">{translate=lang_931}1:</div><input type="text" id="otcestvo" class="inpst" maxlength="100" value="{otcestvo}" style="width:212px;" />
<div class="mgclr"></div>--!>

<div class="texta">{translate=lang_71}:</div>
 <div class="padstylej"><select id="sex" class="inpst"  style="width:222px;" onChange="sp.check()">
  <option value="0">- {translate=lang_72} -</option>
  {sex}
 </select></div>
<div class="mgclr"></div>
<div class="[sp-all]no_display[/sp-all]" id="sp_block"><div class="texta">{translate=lang_73}:</div>
 <div class="padstylej">
 <div class="[user-m]no_display[/user-m]" id="sp_sel_m"><select id="sp"  style="width:222px;" class="inpst" onChange="sp.openfriends()">
  <option value="0">- {translate=lang_72} -</option>
  <option value="1" [instSelect-sp-1]>{translate=lang_74}</option>
  <option value="2" [instSelect-sp-2]>{translate=lang_75}</option>
  <option value="3" [instSelect-sp-3]>{translate=lang_76}</option>
  <option value="4" [instSelect-sp-4]>{translate=lang_77}</option>
  <option value="5" [instSelect-sp-5]>{translate=lang_78}</option>
  <option value="6" [instSelect-sp-6]>{translate=lang_79}</option>
  <option value="7" [instSelect-sp-7]>{translate=lang_80}</option>
 </select></div>
 <div class="[user-w]no_display[/user-w]" id="sp_sel_w"><select id="sp_w"  style="width:222px;" class="inpst" onChange="sp.openfriends()">
  <option value="0">- {translate=lang_72} -</option>
  <option value="1" [instSelect-sp-1]>{translate=lang_81}</option>
  <option value="2" [instSelect-sp-2]>{translate=lang_82}</option>
  <option value="3" [instSelect-sp-3]>{translate=lang_83}</option>
  <option value="4" [instSelect-sp-4]>{translate=lang_84}</option>
  <option value="5" [instSelect-sp-5]>{translate=lang_85}</option>
  <option value="6" [instSelect-sp-6]>{translate=lang_79}</option>
  <option value="7" [instSelect-sp-7]>{translate=lang_80}</option>
 </select></div>
 </div>
<div class="mgclr"></div></div>
<div class="[sp]no_display[/sp]" id="sp_type">
<div class="texta" id="sp_text">{sp-text}</div>
 <div class="padstylej fl_l"><div style="margin-top:3px;margin-bottom:10px;padding-left:1px;float:left"><a href="/" id="sp_name" onClick="sp.openfriends(); return false">{sp-name}</a></div><img src="{theme}/images/close_a_wall.png" class="sp_del" onClick="sp.del()" /></div>
<div class="mgclr"></div>
<input type="hidden" id="sp_val" />
</div>

<div class="texta">{translate=lang_86}:</div>
 <div class="padstylej"><select id="day" style="width:50px;" class="inpst">
  <option>- {translate=lang_87} -</option>
  {user-day}
 </select>
 <select id="month" style="width:106px;" class="inpst">
  <option>- {translate=lang_88} -</option>
  {user-month}
 </select>
 <select id="year" style="width:60px;"  class="inpst">
  <option>- {translate=lang_89} -</option>{user-year}
 </select></div>
<div class="mgclr"></div>

 <div  id="spx_block"><div class="texta"></div>
  <div class="padstylej">
 <div id="spx_sel_w"><select id="spx_w" class="inpst" onChange="sp.opendates()" style="width:222px;">
  {data-profiles}
 </select><span style="margin-left:10px">на моей странице.</span></div>
 </div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_982}:</div><input type="text" id="hometown" class="inpst" maxlength="100" value="{hometown}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_977}:</div><input type="text" id="grandparents" class="inpst" maxlength="100" value="{grandparents}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_978}:</div><input type="text" id="parents" class="inpst" maxlength="100" value="{parents}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_979}:</div><input type="text" id="siblings" class="inpst" maxlength="100" value="{siblings}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_980}:</div><input type="text" id="children" class="inpst" maxlength="100" value="{children}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_981}:</div><input type="text" id="grandchildren" class="inpst" maxlength="100" value="{grandchildren}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">&nbsp;</div>
<div class="pedit_controls_separator"></div>
<div class="pedit_controls clear_fix">
<div class="button_div fl_l"><button id="saveform">{translate=lang_92}</button></div><div class="mgclr"></div>
</div></div>
[/general]
[contact]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>{translate=lang_94}</div></a></div>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>

<div class="settings_edit_contact">
<div class="settings_section">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>
<div class="texta">{translate=lang_90}:</div>
 <div class="padstylej"><select id="country" style="width:222px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- {translate=lang_72} -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">{translate=lang_91}:</div>
 <div class="padstylej"><select id="select_city" style="width:222px;" class="inpst">
  <option value="0">- {translate=lang_72} -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">{translate=lang_880}:</div><input type="text" id="rai" class="inpst" maxlength="100" value="{rai}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_881}:</div><input type="text" id="metro" class="inpst" maxlength="100" value="{metro}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_882}:</div><input type="text" id="ulica" class="inpst" maxlength="100" value="{ulica}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_883}:</div><input type="text" id="nazvanie" class="inpst" maxlength="100" value="{nazvanie}" style="width:212px;" />
<div class="mgclr"></div>

<div class="pedit_controls_separator"></div>

<div class="texta">{translate=lang_96}:</div><input type="text" id="phone" class="inpst" maxlength="50" value="{phone}" style="width:212px;" /><span id="validPhone"></span><div class="mgclr"></div>
<div class="texta">{translate=lang_97}:</div><input type="text" id="vk" class="inpst" maxlength="100" value="{vk}" style="width:212px;" /><span id="validVk"></span><div class="mgclr"></div>
<div class="texta">{translate=lang_98}:</div><input type="text" id="od" class="inpst" maxlength="100" value="{od}" style="width:212px;" /><span id="validOd"></span><div class="mgclr"></div>
<div class="texta">FaceBook:</div><input type="text" id="fb" class="inpst" maxlength="100" value="{fb}" style="width:212px;" /><span id="validFb"></span><div class="mgclr"></div>
<div class="texta">Skype:</div><input type="text" id="skype" class="inpst" maxlength="100" value="{skype}" style="width:212px;" /><span id="validSkype"></span><div class="mgclr"></div>
<div class="texta">ICQ:</div><input type="text" id="icq" class="inpst" maxlength="9" value="{icq}" style="width:212px;" /><span id="validIcq"></span><div class="mgclr"></div>
<div class="texta">{translate=lang_99}:</div><input type="text" id="site" class="inpst" maxlength="100" value="{site}" style="width:212px;" /><span id="validSite"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div>
<div class="pedit_controls_separator"></div>
<div class="pedit_controls clear_fix">
<div class="button_div fl_l"><button name="save" id="saveform_contact">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>
[/contact]
[interests]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_94}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>{translate=lang_95}</div></a></div>
 <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>
<div class="settings_edit_contact">
<div class="settings_interes">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>
<div class="texta">{translate=lang_100}:</div><textarea id="activity" class="inpst" style="width: 300px; height: 80px;">{activity}</textarea><div class="pedit_interests_details fl_r">Участие в организациях, общественные посты</div><div class="mgclr"></div>
<div class="texta">{translate=lang_95}:</div><textarea id="interes" class="inpst" style="width:300px;height:80px;">{interes}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_101}:</div><textarea id="music" class="inpst" style="width:300px;height:80px;">{music}</textarea><div class="pedit_interests_details fl_r">Группы, исполнители, композиторы</div><div class="mgclr"></div>
<div class="texta">{translate=lang_102}:</div><textarea id="kino" class="inpst" style="width:300px;height:80px;">{kino}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_884}:</div><textarea id="shou" class="inpst" style="width:300px;height:80px;">{shou}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_885}:</div><textarea id="serial" class="inpst" style="width:300px;height:80px;">{serial}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_103}:</div><textarea id="books" class="inpst" style="width:300px;height:80px;">{books}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_104}:</div><textarea id="games" class="inpst" style="width:300px;height:80px;">{games}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_105}:</div><textarea id="quote" class="inpst" style="width:300px;height:80px;">{quote}</textarea><div class="mgclr"></div>
<div class="texta">{translate=lang_106}:</div><textarea id="myinfo" class="inpst" style="width:300px;height:80px;">{myinfo}</textarea><div class="mgclr"></div>
<div class="texta">&nbsp;</div>
<div class="pedit_controls_int"></div>
<div class="pedit_controls clear_fix">
<div class="button_div fl_l"><button name="save" id="saveform_interests">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div>
[/interests]

[education]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/education" onClick="Page.Go(this.href); return false;"><div>{translate=lang_924}</div></a></div>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>
<div class="settings_edit_edukation">
<div class="settings_interes">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="buttonsprofile" style="margin-top:15px;">
<div class="summary_tabs_s clear_fix">
<div class="activetab"><a href="/editmypage/education" onClick="Page.Go(this.href); return false;"><div>{translate=lang_887}</div></a></div>
<a href="/editmypage/higher_education" onClick="Page.Go(this.href); return false;">{translate=lang_923}</a>
</div>
<div class="summary_eduk_s">
<div id="summary" class="summary">Здесь Вы можете указать школы, в которых Вы учились или учитесь.</div>
<div style="margin-bottom:5px;"></div>
</div>
</div>
</br>
<div style=margin-top:35px;">
<div class="mgclr"></div>
</br>
<div class="texta">{translate=lang_90}:</div>
 <div class="padstylej"><select id="country" style="width:222px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- {translate=lang_72} -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">{translate=lang_91}:</div>
 <div class="padstylej"><select id="select_city" style="width:222px;" class="inpst">
  <option value="0">- {translate=lang_72} -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">{translate=lang_888}:</div><input type="text" id="shkola" class="inpst" maxlength="100" value="{shkola}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_932}:</div>
 <div class="padstylej"><select id="nacalosr" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {nacalosr}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_933}:</div>
 <div class="padstylej"><select id="konecsr" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {konecsr}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_891}:</div>
 <div class="padstylej"><select id="datasr" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {datasr}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_892}:</div>
 <div class="padstylej"><select id="klass" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {klass}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_893}:</div><input type="text" id="spec" class="inpst" maxlength="100" value="{spec}" style="width:212px;" />
<div class="mgclr"></div>

<div class="pedit_controls_int"></div>
<div class="pedit_controls clear_fix">
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_education">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>
</div>
[/education]

[higher_education]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_94}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/education" onClick="Page.Go(this.href); return false;"><div>{translate=lang_924}</div></a></div>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>
<div class="settings_edit_edukation_ot">
<div class="settings_interes">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="buttonsprofile" style="margin-top:15px;">
<div class="summary_tabs_s clear_fix">
<a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_887}</a>
<div class="activetab"><a href="/editmypage/higher_education" onClick="Page.Go(this.href); return false;"><div>{translate=lang_923}</div></a></div>
</div>
<div class="summary_eduk_s">
<div id="summary" style=margin-top:-5px;">Здесь Вы можете указать основное и дополнительные высшие образования.</div>
<div style="margin-bottom:5px;"></div>
</div>
</div>
</br>
<div style=margin-top:35px;">
<div class="mgclr"></div>
</br>

<div class="texta">{translate=lang_90}:</div>
 <div class="padstylej"><select id="country" style="width:222px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- {translate=lang_72} -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">{translate=lang_91}:</div>
 <div class="padstylej"><select id="select_city" style="width:222px;" class="inpst">
  <option value="0">- {translate=lang_72} -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">{translate=lang_894}:</div><input type="text" id="vuz" class="inpst" maxlength="100" value="{vuz}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_895}:</div><input type="text" id="fac" class="inpst" maxlength="100" value="{fac}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_896}:</div>
 <div class="padstylej"><select id="form" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {form}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_897}:</div>
 <div class="padstylej"><select id="statusvi" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {statusvi}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_891}:</div>
 <div class="padstylej"><select id="datavi" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {datavi}
 </select></div>
<div class="mgclr"></div>

<div class="pedit_controls_int"></div>
<div class="pedit_controls clear_fix">
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_higher_education">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>
</div>
[/higher_education]

[career]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_94}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
  <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/career" onClick="Page.Go(this.href); return false;"><div>{translate=lang_925}</div></a> </div>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>
<div class="settings_carier">
<div class="settings_section">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>


<div class="mgclr"></div>
</br>
<div class="texta">{translate=lang_90}:</div>
 <div class="padstylej"><select id="country" style="width:222px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- {translate=lang_72} -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">{translate=lang_91}:</div>
 <div class="padstylej"><select id="select_city" style="width:222px;" class="inpst">
  <option value="0">- {translate=lang_72} -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">{translate=lang_899}:</div><input type="text" id="mesto" class="inpst" maxlength="100" value="{mesto}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_934}:</div>
 <div class="padstylej"><select id="nacaloca" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {nacaloca}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_935}:</div>
 <div class="padstylej"><select id="konecca" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {konecca}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_902}:</div><input type="text" id="dolj" class="inpst" maxlength="100" value="{dolj}" style="width:212px;" />
<div class="mgclr"></div>

<div class="pedit_controls_separator"></div>
<div class="pedit_controls clear_fix">
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_career">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>

[/career]

[military]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_94}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/military" onClick="Page.Go(this.href); return false;"><div>{translate=lang_926}</div></a></div>
 <a href="/editmypage/personal" onClick="Page.Go(this.href); return false;">{translate=lang_927}</a>
</div>
</div>
<div class="settings_military">
<div class="settings_section">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>
<div class="texta">{translate=lang_90}:</div>
 <div class="padstylej"><select id="country" style="width:222px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- {translate=lang_72} -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">{translate=lang_91}:</div>
 <div class="padstylej"><select id="select_city" style="width:222px;" class="inpst">
  <option value="0">- {translate=lang_72} -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">{translate=lang_904}:</div><input type="text" id="chast" class="inpst" maxlength="100" value="{chast}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_905}:</div><input type="text" id="zvanie" class="inpst" maxlength="100" value="{zvanie}" style="width:212px;" />
<div class="mgclr"></div>

<div class="texta">{translate=lang_936}:</div>
 <div class="padstylej"><select id="nacalosl" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {nacalosl}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_937}:</div>
 <div class="padstylej"><select id="konecsl" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {konecsl}
 </select></div>
<div class="mgclr"></div>

<div class="pedit_controls_separator"></div>
<div class="pedit_controls clear_fix">
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_military">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>
[/military]

[personal]
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
 <a href="/editmypage" onClick="Page.Go(this.href); return false;">{translate=lang_93}</a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;">{translate=lang_94}</a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;">{translate=lang_95}</a>
 <a href="/editmypage/education" onClick="Page.Go(this.href); return false;">{translate=lang_924}</a>
 <a href="/editmypage/career" onClick="Page.Go(this.href); return false;">{translate=lang_925}</a>
 <a href="/editmypage/military" onClick="Page.Go(this.href); return false;">{translate=lang_926}</a>
 <div class="buttonsprofileSec"><a href="/editmypage/personal" onClick="Page.Go(this.href); return false;"><div>{translate=lang_927}</div></a></div>
</div>
</div>
<div class="settings_personal">
<div class="settings_section">
<div class="err_fall" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>
<div class="texta">{translate=lang_909}:</div>
 <div class="padstylej"><select id="pred" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {pred}
 </select></div>
<div class="mgclr"></div>

 <div class="texta">{translate=lang_910}:</div>
<input type="text" list="list"  id="miro" value="{miro}" class="inpst" maxlength="100"  style="width:212px;" />
<datalist id="list">
	<option  value="{translate=lang_938}" />
	<option  value="{translate=lang_939}" />
	<option  value="{translate=lang_940}" />
	<option  value="{translate=lang_941}" />
	<option  value="{translate=lang_942}" />
	<option  value="{translate=lang_943}" />
	<option  value="{translate=lang_944}" />
	<option  value="{translate=lang_945}" />
</datalist>
<div class="mgclr"></div>


<div class="texta">{translate=lang_911}:</div>
 <div class="padstylej"><select id="jizn" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {jizn}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_912}:</div>
 <div class="padstylej"><select id="ludi" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {ludi}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_946}:</div>
 <div class="padstylej"><select id="kurenie" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {kurenie}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_947}:</div>
 <div class="padstylej"><select id="alkogol" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {alkogol}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_948}:</div>
 <div class="padstylej"><select id="narkotiki" class="inpst" onChange="sp.check()" style="width:222px;" >
  <option value="0">- {translate=lang_72} -</option>
  {narkotiki}
 </select></div>
<div class="mgclr"></div>

<div class="texta">{translate=lang_949}:</div><input type="text" id="vdox" class="inpst" maxlength="100" value="{vdox}" style="width:212px;" /><div class="mgclr"></div>


<div class="pedit_controls_separator"></div>
<div class="pedit_controls clear_fix">
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button id="saveform_personal">{translate=lang_92}</button></div><div class="mgclr"></div></div>
</div></div>
[/personal]