<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */

get_header(); ?>

<div id="page" class="container">
	<?php while ( have_posts() ) : the_post(); ?>
	<div id="content" <?php post_class(); ?>>
		
		<?php if ( get_field('content')) :?>
			<?php $i = 0; ?>
			<?php while (the_flexible_field('content')) : ?>
			<?php 
				$layout = get_row_layout();
			?>
				<div class="row">
					<div class="inner clearfix">
					<?php if($layout == 'one_column'): ?>
						<div class="break-on-mobile span ten omega" style="<?php the_sub_field('css_column_one'); ?>">
							<?php the_sub_field('content_column_one'); ?>
						</div>
					<?php endif; ?>
					<?php if($layout == 'two_columns'): ?>
						<div class="break-on-mobile span five column-one" style="<?php the_sub_field('css_column_one'); ?>">
							<?php the_sub_field('content_column_one'); ?>
						</div>
						<div class="break-on-mobile span five column-two" style="<?php the_sub_field('css_column_two'); ?>">
							<?php the_sub_field('content_column_two'); ?>
						</div>
					<?php endif; ?>
					<?php if($layout == 'three_columns'): ?>
						<div class="break-on-mobile span one-third column-one" style="<?php the_sub_field('css_column_one'); ?>">
							<?php the_sub_field('content_column_one'); ?>
						</div>
						<div class="break-on-mobile span one-third column-two " style="<?php the_sub_field('css_column_two'); ?>">
							<?php the_sub_field('content_column_two'); ?>
						</div>
						<div class="break-on-mobile span one-third column-three" style="<?php the_sub_field('css_column_three'); ?>">
							<?php the_sub_field('content_column_three'); ?>
						</div>
					<?php endif; ?>
					</div>
				</div>
			<?php $i++; ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php if(!$post->post_content == ''): ?>
		<div class="page-content">
			<?php the_content(); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endwhile; // end of the loop. ?>

</div><!-- #page -->
<?php get_footer(); ?>