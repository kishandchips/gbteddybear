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
<section id="front-page" class="clearfix">
	<?php if ( get_field('slides')) :?>
		<div id="homepage-scroller" class="scroller container" >
			<div class="outer">
				<div class="inner">
					<div class="scroller-mask">
						<?php $i = 0; ?>
						<?php while (the_repeater_field('slides')) : ?>
						<?php 
							$image_id = get_sub_field('image_id');
							$image = wp_get_attachment_image_src($image_id, 'slide');
							$background_image_id = get_sub_field('background_image_id');
							$background_image = wp_get_attachment_image_src($background_image_id, 'full');    			
						?>
						<div class="scroll-item <?php if($i == 0) echo 'current'; ?>" data-id="<?php echo $i;?>" style="background-image: url(<?php echo $image[0];?>)">
							<div class="content" style="background-image: url(<?php echo $background_image[0]; ?>);">
								<div class="inner"><?php the_sub_field('content'); ?></div>
							</div>
						</div>
						<?php $i++; ?>
						<?php endwhile; ?>
					</div>
					<div class="scroller-navigation">
						<a class="prev-btn"></a>
						<a class="next-btn"></a>
					</div>
				</div>
			</div>
		</div><!-- #homepage-scroller -->
	<?php endif; ?>

	<div id="widgets">
		<div class="container">
			<div class="inner">
				<?php dynamic_sidebar('homepage_content'); ?>
			</div>
		</div>
	</div>
	<?php if ( get_field('content')) :?>
	<div id="content">
		<div class="container">
			<?php $i = 0; ?>
			<?php while (the_flexible_field('content')) : ?>
			<?php 
				$layout = get_row_layout();
			?>
				<div class="row <?php if($i > 0) echo 'border-top';  ?>">
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
		</div>
	</div>
	<?php endif; ?>

	<?php
	$query = new WP_Query( array('post_type' => array('photo')) );
	if($query->have_posts()):
		$gallery_page_id = get_gbteddybear_option('gallery_page_id');
	?>
	<div id="photos">
		<div class="inner container">
			<header class="photos-header">
				<h5 class="title text-center light-brown uppercase"><?php echo get_the_title($gallery_page_id); ?></h5>
			</header>
			<div class="photo-list-container clearfix">
				<ul class="photo-list clearfix">
			<?php
				$i = 0;
				$half = floor($query->found_posts / 2);
				while($query->have_posts()):
					$query->the_post();
			?>
					<li class="item photo <?php if($i == $half) echo 'half'; ?>">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('thumbnail', array('class' => 'scale')); ?>
						</a>
					</li>
					<?php if($i == $half) echo '<br />'; ?>
				<?php $i++; ?>
			<?php endwhile; ?>
				</ul>
			</div>
			<footer class="photos-footer">
				<p class="text-center">
					<a href="<?php echo get_permalink($gallery_page_id); ?>" class="uppercase"><i aria-hidden="true" class="icon-camera big text-middle"></i>&nbsp;&nbsp;<?php _e("Send a photo for the gallery", 'gbteddybear') ?></a>
				</p>
				<div class="photos-navigation">
					<a class="prev-btn icon-arrow-left" data-direction="left"></a>
					<a class="next-btn icon-arrow-right" data-direction="right"></a>
				</div>
			</footer>
		</div>
	</div>
	<?php endif; ?>

</section><!-- #front-page -->

<?php get_footer(); ?>