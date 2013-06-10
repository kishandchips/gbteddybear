<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;
?>
<ul class="thumbnails scroller-pagination">
<?php $attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	
		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array('overlay-btn' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			$image_title = esc_attr( get_the_title( $attachment_id ) );
			?>

			<li>
				<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-id="'.$attachment_id.'">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );?>
			</li>
			<?php
			$loop++;
		}
} else {

}

	$threesixty_images = get_field('360_images');
	if($threesixty_images):
	?>
	<li>
		<a href="http://localhost/gbteddybear/website/build/shop/the-veteran/" data-id="360" class="overlay-btn">
			<img src="<?php echo get_template_directory_uri(); ?>/images/misc/360_view.jpg" />
		</a>
	</li>
	<?php endif; ?>
</ul>