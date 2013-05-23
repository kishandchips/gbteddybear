<?php
/**
 * The template for displaying the single.
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


<div id="single" class="container">
	<div class="content-area clearfix">
		<div id="posts" class="span seven">
			<?php $i = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="post row <?php echo 'border-top';  ?>">
					<header class="post-header">
						<h3 class="title uppercase no-margin"><?php the_title() ?></h3>
						<p class="roboto-bold no-margin uppercase"><?php the_date(); ?></p>
						<?php the_post_thumbnail('large', array('class' => 'scale')); ?>
					</header>
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
			<?php $i++; ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

