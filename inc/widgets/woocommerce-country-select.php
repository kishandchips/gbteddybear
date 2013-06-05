<?php 

class WooCommerce_Country_Select extends WP_Widget {
	
	function WooCommerce_Country_Select() {


		$widget_opts = array( 'description' => __('Use this widget is to show the country selector for WooCommerce') );
		parent::WP_Widget(false, 'WooCommerce Country Select', $widget_opts);
	}
	function form($instance) {
		
		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';  
        echo '<p><label>';
		echo _e('Title:').'<input type="text" class="widefat" name="'. $this->get_field_name('title').'" value="'. $title.'" />';
        echo '</label></p>';

	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		global $woocommerce;

		if(isset($_POST['calc_shipping']) && $_POST['calc_shipping'] == '1'){
			$country = (isset($_POST['calc_shipping_country'])) ? $_POST['calc_shipping_country'] : '';
			$woocommerce->customer->set_country($country);
			$woocommerce->customer->set_shipping_country($country);
		}
	
		$args['title'] = $instance['title'];
		
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		?>
		<form class="country-selector-form" action="" method="POST">
			<select name="calc_shipping_country" class="center country">
				<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
				<?php
					foreach( $woocommerce->countries->get_allowed_countries() as $key => $value )
						echo '<option value="' . esc_attr( $key ) . '"' . selected( $woocommerce->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				?>
			</select>
			<input type="hidden" name="calc_shipping" value="1" />
		</form>
		<?php
		echo $args['after_widget'];
	}
}

register_widget('WooCommerce_Country_Select');



?>
