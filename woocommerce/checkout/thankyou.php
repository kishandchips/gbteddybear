<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( $order ) : ?>

	<?php if ( in_array( $order->status, array( 'failed' ) ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
		<div class="content">
			<div class="row">
				<h3 class="page-title brown no-margin uppercase no-margin"><?php _e( 'Order received!', 'woocommerce' ); ?></h3>
				<p><?php _e("Thank you for ordering your Great British Teddy Bear!", 'woocommerce'); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<div class="col2-set">
		<?php if ( !in_array( $order->status, array( 'failed' ) ) ) : ?>
			
		<div class="col-1">
			<div class="order-details-container">
				<header class="order-details-header">
					<h4 class="title uppercase brown"><?php _e("Your Order Details", 'woocommerce'); ?></h4>
				</header>
				<ul class="order_details order-details">
					<li class="order">
						<?php _e( 'Order:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_order_number(); ?></strong>
					</li>
					<li class="date">
						<?php _e( 'Date:', 'woocommerce' ); ?>
						<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
					</li>
					<li class="total">
						<?php _e( 'Total:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_formatted_order_total(); ?></strong>
					</li>
					<?php if ( $order->payment_method_title ) : ?>
					<li class="method">
						<?php _e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo $order->payment_method_title; ?></strong>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		
		<?php endif; ?>
		<div class="col-2">
			<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
		</div>
	</div>
<?php else : ?>

	<p><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

<?php endif; ?>