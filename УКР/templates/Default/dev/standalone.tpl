<link href="http://onepuls.ru/templates/Default/dev/dev.css" rel="stylesheet" type="text/css"></link>
<div class="dev_header">
<span id="dev_page_acts"></span>
<div id="dev_header_name" class="dev_header_name">
<a href="/developers">Главная</a>
<span class="dev_raquo_parents">»</span>
<a href="/dev/met">Документация</a>
» Standalone/Mobile
</div>
<span id="dev_page_sections"></span>
</div>
<div id="dev_page_cont" class="dev_page_cont fl_l">
<a name="Standalone/Mobile-приложения"></a>
<div class="wk_header">Standalone/Mobile-приложения</div>
Доступ к
<b>API Onepuls</b>
может быть получен из автономной программы на компьютере или мобильном устройстве пользователя.
<br>
<br>
Это открывает широкие возможности для создания как полнофункциональных клиентов Onepuls (например, официальное приложение для Android), так и различных сервисов, в которых информация, полученная с помощью API ВКонтакте, играет вспомогательную роль.
<br>
<br>
<a name="Создание приложения"></a>
<div class="wk_header">Создание приложения</div>
Создать новое приложение Вы можете
<b>
<a class="wk_vk_link" href="http://onepuls.ru/editapp/create">здесь</a>
</b>
, необходимый тип —
<b>«Standalone-приложение»</b>
.
<br>
После подтверждения действия с помощью кода, полученного в SMS, Вы будете переадресованы на страницу, содержащую настройки Вашего приложения.
<blockquote>
Обратите внимание — в дальнейшей работе Вам потребуются значения, указанные в полях
<b>«ID приложения»</b>
(в документации ему соответствует параметр
<b>API_ID</b>
,
<b>app_id</b>
или
<b>client_id</b>
) и
<b>«Защищенный ключ»</b>
(
<b>secret_key</b>
,
<b>client_secret</b>
).
</blockquote>
<br>
<br>
<a name="Способы авторизации"></a>
<div class="wk_header">Способы авторизации</div>
<ul class="listing">
<li>
<span class="l">
<b>
<a href="/dev/auth_mobile">OAuth-авторизация</a>
</b>
<br>
Основной способ авторизации Standalone/Mobile-приложений — клиентская авторизация на базе протокола
<b>OAuth 2.0</b>
(Implicit Flow).
</span>
</li>
<li>
<span class="l">
<b>
<a href="/dev/auth_direct">Прямая авторизация</a>
</b>
<br>
Для доверенных приложений возможен альтернативный способ — прямая авторизация по логину и паролю пользователя.
</span>
</li>
</ul>
<br>
<a name="Выполнение запросов к API"></a>
<div class="wk_header">Выполнение запросов к API</div>
Взаимодействие с API из Standalone/Mobile-приложений происходит по
<a href="/dev/api_requests">стандартной схеме</a>
. При этом Вы можете использовать практически все
<a href="/dev/methods">методы API</a>
, включая наиболее закрытые методы для работы с личными сообщениями, что позволяет реализовать в автономном приложении практически все функции, доступные пользователю в обычном интерфейсе сайта
<a class="wk_vk_link" href="http://onepuls.ru">http://onepuls.ru</a>
.
<br>
<br>
<div class="dev_report_bug">
<a id="sending" onclick="messages.new_(1); return false">Сообщить об ошибке</a>
</div>
</div>