(function ($) {
  $(document).ready(function () { 
    if ($(".animate-element__flexslider > ul > li").length) {
      $('.animate-element__flexslider').flexslider({
        animation: "fade"
      });
    }    
  });
})(jQuery);
