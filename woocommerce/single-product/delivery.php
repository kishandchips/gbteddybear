<?php 
	if(isset($_POST['product_calc_shipping']) && $_POST['product_calc_shipping'] == '1'){
		$country = (isset($_POST['product_calc_shipping_country'])) ? $_POST['product_calc_shipping_country'] : $curr_country;
		$woocommerce->customer->set_country($country);
		$woocommerce->customer->set_shipping_country($country);
	}
?>
<div class="delivery">

	<h5 class="uppercase">Delivery</h5>
	<div class="clearfix">
		<div class="span alpha four break-on-tablet">
			<p class="small no-margin">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu nisi, semper eget condimentum ac, faucibus quis sem. Sed viverra, nibh eget sollicitudin molestie.</p>
		</div>
		<form class="country-selector-form span four break-on-tablet alpha" action="" method="POST">
			<select name="product_calc_shipping_country" class="country">
				<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
				<?php
					foreach( $woocommerce->countries->get_allowed_countries() as $key => $value )
						echo '<option value="' . esc_attr( $key ) . '"' . selected( $woocommerce->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				?>
			</select>
			<input type="hidden" name="product_calc_shipping" value="1" />
		</form>
	</div>
</div>