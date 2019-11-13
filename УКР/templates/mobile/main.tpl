<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
<meta name="MobileOptimized" content="176" />
{header}
<link media="screen" href="{theme}/style/style.css" type="text/css" rel="stylesheet" />  
<script type="text/javascript" src="/templates/mobile/js/main.js"></script>
<link rel="shortcut icon" href="/templates/mobile/images/fav.png" />
</head>
<body>
[aviable=main]<a href="/"><div class="head"><div class="udins"></div></div></a>[/aviable][not-aviable=main]<div class="head">
<a href="/"><div class="udins2"></div>{new-actions}</a>
<div class="speedb"><b id="text_mob_bar">{mobile-speedbar}</b><b id="modalmobbar"></b></div>
</div>[/not-aviable][aviable=main][logged]<a href="/u{my-id}" style="text-decoration:none">[/logged][/aviable][aviable=main|friends]<div class="bar">[/aviable][not-logged]{translate=lang_137}[/not-logged][logged][aviable=main]<img src="{my-ava}" align="left" style="margin-right:10px" width="40" height="40" /><b>{my-name}</b><br />{status-mobile}[/aviable][/logged][aviable=friends]{speedbar}[/aviable]
<div class="clr"></div>[aviable=main|friends]</div>[/aviable][aviable=main][logged]</a>[/logged][/aviable]
<div class="pageBg">[not-logged]<b style="color:#21578b">{translate=lang_734}</b><form method="POST" action="" class="note_add_bg support_bg" style="margin-top:5px">
 <div class="logB">{translate=lang_29}</div>
 <input type="text" name="email" class="inp" maxlength="50" />
 <div class="logB" style="margin-top:10px">{translate=lang_30}</div>
 <input type="password" name="password" class="inp" maxlength="50" />
 <button name="log_in" class="button" style="margin-top:10px">{translate=lang_137}</button>
</form>[/not-logged][logged][aviable=main]<div class="prTab">
<a href="/friends{requests-link}"><div class="oneBic">{demands}<div class="bgic"><div class="icFriends"></div></div>{translate=lang_116}</div></a>
<a href="/albums/{my-id}"><div class="oneBic"><div class="bgic"><div class="icPhotos"></div></div>{translate=lang_117}</div></a>
<a href="/messages"><div class="oneBic">{msg}<div class="bgic"><div class="icMsg"></div></div><div style="margin-left:-5px">{translate=lang_115}</div></div></a>
<a href="/news{news-link}"><div class="oneBic">{new-news}<div class="bgic"><div class="icNews"></div></div>{translate=lang_122}</div></a>
<a href="/groups"><div class="oneBic"><div class="bgic"><div class="icGroups"></div></div>{translate=lang_121}</div></a>
<a href="/fave"><div class="oneBic"><div class="bgic"><div class="icFave"></div></div>{translate=lang_118}</div></a>
<a href="/?go=search&online=1"><div class="oneBic"><div class="bgic"><div class="icSe"></div></div>{translate=lang_124}</div></a>
<a href="/support"><div class="oneBic">{new-support}<div class="bgic"><div class="icSupp"></div></div>{translate=lang_126}</div></a>
<a href="{ubm-link}"><div class="oneBic">{new-ubm}<div class="bgic"><div class="icMon"></div></div>{translate=lang_127}</div></a>
</div>[/aviable][/logged]
<div id="page"><div class="infobl"></div>{info}{content}</div>
<div id="modalbox"></div>
<div class="clr"></div>
</div>
<div class="foot">
 [logged]<a href="/settings" style="margin-right:15px">{translate=lang_125}</a>[/logged]<a href="/index.php?act=change_fullver">{translate=lang_733}</a>[logged]<a href="/?act=logout" style="margin-left:15px">{translate=lang_128}</a>[/logged]
<br />{translate=lang_engine} &copy; 2013 <a class="cursor_pointer" onClick="trsn.box()" onMouseOver="myhtml.title('1', '{translate=lang_145}', 'langTitle', 1)" id="langTitle1">{lang}</a> <br>
 <small><a href="/u1" onClick="Page.Go(this.href); return false">{translate=lang_author}</a></small>
</div>
<div class="no_display</div>
</body>
</html>