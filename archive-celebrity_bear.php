<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */
global $wp_query;
get_header(); ?>
<?php query_posts(array_merge($wp_query->query_vars, array('orderby' => 'menu_order', 'order' => 'ASC'))); ?>
<div id="archive-celebrity-bear" class="container">
	<div class="inner">
		<?php $curr_page = get_queried_page(); ?>
		
		<div id="celebrity-bears">
			<div class="content">
				<?php $id = ($curr_page) ? $curr_page->ID : null; ?>
				<?php if ( get_field('content', $id)) include(locate_template('inc/content.php')); ?>
			</div>
			<ul class="celebrity-bear-list clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="item celebrity-bear">
					<div class="thumbnail">
						<?php the_post_thumbnail('medium', array('class' => 'scale')); ?>
					</div>
					<h5 class="text-center"><?php the_title(); ?></h5>
				</li>
			<?php endwhile; ?>
			</ul>
			<div class="pagination">
				<?php
				$big = 999999999; // need an unlikely integer

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				) );
				?>
			</div>
		</div>
	</div>
	<footer class="celebrity-bears-footer">
		<p class="text-center big">
			<?php _e("Send your celebrity bear pictures to:", 'gbteddybear'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:celebritybear@britishteddies.com" class="red-btn"><i aria-hidden="true" class="icon-camera text-middle"></i>&nbsp;&nbsp;<span class="normalcase">celebritybear@britishteddies.com</span></a>
		</p>
	</footer>
</div>


<?php get_footer(); ?>
