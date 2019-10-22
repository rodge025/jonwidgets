<?php
/**
 * 
 * @package  Portfolio and Projects
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;



function pap_portfolio_projects_shortcode( $atts, $content = null) {
	
	extract(shortcode_atts(array(
		'limit' 				=> '20',
		'category' 				=> '',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'grid' 					=> 3,
	), $atts));
	

	$posts_per_page 		= !empty($limit) 						? $limit 						: '20';
	$grid 					= !empty($grid) 						? $grid 						: 3;
	$cat 					= (!empty($category))					? explode(',',$category) 		: '';
	$order 					= ( strtolower($order) == 'asc' ) 		? 'ASC' 						: 'DESC';
	$orderby 				= !empty($orderby) 						? $orderby 						: 'date';

	// Thumb conf
	$thumb_conf = compact('grid');

	// Required enqueue_script
	wp_enqueue_script('wpos-slick-jquery');
	wp_enqueue_script('wp-pap-portfolio-js');
	wp_enqueue_script('wp-pap-public-js');

	global $post;
	       			
	 $args = array ( 
            'post_type'      => WP_PAP_POST_TYPE,
            'orderby'        => $orderby, 
            'order'          => $order,
            'posts_per_page' => $posts_per_page,
            );
	     
	if($cat != "") {

		$args['tax_query'] = array(
								array(
									'taxonomy' 	=> WP_PAP_CAT,
									'field' 	=> 'term_id',
									'terms' 	=> $cat
								));

	}
	
    $query 			= new WP_Query($args);
	$post_count 	= $query->post_count;
	$prefix 		= WP_PAP_META_PREFIX;
	$unique_main 	= wp_pap_get_unique_main_thumb();
 	ob_start(); ?>
 	
 	<div class="wppap-main-wrapper">
		
		<ul id="thumbs-<?php echo $unique_main; ?>" class="wppap-thumbs"><?php
				
			while ($query->have_posts()) : $query->the_post();
				
				$unique 	= wp_pap_get_unique();
				$url 		= wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'medium' ); ?>
				
				<li class="thum-list">
					<a href="#thumb<?php echo $unique; ?>" class="wppap-thumbnail" style="background-image: url('<?php echo $url; ?>')">
						<span class="wppap-description"><?php the_title(); ?></span>
					</a>
			    </li>						
			<?php endwhile; ?>
			<div class="thumb-conf"><?php echo json_encode( $thumb_conf ); ?></div>
		</ul>

		<div class="wppap-portfolio-content">
			
			<?php while ($query->have_posts()) : $query->the_post(); 

				$unique_thumb 	= wp_pap_get_unique_thumbs(); ?>
				 
				<div id="thumb<?php echo $unique_thumb; ?>"><?php
					
					$gallery_imgs 	= get_post_meta( $post->ID, $prefix.'gallery_id', true );
					$arrows 		= get_post_meta( $post->ID, $prefix.'arrow_slider', true );
					$arrows 		= ($arrows == 'false') ? 'false' : 'true' ;
					$dots 			= get_post_meta( $post->ID, $prefix.'pagination_slider', true );
					$dots 			= ($dots == 'false') ? 'false' : 'true' ;
					$effect 		= get_post_meta( $post->ID, $prefix.'animation_slider', true );
					$effect 		= ($effect == 'fade') ? 'fade' : 'slide' ;
					$project_url 	= get_post_meta( $post->ID, $prefix.'project_url', true );
					
					// Slider configuration
					$slider_conf = compact('dots', 'arrows','effect');
					
					if( !empty($gallery_imgs) ) { ?>
						<div class="wppap-medium-6 wppap-columns">
							<div class="wppap-slider-wrapper">
								<div id="wppap-slider-<?php echo $unique_thumb; ?>" class="wpapap-portfolio-img-slider thumb<?php echo $unique; ?>"><?php 

									foreach ($gallery_imgs as $img_key => $img_data) {
											$gallery_img_src 	= wp_pap_get_image_src( $img_data,'full'); ?>
											<div class="portfolio-slide">
												<img src="<?php echo $gallery_img_src; ?>">
											</div><?php
									} // End of for each ?>
								</div>
								<div class="wppap-slider-conf"><?php echo json_encode( $slider_conf ); ?></div>
							</div>
						</div>
					<?php } ?>
					<div class="wppap-medium-6 wppap-columns">
				     	<div class="wppap-right-content">
				            <div class="wppap-title"><?php echo get_the_title(); ?></div>
				     
				            <div class="wppap-content"><?php echo get_the_content(); ?></div>
				     
				            <a href="<?php echo $project_url; ?>" class="wppap-project-url-btn" target="_blank">Learn More</a>
			            </div>
		            </div>
		        </div>
			 <?php endwhile;
			  ?>
		</div>
	</div>
	<?php 	wp_reset_query();
			$content .= ob_get_clean();
		    return $content;
}
add_shortcode("pap_portfolio", "pap_portfolio_projects_shortcode");