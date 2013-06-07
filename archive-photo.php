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
get_header(); ?>

<div id="archive-photo" class="container">
	<?php $curr_page = get_queried_page(); ?>
	<div class="content">
		<?php $id = ($curr_page) ? $curr_page->ID : null; ?>
		<?php if ( get_field('content', $id)) include(locate_template('inc/content.php')); ?>
	</div>
	<div id="photos">
		<div class="inner clearfix">
			<ul class="photo-list clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
					$image_id = get_post_thumbnail_id();
					$image = wp_get_attachment_image_src($image_id, 'full');
				?>
				<li class="item photo">
					<a href="<?php echo $image[0]; ?>" class="overlay-btn">
						<?php the_post_thumbnail('thumbnail', array('class' => 'scale')); ?>
					</a>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>
		<footer class="photos-footer">
			<p class="no-margin">
				<a href="<?php echo get_permalink(get_gbteddybear_option('submit_photo_page_id')); ?>" class="red-btn small">
					<i aria-hidden="true" class="icon-camera"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php _e("Send a photo of your GB teddy bear!", 'gbteddybear') ?>
				</a>
			</p>

			<?php
			global $wp_query;

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
			) );
			?>
		</footer>
	</div>
</div>

<?php get_footer(); ?>
