<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */

get_header(); ?>

<section id="error">
	<div class="row">
		<div class="container">
			<div id="content" class="span four push-six">
				<div class="inner">
					<h4 class="uppercase red"><?php _e("404 error - Page not found", 'gbteddybear'); ?></h4>
					<h2 class="uppercase"><?php _e("You appear to have taken a wrong turn...", 'gbteddybear'); ?></h2>
					<p><?php _e("The page you are looking for is not here. It may have been deleted, or the address might have been miss-typed. Either way, let’s get you back on track...", 'gbteddybear'); ?></p>
					<p><?php _e("You can use the navigation bar above, or:", 'gbteddybear'); ?><br />
						<a class="grey-btn" href="<?php bloginfo('url') ?>"><?php _e("Go to the Homepage", 'gbteddybear'); ?> </a>
					</p>

				</div>
			</div><!-- #content .site-content -->
		</div>
	</div>
</section><!-- #error -->
<?php get_footer(); ?>