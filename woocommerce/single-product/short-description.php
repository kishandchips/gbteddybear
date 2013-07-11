<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) return;
?>
<div class="tabs description-tabs" itemprop="description">
	<ul class="tab-navigation">
		<li class="current"><a data-id="tab-1"><?php _e("About this bear", 'gbteddybear'); ?></a></li>
		<?php if(get_field('tabs')): ?>
			<?php $i = 1; ?>
			<?php while (has_sub_field('tabs')) : ?>
			<li><a data-id="tab-<?php echo $i+1;?>"><?php the_sub_field('title');  ?></a></li>
			<?php $i++; ?>
			<?php endwhile; ?>
		<?php endif; ?>

	</ul>
	<div class="tab-content-container">
		<div class="fade-top"></div>
		<div class="fade-bottom"></div>
		<div class="tab-content">
			<div data-id="tab-1" class="current tab">
				<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
			</div>

			<?php if(get_field('tabs')): ?>
				<?php $i = 1; ?>
				<?php while (has_sub_field('tabs')) : ?>
					<div data-id="tab-<?php echo $i+1;?>" class="tab">
						<?php the_sub_field('content');  ?>
					</div>
				<?php $i++; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>