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
		wp_register_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.css');

		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/libs/modernizr.min.js');
		wp_enqueue_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/plugins/jquery.easing.js', array('jquery'), '', true);
		wp_enqueue_script('scroller', get_template_directory_uri().'/js/plugins/jquery.scroller.js', array('jquery'), '', true);
		wp_enqueue_script('actual', get_template_directory_uri().'/js/plugins/jquery.actual.js', array('jquery'), '', true);
		wp_enqueue_script('imagesloaded', get_template_directory_uri().'/js/plugins/jquery.imagesloaded.js', array('jquery'), '', true);
		wp_enqueue_script('transit', get_template_directory_uri().'/js/plugins/jquery.transit.js', array('jquery'), '', true);
		wp_register_script('fancybox', get_template_directory_uri().'/js/plugins/jquery.fancybox.min.js', array('jquery'), '', true);
		wp_register_script('threesixty', get_template_directory_uri().'/js/plugins/jquery.threesixty.js', array('jquery'), '', true);
		wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), '', true);

		wp_deregister_script('wc-add-to-cart-variation');
		wp_register_script( 'wc-add-to-cart-variation', get_template_directory_uri().'/js/plugins/jquery.add-to-cart-variation.js', array( 'jquery' ), '', true );
	}
	add_action('wp_enqueue_scripts', 'load_assets');
	wp_head();
?>

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
				<?php global $woocommerce_currency_converter; ?>
				<?php if(isset($woocommerce_currency_converter)): ?>
				<?php 
				$currenies = get_woocommerce_currencies();
				if(isset($_COOKIE['woocommerce_current_currency'])){
					$current_currency = $_COOKIE['woocommerce_current_currency'];
				} else {
					$current_currency = get_option( 'woocommerce_currency' );
				}
				?>
				<li class="currency">
					<span class="label uppercase"><?php _e("Currency:", 'gbteddybear'); ?></span>&nbsp;&nbsp;
					<select data-icon="&#x69;" class="currency">
						<?php foreach($currenies as $currency_code => $currency): ?>
							<option value="<?php echo $currency_code ?>" data-currencycode="<?php echo $currency_code ?>" <?php if($current_currency == $currency_code) echo 'selected'; ?>><?php echo $currency_code; ?></option>
						<?php endforeach; ?>
					</select>

					<ul class="currency_switcher hide">
						<?php foreach($currenies as $currency_code => $currency): ?>
						<?php $class = ($currency_code == $current_currency) ? 'default reset': ''; ?>
						<li>
							<a class="<?php echo $class; ?>" data-currencycode="<?php echo $currency_code; ?>"><?php echo $currency_code; ?></a>
						</li>
						<?php endforeach;?>
					</ul>
				</li>
				<?php endif; ?>
				<li class="account">
					<a href="<?php echo get_permalink(get_gbteddybear_option('account_page_id')); ?>" class="white-btn account-btn" >
						<i aria-hidden="true" class="icon-person"></i>&nbsp;&nbsp;<?php echo get_the_title(get_gbteddybear_option('account_page_id')); ?>
					</a>
				</li>
				<?php global $woocommerce; ?>
				<li class="cart">
					<a href="<?php echo get_permalink(get_gbteddybear_option('cart_page_id')); ?>" class="white-btn cart-btn" >
						<i aria-hidden="true" class="icon-shopping-bag"></i>&nbsp;&nbsp;<?php echo get_the_title(get_gbteddybear_option('cart_page_id')); ?>:
						<strong class="items"><?php echo sprintf(_n('%d Bear', '%d Bears', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></strong>
					</a>
				</li>
				<?php if ( is_user_logged_in() ): ?>
				<li class="logout">
					<a href="<?php echo wp_logout_url('/'); ?>" class="white-btn logout-btn" >
						<?php _e("Logout") ?>
					</a>
				</li>
				<?php endif; ?>
			</ul>
			<div class="info">
				<h4 class="phone-number light-brown no-margin" >
					<i aria-hidden="true" class="icon-phone tiny brown"></i> 08700 429 745
				</h4>
			</div>
			<div class="navigation-container">
				<a href="<?php echo get_permalink(get_gbteddybear_option('cart_page_id')); ?>" class="cart-btn" >
					<i aria-hidden="true" class="icon-shopping-bag"></i>&nbsp;&nbsp;<?php echo get_the_title(get_gbteddybear_option('cart_page_id')); ?>:
					<strong class="items"><?php echo sprintf(_n('%d Bear', '%d Bears', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></strong>
				</a>
				<button class="mobile-navigation-btn uppercase">menu <i aria-hidden="true" class="icon-arrow-down tiny"></i></button>
				<nav role="navigation" class="site-navigation main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary_header', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
			</div>
		</div>
	</header><!-- #header -->
	<?php if(!is_front_page()): ?>
	<?php if ( function_exists('yoast_breadcrumb') ) yoast_breadcrumb('<div id="breadcrumbs"><div class="inner container">','</div></div>'); ?>
	<?php endif; ?>
	<div id="main" class="site-main" role="main">
		<div id="ajax-page"></div>