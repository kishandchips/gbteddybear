<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package gbteddybear
 * @since gbteddybear 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/images/misc/favicon.png" rel="shortcut icon" type="image/x-icon">
    
    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
    <?php

	if ( ! is_admin() ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js', false, '1.9.1');
        wp_enqueue_script('jquery');
    }
	
	function load_assets() {

		wp_enqueue_style('style', get_template_directory_uri().'/css/style.css');
		wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Crimson+Text:400,700,400italic');
		
		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/libs/modernizr.min.js');
		wp_enqueue_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/plugins/jquery.easing.js', array('jquery'), '', true);
		wp_enqueue_script('scroller', get_template_directory_uri().'/js/plugins/jquery.scroller.js', array('jquery'), '', true);
		wp_enqueue_script('actual', get_template_directory_uri().'/js/plugins/jquery.actual.js', array('jquery'), '', true);
		wp_enqueue_script('imagesloaded', get_template_directory_uri().'/js/plugins/jquery.imagesloaded.js', array('jquery'), '', true);
		wp_enqueue_script('transit', get_template_directory_uri().'/js/plugins/jquery.transit.js', array('jquery'), '', true);
		wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), '', true);
	}
	add_action('wp_enqueue_scripts', 'load_assets');
	?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" role="banner">
		<div class="inner container">
			<h1 class="logo-container">
				<a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<ul class="ecommerce-options clearfix">
				<li class="currency">
					<span class="label uppercase"><?php _e("Currency:", 'gbteddybear'); ?></span>&nbsp;&nbsp;
					<select data-icon="&#x69;">
						<option>&pound;GB</option>
						<option></option>
						<option></option>
					</select>
				</li>
				<li class="account">
					<a href="<?php echo get_permalink(get_gbteddybear_option('account_page_id')); ?>" class="white-btn" >
						<i aria-hidden="true" class="icon-person"></i>&nbsp;&nbsp;<?php echo get_the_title(get_gbteddybear_option('account_page_id')); ?>
					</a>
				</li>
				<li class="cart">
					<a href="<?php echo get_permalink(get_gbteddybear_option('cart_page_id')); ?>" class="white-btn" >
						<i aria-hidden="true" class="icon-shopping-bag"></i>&nbsp;&nbsp;<?php echo get_the_title(get_gbteddybear_option('cart_page_id')); ?>
					</a>
				</li>
			</ul>
			<div class="info">
				<h4 class="phone-number light-brown">
					<i aria-hidden="true" class="icon-phone tiny brown"></i> 08700429745
				</h4>
			</div>
			<div class="navigation-container">
				<button class="mobile-navigation-btn uppercase">menu <i aria-hidden="true" class="icon-arrow-down tiny"></i></button>
				<nav role="navigation" class="site-navigation main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary_header', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
			</div>
		</div>
	</header><!-- #header -->

	<div id="main" class="site-main" role="main">
		<div id="ajax-page"></div>