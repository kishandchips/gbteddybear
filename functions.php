<?php
/**
 * gbteddybear functions and definitions
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since gbteddybear 1.0
 */

if ( ! function_exists( 'gbteddybear_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since gbteddybear 1.0
 */
function gbteddybear_setup() {
	global $woocommerce;

	require( get_template_directory() . '/inc/custom_post_type.php' );

	require( get_template_directory() . '/inc/shortcodes.php' );

	require( get_template_directory() . '/inc/options.php' );

	require( get_template_directory() . '/inc/widgets/woocommerce-country-select.php' );

	require( get_template_directory() . '/inc/widgets/twitter/twitter-feed.php' );


	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on gbteddybear, use a find and replace
	 * to change 'gbteddybear' to the name of your theme in all the template files
	 */
	//load_theme_textdomain( 'gbteddybear', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary_header' => __( 'Primary Menu', 'gbteddybear' ),
		'primary_footer' => __( 'Footer Menu', 'gbteddybear' )
	) );

	add_image_size( 'custom_large', 530, 650, true);
	add_image_size( 'custom_medium', 380, 250, true);
	add_image_size( 'custom_thumbnail', 210, 9999);
	
	add_filter('jpeg_quality', function($arg){return 100;});

	//add_theme_support( 'post-formats', array( 'gallery' ) );

	add_filter('next_posts_link_attributes', 'posts_link_next_class');
	function posts_link_next_class() {
		return 'class="next-btn"';
	} 
	
	add_filter('previous_posts_link_attributes', 'posts_link_prev_class');
	function posts_link_prev_class() {
		return 'class="prev-btn"';
	}

	add_filter('excerpt_more', 'new_excerpt_more');

	function new_excerpt_more($more) {
		return '...';
	}

	function remove_menus () {
		global $menu;
		$restricted = array(__('Links'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) unset($menu[key($menu)]);
		}
	}

	add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );
	
	function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	    return $html;
	}

	add_action('admin_menu', 'remove_menus');

	add_filter('widget_text', 'do_shortcode');


	$photo = new Custom_Post_Type( 'Photo', 
 		array(
 			'rewrite' => array( 'with_front' => false, 'slug' => get_page_uri(get_gbteddybear_option('gallery_page_id')) ),
 			'capability_type' => 'post',
 		 	'publicly_queryable' => true,
   			'has_archive' => true, 
    		'hierarchical' => false,
    		'exclude_from_search' => true,
    		'menu_position' => null,
    		'supports' => array('title', 'thumbnail', 'page-attributes'),
    		'plural' => 'Photos'
   		)
   	);


	$celebrity_bear = new Custom_Post_Type( 'Celebrity Bear', 
 		array(
 			'rewrite' => array( 'with_front' => false, 'slug' => get_page_uri(get_gbteddybear_option('celebrity_bear_page_id')) ),
 			'capability_type' => 'post',
 		 	'publicly_queryable' => true,
   			'has_archive' => true, 
    		'hierarchical' => false,
    		'exclude_from_search' => true,
    		'menu_position' => null,
    		'supports' => array('title', 'thumbnail', 'page-attributes'),
    		'plural' => 'Celebrity Bears'
   		)
   	);

	
 	//global $wp_rewrite;
	//$wp_rewrite->flush_rules();
	//add_rewrite_rule('case-studies/([^/]+)?', 'index.php?post_type=true&work=$matches[1]', 'top');
   	//$shop->add_taxonomy('Shop Category', array('hierarchical' => true), array('plural' => 'Shop Categories'));

	add_editor_style('css/editor-styles.css');

	add_filter("gform_tabindex", create_function("", "return false;"));

	add_theme_support('woocommerce');  

}
endif; // gbteddybear_setup

add_action( 'after_setup_theme', 'gbteddybear_setup' );


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since gbteddybear 1.0
 */
