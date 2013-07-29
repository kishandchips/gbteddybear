<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wp_query;
get_header('shop'); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
		$curr_page = get_queried_page();
	?>
		<div class="content">
		<?php $id = ($curr_page) ? $curr_page->ID : null; ?>
		<?php if ( get_field('content', $id) && !is_product_category()) :?>
		<?php include(locate_template('inc/content.php')); ?>
		<?php else: ?>
			<div class="row">
				<div class="inner clearfix">
					<div class="span seven break-on-mobile">
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h3 class="page-title brown no-margin"><?php woocommerce_page_title(); ?></h3>
							<?php do_action( 'woocommerce_archive_description' ); ?>
						<?php endif; ?>
					</div>
					<?php
					$term = get_term_by('slug', get_query_var('product_cat'), 'product_cat');
					$term_id = (isset($term->term_id)) ? $term->term_id : null;
					?>
					<?php if($term_id != get_gbteddybear_option('all_bears_category_id') && !is_shop()): ?>
					<div class="span three hide-on-mobile">
						<a href="<?php echo get_term_link((int) get_gbteddybear_option('all_bears_category_id'), 'product_cat'); ?>" class="show-all-bears-btn">Show all bears</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		</div>
		<?php if ( have_posts() ) : ?>
			<!-- <div class="options clearfix"> -->
				<?php do_action( 'woocommerce_before_shop_loop' ); ?>
			<!-- </div> -->
			<?php $woocommerce_loop['columns'] = 2; ?>
			<?php woocommerce_product_subcategories(array('before' => '<ul class="top-level-categories categories clearfix">', 'after' => '</ul>')); ?>

				<?php query_posts(array_merge($wp_query->query_vars, array('meta_key' => 'exclude_from_archive', 'meta_value' => 0))); ?>
				<?php if(have_posts()): ?>
				<?php woocommerce_product_loop_start(); ?>
				<?php $woocommerce_loop['loop'] = 0; ?>
				<?php $woocommerce_loop['columns'] = 5; ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php //the_field('exclude_from_archive'); ?>
					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
				<?php woocommerce_product_loop_end(); ?>

				<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>
			<?php endif; ?>
			<?php if(!is_shop()): ?>
			<header class="line-header"><h5 class="title"><?php _e("More Great British Teddy Bears", 'gbteddybear'); ?></h5></header>
			<?php woocommerce_product_categories(array('before' => '<ul class="categories clearfix">', 'after' => '</ul>', 'exclude' => get_gbteddybear_option('all_bears_category_id'), 'woocommerce_loop' => array('columns' => 4))); ?>
			<?php endif; ?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>