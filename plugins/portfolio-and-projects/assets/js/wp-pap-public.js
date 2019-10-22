jQuery(document).ready(function($){

	$( '.wppap-thumbs' ).each(function( index ) {
		
		var thumb_id 	= $(this).attr('id');
		var thumb_conf 	= $.parseJSON( $(this).find('.thumb-conf').text());

		$('#'+thumb_id).portfolio({
            cols: parseInt(thumb_conf.grid),
            transition: 'slideDown'
        });
	});

	$( "ul.wppap-thumbs li a" ).on( "click", function() {
		
		var slick_id 		= $(this).closest('.wppap-main-wrapper').find('.wppap-content .wpapap-portfolio-img-slider').attr('id');
		var slider_conf 	= $.parseJSON( $(this).closest('.wppap-main-wrapper').find('.wppap-content .wppap-slider-wrapper').find('.wppap-slider-conf').text());

		if( typeof(slick_id) !== 'undefined' && slick_id != '' ) {
			
			$('#'+slick_id).slick({
				dots				: (slider_conf.dots) == "true" 		? true : false,
				arrows				: (slider_conf.arrows) == "true" 	? true : false,
				infinite			: true,
				speed				: 1000,
				autoplay			: true,
				autoplaySpeed		: 1000,
				rtl             	: (WpPap.rtl == 1) 					? true : false,
				mobileFirst    		: (WpPap.is_mobile == 1) 			? true : false,
				fade 				: (slider_conf.effect)	== "fade" 	? true : false,
			});
		}
	});

});