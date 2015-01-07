require('./fixes/eventListener.polyfill.js');

window.jQuery = require('jquery');

//only include picturefill (with the css calc) in ie9+
var msie = window.navigator.userAgent.match(/MSIE (\d+)/);
if(msie instanceof Array && msie.length>0 && msie[1] > 8){
    require('picturefill');
}

require('slick-carousel');
require('fitvids');
require('./offcanvas.js');
require('./fixes/ie10-fix.js');


(function ($) {
    $(document).ready(function () {

        $('.post-content').fitVids({
            'customSelector': 'iframe[src*="ted.com"], iframe[src*="maps.google"]'
        });
        $('.slider').slick({
            slide: 'article',
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            pauseOnDotsHover: true,

            autoplay: true,
            autoplaySpeed: 3000
        });

        $('.sidebar.teaser').on('click', '.widget.TeaserWidget', function(e){
            if(window.matchMedia('(max-width: 991px)').matches){
                if(!$('body').hasClass('expanded-teaser')){
                    $('body').addClass('expanded-teaser');
                    e.preventDefault();
                }
            }
        });

    });
})(jQuery);