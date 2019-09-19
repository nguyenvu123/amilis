(function($)  {   
    "use strict";
    $(document).ready(function(){ 

    // sticky menu
        var c;
        var currentScrollTop = 0;
        var header = $('#mainHeader');
        var offset_header = $('#mainHeader').offset().top;
        if (offset_header > 0) {
            $('#mainHeader').addClass('pin-top');
        }

        $(window).scroll(function () {
            var a = $(window).scrollTop();
            var b = header.height();
            currentScrollTop = a;
            if (a > 0) {
                header.addClass("pin-top");
            }
            else {

                header.removeClass("pin-top"); 
                header.removeClass("pin");
            }

            if (c < currentScrollTop && a > 0) { 
                header.addClass("pin");
            } else if (c > currentScrollTop && a > 0) {
                header.removeClass("pin");
            }

            c = currentScrollTop; 
        }); 


        $('.include-menu .icon-search.icon-close .icon-Shape').click(function(event) {
            $('.search-container-2').show();
            $(this).css('display', 'none');
            $('.close-search').css('display', 'block');

        });

         $('.include-menu .icon-search.icon-close .close-search').click(function(event) {
            $('.search-container-2').hide();
            $(this).css('display', 'none');
            $('.icon-Shape').css('display', 'block');

        });

    });

})( jQuery );
