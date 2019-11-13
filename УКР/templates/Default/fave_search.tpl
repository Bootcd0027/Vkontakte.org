<script type="text/javascript" src="{theme}/js/fave.filter.js"></script>
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:23px">
  <div class="{return_users}"><a href="/fave/users" onclick="Page.Go(this.href); return false;"><div><b>{translate=lang_460}</b></div></a></div>
  <div class="{return_clubs}"><a href="/fave/clubs" onclick="Page.Go(this.href); return false;"><div><b>{translate=lang_121}</b></div></a></div>
  <div class="{return_public}"><a href="/fave/public" onclick="Page.Go(this.href); return false;"><div><b>{translate=lang_345}</b></div></a></div>
  <div class="{return_video}"><a href="/fave/video" onclick="Page.Go(this.href); return false;"><div><b>{translate=lang_119}</b></div></a></div>
</div>
[search]<div class="fave_search">
<div style="padding:0px 10px;margin-top:-10px;"><input class="friends_se_search friends_s_search" type="text" style="width:400px;" value="{translate=lang_108}" onblur="if(this.value=='') this.value='{translate=lang_108}';this.style.color = '#c1cad0';" onfocus="if(this.value=='{translate=lang_108}') this.value='';this.style.color = '#000'" id="filter" /></div></div>[/search]
</div>
<div class="clear"></div>

[block_none]<div class="allbar_title_grups" style="margin-bottom:0px;border-bottom:0px"><div class="public_title" id="e_public_title" style="margin-left:10px;margin-top:10px;">{count}</div>
<div class="public_hr" style="margin-bottom: -5px;"></div></div>[/block_none]
[block_error]<div class="info_center" style="margin-top: 55px;">У вас в закладках ничего нету.</div>[/block_error]