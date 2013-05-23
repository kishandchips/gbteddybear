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
			<div class="container">
				<div class="alpha span seven break-on-tablet">
					<div class="newsletter">
						<?php gravity_form(2); ?>
					</div>
					<nav role="navigation" class="site-navigation main-navigation">
						<h6 class="uppercase light-grey"><?php _e("Quick Links", 'gbteddybear'); ?></h6>
						<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'clearfix', 'container' => false ) ); ?>
					</nav>
				</div>
				<div class="omega alpha three span break-on-tablet">
					<h6 class="uppercase light-grey"><?php _e("Get Tickets", 'gbteddybear'); ?></h6>
					<h4 class="uppercase"><a href="<?php echo get_permalink(get_gbteddybear_option('tickets_page_id')); ?>" class="green"><?php echo get_the_title(get_gbteddybear_option('tickets_page_id')) ?></a></h4>
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style ">
						<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
						<a class="addthis_button_tweet"></a>
						<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
					</div>
					<!-- AddThis Button END -->
				</div>
			</div>
		</div>

		 <div class="bottom">
			<div class="inner container">
				<div class="span six alpha break-on-mobile">
					<p clas="no-margin">&copy; <?php bloginfo( 'name' ); ?> <?php echo date('Y'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo get_permalink(get_gbteddybear_option('tnc_page_id')); ?>"><?php echo get_the_title(get_gbteddybear_option('tnc_page_id')) ?></a></p>
				</div>
				<div class="span four omega break-on-mobile">
					<p clas="no-margin small italic"><?php _e("Subject to contracting, licensing and planning permissions", 'gbteddybear'); ?></p>
				</div>
			</div>
		</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
// var _gaq = _gaq || [];_gaq.push(["_setAccount", "UA-3620331-1"]);
// _gaq.push(["_trackPageview"]);
// (function() {
// 	var ga = document.createElement("script");
// 	ga.type = "text/javascript";ga.async = true;
// 	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";var s = document.getElementsByTagName("script")[0];
// 	s.parentNode.insertBefore(ga, s);
// })();
--><!]]>
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>

</body>
</html>