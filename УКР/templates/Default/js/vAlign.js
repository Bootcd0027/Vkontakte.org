// JavaScript Document

(function ($) {
// VERTICALLY ALIGN FUNCTION
$.fn.vAlign = function() {
  return this.each(function(i){
  var ah = $(this).height();
  var ph = $(this).parent().height();
  var mh = (ph - ah) / 2;
  if(mh>0) {
    $(this).css('padding-top', mh);
  } else {
    $(this).css('padding-top', 0);
  }
});
};
})(jQuery);