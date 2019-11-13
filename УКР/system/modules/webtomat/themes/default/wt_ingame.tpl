<div id="wt_cont">
    <!-- ingame -->
    <link href="{WTDIR}css/style.css" rel="stylesheet" type="text/css">
    <script src="{WTDIR}js/style.js" type="text/javascript"></script>
    <script src="{WTDIR}js/ds.js" type="text/javascript"></script>
    <script src="{WTDIR}js/swfobject.js" type="text/javascript"></script>
    <script type="text/javascript">
        var wt_show_all = ["Показать все","Скрыть"];
    </script>
    <script> wt_dir = "{WTDIR}"; </script>
    <div id="wt_wrapper">
        <div id="wt_header">
            <div style="width:100%">
                <!-- Слайдер -->
                <a class="wt_s_nor in-main" href="{WTMAIN}">&nbsp;</a>
                [cont=wt_slider]
                <div id="wt_slid" class="wt_s_nor">
                    <div id="wt_slider">
                        <div id="wt_slider_content">
                            [cont2=slider]<a title="{wtg_title}" href="{WTURLMAIN}{wt_href_slid}"><div class="wt_s_nor slid_img_mask"></div><img src="{wt_href_slidimg}" width="120" height="60" alt="1"></a>[/cont2]
                        </div>
                    </div>
                    <span id="wt-slider-go-next" class="offsel wt_s_nor" onclick="wt_nextSlid(123,80)">&nbsp;</span>
                </div>
                [/cont]
                {WT_LOGIN}
            </div>
            <!-- Меню -->
            [cont=wt_menu]
                <div id="wt_menu" class="offsel">
                    <span>
                        <span id="wt_menu_kn" onclick="wt_st(this,0)">
                            Показать все
                        </span>
                    </span>
                    <div {wt_menu_sel_new}><a href="{WTURLMAIN}{wt_href_mn}">Новое</a></div>
                    [cont2=genre]
                        <div {wt_menu_sel_ingenre}><a href="{WTURLMAIN}{wt_href_mg}">{genre_rus}</a></div>
                    [/cont2]
                </div>
            [/cont]
            <!-- Поиск -->
			<div id="wt_search">
                 <input id="wt_input_search" class="s" name="search" type="text" onFocus="this.value=''; this.style.color='#000'" onBlur="if (this.value==''){this.value='Поиск игры'; this.style.color='#b3b3b3'}" value="Поиск игры">
            </div>
			<script type="text/javascript">
			document.getElementById("wt_input_search").onkeydown = function(event){
                event = event || window.event;
				if(event.keyCode==13){
					var url = '{WTURLMAIN}'+'search='+this.value;
					document.location = url;
				}
			}
			</script>
        </div>
        <!-- Контент -->
        <div id="wt_content" onclick="wt_st(document.getElementById('wt_menu_kn'),1)">
            <!-- Хлебные крошки -->
            [cont=wt_kroshki]<div id="breedclumbs"><a href="{WTMAIN}">Главная</a>[cont2=krosh] <span></span> <a href="{WTURLMAIN}{wt_href_krosh}" title="{krosh_text}"> {krosh_text}  </a>[/cont2] <span></span> {krosh_rus}</div>[/cont]
            <div id="ingame">
                <div class="img"><img src="{img200}" width="200" height="200"></div>
                <div class="disk">
                    <div class="wt_title">
                        {game_name_rus}
                        [cont2=new_img]<span class="wt_s_nor wt_top_new"></span>[/cont2]
                        [cont2=top_img]<span class="wt_s_nor wt_top_pop"></span>[/cont2]
                    </div><br /><br />
                    [cont=wt_reating]
                        <div class="wt_reating">
                            [var=src]
                                <script type="text/javascript">
                                    var wt_uv = {wt_uv};
                                    var wt_reatWidth = parseFloat({rate_percent});
                                    var ds = new DShare(location.href,
                                            "{game_name_rus}",
                                            "{game_desc}",
                                            "{img200}?{wt_rnum}"
                                    );
                                </script>
                            [/var]
                            [cont2=reating_str]
                                <span class="wt_s_nor wt_rate_star inl" style="left:{star_pos}px" onmouseover="wt_rt_start(this)" onmouseout="wt_rt_end(this)" onclick="if (!wt_uv) wt_rt_vote(this)"><input type="hidden" value="{n}" name="rate_val" /></span>
                            [/cont2]
                            <div id="wt_rate_color" style="width:{rate_percent}%"></div>
                            <div id="wt_rate_color_ser"></div>
                            <div class="wt_load" style="display:none"><img src="{WTDIR}images/load.gif" width="15" height="15" /></div>
                        </div>
                    [/cont]
                    <div class="anons">{game_desc}</div>
                    <div class="wt_s_nor tag">
                        [cont2=tagname_rus] <a href="{WTURLMAIN}{wt_href_tag}">{tgr}</a>,[/cont2]
                    </div>
                </div>
                <div class="share">
                    <div class="social">
                        <div class="wt_social_title">Рекомендуй друзьям!</div>
                        <a onclick="ds.OpenVK(location.host, {ingame}, 'mini', 'vk'); return false;" href="#" class="wt_s_nor" style="position: relative;">
                            <div class="wt_s_nor s_share social_vk"></div>
                            <span>Вконтакте</span>
                            <div id="wt_share_vkontakte" class="wt_s_nor wt_share_net" style="display:none;"></div></a>
                        <a onclick="ds.OpenMM(location.host, {ingame}, 'mini', 'mm'); return false;" href="#" class="wt_s_nor" style="position: relative;">
                            <div class="wt_s_nor s_share social_mm"></div>
                            <span>Мой Мир</span>
                            <div id="wt_share_mailru" class="wt_s_nor wt_share_net" style="display:none;"></div></a>
                        <a onclick="ds.OpenOK(location.host, {ingame}, 'mini', 'ok'); return false;" href="#" class="wt_s_nor" style="position: relative;">
                            <div class="wt_s_nor s_share social_ok"></div>
                            <span>Одноклассники</span>
                            <div id="wt_share_odnoklassniki" class="wt_s_nor wt_share_net" style="display:none;"></div></a>
                        <a onclick="ds.OpenFB(location.host, {ingame}, 'mini', 'fb'); return false;" href="#" class="wt_s_nor" style="position: relative;">
                            <div class="wt_s_nor s_share social_fb"></div>
                            <span>Facebook</span>
                            <div id="wt_share_facebook" class="wt_s_nor wt_share_net" style="display:none;"></div></a>


                    </div>
                    <div class="wt_addthis_title">Другие сервисы</div>
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style " style="float:right;margin-right:10px;">
                        <a class="addthis_button_compact"></a>
                        <a class="addthis_counter addthis_bubble_style"></a>
                    </div>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f8e5e1a54613ded"></script>
                    <!-- AddThis Button END -->
                </div>
            </div>

            <div id="wt_game">
				<div id="affCaller"></div>
				<script type="text/javascript">
				swfobject.embedSWF("http://static.apitech.ru/lib/web/c/caller.swf?{wt_rnum}", "affCaller", 1, 1, "4.0.0.0", '', {gId : {ingame}, pId : {webid}}, { "wmode": "transparent", "allowscriptaccess": "always", "allownetwork": "all" });
				function getRedirectURI(gameId) {
					var link = location.href.split('ingame=');
					var url = link[0]+"ingame="+gameId;
					document.location = url;
				}
				</script>
                <iframe id="wt_game_iframe" width="{wt_game_width}" frameborder="0" scrolling="no" height="{wt_game_height}" src="http://games.apitech.ru/Web/Preloader?appid={ingame}&webid={webid}">
                </iframe>
            </div>

            <div id="wt_bottom_genreblock">
            [cont=wt_gbs2]
                <!-- Блок -->
                <div class="block">
                    <div class="wt_title">
                        <a href="{WTURLMAIN}{wt_href_genre}">{genrename_rus}</a>
                        <span>(всего {count})</span></div>
                    <div class="disk">
                        <div class="img"><a href="{WTURLMAIN}{wt_href_gbingame}"><img src="{top_game_img}" width="100" height="100" alt="{game_name_en}"></a></div>
                        <div class="wt_title">
                            <div class="wt_game_titl">
                                <div class="wt_game_titl_in">
                                {top_game_name}
                                    [cont2=new_img]<span class="wt_s_nor wt_top_new"></span>[/cont2]
                                    [cont2=pop_img]<span class="wt_s_nor wt_top_pop"></span>[/cont2]
                                </div>
                            </div>
                            <div class="trans"></div>
                        </div>
                        <div class="anons">{top_game_desc}<div class="trans" style="height:16px;top:auto;bottom:0"></div></div>
                        <div class="wt_s_nor tag">
                            [cont2=tagname_rus] <a href="{WTURLMAIN}{wt_href_tag}">{tgr}</a>,[/cont2]
                        </div>
                        <a class="wt_s_nor ingame" href="{WTURLMAIN}{wt_href_gbingame}">&nbsp;</a>
                    </div>
                    <div class="best"><a href="{WTURLMAIN}{wt_href_genre}">Показать все {count}</a>Лучшее в разделе</div>
                    <div class="wt_game">
                        [cont2=most_popular]
                        <a{wtg_mp_class} href="{WTURLMAIN}{wt_href_gbmostp}">
							<div class="wt_game_icon inl" style="background-image:url({wtg_img16});">&nbsp;</div>
                            <div class="wt_game_name">{game_name}</div>
                            <div class="trans inl">&nbsp;</div>
                        </a>
                        [/cont2]
                    </div>
                </div>
            [/cont]
            </div>
        </div>
    </div>
</div>
