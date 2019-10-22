<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Wp_Pap_Admin {

	function __construct() {
		
		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'wp_pap_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'wp_pap_save_metabox_value') );

		// Action to add custom column to Gallery listing
		add_filter( 'manage_'.WP_PAP_POST_TYPE.'_posts_columns', array($this, 'wp_pap_posts_columns') );

		// Action to add custom column data to Gallery listing
		add_action('manage_'.WP_PAP_POST_TYPE.'_posts_custom_column', array($this, 'wp_pap_post_columns_data'), 10, 2);

		// Action to add Attachment Popup HTML
		add_action( 'admin_footer', array($this,'wp_pap_image_update_popup_html') );

		// Ajax call to update option
		add_action( 'wp_ajax_wp_pap_get_attachment_edit_form', array($this, 'wp_pap_get_attachment_edit_form'));
		add_action( 'wp_ajax_nopriv_wp_pap_get_attachment_edit_form',array( $this, 'wp_pap_get_attachment_edit_form'));

		// Ajax call to update attachment data
		add_action( 'wp_ajax_wp_pap_save_attachment_data', array($this, 'wp_pap_save_attachment_data'));
		add_action( 'wp_ajax_nopriv_wp_pap_save_attachment_data',array( $this, 'wp_pap_save_attachment_data'));

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'wp_pap_register_menu'), 12 );
	}

	/**
	 * Function to add menu
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_register_menu() {

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.WP_PAP_POST_TYPE, __('Upgrade to PRO - Portfolio and Projects', 'portfolio-and-projects'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'portfolio-and-projects').'</span>', 'manage_options', 'wp-pap-premium', array($this, 'wp_pap_premium_page') );

		// Register plugin hire us page
		add_submenu_page( 'edit.php?post_type='.WP_PAP_POST_TYPE, __('Hire Us', 'portfolio-and-projects'), '<span style="color:#2ECC71">'.__('Hire Us', 'portfolio-and-projects').'</span>', 'manage_options', 'wp-pap-hireus', array($this, 'wp_pap_hireus_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_premium_page() {
		include_once( WP_PAP_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * Hire Us Page Html
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_hireus_page() {		
		include_once( WP_PAP_DIR . '/includes/admin/settings/hire-us.php' );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_post_sett_metabox() {
		
		// Getting all post types
		$all_post_types = array(WP_PAP_POST_TYPE);
	
		add_meta_box( 'wp-pap-post-sett', __( 'Portfolio Gallery', 'portfolio-and-projects' ), array($this, 'wp_pap_post_sett_mb_content'), $all_post_types, 'normal', 'high' );
		
		add_meta_box( 'wp-pap-post-slider-sett', __( 'Slider Parameter', 'portfolio-and-projects' ), array($this, 'wp_pap_post_slider_sett_mb_content'), $all_post_types, 'normal', 'default' );	
		
	}
	
	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_post_sett_mb_content() {
		include_once( WP_PAP_DIR .'/includes/admin/metabox/wp-pap-sett-metabox.php');
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_post_slider_sett_mb_content() {
		include_once( WP_PAP_DIR .'/includes/admin/metabox/wp-pap-slider-parameter.php');
	}
	
	/**
	 * Function to save metabox values
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_save_metabox_value( $post_id ) {

		global $post_type;

		$registered_posts = array(WP_PAP_POST_TYPE); // Getting registered post types

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( !current_user_can('edit_post', $post_id) )              			// Check if user can edit the post.
		|| ( !in_array($post_type, $registered_posts) ) )             			// Check if user can edit the post.
		{
		  return $post_id;
		}

		$prefix = WP_PAP_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$gallery_imgs 	= isset($_POST['wp_pap_img']) 							? wp_pap_slashes_deep($_POST['wp_pap_img']) : '';

		// Getting Slider Variables
		$arrow_slider 		  		= isset($_POST[$prefix.'arrow_slider']) 				? wp_pap_slashes_deep($_POST[$prefix.'arrow_slider']) 				: '';
		$pagination_slider 			= isset($_POST[$prefix.'pagination_slider']) 			? wp_pap_slashes_deep($_POST[$prefix.'pagination_slider']) 			: '';
		$animation_slider 	  		= isset($_POST[$prefix.'animation_slider']) 			? wp_pap_slashes_deep($_POST[$prefix.'animation_slider']) 			: '';
		$project_link 		  		= isset($_POST[$prefix.'project_url']) 					? wp_pap_slashes_deep($_POST[$prefix.'project_url']) 				: '';


		update_post_meta($post_id, $prefix.'gallery_id', $gallery_imgs);
		
		// Updating Slider settings
 		update_post_meta($post_id, $prefix.'arrow_slider', $arrow_slider);
 		update_post_meta($post_id, $prefix.'pagination_slider', $pagination_slider);
 		update_post_meta($post_id, $prefix.'animation_slider', $animation_slider);
 		update_post_meta($post_id, $prefix.'project_url', $project_link);
	}
	
	/**
	 * Add custom column to Post listing page
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_posts_columns( $columns ) {

	    $new_columns['wp_pap_photos'] 		= __('Number of Photos', 'portfolio-and-projects');

	    $columns = wp_pap_add_array( $columns, $new_columns, 1, true );

	    return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_post_columns_data( $column, $post_id ) {

		global $post;

		// Taking some variables
		$prefix = WP_PAP_META_PREFIX;

	    switch ($column) {
	    	case 'wp_pap_photos':
	    		$total_photos = get_post_meta($post_id, $prefix.'gallery_id', true);
	    		echo !empty($total_photos) ? count($total_photos) : '--';
	    		break;
		}
	}

	/**
	 * Image data popup HTML
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_image_update_popup_html() {

		global $post_type;

		$registered_posts = array(WP_PAP_POST_TYPE); // Getting registered post types

		if( in_array($post_type, $registered_posts) ) {
			include_once( WP_PAP_DIR .'/includes/admin/settings/wp-pap-img-popup.php');
		}
	}

	/**
	 * Get attachment edit form
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_get_attachment_edit_form() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= __('Sorry, Something happened wrong.', 'portfolio-and-projects');
		$attachment_id 		= !empty($_POST['attachment_id']) ? trim($_POST['attachment_id']) : '';

		if( !empty($attachment_id) ) {
			$attachment_post = get_post( $_POST['attachment_id'] );

			if( !empty($attachment_post) ) {
				
				ob_start();

				// Popup Data File
				include( WP_PAP_DIR . '/includes/admin/settings/wp-pap-img-popup-data.php' );

				$attachment_data = ob_get_clean();

				$result['success'] 	= 1;
				$result['msg'] 		= __('Attachment Found.', 'portfolio-and-projects');
				$result['data']		= $attachment_data;
			}
		}

		echo json_encode($result);
		exit;
	}

	/**
	 * Get attachment edit form
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_save_attachment_data() {

		$prefix 			= WP_PAP_META_PREFIX;
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= __('Sorry, Something happened wrong.', 'portfolio-and-projects');
		$attachment_id 		= !empty($_POST['attachment_id']) ? trim($_POST['attachment_id']) : '';
		$form_data 			= parse_str($_POST['form_data'], $form_data_arr);

		if( !empty($attachment_id) && !empty($form_data_arr) ) {

			// Getting attachment post
			$wp_pap_attachment_post = get_post( $attachment_id );

			// If post type is attachment
			if( isset($wp_pap_attachment_post->post_type) && $wp_pap_attachment_post->post_type == 'attachment' ) {
				$post_args = array(
									'ID'			=> $attachment_id,
									'post_title'	=> !empty($form_data_arr['wp_pap_attachment_title']) ? $form_data_arr['wp_pap_attachment_title'] : $wp_pap_attachment_post->post_name,
									'post_content'	=> $form_data_arr['wp_pap_attachment_desc'],
									'post_excerpt'	=> $form_data_arr['wp_pap_attachment_caption'],
								);
				$update = wp_update_post( $post_args, $wp_error );

				if( !is_wp_error( $update ) ) {

					update_post_meta( $attachment_id, '_wp_attachment_image_alt', wp_pap_slashes_deep($form_data_arr['wp_pap_attachment_alt']) );
					update_post_meta( $attachment_id, $prefix.'attachment_link', wp_pap_slashes_deep($form_data_arr['wp_pap_attachment_link']) );

					$result['success'] 	= 1;
					$result['msg'] 		= __('Your changes saved successfully.', 'portfolio-and-projects');
				}
			}
		}
		echo json_encode($result);
		exit;
	}
}

$wp_pap_admin = new Wp_Pap_Admin();