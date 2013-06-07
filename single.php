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
	<?php the_content(); ?>
</div>
<?php get_footer(); ?>

