<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images scroller" data-resize="true">
	<div class="scroller-mask">

	
	<?php
	// if ( has_post_thumbnail() ) {

	// 	$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
	// 	$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
	// 	$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
	// 	$attachment_count   = count( $product->get_gallery_attachment_ids() );

	// 	if ( $attachment_count > 0 ) {
	// 		$gallery = '[product-gallery]';
	// 	} else {
	// 		$gallery = '';
	// 	}

	// 	echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

	// } else {

	// 	echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

	// }

	$attachment_ids = $product->get_gallery_attachment_ids();

	if ( $attachment_ids ) {
	
		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {
			$classes = array( 'woocommerce-main-image', 'zoom');

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );
			?>
			<div class="scroll-item" data-id="<?php echo $attachment_id; ?>">
			<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="%s" title="%s" rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, '', $image ), $attachment_id, $post->ID, $image_class ); ?>
			</div>
			<?php $loop++;
		}
	}
	?>
	<?php

	$threesixty_images = get_field('360_images');
	if($threesixty_images):
		wp_enqueue_script('threesixty');
	?>
		<div class="scroll-item" data-id="360">
			<ul class="threesixty">
				<?php foreach( $threesixty_images as $image ): ?>
				<li>
					<a href="<?php echo $image['sizes']['large']; ?>" class="zoom" rel="prettyPhoto">
						<img src="<?php echo $image['sizes']['shop_single']; ?>" class="scale" />
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	</div>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
