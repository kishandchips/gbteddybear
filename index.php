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
global $parent_id;
$parent_id = 32;
get_header(); ?>

<div id="index" class="container">
	<header class="row index-header">
		<div class="inner clearfix">
			<h3></h3>
		</div>
	</header>
	<div id="posts">
		<?php $i = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="post row">
				<div class="inner clearfix">
					<div class="break-on-mobile span three column-one image">
						<div class="thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('thumbnail', array('class' => 'scale')); ?>
							</a>
						</div>
					</div>
					<div class="break-on-mobile span six column-two content">
						<header class="post-header">
							<h3 class="title uppercase no-margin"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
							<p class="roboto-bold no-margin uppercase"><?php the_date(); ?></p>
						</header>
						<div class="excerpt">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php $i++; ?>
		<?php endwhile; ?>
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
	</div>
</div>

<?php get_footer(); ?>
