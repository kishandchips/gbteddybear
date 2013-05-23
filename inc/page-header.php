<?php
	global $post, $parent_id, $page_id;
	if(!$page_id){
		$page_id = $post->ID;
	}

	if(!$parent_id){
		$parent_id = ($post->post_parent) ? $post->post_parent : $post->ID;
	}

	$header_image_id = (get_field('header_image_id', $parent_id)) ? get_field('header_image_id', $parent_id) : get_field('header_image_id', $page_id);
	$header_image = ($header_image_id) ? wp_get_attachment_image_src($header_image_id, 'full') : null;
	$header_color = (get_field('header_color', $parent_id)) ? get_field('header_color', $parent_id) : get_field('header_color', $page_id);
?>
<header class="page-header" style="<?php if($header_image): ?>background-image: url(<?php echo $header_image[0]; ?>);<?php endif; ?> background-color: <?php echo $header_color; ?>;">
	<h1 class="title no-margin text-center white uppercase"><?php echo get_the_title($parent_id); ?></h1>
	<nav role="navigation" class="sub-navigation">
		<div class="inner">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix', 'container' => false, 'child_of' => $parent_id) ); ?>
		</div>	
	</nav>
</header><!-- .page-header -->