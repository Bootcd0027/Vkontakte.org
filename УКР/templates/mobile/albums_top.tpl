[all-albums]
<div class="tmenuf">
 <div><a href="/albums/{user-id}">{translate=lang_192}</a></div>
 <a href="/albums/comments/{user-id}">{translate=lang_523}</a>
 [not-owner]<a href="/u{user-id}">{translate=lang_59} {name}</a>[/not-owner]
 [new-photos]<a href="/albums/newphotos" >{translate=lang_66} (<b>{num}</b>)</a>[/new-photos]
</div>
<div class="clr"></div>
[/all-albums]
[view]
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="tmenuf">
 <a href="/albums/{user-id}">{translate=lang_466}</a>
 <div><a href="/albums/view/{aid}">{album-name}</a></div>
 <a href="/albums/view/{aid}/comments/">{translate=lang_523}</a>
 [not-owner]<a href="/u{user-id}">{translate=lang_59} {name}</a>[/not-owner]
</div>
<div class="clr"></div>
[/view]
[comments]
<div class="tmenuf">
 <a href="/albums/{user-id}">Все</a>
 <div><a href="/albums/comments/{user-id}">{translate=lang_523}</a></div>
 [not-owner]<a href="/u{user-id}">{translate=lang_59} {name}</a>[/not-owner]
</div>
<div class="clr"></div>
[/comments]
[albums-comments]
<div class="tmenuf">
 <a href="/albums/{user-id}">{translate=lang_192}</a>
 <a href="/albums/view/{aid}">{album-name}</a>
 <div><a href="/albums/view/{aid}/comments/">{translate=lang_523}</a></div>
 [not-owner]<a href="/u{user-id}">{translate=lang_59} {name}</a>[/not-owner]
</div>
<div class="clr"></div>
[/albums-comments]