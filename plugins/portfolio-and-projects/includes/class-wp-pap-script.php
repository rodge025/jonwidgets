<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class WP_pap_Script {
	
	function __construct() {
		
		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wp_pap_front_style') );
		
		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wp_pap_front_script') );
		
		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'wp_pap_admin_style') );
		
		// Action to add script at admin side
		add_action( 'admin_enqueue_scripts', array($this, 'wp_pap_admin_script') );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_front_style() {


		// Registring and enqueing slick css		
		if( !wp_style_is( 'wpos-slick-style', 'registered' ) ) {
			wp_register_style( 'wpos-slick-style', WP_PAP_URL.'assets/css/slick.css', array(), WP_PAP_VERSION );
			wp_enqueue_style( 'wpos-slick-style');	
		}
		
		
		// Registring and enqueing public css
		wp_register_style( 'wp-pap-public-css', WP_PAP_URL.'assets/css/wp-pap-public.css', null, WP_PAP_VERSION );
		wp_enqueue_style( 'wp-pap-public-css' );
		
		// Registring and enqueing public css
		wp_register_style( 'wp-pap-portfolio-css', WP_PAP_URL.'assets/css/portfolio.jquery.css', null, WP_PAP_VERSION );
		wp_enqueue_style( 'wp-pap-portfolio-css' );
	}
	
	/**
	 * Function to add script at front side
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_front_script() {

		
		// Registring slick slider script
		// Registring slick slider script
		if( !wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
			wp_register_script( 'wpos-slick-jquery', WP_PAP_URL. 'assets/js/slick.min.js', array('jquery'), WP_PAP_VERSION, true);
		}
		

		// Registring public script
		wp_register_script( 'wp-pap-public-js', WP_PAP_URL.'assets/js/wp-pap-public.js', array('jquery'), WP_PAP_VERSION, true );
		wp_localize_script( 'wp-pap-public-js', 'WpPap', array(
															'is_mobile' 		=>	(wp_is_mobile()) ? 1 : 0,
															'is_rtl' 			=>	(is_rtl()) ? 1 : 0,
														));
		
		// Registring public script
		wp_register_script( 'wp-pap-portfolio-js', WP_PAP_URL.'assets/js/wp-pap-portfolio.js', array('jquery'), WP_PAP_VERSION, true );
	}
	
	/**
	 * Enqueue admin styles
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_admin_style( $hook ) {

		global $post_type, $typenow;
		
		$registered_posts = array(WP_PAP_POST_TYPE); // Getting registered post types

		// If page is plugin setting page then enqueue script
		if( in_array($post_type, $registered_posts) ) {
			
			// Registring admin script
			wp_register_style( 'wp-pap-admin-style', WP_PAP_URL.'assets/css/wp-pap-admin.css', null, WP_PAP_VERSION );
			wp_enqueue_style( 'wp-pap-admin-style' );
		}
	}

	/**
	 * Function to add script at admin side
	 * 
	 * @package Portfolio and Projects
	 * @since 1.0.0
	 */
	function wp_pap_admin_script( $hook ) {
		
		global $wp_version, $wp_query, $typenow, $post_type;
		
		$registered_posts = array(WP_PAP_POST_TYPE); // Getting registered post types
		$new_ui = $wp_version >= '3.5' ? '1' : '0'; // Check wordpress version for older scripts
		
		if( in_array($post_type, $registered_posts) ) {

			// Enqueue required inbuilt sctipt
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Registring admin script
			wp_register_script( 'wp-pap-admin-script', WP_PAP_URL.'assets/js/wp-pap-admin.js', array('jquery'), WP_PAP_VERSION, true );
			wp_localize_script( 'wp-pap-admin-script', 'WppapAdmin', array(
																	'new_ui' 				=>	$new_ui,
																	'img_edit_popup_text'	=> __('Edit Image in Popup', 'swiper-slider-and-carousel'),
																	'attachment_edit_text'	=> __('Edit Image', 'swiper-slider-and-carousel'),
																	'img_delete_text'		=> __('Remove Image', 'swiper-slider-and-carousel'),
																));
			wp_enqueue_script( 'wp-pap-admin-script' );
			wp_enqueue_media(); // For media uploader
		}
	}
}

$wp_pap_script = new WP_pap_Script();