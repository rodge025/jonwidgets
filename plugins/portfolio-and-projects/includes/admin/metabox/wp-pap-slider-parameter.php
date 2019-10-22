<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $post;

$prefix = WP_PAP_META_PREFIX; // Metabox prefix

// Slider Variables
$arrow_slider 				= get_post_meta( $post->ID, $prefix.'arrow_slider', true );
$pagination_slider 			= get_post_meta( $post->ID, $prefix.'pagination_slider', true );
$animation_slider 			= get_post_meta( $post->ID, $prefix.'animation_slider', true );
?>

<div class="wp-tsasp-mb-tabs-wrp">
	
	<div id="wp-tsasp-mdetails" class="wp-tsasp-mdetails wpssc-slider">
		<table class="form-table wp-tsasp-team-detail-tbl">
			<tbody>
				<tr valign="top">
					<h4><?php _e('Navigation & Pagination Settings', 'swiper-slider-and-carousel') ?></h4>
					<hr>
					<td scope="row">
						<label><?php _e('Arrow', 'swiper-slider-and-carousel'); ?></label>
					</td>
					<td>
						<input type="radio" value="true" name="<?php echo $prefix; ?>arrow_slider" <?php checked( 'true', $arrow_slider ); ?>>True
						<input type="radio" value="false" name="<?php echo $prefix; ?>arrow_slider" <?php checked( 'false', $arrow_slider ); ?>>False<br>
						<em style="font-size:11px;"><?php _e('Enable Arrows for slider','swiper-slider-and-carousel'); ?></em>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Pagination', 'swiper-slider-and-carousel'); ?></label>
					</td>
					<td>
						<input type="radio" name="<?php echo $prefix; ?>pagination_slider" value="true" <?php checked( 'true', $pagination_slider ); ?>>True
						<input type="radio" name="<?php echo $prefix; ?>pagination_slider" value="false" <?php checked( 'false', $pagination_slider ); ?>>False<br>
						<em style="font-size:11px;"><?php _e('String with CSS selector or HTML element of the container with pagination','swiper-slider-and-carousel'); ?></em>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Effect', 'swiper-slider-and-carousel'); ?></label>
					</td>
					<td>
						<select name="<?php echo $prefix; ?>animation_slider">
							<option value="slide" <?php if($animation_slider == 'slide'){echo 'selected'; } ?>>Slide</option>
							<option value="fade" <?php if($animation_slider == 'fade'){echo 'selected'; } ?>>Fade</option>
						</select><br/>
						<em style="font-size:11px;"><?php _e('Could be "slide", "fade"','swiper-slider-and-carousel'); ?></em>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>