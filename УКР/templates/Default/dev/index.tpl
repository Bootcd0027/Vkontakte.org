<link href="http://onepuls.ru/templates/Default/dev/dev.css" rel="stylesheet" type="text/css"></link>
<script src="http://onepuls.ru//templates/Default/dev/js/dev.js" type="text/javascript">
var Dev = {
init: function(opts) {
cur.searchEl = ge('dev_search');
placeholderSetup(cur.searchEl, {back: true});
cur.nav.push(function(changed, old, n) {
debugLog(n);
if (old[0] == 'dev' && !old.act) {
return true;
}
if (n[0].substr(0, 4) == 'dev/' || (n[0] == 'dev' && n.act) && cur.page) {
var page = n[0].substr(4);
if (page) {
Dev.switchPage(page, n.edit);
return false;
}
}
});
var onKey = function(e) {
if (opts.edit && e.keyCode == 83 && (e.ctrlKey || e.metaKey)) {
var btn = ge('dev_save_button');
btn.click();
return cancelEvent(e);
}
if (e.keyCode == KEY.RETURN && hasClass(e.target, 'dev_param_field')) {
ge('dev_req_run_btn').click();
}
}
addEvent(document, 'keydown', onKey);
cur.destroy.push(function() {
removeEvent(document, 'keydown', onKey);
});
Dev.initPage(opts);
if (cur.page) {
Dev.initSuggestions();
}
},
initPage: function(opts) {
if (opts.edit) {
var desc = ge('dev_method_desc');
placeholderSetup(desc, {back: true});
var simular = ge('dev_edit_simular');
placeholderSetup(simular, {back: true});
var textareas = geByClass('dev_textarea', ge('dev_page'));
for(var i in textareas) {
autosizeSetup(textareas[i], {});
}
elfocus(desc);
}
if (opts.res) {
Dev.requestResult(parseJSON(opts.res));
}
extend(cur, opts);
elfocus(cur.searchEl);
},
switchPage: function(page, edit) {
cur.page = page;
var pageRaw = page.split('.');
Dev.switchSection(pageRaw[0], false, true)
var curSel = geByClass1('dev_mlist_sel', ge('dev_mlist_cont'));
removeClass(curSel, 'dev_mlist_sel');
var newSel = ge('dev_mlist_'+page.replace('.', '_'));
if (newSel) {
addClass(newSel, 'dev_mlist_sel');
}
var actsCont = ge('dev_page_acts');
ajax.post('/dev/'+page, {preload: 1, edit: edit ? 1 : 0}, {
onDone: function(title, text, acts, edit_sections, isPage, opts, js) {
ge('dev_header_name').innerHTML = title;
ge('dev_page_cont').innerHTML = text;
ge('dev_page_acts').innerHTML = acts;
ge('dev_page_sections').innerHTML = edit_sections;
nav.setLoc('dev/'+page+(edit ? '?edit=1' : ''));
if (isPage) {
hide('dev_method_narrow');
show('dev_page_narrow');
} else {
show('dev_method_narrow');
hide('dev_page_narrow');
}
Dev.initPage(opts);
if (js) {
eval('(function(){' + js + ';})()');
}
scrollToTop(0);
},
showProgress: function() {
if (newSel && !cur.devSectLoader) {
cur.devSectLoader = actsCont.innerHTML;
actsCont.innerHTML = '<div class="progress_inline dev_sect_load fl_r"></div>';
}
},
hideProgress: function() {
if (cur.devSectLoader) {
actsCont.innerHTML = cur.devSectLoader;
cur.devSectLoader = false;
}
}
});
},
switchSection: function(sect, openSect, onlyIfSect) {
if (cur.sect == sect) {
return;
}
if (!cur.sections || !cur.sections[sect]) {
if (onlyIfSect) {
return;
}
sect = 'users';
}
var rows = cur.sections[sect]['list'];
var name = cur.sections[sect]['name'];
ge('dev_section_menu').innerHTML = name;
if (cur.methodsDD && cur.methodsDD.header && cur.methodsDD.header.firstChild) {
cur.methodsDD.header.firstChild.innerHTML = name;
}
var html = '';
var firstMethod = false;
for (var i in rows) {
var name = rows[i];
if (!firstMethod) {
firstMethod = name;
}
html += '<a id="dev_mlist_'+(name.replace(/\./g, '_'))+'" class="dev_mlist_item'+(cur.page == name ? ' dev_mlist_sel' : '')+'" href="/dev/'+name+'">'+name+'</a>';
}
var mlist = ge('dev_mlist_list');
mlist.innerHTML = html;
cur.sect = sect;
if (openSect) {
nav.go('/dev/'+sect);
}
},
getParamName: function(obj) {
var name = obj.id.replace(/^dev_edit_/, '');
return name.substr(0, 1).toUpperCase() + name.substr(1);
},
saveDoc: function(hash, btn) {
var params = {act: 'a_save_page', hash: hash, page: cur.page, type: cur.type};
var textareas = geByClass('dev_textarea', ge('dev_page'));
for (var i in textareas) {
params[Dev.getParamName(textareas[i])] = val(textareas[i]);
}
var inputs = geByClass('dev_input', ge('dev_page'));
for (var i in inputs) {
params[Dev.getParamName(inputs[i])] = val(inputs[i]);
}
var parents = [];
if (cur.dropDowns) {
for (var i in cur.dropDowns) {
var iItem = cur.dropDowns[i];
var value = iItem.val();
if (parseInt(value) != -1) {
for(var k in iItem.options.defaultItems) {
var kItem = iItem.options.defaultItems[k];
if (kItem[0] == value) {
parents.push(kItem[2]);
break;
}
}
}
}
}
params['parents'] = parents.join(',');
ajax.post('dev', params, {
onDone: function(msg) {
showDoneBox(msg);
},
showProgress: lockButton.pbind(btn),
hideProgress: unlockButton.pbind(btn)
})
},
parentChange: function(dd, v, objId) {
var cont = ge(objId);
var el = cont;
var nextEl = el.nextSibling;
while (nextEl) {
if (hasClass(nextEl, 'dev_sel_section')) {
for (var i in cur.dropDowns) {
if (cur.dropDowns[i].container.parentNode == nextEl) {
cur.dropDowns.splice(i ,1);
}
}
re(nextEl);
} else {
el = nextEl;
}
nextEl = el.nextSibling;
}
if (parseInt(v) == -1) {
var name = '';
} else {
var name = '';
for (var i in dd.defaultItems) {
if (parseInt(dd.defaultItems[i][0]) == parseInt(v)) {
name = dd.defaultItems[i][2];
}
}
}
var prg = ge('dev_sections_progress');
var parents = [];
if (cur.dropDowns) {
for (var i in cur.dropDowns) {
var iItem = cur.dropDowns[i];
var value = iItem.val();
if (parseInt(value) == -1) {
break;
} else {
for(var k in iItem.options.defaultItems) {
var kItem = iItem.options.defaultItems[k];
debugLog(kItem);
if (kItem[0] == value) {
parents.push(kItem[2]);
break;
}
}
}
}
}
ajax.post('dev', {act: 'a_get_sections', name: name, page: cur.page, parents: parents.join(','), hash: cur.editHash}, {
onDone: function(rows, js) {
cont.parentNode.insertBefore(cf(rows), prg);
eval('(function(){' + js + ';})()');
},
showProgress: show.pbind(prg),
hideProgress: hide.pbind(prg)
});
},
methodRun: function(hash, btn) {
var params = {hash: hash};
var paramsFields = geByClass('dev_param_field', ge('dev_params_wrap'));
var params = {act: 'a_run_method', method: cur.page, hash: hash};
for (var i in paramsFields) {
var el = paramsFields[i];
var v = val(el);
if (v !== '') {
params['param_'+el.id.substr(10)] = v;
}
}
if (cur.edit) {
params['_edit'] = '1';
}
ajax.post('dev', params, {
onDone: function(code) {
var res = parseJSON(code);
Dev.requestResult(res);
},
onFail: function(msg) {
setTimeout(showFastBox({title: getLang('global_error'), width: 500}, '<div style="word-wrap: break-word;">'+msg+'</div>').hide, 2000);
return true;
},
showProgress: lockButton.pbind(btn),
hideProgress: unlockButton.pbind(btn)
});
},
wrapObject: function(obj, noCover) {
var html = '';
if (!cur.wrapNum) {
cur.wrapNum = 0;
}
switch (typeof obj) {
case 'object':
var items = [];
if (Object.prototype.toString.call( obj ) == '[object Array]') {
for (var i in obj) {
items.push(Dev.wrapObject(obj[i]));
}
html += '<span class="dev_result_block"><span class="dev_result_lbracket">[</span>'+items.join(', ')+'<span class="dev_result_lbracket">]</span></span>';
} else {
for (var i in obj) {
items.push('<span class="dev_result_key">'+i+':</span> '+Dev.wrapObject(obj[i]));
}
var res = '<div class="dev_result_obj">'+items.join(',<br/>')+'</div>';
if (noCover) {
html += res;
} else {
html += '<span class="dev_result_block"><span id="dev_wrap_open_'+cur.wrapNum+'" class="dev_result_bracket">{</span><br/>'+res+'<span id="dev_wrap_close_'+cur.wrapNum+'" class="dev_result_bracket">}</span></span>';
cur.wrapNum += 1;
}
}
break;
case 'string':
var str = clean(obj);
if (obj.match(/^http:\/\/.*/)) {
str = '<a href="'+str+'" target="_blank">'+str+'</a>';
}
html += '<span class="dev_result_str">\''+str+'\'</span>';
break;
case 'number':
html += '<span class="dev_result_num">'+obj+'</span>';
break;
case 'boolean':
html += '<span class="dev_result_bool">'+obj+'</span>';
default:
debugLog('unknown type', typeof obj);
break;
}
return html;
},
requestResult: function(res) {
var html = Dev.wrapObject(res, true);
ge('dev_result').innerHTML = html;
},
resultMove: function(el) {
var res = ge('dev_result');
debugLog(el);
while(el) {
if (hasClass(el, 'dev_result_block')) {
addClass(el, 'dev_result_highlight')
break;
}
el = el.parentNode;
if (el == res) {
break;
}
}
if (cur.highLighted != el) {
removeClass(cur.highLighted, 'dev_result_highlight')
cur.highLighted = el;
}
},
onSearchChange: function(el, ev) {
if (ev) {
switch(ev.keyCode) {
case KEY.DOWN:
return Dev.selSuggRow(false, 1, ev);
break;
case KEY.UP:
return Dev.selSuggRow(false, -1, ev);
break;
case KEY.RETURN:
return Dev.onSearchSelect();
break;
case KEY.ESC:
val(el, '');
break;
}
}
setTimeout(function() {
var v = val(el).toLowerCase().replace(/[^a-zР°-СЏ]+/g, '');
if (v) {
if (v == cur.prevSearch) {
return show('dev_search_suggest');;
}
var reStr = '';
for (var i = 0; i < v.length; i++) {
reStr += v.substr(i, 1)+'.*?';
}
var regEx = new RegExp('.*?('+reStr+')', 'i');
var regExPrior = new RegExp('^('+reStr+')', 'i');
var found = [];
for(var i in cur.sections) {
var list = cur.sections[i].list;
for (var k in list) {
var method = list[k];
var m = method.match(regExPrior);
if (m) {
found.push([method, m[1].length]);
} else {
var m = method.match(regEx);
if (m) {
found.push([method, m[1].length+2]);
}
}
}
}
found = found.sort(function(a, b) {
if (a[1] < b[1]) {
return -1;
} else if (a[1] > b[1]) {
return 1
} else {
return 0;
}
});
var foundList = [];
for (var i in found) {
foundList.push(found[i][0])
}
Dev.showSuggestions(foundList, v);
} else {
Dev.showSuggestions();
}
cur.prevSearch = v;
}, 0);
},
initSuggestions: function() {
var cont = ge('dev_search_suggest_list');
debugLog('init sugg');
stManager.add(['notifier.css', 'notifier.js'], function() {
debugLog('go next');
cur.scroll = new Scrollbar(cont, {
prefix: 'fc_',
nomargin: true,
global: true,
nokeys: true,
right: vk.rtl ? 'auto' : 0,
left: !vk.rtl ? 'auto' : 0
});
});
},
showSuggestions: function(list, v) {
if (list && list.length) {
var cont = ge('dev_search_suggest_list');
var html = '';
var reStr = [];
for (var i = 0; i < v.length; i++) {
reStr.push(v.substr(i, 1));
}
var reg = new RegExp(reStr.join('.*?'), 'i');
for(var i in list) {
var name = list[i];
name = name.replace(reg, function(found) {
return '<em>'+found+'</em>';
})
html += '<a class="dev_search_row" onmousedown="return Dev.onSearchSelect(event);" onmouseover="Dev.selSuggRow(this);">'+name+'</a>';
}
cont.innerHTML = html;
show('dev_search_suggest');
if (cur.scroll) {
cur.scroll.scrollTop(0);
cur.scroll.update(false, true);
}
} else {
hide('dev_search_suggest');
debugLog('hiden');
}
},
onSearchSelect: function(ev) {
var cont = ge('dev_search_suggest_list');
var el = ge('dev_search');
var curSel = geByClass1('dev_sugg_sel', cont);
var method = false;
var q = val(el);
if (curSel) {
method = val(curSel).replace(/<[^>]*>/g, '');
} else {
firstSel = geByClass1('dev_search_row', cont);
var methodStr = (val(firstSel) || '').replace(/<[^>]*>/g, '');
if (methodStr && methodStr.replace(/[\. ]/g, '').toLowerCase().indexOf(q.replace(/[\. ]/g, '').toLowerCase()) === 0) {
if (methodStr.split('.')[0].toLowerCase().indexOf(q.toLowerCase()) === 0) {
method = methodStr.split('.')[0];
} else {
method = methodStr;
}
}
}
if (method) {
nav.go('dev/'+method);
val(el, '');
} else {
nav.go('dev?act=search&q='+q);
}
Dev.onSearchChange(el, ev);
return cancelEvent(ev);
},
selSuggRow: function(obj, move, ev) {
if (!isVisible(ge('dev_search_suggest'))) {
return false;
}
var cont = ge('dev_search_suggest_list');
var curSel = geByClass1('dev_sugg_sel', cont);
if (!obj) {
if (move == 1 && curSel) {
obj = curSel.nextSibling;
} else if (move == -1 && curSel) {
obj = curSel.previousSibling;
if (!obj) {
var listRows = geByClass('dev_search_row', cont);
obj = listRows[listRows.length - 1];
}
}
if (!obj) {
obj = geByClass1('dev_search_row', cont);
}
}
if (curSel != obj) {
if (curSel) {
removeClass(curSel, 'dev_sugg_sel');
}
addClass(obj, 'dev_sugg_sel');
if (move) {
var y = getXY(obj)[1];
var stY = getXY(cont)[1];
var pos = y - stY - cont.scrollTop;
var minHeight = getSize(obj)[1];
var maxHeight = 250 - getSize(obj)[1];
if (pos > maxHeight) {
cur.scroll.scrollTop(cont.scrollTop + pos - maxHeight);
} else if (pos < 0) {
cur.scroll.scrollTop(Math.max(0, cont.scrollTop + pos));
}
}
}
return cancelEvent(ev);
},
onSearchBlur: function() {
hide('dev_search_suggest');
},
checkParamVal: function(obj, ev, type, checks) {
switch(ev.keyCode) {
case KEY.UP:
if (type == 'int' || type == 'positive') {
val(obj, intval(val(obj)) + 1);
}
break;
case KEY.DOWN:
if (type == 'int' || type == 'positive') {
val(obj, intval(val(obj)) - 1);
}
break;
}
setTimeout(function() {
var v = val(obj);
var startVal = v;
switch(type) {
case 'int':
v = (v == '-') ? '-' : intval(v);
break;
case 'positive':
v = positive(v);
break;
}
if (v != startVal) {
val(obj, v);
}
}, 0)
},
toggleMethodListHeader: function(obj) {
var v = val(obj);
if (hasClass(obj, 'dev_methods_list_min')) {
removeClass(obj, 'dev_methods_list_min');
addClass(obj, 'dev_methods_list_max');
} else {
if (!v) {
addClass(obj, 'dev_methods_list_min');
removeClass(obj, 'dev_methods_list_max');
}
}
},
showPageSettings: function() {
},
reportError: function(address, title) {
return !showBox('/bugs', {act: 'new_box', doc: address, doc_title: title}, {
stat: ['wide_dd.js', 'wide_dd.css', 'page.css', 'page.js', 'upload.js'],
cache: 1,
params: {
width: 500,
hideButtons: true,
bodyStyle: 'border: 0px; padding: 0px'
}
});
},
paletteDown: function(ev, down, y, noChangeColor) {
var palette = ge('dev_palette');
var height = getSize(palette)[1];
if (y === undefined) {
var y = ev.offsetY || ev.layerY;
}
var y = Math.max(0, Math.min(y, height));
var t = Math.round(y / (height / 360));
t = Math.abs(t - 360);
t = (t == 360)? 0 : t;
ge('dev_colors').style.backgroundColor = "rgb("+Dev.hsv2rgb(t,100,100)+")";
if (!noChangeColor) {
Dev.setColor(Dev.hsv2rgb(t, cur.pickerX, cur.pickerY));
}
cur.pickerT = t;
var pointer = ge('dev_picker1');
setStyle(pointer, {marginTop: y - 1});
if (down) {
var yMain = ev.clientY;
var onMove = function(evNew) {
Dev.paletteDown(evNew, false, y + evNew.clientY - yMain);
}
addEvent(window, 'mousemove', onMove);
addEvent(window, 'mouseup', function(evNew) {
removeEvent(window, 'mousemove', onMove)
});
}
return cancelEvent(ev);
},
colorsDown: function(ev, down, x, y, noChangeColor) {
var pointer = ge('dev_picker2');
var colors = ge('dev_colors');
var size = getSize(colors);
if (x === undefined) {
var x = ev.offsetX || ev.layerX;
}
if (y === undefined) {
var y = ev.offsetY || ev.layerY;
}
y = Math.max(0, Math.min(y, size[1]));
x = Math.max(0, Math.min(x, size[0]));
setStyle(pointer, {marginTop: y - 6, marginLeft: x - 7});
cur.pickerX = x / size[0] * 100;
cur.pickerY = 100 - y / size[1] * 100;
if (!noChangeColor) {
Dev.setColor(Dev.hsv2rgb(cur.pickerT, cur.pickerX, cur.pickerY));
}
if (down) {
var yMain = ev.clientY;
var xMain = ev.clientX;
var onMove = function(evNew) {
Dev.colorsDown(evNew, false, x + evNew.clientX - xMain, y + evNew.clientY - yMain);
}
addEvent(window, 'mousemove', onMove);
addEvent(window, 'mouseup', function(evNew) {
removeEvent(window, 'mousemove', onMove)
});
}
return cancelEvent(ev);
},
hsv2rgb: function (H,S,V){
debugLog('try', H, S, V);
var f, p, q , t, lH, R, G, B;
S /=100;
V /=100;
lH = Math.floor(H / 60);
f = H/60 - lH;
p = V * (1 - S);
q = V *(1 - S*f);
t = V* (1 - (1-f)* S);
switch (lH) {
case 0: R = V; G = t; B = p; break;
case 1: R = q; G = V; B = p; break;
case 2: R = p; G = V; B = t; break;
case 3: R = p; G = q; B = V; break;
case 4: R = t; G = p; B = V; break;
case 5: R = V; G = p; B = q; break;
}
return [parseInt(R*255), parseInt(G*255), parseInt(B*255)];
},
rgb2hsv: function(rgb) {
var rr, gg, bb,
r = rgb[0] / 255,
g = rgb[1] / 255,
b = rgb[2] / 255,
h, s,
v = Math.max(r, g, b),
diff = v - Math.min(r, g, b),
diffc = function(c){
return (v - c) / 6 / diff + 1 / 2;
};
if (diff == 0) {
h = s = 0;
} else {
s = diff / v;
rr = diffc(r);
gg = diffc(g);
bb = diffc(b);
if (r === v) {
h = bb - gg;
} else if (g === v) {
h = (1 / 3) + rr - bb;
} else if (b === v) {
h = (2 / 3) + gg - rr;
}
if (h < 0) {
h += 1;
} else if (h > 1) {
h -= 1;
}
}
return {
h: Math.round(h * 360),
s: Math.round(s * 100),
v: Math.round(v * 100)
};
},
hex2rgb: function(hex) {
var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
hex = hex.replace(shorthandRegex, function(m, r, g, b) {
return r + r + g + g + b + b;
});
var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
return result ? [
parseInt(result[1], 16),
parseInt(result[2], 16),
parseInt(result[3], 16)
] : [0,0,0];
},
setColor: function(color) {
var col = ge('dev_colorbox'+cur.colorNum);
setStyle(col, {backgroundColor: 'rgb('+color.join(',')+')'});
var colInp = ge('groups_color'+cur.colorNum);
var hex = [color[0].toString(16), color[1].toString(16), color[2].toString(16)];
for(var i in hex) if (hex[i].length == 1) hex[i] = '0' + hex[i];
val(colInp, hex.join('').toUpperCase());
cur.soonUpdatePreview();
},
showColorBox: function(obj, num, ev) {
if (browser.msie && browser.version < 9) {
return false;
}
cur.colorNum = num;
var wrap = ge('dev_community_colors');
var cont = ge('dev_colorpicker');
var colors = ge('dev_colors');
var palette = ge('dev_palette');
var shownHere = false;
if (!cur.colorShown) {
fadeIn(cont, 200);
var shownHere = true;
cur.colorShown = true;
}
var posY = (getXY(obj)[1] - getXY(wrap)[1]);
if (cur.colorInited) {
animate(cont, {marginTop: -180 + posY}, 200)
} else {
setStyle(cont, {marginTop: -180 + posY})
var palSize = getSize(palette);
var pal = palette.getContext('2d');
var gradient = pal.createLinearGradient(palSize[0]/2,palSize[1],palSize[0]/2,0);
var hue = [[255,0,0],[255,255,0],[0,255,0],[0,255,255],[0,0,255],[255,0,255],[255,0,0]];
for (var i=0; i <= 6; i++){
color = 'rgb('+hue[i][0]+','+hue[i][1]+','+hue[i][2]+')';
gradient.addColorStop(i*1/6, color);
};
pal.fillStyle = gradient;
pal.fillRect(0, 0, palSize[0], palSize[1]);
addEvent(document, 'mouseup', function() {
cur.paletteDown = false;
})
}
var colInp = ge('groups_color'+cur.colorNum);
var color = val(colInp);
var rgb = Dev.hex2rgb(color);
var hsv = Dev.rgb2hsv(rgb);
Dev.paletteDown(false, false, (360 - hsv.h) / 360 * getSize(palette)[1], true);
var colorsSize = getSize(colors);
Dev.colorsDown(false, false, (hsv.s) / 100 * colorsSize[0], (100 - hsv.v) / 100 * colorsSize[1], true);
var onWndMove = function(ev) {
var el = ev.target;
while(el) {
if (el.id == 'dev_colorpicker' || hasClass(el, 'dev_colorbox_cont')) {
if (cur.colorBoxHideTimeout) {
debugLog('cancel Hide');
clearTimeout(cur.colorBoxHideTimeout);
cur.colorBoxHideTimeout = false;
}
return false;
}
el = el.parentNode;
}
if (cur.colorBoxHideTimeout) {
return false;
}
cur.colorBoxHideTimeout = setTimeout(function() {
fadeOut(cont, 200);
cur.colorShown = false;
removeEvent(window, 'mousemove', onWndMove);
}, 500);
};
if (shownHere) {
addEvent(window, 'mousemove', onWndMove);
}
cur.colorInited = true;
return cancelEvent(ev);
},
_eof:1};try{stManager.done('dev.js');}catch(e){}
</script>
<script src="http://st3.vk.me/js/al/wk.js?13" type="text/javascript">
var Wiki = {
inBox: function(params, event) {
if (checkEvent(event)) return;
if (cur.wkBox) cur.wkBox.hide();
cur.wkBox = showBox('al_pages.php', extend({act: 'in_box'}, params), {params: {
width: 634,
bodyStyle: 'max-height: 400px; padding: 10px 16px; padding-left: 10px; overflow-y: scroll; overflow-x: hidden;'
}});
return cancelEvent(event);
},
switchHider: function(el) {
var box = el.parentNode.parentNode;
if (hasClass(box, 'wk_hider_box')) {
box.className = box.className.replace('wk_hider_box', 'wk_hider_box_opened');
} else {
box.className = box.className.replace('wk_hider_box_opened', 'wk_hider_box');
}
},
toHash: function(obj, link) {
var loc = extend(clone(nav.objLoc), {f: link});
obj.href = '/'+nav.toStr(loc);
obj.setAttribute('onmousedown', '');
obj.onmousedown = null;
delete obj.onmousedown;
}
}
try{stManager.done('wk.js');}catch(e){}
</script>
<script src="http://st1.vk.me/js/lib/ui_controls.js?131" type="text/javascript">
// Classes:
// Dropdown / Autocomplete / Selector
// Select
// Checkbox
// Radiobutton
// Autosize
// DropdownMenu
// Cache
// Indexer
var UI_CONTROLS_DEBUG = false;
function debug(e) {
if (!UI_CONTROLS_DEBUG) return;
debugLog(e);
}
if (!window.vk) vk = {};
//
// OOP functions
//
function inherit(child, parent) {
var F = function() {};
F.prototype = parent.prototype;
child.prototype = new F();
child.prototype.constructor = child;
child.superclass = parent.prototype;
}
function createChildClass(className, parent, proto) {
var code = 'function ' + className + ' (a, b, c, d) {\
if (this == window || this.setInterval) return new ' + className + '(a, b, c, d);\
this.__className = "' + className + '";\
return this.__construct__(arguments);\
};';
if (window.execScript) {
window.execScript(code);
} else {
window.eval(code);
}
childClass = eval('(' + className + ')');
inherit(childClass, parent);
if (('common' in proto)) {
extend(childClass, proto['common']);
proto['common'] = childClass;
}
extend(childClass.prototype, proto);
}
if (window._ui === undefined) {
var _ui = {
_guid: 0,
_sel: false,
_uids: [false],
reg: function(obj) {
_ui._uids.push(obj);
return ++_ui._guid;
},
sel: function(nsel) {
if (nsel !== undefined) {
var s = _ui.selobj();
if (s && s._blur) {
s._blur();
}
_ui._sel = nsel;
}
return _ui._sel;
},
selobj: function(val) {
if (_ui._sel && val !== undefined) {
_ui._uids[_ui._sel] = val;
}
return _ui._uids[_ui._sel];
}
}
addEvent(document, 'keypress keydown mousedown', function(e) {
if (_ui.sel()) {
var sel = _ui.selobj();
if (!sel) {
return _ui.sel(false);
}
if (sel.container && sel.container != ge(sel.container.id)) {
_ui.selobj(false);
return _ui.sel(false);
}
sel.onEvent(e);
}
});
}
//
// UiControl abstract class
//
function UiControl(args) {
return this.__construct__(args);
}
extend(UiControl.prototype, {
// Constants
CSS: {},
defaultOptions: null,
dom: {},
// Consructor
__construct__: function(args) {
if (this.beforeInit) if (this.beforeInit.apply(this, args) === false) return false;
if (this.initOptions) if (this.initOptions.apply(this, args) === false) return false;
if (this.init.apply(this, args) === false) return false;
if (this.initDOM) if (this.initDOM.apply(this, args) === false) return false;
if (this.initEvents) this.initEvents.apply(this, args);
if (this.afterInit) this.afterInit.apply(this, args);
return this;
},
// Standart abstract methods
// UI Control initialisation
// User defined callback
beforeInit: null,
// Init options field
initOptions: null,
// init and initEvents are required
init: null,
// Construct DOM
initDOM: null,
// Attach events listeners to elements
initEvents: null,
// User defined callback
afterInit: null,
show: null,
hide: null
});
function Dropdown(input, data, options) {
if (!options) options = {};
return new Selector(
input,
options.autocomplete ? data : [], extend({
introText: '',
multiselect: false,
autocomplete: false,
selectedItems: options.selectedItem
}, options, {
defaultItems: data
}
));
}
// Alias
function Autocomplete(input, data, options) {
return new Selector(input, data, options);
}
//
// Dropdown class
//
createChildClass('Selector', UiControl, {
// Standart object fields
CSS: {
},
defaultOptions: {
selectedItems: [],
defaultItems: [],
multiselect: true,
autocomplete: true,
dropdown: true,
cacheLength: 100,
showMax: 10,
maxItems: 50,
maxItemsShown: function(query_length) {
if (query_length > 6) {
return 500;
} else if (query_length > 4) {
return 200;
} else if (query_length > 2) {
return 150;
} else {
return 100;
}
},
selectFirst: true,
dividingLine: 'smart',
enableCustom: false,
valueForCustom: -1,
width: 300,
height: 250,
progressBar: false,
highlight: function(label, term) {
label = term.indexOf(' ') == -1 ? label.split(' ') : [label];
var tmp = '';
var termRus = parseLatin(term);
if (termRus != null) {
term = term + '|' + termRus;
}
var re = new RegExp('(?![^&;]+;)(?!<[^<>]*)((\\(*)(' + escapeRE(term) + '))(?![^<>]*>)(?![^&;]+;)', 'gi');
for (var i in label) {
tmp += (i > 0 ? ' ' : '') + label[i].replace(re, '$2<em>$3</em>');
}
return tmp;
},
placeholder: '',
placeholderColor: '#afb8c2',
introText: 'Start typing',
noResult: getLang('search_nothing_found'),
noImageSrc: 'http://vk.com/images/question_s.gif',
formatResult: function(data) {
return data[1] + (typeof(data[2]) == 'string' ? ' <span>' + data[2] + '</span>' : '');
},
hrefPrefix: 'id'
},
controlName: 'Selector',
// Standart object methods
beforeInit: function(input) {
if (input == null || input['autocomplete']) {
try { console.error("Can't init ", input); } catch (e) {}
return false;
}
this.guid = _ui.reg(this);
},
initOptions: function(input, data, options) {
var opts = this.options = extend({}, this.defaultOptions, {
resultField: input['name'] || 'selectedItems',
customField: input['name'] ? (input['name'] + '_custom') : 'selectedItems_custom'
}, this.prepareOptionsText(options || {}));
// if highlight is set to false, replace it with a do-nothing function
opts.highlight = opts.highlight || function(label) { return label; };
// Get selected value
if (!isArray(opts.selectedItems) && isEmpty(opts.selectedItems)) {
opts.selectedItems = [];
}
if (input['value'] && !opts.selectedItems.length) {
opts.selectedItems = input['value'];
}
opts.width = parseInt(opts.width) > 0 ? parseInt(opts.width) : this.defaultOptions.width;
opts.height = parseInt(opts.height) > 0 ? parseInt(opts.height) : this.defaultOptions.height;
opts.resultListWidth = parseInt(opts.resultListWidth) > 0 ? parseInt(opts.resultListWidth) : opts.width;
if (opts.imageId) {
opts.imageId = ge(opts.imageId);
}
},
init: function(input, data) {
this.dataURL = typeof(data) == 'string' ? data : null;
this.dataItems = isArray(data) ? data : [];
this.currentList = this.dataItems;
if (this.dataURL) {
this.cache = new Cache(this.options);
} else {
this.indexer = new Indexer(this.dataItems, {indexkeys: this.options.indexkeys});
}
this._selectedItems = [];
this.input = input;
this.disabled = false;
this.mouseIsOver = false;
this.hasFocus = 0;
this.scrollbarWidth = 0;
this.timeout = null;
this.readOnly = (!this.options.autocomplete ? 'readonly="true"' : '');
this.requestTimeout = null;
this.selectedTokenId = 0;
this.selectorWidth = this.options.width;
},
initDOM: function(input, data, options) {
var opts = this.options, self = this;
this.container = ce('div', {
id: 'container' + this.guid,
className: 'selector_container' + (!opts.autocomplete ? ' dropdown_container' : '') + (browser.mobile ? ' mobile_selector_container' : ''),
innerHTML:
'<table cellspacing="0" cellpadding="0" class="selector_table">\
<tr>\
<td class="selector">\
<span class="selected_items"></span>\
<input type="text" class="selector_input" ' + this.readOnly + ' />\
<input type="hidden" name="' + opts.resultField + '" id="' + opts.resultField + '" value="" class="resultField"><input type="hidden" name="' + opts.customField + '" id="' + opts.customField + '" value="" class="customField">\
</td>' + (opts.dropdown ? '<td id="dropdown' + this.guid + '" class="selector_dropdown">&nbsp;</td>' : '') + '\
</tr>\
</table>\
<div class="results_container">\
<div class="result_list" style="display:none;"></div>\
<div class="result_list_shadow">\
<div class="shadow1"></div>\
<div class="shadow2"></div>\
</div>\
</div>'
}, {
width: opts.width + 'px'
});
input.parentNode.replaceChild(this.container, input);
each ({
selector: 'selector',
resultList: 'result_list',
resultListShadow: 'result_list_shadow',
input: 'selector_input',
selectedItemsContainer: 'selected_items',
resultField: 'resultField',
customField: 'customField',
dropdownButton: 'selector_dropdown'
}, function(k, v) {
self[k] = geByClass(v, self.container)[0];
});
if (browser.chrome) {
this.resultList.style.opacity = 1;
}
//if (!this.disabled) // always enabled at init
input.style.color = opts.placeholderColor;
input.autocomplete = '1';
if (opts.dividingLine) {
addClass(this.resultList, 'dividing_line')
}
this.resultList.style.width = this.resultListShadow.style.width = opts.resultListWidth + 'px';
if (this.options.dropdown) {
this.initDropdown();
}
this.select = new Select(this.resultList, this.resultListShadow, {
selectFirst: opts.selectFirst,
height: opts.height,
onItemActive: function(value) {
self.showImage(value);
self.activeItemValue = value;
},
onItemSelect: self._selectItem.bind(self),
onShow: function() {
_ui.sel(self.guid);
self.highlightInput(true);
if (options.onShow) {
options.onShow();
}
},
onHide: function() {
_ui.sel(false);
self.highlightInput(false);
if (options.onHide) {
options.onHide();
}
}
});
},
initEvents: function() {
var self = this;
if (this.options.dropdown) {
this.initDropdownEvents();
}
var keyev1 = browser.opera || browser.mozilla ? 'keypress' : 'keydown';
var keyev2 = browser.opera ? 'keypress' : 'keydown';
this.onEvent = function(e) {
if (e.type == 'mousedown') {
var outside = true, t = e.target;
while (t && t != t.parentNode) {
if (t == self.container) {
outside = false;
break;
}
t = t.parentNode;
}
if (outside) {
self.select.hide();
self.deselectTokens();
}
}
if (e.type == keyev1) {
self.handleKeyboardEventOutside(e);
}
if (e.type == keyev2) {
self.select.handleKeyEvent(e);
}
}
addEvent(this.input, 'paste keypress keydown focus blur', this.handleKeyboardEvent, false, {self: this});
addEvent(this.selector, 'mousedown', function(e) {
var click_over_token = false;
var el = e.target;
while (el != null) {
if (hasClass(el, 'token')) {
click_over_token = true;
break;
}
el = el.parentNode;
}
if (!click_over_token) {
return self.onInputClick(e);
}
return true;
}, false, {self: this});
},
afterInit: function() {
this.updateInput();
var opt = this.options, self = this;
if (opt.selectedItems !== undefined) {
if (isArray(opt.selectedItems)) {
for (var i in opt.selectedItems) {
this._selectItem(opt.selectedItems[i], false);
}
} else {
each((opt.selectedItems + '').split(','), function(i, x) {
self._selectItem(x, false);
});
}
}
// Select first item if it is dropdown
if (!this._selectedItems.length && !this.options.autocomplete && !this.options.multiselect && this.options.defaultItems.length) {
this._selectItem(this.options.defaultItems[0], false);
}
},
// Extended methods
prepareOptionsText: function(options) {
each(['disabledText', 'placeholder'], function() {
if (this in options) {
options[this] = winToUtf(stripHTML(options[this]));
}
});
return options;
},
fadeButtonToColor: function() {
if (this.options.customArrow) return;
var state = window.is_rtl ? {backgroundColor: '#E1E8ED', borderRightColor: '#D2DBE0'} : {backgroundColor: '#E1E8ED', borderLeftColor: '#D2DBE0'};
var self = this;
animate(this.dropdownButton, state, 200, function() {
if (!self.mouseIsOver) {
if (!self.select.isVisible()) {
self.fadeButtonToWhite();
} else {
self.dropdownButton.style.backgroundColor = self.dropdownButton.style[window.is_rtl ? 'borderRightColor' : 'borderLeftColor'] = '';
}
}
});
},
fadeButtonToWhite: function() {
if (this.options.customArrow) return;
var self = this;
animate(this.dropdownButton, {backgroundColor: '#FFFFFF', borderLeftColor: '#FFFFFF'}, 200, function() {
self.dropdownButton.style.backgroundColor = self.dropdownButton.style[window.is_rtl ? 'borderRightColor' : 'borderLeftColor'] = '';
if (self.mouseIsOver) {
self.fadeButtonToColor();
}
});
},
initDropdown: function() {
this.scrollbarWidth = this.options.customArrowWidth || window.sbWidth();
if (this.scrollbarWidth <= 3) {
this.scrollbarWidth = browser.mobile ? 20 : 14;
}
if (!this.options.customArrow) {
this.dropdownButton.style.width = this.scrollbarWidth + 'px';
}
this.selectorWidth -= this.scrollbarWidth;
},
initDropdownEvents: function() {
var self = this;
addEvent(this.dropdownButton, 'mouseover', function() {
addClass(this, 'selector_dropdown_hover');
});
addEvent(this.dropdownButton, 'mouseout', function() {
removeClass(this, 'selector_dropdown_hover');
});
addEvent(this.container, 'mouseover', function(e) {
self.mouseIsOver = true;
if (self.disabled) return;
self.fadeButtonToColor();
});
addEvent(this.container, 'mouseout', function() {
self.mouseIsOver = false;
if (self.disabled) return;
setTimeout(function() {
if (self.mouseIsOver) return;
if (!self.select.isVisible()) {
self.fadeButtonToWhite();
} else {
self.dropdownButton.style.backgroundColor = self.dropdownButton.style[window.is_rtl ? 'borderRightColor' : 'borderLeftColor'] = '';
}
}, 0);
});
addEvent(this.dropdownButton, 'mousedown', function() {
if (!self.select.isVisible()) {
self.showDefaultList();
} else {
self.select.toggle();
}
});
},
destroyDropdown: function() {
if (vk.al) cleanElems(this.dropdownButton);
removeEvent(this.container, 'mouseover');
removeEvent(this.container, 'mouseout');
this.scrollbarWidth = 0;
this.selectorWidth = this.options.width;
},
destroy: function() {
if (!vk.al || this.destroyed) return;
this.destroyDropdown();
var img = ge(this.options.imageId);
if (img) removeEvent(img, 'click');
this.select.destroy();
cleanElems(this.container, this.input, this.selector, this.resultList, this.resultListShadow);
for (var el = this.selectedItemsContainer.firstChild; el; el = el.nextSibling) {
cleanElems(el, el.firstChild.nextSibling);
}
this.destroyed = true;
},
updateInput: function() {
if (!this._selectedItems.length && !this.hasFocus) {
this.input.value = ((this.disabled && this.options.disabledText) ? this.options.disabledText : this.options.placeholder);
if (!this.disabled) this.input.style.color = this.options.placeholderColor;
}
if (!this.options.autocomplete && this.options.multiselect && this._selectedItems.length){
hide(this.input);
} else {
if (!isVisible(this.input)) show(this.input);
this.input.style.width = '20px';
var offset = this._selectedItems.length ? this.input.offsetLeft : (window.is_rtl ? this.selectorWidth - 9 : 0);
var w = window.is_rtl ? offset : (this.selectorWidth - offset - 9);
this.input.style.width = Math.max(20, w) + 'px';
}
},
handleKeyboardEvent: function(e) {
var self = e.data.self;
switch (e.type) {
case 'paste':
clearTimeout(self.timeout);
self.timeout = setTimeout(function(){ self.onChange(); }, 0);
break;
case 'keypress':
if (e.which == KEY.RETURN && browser.opera && self.options.enableCustom && (self.select.selectedItem() === null || self.select.selectedItem() === undefined)) {
self.select.hide();
if (!self.options.noBlur) { self.input.blur(); }
else if (isFunction(self.options.onChange)) {
self.updateCustom();
self.options.onChange(self.resultField.value);
}
return false;
} else if (e.which == KEY.SPACE || e.which > 40 && !e.metaKey) {
clearTimeout(self.timeout);
self.timeout = setTimeout(function(){ self.onChange(); }, 0);
}
break;
case 'keydown':
switch (e.keyCode) {
case KEY.DOWN:
if (!self.select.isVisible()) {
setTimeout(self.showDefaultList.bind(self), 0);
return false;
}
break;
case KEY.DEL:
if (self.input.value.length > 0) {
clearTimeout(self.timeout);
self.timeout = setTimeout(self.onChange.bind(self), 0);
} else {
if (self.selectedTokenId) {
var nextTokenId = 0;
for (var i = self._selectedItems.length - 2; i >= 0; i--) {
if (self._selectedItems[i][0] == self.selectedTokenId && self._selectedItems[i+1]) {
nextTokenId = self._selectedItems[i+1][0];
}
}
self.removeTagData(self.selectedTokenId);
if (nextTokenId) {
self.selectToken(nextTokenId);
} else if (!self.readOnly && !self.hasFocus) {
self.input.focus();
}
} else if (self.hasFocus && self._selectedItems.length) {
self.selectToken(self._selectedItems[self._selectedItems.length - 1][0]);
}
cancelEvent(e);
}
return true;
break;
case KEY.RETURN:
if (!browser.opera && self.options.enableCustom && (self.select.selectedItem() === null || self.select.selectedItem() === undefined)) {
self.select.hide();
if (!self.options.noBlur) { self.input.blur(); }
else if (isFunction(self.options.onChange)) {
self.updateCustom();
self.options.onChange(self.resultField.value);
}
return false;
}
break;
case KEY.ESC:
self.input.blur();
break;
}
break;
case 'focus':
if (!self.disabled && !self.select.isVisible() && !self.focusSelf) {
self.showDefaultList();
}
self.focusSelf = false;
if (self.disabled || self.readOnly) {
self.input.blur();
return true;
}
if ((self._selectedItems.length == 0) || self.options.multiselect) {
if (browser.mozilla) {
setTimeout(function () {
self.input.value = '';
}, 0);
} else {
self.input.value = '';
}
}
addClass(self.input, 'focused');
self.input.style.color = '#000';
self.hasFocus++;
break;
case 'blur':
if (self.options.chooseFirst && self.options.chooseFirst(self.input.value)) { // email field
// todo
self.select.active = 0;
if (isFunction(self.select.options.onItemSelect)) {
self.select.options.onItemSelect(self.select.selectedItem(), undefined, true);
}
return cancelEvent(e);
}
if (self.readOnly) return true;
if (!self.disabled) {
self.updateCustom();
clearTimeout(self.requestTimeout);
if (self.changeAfterBlur && isFunction(self.options.onChange)) {
if (!self.options.enableCustom || !self._selectedItems.length) {
self.options.onChange('');
}
self.changeAfterBlur = false;
}
if (self.options.onBlur) { self.options.onBlur(); }
}
if (!hasClass(self.input, 'selected')) {
self.input.style.color = self.options.placeholderColor;
}
removeClass(self.input, 'focused');
self.hasFocus = 0;
break;
}
return true;
},
updateCustom: function() {
var self = this;
if (self.options.enableCustom && self.input.value.length) {
var custom_val = self.input.value;
if (self._selectedItems.length == 0) {
self.resultField.value = parseInt(!self.options.valueForCustom);
self.customField.value = custom_val;
self._selectItem([self.options.valueForCustom, custom_val]);
}
} else if (self._selectedItems.length == 0) {
self.input.value = self.options.placeholder;
} else if (self.options.multiselect) {
self.input.value = '';
}
},
handleKeyboardEventOutside: function(e) {
if (this.disabled || this.input.value.length > 0 && this.hasFocus || !this.hasFocus && this.selectedTokenId == 0) {
return true;
}
switch(e.keyCode) {
case KEY.RETURN:
return false;
break;
case KEY.LEFT:
for (var i = this._selectedItems.length - 1; i >= 0; i--) {
if (!this.selectedTokenId || this._selectedItems[i][0] == this.selectedTokenId && i > 0) {
if (this.selectedTokenId) {
i--;
}
this.selectToken(this._selectedItems[i][0]);
this.input.blur();
break;
}
}
return false;
break;
case KEY.RIGHT:
for (var i = 0; i < this._selectedItems.length; i++) {
if (this._selectedItems[i][0] == this.selectedTokenId) {
if (i < this._selectedItems.length - 1) {
this.selectToken(this._selectedItems[i+1][0]);
this.input.blur();
} else if (!this.readOnly) {
this.deselectTokens();
this.input.focus();
}
break;
}
}
return false;
break;
}
return true;
},
onInputClick: function(e) {
var self = e.data.self;
self.deselectTokens();
if (!self.select.isVisible()) {
self.showDefaultList();
} else {
if (self.input.readOnly) {
self.focusSelf = true;
self.select.toggle();
} else {
self.onChange();
}
}
if (!self.readOnly) {
// self.focusSelf = true;
self.input.focus();
} else {
self.input.blur();
}
},
highlightInput: function(focus) {
if (focus) {
addClass(this.container, 'selector_focused');
} else {
removeClass(this.container, 'selector_focused');
}
},
selectToken: function(id) {
if (!this.options.multiselect) return;
this.select.hide();
removeClass(ge('bit_' + this.guid + '_' + this.selectedTokenId), 'token_selected');
addClass(ge('bit_' + this.guid + '_' + id), 'token_selected');
this.selectedTokenId = id;
if (this.options.onTokenSelected) this.options.onTokenSelected(id);
this.showImage(id);
},
deselectTokens: function() {
if (!this.selectedTokenId || !this.options.multiselect) return;
removeClass(ge('bit_' + this.guid + '_' + this.selectedTokenId), 'token_selected');
this.selectedTokenId = 0;
if (this.options.onTokenSelected) this.options.onTokenSelected();
this.showImage();
},
_blur: function() {
this.select.hide();
},
showImage: function(itemValue, itemData) {
if (!this.options.imageId) {
return false;
}
var img = ge(this.options.imageId);
if (!img) return false;
if (itemData === undefined) {
if (!itemValue) { // 0 or undefined
itemValue = this.resultField.value.split(',')[0];
}
var data = this._selectedItems.concat(this.currenDataItems);
if (data && data.length) {
for (var i in data) {
if (data[i] && data[i][0] == itemValue) {
itemData = data[i];
break;
}
}
}
}
if (itemData !== undefined && typeof(itemData[3]) == 'string' && itemData[3].length) {
if (itemData[3] == 'none'){
img.style.display = 'none';
} else {
img.style.display = '';
img.setAttribute('src', itemData[3]);
img.parentNode.href = '/' + this.options.hrefPrefix + itemData[0]; // hack
removeEvent(img.parentNode, 'click');
}
} else {
img.style.display = '';
img.setAttribute('src', this.options.noImageSrc);
img.parentNode.href = '#'; // hack
addEvent(img.parentNode, 'click', function() { return true; });
}
return true;
},
_selectItem: function(item, fireEvent, focusIfMultiselect) {
if (item == null) {
return;
}
if (fireEvent === undefined) {
fireEvent = true;
}
var data;
if (item == -2e9) {
data = [this.curTerm, this.curTerm, cur.lang['mail_enter_email_address'], '/images/pics/contact_info.png', 0, ''];
} else if (typeof(item) == 'string' && item.indexOf('@') != -1) {
data = [item, item, cur.lang['mail_enter_email_address'], '/images/pics/contact_info.png', 0, ''];
} else if (typeof(item) == 'object') {
data = item;
} else {
var all_data = [];
each([this.dataItems, this.options.defaultItems, this.receivedData], function(i,items) {
if (items && items.length)
all_data = all_data.concat(items);
});
for (var i in all_data) {
if (all_data[i][0] == item || all_data[i] == item) {
data = all_data[i];
break;
}
}
}
if (typeof data != 'object') {
data = [item, item]; // value and text
};
data[0] = data[0].toString();
data[1] = data[1].toString();
this.changeAfterBlur = false;
if (data[0] === this.resultField.value) {
if (!this.options.multiselect) {
this.input.value = winToUtf(stripHTML(data[1])); // It could have changed in setData method
this.showImage();
if (this.input.value.length || !this.options.placeholder) {
addClass(this.input, 'selected');
if (!this.disabled) {
this.input.style.color = this.resultField.value == '0' && this.options.zeroPlaceholder && this.options.placeholderColor || '#000';
}
} else {
this.input.value = this.options.placeholder;
if (!this.disabled) this.input.style.color = this.options.placeholderColor;
}
}
return;
}
if (this._selectedItems.length >= this.options.maxItems) {
this.select.hide();
return;
}
this.deselectTokens();
this.addTagData(data);
this.showImage();
if (this.options.multiselect) {
this.input.value = '';
if (this.dataURL) {
this.select.clear();
} else {
this.select.removeItem(data[0]);
}
} else {
this.input.value = winToUtf(stripHTML(data[1]));
addClass(this.input, 'selected');
if (!this.disabled) {
this.input.style.color = this.resultField.value == '0' && this.options.zeroPlaceholder && this.options.placeholderColor || '#000';
}
}
this.select.hide();
this.updateInput();
if (focusIfMultiselect && this.options.multiselect && !this.readOnly) {
setTimeout(function() {
if (!this.options.multinostop) {
this.focusSelf = true;
}
hide(this.input);
show(this.input);
this.input.focus();
}.bind(this), 100);
} else {
if (!this.options.noBlur) this.input.blur();
}
if (fireEvent) {
if (this.options.multiselect && isFunction(this.options.onTagAdd)) {
this.options.onTagAdd(data, this.resultField.value);
}
if (isFunction(this.options.onChange)) {
this.options.onChange(this.resultField.value);
}
}
},
addTagData: function(data) {
if (!data || data.length < 2) return;
if (!this.options.multiselect) {
this._selectedItems.splice(0, this._selectedItems.length, data);
this.resultField.value = data[0];
return;
}
for (var i in this._selectedItems) {
if (this._selectedItems[i][0] == data[0]) {
this.selectToken(this._selectedItems[i][0]);
return;
}
}
this._selectedItems.push(data);
var resultArr = [];
for (i in this._selectedItems) {
resultArr.push(this._selectedItems[i][0]);
}
this.resultField.value = resultArr.join(',');
this.input.style.width = '1px';
// make box
var token = ce('div', {
id: 'bit_' + this.guid + '_' + data[0],
className: 'token'
});
var maxTokenWidth = Math.max(this.selector.clientWidth, getSize(token)[0]);
var self = this;
token.innerHTML = '<span class="l">' + data[1] + '</span><span class="x" />';
addEvent(token, 'click', function() {
self.selectToken(data[0]);
return false;
});
addEvent(token, 'dblclick', function() {
if (data[4]) {
self.removeTagData(data[0]);
each(data[4], function(i, v) {
self._selectItem(v, false);
});
}
return false;
});
addEvent(token, 'mouseover', function(e) {
addClass(token, 'token_hover');
self.showImage(data[0], data);
});
addEvent(token, 'mouseout', function(e) {
removeClass(token, 'token_hover');
self.showImage(self.activeItemValue ? self.activeItemValue : self.selectedTokenId);
});
var close = token.firstChild.nextSibling;
addEvent(close, 'mousedown', function() {
self.select.hide();
self.removeTagData(data[0]);
if (!self.readOnly && self.hasFocus) {
self.input.focus();
}
return false;
});
self.selectedItemsContainer.appendChild(token);
var label = token.firstChild;
var labelStr = label.innerHTML;
while (token.offsetWidth > maxTokenWidth && labelStr.length > 3) {
labelStr = labelStr.substr(0, labelStr.length - 2);
label.innerHTML = labelStr + '...';
}
},
removeTagData: function(id) {
this.selectedTokenId = 0;
var token = ge('bit_' + this.guid + '_' + id);
if (!token) {
return false;
}
var close = token.firstChild.nextSibling;
if (vk.al) cleanElems(token, close);
token.parentNode.removeChild(token);
var index, resultArr = [];
for (i in this._selectedItems) {
if (this._selectedItems[i][0] == id) {
index = i;
continue;
}
resultArr.push(this._selectedItems[i][0]);
}
if (index == undefined) return false;
this.resultField.value = resultArr.join(',');
if (this.options.onTagRemove) {
this.options.onTagRemove(this._selectedItems[i], this.resultField.value);
}
if (isFunction(this.options.onChange)) {
this.options.onChange(this.resultField.value);
}
this._selectedItems.splice(index, 1);
if (this.options.multiselect) {
this.defaultList = false;
}
this.showImage();
this.updateInput();
return false;
},
onChange: function() {
var term = trim(this.input.value.toLowerCase()),
self = this;
if (!this.options.multiselect) {
if (this._selectedItems.length) {
this.changeAfterBlur = true;
}
this._clear();
}
clearTimeout(this.requestTimeout);
if (term.length == 0) {
this.showDefaultList();
return;
}
this.curTerm = term;
var custom = this.options.customSearch, res = custom && custom(term);
if (res) {
this.receiveData(term, res);
return;
}
if (this.dataURL) {
var data = this.cache.getData(term);
if (data == null) {
this.requestTimeout = setTimeout(function() {
self.request(self.receiveData.bind(self), self.showNoDataList.bind(self));
}, 300);
} else {
// receive the cached data
if (data && data.length) {
this.receiveData(term, data);
} else {
this.showNoDataList();
}
}
} else {
var data = this.indexer.search(term);
if (data && data.length) {
this.receiveData(term, data);
} else {
this.showNoDataList();
}
}
},
showNoDataList: function() {
if (this.hasFocus || this.readOnly) {
this._showSelectList(this.options.noResult);
this.defaultList = false;
}
},
showDefaultList: function() {
var reversed = hasClass(this.resultList, 'reverse');
if (reversed != this.needsReverse() && this.currenDataItems) {
this.setSelectContent(this.currenDataText || '', this.currenDataItems);
}
if (this.defaultList && this.select.hasItems()) {
if (this.options.multiselect || !this._selectedItems.length)
this.select.show();
else
this.select.show(this._selectedItems[0][0]);
} else {
this.defaultList = true;
var text = this.options.autocomplete ? this.options.introText : null;
this._showSelectList(text, (this.options.defaultItems.length || this.options.zeroDefault) ? this.options.defaultItems : this.dataItems);
}
reversed = hasClass(this.resultList, 'reverse');
if (reversed) {
if (!this._selectedItems.length) {
this.resultList.scrollTop = getSize(this.resultList.firstChild)[1] - getSize(this.resultList)[1] + 10;
}
setStyle(this.resultList, {bottom: getSize(this.container)[1] - 1});
} else {
setStyle(this.resultList, {bottom: 'auto'});
}
},
showDataList: function(items, query) {
this.defaultList = false;
this._showSelectList(null, items, query);
},
needsReverse: function() {
var scrollY = window.scrollGetY ? scrollGetY() : getScroll()[1],
contY = getXY(this.container)[1] || 0,
contH = getSize(this.container)[1] || 22,
maxListH = this.options.height || 250,
minListH = this.options.minHeight || 0,
wh = (window.pageNode && window.browser.mozilla ? Math.min(getSize(pageNode)[1], window.lastWindowHeight) : window.lastWindowHeight) || getScroll()[3],
list_ul = this.resultList && this.resultList.firstChild, listH;
if (list_ul && list_ul.firstChild) {
var disp = getStyle(this.resultList, 'display'), vis = getStyle(this.resultList, 'visibility');
setStyle(this.resultList, {visibility: 'hidden', display: 'block'});
listH = getSize(this.resultList)[1];
setStyle(this.resultList, {visibility: vis, display: disp});
} else {
listH = minListH ? minListH : (this.currenDataItems ? this.currenDataItems.length * getSize(this.container)[1] : maxListH);
}
if (listH > maxListH) listH = maxListH;
return (contY + contH + listH - scrollY > wh && contY - listH - scrollY > 0);
},
setSelectContent: function(text, items, query) {
items = isArray(items) && items.length ? items : [];
var adding = [];
this.select.clear();
if (text) {
adding.push(['', text, true]);
}
if (items.length) {
for (var i in items) {
if (typeof items[i] != 'object') items[i] = [items[i], items[i]];
}
if (this.options.multiselect) {
items = this.filterData(items);
}
if (this.options.dividingLine == 'smart') {
removeClass(this.resultList, 'dividing_line');
for (var i in items) {
if (typeof(items[i][2]) == 'string' && items[i][2].length) {
addClass(this.resultList, 'dividing_line');
}
}
}
var itemsToShow = (this.options.autocomplete && query) ? this.options.maxItemsShown(query.length) : items.length, self = this;
for (var i = 0; i < items.length; ++i) {
var it = items[i];
if (!itemsToShow) break;
var formatted = self.options.formatResult(it);
if (query) {
if ((formatted = self.options.highlight(formatted, query))) {
--itemsToShow;
}
}
if (!formatted) continue;
adding.push([it[0], formatted]);
}
}
var rev = this.needsReverse();
if (rev) adding = adding.reverse();
toggleClass(this.resultList, 'reverse', rev);
toggleClass(this.resultListShadow, 'reverse', rev);
this.select.content(adding);
},
_showSelectList: function(text, items, query) {
this.currenDataItems = items;
this.currenDataText = text;
// RTL fix
if (window.is_rtl) {
var l = getXY(this.container)[0];
if (l) geByClass('results_container', this.container)[0].style.left = l + 'px';
}
this.setSelectContent(text, items, query);
if (this.options.multiselect || !this._selectedItems.length) {
this.select.show();
} else {
this.select.show(this._selectedItems[0][0]);
}
return true;
},
receiveData: function(q, data) {
if (q != this.curTerm) return;
if (q != '' && data && data.length && this.hasFocus) {
this.receivedData = data;
this.showDataList(data, q);
} else {
this.select.hide();
}
},
filterData: function(items) {
var result = [], self = this;
each(items, function(i) {
for (var j in self._selectedItems) {
if (this[0] == self._selectedItems[j][0])
return;
}
result.push(this);
});
return result;
},
request: function(success, failure) {
if (!this.dataURL) return;
var term = trim(this.input.value.toLowerCase()), self = this;
if (term.length == 0) return;
var sep = this.dataURL.indexOf('?') == -1 ? '?' : '&';
var url = this.dataURL + sep + 'str=' + encodeURIComponent(term);
var done = function(data) {
if (self.options.progressBar) {
hide(self.options.progressBar);
}
try {
data = eval('(' + data + ')');
} catch (e) {}
if (data.length) {
self.cache.setData(term, data);
if (isFunction(success)) success(term, data);
} else {
self.cache.setData(term, []);
if (isFunction(failure)) failure(term);
}
}
if (vk.al) {
ajax.plainpost(url, {}, done);
} else {
var aj = new Ajax(function(obj, data) {
done(data);
});
aj.post(url);
}
if (this.options.progressBar) {
show(this.options.progressBar);
}
},
doSort: function(data) {
var i, j, tmp;
if (!data.length || data.length < 2) return;
for (i = 0; i < data.length - 1; i++) {
for (j = i + 1; j < data.length; j++) {
if (data[i][1] > data[j][1]) {
tmp = data[i];
data[i] = data[j];
data[j] = tmp;
}
}
}
},
disable: function(value) {
if (value && !this.disabled) {
this.disabled = true;
addClass(this.container, 'disabled');
var s = getSize(this.container);
if (this.options.disabledText) this.input.value = this.options.disabledText;
this.container.appendChild(
ce('div', {
className: 'hide_mask'
}, {
position: 'absolute',
background: '#000',
opacity: 0,
width: s[0] + 'px',
height: s[1] + 'px',
marginTop: -s[1] + 'px'
})
);
this.input.blur();
this.input.style.color = '';
this.select.hide();
//this.updateInput(); // Is it correct?
} else if (!value && this.disabled) {
this.disabled = false;
if (this.options.autocomplete) this.input.value = '';
removeClass(this.container, 'disabled');
this.container.removeChild(geByClass('hide_mask', this.container)[0]);
//this.updateInput(); // Is it correct?
}
},
_clear: function() {
this.showImage();
if (this.options.multiselect) {
this.selectedTokenId = 0;
this.selectedItemsContainer.innerHTML = '';
this.defaultList = false;
}
if (!this.options.multiselect && !this.options.autocomplete) {
if (this._selectedItems[0] != this.options.defaultItems[0]) {
this._selectItem(this.options.defaultItems[0], false);
}
} else {
removeClass(this.input, 'selected');
this.resultField.value = '';
this._selectedItems.splice(0, this._selectedItems.length);
}
return false;
},
setURL: function(url) {
if (typeof(url) == 'string') {
this.dataURL = url;
if (!this.cache) {
this.cache = new Cache(this.options);
} else {
this.cache.flush();
}
if (this.indexer) delete this.indexer;
this.dataItems = [];
}
},
setData: function(dataArr) {
if (!isArray(dataArr)) return;
if (!this.options.autocomplete) {
this.select.clear();
this.options.defaultItems = dataArr;
if (!this.options.multiselect) {
if (!this._selectedItems.length && this.options.defaultItems.length) {
this._selectItem(this.options.defaultItems[0], false);
} else if (this._selectedItems.length) {
var exists = false;
for (var i in this.options.defaultItems) {
var item = this.options.defaultItems[i][0] || this.options.defaultItems[i];
if (item == this._selectedItems[0][0] || item == this._selectedItems[0][0]) {
exists = true;
break
}
}
if (!exists) {
this._selectItem(this.options.defaultItems[0], false);
} else {
this._selectItem(this._selectedItems[0][0], false);
}
}
}
} else {
this.dataItems = dataArr;
this.dataURL = null;
}
if (!this.indexer) {
this.indexer = new Indexer(dataArr);
} else {
this.indexer.setData(dataArr);
}
if (this.cache) delete this.cache;
},
focus: function() {
if (!this.readOnly) {
this.input.focus();
}
},
selectItem: function(item, fireEvent) {
this._selectItem(item, fireEvent);
},
setOptions: function(new_options) {
new_options = this.prepareOptionsText(new_options);
extend(this.options, new_options);
if ('maxItems' in new_options && this.options.maxItems >= 0) {
for (var i = this._selectedItems.length - 1; i >= this.options.maxItems; i--) {
this.removeTagData(this._selectedItems[i][0]);
}
}
if ('defaultItems' in new_options) {
this.select.clear();
if (this.select.isVisible(this.container)) { // todo: check and remove arg
this.showDefaultList();
}
}
if ('enableCustom' in new_options) {
if (this.options.enableCustom && !this.options.autocomplete) {
this.options.autocomplete = new_options.autocomplete = true;
}
}
if ('width' in new_options) {
this.container.style.width = this.options.width + 'px';
this.resultList.style.width = this.resultListShadow.style.width = this.options.width + 'px';
this.selectorWidth = this.options.width - this.scrollbarWidth;
}
if ('dropdown' in new_options) {
var dd = geByClass('selector_dropdown', this.container)[0];
if (!this.options.dropdown && dd) {
this.destroyDropdown();
dd.parentNode.removeChild(dd);
} else if (!dd && this.options.dropdown) {
dd = this.container.firstChild.rows[0].insertCell(1);
dd.id = 'dropdown' + this.guid;
dd.className = 'selector_dropdown';
dd.innerHTML = '&nbsp;';
this.dropdownButton = dd;
this.initDropdown();
this.initDropdownEvents();
}
}
if (('width' in new_options) || ('autocomplete' in new_options) || ('dropdown' in new_options)) {
this.updateInput();
}
if ('autocomplete' in new_options) {
if (this.options.autocomplete) {
removeClass(this.container, 'dropdown_container');
this.input.readOnly = false;
this.readOnly = '';
} else {
addClass(this.container, 'dropdown_container');
this.input.readOnly = true;
this.options.enableCustom = false;
this.readOnly = 'readonly="true"';
}
}
},
val: function(value, fireEvent) {
if (value !== undefined) this._selectItem(value, (fireEvent === undefined) ? false : fireEvent);
return this.resultField.value;
},
val_full: function() {
if (this.options.multiselect) {
return this._selectedItems;
} else {
if (this._selectedItems.length) {
return this._selectedItems[0];
} else {
return [this.resultField.value, this.input.value];
}
}
},
customVal: function(value, fireEvent) {
if (value !== undefined) {
this.customField.value = value;
this.selectItem([this.options.valueForCustom, value], (fireEvent === undefined) ? false : fireEvent);
}
return this.customField.value;
},
selectedItems: function() {
return this._selectedItems;
},
clear: function() {
this._clear();
this.updateInput();
}
});
//
// Select class
//
createChildClass('Select', UiControl, {
// Static class fields
common: {
_sel: window.Select && Select._sel || [],
reg: function(obj) {
this._sel.push(obj);
return this._sel.length;
},
destroy: function(uid) {
this._sel[uid - 1] = false;
},
itemMouseMove: function(uid, i, el) {
this._sel[uid - 1].onMouseMove(i, el);
},
itemMouseDown: function(uid, i, el) {
this._sel[uid - 1].onMouseDown(i, el);
}
},
// Standart fields
CSS: {
FIRST: 'first',
LAST: 'last',
ACTIVE: 'active',
SCROLLABLE: 'result_list_scrollable'
},
controlName: 'SelectList',
// Standart methods
initOptions: function(container, shadow, options) {
this.options = options || {};
},
init: function(container, shadow, options) {
this.container = container;
this.shadow = shadow;
this.active = -1;
this.data = [];
this.uid = this.common.reg(this);
this.maxHeight = this.options.height ? this.options.height : 250;
},
initDOM: function() {
this.list = ce('ul');
this.container.appendChild(this.list);
},
show: function(selectedItem) {
var wasVisible = isVisible(this.container);
if (!wasVisible) {
this.performShow();
}
var childNode;
if (selectedItem) {
for (var i = 0; i < this.list.childNodes.length; i++) {
childNode = this.list.childNodes[i];
if (childNode.getAttribute('val') == selectedItem) {
this.highlight(i, childNode);
break;
}
}
} else if (this.options.selectFirst) {
var reversed = this.container && hasClass(this.container, 'reverse'), ind;
for (var i = 0; i < this.list.childNodes.length; i++) {
ind = reversed ? this.list.childNodes.length - 1 - i : i;
childNode = this.list.childNodes[ind];
if (!childNode.getAttribute('dis')) {
this.highlight(ind, childNode);
break;
}
}
}
if (!wasVisible && isFunction(this.options.onShow)) this.options.onShow();
},
hide: function() {
if (!isVisible(this.container)) return;
hide(this.container);
hide(this.shadow);
if (isFunction(this.options.onHide)) this.options.onHide();
this.highlight(-1);
if (isFunction(this.options.onItemActive)) this.options.onItemActive();
},
// Extended methods
handleKeyEvent: function(e) {
if (!isVisible(this.container)) {
return true;
}
switch(e.keyCode) {
case KEY.UP:
this.movePosition(-1)
return cancelEvent(e);
break;
case KEY.DOWN:
this.movePosition(1);
return cancelEvent(e);
break;
case KEY.TAB:
this.hide();
break;
case KEY.RETURN:
if (isFunction(this.options.onItemSelect) && this.active > -1) {
this.options.onItemSelect(this.selectedItem(), undefined, true);
}
cancelEvent(e);
return false;
break;
case KEY.ESC:
this.hide();
return false;
break;
case KEY.PAGEUP:
case KEY.PAGEDOWN:
// deprecated
return false;
break;
}
return true;
},
clear: function() {
this.highlight(-1);
this.list.innerHTML = '';
this.updateContainer();
},
destroy: function() {
this.clear();
Select.destroy(this.uid);
},
selectedItem: function() {
if (this.active >= 0) {
var el = this.list.childNodes[this.active];
var value = el.getAttribute('val') || el.innerHTML;
return value;
}
return undefined;
},
movePosition: function(step) {
var selected = intval(this.active) + intval(step);
if (selected < 0)
this.container.scrollTop = 0;
else if (selected + 1 > this.list.childNodes.length)
this.container.scrollTop = this.list.offsetTop + this.list.offsetHeight - this.container.offsetHeight;
while (1) {
if (selected + 1 > this.list.childNodes.length || selected < 0) {
if (this.options.cycle) break;
else return false;
}
var s = this.list.childNodes[selected];
if (s && !s.getAttribute('dis')) {
break;
}
selected++;
}
this.highlight(selected, this.list.childNodes[selected]);
return true;
},
highlight: function(i, el) {
if (this.active != -1) {
removeClass(this.list.childNodes[this.active], this.CSS.ACTIVE);
}
if (!el) {
this.active = -1;
return;
}
this.active = i;
addClass(el, this.CSS.ACTIVE);
if (isFunction(this.options.onItemActive)) {
this.options.onItemActive(el.getAttribute('val') || el.innerHTML);
}
if (el.offsetTop + el.offsetHeight + this.list.offsetTop > this.container.offsetHeight + this.container.scrollTop - 1) {
this.container.scrollTop = el.offsetTop + this.list.offsetTop + el.offsetHeight - this.container.offsetHeight + 1;
} else if (el.offsetTop + this.list.offsetTop < this.container.scrollTop) {
this.container.scrollTop = el.offsetTop + this.list.offsetTop;
}
},
onMouseMove: function(i, el) {
if (hasClass(el, 'active')) return false;
this.highlight(i, el);
return true;
},
onMouseDown: function(i, el) {
var val = el.getAttribute('val') || el.innerHTML;
if (isFunction(this.options.onItemSelect)) {
this.options.onItemSelect(val, undefined, true);
}
this.hide();
},
updateContainer: function() {
if (this.maxHeight < this.list.offsetHeight) {
this.container.style.height = this.maxHeight + 'px';
show(this.shadow);
this.shadow.style.marginTop = (this.maxHeight + 1) + 'px'; // +1 - because of border-bottom
addClass(this.container, this.CSS.SCROLLABLE);
} else {
removeClass(this.container, this.CSS.SCROLLABLE);
this.container.style.height = 'auto';
var shadow_height = intval(this.list.offsetHeight) + intval(this.list.offsetTop);
if (shadow_height) {
show(this.shadow);
this.shadow.style.marginTop = shadow_height + 'px';
} else {
hide(this.shadow);
}
}
},
content: function(items) {
var html = [],
i, it, v, t, d, a, ind,
len = items.length;
for (i = 0; i < len; ++i) {
// value, text, disabled, attributes, index
it = items[i];
v = it[0];
t = it[1];
d = it[2];
ind = this.uid + ', ' + i;
v = (v === undefined) ? '' : v.toString();
t = ((t === undefined) ? '' : t.toString()) || v;
html.push(
'<li ',
!d ? 'onmousemove="Select.itemMouseMove(' + ind + ', this)" onmousedown="Select.itemMouseDown(' + ind + ', this)"' : 'dis="1"',
' val="',
v.replace(/&/g, '&amp;').replace(/"/g, '&quot;'),
'" class="',
(d ? 'disabled ' : ''),
((i == len - 1) ? (this.CSS.LAST + ' ') : ''),
(i ? '' : this.CSS.FIRST) + '">',
t,
'</li>'
);
}
this.list.innerHTML = html.join('');
this.updateContainer();
return true;
},
removeItem: function(value) {
var undefined, l = this.list.childNodes, len = l.length;
if (value === undefined) return;
for (var i = 0; i < len; ++i) {
var node = l[i];
if (node.getAttribute('val') != value && node.innerHTML != value) continue;
node.setAttribute('dis', '1');
hide(node);
break;
}
for (var i = 0; i < len; ++i) {
if (isVisible(l[i])) {
addClass(l[i], this.CSS.FIRST);
break;
}
}
for (var i = len; i > 0; --i) {
if (isVisible(l[i - 1])) {
addClass(l[i - 1], this.CSS.LAST);
break;
}
}
this.updateContainer();
},
// AntanubiS - if list.offsetHeight is greater, than screen without scrollbar - bugs.
performShow: function() {
this.list.style.position = 'absolute';
this.list.style.visibility = 'hidden';
show(this.container);// We see bug in MessageBox with Selector between theese lines.
show(this.shadow);
this.updateContainer();
this.list.style.position = 'relative';
this.list.style.visibility = 'visible';
},
// Shortcuts
isVisible: function() {
return isVisible(this.container);
},
hasItems: function() {
return this.list.childNodes.length > 0;
},
toggle: function() {
if (this.isVisible(this.container)) {
this.hide();
} else {
this.show();
}
}
});
//
// Checkbox class
//
createChildClass('Checkbox', UiControl, {
// Standart fields
CSS: {
STANDART: 'checkbox_'
},
defaultOptions: {
checkedValue: 1,
notCheckedValue: '',
width: 300,
label: 'checkbox'
},
beforeInit: function() {
this.guid = _ui.reg(this);
},
controlName: 'CheckBox',
initOptions: function(input, options) {
if (!input) return false;
this.options = extend({}, this.defaultOptions, {
checked: input['value'],
resultField: input.name || input.id || 'checkbox'
}, options);
this.options.checked = intval(this.options.checked) ? true : false;
this.options.width = intval(this.options.width) > 0 ? intval(this.options.width) : this.defaultOptions.width;
},
init: function() {
this.disabled = false;
},
initDOM: function(input, options) {
this.container = ce('div', {
id: 'container' + this.guid,
className: 'checkbox_container',
innerHTML: '<table cellpadding=0 cellspacing=0><tr><td class="checkbox"><div class="checkbox_off"></div></td><td class="checkbox_label">' + this.options.label + '<input type="hidden" name="' + this.options.resultField + '" id="' + this.options.resultField + '" value="'+ (this.options.checked ? this.options.checkedValue : this.options.notCheckedValue) + '"></td></tr></table>'
}, {
width: this.options.width + 'px'
});
input.parentNode.replaceChild(this.container, input);
this.checkbox = geByClass('checkbox_off', this.container)[0];
this.resultField = ge(this.options.resultField);
},
initEvents: function() {
addEvent(this.container, 'click mouseover mouseout', this.handleMouseEvent, false, {'self': this});
},
afterInit: function() {
this.setState(this.options.checked, false, true);
},
destroy: function() {
if (!vk.al || this.destroyed) return;
removeEvent(this.container, 'click mouseover mouseout', this.handleMouseEvent);
this.destroyed = true;
},
show: function() {show(this.container);},
hide: function() {hide(this.container);},
// extended methods
handleMouseEvent: function(e) {
if (e.type == 'click') {
if (!e.data.self.disabled) {
e.data.self.setState(!e.data.self.options.checked);
}
} else {
e.data.self.is_over = (e.type == 'mouseover');
e.data.self.updateClass();
}
},
disable: function(value) {
if (value && !this.disabled) {
this.disabled = true;
addClass(this.container, 'disabled');
} else if (!value && this.disabled) {
this.disabled = false;
removeClass(this.container, 'disabled');
}
},
updateClass: function() {
this.checkbox.className = 'checkbox_' + (this.options.checked ? 'on' : 'off') + (this.is_over ? '_over' : '');
},
setState: function(checked, fireEvent, forceUpdate) {
if (fireEvent === undefined) fireEvent = true;
if (forceUpdate === undefined) forceUpdate = false;
checked = checked ? true : false;
if (this.options.checked == checked && !forceUpdate) {
return;
}
this.options.checked = checked;
this.updateClass();
this.resultField.value = this.options.checked ? this.options.checkedValue : this.options.notCheckedValue;
if (fireEvent && isFunction(this.options.onChange)) {
this.options.onChange(this.resultField.value);
}
},
// shortcuts
setOptions: function(new_options) {
extend(this.options, new_options);
if (('checked' in new_options) || ('checkedValue' in new_options) || ('notCheckedValue' in new_options)) {
this.setState(this.options.checked, false, true);
}
},
checked: function(value) {
if (value !== undefined) this.setState(value);
return this.options.checked;
},
val: function() {
return this.resultField.value;
}
});
//
// Radiobutton class
//
createChildClass('Radiobutton', UiControl, {
// Static class fields
common: {
_radio_buttons: {},
_callbacks: {},
// static methods
deselect: function(name) {
for (var i = 0; i < this._radio_buttons[name].length; ++i) {
this._radio_buttons[name][i].checked(false);
}
},
select: function(name, value) {
for (var i = 0; i < this._radio_buttons[name].length; ++i) {
if (this._radio_buttons[name][i].val() == value) {
this._radio_buttons[name][i].checked(true);
return;
}
}
},
setChangeEvent: function(name, callback) {
if (isFunction(callback)) this._callbacks[name] = callback;
else delete(this._callbacks[name]);
}
},
// Standart object fields
CSS: {
STANDART: 'radiobutton_',
CONTAINER: 'radiobtn_container'
},
defaultOptions: {
checked: false,
width: 300,
label: 'radiobutton'
},
controlName: 'Radiobutton',
beforeInit: function() {
this.guid = _ui.reg(this);
},
initOptions: function(input, options) {
if (!input) return false;
this.options = extend({}, this.defaultOptions, {
value: input.value,
resultField: input.name || 'radiobutton'
}, options);
this.options.checked = intval(this.options.checked) ? true : false;
this.options.width = intval(this.options.width) > 0 ? intval(this.options.width) : this.defaultOptions.width;
},
init: function() {
this.disabled = false;
this.is_over = false;
this.inputName = this.options.resultField;
},
initDOM: function(input, options) {
this.container = ce('div', {
id: 'container' + this.guid,
className: this.CSS.CONTAINER,
innerHTML: '<table cellpadding=0 cellspacing=0><tr><td class="radiobtn"><div class="radiobtn_off"><div></div></div></td><td class="radiobtn_label">' + this.options.label + '<input type="radio" id="' + input.id + '" name="' + this.options.resultField + '" value="'+ (this.options.checked ? 'checked="true"' : '') + '"></td></tr></table>'
}, {
width: this.options.width + 'px'
});
input.parentNode.replaceChild(this.container, input);
this.radiobutton = geByClass('radiobtn_off', this.container)[0];
this.resultField = this.container.getElementsByTagName('input')[0];
this.resultField.value = this.options.value;
},
initEvents: function() {
addEvent(this.container, 'click mouseover mouseout', this.handleMouseEvent, false, {'self': this});
},
afterInit: function() {
if (!isArray(this.common._radio_buttons[this.inputName])) {
this.common._radio_buttons[this.inputName] = [];
}
this.common._radio_buttons[this.inputName].push(this);
this.setState(this.options.checked, false, true);
},
destroy: function() {
if (!vk.al || this.destroyed) return;
for (var i = 0; i < this.common._radio_buttons[this.inputName].length; ++i) {
if (this.common._radio_buttons[this.inputName][i] === this) {
this.common._radio_buttons[this.inputName].splice(i, 1);
break;
}
}
if (!this.common._radio_buttons[this.inputName].length) {
delete this.common._radio_buttons[this.inputName];
this.common.setChangeEvent(this.inputName);
}
removeEvent(this.container, 'click mouseover mouseout', this.handleMouseEvent);
this.destroyed = true;
},
handleMouseEvent: function(e) {
var t = e.data.self;
if (e.type == 'click') {
if (!t.disabled && !t.options.checked) {
t.setState(true);
}
} else {
t.is_over = (e.type == 'mouseover');
t.updateClass();
}
},
disable: function(value) {
if (value && !this.disabled) {
this.disabled = true;
addClass(this.container, 'disabled');
} else if (!value && this.disabled) {
this.disabled = false;
removeClass(this.container, 'disabled');
}
},
updateClass: function() {
this.radiobutton.className = 'radiobtn_' + (this.options.checked ? 'on' : 'off') + (this.is_over ? '_over' : '');
},
setState: function(checked, fireEvent, forceUpdate) {
if (fireEvent === undefined) fireEvent = true;
forceUpdate = forceUpdate || false;
checked = checked ? true : false;
if (this.options.checked == checked && !forceUpdate)
return;
if (checked)
this.common.deselect(this.inputName);
this.options.checked = checked;
this.updateClass();
this.resultField.checked = checked;
if (fireEvent) {
if (this.options.checked && isFunction(this.options.onSelect))
this.options.onSelect(this.resultField.value);
if (isFunction(this.options.onChange))
this.options.onChange(this.resultField.value, checked);
if (checked) {
if (isFunction(this.common._callbacks[this.inputName])) this.common._callbacks[this.inputName](this.resultField.value);
}
}
},
// shortcuts
setOptions: function(new_options) {
extend(this.options, new_options);
if (('checked' in new_options)) {
this.setState(this.options.checked, false);
}
},
checked: function(value) {
if (value !== undefined) this.setState(value);
return this.options.checked;
},
val: function() {
return this.resultField.value;
}
});
// Multiple radiobutton initialization
function Radiobuttons(input, buttons, options) {
var id = input.id;
Radiobutton._radio_buttons[id] = [];
Radiobutton._callbacks[id] = [];
each(buttons, function(i, v) {
new Radiobutton(ge(id + v[0]), {label: v[1], width: options.width, resultField:id});
});
Radiobutton.select(id, options.selected !== undefined ? options.selected : input.value);
Radiobutton.setChangeEvent(id, function(value) {
input.value = value;
if(isFunction(options.onChange)) {
options.onChange(value);
}
});
}
//
// Autosize class
//
createChildClass('Autosize', UiControl, {
// Static class fields
common: {
_autosize_helpers: null
},
// Standart object fields
CSS: {
},
defaultOptions: {
height: 0,
minHeight: 0,
padding: 0,
helperTA: false // new type of autosize, untested
},
controlName: 'Autosize',
// Standart object methods
beforeInit: function() {
this.guid = _ui.reg(this);
if (!this.common._autosize_helpers || !ge('autosize_helpers')) {
document.body.appendChild(
(this.common._autosize_helpers = ce('div', {'id': 'autosize_helpers'}, {
'position': 'absolute',
'left': '-10000px',
'top': '-10000px'
}))
);
}
},
initOptions: function(textarea, options) {
this.options = extend({}, this.defaultOptions, options);
this.options.checked = intval(this.options.checked) ? true : false;
this.options.width = intval(this.options.width) > 0 ? intval(this.options.width) : this.defaultOptions.width;
},
init: function(input) {
this.input = input;
this.oldValue = '';
this.oldHeight = 0;
this.overflowAuto = false;
},
initDOM: function(input) {
this.minHeight = intval(this.options.minHeight) || intval(getStyle(input, 'height'));
this.maxHeight = intval(this.options.height);
this.fontSize = intval(getStyle(input, 'fontSize'));
var w = intval(getStyle(input, 'width'));
// fix for hidden textareas
if (w < 1) {
w = intval(getStyle(input, 'width', false));
}
if (this.defaultOptions.padding) w -= this.defaultOptions.padding * 2;
this.common._autosize_helpers.appendChild(
this.helper = ce(this.options.helperTA ? 'textarea' : 'div', false, {
wordWrap: 'break-word',
width: (w < 0 ? 0 : w) + 'px',
fontFamily: getStyle(input, 'fontFamily'),
fontSize: this.fontSize + 'px',
lineHeight: getStyle(input, 'lineHeight')
})
);
this.input.helper = this.helper;
setStyle(this.input, 'overflow', 'hidden');
},
initEvents: function() {
addEvent(this.input, 'keydown keypress keyup', this.updateSize, false, {'self': this});
},
afterInit: function() {
this.update();
},
// Extended methods
updateSize: function(event) {
var self = event.data.self, value = self.input.value, newHeight;
if (event.type != 'keyup') {
if (event.keyCode == 13 && !event.ctrlKey && !event.altKey) {
value += '\n';
}
}
if (value == self.oldValue) {
return;
}
self.oldValue = value;
if (self.options.helperTA) {
self.helper.value = value;
newHeight = self.helper.scrollHeight + self.fontSize + 4;
} else {
self.helper.innerHTML = trim(replaceChars(value)).replace(/<br>$/, '<br>&nbsp;');
newHeight = getSize(self.helper, true)[1] + self.fontSize + 4;
}
newHeight = Math.max(newHeight, self.minHeight);
if (self.maxHeight > 0 && newHeight > self.maxHeight) {
newHeight = self.maxHeight;
if (!self.overflowAuto) {
if (browser.mozilla) var cr = self.input.selectionStart;
self.overflowAuto = true;
setStyle(self.input, {
'overflow': 'auto',
'overflowX': 'hidden'
});
if (browser.mozilla) self.input.setSelectionRange(cr, cr);
self.oldHeight = newHeight;
}
} else {
if (self.overflowAuto) {
self.overflowAuto = false;
if (browser.mozilla) var cr = self.input.selectionStart;
self.input.style.overflow = 'hidden';
if (browser.mozilla) self.input.setSelectionRange(cr, cr);
}
}
if (self.options.preventEnter && event.keyCode == 13 && !event.shiftKey) {
return;
}
if (self.oldHeight != newHeight) {
self.input.style.height = (self.oldHeight = newHeight) + 'px';
if (self.options.onResize) self.options.onResize(newHeight);
}
},
// Shortcuts
update: function() {
this.updateSize({data: {self: this}});
}
});
//
// Dropdown Menu class
//
createChildClass('DropdownMenu', UiControl, {
// Static class fields
common: {
pageContainer: null
},
defaultOptions: {
title: 'Menu',
hideOnClick: true,
showHover: true,
updateTarget: true,
alwaysMenuToUp: false,
columnsCount: false,
offsetLeft: -7,
offsetTop: -4,
onSelect: function(){},
updateHeader: function(i,t){return t;}
},
controlName: 'DropdownMenu',
// Standart object methods
beforeInit: function() {
this.guid = _ui.reg(this);
if (!this.common.pageContainer) {
this.common.pageContainer = document.body;
if (browser.msie6 && ge('pageContainer')) {
this.pageContainer = ge('pageContainer');
}
}
},
initOptions: function(items, options) {
if (!options.title && options.target) options.title = options.target.innerHTML;
this.options = extend({}, this.defaultOptions, options);
},
init: function(input, options) {
this.visible = false;
this.offsetTop = 0;
this.mouseTimer = 0;
this.childMenus = [];
this.childIsOver = false;
if (options.parentMenu) {
this.parentMenu = options.parentMenu;
this.parentMenu.childMenus.push(this);
}
this.isOver = false;
this.value = options.value || 0;
this.items = {};
},
initDOM: function(input, options) {
this.container = ce('div', {
className: 'dd_menu' + (options.containerClass ? ' '+options.containerClass : ''),
id: 'dd_menu' + this.guid
});
this.header = ce('div', {
className: 'dd_menu_header',
innerHTML: '<div>' + this.options.title.replace(/\s+/g, '&nbsp;') + '</div>'
});
this.body = ce('div', {
className: 'dd_menu_body',
innerHTML: '<table cellspacing="0" cellpadding="0"><tbody><tr><td class="dd_menu_shad_l"><div></div></td><td><div class="dd_menu_shad_t2"></div><div class="dd_menu_shad_t"></div><div id="dd_rows_'+this.guid+'" class="dd_menu_rows"></div><div class="dd_menu_shad_b"></div><div class="dd_menu_shad_b2"></div></td><td class="dd_menu_shad_r"><div> </div></td></tr></tbody></table>'
});
this.container.appendChild(this.header);
this.container.appendChild(this.body);
hide(this.header);
hide(this.body);
// Container for menu items
this.rows = ce('div', {'id': 'rows' + this.guid, 'className' : 'dd_menu_rows2'});
},
initEvents: function() {
addEvent(this.container, 'mouseover mouseout', this.handleMouseEvent, false, {'self': this});
},
afterInit: function(items, options) {
this.setData(items);
var self = this;
onDomReady(function() {
(self.common.pageContainer || window.pageNode).appendChild(self.container);
var header = self.header, body = self.body, target = self.options.target;
ge('dd_rows_'+ self.guid).appendChild(self.rows);
self.setOptions(self.options);
if (target) {
if (target.innerHTML.indexOf('<') == -1) {
target.innerHTML = target.innerHTML.replace(/\s+/g, '&nbsp;');
}
target.onclick = function() {self.show();return false;};
if (target.tagName == 'A') {
target.className += ' dd_menu_target';
}
}
if (self.options.target && self.options.showHover) {
var timer;
var outFunc = function() {
if (self.parentMenu) { self.parentMenu.childIsOver = false; }
if (!self.visible) hide(header);
removeClass(header, 'dd_header_hover');
}
self.showTargetHover = function() {
if (self.parentMenu) { self.parentMenu.childIsOver = true; }
addClass(header, 'dd_header_hover');
self.moveToTarget();
show(header);
timer = setTimeout(outFunc, 100);
};
addEvent(self.options.target, 'mouseover', self.showTargetHover);
addEvent(header, 'mouseover', function() {
if (self.parentMenu) { self.parentMenu.childIsOver = true; }
clearTimeout(timer);
});
addEvent(header, 'mouseout', outFunc);
}
});
},
moveTo: function(left, top) {
left = intval(left);
top = intval(top);
extend(this.container.style, {top: top + 'px', left: left + 'px'});
setStyle(this.rows, 'width', 'auto');
if (this.options.columnsCount && !browser.msie) {
setStyle(this.rows, 'columnCount', 'auto');
setStyle(this.rows, 'MozColumnCount', 'auto');
setStyle(this.rows, 'webkitColumnCount', 'auto');
setStyle(this.rows, 'height', 'auto');
var itemsCount = geByTag('a', this.rows).length;
var bodySize = getSize(this.body);
var rowsWidth = bodySize[0] - 4;
var rowsHeight = bodySize[1] - 4;
if (rowsHeight > 500) {
rowsHeight = Math.round(rowsHeight / itemsCount) * Math.ceil(itemsCount / this.options.columnsCount);
setStyle(this.rows, 'columnCount', this.options.columnsCount.toString());
setStyle(this.rows, 'MozColumnCount', this.options.columnsCount.toString());
setStyle(this.rows, 'webkitColumnCount', this.options.columnsCount.toString());
setStyle(this.rows, 'width', (rowsWidth * 2) + 'px');
setStyle(this.rows, 'height', rowsHeight + 'px');
}
}
var headerWidth = getSize(this.header)[0];
var bodyWidth = getSize(this.body)[0];
if (headerWidth > bodyWidth){
setStyle(this.rows, 'width', (headerWidth - 2) + 'px');
}
bodyWidth = getSize(this.body)[0];
var windowWidth = document.documentElement.clientWidth;
var bodyRight = ((left > bodyWidth && left + bodyWidth > windowWidth) ? (-headerWidth - 1) + 'px' : 'auto');
setStyle(this.body, 'right', bodyRight);
},
moveToTarget: function() {
var tc = getXY(this.options.target);
if (/mac/.test(_ua) && browser.mozilla) {
tc[1] += 1; // offset fix
}
this.moveTo(tc[0] + this.options.offsetLeft, tc[1] + this.options.offsetTop);
},
alignBody: function() {
this.body.style.marginLeft = (getSize(this.header)[0] - getSize(this.body)[0] + 1) + 'px';
},
setData: function(items) {
this.rows.innerHTML = '';
if (isArray(items) && items.length) {
for (var i=0; i<items.length; i++) {
this.addItem(items[i]);
}
}
if (this.visible && this.menuToUp()){
var bh = getSize(this.body)[1];
this.body.style.top = -bh+3+'px';
addClass(this.container, 'dd_up');
}
},
addItem: function(item) {
if (!item) return false;
var link = ce('a');
if(isArray(item))item = {i: item[0], l: item[1], onClick: item[2], c: item[3], s: item[4], b: item[5], h: item[6], el: link};
if(item.onClick && !isFunction(item.onClick)){
var funcs = item.onClick;
item.onClick = funcs.onClick;
item.onMouseOver = funcs.onMouseOver;
item.onMouseOut = funcs.onMouseOut;
}
link.innerHTML = (this.options.checkable ? '<img src="/images/dropdead_check.gif">' : '') + item.l;
if (item.i) link['index'] = item.i;
if (item.c) link.className = item.c;
if (item.s) extend(link.style, item.s);
if (item.b) extend(link.style, {backgroundImage: 'url(\'' + item.b + '\')', paddingLeft: '27px' });
if (item.h) link.href = item.h;
var self = this;
addEvent(link, 'click', function(e) {
self.value = e.data.item.i;
var hide = true;
if (isFunction(item.onClick) && item.onClick(e) === false)
hide = false;
if (self.options.onSelect(e) === false)
hide = false;
if (item.h) {
return true; //toUrl(item.h, e);
}
if (hide) self.hide();
else cancelEvent(e);
if(self.options.updateTarget && hide) {
var text = self.options.updateHeader(e.target.index, e.target.innerHTML);
self.header.innerHTML = '<div>'+text+'</div>';
if (self.options.target) {
self.options.target.innerHTML = text.replace(/\s+/g, '&nbsp;');
}
}
}, false, {item: item});
if (isFunction(item.onMouseOver)) {addEvent(link, 'mouseover', item.onMouseOver);}
if (isFunction(item.onMouseOut)) {addEvent(link, 'mouseout', item.onMouseOut);}
if (browser.msie) {
link.onmouseover = function(){addClass(link, 'dd_a_hover');};
link.onmouseout = function(){removeClass(link, 'dd_a_hover');};
}
this.items[item.i] = link;
this.rows.appendChild(link);
if (this.options.align == 'left') this.alignBody();
},
getRows: function() {
return this.rows;
},
setOptions: function(options) {
var self = this;
extend(this.options, options);
// apply options
if (this.options.title)
this.header.innerHTML = '<div>'+this.options.title+'</div>';
if (typeof this.options.hideOnClick != 'undefined')
this.header.onclick = this.options.hideOnClick ? this.toggle.bind(this) : this.show.bind(this);
if (this.options.align == 'left') this.alignBody();
},
onHide: function(fade) {
this.visible = false;
if (fade || !this.options.showHover) hide(this.header);
else addClass(this.header, 'dd_header_hover');
hide(this.body);
if (this.options.onHide) this.options.onHide();
},
toggle: function() {
this.visible ? this.hide(false) : this.show();
},
show: function() {
if (this.visible) return;
if (this.options.target && !this.options.showHover) this.moveToTarget();
clearTimeout(this.mouseTimer);
show(this.header);
show(this.body);
if (this.options.showHover) removeClass(this.header, 'dd_header_hover');
this.visible = true;
// Set menu coordinates
if (this.menuToUp()) {
var bh = getSize(this.body)[1];
this.body.style.top = -bh+3+'px';
addClass(this.container, 'dd_up');
} else {
var hh = getSize(this.header)[1];
this.body.style.top = hh-1+'px';
removeClass(this.container, 'dd_up');
}
if (this.options.onShow) {
this.options.onShow();
}
_ui.sel(this.guid);
},
menuToUp: function() {
if (this.options.alwaysMenuToUp) {
return true;
}
var h = window.innerHeight,
bh = getSize(this.body)[1],
hh = getSize(this.header)[1],
ht = getXY(this.header)[1];
if (!h && document.documentElement) {
h = document.documentElement.clientHeight;
}
var pt = this.common.pageContainer.scrollTop;
if (!pt && !browser.msie6) pt = document.getElementsByTagName('html')[0].scrollTop;
if (ht - pt > bh) {
return (hh + ht + bh > h + pt);
}
return false;
},
hide: function(fade) {
if (!this.visible) return;
// return;
var self = this;
if (self.childIsOver) {
self.mouseTimer = setTimeout(self.hide.bind(self), 400);
return;
}
each(self.childMenus, function () {
this.hide();
});
var fadeSpeed = (this.options.fadeSpeed !== undefined) ? this.options.fadeSpeed : 100;
(fade === false) ? this.onHide(false) : fadeOut(this.container, fadeSpeed, function(){
show(self.container);
self.onHide.call(self, true);
_ui.sel(false);
//if (self.options.onHide) self.options.onHide();
});
if (self.parentMenu) {
self.parentMenu.childIsOver = false;
}
},
val: function () {
return this.value;
},
destroy: function() {
if (!vk.al || this.destroyed) return;
removeEvent(this.options.target, 'mouseover', this.showTargetHover);
cleanElems(this.container, this.header);
for (var el = this.rows.firstChild; el; el = el.nextSibling) {
cleanElems(el);
}
this.destroyed = true;
},
handleMouseEvent: function(e) {
var self = e.data.self;
self.isOver = (e.type == 'mouseover');
if (self.parentMenu) { self.parentMenu.childIsOver = self.isOver; }
clearTimeout(self.mouseTimer);
if (e.type == 'mouseout') {
self.mouseTimer = setTimeout(self.hide.bind(self), 400);
}
},
onEvent: function (e) {
if (inArray(e.type, ['keydown', 'keypress', 'keyup']) && inArray(e.keyCode, [16, 17, 18, 91])) {
return;
}
var outside = true, t = e.target;
while (t && t != t.parentNode) {
if (t == this.container) {
outside = false;
break;
}
t = t.parentNode;
}
if (outside) {
this.hide();
}
}
});
//
// UiControl abstract class
//
function UiUtil(args) {
return this.__construct__(args);
}
extend(UiUtil.prototype, {
// Constants
defaultOptions: null,
// List of all storages, to delete on page reload
__components: {},
__cid: 0,
// Main storage for current component
storage: null,
// Consructor
__construct__: function(args) {
if (this.beforeInit) this.beforeInit.apply(this, args);
if (this.initOptions) this.initOptions.apply(this, args);
this.init.apply(this, args);
if (this.initEvents) this.initEvents.apply(this, args);
if (this.afterInit) this.afterInit.apply(this, args);
this.__components[(this.componentName ? this.componentName : this.__className) + (this.__cid++)] = this;
return this;
},
// Standart abstract methods
// Component initialisation
// User defined callback
beforeInit: null,
// Init options field
initOptions: null,
// init and initEvents are required
init: null,
// Attach events listeners to elements
initEvents: null,
// User defined callback
afterInit: null
});
//
// Cache Menu class
//
createChildClass('Cache', UiUtil, {
defaultOptions: {
cacheLength: 100
},
componentName: 'Cache',
initOptions: function(options) {
this.options = extend({}, this.defaultOptions, options);
},
init: function() {
this.storage = {};
this.length = 0;
},
setData: function(key, value) {
if (this.length > this.options.cacheLength) {
this.flush();
}
if (!(key in this.storage)){
this.length++;
}
this.storage[key] = clone(value);
},
getData: function(key) {
if (!this.options.cacheLength || !this.length || !(key in this.storage)) {
return null;
}
return this.storage[key];
},
flush: function() {
delete this.storage;
this.storage = {};
this.length = 0;
}
});
//
// Indexer class
//
createChildClass('Indexer', UiUtil, {
defaultOptions: {
chars: 2,
delimeter: /[\s\(\)\.,\-]+/
},
componentName: 'Indexer',
initOptions: function(data, options) {
this.options = extend({}, this.defaultOptions, {indexkeys: [1]}, options);
},
init: function(data) {
this.setData(data);
},
setData: function(data) {
delete this.storage;
this.storage = {
data: clone(data),
index: {}
};
clearTimeout(this.indexTimer);
this.indexTimer = setTimeout(this.createIndex.bind(this), 10);
},
createIndex: function() {
if (!this.storage.data.length) return;
this.storage.index = {};
debug('createIndex start, ' + this.storage.data.length + ' items');
each(this.storage.data, this.indexItem.bind(this));
debug('createIndex ended');
},
indexItem: function(k, v) {
var i, j, current_words = '', index_key, already_indexed = {};
for (i = 0; i < this.options.indexkeys.length; i++) {
if (!v[this.options.indexkeys[i]]) continue;
current_words += ' ' + v[this.options.indexkeys[i]].replace(this.options.delimeter, ' ').replace(/<[^>]*>/, '');
}
current_words = trim(winToUtf(current_words).toLowerCase()).split(/\s+/);
for (i = 0; i < current_words.length; i++) {
for (j = 1; j <= this.options.chars; j++) {
index_key = current_words[i].substr(0, j);
if (already_indexed[index_key]) {
continue;
}
already_indexed[index_key] = 1;
if (this.storage.index[index_key] === undefined) this.storage.index[index_key] = [];
this.storage.index[index_key].push(k);
}
}
},
search: function(pattern) {
debug('search start, index width: ' + this.options.chars + ', data size: ' + this.storage.data.length);
pattern = trim(pattern.toLowerCase().replace(this.options.delimeter, ' '));
debug('pattern: '+pattern+', length: ' + pattern.length);
var self = this;
if (!pattern) {
debug('empty pattern, return whole list');
return self.storage.data;
}
if (pattern.length <= this.options.chars && pattern.indexOf(' ') == -1) {
debug('found whole pattern indexed');
var retArr = [];
each ((this.storage.index[pattern] || []), function() {
retArr.push(self.storage.data[this]);
});
return retArr;
}
pattern = pattern.split(' ');
var min_size = 0, min_pattern = '', self = this;
each (pattern, function() {
var items = self.storage.index[this.substr(0, self.options.chars)];
if (!min_pattern || !items || items.length < min_size) {
min_size = items ? items.length : 0;
min_pattern = this.substr(0, self.options.chars);
}
return !min_size;
});
var ret_arr = [];
debug('index returned: ' + min_size + ' items');
if (!min_size) return ret_arr;
debug('starting manual filter');
each (self.storage.index[min_pattern.substr(0, self.options.chars)], function(k, v) {
var item = self.storage.data[v];
var i, fail = false, current_words = '', index_key;
for (i = 0; i < self.options.indexkeys.length; i++) {
current_words += ' ' + item[self.options.indexkeys[i]].replace(self.options.delimeter, ' ').replace('<b>', '').replace('</b>', '');
}
current_words = winToUtf(current_words).toLowerCase();
for (i = 0; i < pattern.length; i++) {
if (current_words.indexOf(' ' + pattern[i]) == -1) {
fail = true;
break;
}
}
if (fail) return;
ret_arr.push(item);
});
debug('manual filter ended, found ' + ret_arr.length + ' items');
return ret_arr;
},
flush: function() {
delete this.storage;
}
});
var curInlineEdit = false;
if (!window.inlineOnEvent) {
window.inlineOnEvent = function(e) {
if (!curInlineEdit) return;
if (e.type == 'mousedown') {
var outside = true, t = e.target;
while (t && t != t.parentNode) {
if (t == curInlineEdit.container) {
outside = false;
break;
}
t = t.parentNode;
}
if (!outside || !isVisible(curInlineEdit.container)) return;
curInlineEdit.hide();
}
if (e.type == 'keydown') {
if (!isVisible(curInlineEdit.container)) return;
if (e.keyCode == KEY.ESC) curInlineEdit.hide();
if (e.keyCode == KEY.RETURN) {
if (!curInlineEdit.options.onConfirm || curInlineEdit.options.onConfirm.apply(curInlineEdit) !== false) curInlineEdit.hide();
}
}
}
addEvent(document, 'mousedown keydown', inlineOnEvent);
}
//
// InlineEdit class
//
createChildClass('InlineEdit', UiControl, {
// Static class fields
common: {
pageContainer: null
},
defaultOptions: {
offsetLeft: -20 + (browser.msie7 ? 2 : (browser.opera || browser.msie ? 3 : (browser.safari || browser.chrome ? 0 : (browser.mozilla ? 2 : 0)))),
offsetTop: -20 + (browser.msie7 ? 2 : (browser.opera || browser.msie ? 3 : (browser.safari || browser.chrome ? 1 : (browser.mozilla ? 3 : 0)))),
top: 0,
left: 0,
width: 'auto',
flex: false,
mainTableHTML:
'<tbody><tr><td class="inlFrame00"></td><td class="inlFrame01"><div></div></td><td class="inlFrame02"></td></tr>\
<tr><td class="inlFrame10"></td><td class="inlContent">{content_table}</td><td class="inlFrame12"></td></tr>\
<tr><td class="inlFrame20"></td><td class="inlFrame21"><div></div></td><td class="inlFrame22"></td></tr></tbody>',
contentTableHTML:
'<tbody>{content}\
<tr>\
<td class="inlButtonOk"><div class="button_yes"><div>{yeslabel}</div></div></td>\
<td class="inlButtonCancel"><div class="button_no"><div>{nolabel}</div></div></td>\
</tr></tbody>',
contentHTML: '<tr><td><input class="inlInput text" type="text" /></td></tr>',
confirmLabel: getLang('global_save'),
cancelLabel: getLang('global_cancel'),
onBeforeShow: null,
onShow: null,
onHide: null,
onConfirm: null,
onCancel: null
},
controlName: 'InlineEdit',
// Standart object methods
beforeInit: function() {
if (!this.common.pageContainer) {
this.common.pageContainer = document.body;
if (browser.msie6 && ge('pageContainer')) {
this.pageContainer = ge('pageContainer');
}
}
this.guid = _ui.reg(this);
},
initOptions: function(target, options) {
if (!target) return false;
this.options = extend({}, this.defaultOptions, options);
},
init: function(target) {
this.target = target;
},
initDOM: function(target, options) {
this.container = ce('div', {
className: 'inlContainer',
id: 'container' + this.guid,
innerHTML: '<table class="inlMainTable">' + this.options.mainTableHTML.replace('{content_table}', '<table class="inlContentTable">' + this.options.contentTableHTML.replace('{content}', this.options.contentHTML).replace('{nolabel}', this.options.cancelLabel).replace('{yeslabel}', this.options.confirmLabel) + '</table>') + '</table>'
});
this.mainTable = geByClass('inlMainTable', this.container)[0];
this.mainCell = geByClass('inlContent', this.mainTable)[0];
this.contentTable = geByClass('inlContentTable', this.mainCell)[0];
setStyle(this.contentTable, 'width', this.options.width);
this.input = geByClass('inlInput', this.contentTable)[0];
this.buttonOkCell = geByClass('inlButtonOk', this.contentTable)[0];
this.buttonCancelCell = geByClass('inlButtonCancel', this.contentTable)[0];
this.buttonOk = this.buttonOkCell.firstChild.firstChild;
this.buttonCancel = this.buttonCancelCell.firstChild.firstChild;
this.container.appendChild(this.mainTable);
this.mainCell.appendChild(this.contentTable);
},
initEvents: function() {
var self = this;
createButton(this.buttonOk, function() {
if (!self.options.onConfirm || self.options.onConfirm.apply(self) !== false) self.hide();
});
createButton(this.buttonCancel, function() {
if (!self.options.onCancel || self.options.onCancel.apply(self) !== false) self.hide();
});
addEvent(this.target, 'click', function() {self.show(); return false;});
this.onEvent = function(e) {
}
},
afterInit: function(target, options) {
if (this.options.afterInit) {
this.options.afterInit.apply(this);
}
var self = this;
onDomReady(function() {
self.common.pageContainer.appendChild(self.container);
});
},
hide: function() {
if (!isVisible(this.container)) return;
hide(this.container);
if (curInlineEdit == this) curInlineEdit = false;
if (this.options.onHide) this.options.onHide.apply(this);
},
moveTo: function(left, top) {
setStyle(this.container, {top: intval(top)+'px', left: intval(left) + 'px'});
},
moveToTarget: function() {
var tc = getXY(this.target);
this.moveTo(tc[0] + this.options.offsetLeft + this.options.left, tc[1] + this.options.offsetTop + this.options.top);
},
setOptions: function(options) {
var self = this;
extend(this.options, options);
},
toggle: function() {
this.visible ? this.hide(false) : this.show();
},
show: function() {
if (isVisible(this.container)) return;
this.moveToTarget();
if (this.options.onBeforeShow) {
this.options.onBeforeShow.apply(this);
}
show(this.container);
if (curInlineEdit) curInlineEdit.hide();
curInlineEdit = this;
if (this.input) elfocus(this.input);
if (this.options.onShow) {
this.options.onShow.apply(this);
}
}
});
try{jsDispatcher.triggerOnload('lib/ui_controls');}catch(e){}
try{stManager.done('ui_controls.js');}catch(e){}
</script>
<script src="http://st1.vk.me/js/api/openapi.js?1" type="text/javascript">
(function(w) {
if (w.fastXDM) return;
var handlers = {};
var onEnvLoad = [];
var env = {};
// Key generation
function genKey() {
var key = '';
for (i=0;i<5;i++) key += Math.ceil(Math.random()*15).toString(16);
return key;
}
function waitFor(obj, prop, func, self, count) {
if (obj[prop]) {
func.apply(self);
} else {
count = count || 0;
if (count < 1000) setTimeout(function() {
waitFor(obj, prop, func, self, count + 1)
}, 0);
}
}
function attachScript(url) {
setTimeout(function() {
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
newScript.src = url || w.fastXDM.helperUrl;
waitFor(document, 'body', function() {
document.getElementsByTagName('HEAD')[0].appendChild(newScript);
});
}, 0);
}
function walkVar(value, clean) {
switch (typeof value) {
case 'string':
if (clean) {
return value.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}
return value.replace(/&#039;/g, '\'').replace(/&quot;/g, '"').replace(/&gt;/g, '>').replace(/&lt;/g, '<').replace(/&amp;/g, '&');
case 'object':
if (Object.prototype.toString.apply(value) === '[object Array]') {
for (var i = 0; i < value.length; i++) {
value[i] = walkVar(value[i], clean);
}
} else {
for (var k in value) {
if (Object.hasOwnProperty.call(value, k)) {
value[k] = walkVar(value[k], clean);
}
}
}
}
return value;
}
// Env functions
function getEnv(callback, self) {
if (env.loaded) {
callback.apply(self, [env]);
} else {
onEnvLoad.push([self, callback]);
}
}
function envLoaded() {
env.loaded = true;
var i = onEnvLoad.length;
while (i--) {
onEnvLoad[i][1].apply(onEnvLoad[i][0], [env]);
}
}
function applyMethod(strData, self) {
getEnv(function(env) {
var data = env.json.parse(strData);
if (data[0]) {
if (!data[1]) data[1] = [];
var i = data[1].length;
while (i--) {
if (data[1][i]._func) {
var funcNum = data[1][i]._func;
data[1][i] = function() {
var args = Array.prototype.slice.call(arguments);
args.unshift('_func'+funcNum);
self.callMethod.apply(self, args);
}
} else if (self.options.safe) {
data[1][i] = walkVar(data[1][i], true);
}
}
setTimeout(function() {
if (!self.methods[data[0]]) throw Error('fastXDM: Method ' + data[0] + ' is undefined');
self.methods[data[0]].apply(self, data[1]);
}, 0);
}
});
}
// XDM object
w.fastXDM = {
_id: 0,
helperUrl: ((location.protocol === 'https:') ? 'https:' : 'http:') + '//vk.com/js/api/xdmHelper.js',
Server: function(methods, filter, options) {
this.methods = methods || {};
this.id = w.fastXDM._id++;
this.options = options || {};
this.filter = filter;
this.key = genKey();
this.methods['%init%'] = this.methods.__fxdm_i = function() {
w.fastXDM.run(this.id);
if (this.methods.onInit) this.methods.onInit();
};
this.frameName = 'fXD'+this.key;
this.server = true;
handlers[this.key] = [applyMethod, this];
},
Client: function(methods, options) {
this.methods = methods || {};
this.id = w.fastXDM._id++;
this.options = options || {};
w.fastXDM.run(this.id);
if (window.name.indexOf('fXD') === 0) {
this.key = window.name.substr(3);
} else {
throw Error('Wrong window.name property.');
}
this.caller = window.parent;
handlers[this.key] = [applyMethod, this];
this.client = true;
w.fastXDM.on('helper', function() {
w.fastXDM.onClientStart(this);
}, this);
getEnv(function(env) {
env.send(this, env.json.stringify(['%init%']));
var methods = this.methods;
setTimeout(function() {
if (methods.onInit) methods.onInit();
}, 0);
}, this);
},
onMessage: function(e) {
if (!e.data) return false;
var key = e.data.substr(0, 5);
if (handlers[key]) {
var self = handlers[key][1];
if (self && (!self.filter || self.filter(e.origin))) {
handlers[key][0](e.data.substr(6), self);
}
}
},
setJSON: function(json) {
env.json = json;
},
getJSON: function(callback) {
if (!callback) return env.json;
getEnv(function(env) {
callback(env.json);
});
},
setEnv: function(exEnv) {
var i;
for (i in exEnv) {
env[i] = exEnv[i];
}
envLoaded();
},
_q: {},
on: function(key, act, self) {
if (!this._q[key]) this._q[key] = [];
if (this._q[key] == -1) {
act.apply(self);
} else {
this._q[key].push([act, self]);
}
},
run: function(key) {
var len = (this._q[key] || []).length;
if (this._q[key] && len > 0) {
for (var i = 0; i < len; i++) this._q[key][i][0].apply(this._q[key][i][1]);
}
this._q[key] = -1;
},
waitFor: waitFor
}
w.fastXDM.Server.prototype.start = function(obj, count) {
if (obj.contentWindow) {
this.caller = obj.contentWindow;
this.frame = obj;
w.fastXDM.on('helper', function() {
w.fastXDM.onServerStart(this);
}, this);
} else { // Opera old versions
var self = this;
count = count || 0;
if (count < 50) setTimeout(function() {
self.start.apply(self, [obj, count+1]);
}, 100);
}
}
function extend(obj1, obj2){
for (var i in obj2) {
if (obj1[i] && typeof(obj1[i]) == 'object') {
extend(obj1[i], obj2[i])
} else {
obj1[i] = obj2[i];
}
}
}
w.fastXDM.Server.prototype.append = function(obj, options) {
var div = document.createElement('DIV');
div.innerHTML = '<iframe name="'+this.frameName+'" ></iframe>';
var frame = div.firstChild;
var self = this;
setTimeout(function() {
frame.frameBorder = '0';
if (options) extend(frame, options);
obj.insertBefore(frame, obj.firstChild);
self.start(frame);
}, 0);
return frame;
}
w.fastXDM.Client.prototype.callMethod = w.fastXDM.Server.prototype.callMethod = function() {
var args = Array.prototype.slice.call(arguments);
var method = args.shift();
var i = args.length;
while (i--) {
if (typeof(args[i]) == 'function') {
this.funcsCount = (this.funcsCount || 0) + 1;
var func = args[i];
var funcName = '_func' + this.funcsCount;
this.methods[funcName] = function() {
func.apply(this, arguments);
delete this.methods[funcName];
}
args[i] = {_func: this.funcsCount};
}
else if (this.options.safe) {
args[i] = walkVar(args[i], false);
}
}
waitFor(this, 'caller', function() {
w.fastXDM.on(this.id, function() {
getEnv(function(env) {
env.send(this, env.json.stringify([method, args]));
}, this);
}, this);
}, this);
}
if (w.JSON && typeof(w.JSON) == 'object' && w.JSON.parse && w.JSON.stringify && w.JSON.stringify({a:[1,2,3]}).replace(/ /g, '') == '{"a":[1,2,3]}') {
env.json = {parse: w.JSON.parse, stringify: w.JSON.stringify};
} else {
w.fastXDM._needJSON = true;
}
// PostMessage cover
if (w.postMessage) {
env.protocol = 'p';
env.send = function(xdm, strData) {
// alert(key+':'+strData);
xdm.caller.postMessage(xdm.key+':'+strData, "*");
}
if (w.addEventListener) {
w.addEventListener("message", w.fastXDM.onMessage, false);
} else {
w.attachEvent("onmessage", w.fastXDM.onMessage);
}
if (w.fastXDM._needJSON) {
w.fastXDM._onlyJSON = true;
attachScript();
} else {
envLoaded();
}
} else {
attachScript();
}
})(window);
if (!window.VK) window.VK = {};
/*
* Based on JavaScript implementation of the RSA Data Security, Inc. MD5 Message
* Copyright (C) Paul Johnston 1999 - 2009
* Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
* Distributed under the BSD License
*/
if(!VK.MD5){VK.MD5=function(n){var j=function(o,r){var q=(o&65535)+(r&65535),p=(o>>16)+(r>>16)+(q>>16);return(p<<16)|(q&65535)},g=function(o,p){return(o<<p)|(o>>>(32-p))},k=function(w,r,p,o,v,u){return j(g(j(j(r,w),j(o,u)),v),p)},a=function(q,p,w,v,o,u,r){return k((p&w)|((~p)&v),q,p,o,u,r)},h=function(q,p,w,v,o,u,r){return k((p&v)|(w&(~v)),q,p,o,u,r)},c=function(q,p,w,v,o,u,r){return k(p^w^v,q,p,o,u,r)},m=function(q,p,w,v,o,u,r){return k(w^(p|(~v)),q,p,o,u,r)},b=function(A,u){var z=1732584193,y=-271733879,w=-1732584194,v=271733878,r,q,p,o;A[u>>5]|=128<<((u)%32);A[(((u+64)>>>9)<<4)+14]=u;for(var t=0,s=A.length;t<s;t+=16){r=z;q=y;p=w;o=v;z=a(z,y,w,v,A[t+0],7,-680876936);v=a(v,z,y,w,A[t+1],12,-389564586);w=a(w,v,z,y,A[t+2],17,606105819);y=a(y,w,v,z,A[t+3],22,-1044525330);z=a(z,y,w,v,A[t+4],7,-176418897);v=a(v,z,y,w,A[t+5],12,1200080426);w=a(w,v,z,y,A[t+6],17,-1473231341);y=a(y,w,v,z,A[t+7],22,-45705983);z=a(z,y,w,v,A[t+8],7,1770035416);v=a(v,z,y,w,A[t+9],12,-1958414417);w=a(w,v,z,y,A[t+10],17,-42063);y=a(y,w,v,z,A[t+11],22,-1990404162);z=a(z,y,w,v,A[t+12],7,1804603682);v=a(v,z,y,w,A[t+13],12,-40341101);w=a(w,v,z,y,A[t+14],17,-1502002290);y=a(y,w,v,z,A[t+15],22,1236535329);z=h(z,y,w,v,A[t+1],5,-165796510);v=h(v,z,y,w,A[t+6],9,-1069501632);w=h(w,v,z,y,A[t+11],14,643717713);y=h(y,w,v,z,A[t+0],20,-373897302);z=h(z,y,w,v,A[t+5],5,-701558691);v=h(v,z,y,w,A[t+10],9,38016083);w=h(w,v,z,y,A[t+15],14,-660478335);y=h(y,w,v,z,A[t+4],20,-405537848);z=h(z,y,w,v,A[t+9],5,568446438);v=h(v,z,y,w,A[t+14],9,-1019803690);w=h(w,v,z,y,A[t+3],14,-187363961);y=h(y,w,v,z,A[t+8],20,1163531501);z=h(z,y,w,v,A[t+13],5,-1444681467);v=h(v,z,y,w,A[t+2],9,-51403784);w=h(w,v,z,y,A[t+7],14,1735328473);y=h(y,w,v,z,A[t+12],20,-1926607734);z=c(z,y,w,v,A[t+5],4,-378558);v=c(v,z,y,w,A[t+8],11,-2022574463);w=c(w,v,z,y,A[t+11],16,1839030562);y=c(y,w,v,z,A[t+14],23,-35309556);z=c(z,y,w,v,A[t+1],4,-1530992060);v=c(v,z,y,w,A[t+4],11,1272893353);w=c(w,v,z,y,A[t+7],16,-155497632);y=c(y,w,v,z,A[t+10],23,-1094730640);z=c(z,y,w,v,A[t+13],4,681279174);v=c(v,z,y,w,A[t+0],11,-358537222);w=c(w,v,z,y,A[t+3],16,-722521979);y=c(y,w,v,z,A[t+6],23,76029189);z=c(z,y,w,v,A[t+9],4,-640364487);v=c(v,z,y,w,A[t+12],11,-421815835);w=c(w,v,z,y,A[t+15],16,530742520);y=c(y,w,v,z,A[t+2],23,-995338651);z=m(z,y,w,v,A[t+0],6,-198630844);v=m(v,z,y,w,A[t+7],10,1126891415);w=m(w,v,z,y,A[t+14],15,-1416354905);y=m(y,w,v,z,A[t+5],21,-57434055);z=m(z,y,w,v,A[t+12],6,1700485571);v=m(v,z,y,w,A[t+3],10,-1894986606);w=m(w,v,z,y,A[t+10],15,-1051523);y=m(y,w,v,z,A[t+1],21,-2054922799);z=m(z,y,w,v,A[t+8],6,1873313359);v=m(v,z,y,w,A[t+15],10,-30611744);w=m(w,v,z,y,A[t+6],15,-1560198380);y=m(y,w,v,z,A[t+13],21,1309151649);z=m(z,y,w,v,A[t+4],6,-145523070);v=m(v,z,y,w,A[t+11],10,-1120210379);w=m(w,v,z,y,A[t+2],15,718787259);y=m(y,w,v,z,A[t+9],21,-343485551);z=j(z,r);y=j(y,q);w=j(w,p);v=j(v,o)}return[z,y,w,v]},f=function(r){var q="",s=-1,p=r.length,o,t;while(++s<p){o=r.charCodeAt(s);t=s+1<p?r.charCodeAt(s+1):0;if(55296<=o&&o<=56319&&56320<=t&&t<=57343){o=65536+((o&1023)<<10)+(t&1023);s++}if(o<=127){q+=String.fromCharCode(o)}else{if(o<=2047){q+=String.fromCharCode(192|((o>>>6)&31),128|(o&63))}else{if(o<=65535){q+=String.fromCharCode(224|((o>>>12)&15),128|((o>>>6)&63),128|(o&63))}else{if(o<=2097151){q+=String.fromCharCode(240|((o>>>18)&7),128|((o>>>12)&63),128|((o>>>6)&63),128|(o&63))}}}}}return q},e=function(p){var o=Array(p.length>>2),r,q;for(r=0,q=o.length;r<q;r++){o[r]=0}for(r=0,q=p.length*8;r<q;r+=8){o[r>>5]|=(p.charCodeAt(r/8)&255)<<(r%32)}return o},l=function(p){var o="";for(var r=0,q=p.length*32;r<q;r+=8){o+=String.fromCharCode((p[r>>5]>>>(r%32))&255)}return o},d=function(o){return l(b(e(o),o.length*8))},i=function(q){var t="0123456789abcdef",p="",o;for(var s=0,r=q.length;s<r;s++){o=q.charCodeAt(s);p+=t.charAt((o>>>4)&15)+t.charAt(o&15)}return p};return i(d(f(n)))}}
/*
* VKontakte Open API JavaScript library
* http://vk.com/
*/
VK.extend = function(target, source, overwrite) {
for (var key in source) {
if (overwrite || typeof target[key] === 'undefined') {
target[key] = source[key];
}
}
return target;
};
if (VK._protocol !== 'https:') {
VK._protocol = ((location.protocol === 'https:') ? 'https:' : 'http:');
}
if (!VK.xdConnectionCallbacks) {
VK.extend(VK, {
version: 1,
_apiId: null,
_session: null,
_userStatus: 'unknown',
_domain: {
main: 'https://oauth.vk.com/',
api: 'https://api.vk.com/'
},
_path: {
login: 'authorize',
proxy: 'fxdm_oauth_proxy.html'
},
_rootId: 'vk_api_transport',
_nameTransportPath: '',
xdReady: false,
access: {
FRIENDS: 0x2,
PHOTOS: 0x4,
AUDIO: 0x8,
VIDEO: 0x10,
MATCHES: 0x20,
QUESTIONS: 0x40,
WIKI: 0x80
}
});
VK.init = function(options) {
var body, root;
VK._apiId = null;
if (!options.apiId) {
throw Error('VK.init() called without an apiId');
}
VK._apiId = options.apiId;
if (options.onlyWidgets) return true;
if (options.nameTransportPath && options.nameTransportPath !== '') {
VK._nameTransportPath = options.nameTransportPath;
}
root = document.getElementById(VK._rootId);
if (!root) {
root = document.createElement('div');
root.id = VK._rootId;
body = document.getElementsByTagName('body')[0];
body.insertBefore(root, body.childNodes[0]);
}
root.style.position = 'absolute';
root.style.top = '-10000px';
var session = VK.Cookie.load();
if (session) {
VK.Auth._loadState = 'loaded';
VK.Auth.setSession(session, session ? 'connected' : 'unknown');
}
};
if (!VK.Cookie) {
VK.Cookie = {
_domain: null,
load: function() {
var
cookie = document.cookie.match('\\bvk_app_' + VK._apiId + '=([^;]*)\\b'),
session;
if (cookie) {
session = this.decode(cookie[1]);
if (session.secret != 'oauth') {
return false;
}
session.expire = parseInt(session.expire, 10);
VK.Cookie._domain = '.' + window.location.hostname;//session.base_domain;
}
return session;
},
setRaw: function(val, ts, domain, time) {
var rawCookie;
rawCookie = 'vk_app_' + VK._apiId + '=' + val + '';
var exp = time ? (new Date().getTime() + time * 1000) : ts * 1000;
rawCookie += (val && ts === 0 ? '' : '; expires=' + new Date(exp).toGMTString());
rawCookie += '; path=/';
rawCookie += (domain ? '; domain=.' + domain : '');
document.cookie = rawCookie;
this._domain = domain;
},
set: function(session, resp) {
if (session) {
this.setRaw(this.encode(session), session.expire, window.location.hostname, (resp || {}).time);
} else {
this.clear();
}
},
clear: function() {
this.setRaw('', 0, this._domain, 0);
},
encode: function(params) {
var
pairs = [],
key;
for (key in params) {
if (key != 'user') pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
}
pairs.sort();
return pairs.join('&');
},
decode: function(str) {
var
params = {},
parts = str.split('&'),
i,
pair;
for (i=0; i < parts.length; i++) {
pair = parts[i].split('=', 2);
if (pair && pair[0]) {
params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
}
}
return params;
}
};
}
if (!VK.Api) {
VK.Api = {
_headId: null,
_callbacks: {},
ie6_7: function() {
if (!VK.Api.ieTested) {
VK.Api.isIE6_7 = navigator.userAgent.match(/MSIE [6|7]/i);
VK.Api.ieTested = true;
}
return VK.Api.isIE6_7;
},
attachScript: function(url) {
if (!VK.Api._headId) VK.Api._headId = document.getElementsByTagName("head")[0];
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
newScript.setAttribute('encoding', 'UTF-8');
newScript.src = url;
VK.Api._headId.appendChild(newScript);
},
checkMethod: function(method, params, cb, queryTry) {
var m = method.toLowerCase();
if (m == 'wall.post' || m == 'activity.set') {
var text = (m == 'activity.set') ? params.text : params.message;
var query = VK._protocol + '//vk.com/al_apps.php?act=wall_post_box&widget=1&method='+m+'&aid=' + parseInt(VK._apiId, 10) + '&text=' + encodeURIComponent(text);
if (m == 'wall.post') {
query += '&owner_id=' + parseInt(params.owner_id || 0, 10) + '&attachments=' + (params.attachments || params.attachment || '');
}
var method_access = '_'+(Math.random()).toString(16).substr(2);
query += '&method_access='+method_access;
var popup = VK.UI.popup({
url: query,
width: 460,
height: 220
});
var timer = setInterval(function() {
if (VK.UI.active.closed) {
clearInterval(timer);
params.method_access = method_access;
VK.Api.call(method, params, cb, queryTry);
}
}, 500);
return false;
}
return true;
},
call: function(method, params, cb, queryTry) {
var
query = params || {},
qs,
responseCb;
if (typeof query != 'object' || typeof cb != 'function') {
return false;
}
if (!params.method_access && !params.method_force && !VK.Api.checkMethod(method, params, cb, queryTry)) {
return;
}
if (!queryTry) queryTry = 0;
if (VK.Auth._loadState != 'loaded') {
var authFunc = function(result) {
if (result && result.session) {
VK.Observer.unsubscribe('auth.loginStatus', authFunc);
VK.Api.call(method, params, cb);
}
};
VK.Observer.subscribe('auth.loginStatus', authFunc);
VK.Auth.getLoginStatus();
return;
}
if (VK.Api.queryLength(query) < 1500 && !VK.Api.ie6_7()) {
var useXDM = false;
var rnd = parseInt(Math.random() * 10000000, 10);
while (VK.Api._callbacks[rnd]) {
rnd = parseInt(Math.random() * 10000000, 10)
}
query.callback = 'VK.Api._callbacks['+rnd+']';
} else {
var useXDM = true;
}
if (VK._session && VK._session.sid) {
query.access_token = VK._session.sid;
}
qs = VK.Cookie.encode(query);
responseCb = function(response) {
if (response.error && (response.error.error_code == 3 || response.error.error_code == 4 || response.error.error_code == 5)) {
if (queryTry > 3) return false;
var repeatCall = function(resp) {
VK.Observer.unsubscribe('auth.sessionChange', repeatCall);
delete params.access_token;
if (resp.session) VK.Api.call(method, params, cb, queryTry + 1);
}
VK.Observer.subscribe('auth.sessionChange', repeatCall);
VK.Auth.getLoginStatus();
} else {
cb(response);
}
if (!useXDM) delete VK.Api._callbacks[rnd];
};
if (useXDM) {
if (VK.xdReady) {
VK.XDM.remote.callMethod('apiCall', method, qs, responseCb);
} else {
VK.Observer.subscribe('xdm.init', function() {VK.XDM.remote.callMethod('apiCall', method, qs, responseCb);});
VK.XDM.init();
}
} else {
VK.Api._callbacks[rnd] = responseCb;
VK.Api.attachScript(VK._domain.api + 'method/' + method +'?' + qs);
}
},
queryLength: function(query) {
var len = 100, i; // sid + sig
for (i in query) {
len += i.length + encodeURIComponent(query.i).length + 1;
}
return len;
}
};
// Alias
VK.api = function(method, params, cb) {VK.Api.call(method, params, cb);}
};
if (!VK.Auth) {
VK.Auth = {
popup: null,
lsCb: {},
setSession: function(session, status, settings, resp) {
var
login = !VK._session && session,
logout = VK._session && !session,
both = VK._session && session && VK._session.mid != session.mid,
sessionChange = login || logout || (VK._session && session && VK._session.sid != session.sid),
statusChange = status != VK._userStatus,
response = {
'session': session,
'status': status,
'settings': settings
};
VK._session = session;
VK._userStatus = status;
VK.Cookie.set(session, resp);
if (sessionChange || statusChange || both) {
setTimeout(function() {
if (statusChange) {
VK.Observer.publish('auth.statusChange', response);
}
if (logout || both) {
VK.Observer.publish('auth.logout', response);
}
if (login || both) {
if (VK.xdReady) VK.XDM.remote.init(VK._apiId, session, status);
VK.Observer.publish('auth.login', response);
}
if (sessionChange) {
VK.Observer.publish('auth.sessionChange', response);
}
}, 0);
}
return response;
},
// Public VK.Auth methods
login: function(cb, settings) {
var channel, url;
if (!VK._apiId) {
return false;
}
channel = window.location.protocol + '//' + window.location.hostname;
url = VK._domain.main + VK._path.login + '?client_id='+VK._apiId+'&display=popup&redirect_uri=close.html&response_type=token';
if (settings && parseInt(settings, 10) > 0) {
url += '&scope=' + settings;
}
VK.Observer.unsubscribe('auth.onLogin');
VK.Observer.subscribe('auth.onLogin', cb);
VK.UI.popup({
width: 620,
height: 370,
url: url
});
var authCallback = function() {
VK.Auth.getLoginStatus(function(resp) {
VK.Observer.publish('auth.onLogin', resp);
VK.Observer.unsubscribe('auth.onLogin');
}, true);
}
VK.UI.popupOpened = true;
var popupCheck = function() {
if (!VK.UI.popupOpened) return false;
try {
if (!VK.UI.active.top) {
VK.UI.popupOpened = false;
authCallback();
return true;
}
} catch(e) {
VK.UI.popupOpened = false;
authCallback();
return true;
}
setTimeout(popupCheck, 100);
};
setTimeout(popupCheck, 100);
},
// Logout user from app, vk.com & login.vk.com
logout: function(cb) {
VK.Auth.revokeGrants(cb);
},
revokeGrants: function(cb) {
var onLogout = function(resp) {
VK.Observer.unsubscribe('auth.statusChange', onLogout);
if (cb) cb(resp);
}
VK.Observer.subscribe('auth.statusChange', onLogout);
if (VK._session && VK._session.sid) VK.Api.attachScript('https://login.vk.com/?act=openapi&oauth=1&aid=' + parseInt(VK._apiId, 10) + '&location=' + encodeURIComponent(window.location.hostname)+'&do_logout=1&token='+VK._session.sid);
VK.Cookie.clear();
},
// Get current login status from session (sync) (not use on load time)
getSession: function() {
return VK._session;
},
// Get current login status from vk.com (async)
getLoginStatus: function(cb, force) {
if (!VK._apiId) {
return;
}
if (cb) {
if (!force && VK.Auth._loadState == 'loaded') {
cb({status: VK._userStatus, session: VK._session});
return;
} else {
VK.Observer.subscribe('auth.loginStatus', cb);
}
}
if (!force && VK.Auth._loadState == 'loading') {
return;
}
VK.Auth._loadState = 'loading';
var rnd = parseInt(Math.random() * 10000000, 10);
while (VK.Auth.lsCb[rnd]) {
rnd = parseInt(Math.random() * 10000000, 10)
}
VK.Auth.lsCb[rnd] = function(response) {
delete VK.Auth.lsCb[rnd];
VK.Auth._loadState = 'loaded';
if (response && response.auth) {
var session = {
mid: response.user.id,
sid: response.access_token,
sig: response.sig,
secret: response.secret,
expire: response.expire
};
if (force) session.user = response.user;
var status = 'connected';
} else {
var session = null;
var status = response.user ? 'logined' : 'unknown';
VK.Cookie.clear();
}
VK.Auth.setSession(session, status, false, response);
VK.Observer.publish('auth.loginStatus', {session: session, status: status});
VK.Observer.unsubscribe('auth.loginStatus');
};
// AttachScript here
VK.Api.attachScript('https://login.vk.com/?act=openapi&oauth=1&aid=' + parseInt(VK._apiId, 10) + '&location=' + encodeURIComponent(window.location.hostname)+'&rnd='+rnd);
}
};
}
} else { // if VK.xdConnectionCallbacks
setTimeout(function() {
var callback;
while (callback = VK.xdConnectionCallbacks.pop()) {
callback();
}
}, 0);
if (VK.Widgets && !VK.Widgets._constructor) {
VK.Widgets = false;
}
}
if (!VK.UI) {
VK.UI = {
active: null,
_buttons: [],
popup: function(options) {
var
screenX = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
screenY = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
width = options.width,
height = options.height,
left = parseInt(screenX + ((outerWidth - width) / 2), 10),
top = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
features = (
'width=' + width +
',height=' + height +
',left=' + left +
',top=' + top
);
this.active = window.open(options.url, 'vk_openapi', features);
},
button: function(el, handler) {
var html = '';
if (typeof el == 'string') {
el = document.getElementById(el);
}
this._buttons.push(el);
index = this._buttons.length - 1;
html = (
'<table cellspacing="0" cellpadding="0" id="openapi_UI_' + index + '" onmouseover="VK.UI._change(1, ' + index + ');" onmouseout="VK.UI._change(0, ' + index + ');" onmousedown="VK.UI._change(2, ' + index + ');" onmouseup="VK.UI._change(1, ' + index + ');" style="cursor: pointer; border: 0px; font-family: tahoma, arial, verdana, sans-serif, Lucida Sans; font-size: 10px;"><tr style="vertical-align: middle">' +
'<td><div style="border: 1px solid #3b6798;border-radius: 2px 0px 0px 2px;-moz-border-radius: 2px 0px 0px 2px;-webkit-border-radius: 2px 0px 0px 2px;"><div style="border: 1px solid #5c82ab; border-top-color: #7e9cbc; background-color: #6D8DB1; color: #fff; text-shadow: 0px 1px #45688E; height: 15px; padding: 2px 4px 0px 6px;line-height: 13px;">&#1042;&#1086;&#1081;&#1090;&#1080;</div></div></td>' +
'<td><div style="background: url(' + VK._protocol + '//vk.com/images/btns.png) 0px -42px no-repeat; width: 21px; height: 21px"></div></td>' +
'<td><div style="border: 1px solid #3b6798;border-radius: 0px 2px 2px 0px;-moz-border-radius: 0px 2px 2px 0px;-webkit-border-radius: 0px 2px 2px 0px;"><div style="border: 1px solid #5c82ab; border-top-color: #7e9cbc; background-color: #6D8DB1; color: #fff; text-shadow: 0px 1px #45688E; height: 15px; padding: 2px 6px 0px 4px;line-height: 13px;">&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1077;</div></div></td>' +
'</tr></table>'
);
el.innerHTML = html;
el.style.width = el.childNodes[0].offsetWidth + 'px';
},
_change: function(state, index) {
var row = document.getElementById('openapi_UI_' + index).rows[0];
var elems = [row.cells[0].firstChild.firstChild, row.cells[2].firstChild.firstChild];
for (var i = 0; i < 2; ++i) {
var elem = elems[i];
if (state === 0) {
elem.style.backgroundColor = '#6D8DB1';
elem.style.borderTopColor = '#7E9CBC';
elem.style.borderLeftColor = elem.style.borderRightColor = elem.style.borderBottomColor = '#5C82AB';
} else if (state == 1) {
elem.style.backgroundColor = '#7693B6';
elem.style.borderTopColor = '#88A4C4';
elem.style.borderLeftColor = elem.style.borderRightColor = elem.style.borderBottomColor = '#6088B4';
} else if (state == 2) {
elem.style.backgroundColor = '#6688AD';
elem.style.borderBottomColor = '#7495B8';
elem.style.borderLeftColor = elem.style.borderRightColor = elem.style.borderTopColor = '#51779F';
}
}
if (state === 0 || state == 2) {
row.cells[2].firstChild.style.backgroundPosition = '0px -42px';
} else if (state == 1) {
row.cells[2].firstChild.style.backgroundPosition = '0px -63px';
}
}
};
}
if (!VK.XDM) {
VK.XDM = {
remote: null,
init: function() {
if (this.remote) return false;
var url = VK._domain.api + VK._path.proxy;
this.remote = new fastXDM.Server({
onInit: function() {
VK.XDM.remote.callMethod('init', VK._apiId, VK._session, VK._userStatus);
VK.xdReady = true;
VK.Observer.publish('xdm.init');
},
setSession: {
isVoid: true,
method: function(session, status) {
VK.Auth.setSession(session, status);
}
},
alert: {
isVoid: true,
method: function(text) {
alert(text);
}
}
});
this.remote.append(document.getElementById(VK._rootId), {
src: url
});
},
xdHandler: function(code) {
try {
eval('VK.' + code);
} catch(e) {}
}
};
}
if (!VK.Observer) {
VK.Observer = {
_subscribers: function() {
if (!this._subscribersMap) {
this._subscribersMap = {};
}
return this._subscribersMap;
},
publish: function(eventName) {
var
args = Array.prototype.slice.call(arguments),
eventName = args.shift(),
subscribers = this._subscribers()[eventName],
i, j;
if (!subscribers) return;
for (i = 0, j = subscribers.length; i < j; i++) {
if (subscribers[i] != null) {
subscribers[i].apply(this, args);
}
}
},
subscribe: function(eventName, handler) {
var
subscribers = this._subscribers();
if (typeof handler != 'function') return false;
if (!subscribers[eventName]) {
subscribers[eventName] = [handler];
} else {
subscribers[eventName].push(handler);
}
},
unsubscribe: function(eventName, handler) {
var
subscribers = this._subscribers()[eventName],
i, j;
if (!subscribers) return false;
if (typeof handler == 'function') {
for (i = 0, j = subscribers.length; i < j; i++) {
if (subscribers[i] == handler) {
subscribers[i] = null;
}
}
} else {
delete this._subscribers()[eventName];
}
}
};
}
if (!VK.Widgets) {
VK.Widgets = {};
VK.Widgets.count = 0;
VK.Widgets.RPC = {};
VK.Widgets.loading = function(obj, enabled) {
obj.style.background = enabled ? 'url("' + VK._protocol + '//vk.com/images/upload.gif") center center no-repeat transparent' : 'none';
};
VK.Widgets.Comments = function(objId, options, page) {
var pData = VK.Util.getPageData();
if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
options = options || {};
var params = {
limit: options.limit || 10,
height: options.height || 0,
mini: options.mini === undefined ? 'auto' : options.mini,
norealtime: options.norealtime ? 1 : 0
}, mouseup = function() {
rpc.callMethod('mouseUp');
return false;
}, move = function(event) {
rpc.callMethod('mouseMove', {screenY: event.screenY});
}, iframe, rpc;
if (options.browse) { // browse all comments
params.browse = 1;
params.replies = options.replies || 0;
} else { // page
VK.extend(params, {
page: page || 0,
status_publish: options.autoPublish === undefined ? 1 : options.autoPublish,
attach: options.attach === undefined ? '*' : (options.attach ? options.attach : ''),
url: options.pageUrl || pData.url,
title: options.pageTitle || pData.title,
description: options.pageDescription || pData.description,
image: options.pageImage || pData.image
});
}
if (options.onChange) { // DEPRECATED
VK.Observer.subscribe('widgets.comments.new_comment', options.onChange);
VK.Observer.subscribe('widgets.comments.delete_comment', options.onChange);
}
return VK.Widgets._constructor('widget_comments.php', objId, options, params, {
showBox: function(url, props) {
var box = VK.Util.Box((options.base_domain || VK._protocol + '//vk.com/') + url, [], {
proxy: function() {
rpc.callMethod.apply(rpc, arguments);
}
});
box.show();
},
startDrag: function() {
cursorBack = window.document.body.style.cursor;
window.document.body.style.cursor = 'pointer';
VK.Util.addEvent('mousemove', move);
VK.Util.addEvent('mouseup', mouseup);
},
stopDrag: function() {
window.document.body.style.cursor = cursorBack;
VK.Util.removeEvent('mousemove', move);
VK.Util.removeEvent('mouseup', mouseup);
}
}, {
startHeight: 133,
minWidth: 300,
width: '100%'
}, function(o, i, r) {iframe = i; rpc = r;});
};
VK.Widgets.CommentsBrowse = function(objId, options) {
options = options || {};
options.browse = 1;
return VK.Widgets.Comments(objId, options);
};
VK.Widgets.Recommended = function(objId, options) {
var pData = VK.Util.getPageData();
if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
options = options || {};
var params = {
limit: options.limit || 5,
max: options.max || 0,
sort: options.sort || 'friend_likes',
verb: options.verb || 0,
period: options.period || 'week',
target: options.target || 'parent'
};
return VK.Widgets._constructor('widget_recommended.php', objId, options, params, {}, {
startHeight: (90 + params.limit * 30),
minWidth: 150,
width: '100%'
});
};
VK.Widgets.Like = function(objId, options, page) {
var pData = VK.Util.getPageData();
if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
options = VK.extend(options || {}, {allowTransparency: true});
if (options.type == 'button' || options.type == 'vertical' || options.type == 'mini') delete options.width;
var
type = (options.type == 'full' || options.type == 'button' || options.type == 'vertical' || options.type == 'mini') ? options.type : 'full',
width = type == 'full' ? Math.max(200, options.width || 350) : (type == 'button' ? 180 : (type == 'mini' ? 100 : 41)),
btnHeight = parseInt(options.height, 10) || 22,
height = type == 'vertical' ? (2 * btnHeight + 7) : (type == 'full' ? btnHeight + 1 : btnHeight),
params = {
page: page || 0,
url: options.pageUrl || pData.url,
type: type,
verb: options.verb == 1 ? 1 : 0,
title: options.pageTitle || pData.title,
description: options.pageDescription || pData.description,
image: options.pageImage || pData.image,
text: (options.text || '').substr(0, 140),
h: btnHeight
},
ttHere = options.ttHere || false,
isOver = false,
obj, buttonIfr, buttonRpc, tooltipIfr, tooltipRpc, checkTO, statsBox;
function showTooltip(force) {
if ((!isOver && !force) || !tooltipRpc) return;
if (!tooltipIfr || !tooltipRpc || tooltipIfr.style.display != 'none' && tooltipIfr.getAttribute('vkhidden') != 'yes') return;
var scrollTop = options.getScrollTop ? options.getScrollTop() : (document.body.scrollTop || document.documentElement.scrollTop || 0);
var objPos = VK.Util.getXY(obj, options.fixed);
var startY = ttHere ? 0 : objPos[1];
if (scrollTop > objPos[1] - 120 && options.tooltipPos != 'top' || type == 'vertical' || options.tooltipPos == 'bottom') {
tooltipIfr.style.top = (startY + height + 2) + 'px';
tooltipRpc.callMethod('show', false);
} else {
tooltipIfr.style.top = (startY - 125) + 'px';
tooltipRpc.callMethod('show', true);
}
VK.Util.ss(tooltipIfr, {left: ((ttHere ? 0 : objPos[0]) - (type == 'vertical' || type == 'mini' ? 36 : 2)) + 'px', display: 'block', opacity: 1, filter: 'none'});
tooltipIfr.setAttribute('vkhidden', 'no');
isOver = true;
}
function hideTooltip(force) {
if ((isOver && !force) || !tooltipRpc) return;
tooltipRpc.callMethod('hide');
buttonRpc.callMethod('hide');
setTimeout(function() {
tooltipIfr.style.display = 'none'
}, 400);
}
return VK.Widgets._constructor('widget_like.php', objId, options, params, {
initTooltip: function(counter) {
tooltipRpc = new fastXDM.Server({
onInit: counter ? function() {showTooltip(true)} : function() {},
proxy: function() {
buttonRpc.callMethod.apply(buttonRpc, arguments);
},
showBox: function(url, props) {
var box = VK.Util.Box((options.base_domain || VK._protocol + '//vk.com/') + url, [props.width, props.height], {
proxy: function() {
tooltipRpc.callMethod.apply(tooltipRpc, arguments);
}
});
box.show();
},
statsBox: function(act) {
hideTooltip(true);
statsBox = VK.Util.Box(buttonIfr.src + '&act=a_stats_box&widget_width=620');
statsBox.show();
}
}, false, {safe: true});
tooltipIfr = tooltipRpc.append(ttHere ? obj : document.body, {
src: buttonIfr.src + '&act=a_share_tooltip',
scrolling: 'no',
allowTransparency: true,
id: buttonIfr.id + '_tt',
style: {position: 'absolute', padding: 0, display: 'block', opacity: 0.01, filter: 'alpha(opacity=1)', border: '0', width: '206px', height: '127px', zIndex: 5000, overflow: 'hidden'}
});
tooltipIfr.setAttribute('vkhidden', 'yes');
obj.onmouseover = tooltipIfr.onmouseover = function() {isOver = true;};
obj.onmouseout = tooltipIfr.onmouseout = function() {
clearTimeout(checkTO);
isOver = false;
checkTO = setTimeout(function() {hideTooltip(); }, 200);
};
},
showTooltip: showTooltip,
hideTooltip: hideTooltip,
showBox: function(url, props) {
var box = VK.Util.Box((options.base_domain || VK._protocol + '//vk.com/') + url, [], {
proxy: function() {
buttonRpc.callMethod.apply(buttonRpc, arguments);
}
});
box.show();
},
proxy: function() {if (tooltipRpc) tooltipRpc.callMethod.apply(tooltipRpc, arguments);}
}, {
startHeight: height,
minWidth: width
}, function(o, i, r) {
buttonRpc = r;
VK.Util.ss(obj = o, {height: height + 'px', width: width + 'px', position: 'relative', clear: 'both'});
VK.Util.ss(buttonIfr = i, {height: height + 'px', width: width + 'px', overflow: 'hidden', zIndex: 150});
});
};
VK.Widgets.Poll = function(objId, options, pollId) {
var pData = VK.Util.getPageData();
// if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
if (!pollId) throw Error('No poll id passed');
options = options || {};
var params = {
poll_id: pollId,
url: options.pageUrl || pData.url || location.href,
title: options.pageTitle || pData.title,
description: options.pageDescription || pData.description
};
return VK.Widgets._constructor('widget_poll.php', objId, options, params, {}, {
startHeight: 133,
minWidth: 300,
width: '100%'
});
};
VK.Widgets.PagePoll = function(objId, options, page) {
var pData = VK.Util.getPageData();
// if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
options = options || {};
var params = {
page: page || 0,
norealtime: options.norealtime ? 1 : 0,
poll_id: options.pollId || '',
url: options.pageUrl || pData.url || location.href,
title: options.pageTitle || pData.title,
description: options.pageDescription || pData.description
};
return VK.Widgets._constructor('al_widget_poll.php', objId, options, params, {}, {
startHeight: 133,
minWidth: 300,
width: '100%'
});
};
VK.Widgets.Community = VK.Widgets.Group = function(objId, options, gid) {
gid = parseInt(gid, 10);
var RPC;
if (!gid) {
throw Error('No group_id passed');
}
options.mode = parseInt(options.mode, 10).toString();
var params = {
gid: gid,
mode: (options.mode) ? options.mode : '0'
};
if (!options.width) options.width = 200;
if (options.wall) params.wall = options.wall;
params.color1 = options.color1 || '';
params.color2 = options.color2 || '';
params.color3 = options.color3 || '';
if (options.no_head) params.no_head = 1;
if (!options.height) options.height = 290;
if (options.wide) {
params.wide = 1;
if (options.width < 300) {
options.width = 300;
}
}
var cursorBack;
function mouseup() {
RPC.callMethod('mouseUp');
return false;
}
function move(event) {
RPC.callMethod('mouseMove', {screenY: event.screenY});
return false;
}
return VK.Widgets._constructor('widget_community.php', objId, options, params, {
showBox: function(url, props) {
var box = VK.Util.Box((options.base_domain || VK._protocol + '//vk.com/') + url, [], {
proxy: function() {
rpc.callMethod.apply(rpc, arguments);
}
});
box.show();
},
startDrag: function() {
cursorBack = window.document.body.style.cursor;
window.document.body.style.cursor = 'pointer';
VK.Util.addEvent('mousemove', move);
VK.Util.addEvent('mouseup', mouseup);
},
stopDrag: function() {
window.document.body.style.cursor = cursorBack;
VK.Util.removeEvent('mousemove', move);
VK.Util.removeEvent('mouseup', mouseup);
},
auth: function() {
VK.Auth.login(null, 1);
}
}, {
minWidth: 120,
width: '200',
height: '290',
startHeight: 200
}, function(o, i, r) {
RPC = r;
});
};
VK.Widgets.Auth = function(objId, options) {
var pData = VK.Util.getPageData();
if (!VK._apiId) throw Error('VK not initialized. Please use VK.init');
if (!options.width) {
options.width = 200;
}
if (options.type) {
type = 1;
} else {
type = 0;
}
return VK.Widgets._constructor('widget_auth.php', objId, options, {}, {makeAuth: function(data) {
if (data.session) {
VK.Auth._loadState = 'loaded';
VK.Auth.setSession(data.session, 'connected');
VK.Observer.publish('auth.loginStatus', {session: data.session, status: 'connected'});
VK.Observer.unsubscribe('auth.loginStatus');
}
if (options.onAuth) {
options.onAuth(data);
} else {
if (options.authUrl) {
var href = options.authUrl;
} else {
var href = window.location.href;
}
if (href.indexOf('?') == -1) {
href+='?';
} else {
href+='&';
}
var vars = [];
for (var i in data) {
if (i != 'session') vars.push(i+'='+decodeURIComponent(data[i]).replace(/&/g, '%26').replace(/\?/, '%3F'));
}
window.location.href = href + vars.join('&');
}
}}, {startHeight: 80});
};
VK.Widgets.Subscribe = function(objId, options, oid) {
oid = parseInt(oid, 10);
var RPC;
if (!oid) {
throw Error('No owner_id passed');
}
var params = {
oid: oid
};
if (options.mode) {
params.mode = options.mode;
}
if (options.soft) {
params.soft = options.soft;
}
return VK.Widgets._constructor('widget_subscribe.php', objId, options, params, {
showBox: function(url, props) {
var box = VK.Util.Box((options.base_domain || VK._protocol + '//vk.com/') + url, [], {
proxy: function() {
rpc.callMethod.apply(rpc, arguments);
}
});
box.show();
},
auth: function() {
VK.Auth.login(null, 1);
}
}, {
minWidth: 220,
startHeight: 22,
height: options.height || 22
}, function(o, i, r) {
RPC = r;
});
};
VK.Widgets.Ads = function(objId, options, paramsExtra) {
options = options || {};
paramsExtra = paramsExtra || {};
var params = {};
var defaults = {};
var funcs = {};
var obj = document.getElementById(objId);
var iframe;
var rpc;
var paramsExtraFix = {};
for (var key in paramsExtra) {
var keyFix = (inArray(key, ['ads_count', 'hash']) ? key : 'ads_' + key);
paramsExtraFix[keyFix] = paramsExtra[key];
}
if (paramsExtraFix.ads_ad_unit_width === 'auto' || paramsExtraFix.ads_ad_unit_height === 'auto') {
if (obj && obj.getBoundingClientRect) {
obj.style.width = '100%';
obj.style.height = '100%';
var rect = obj.getBoundingClientRect();
obj.style.width = '';
obj.style.height = '';
if (paramsExtraFix.ads_ad_unit_width === 'auto') {
paramsExtraFix.ads_ad_unit_width = Math.floor(rect.right - rect.left);
if (!paramsExtraFix.ads_ad_unit_width) {
delete paramsExtraFix.ads_ad_unit_width;
}
}
if (paramsExtraFix.ads_ad_unit_height === 'auto') {
paramsExtraFix.ads_ad_unit_height = Math.floor(rect.bottom - rect.top);
if (!paramsExtraFix.ads_ad_unit_height) {
delete paramsExtraFix.ads_ad_unit_height;
}
}
}
if (paramsExtraFix.ads_ad_unit_width === 'auto') {
delete paramsExtraFix.ads_ad_unit_width;
}
if (paramsExtraFix.ads_ad_unit_height === 'auto') {
delete paramsExtraFix.ads_ad_unit_height;
}
}
var width = (paramsExtraFix && parseInt(paramsExtraFix.ads_ad_unit_width) || 100);
var height = (paramsExtraFix && parseInt(paramsExtraFix.ads_ad_unit_height) || 100);
var handler = paramsExtraFix.ads_handler;
var handlerEmptyHtml = paramsExtraFix.ads_handler_empty_html;
delete paramsExtraFix.ads_handler;
delete paramsExtraFix.ads_handler_empty_html;
if (paramsExtraFix.ads_demo === 'empty') {
adsProcessHandler(0);
return;
}
params.act = 'ads_web';
params.url = location.href;
VK.extend(params, paramsExtraFix);
options.noDefaultParams = true;
options.width = width;
options.allowTransparency = true;
defaults.startHeight = height;
defaults.minWidth = width;
funcs.adsOnInitLoader = adsOnInitLoader;
funcs.adsOnInit = adsOnInit;
return VK.Widgets._constructor('ads_rotate.php', objId, options, params, funcs, defaults, onDone);
function adsOnInitLoader(adsScriptVersion) {
VK.Widgets.loading(obj, true);
adsAttachScript(adsScriptVersion);
}
function adsOnInit(errorCode) {
VK.Widgets.loading(obj, false);
if (options.onAdsReady) options.onAdsReady.apply(options.onAdsReady, Array.prototype.slice.call(arguments));
adsProcessHandler(errorCode);
}
function adsAttachScript(adsScriptVersion) {
if (!('vk__adsLight' in window)) {
window.vk__adsLight = false;
adsScriptVersion = parseInt(adsScriptVersion);
var attachScriptFucn = (VK.Api && VK.Api.attachScript || VK.addScript);
var base_domain = (options.base_domain || VK._protocol + '//vk.com');
attachScriptFucn(base_domain + '/js/al/aes_light.js?' + adsScriptVersion);
} else if (window.vk__adsLight && vk__adsLight.userHandlers && vk__adsLight.userHandlers.onInit) {
vk__adsLight.userHandlers.onInit();
}
}
function adsProcessHandler(errorCode) {
var handlerResult = adsEvalHandler(handler, errorCode);
if (errorCode <= 0 && handlerResult !== true) {
try { console.log('VK: ad_unit_id = ' + paramsExtraFix.ads_ad_unit_id, ', errorCode = ', errorCode); } catch (e) {}
adsInsertHtmlHandler(handlerEmptyHtml, paramsExtraFix.ads_ad_unit_width, paramsExtraFix.ads_ad_unit_height);
}
}
function adsEvalHandler(handler) {
var result = false;
try {
if (!handler) {
return false;
}
var func = false;
if (isFunction(handler)) {
func = handler;
} else if (isString(handler)) {
var handlerFuncs = handler.split('.');
func = window;
for (var i = 0, len = handlerFuncs.length; i < len; i++) {
func = func[handlerFuncs[i]];
if (!func) {
break;
}
}
if (!func) {
var handlerResult = (new Function(handler))();
if (isFunction(handlerResult)) {
func = handlerResult;
} else {
result = handlerResult;
}
}
}
if (func) {
var args = Array.prototype.slice.call(arguments, 1);
result = func.apply(func, args);
}
} catch (e) {
try {
console.error(e);
} catch (e2) {}
}
return result;
function isFunction(obj) {
return Object.prototype.toString.call(obj) === '[object Function]';
}
function isString(obj) {
return Object.prototype.toString.call(obj) === '[object String]';
}
}
function adsInsertHtmlHandler(handlerHtml, width, height) {
if (!handlerHtml) {
return;
}
if (!obj) {
return;
}
width = (width ? width + 'px' : '');
height = (height ? height + 'px' : '');
var iframeHandlerHtml = '<html><head></head><body style="padding: 0; margin: 0;"><div>' + handlerHtml + '</div></body></html>';
var iframeHandler = document.createElement('iframe');
iframeHandler.onload = fixIframeHeight;
iframeHandler.id = (iframe ? iframe.id : ('vkwidget-' + Math.round(Math.random() * 1000000))) + '_ads_html_handler';
iframeHandler.src = 'about:blank';
iframeHandler.width = '100%';
iframeHandler.height = '100%';
iframeHandler.scrolling = 'no';
iframeHandler.frameBorder = '0';
iframeHandler.allowTransparency = true;
iframeHandler.style.overflow = 'hidden';
iframeHandler.style.width = width;
iframeHandler.style.height = height;
obj.style.width = width;
obj.style.height = height;
obj.appendChild(iframeHandler);
iframeHandler.contentWindow.vk_ads_html_handler = iframeHandlerHtml;
iframeHandler.src = 'javascript:window["vk_ads_html_handler"]';
function fixIframeHeight() {
if (height) {
return;
}
try {
var rect = iframeHandler.contentWindow.document.body.firstChild.getBoundingClientRect();
var heightFix = Math.ceil(rect.bottom - rect.top);
if (heightFix) {
iframeHandler.style.height = heightFix;
obj.style.height = heightFix;
}
} catch (e) {}
}
}
function indexOf(arr, value, from) {
for (var i = from || 0, l = (arr || []).length; i < l; i++) {
if (arr[i] == value) return i;
}
return -1;
}
function inArray(value, arr) {
return indexOf(arr, value) != -1;
}
function onDone(o, i, r) {
obj = o;
iframe = i;
rpc = r;
}
};
VK.Widgets._constructor = function(widgetUrl, objId, options, params, funcs, defaults, onDone, widgetId, iter) {
var obj = document.getElementById(objId);
widgetId = widgetId || (++VK.Widgets.count);
if (!obj) {
iter = iter || 0;
if (iter > 10) {
throw Error('VK.Widgets: object #' + objId + ' not found.');
}
setTimeout(function() {
VK.Widgets._constructor(widgetUrl, objId, options, params, funcs, defaults, onDone, widgetId, iter + 1);
}, 500);
return widgetId;
}
var ifr, base_domain, width, url, urlQueryString, encodedParam, rpc, iframe, i;
options = options || {};
defaults = defaults || {};
funcs = funcs || {};
base_domain = options.base_domain || VK._protocol + '//vk.com';
width = (options.width == 'auto') ? obj.clientWidth || '100%' : parseInt(options.width, 10);
if (options.height) {
params.height = options.height;
obj.style.height = options.height + 'px';
} else {
obj.style.height = (defaults.startHeight || 200) + 'px';
}
width = width ? (Math.max(defaults.minWidth || 200, Math.min(10000, width)) + 'px') : '100%';
if (!params.url) {
params.url = options.pageUrl || location.href.replace(/#.*$/, '');
}
url = base_domain + '/' + widgetUrl;
urlQueryString = '';
if (!options.noDefaultParams) {
urlQueryString += '&app=' + (VK._apiId || '0') + '&width=' + width
}
urlQueryString += '&_ver=' + VK.version
if (VK._iframeAppWidget) {
params.iframe_app = 1;
}
for (i in params) {
if (i == 'title' && params[i].length > 80) params[i] = params[i].substr(0, 80)+'...';
if (i == 'description' && params[i].length > 160) params[i] = params[i].substr(0, 160)+'...';
if (typeof(params[i]) == 'number') {
encodedParam = params[i];
} else {
try {
encodedParam = encodeURIComponent(params[i]);
} catch (e) {
encodedParam = '';
}
}
urlQueryString += '&' + i + '=' + encodedParam;
}
urlQueryString += '&' + (+new Date()).toString(16);
url += '?' + urlQueryString.substr(1);
obj.style.width = width;
VK.Widgets.loading(obj, true);
funcs.publish = function() {
var args = Array.prototype.slice.call(arguments);
args.push(widgetId);
VK.Observer.publish.apply(VK.Observer, args);
};
funcs.onInit = function() {
VK.Widgets.loading(obj, false);
if (funcs.onReady) funcs.onReady();
if (options.onReady) options.onReady();
}
funcs.resize = function(e, cb) {
obj.style.height = e + 'px';
var el = document.getElementById('vkwidget' + widgetId);
if (el) {
el.style.height = e + 'px';
}
}
funcs.resizeWidget = function(newWidth, newHeight) {
newWidth = parseInt(newWidth);
newHeight = parseInt(newHeight);
var widgetElem = document.getElementById('vkwidget' + widgetId);
if (isFinite(newWidth)) {
obj.style.width = newWidth + 'px';
if (widgetElem) {
widgetElem.style.width = newWidth + 'px';
}
}
if (isFinite(newHeight)) {
obj.style.height = newHeight + 'px';
if (widgetElem) {
widgetElem.style.height = newHeight + 'px';
}
}
if (options.onResizeWidget) options.onResizeWidget();
}
funcs.updateVersion = function(ver) {
if (ver > 1) {
VK.Api.attachScript('//vk.com/js/api/openapi_update.js?'+parseInt(ver));
}
}
rpc = VK.Widgets.RPC[widgetId] = new fastXDM.Server(funcs, function(origin) {
if (!origin) return true;
origin = origin.toLowerCase();
return (origin.indexOf('.vk.com') != -1 || origin.indexOf('/vk.com') != -1);
}, {safe: true});
iframe = VK.Widgets.RPC[widgetId].append(obj, {
src: url,
width: (width.indexOf('%') != -1) ? width : (parseInt(width) || width),
height: defaults.startHeight || '100%',
scrolling: 'no',
id: 'vkwidget' + widgetId,
allowTransparency: options.allowTransparency || false,
style: {
overflow: 'hidden'
}
});
onDone && setTimeout(function() {onDone(obj, iframe || obj.firstChild, rpc);}, 10);
return widgetId;
};
}
if (!VK.Util) {
VK.Util = {
getPageData: function() {
if (!VK._pData) {
var metas = document.getElementsByTagName('meta'), pData = {}, keys = ['description', 'title', 'url', 'image', 'app_id'], metaName;
for (var i in metas) {
if (!metas[i].getAttribute) continue;
if (metas[i].getAttribute && ((metaName = metas[i].getAttribute('name')) || (metaName = metas[i].getAttribute('property')))) {
for (var j in keys) {
if (metaName == keys[j] || metaName == 'og:'+keys[j] || metaName == 'vk:'+keys[j]) {
pData[keys[j]] = metas[i].content;
}
}
}
}
if (pData.app_id && !VK._apiId) {
VK._apiId = pData.app_id;
}
pData.title = pData.title || document.title || '';
pData.description = pData.description || '';
pData.image = pData.image || '';
if (!pData.url && VK._iframeAppWidget && VK._apiId) {
pData.url = '/app' + VK._apiId;
if (VK._browserHash) {
pData.url += VK._browserHash
}
}
var loc = location.href.replace(/#.*$/, '');
if (!pData.url || !pData.url.indexOf(loc)) {
pData.url = loc;
}
VK._pData = pData;
}
return VK._pData;
},
getStyle: function(elem, name) {
var ret, defaultView = document.defaultView || window;
if (defaultView.getComputedStyle) {
name = name.replace(/([A-Z])/g, '-$1').toLowerCase();
var computedStyle = defaultView.getComputedStyle(elem, null);
if (computedStyle) {
ret = computedStyle.getPropertyValue(name);
}
} else if (elem.currentStyle) {
var camelCase = name.replace(/\-(\w)/g, function(all, letter){
return letter.toUpperCase();
});
ret = elem.currentStyle[name] || elem.currentStyle[camelCase];
}
return ret;
},
getXY: function(obj, fixed) {
if (!obj || obj === undefined) return;
var left = 0, top = 0;
if (obj.getBoundingClientRect !== undefined) {
var rect = obj.getBoundingClientRect();
left = rect.left;
top = rect.top;
fixed = true;
} else if (obj.offsetParent) {
do {
left += obj.offsetLeft;
top += obj.offsetTop;
if (fixed) {
left -= obj.scrollLeft;
top -= obj.scrollTop;
}
} while (obj = obj.offsetParent);
}
if (fixed) {
top += window.pageYOffset || window.scrollNode && scrollNode.scrollTop || document.documentElement.scrollTop;
left += window.pageXOffset || window.scrollNode && scrollNode.scrollLeft || document.documentElement.scrollLeft;
}
return [left, top];
},
Box: function(src, sizes, fnc, options) {
fnc = fnc || {};
var overflowB = document.body.style.overflow;
var loader = document.createElement('DIV');
var rpc = new fastXDM.Server(VK.extend(fnc, {
onInit: function() {
iframe.style.background = 'transparent';
iframe.style.visibility = 'visible';
document.body.style.overflow = 'hidden';
document.body.removeChild(loader);
},
hide: function() {
iframe.style.display = 'none';
},
tempHide: function() {
iframe.style.left = '-10000px';
iframe.style.top = '-10000px';
iframe.style.width = '10px';
iframe.style.height = '10px';
document.body.style.overflow = overflowB;
},
destroy: function() {
try {
iframe.src = 'about: blank;';
} catch (e) {}
iframe.parentNode.removeChild(iframe);
document.body.style.overflow = overflowB;
},
resize: function(w, h) {
}
}, true), false, {safe: true}),
iframe = rpc.append(document.body, {
src: src.replace(/&amp;/g, '&'),
scrolling: 'no',
allowTransparency: true,
style: {position: 'fixed', left: 0, top: 0, zIndex: 1002, background: VK._protocol + '//vk.com/images/upload.gif center center no-repeat transparent', padding: '0', border: '0', width: '100%', height: '100%', overflow: 'hidden', visibility: 'hidden'}
});
loader.innerHTML = '<div style="position: fixed;left: 50%;top: 50%;margin: 0px auto 0px -60px;z-index: 1002;width: 100px;"><div style="background: url(//vk.com/images/upload_inv_mono'+(window.devicePixelRatio >= 2 ? '_2x' : '')+'.gif) no-repeat 50% 50%;background-size: 64px 16px;height: 50px;position: absolute;width: 100%;z-index: 100;"></div><div style="background-color: #000;opacity: 0.7;filter: alpha(opacity=70);height: 50px;-webkit-border-radius: 5px;-khtml-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.35);-moz-box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.35);box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.35);"></div></div>';
document.body.insertBefore(loader, document.body.firstChild);
return {
show: function(scrollTop, height) {
iframe.style.display = 'block';
document.body.style.overflow = 'hidden';
},
hide: function() {
iframe.style.display = 'none';
document.body.style.overflow = overflowB;
},
iframe: iframe,
rpc: rpc
}
},
addEvent: function(type, func) {
if (window.document.addEventListener) {
window.document.addEventListener(type, func, false);
} else if (window.document.attachEvent) {
window.document.attachEvent('on'+type, func);
}
},
removeEvent: function(type, func) {
if (window.document.removeEventListener) {
window.document.removeEventListener(type, func, false);
} else if (window.document.detachEvent) {
window.document.detachEvent('on'+type, func);
}
},
ss: function(el, styles) {VK.extend(el.style, styles, true);}
};
}
// Init asynchronous library loading
window.vkAsyncInit && setTimeout(vkAsyncInit, 0);
if (window.vkAsyncInitCallbacks && vkAsyncInitCallbacks.length) {
setTimeout(function() {
var callback;
while (callback = vkAsyncInitCallbacks.pop()) {
try {
callback();
} catch(e) {
try {
console.error(e);
} catch (e2) {}
}
}
}, 0);
}
try{if (window.stManager) stManager.done('api/openapi.js');}catch(e){}
</script>
<div id="content">
<div class="dev_main_head">
<div class="dev_main_narrow fl_r">
<a class="button_blue dev_create_app_btn" href="/editapp/create">
<button>  Создать приложение  </button>
<br>
</a>
<div style="padding-top:20px;">
<a href="/apps">Список моих приложений »</a>
</div>
</div>
<div class="dev_main_header">Разработка приложений</div>
<div class="dev_main_desc">
<b>Onepuls</b>
– самый быстрорастущий сайт европейского интернета. Его аудитория удваивается каждые несколько месяцев, и сейчас на onepuls приходится более половины русскоязычного трафика. Если Вы хотите заниматься разработкой приложений в интернете, Вы можете приобщиться к этому успеху и получить доступ к аудитории свыше
<b>3 тысяч</b>
пользователей.
</div>
<br class="clear">
<div class="dev_main_sections">
<a class="dev_sect dev_sect_games" href="/dev/native">
<div class="dev_sect_icon"></div>
Игры и приложения <b>Onepuls</b>
</a>
<a class="dev_sect dev_sect_standalone" href="/dev/standalone">
<div class="dev_sect_icon"></div>
Mobile/Standalone приложения
</a>
<a class="dev_sect dev_sect_widgets" href="/dev/sites">
<div class="dev_sect_icon"></div>
Авторизация и виджеты для сайтов
</a>
</div>
</div>
<div class="dev_main_cont">
<div class="dev_parts_list fl_l">
<a class="dev_part" href="/dev/main">
<div class="dev_part_name">Документация платформы</div>
<div class="dev_part_desc">Описание возможностей платформы Onepuls: процедура авторизации приложения, серверные и клиентские методы API, создание приложений и подключение сайтов.</div>
</a>
<a class="dev_part" href="/dev/help">
<div class="dev_part_name">Поддержка</div>
<div class="dev_part_desc">Разрешение вопросов, связанных с платформой: инструменты для связи со службой поддержки, попадание в каталог приложений, статус работы платформы.</div>
</a>
<a class="dev_part" href="/dev/rules">
<div class="dev_part_name">Правила платформы</div>
<div class="dev_part_desc">Правила публикации приложений на площадке onepuls, размещение рекламы в приложениях, прием платежей от пользователей.</div>
</a>
<a class="dev_part" href="/bugs">
<div class="dev_part_name">Баг-трекер</div>
<div class="dev_part_desc">Инструмент для информирования разработчиков о проблемах в API и документации платформы.</div>
</a>
</div>
</div>
</div>

<div class="clear"></div>