<link media="screen" href="../style/style.css" type="text/css" rel="stylesheet" /> 
<div id="miniature_box" class="miniature_box" style="z-index:100; ">
 <div class="miniature_pos" style="width:700px;">
<div style="float:left; padding:20px; width:700px; background-color:#597ba5;  margin-left:-20px; margin-top:-20px; color:#fff; font-weight:bold;">
<span style="float:left;">
Последние загруженные фотографии</span>
<span style="float:right;"><a class="cursor_pointer fl_r" style="font-size:12px" onClick="viiBox.clos('ourphoto', 1);">Закрыть</a></span></div>
   <script type="text/javascript">
$(document).ready(function(){
	$('#miniature_box').scroll(function(){
		if($('#miniature_box').scrollTop() > 150){
			$('#onphotos').css('position', 'fixed').css('top', '0px').css('box-shadow','0px 0px 10px 1px #666');
		} else {
			$('#onphotos').css('position','relative').css('box-shadow','none');
		}
	});
});</script>
  <div id="onphotos" style="float: left; padding:15px 20px; width: 700px; background-color: #eff1f3; margin-left: -20px; color: #45689a; font-weight: bold; z-index:103;">
  
    
  <div onclick="viiBox.clos('ourphoto', 1), otherbox.awayphoto();" style="float:left; padding:5px; margin-right:5px; cursor:pointer;">На всем сайте</div>
  <div style="float:left; padding:5px; background-color:#597da3; color:#FFF; border-radius:3px;  cursor:pointer;"  >Мои фотографии</div>
  
  </div>

 

  <style>
  .noMarg{margin:1px; float:left;}
  </style>
  <div style="float:left;width:700px; ">
<div style="width:700px; min-height:100px;  float:left;">  
<img {vaphoto0} width="698" class="noMarg" />
<img {vaphoto1} width="348" height="250" class="noMarg" />
<img {vaphoto2} width="348" height="250" class="noMarg" />

<img {vaphoto3} width="173" height="125" class="noMarg" />
<img {vaphoto4} width="173" height="125" class="noMarg" />
<img {vaphoto5} width="173" height="125" class="noMarg" />
<img {vaphoto6} width="173" height="125" class="noMarg" />

<img {vaphoto7} width="348" height="250" class="noMarg" />

<img {vaphoto8} width="173" height="124" class="noMarg" />
<img {vaphoto9} width="173" height="124" class="noMarg" />
<img {vaphoto10} width="173" height="124" class="noMarg" />
<img {vaphoto11} width="173" height="124" class="noMarg" />

<img {vaphoto12} width="698" class="noMarg" />

<img {vaphoto13} width="698" class="noMarg" />
<img {vaphoto14} width="348" height="250" class="noMarg" />
<img {vaphoto15} width="348" height="250" class="noMarg" />

</div>

</div>
  <div class="clear"></div>