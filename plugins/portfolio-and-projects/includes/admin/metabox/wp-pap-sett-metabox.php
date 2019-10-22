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

$gallery_imgs 	= get_post_meta( $post->ID, $prefix.'gallery_id', true );
$no_img_cls		= !empty($gallery_imgs) ? 'wp-pap-hide' : '';
$project_url 	= get_post_meta( $post->ID, $prefix.'project_url', true );
?>

<table class="form-table wp-pap-post-sett-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="wp-pap-gallery-imgs"><?php _e('Choose Gallery Images', ' portfolio-and-projects'); ?></label>
			</th>
			<td>
				<button type="button" class="button button-secondary wp-pap-img-uploader" id="wp-pap-gallery-imgs" data-multiple="true" data-button-text="<?php _e('Add to Gallery', ' portfolio-and-projects'); ?>" data-title="<?php _e('Add Images to Gallery', ' portfolio-and-projects'); ?>"><i class="dashicons dashicons-format-gallery"></i> <?php _e('Gallery Images', ' portfolio-and-projects'); ?></button>
				<button type="button" class="button button-secondary wp-pap-del-gallery-imgs"><i class="dashicons dashicons-trash"></i> <?php _e('Remove Gallery Images', ' portfolio-and-projects'); ?></button><br/>
				
				<div class="wp-pap-gallery-imgs-prev wp-pap-imgs-preview wp-pap-gallery-imgs-wrp">
					<?php if( !empty($gallery_imgs) ) {
						foreach ($gallery_imgs as $img_key => $img_data) {

							$attachment_url 		= wp_get_attachment_thumb_url( $img_data );
							$attachment_edit_link	= get_edit_post_link( $img_data );
					?>
							<div class="wp-pap-img-wrp">
								<div class="wp-pap-img-tools wp-pap-hide">
									<span class="wp-pap-tool-icon wp-pap-edit-img dashicons dashicons-edit" title="<?php _e('Edit Image in Popup', ' portfolio-and-projects'); ?>"></span>
									<a href="<?php echo $attachment_edit_link; ?>" target="_blank" title="<?php _e('Edit Image', ' portfolio-and-projects'); ?>"><span class="wp-pap-tool-icon wp-pap-edit-attachment dashicons dashicons-visibility"></span></a>
									<span class="wp-pap-tool-icon wp-pap-del-tool wp-pap-del-img dashicons dashicons-no" title="<?php _e('Remove Image', ' portfolio-and-projects'); ?>"></span>
								</div>
								<img class="wp-pap-img" src="<?php echo $attachment_url; ?>" alt="" />
								<input type="hidden" class="wp-pap-attachment-no" name="wp_pap_img[]" value="<?php echo $img_data; ?>" />
							</div><!-- end .wp-pap-img-wrp -->
					<?php }
					} ?>
					
					<p class="wp-pap-img-placeholder <?php echo $no_img_cls; ?>"><?php _e('No Gallery Images', ' portfolio-and-projects'); ?></p>
				</div><!-- end .wp-pap-imgs-preview -->
				<span class="description"><?php _e('Choose your desired images for gallery. Hold Ctrl key to select multiple images at a time.', ' portfolio-and-projects'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="wp-pap-project-link"><?php _e('Project Link', ' portfolio-and-projects'); ?></label>
			</th>
			<td>
				<input type="url" id="wp-pap-project-link" class="large-text wp-pap-project-link" name="<?php echo $prefix ?>project_url" value="<?php echo wp_pap_esc_attr($project_url); ?>"><br/>
				<span class="description"><?php _e('Enter your Project Link here.', ' portfolio-and-projects'); ?></span>
			</td>
		</tr>
	</tbody>
</table><!-- end .wtwp-tstmnl-table -->