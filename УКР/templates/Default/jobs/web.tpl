<div class="dev_header">
<div id="dev_header_name" class="dev_header_name">
<a href="/jobs">Вакансии</a>
» Веб-разработчик
</div>
<span id="dev_page_sections"></span>
</div>

<div id="wrap2">
<div id="wrap1">
<script>
function deleteJobApplication(jid, aid) {
var ajax = new Ajax();
ajax.onDone = function() {ge('jobApplication'+aid).innerHTML = "<span style='color:#777'>заявка удалена</span>";};
ajax.onFail = function() {};
ajax.post("/web.php", {'act': 'a_delete_application', 'jid': jid, 'aid': aid});
return false;
}
</script>
<div style="padding:10px 10px 10px 10px;background-color:#F7F7F7;width: 700px;margin-left: -12px;">

<div class="positionRow">
<div class="positionTitle">
<a href="jobs">Веб-разработчик</a>
</div>
<div style="line-height:150%">
Будем рады видеть в нашей команде в Санкт-Петербурге амбициозного веб-разработчика.
<br>
<br>
<a name="Требования"></a>
<div class="wikiSubSubHeader">Требования</div>
<ul class="listing">
<li>
<span>Умение решать сложные задачи простыми способами </span>
</li>
<li>
<span>Умение быстро и самостоятельно добиваться результата </span>
</li>
<li>
<span>Большое внимание к мельчайшим деталям </span>
</li>
<li>
<span>
Крайне желателен опыт создания собственных проектов. При подаче заявки на эту вакансию
<b>обязательно</b>
нужно оставить ссылку на одну или несколько законченных работ
</span>
</li>
</ul>
<br>
<br>
<a name="Навыки"></a>
<div class="wikiSubSubHeader">Навыки</div>
<ul class="listing">
<li>
<span>Опыт работы с PHP </span>
</li>
<li>
<span>Опыт работы с JavaScript </span>
</li>
<li>
<span>Опыт работы с HTML/CSS </span>
</li>
<li>
<span>Опыт работы с MySQL </span>
</li>
<li>
<span>Базовые знания в построении нагрузочных систем (кеширование, оптимизация) </span>
</li>
<li>
<span>Приветствуется знание Flash (ActionScript 3.0) </span>
</li>
</ul>
<br>
<br>
<a name="Условия"></a>
<div class="wikiSubSubHeader">Условия</div>
<ul class="listing">
<li>
<span>Вознаграждение не ограничено сверху и зависит от амбиций и таланта разработчика. </span>
</li>
<li>
<span>Полный социальный пакет </span>
</li>
</ul>
</div>
<div style="margin-top:10px;">
<div class="clear_fix">
<div style="margin-bottom:5px">
<div class="button_blue fl_l" style="margin-right:15px;">
<button onclick="document.location='jobs.php?act=apply&id=23'">Предложить свои услуги</button>
</div>
</div>
<div style="padding-top: 30px"></div>
</div>
</div>
</div>
</div>
</div>
</div>