<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */
?>
	</div><!-- #main .site-main -->
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="top">
			<div class="container inner">
				<?php dynamic_sidebar('footer'); ?>
			</div>
		</div>
		<div class="bottom">
			<div class="container inner">
				<div class="span five alpha">
					<p>&copy; <?php echo date('Y'); ?><?php _e("The Great British Teddy Bear Company&reg; all rights reserved.", 'gbteddybear'); ?></p>
				</div>
				<div class="span five omega">
					<nav role="navigation" class="footer-navigation right">
						<?php wp_nav_menu( array( 'theme_location' => 'primary_footer', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
					</nav><!-- .site-navigation .main-navigation -->
				</div>
			</div>
		</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2727159-29', 'britishteddies.com');
  ga('create', 'UA-42667418-1', 'britishteddies.com');
  ga('send', 'pageview');

</script>
<script src="//s7.addthis.com/js/300/addthis_widget.js"></script>

</body>
</html>