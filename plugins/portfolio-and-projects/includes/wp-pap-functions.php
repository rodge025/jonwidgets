<?php
/**
 * Plugin generic functions file
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_esc_attr($data) {
    return esc_attr( stripslashes($data) );
}

/**
 * Strip Slashes From Array
 *
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_slashes_deep($data = array(), $flag = false) {
  
    if($flag != true) {
        $data = wp_pap_nohtml_kses($data);
    }
    $data = stripslashes_deep($data);
    return $data;
}

/**
 * Strip Html Tags 
 * 
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */

function wp_pap_nohtml_kses($data = array()) {
  
  if ( is_array($data) ) {
    
    $data = array_map('wp_pap_nohtml_kses', $data);
    
  } elseif ( is_string( $data ) ) {
    $data = trim( $data );
    $data = wp_filter_nohtml_kses($data);
  }
  
  return $data;
}

/**
 * Function to unique number value
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_get_unique() {
	
    static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to unique number value
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_get_unique_thumbs() {
    
    static $unique1 = 0;
    $unique1++;

    return $unique1;
}

/**
 * Function to unique number value
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_get_unique_main_thumb() {
    
    static $unique2 = 0;
    $unique2++;

    return $unique2;
}

/**
 * Function to add array after specific key
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_add_array(&$array, $value, $index, $from_last = false) {
    
    if( is_array($array) && is_array($value) ) {

        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }
        
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }
    
    return $array;
}

/**
 * Function to get post featured image
 * 
 * @package Portfolio and Projects
 * @since 1.0.0
 */
function wp_pap_get_image_src( $post_id = '', $size = 'full' ) {
    $size   = !empty($size) ? $size : 'full';
    $image  = wp_get_attachment_image_src( $post_id, $size );

    if( !empty($image) ) {
        $image = isset($image[0]) ? $image[0] : '';
    }

    return $image;
}