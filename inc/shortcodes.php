<?php

add_shortcode( 'base_url', 'base_url_handler' );
function base_url_handler( $atts ) {
	return get_bloginfo('url');
}

add_shortcode( 'uploads_url', 'uploads_url_handler' );
function uploads_url_handler( $atts ) {
	$uploads_dir = wp_upload_dir();
	return $uploads_dir['baseurl'];
}

add_shortcode( 'embed_page', 'embed_page_handler' );
function embed_page_handler( $atts ) {
	global $post;
	$output = '';
    extract(shortcode_atts(array(
        'id'      => '0'
    ), $atts));

    $page = get_post($atts['id']);
	if($page) {
		$output .= '<div class="embed-page">';
		$output .= '<div class="inner">';
		$output .= '<header class="embed-page-header">';
		$output .= '<h3 class="text-center red">'.get_the_title($page->ID).'</h3>';
		$output .= '</header>';
		$output .= '<div class="content">';
		$output .=  apply_filters('the_content', $page->post_content);
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';	
	}
	return $output;
}

remove_shortcode('gallery');
add_shortcode( 'gallery', 'gallery_handler' );
function gallery_handler( $atts ) {
	global $post;
	$output = '';

    extract(shortcode_atts(array(
        'ids'      => array()
    ), $atts));

    $ids = explode(',', $atts['ids']);
   	if(!empty($ids) && 1 == 2){
	    $output .= '<div class="gallery scroller" data-resize="true">';
			$output .= '<div class="scroller-mask">';
			foreach($ids as $id){
				$output .= '<div class="scroll-item" data-id="'.$id.'">';
				$image = wp_get_attachment_image_src($id, 'gallery');
					$output .= '<div class="image">';
						$output .= '<img src="'.$image[0].'" />';
					$output .= '</div>'; 
				$output .= '</div>';	
			}
		    $output .= '</div>';
		    $output .= '<ul class="scroller-pagination">';
		    foreach($ids as $id){
				$output .= '<li>';
				$image = wp_get_attachment_image_src($id, 'gallery_thumbnail');
					$output .= '<div class="image">';
						$output .= '<img src="'.$image[0].'" />';
					$output .= '</div>'; 
				$output .= '</li>';	
			}
		    $output .= '</ul>';

	    $output .= '</div>';
    }
	return $output;
}