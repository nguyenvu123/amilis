(function($)  {   
    "use strict";
    $(document).ready(function(){ 
    	var member = $('.member-carousel-customs');

    	if(member) {
    		member.slick({
    			slidesToShow: 4,
    			dots: true,
  				infinite: true,
  				autoplaySpeed: 4000,
  				autoplay: true,
  				arrows: false,
    		});
    	}

        //map on mobile
        $('.show-list').click(function(event) {
            $('.section-amelis-sur-la-carte .list-items .items').slideDown({
                start: function () {
                    $('.show-map').css({
                        display: "flex"
                    });
                }
            });
            $(this).hide();
            $('.section-amelis-sur-la-carte .list-items .show-map').show();
        });

        $('.show-map').click(function(event) {
            $('.section-amelis-sur-la-carte .list-items .items').slideUp({
                start: function () {
                    $('.show-map').css({
                        display: "flex"
                    });
                }
            });
            $(this).hide();
            $('.section-amelis-sur-la-carte .list-items .show-list').show();
        });


        //menu mobile

        $('.menu-item-has-children').click(function(event) {
           $(this).toggleClass('open');
           var check_open_sub_menu = $(this).find('.open');

           if($('.menu-item-has-children').hasClass('open')) {
                $(this).find('.dropdown-wrapper').slideDown(); 
           }else {
                $(this).find('.dropdown-wrapper').slideUp();  
           }

           
        });

        $('.mobile.icon_menu').click(function(event) {
           $('.header__navigation').addClass('open_menu_mobile');
           $('body').toggleClass('fixed');
        });
         $('.icon_close-menu').click(function(event) {
           $('.header__navigation').removeClass('open_menu_mobile');
           $('body').removeClass('fixed');
        });
        


        
        
    
    });

})( jQuery );

var boilerplate_timer = true; 