<?php
/**
 * Additional Information tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post, $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'woocommerce' ) );
?>
<div class="additional-information">
	<header class="line-header"><h5 class="title"><?php echo $heading; ?></h5></header>
	<?php $product->list_attributes(); ?>
</div>