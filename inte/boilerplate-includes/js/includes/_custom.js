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
    
    });

})( jQuery );

var boilerplate_timer = true; 