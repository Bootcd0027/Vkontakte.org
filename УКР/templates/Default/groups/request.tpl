<div class="groups_items">
<a href="/public{group-id}" onClick="Page.Go(this.href); return false"><div class="fm_allstu_req_ava"><img src="{ava}" /></div></a>
<div class="fl_l groups_ml">
<a href="/public{group-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a><div class="friends_clr"></div>
<div class="groups_people_stat">&nbsp;От:&nbsp;{invname}</div><div class="friends_clr"></div>
</div>
<div id="action_{group-id}" class="fm_menu_class fl_l groups_menu_xl">
<a class="fm_none_href" onMouseDown="groups.invyes({group-id},{user_id}); return false"><div>Подписаться</div></a>
<a class="fm_none_href" onMouseDown="groups.invno({group-id},{user_id}); return false"><div>Отклонить</div></a>
</div>
</div>