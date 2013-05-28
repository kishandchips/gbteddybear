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

	require( get_template_directory() . '/inc/custom_post_type.php' );

	require( get_template_directory() . '/inc/shortcodes.php' );

	require( get_template_directory() . '/inc/options.php' );

	require( get_template_directory() . '/inc/widgets/woocommerce-country-select.php' );

	require( get_template_directory() . '/inc/widgets/twitter-feed.php' );


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
		'primary_header' => __( 'Primary Menu', 'gbteddybear' )
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
		$restricted = array(__('Links'),__('Comments'));
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


	// $company = new Custom_Post_Type( 'Company', 
 // 		array(
 // 			'rewrite' => array( 'with_front' => false, 'slug' => get_page_uri(get_gbteddybear_option('companies_page_id')) ),
 // 			'capability_type' => 'post',
 //		 		'publicly_queryable' => true,
 //   			'has_archive' => true, 
 //    		'hierarchical' => false,
 //    		'exclude_from_search' => false,
 //    		'menu_position' => null,
 //    		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
 //    		'plural' => 'Companies'
 //   		)
 //   	);


 	// global $wp_rewrite;
	// $wp_rewrite->flush_rules();
	//add_rewrite_rule('case-studies/([^/]+)?', 'index.php?post_type=true&work=$matches[1]', 'top');
   	//$shop->add_taxonomy('Shop Category', array('hierarchical' => true), array('plural' => 'Shop Categories'));

	add_editor_style('css/editor-styles.css');

	add_filter("gform_tabindex", create_function("", "return false;"));
   
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


function add_grav_forms(){
	$role = get_role('editor');
	$role->add_cap('gform_full_access');
}
add_action('admin_init','add_grav_forms');




