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
	$attachment_ids = $product->get_gallery_attachment_ids();
	$show_thumbnail = true;
	if ( $attachment_ids ) {
		$loop = 0;
		$show_thumbnail = false;
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
			<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="%s" title="%s" rel="prettyPhoto[product-gallery]"><div class="enlarge"><i class="icon-expand"></i>zoom</div>%s</a>', $image_link, $image_class, '', $image ), $attachment_id, $post->ID, $image_class ); ?>
			</div>
			<?php $loop++;
		}
	} elseif($product->is_type('variable')){
		global $wpdb;
		$variations = $product->get_available_variations();
		$loop = 0;
		$selected_attributes = $product->get_variation_default_attributes();
		$curr_variation = null;
		if(!empty($selected_attributes)){		
			foreach($selected_attributes as $selected_attribute){
				$selected_attributes[] = $selected_attribute;
			}
			$curr_variation = $selected_attributes[0];
		}
		foreach($variations as $variation){

			if(isset($variation['image_link'])){
				
				if(!empty($variation['attributes'])){		
					foreach($variation['attributes'] as $attribute){
						$variation['attributes'][] = $attribute;
					}					
				}

				$image_url = $variation['image_link'];
				$attachment_id = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_url'");
				$classes = array( 'woocommerce-main-image', 'zoom');
				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$show_thumbnail = false;
				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );
				?>
				<div class="scroll-item <?php if($curr_variation == $variation['attributes'][0]) echo 'current'; ?>" data-id="<?php echo $variation['variation_id']; ?>">
				<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="%s" title="%s" rel="prettyPhoto[product-gallery]"><div class="enlarge"><i class="icon-expand"></i>zoom</div>%s</a>', $image_link, $image_class, '', $image ), $attachment_id, $post->ID, $image_class ); ?>
				</div>
				<?php $loop++;
			}
		}
	} 
	
	if ( has_post_thumbnail() && $show_thumbnail) {

		$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
		$attachment_count   = count( $product->get_gallery_attachment_ids() );

		if ( $attachment_count > 0 ) {
			$gallery = '[product-gallery]';
		} else {
			$gallery = '';
		}
		?>
		<div class="scroll-item current" data-id="<?php echo get_post_thumbnail_id(); ?>">
			<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '"><div class="enlarge"><i class="icon-expand"></i>zoom</div>%s</a>', $image_link, '', $image ), $post->ID ); ?>
		</div>
	<?php }

	$has_variation_images = false;
	if($product->is_type('variable')):
		$variations = $product->get_available_variations();
		$loop = 0;
		$selected_attributes = $product->get_variation_default_attributes();
		$curr_variation = null;
		if(!empty($selected_attributes)){		
			foreach($selected_attributes as $selected_attribute){
				$selected_attributes[] = $selected_attribute;
			}
			$curr_variation = $selected_attributes[0];
		}

		$i = 0;
		foreach($variations as $variation){
			$threesixty_images = get_field('360_images', $variation['variation_id']);
			if($threesixty_images){
				if($i == 0) {
					?>
					<div class="scroll-item" data-id="360">
						<a class="spin-btn"><i class="icon-spin"></i>spin</a>
					<?php
				}
				wp_enqueue_script('threesixty');
				if(!empty($variation['attributes'])){		
					foreach($variation['attributes'] as $attribute){
						$variation['attributes'][] = $attribute;
					}					
				}
				$has_variation_images = true;
				?>
				<ul class="variation-360 threesixty <?php if($curr_variation == $variation['attributes'][0]) echo 'current'; ?>" data-variation-id="<?php echo $variation['variation_id'] ?>">
					<?php $ii = 0; ?>
					<?php foreach( $threesixty_images as $image ): ?>
					<li class="<?php if($ii == 0) echo 'current'; ?>">
						<a href="<?php echo $image['sizes']['large']; ?>" class="zoom" rel="prettyPhoto">
							<div class="enlarge"><i class="icon-expand"></i>zoom</div>
							<img data-src="<?php echo $image['sizes']['shop_single']; ?>" src="<?php if($ii == 0) echo $image['sizes']['shop_single'];?>" class="scale" />
						</a>
					</li>
					<?php $ii++; ?>
					<?php endforeach; ?>
				</ul>
				
				<?php if($i == count($variations) - 1){	?>
				</div>
				<?php
				}
			}
			$i++;
		}
		?>
	<?php
	endif;

	if(!$product->is_type('variable') || !$has_variation_images):
		$threesixty_images = get_field('360_images');
		if($threesixty_images):
			wp_enqueue_script('threesixty');
		?>
			<div class="scroll-item" data-id="360">
				<a class="spin-btn"><i class="icon-spin"></i>spin</a>
				<ul class="threesixty">
					<?php $i = 0; ?>
					<?php foreach( $threesixty_images as $image ): ?>
					<li class="<?php if($i == 0) echo 'current'; ?>">
						<a href="<?php echo $image['sizes']['large']; ?>" class="zoom" rel="prettyPhoto">
							<div class="enlarge"><i class="icon-expand"></i>zoom</div>
							<img data-src="<?php echo $image['sizes']['shop_single']; ?>" src="<?php if($i == 0) echo $image['sizes']['shop_single'];?>" class="scale" />
						</a>
					</li>
					<?php $i++; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	</div>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
