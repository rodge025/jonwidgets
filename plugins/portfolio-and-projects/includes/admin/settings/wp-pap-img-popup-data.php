<?php
/**
 * Popup Image Data HTML
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$prefix = WP_PAP_META_PREFIX;

// Taking some values
$alt_text 			= get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
$attachment_link 	= get_post_meta( $attachment_id, $prefix.'attachment_link', true );
?>

<div class="wp-pap-popup-title"><?php _e('Edit Image', 'portfolio-and-projects'); ?></div>
	
<div class="wp-pap-popup-body">

	<form method="post" class="wp-pap-attachment-form">
		
		<?php if( !empty($attachment_post->guid) ) { ?>
		<div class="wp-pap-popup-img-preview">
			<img src="<?php echo $attachment_post->guid; ?>" alt="" />
		</div>
		<?php } ?>
		<a href="<?php echo get_edit_post_link( $attachment_id ); ?>" target="_blank" class="button right"><i class="dashicons dashicons-edit"></i> <?php _e('Edit Image From Attachment Page', ' portfolio-and-projects'); ?></a>

		<table class="form-table">
			<tr>
				<th><label for="wp-pap-attachment-title"><?php _e('Title', ' portfolio-and-projects'); ?>:</label></th>
				<td>
					<input type="text" name="wp_pap_attachment_title" value="<?php echo wp_pap_esc_attr($attachment_post->post_title); ?>" class="large-text wp-pap-attachment-title" id="wp-pap-attachment-title" />
					<span class="description"><?php _e('Enter image title.', ' portfolio-and-projects'); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="wp-pap-attachment-alt-text"><?php _e('Alternative Text', ' portfolio-and-projects'); ?>:</label></th>
				<td>
					<input type="text" name="wp_pap_attachment_alt" value="<?php echo wp_pap_esc_attr($alt_text); ?>" class="large-text wp-pap-attachment-alt-text" id="wp-pap-attachment-alt-text" />
					<span class="description"><?php _e('Enter image alternative text.', ' portfolio-and-projects'); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="wp-pap-attachment-caption"><?php _e('Caption', ' portfolio-and-projects'); ?>:</label></th>
				<td>
					<textarea name="wp_pap_attachment_caption" class="large-text wp-pap-attachment-caption" id="wp-pap-attachment-caption"><?php echo wp_pap_esc_attr($attachment_post->post_excerpt); ?></textarea>
					<span class="description"><?php _e('Enter image caption.', ' portfolio-and-projects'); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="wp-pap-attachment-desc"><?php _e('Description', ' portfolio-and-projects'); ?>:</label></th>
				<td>
					<textarea name="wp_pap_attachment_desc" class="large-text wp-pap-attachment-desc" id="wp-pap-attachment-desc"><?php echo wp_pap_esc_attr($attachment_post->post_content); ?></textarea>
					<span class="description"><?php _e('Enter image description.', ' portfolio-and-projects'); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="wp-pap-attachment-link"><?php _e('Image Link', ' portfolio-and-projects'); ?>:</label></th>
				<td>
					<input type="text" name="wp_pap_attachment_link" value="<?php echo esc_url($attachment_link); ?>" class="large-text wp-pap-attachment-link" id="wp-pap-attachment-link" />
					<span class="description"><?php _e('Enter image link. e.g http://wponlinesupport.com', ' portfolio-and-projects'); ?></span>
				</td>
			</tr>

			<tr>
				<td colspan="2" align="right">
					<div class="wp-pap-success wp-pap-hide"></div>
					<div class="wp-pap-error wp-pap-hide"></div>
					<span class="spinner wp-pap-spinner"></span>
					<button type="button" class="button button-primary wp-pap-save-attachment-data" data-id="<?php echo $attachment_id; ?>"><i class="dashicons dashicons-yes"></i> <?php _e('Save Changes', ' portfolio-and-projects'); ?></button>
					<button type="button" class="button wp-pap-popup-close"><?php _e('Close', ' portfolio-and-projects'); ?></button>
				</td>
			</tr>
		</table>
	</form><!-- end .wp-pap-attachment-form -->

</div><!-- end .wp-pap-popup-body -->