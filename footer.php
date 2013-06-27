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
				<p>&copy; Copyright <?php _e("The Great British Teddy Bear Company Ltd.", 'gbteddybear'); ?>&nbsp;&nbsp;<a href="<?php echo get_permalink(get_gbteddybear_option('tnc_page_id')); ?>"><?php echo get_the_title(get_gbteddybear_option('tnc_page_id')); ?></a></p> 
			</div>
		</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

<script>

// var _gaq = _gaq || [];_gaq.push(["_setAccount", "UA-25665437-1"]);
// _gaq.push(["_trackPageview"]);
// (function() {
// 	var ga = document.createElement("script");
// 	ga.type = "text/javascript";ga.async = true;
// 	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";var s = document.getElementsByTagName("script")[0];
// 	s.parentNode.insertBefore(ga, s);
// })();
</script>
<script src="//s7.addthis.com/js/300/addthis_widget.js"></script>

</body>
</html>