<?php
/**
 * Image Data Popup
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>

<div class="wp-pap-img-data-wrp wp-pap-hide">
	<div class="wp-pap-img-data-cnt">

		<div class="wp-pap-img-cnt-block">
			<div class="wp-pap-popup-close wp-pap-popup-close-wrp"><img src="<?php echo WP_PAP_URL; ?>assets/images/close.png" alt="<?php _e('Close (Esc)', 'swiper-slider-and-carousel'); ?>" title="<?php _e('Close (Esc)', 'swiper-slider-and-carousel'); ?>" /></div>

			<div class="wp-pap-popup-body-wrp">
			</div><!-- end .wp-pap-popup-body-wrp -->
			
			<div class="wp-pap-img-loader"><?php _e('Please Wait', 'portfolio-and-projects'); ?> <span class="spinner"></span></div>

		</div><!-- end .wp-pap-img-cnt-block -->

	</div><!-- end .wp-pap-img-data-cnt -->
</div><!-- end .wp-pap-img-data-wrp -->
<div class="wp-pap-popup-overlay"></div>