<a href="/u{user-id}"><img src="{ava}" align="left" width="50" height="50" style="margin-right:10px" />
<b>{name} {lastname}</b></a> {online}<br />
<div style="font-size:11px;color:#000;margin-bottom:2px;margin-top:2px" id="new_status">{status-text}</div>
<div style="font-size:11px">{city}</div>
<div class="clr"></div>
<div class="clr" style="margin-top:10px"></div>
[not-owner][blacklist][privacy-msg]<button class="button" onClick="messages.new_({user-id}); return false" style="width:100%">{translate=lang_266}</button>[/privacy-msg][/blacklist]
[no-friends][blacklist]<button class="button" onClick="friends.add({user-id}); return false" style="width:100%;margin-top:10px">{translate=lang_180}</button>[/blacklist][/no-friends]
[yes-friends]<button class="button" onClick="friends.goDelte({user-id}); return false" style="width:100%;margin-top:10px">{translate=lang_322}</button>[/yes-friends][/not-owner]
[owner]<div class="profbloctitl">{translate=lang_202}</div>
<input type="text" class="inp" style="padding-bottom:4px;margin-bottom:10px;margin-top:10px" id="status_text" placeholder="{translate=lang_197}" />
<button id="status_but" class="button" onClick="gStatus.set()">{translate=lang_72}</button>
<a href="/" class="yes_status_text [no-status]no_display[/no-status]" onClick="gStatus.set(1); return false">{translate=lang_37}</a>[/owner]
[albums]<a href="/albums/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="profbloctitl">{translate=title_albums}<span>{albums-num}</span></div></a>
{albums}[/albums]
[privacy-info]<div class="profbloctitl">{translate=lang_538}</div>
<div style="padding-top:10px;font-size:12px">
[not-all-birthday]<div style="margin-bottom:10px">{translate=lang_11}: {birth-day}</div>[/not-all-birthday]
[sp]<div style="margin-bottom:10px">{translate=lang_73}: {sp}</div>[/sp]
[not-contact-phone]<div style="margin-bottom:10px">{translate=lang_206}: {phone}</div>[/not-contact-phone]
</div>[/privacy-info]
<div class="profbloctitl">{translate=lang_732}</div>
<div class="profii">
 [not-owner]<a href="/" onClick="gifts.box('{user-id}'); return false">{translate=lag_184}</a>
 [no-fave]<a href="/" onClick="fave.add({user-id}); return false" id="addfave_but"><b id="text_add_fave">{translate=lang_185}</b></a>[/no-fave]
 [yes-fave]<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but"><b id="text_add_fave">{translate=lang_186}</b></a>[/yes-fave]
 [no-subscription]<a href="/" onClick="subscriptions.add({user-id}); return false" id="lnk_unsubscription"><b id="text_add_subscription">{translate=lang_182}</b></a>[/no-subscription]
 [yes-subscription]<a href="/" onClick="subscriptions.del({user-id}); return false" id="lnk_unsubscription"><b id="text_add_subscription">{translate=lang_183}</b></a>[/yes-subscription][/not-owner]
 [owner]<a href="/editmypage">{translate=lang_200}</a>
 <a href="/" onClick="Profile.DelPhoto(); return false;" {display-ava}>{translate=lang_173}</a>[/owner]
 <div class="profbloctitl" style="margin-top:-1px">{translate=lang_70}</div>
 [friends]<a href="/friends/{user-id}">{translate=lang_116}<span>{friends-num}</span></a>[/friends]
 [online-friends]<a href="/friends/online/{user-id}">{translate=lang_191}<span>{online-friends-num}</span></a>[/online-friends]
 [subscriptions]<a href="/" onClick="subscriptions.all({user-id}, '', {subscriptions-num}); return false">{translate=lang_193}<span>{subscriptions-num}</span></a>[/subscriptions]
 [groups]<a href="/" onClick="groups.all_groups_user('{user-id}'); return false">{translate=lang_194}<span id="groups_num">{groups-num}</span></a>[/groups]
 [gifts]<a href="/gifts{user-id}">{translate=lang_328}<span>{gifts-text}</span></a>[/gifts]
</div>
<div class="profbloctitl" style="margin-top:-1px">Стена <span id="wall_rec_num">{wall-rec-num}</span></div>
<div class="wallformbg">
<textarea id="wall_text" class="wall_fast_text inp" placeholder="[owner]{translate=lang_210}[/owner][not-owner]{translate=lang_211}[/not-owner]"></textarea>
<button class="button" onClick="wall.send({user-id}); return false">{translate=lang_502}</button>
</div>
<div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>{translate=lang_225}</div>[/no-records]</div>
[wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">{translate=lang_226}</div></div>[/wall-link]