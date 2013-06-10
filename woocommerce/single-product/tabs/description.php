<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;
$id = ($post) ? $post->ID : null;
if($post->post_content || get_field('content', $id)):
$heading = esc_html( apply_filters('woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );
?>
<div class="description">
	<header class="line-header"><h5 class="title"><?php echo $heading; ?></h5></header>
	<div class="content">
		<?php if($post->post_content): ?>
		<div class="product-content"><?php the_content(); ?></div>
		<?php endif; ?>
		<?php if ( get_field('content', $id)) :?>
		<?php include(locate_template('inc/content.php')); ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>