(function($)
{   
    "use strict";
    $(document).ready(function(){ 

    	$('#blogCarouselSlick').slick({
			leftPadding: '60px',
			slidesToShow: 1,
			dots: true,
  			infinite: true,
		});

		$('.slick-mobile-box-map').slick({
			leftPadding: '60px',
			slidesToShow: 1,
			dots: true,
  			infinite: true,
  			variableWidth: true
		});
		$('.local-map-mobile-slick').slick({
			leftPadding: '60px',
			slidesToShow: 1,
			dots: true,
  			infinite: true,
  			variableWidth: true
		});

		

		setTimeout(function(){ 
			$('.my-3.mb-5').each(function() {
				var height_card = $(this).find('.card-body').outerHeight();
				$(this).find('.img-square-wrapper img').css('height', height_card);
				$(this).find('.img-square-wrapper .crop-image-desktop').css("cssText", 'max-width: 780px;display: inline;');
			});

		}, 1000);
		
    });

})( jQuery );
