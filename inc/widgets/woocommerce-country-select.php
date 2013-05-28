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
		$customer = new WC_Customer();
		$countries = new WC_Countries();
		$curr_country = $customer->get_country();
		$curr_state = '*';
		if(isset($_POST['action']) && $_POST['action'] == 'set_country'){
			$country = (isset($_POST['country'])) ? $_POST['country'] : $curr_country;
			
			if($curr_country != $country){
				$curr_country = $country;

				$customer->set_country($curr_country);

				if(strpos($curr_country, ':') !== false){
					$curr_country_ary = explode(':', $curr_country);
					$curr_country = $curr_country_ary[0];
					if(isset($curr_country_ary[1])){
						$curr_state = $curr_country_ary[1];
					}
				}

			}
		}

		$args['title'] = $instance['title'];
		
		echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
		?>
		<form id="country-selector-form" action="" method="POST">
			<select name="country" class="center">
				<?php $countries->country_dropdown_options($curr_country, $curr_state, false); ?>
			</select>
			<input type="hidden" name="action" value="set_country">
		</form>
		<?php
		echo $args['after_widget'];
	}
}

register_widget('WooCommerce_Country_Select');



?>