function gbteddybear_widgets_init() {

	/********************** Sidebars ***********************/

	register_sidebar( array(
		'name' => __( 'Default Sidebar', 'gbteddybear' ),
		'id' => 'default',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer', 'gbteddybear' ),
		'id' => 'footer',
		'before_widget' => '<aside id="%1$s" class="widget span two equal-height %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

	/********************** Content ***********************/

	register_sidebar( array(
		'name' => __( 'Homepage Content', 'gbteddybear' ),
		'id' => 'homepage_content',
		'before_widget' => '<aside id="%1$s" class="widget span one-third %2$s">',
		'after_widget' => '</div></aside>',
		'before_title' => '<h5 class="widget-title text-center light-brown uppercase">',
		'after_title' => '</h5><div class="inner equal-height">',
	) );


}

add_action( 'widgets_init', 'gbteddybear_widgets_init' );


if ( ! function_exists( 'get_top_level_category' )) {
	function get_top_level_category($id, $taxonomy = 'category'){
		$term = get_top_level($taxonomy, $id);
		$term_id = ($term) ? $term : $id;
		return get_term_by( 'id', $term_id, $taxonomy);
	}
}


if ( ! function_exists( 'get_top_level' )) {
	function get_top_level($object, $id){
		$terms = get_ancestors($id, $object);
		return (!empty($terms)) ? $terms[count($terms) - 1] : null;
	}
}

if ( ! function_exists( 'get_sub_category' )) {
	function get_sub_category($id){
		$sub_categories = get_categories( array('child_of' => $id, 'hierarchical' => false, 'orderby' => 'count'));
		foreach($sub_categories as $sub_category){
			if(has_category($sub_category->term_id)){
				$category = $sub_category;
			}
		}

		return (isset($category)) ? $category : null;
	}
}

function get_the_adjacent_fukn_post($adjacent, $post_type = 'post', $category = array(), $post_parent = 0){
	global $post;
	$args = array( 
		'post_type' => $post_type,
		'order' => 'ASC', 
		'posts_per_page' => -1,
		'category__in' => $category,
		'post_parent' => $post_parent
	);
	
	$curr_post = $post;
	$new_post = NULL;
	$custom_query = new WP_Query($args);
	$posts = $custom_query->get_posts();
	$total_posts = count($posts);
	$i = 0;
	foreach($posts as $a_post) {
		if($a_post->ID == $curr_post->ID){
			if($adjacent == 'next'){
				$new_i = ($i + 1 >= $total_posts) ? 0 : $i + 1; 
				$new_post = $posts[$new_i];	
			} else {
				$new_i = ($i - 1 <= 0) ? $total_posts - 1 : $i - 1; 
				$new_post = $posts[$new_i];	
			}
			break;	
		}
		$i++;
	}
	
	return $new_post;
}

function get_gbteddybear_option($option){
	$options = get_option('gbteddybear_theme_options');
	return $options[$option];
}

if ( ! function_exists( 'get_latest_post' )) {
	function get_latest_post() {
		$posts = get_posts(array('posts_per_page' => 1));
		return $posts[0];
	}
}

if ( ! function_exists( 'get_limited_content' )) {
	function get_limited_content($limit) {
		$content = get_the_content();
		$content = strip_shortcodes($content);
		$content = strip_tags($content);
		return substr($content, 0, $limit).'...';
	}
}

add_action('wp_nav_menu_objects', 'nav_check_sub_nav', 10, 2);

function nav_check_sub_nav($items, $args){
	if(isset($args->child_of)){
		$parent_menu_item = null;
		$menu_items = array();
		foreach($items as $item){
			if($item->object_id == $args->child_of){
				$parent_menu_item = $item;
				break;
			}
		}

		if($parent_menu_item){
			foreach($items as $item){
				if(isset($item->menu_item_parent) && $item->menu_item_parent == $parent_menu_item->ID){
					$menu_items[] = $item;
				}	
			}
		}
		return $menu_items;
	} else {
		return $items;
	}
}

add_action('nav_menu_css_class', 'nav_add_classes', 10, 2);

function nav_add_classes($classes, $item){
	$slug = str_replace(array(get_option('home')), '', $item->url);
	$current_slug = str_replace(array(get_option('home')), '', get_current_url());
	if (strpos($current_slug, $slug) !== false && $slug != '/') {
		$classes[] = 'current';
	}

	return $classes;
}

if ( ! function_exists( 'get_current_url' )) {
	function get_current_url() {
		$url = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $url .= 's';
			$url .= '://';

		if ($_SERVER['SERVER_PORT'] != '80') {
			$url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		} else {
			$url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		return $url;
	}
}


add_action("gform_field_standard_settings", "custom_gform_standard_settings", 10, 2);
function custom_gform_standard_settings($position, $form_id){
    if($position == 25){
    	?>
        <li style="display: list-item; ">
            <label for="field_placeholder">Placeholder Text</label>
            <input type="text" id="field_placeholder" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
        </li>
        <?php
    }
}

add_action('gform_enqueue_scripts',"custom_gform_enqueue_scripts", 10, 2);
function custom_gform_enqueue_scripts($form, $is_ajax=false){
    ?>
<script>
    jQuery(function(){
        <?php
        foreach($form['fields'] as $i=>$field){
            if(isset($field['placeholder']) && !empty($field['placeholder'])){
                ?>
                jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
                <?php
            }
        }
        ?>
    });
    </script>
    <?php
}

add_action('tiny_mce_before_init', 'custom_tinymce_options'); 

if ( ! function_exists( 'custom_tinymce_options' )) { 
	function custom_tinymce_options($init){ 
		$init['apply_source_formatting'] = true; 
		return $init; 
	} 
}


function get_queried_page(){
	$curr_url = get_current_url();

	$curr_uri = str_replace(get_bloginfo('url'), '', $curr_url);
	$page = get_page_by_path($curr_uri);
	if($page) return $page;
	return null;
}

function add_grav_forms(){
	$role = get_role('editor');
	$role->add_cap('gform_full_access');

	$role = get_role('shop_manager');
	$role->add_cap('gform_full_access');
}
add_action('admin_init','add_grav_forms');


remove_action( 'woocommerce_before_subcategory_title' , 'woocommerce_subcategory_thumbnail', 10);
add_action( 'woocommerce_before_subcategory_title', 'custom_subcategory_thumbnail', 10);
if ( ! function_exists( 'custom_subcategory_thumbnail' ) ) {
	function custom_subcategory_thumbnail($category){
		global $woocommerce;
		$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
		$mobile_thumbnail_id  	= get_field('mobile_thumbnail_id', 'product_cat_'.$category->term_id);
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = woocommerce_placeholder_img_src();
		}

		if($mobile_thumbnail_id){
			$mobile_image = wp_get_attachment_image_src( $mobile_thumbnail_id, $small_thumbnail_size  );
			$mobile_image = $mobile_image[0];
		} else {
			$mobile_image = $image;
		}

		if(is_shop()) {
			if ( $image)
				echo '<img class="large category-image" src="' . $image . '" alt="' . $category->name . '"/>';

			if ( $mobile_image )
				echo '<img class="small category-image" src="' . $mobile_image . '" alt="' . $category->name . '"/>';
		} else {
			if ( $mobile_image )
				echo '<img class="category-image" src="' . $mobile_image . '" alt="' . $category->name . '"/>';

		}
	}
}

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_show_messages', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_loop_product_thumbnail', 10 );


if ( ! function_exists( 'custom_loop_product_thumbnail' ) ) {

	function custom_loop_product_thumbnail() {
		global $post;
		$size = 'thumbnail';
		if ( has_post_thumbnail() )
			echo get_the_post_thumbnail( $post->ID, $size );
		elseif ( woocommerce_placeholder_img_src() ){
			echo woocommerce_placeholder_img( 'shop_thumbnail' );
		}
	}
}

add_filter('single_add_to_cart_text', 'custom_add_to_cart_text');

if ( ! function_exists( 'custom_add_to_cart_text' ) ) {

	function custom_add_to_cart_text( $text ) {
		return '<i class="icon-shopping-bag"></i>&nbsp;&nbsp;'.__("Add to shopping bag", 'gbteddybear');
	}
}


if ( ! function_exists( 'woocommerce_product_categories' ) ) {

	function woocommerce_product_categories( $args = array() ) {
		global $woocommerce, $wp_query, $woocommerce_loop;

		$defaults = array(
			'before'  => '',
			'after'  => '',
			'force_display' => false,
			'exclude' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		extract( $args );
	
		$term 			= get_queried_object();
		$parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

		
		$args = array(
			'child_of'		=> 0,
			'menu_order'	=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'taxonomy'		=> 'product_cat',
			'pad_counts'	=> 1,
			'exclude'		=> $exclude
		);
		$product_categories = get_categories( apply_filters( 'woocommerce_product_categories_args', $args ) );
		$product_category_found = false;
		
		if ( $product_categories ) {

			foreach ( $product_categories as $category ) {
				
				if ( ! $product_category_found ) {
					// We found a category
					$product_category_found = true;
					echo $before;
				}

				woocommerce_get_template( 'content-product_cat.php', array(
					'category' => $category
				) );

			}

		}

		
		wp_reset_query();
		echo $after;
		return true;
	}
}


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'custom_template_single_product_delivery', 40 );

if ( ! function_exists( 'custom_template_single_product_delivery' ) ) {

	function custom_template_single_product_delivery( ) {
		woocommerce_get_template( 'single-product/delivery.php' );
	}
}


add_filter( 'woocommerce_product_description_heading', 'custom_product_description_heading'); 


if ( ! function_exists( 'custom_product_description_heading' ) ) {

	function custom_product_description_heading( ) {
		return __("More about this bear", 'gbteddybear');
	}
}



add_filter( 'woocommerce_product_tabs', 'custom_product_tabs' );


if ( ! function_exists( 'custom_product_tabs' ) ) {

	function custom_product_tabs( $tabs) {
		$tabs['description'] = array(
			'title'    => __( 'Description', 'woocommerce' ),
			'priority' => 10,
			'callback' => 'woocommerce_product_description_tab'
		);

		return $tabs;
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'custom_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'custom_related_products', 20 );


if ( ! function_exists( 'custom_related_products' ) ) {

	function custom_related_products() {
		woocommerce_related_products( -1, 5 );
	}
}

if ( ! function_exists( 'custom_upsell_display' ) ) {

	function custom_upsell_display() {
		woocommerce_upsell_display( -1, 5 );
	}
}

remove_action( 'woocommerce_view_order', 'woocommerce_order_details_table', 10 );
add_action( 'woocommerce_view_order', 'custom_order_details', 10 );


if ( ! function_exists( 'custom_order_details' ) ) {

	function custom_order_details( $order_id  ) {
		if ( ! $order_id ) return;

		woocommerce_get_template( 'order/order.php', array(
			'order_id' => $order_id
		) );
	}
}


add_filter( 'woocommerce_product_thumbnails_columns', 'custom_product_thumbnails_columns', 3 );

if ( ! function_exists( 'custom_product_thumbnails_columns' ) ) {

	function custom_product_thumbnails_columns(   ) {
		return 6;
	}
}

add_filter('loop_shop_columns', 'custom_loop_columns');
if (!function_exists('custom_loop_columns')) {
	function custom_loop_columns() {
		return 5;
	}
}


add_action('woocommerce_init', 'custom_woocommerce_init');

if (!function_exists('custom_woocommerce_init')) {
	function custom_woocommerce_init() {
		global $woocommerce;
		if(isset($_POST['calc_shipping']) && $_POST['calc_shipping'] == '1'){
			$country = (isset($_POST['calc_shipping_country'])) ? $_POST['calc_shipping_country'] : '';
			$woocommerce->customer->set_country($country);
			$woocommerce->customer->set_shipping_country($country);
			$currency = get_currency_from_country($country);
			setcookie($currency, 'woocommerce_current_currency', time()+3600);	
		}
	}
}

if ( ! function_exists( 'get_currency_from_country' ) ) {

	function get_currency_from_country($country) {

		$currencies = array(
			'AF' => 'AFA', 'AL' => 'ALL', 'DZ' => 'DZD', 'AS' => 'USD', 'AD' => 'EUR', 'AO' => 'AOA', 'AI' => 'XCD', 'AQ' => 'NOK', 'AG' => 'XCD', 'AR' => 'ARA', 'AM' => 'AMD', 'AW' => 'AWG', 'AU' => 'AUD', 'AT' => 'EUR', 'AZ' => 'AZM', 'BS' => 'BSD', 'BH' => 'BHD', 'BD' => 'BDT', 'BB' => 'BBD', 'BY' => 'BYR', 'BE' => 'EUR', 'BZ' => 'BZD', 'BJ' => 'XAF', 'BM' => 'BMD', 'BT' => 'BTN', 'BO' => 'BOB', 'BA' => 'BAM', 'BW' => 'BWP', 'BV' => 'NOK', 'BR' => 'BRL', 'IO' => 'GBP', 'BN' => 'BND', 'BG' => 'BGN', 'BF' => 'XAF', 'BI' => 'BIF', 'KH' => 'KHR', 'CM' => 'XAF', 'CA' => 'CAD', 'CV' => 'CVE', 'KY' => 'KYD', 'CF' => 'XAF', 'TD' => 'XAF', 'CL' => 'CLF', 'CN' => 'CNY', 'CX' => 'AUD', 'CC' => 'AUD', 'CO' => 'COP', 'KM' => 'KMF', 'CD' => 'CDZ', 'CG' => 'XAF', 'CK' => 'NZD', 'CR' => 'CRC', 'HR' => 'HRK', 'CU' => 'CUP', 'CY' => 'EUR', 'CZ' => 'CZK', 'DK' => 'DKK', 'DJ' => 'DJF', 'DM' => 'XCD', 'DO' => 'DOP', 'TP' => 'TPE', 'EC' => 'USD', 'EG' => 'EGP', 'SV' => 'USD', 'GQ' => 'XAF', 'ER' => 'ERN', 'EE' => 'EEK', 'ET' => 'ETB', 'FK' => 'FKP', 'FO' => 'DKK', 'FJ' => 'FJD', 'FI' => 'EUR', 'FR' => 'EUR', 'FX' => 'EUR', 'GF' => 'EUR', 'PF' => 'XPF', 'TF' => 'EUR', 'GA' => 'XAF', 'GM' => 'GMD', 'GE' => 'GEL', 'DE' => 'EUR', 'GH' => 'GHC', 'GI' => 'GIP', 'GR' => 'EUR', 'GL' => 'DKK', 'GD' => 'XCD', 'GP' => 'EUR', 'GU' => 'USD', 'GT' => 'GTQ', 'GN' => 'GNS', 'GW' => 'GWP', 'GY' => 'GYD', 'HT' => 'HTG', 'HM' => 'AUD', 'VA' => 'EUR', 'HN' => 'HNL', 'HK' => 'HKD', 'HU' => 'HUF', 'IS' => 'ISK', 'IN' => 'INR', 'ID' => 'IDR', 'IR' => 'IRR', 'IQ' => 'IQD', 'IE' => 'EUR', 'IL' => 'ILS', 'IT' => 'EUR', 'CI' => 'XAF', 'JM' => 'JMD', 'JP' => 'JPY', 'JO' => 'JOD', 'KZ' => 'KZT', 'KE' => 'KES', 'KI' => 'AUD', 'KP' => 'KPW', 'KR' => 'KRW', 'KW' => 'KWD', 'KG' => 'KGS', 'LA' => 'LAK', 'LV' => 'LVL', 'LB' => 'LBP', 'LS' => 'LSL', 'LR' => 'LRD', 'LY' => 'LYD', 'LI' => 'CHF', 'LT' => 'LTL', 'LU' => 'EUR', 'MO' => 'MOP', 'MK' => 'MKD', 'MG' => 'MGF', 'MW' => 'MWK', 'MY' => 'MYR', 'MV' => 'MVR', 'ML' => 'XAF', 'MT' => 'EUR', 'MH' => 'USD', 'MQ' => 'EUR', 'MR' => 'MRO', 'MU' => 'MUR', 'YT' => 'EUR', 'MX' => 'MXN', 'FM' => 'USD', 'MD' => 'MDL', 'MC' => 'EUR', 'MN' => 'MNT', 'MS' => 'XCD', 'MA' => 'MAD', 'MZ' => 'MZM', 'MM' => 'MMK', 'NA' => 'NAD', 'NR' => 'AUD', 'NP' => 'NPR', 'NL' => 'EUR', 'AN' => 'ANG', 'NC' => 'XPF', 'NZ' => 'NZD', 'NI' => 'NIC', 'NE' => 'XOF', 'NG' => 'NGN', 'NU' => 'NZD', 'NF' => 'AUD', 'MP' => 'USD', 'NO' => 'NOK', 'OM' => 'OMR', 'PK' => 'PKR', 'PW' => 'USD', 'PA' => 'PAB', 'PG' => 'PGK', 'PY' => 'PYG', 'PE' => 'PEI', 'PH' => 'PHP', 'PN' => 'NZD', 'PL' => 'PLN', 'PT' => 'EUR', 'PR' => 'USD', 'QA' => 'QAR', 'RE' => 'EUR', 'RO' => 'ROL', 'RU' => 'RUB', 'RW' => 'RWF', 'KN' => 'XCD', 'LC' => 'XCD', 'VC' => 'XCD', 'WS' => 'WST', 'SM' => 'EUR', 'ST' => 'STD', 'SA' => 'SAR', 'SN' => 'XOF', 'CS' => 'EUR', 'SC' => 'SCR', 'SL' => 'SLL', 'SG' => 'SGD', 'SK' => 'EUR', 'SI' => 'EUR', 'SB' => 'SBD', 'SO' => 'SOS', 'ZA' => 'ZAR', 'GS' => 'GBP', 'ES' => 'EUR', 'LK' => 'LKR', 'SH' => 'SHP', 'PM' => 'EUR', 'SD' => 'SDG', 'SR' => 'SRG', 'SJ' => 'NOK', 'SZ' => 'SZL', 'SE' => 'SEK', 'CH' => 'CHF', 'SY' => 'SYP', 'TW' => 'TWD', 'TJ' => 'TJR', 'TZ' => 'TZS', 'TH' => 'THB', 'TG' => 'XAF', 'TK' => 'NZD', 'TO' => 'TOP', 'TT' => 'TTD', 'TN' => 'TND', 'TR' => 'TRY', 'TM' => 'TMM', 'TC' => 'USD', 'TV' => 'AUD', 'UG' => 'UGS', 'UA' => 'UAH', 'SU' => 'SUR', 'AE' => 'AED', 'GB' => 'GBP', 'US' => 'USD', 'UM' => 'USD', 'UY' => 'UYU', 'UZ' => 'UZS', 'VU' => 'VUV', 'VE' => 'VEF', 'VN' => 'VND', 'VG' => 'USD', 'VI' => 'USD', 'WF' => 'XPF', 'XO' => 'XOF', 'EH' => 'MAD', 'ZM' => 'ZMK', 'ZW' => 'USD'
		);

		return $currencies[$country];
	}
}

add_filter( 'loop_shop_per_page', 'custom_shop_per_page', 20 );

function custom_shop_per_page($columns){
	return 20;
}


add_filter('woocommerce_gateway_icon', 'custom_gateway_icon', 20, 3);

if ( ! function_exists( 'custom_gateway_icon' ) ) {
	function custom_gateway_icon($icon, $id){
		if($id == 'sagepaydirect'){
			$icon = '';
			$sage_payment_gateway = new DS_Sagepay_Direct();
			$available_cardtypes = explode(',', SAGEPAY_CARDTYPES);
            for ($i = 0; $i < count($available_cardtypes); $i += 2){
                if($sage_payment_gateway->settings['cardtype-' . $available_cardtypes[$i]] == 'yes'){
                    $card = strtolower($available_cardtypes[$i]);
                    if(file_exists(get_template_directory().'/images/icons/cards/'.$card.'.png')){
	                	$icon .= '<img src="'.get_stylesheet_directory_uri().'/images/icons/cards/'.$card.'.png" />';
    				}
            	}
            }
		}
		return $icon;
	}
}

add_filter('woocommerce_product_related_posts', 'custom_product_related_posts', 20);

if ( ! function_exists( 'custom_product_related_posts' ) ) {
	function custom_product_related_posts($args){

		if(isset($args['orderby'])){
			$args['orderby'] = 'menu_order';
		}
		if(isset($args['tax_query'][0]['terms'])){
			$terms = $args['tax_query'][0]['terms'];
			$args['tax_query'][0]['terms'] = array();
			foreach($terms as $term){
				if($term != get_gbteddybear_option('all_bears_category_id')){
					$args['tax_query'][0]['terms'][] = $term;
				}
			}
		}

		return $args;
	}
}

add_filter( 'comment_text', 'custom_comment_text'); 

if ( ! function_exists( 'custom_comment_text' ) ) {
	function custom_comment_text($comment){
		return $comment.'&nbsp;&nbsp;&nbsp;&nbsp;<i aria-hidden="hidden" class="icon-close-quote light-grey"></i>';
	}
}


add_filter( 'woocommerce_stock_html', 'custom_stock_html', 1 );

if ( ! function_exists( 'custom_stock_html' ) ) {
	function custom_stock_html($availability){
		return str_replace('Out of stock', 'Sorry this item is currently unavailable.</p><p class="small">If you would like to preorder please contact <a href="'.get_permalink(get_gbteddybear_option('customer_service_page_id')).'">Customer Service</a>', $availability);
	}
}


add_action('woocommerce_check_cart_items', 'woocommerce_ready');

if ( ! function_exists( 'woocommerce_ready' ) ) {
	function woocommerce_ready(){
		global $woocommerce;
		if ($woocommerce->cart->cart_contents_count > 24){
			$woocommerce->add_error(__('Sorry, it seems that there are no available shipping methods for your location.<br />If you require assistance or wish to make alternate arrangements please contact <a href="'.get_permalink(get_gbteddybear_option('customer_service_page_id')).'">customer service</a>.'));
		}
	}
}

add_action('gform_after_submission_1', 'mark_emails_as_read', 10, 2);

if ( ! function_exists( 'mark_emails_as_read' ) ) {
	function mark_emails_as_read($entry, $form){
		if(isset($entry['id'])){
			RGFormsModel::update_lead_property($entry['id'], 'is_read', 1);
 		}
 	}
}


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
add_action( 'woocommerce_after_product_images', 'woocommerce_template_single_sharing', 30);


//remove_action( 'woocommerce_share', array( $WC_ShareThis, 'sharethis_code' ) );


add_action('woocommerce_after_checkout_validation', 'custom_checkout_validation', 10, 1);

function custom_checkout_validation($posted){
	global $woocommerce;
	$fields = array(
		array(
			'title' => __("Billing Title"),
			'name' => 'billing_title',
			'max_characters' => 15
		),
		array(
			'title' => __("Billing First Name"),
			'name' => 'billing_first_name',
			'max_characters' => 15
		),
		array(
			'title' => __("Billing Last Name"),
			'name' => 'billing_last_name',
			'max_characters' => 25
		),
		array(
			'title' => __("Billing Company"),
			'name' => 'billing_company',
			'max_characters' => 50
		),
		array(
			'title' => __("Billing Address - Line 1"),
			'name' => 'billing_address_1',
			'max_characters' => 35
		),
		array(
			'title' => __("Billing Address - Line 2"),
			'name' => 'billing_address_2',
			'max_characters' => 35
		),
		array(
			'title' => __("Billing Country"),
			'name' => 'billing_country',
			'max_characters' => 2
		),
		array(
			'title' => __("Billing Postcode"),
			'name' => 'billing_postcode',
			'max_characters' => 8
		),
		array(
			'title' => __("Billing Email"),
			'name' => 'billing_email',
			'max_characters' => 50
		),
		array(
			'title' => __("Billing Title"),
			'name' => 'billing_phone',
			'max_characters' => 35
		),
		
		array(
			'title' => __("Shipping Title"),
			'name' => 'shipping_title',
			'max_characters' => 15
		),
		array(
			'title' => __("Shipping First Name"),
			'name' => 'shipping_first_name',
			'max_characters' => 15
		),
		array(
			'title' => __("Shipping Last Name"),
			'name' => 'shipping_last_name',
			'max_characters' => 25
		),
		array(
			'title' => __("Shipping Company"),
			'name' => 'shipping_company',
			'max_characters' => 50
		),
		array(
			'title' => __("Shipping Address - Line 1"),
			'name' => 'shipping_address_1',
			'max_characters' => 35
		),
		array(
			'title' => __("Shipping Address - Line 2"),
			'name' => 'shipping_address_2',
			'max_characters' => 35
		),
		array(
			'title' => __("Shipping Country"),
			'name' => 'shipping_country',
			'max_characters' => 2
		),
		array(
			'title' => __("Shipping Postcode"),
			'name' => 'shipping_postcode',
			'max_characters' => 8
		)
	);
	foreach($fields as $field){
		if(isset($posted[$field['name']]) && strlen($posted[$field['name']]) > $field['max_characters']){
			$message = sprintf(__("%s, is too long. Please reduce down to a maximum of %d characters"), $field['title'], $field['max_characters']);
			$woocommerce->add_error($message);
		}
	}
}