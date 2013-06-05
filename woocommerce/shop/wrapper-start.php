<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wp_query;
$curr_page = get_queried_page();
$id = ($curr_page) ? $curr_page->ID : null;
$classes = array();
$queried_object = $wp_query->get_queried_object();

if($id == get_option('woocommerce_shop_page_id')) {
	$shop_display = get_option('woocommerce_shop_page_display');
	switch($shop_display){
		case 'subcategories':
			$classes[] = 'archive-category';
			break;
		case 'both': 
			$classes[] = 'archive-category';
			$classes[] = 'archive-product';
		default:
			$classes[] = 'archive-product';
	}
} elseif(isset($queried_object->taxonomy) && $queried_object->taxonomy == 'product_cat') {
	$classes[] = 'archive-sub-category';
}

$classes = ($id) ? get_post_class($classes, $id) : $classes;
?>

<div id="woocommerce"><div class="container"><div class="woocommerce <?php if(!empty($classes)) echo implode(' ', $classes); ?>">