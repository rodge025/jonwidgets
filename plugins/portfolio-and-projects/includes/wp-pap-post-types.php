<?php
/**
 * Register Post type functionality
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Function to register post type
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_register_post_type() {
	
	$wp_pap_post_lbls = apply_filters( 'wp_pap_post_labels', array(
								'name'                 	=> __('Projects', 'portfolio-and-projects'),
								'singular_name'        	=> __('Project', 'portfolio-and-projects'),
								'add_new'              	=> __('Add Projects', 'portfolio-and-projects'),
								'add_new_item'         	=> __('Add New Projects', 'portfolio-and-projects'),
								'edit_item'            	=> __('Edit Projects', 'portfolio-and-projects'),
								'new_item'             	=> __('New Project', 'portfolio-and-projects'),
								'view_item'            	=> __('View Projects', 'portfolio-and-projects'),
								'search_items'         	=> __('Search Portfolio/Projects', 'portfolio-and-projects'),
								'not_found'            	=> __('No Portfolio/Projects', 'portfolio-and-projects'),
								'not_found_in_trash'   	=> __('No Portfolio/Projects found in Trash', 'portfolio-and-projects'),								
								'menu_name'           	=> __('Portfolio/Projects', 'portfolio-and-projects')
							));

	$wp_pap_slider_args = array(
		'labels'				=> $wp_pap_post_lbls,
		'public'              	=> true,
		'show_ui'             	=> true,
		'query_var'           	=> false,
		'rewrite'             	=> true,
		'capability_type'     	=> 'post',
		'hierarchical'        	=> false,
		'menu_icon'				=> 'dashicons-format-gallery',
		 'supports'            => array('title','editor','thumbnail')
	);

	// Register slick slider post type
	register_post_type( WP_PAP_POST_TYPE, apply_filters( 'wp_pap_registered_post_type_args', $wp_pap_slider_args ) );
}

// Action to register plugin post type
add_action('init', 'wp_pap_register_post_type');

/**
 * Function to regoster category for portfolio
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */

function wppap_register_taxonomies() {
    
    $cat_labels = apply_filters('wppap_cat_labels', array(
        'name'              => __( 'Category', 'portfolio-and-projects' ),
        'singular_name'     => __( 'Category', 'portfolio-and-projects' ),
        'search_items'      => __( 'Search Category', 'portfolio-and-projects' ),
        'all_items'         => __( 'All Category', 'portfolio-and-projects' ),
        'parent_item'       => __( 'Parent Category', 'portfolio-and-projects' ),
        'parent_item_colon' => __( 'Parent Category:', 'portfolio-and-projects' ),
        'edit_item'         => __( 'Edit Category', 'portfolio-and-projects' ),
        'update_item'       => __( 'Update Category', 'portfolio-and-projects' ),
        'add_new_item'      => __( 'Add New Category', 'portfolio-and-projects' ),
        'new_item_name'     => __( 'New Category Name', 'portfolio-and-projects' ),
        'menu_name'         => __( 'Portfolio Category', 'portfolio-and-projects' ),
    ));
    
    $cat_args = array(
    	'public'			=> false,
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
    );
    
    // Register Logo Showcase category
    register_taxonomy( WP_PAP_CAT, array( WP_PAP_POST_TYPE ), $cat_args );
}

/* Register Taxonomy */
add_action( 'init', 'wppap_register_taxonomies');

/**
 * Function to update post message for portfolio
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_post_updated_messages( $messages ) {
	
	global $post, $post_ID;
	
	$messages[WP_PAP_POST_TYPE] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __( 'Image Gallery updated.', 'portfolio-and-projects' ) ),
		2 => __( 'Custom field updated.', 'portfolio-and-projects' ),
		3 => __( 'Custom field deleted.', 'portfolio-and-projects' ),
		4 => __( 'Image Gallery updated.', 'portfolio-and-projects' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Image Gallery restored to revision from %s', 'portfolio-and-projects' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Image Gallery published.', 'portfolio-and-projects' ) ),
		7 => __( 'Image Gallery saved.', 'portfolio-and-projects' ),
		8 => sprintf( __( 'Image Gallery submitted.', 'portfolio-and-projects' ) ),
		9 => sprintf( __( 'Image Gallery scheduled for: <strong>%1$s</strong>.', 'portfolio-and-projects' ),
		  date_i18n( __( 'M j, Y @ G:i', 'portfolio-and-projects' ), strtotime( $post->post_date ) ) ),
		10 => sprintf( __( 'Image Gallery draft updated.', 'portfolio-and-projects' ) ),
	);
	
	return $messages;
}

// Filter to update slider post message
add_filter( 'post_updated_messages', 'wp_pap_post_updated_messages' );