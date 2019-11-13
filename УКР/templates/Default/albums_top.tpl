[all-albums]
[admin-drag][owner]<script type="text/javascript">
$(document).ready(function(){
	Albums.Drag();
});
</script>[/owner][/admin-drag]
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <div class="buttonsprofileSec"><a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;"><div>[not-owner]{translate=lang_43} {name}[/not-owner][owner]Все альбомы[/owner]</div></a></div>
 [owner]<div style="float:right;"><a href="" onClick="Albums.CreatAlbum(); return false;"><b>{translate=lang_57}</b></a></div>[/owner]
 <a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_58}</a>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_59} {name}</a>[/not-owner]
 [new-photos]<a href="/albums/newphotos" onClick="Page.Go(this.href); return false;">{translate=lang_60} (<b>{num}</b>)</a>[/new-photos]
</div></div>
<div style="margin-top:0px;"></div>
[/all-albums]

[view]
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]{translate=lang_61} {name}[/not-owner][owner]{translate=lang_61}[/owner]</a>
 <div class="buttonsprofileSec"><a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false;"><div>{album-name}</div></a></div>
 <a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;">{translate=lang_62}</a>
 [owner]<a href="/albums/editphotos/{aid}" onClick="Page.Go(this.href); return false;">{translate=lang_63}</a>
 <a href="/albums/add/{aid}" onClick="Page.Go(this.href); return false;">{translate=lang_64}</a>[/owner]
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_59} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div><div style="margin-top:8px;"></div>
[/view]
[editphotos]
[admin-drag]<script type="text/javascript">
$(document).ready(function(){
	Photo.Drag();
});
</script>[/admin-drag]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_61}</a>
 <a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false;">{album-name}</a>
 <a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;">{translate=lang_62}</a>
 <div class="buttonsprofileSec"><a href="/albums/editphotos/{aid}" onClick="Page.Go(this.href); return false;"><div>{translate=lang_63}</div></a></div>
 <a href="/albums/add/{aid}" onClick="Page.Go(this.href); return false;">{translate=lang_64}</a>
</div></div>
<div class="clear"></div><div style="margin-top:8px;"></div>
[/editphotos]

[comments]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]{translate=lang_61} {name}[/not-owner][owner]{translate=lang_61}[/owner]</a>
 [owner]<div style="float:right;"><a href="" onClick="Albums.CreatAlbum(); return false;"><b>{translate=lang_57}</b></a></div>[/owner]
 <div class="buttonsprofileSec"><a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;"><div>{translate=lang_58}</div></a></div>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_59} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
[/comments]
[albums-comments]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]{translate=lang_61} {name}[/not-owner][owner]{translate=lang_61}[/owner]</a>
 <a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false;">{album-name}</a>
 <div class="buttonsprofileSec"><a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;"><div>{translate=lang_62}</div></a></div>
 [owner]<a href="/albums/editphotos/{aid}" onClick="Page.Go(this.href); return false;">{translate=lang_63}</a>
 <a href="/albums/add/{aid}" onClick="Page.Go(this.href); return false;">{translate=lang_64}</a>[/owner]
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_59} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
[/albums-comments]
[all-photos]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="search_form_tab">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px;">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]{translate=lang_61} {name}[/not-owner][owner]{translate=lang_61}[/owner]</a>
 [owner]<a href="" onClick="Albums.CreatAlbum(); return false;"><b>{translate=lang_57}</b></a>[/owner]
 <a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_58}</a>
 <div class="buttonsprofileSec"><a href="/photos{user-id}" onClick="Page.Go(this.href); return false;"><div>{translate=lang_65}</div></a></div>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">{translate=lang_59} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div><div style="margin-top:8px;"></div>
[/all-photos]