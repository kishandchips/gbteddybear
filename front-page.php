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
	<div class="inner container">
		<?php if ( get_field('slides')) :?>
		<div id="homepage-scroller" class="scroller shadow" data-auto-scroll="true">
			<div class="scroller-mask">
				<?php $i = 0; ?>
				<?php while (the_repeater_field('slides')) : ?>
				<?php 
					$image_id = get_sub_field('image_id');
					$image = wp_get_attachment_image_src($image_id, 'slide');    			
				?>
				<div class="scroll-item <?php if($i == 0) echo 'current'; ?>" data-id="<?php echo $i;?>" style="background-image: url(<?php echo $image[0];?>)"></div>
				<?php $i++; ?>
				<?php endwhile; ?>
			</div>
			<div class="scroller-navigation">
				<a class="prev-btn"></a>
				<a class="next-btn"></a>
			</div>
		</div><!-- #homepage-scroller -->
		<?php endif; ?>

		<div id="content" >

			<?php if ( get_field('boxes')) :?>
				<div class="boxes">
					<?php while (the_repeater_field('boxes')) : ?>
					<div class="box span third shadow">
						<?php $url = get_sub_field('url'); ?>
						<?php if($url): ?>
						<a href="<?php echo $url; ?>">
						<?php endif; ?>
							<?php 
								$image_id = get_sub_field('image_id');
								$image = wp_get_attachment_image_src($image_id, 'thumbnail');   
							?>
							<?php if(get_sub_field('content')): ?>
							<div class="content">
								<div class="inner"><?php the_sub_field('content'); ?></div>
							</div>
							<?php endif; ?>
							<div class="thumbnail">
								<img src="<?php echo $image[0]; ?>" class="scale" />
							</div>
							<div class="box-meta">
								<h4 class="title no-margin uppercase green"><?php the_sub_field('title'); ?></h4>
								<p class="no-margin"><?php the_sub_field('sub_title'); ?>
							</div>
						<?php if($url): ?>
						</a>
						<?php endif; ?>
					</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div><!-- #content -->
	</div>
</section><!-- #front-page -->

<?php get_footer(); ?>