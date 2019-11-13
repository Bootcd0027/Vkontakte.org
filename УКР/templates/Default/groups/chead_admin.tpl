<script type="text/javascript" src="{theme}/js/groups.filter.js"></script>
<div class="search_form_tab" style="margin-top:-9px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
  <a href="/clubs" onClick="Page.Go(this.href); return false;"><div><b>Сообщества</b></div></a>
  <div class="buttonsprofileSec"><a href="/clubs?act=admin" onClick="Page.Go(this.href); return false;"><div><b>Управление</b></div></a></div>
  <a href="/clubs" onClick="groups.created(); return false"><div><b>Создать сообщество</b></div></a>
 </div>
</div>
<div class="search_form_tab" style="margin-top:20px;border-top: 1px solid #E4E7EB;">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
<input type="text" value="Начните вводить имя или название" class="fave_input fl_l" onblur="if(this.value=='') this.value='Начните вводить имя или название';this.style.color = '#c1cad0';" onfocus="if(this.value=='Начните вводить имя или название') this.value='';this.style.color = '#000'" id="filter" style="margin-left: 0px; width: 300px !important;margin-top: 0px;">
 <div class="fl_r"><a href="/groups?act=admin" onclick="Page.Go(this.href); return false;"><div><b>Публичные страницы</b></div></a></div>
 <div class="buttonsprofileSec fl_r"><a href="/clubs?act=admin" onclick="Page.Go(this.href); return false;"><div><b>Группы</b></div></a></div>
</div>
</div>
<div class="margin_top_10"></div><div class="allbar_title" [yes]style="margin-bottom:0px;border-bottom:0px"[/yes]>[yes]Вы руководитель в {num}[/yes][no]Вы не управляете ни одним сообществом[/no]</div>
[no]<div class="info_center"><br /><br />
Вы не управляете ни одним сообществом. 
<br /><br />
Вы можете <a href="/groups" onClick="groups.created(); return false">создать сообщество</a> или воспользоваться <a href="/" onClick="gSearch.open_tab(); gSearch.select_type('4', 'по сообществам'); return false" id="se_link">поиском по сообществам</a>.<br /><br /><br />
</div>[/no]