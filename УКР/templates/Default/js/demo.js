function g(el){
var ge = document.getElementById(el);
return ge;
}

function hide(el){
var ge = document.getElementById(el).style.display = 'none';
return ge;
}

function show(el){
var ge = document.getElementById(el).style.display = 'block';
return ge;
}

function getXmlHttp(){
var xmlhttp;
try {
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
xmlhttp = false;
}
}
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
}

function sreen(page) {

var req = getXmlHttp() 
var statusElem = document.getElementById('body') 

req.onreadystatechange = function() { 
if (req.readyState == 3) { 

document.getElementById('box_site').innerHTML = '<div onClick="hide();" style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; margin:0 auto; z-index: 199; opacity: 0.5;background-color: #000; " class="jqmOverlay"></div>' + req.responseText + '</div>';
var ge = document.getElementById('box_site').style.display = 'block';
}
if (req.readyState == 4) { 



}

}

req.open('GET', page, true); 
req.send(null); // аОбаОбаЛаАбб аЗаАаПбаОб



}
function hide(el){ 
var ge = document.getElementById('box_site').style.display = 'none';
return ge; 
}